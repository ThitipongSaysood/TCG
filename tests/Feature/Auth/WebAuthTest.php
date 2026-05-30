<?php

namespace Tests\Feature\Auth;

use App\Src\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WebAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('เข้าสู่ระบบ')
            ->assertSee('LINE')
            ->assertSee('Google')
            ->assertDontSee('Facebook');
    }

    public function test_register_creates_user_and_wallet_and_logs_in(): void
    {
        $response = $this->post('/register', [
            'display_name'          => 'Web Tester',
            'email'                 => 'web@example.com',
            'phone'                 => '0811111111',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('member', ['email' => 'web@example.com', 'login_provider' => 'email']);
        $this->assertDatabaseHas('wallets', ['user_id' => 1]);
    }

    public function test_login_with_valid_credentials_redirects_home(): void
    {
        User::create([
            'display_name' => 'Login',
            'email'        => 'login@example.com',
            'password'     => Hash::make('Password123!'),
        ]);

        $this->post('/login', [
            'email'    => 'login@example.com',
            'password' => 'Password123!',
        ])->assertRedirect('/');

        $this->assertAuthenticated();
    }

    public function test_login_with_wrong_password_returns_error(): void
    {
        User::create([
            'display_name' => 'X',
            'email'        => 'wrong@example.com',
            'password'     => Hash::make('Password123!'),
        ]);

        $this->from('/login')->post('/login', [
            'email'    => 'wrong@example.com',
            'password' => 'WRONG',
        ])->assertRedirect('/login')
          ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_logout_clears_session(): void
    {
        $user = User::create([
            'display_name' => 'Out',
            'email'        => 'out@example.com',
            'password'     => Hash::make('Password123!'),
        ]);

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    /* ---------- Social OAuth (LINE / Google) ---------- */

    public function test_line_redirect_sends_to_line_authorize(): void
    {
        config([
            'services.line.client_id'     => 'fake-id',
            'services.line.client_secret' => 'fake-secret',
            'services.line.redirect'      => 'http://localhost/login/line/callback',
        ]);

        $response = $this->get('/login/line/redirect');

        $response->assertRedirect();
        $this->assertStringContainsString('access.line.me', $response->headers->get('Location'));
    }

    public function test_google_redirect_sends_to_google_authorize(): void
    {
        config([
            'services.google.client_id'     => 'fake-id',
            'services.google.client_secret' => 'fake-secret',
            'services.google.redirect'      => 'http://localhost/login/google/callback',
        ]);

        $response = $this->get('/login/google/redirect');

        $response->assertRedirect();
        $this->assertStringContainsString('accounts.google.com', $response->headers->get('Location'));
    }

    public function test_invalid_provider_returns_404(): void
    {
        $this->get('/login/facebook/redirect')->assertStatus(404);
        $this->get('/login/twitter/redirect')->assertStatus(404);
    }
}
