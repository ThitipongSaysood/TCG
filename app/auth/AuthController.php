<?php

namespace App\Auth;

use App\Server\Controller;
use App\Src\Models\User;
use App\Src\Models\Wallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialUser;
use Throwable;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'])->onlyInput('email');
        }

        $request->session()->regenerate();
        $this->ensureWallet(Auth::user());
        return redirect()->intended(route('home'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:80'],
            'email'        => ['required', 'email', 'max:160', 'unique:member,email'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'password'     => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'display_name'   => $data['display_name'],
                'email'          => $data['email'],
                'phone'          => $data['phone'] ?? null,
                'password'       => Hash::make($data['password']),
                'login_provider' => 'email',
            ]);
            $this->ensureWallet($user);
            return $user->refresh();
        });

        Auth::login($user);
        return redirect()->route('home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    /* ---------- Social OAuth (LINE / Google) ---------- */

    public function redirectToProvider(string $provider): RedirectResponse
    {
        $this->assertProvider($provider);
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider, Request $request): RedirectResponse
    {
        $this->assertProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'เข้าสู่ระบบด้วย '.strtoupper($provider).' ไม่สำเร็จ',
            ]);
        }

        $user = $this->upsertSocialUser($provider, $socialUser);
        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    /* ---------- Helpers ---------- */

    private function assertProvider(string $provider): void
    {
        if (! in_array($provider, ['line', 'google'], strict: true)) {
            abort(404);
        }
    }

    private function upsertSocialUser(string $provider, SocialUser $socialUser): User
    {
        return DB::transaction(function () use ($provider, $socialUser) {
            $providerUid = (string) $socialUser->getId();
            $email       = $socialUser->getEmail();

            $user = User::where('login_provider', $provider)
                ->where('provider_uid', $providerUid)
                ->first();

            if (! $user && $email) {
                $user = User::where('email', $email)->first();
                if ($user) {
                    $user->update([
                        'login_provider' => $provider,
                        'provider_uid'   => $providerUid,
                        'avatar_url'     => $user->avatar_url ?: $socialUser->getAvatar(),
                    ]);
                }
            }

            if (! $user) {
                $user = User::create([
                    'display_name'   => $socialUser->getName() ?: $socialUser->getNickname() ?: 'CardZone User',
                    'email'          => $email,
                    'login_provider' => $provider,
                    'provider_uid'   => $providerUid,
                    'avatar_url'     => $socialUser->getAvatar(),
                    'password'       => null,
                ]);
            }

            $this->ensureWallet($user);
            return $user->refresh();
        });
    }

    private function ensureWallet(User $user): void
    {
        Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0, 'locked_balance' => 0],
        );
    }
}
