<?php

namespace App\Api;

use App\Server\Controller;
use App\Src\Models\User;
use App\Src\Models\Wallet;
use App\Src\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialUser;
use Throwable;

class AuthController extends Controller
{
    /* ---------- Email / password ---------- */

    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:80'],
            'email'        => ['required', 'email', 'max:160', 'unique:member,email'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'password'     => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'display_name'    => $data['display_name'],
                'email'           => $data['email'],
                'phone'           => $data['phone'] ?? null,
                'password'        => Hash::make($data['password']),
                'login_provider'  => 'email',
            ]);
            $this->ensureWallet($user);
            return $user->refresh();
        });

        return $this->tokenResponse($user, deviceName: $request->input('device_name'), status: 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required'],
            'device_name' => ['nullable', 'string', 'max:80'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! $user->password || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['อีเมลหรือรหัสผ่านไม่ถูกต้อง'],
            ]);
        }

        if ($user->status === 'suspended') {
            throw ValidationException::withMessages([
                'email' => ['บัญชีนี้ถูกระงับการใช้งาน'],
            ]);
        }

        $this->ensureWallet($user);

        return $this->tokenResponse($user, deviceName: $credentials['device_name'] ?? null);
    }

    /* ---------- Social OAuth — server-side redirect flow ---------- */

    public function redirectToProvider(string $provider): JsonResponse
    {
        $this->assertProvider($provider);

        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json(['redirect_url' => $url]);
    }

    public function handleProviderCallback(string $provider, Request $request): JsonResponse
    {
        $this->assertProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'ไม่สามารถยืนยันตัวตนกับ '.strtoupper($provider).' ได้',
                'error'   => $e->getMessage(),
            ], 422);
        }

        $user = $this->upsertSocialUser($provider, $socialUser);

        return $this->tokenResponse($user, deviceName: $request->input('device_name'));
    }

    /* ---------- Social OAuth — token flow for mobile / SPA ---------- */

    public function loginWithProviderToken(string $provider, Request $request): JsonResponse
    {
        $this->assertProvider($provider);

        $request->validate([
            'access_token' => ['required', 'string'],
            'device_name'  => ['nullable', 'string', 'max:80'],
        ]);

        try {
            $socialUser = Socialite::driver($provider)->userFromToken($request->string('access_token'));
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'access_token ไม่ถูกต้อง',
                'error'   => $e->getMessage(),
            ], 422);
        }

        $user = $this->upsertSocialUser($provider, $socialUser);

        return $this->tokenResponse($user, deviceName: $request->input('device_name'));
    }

    /* ---------- Authenticated ---------- */

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'ออกจากระบบเรียบร้อย']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($request->user()->loadMissing('wallet')),
        ]);
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

            return $user;
        });
    }

    private function ensureWallet(User $user): void
    {
        Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0, 'locked_balance' => 0],
        );
    }

    private function tokenResponse(User $user, ?string $deviceName = null, int $status = 200): JsonResponse
    {
        $deviceName = $deviceName ?: 'api-'.Str::lower(Str::random(8));

        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'token'      => $token,
            'token_type' => 'Bearer',
            'user'       => new UserResource($user->loadMissing('wallet')),
        ], $status);
    }
}
