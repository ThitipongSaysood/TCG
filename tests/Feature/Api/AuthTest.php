<?php

namespace Tests\Feature\Api;

use App\Src\Models\User;
use App\Src\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /* ---------- register ---------- */

    public function test_register_creates_user_with_wallet_and_returns_token(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'display_name'          => 'Panya',
            'email'                 => 'panya@example.com',
            'phone'                 => '0811111111',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'token',
                'token_type',
                'user' => ['id', 'display_name', 'email', 'membership_tier', 'role', 'status', 'wallet' => ['balance', 'locked_balance']],
            ])
            ->assertJsonPath('user.email', 'panya@example.com')
            ->assertJsonPath('user.login_provider', 'email')
            ->assertJsonPath('user.membership_tier', 'bronze')
            ->assertJsonPath('user.role', 'member')
            ->assertJsonPath('user.status', 'active')
            ->assertJsonPath('user.wallet.balance', 0)
            ->assertJsonPath('token_type', 'Bearer');

        $this->assertDatabaseHas('member', ['email' => 'panya@example.com']);
        $this->assertDatabaseHas('wallets', ['user_id' => 1, 'balance' => 0]);
    }

    public function test_register_rejects_duplicate_email(): void
    {
        User::create([
            'display_name' => 'Existing',
            'email'        => 'dupe@example.com',
            'password'     => Hash::make('Password123!'),
        ]);

        $response = $this->postJson('/api/auth/register', [
            'display_name'          => 'New',
            'email'                 => 'dupe@example.com',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    public function test_register_validates_password_minimum_length(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'display_name'          => 'X',
            'email'                 => 'short@example.com',
            'password'              => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['password']);
    }

    public function test_register_requires_password_confirmation_to_match(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'display_name'          => 'X',
            'email'                 => 'mismatch@example.com',
            'password'              => 'Password123!',
            'password_confirmation' => 'Different456!',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['password']);
    }

    /* ---------- login ---------- */

    public function test_login_returns_token_with_valid_credentials(): void
    {
        User::create([
            'display_name' => 'Login Tester',
            'email'        => 'login@example.com',
            'password'     => Hash::make('Password123!'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'login@example.com',
            'password' => 'Password123!',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['token', 'token_type', 'user'])
            ->assertJsonPath('user.email', 'login@example.com');
    }

    public function test_login_auto_creates_wallet_if_missing(): void
    {
        User::create([
            'display_name' => 'NoWallet',
            'email'        => 'nowallet@example.com',
            'password'     => Hash::make('Password123!'),
        ]);

        $this->assertDatabaseCount('wallets', 0);

        $this->postJson('/api/auth/login', [
            'email'    => 'nowallet@example.com',
            'password' => 'Password123!',
        ])->assertOk();

        $this->assertDatabaseCount('wallets', 1);
    }

    public function test_login_rejects_invalid_password(): void
    {
        User::create([
            'display_name' => 'X',
            'email'        => 'wrong@example.com',
            'password'     => Hash::make('Password123!'),
        ]);

        $this->postJson('/api/auth/login', [
            'email'    => 'wrong@example.com',
            'password' => 'WrongPassword',
        ])->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    public function test_login_rejects_unknown_email(): void
    {
        $this->postJson('/api/auth/login', [
            'email'    => 'ghost@example.com',
            'password' => 'Password123!',
        ])->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    public function test_login_rejects_suspended_account(): void
    {
        $user = User::create([
            'display_name' => 'Banned',
            'email'        => 'banned@example.com',
            'password'     => Hash::make('Password123!'),
        ]);
        $user->update(['status' => 'suspended']);

        $this->postJson('/api/auth/login', [
            'email'    => 'banned@example.com',
            'password' => 'Password123!',
        ])->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    public function test_login_rejects_social_account_without_password(): void
    {
        // User logged in via LINE — no password set
        User::create([
            'display_name'   => 'LINE User',
            'email'          => 'line@example.com',
            'login_provider' => 'line',
            'provider_uid'   => 'U-line-123',
            'password'       => null,
        ]);

        $this->postJson('/api/auth/login', [
            'email'    => 'line@example.com',
            'password' => 'AnyPassword',
        ])->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    /* ---------- me ---------- */

    public function test_me_returns_authenticated_user(): void
    {
        $user = User::create([
            'display_name' => 'Me',
            'email'        => 'me@example.com',
            'password'     => Hash::make('Password123!'),
        ]);
        Wallet::create(['user_id' => $user->id, 'balance' => 250, 'locked_balance' => 50]);

        Sanctum::actingAs($user);

        $this->getJson('/api/auth/me')
            ->assertOk()
            ->assertJsonPath('user.email', 'me@example.com')
            ->assertJsonPath('user.wallet.balance', 250)
            ->assertJsonPath('user.wallet.locked_balance', 50);
    }

    public function test_me_requires_authentication(): void
    {
        $this->getJson('/api/auth/me')->assertStatus(401);
    }

    /* ---------- logout ---------- */

    public function test_logout_revokes_current_token(): void
    {
        $user  = User::create([
            'display_name' => 'Logout',
            'email'        => 'logout@example.com',
            'password'     => Hash::make('Password123!'),
        ]);
        $token = $user->createToken('test-device')->plainTextToken;

        $this->assertDatabaseCount('personal_access_tokens', 1);

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/auth/logout')
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseCount('personal_access_tokens', 0);

        $this->app['auth']->forgetGuards();
        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/auth/me')
            ->assertStatus(401);
    }

    public function test_logout_requires_authentication(): void
    {
        $this->postJson('/api/auth/logout')->assertStatus(401);
    }

    /* ---------- social OAuth (redirect URL only — no real LINE/Google round-trip) ---------- */

    public function test_social_redirect_returns_line_authorize_url(): void
    {
        config([
            'services.line.client_id'     => 'fake-client-id',
            'services.line.client_secret' => 'fake-secret',
            'services.line.redirect'      => 'http://localhost/api/auth/line/callback',
        ]);

        $response = $this->getJson('/api/auth/line/redirect');

        $response->assertOk()->assertJsonStructure(['redirect_url']);
        $this->assertStringContainsString('access.line.me', $response->json('redirect_url'));
    }

    public function test_social_redirect_returns_google_authorize_url(): void
    {
        config([
            'services.google.client_id'     => 'fake-client-id',
            'services.google.client_secret' => 'fake-secret',
            'services.google.redirect'      => 'http://localhost/api/auth/google/callback',
        ]);

        $response = $this->getJson('/api/auth/google/redirect');

        $response->assertOk()->assertJsonStructure(['redirect_url']);
        $this->assertStringContainsString('accounts.google.com', $response->json('redirect_url'));
    }

    public function test_social_rejects_invalid_provider(): void
    {
        $this->getJson('/api/auth/facebook/redirect')->assertStatus(404);
        $this->getJson('/api/auth/twitter/redirect')->assertStatus(404);
    }
}
