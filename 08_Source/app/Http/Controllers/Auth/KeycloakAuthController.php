<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class KeycloakAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        if (! $this->oidcConfigured()) {
            return redirect()->route('login')->withErrors([
                'login' => 'Login kampus belum dikonfigurasi untuk lingkungan lokal.',
            ]);
        }

        return Socialite::driver('oidc_keycloak')
            ->scopes(['openid', 'email', 'profile'])
            ->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $identity = Socialite::driver('oidc_keycloak')->user();
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('login')->withErrors([
                'login' => 'Login tidak berhasil. Coba lagi.',
            ]);
        }

        $email = strtolower(trim((string) $identity->getEmail()));
        $claims = $identity->getRaw();

        if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false || ($claims['email_verified'] ?? false) !== true) {
            return redirect()->route('login')->withErrors([
                'login' => 'Akun Keycloak tidak memberikan alamat email terverifikasi.',
            ]);
        }

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->where('account_status', 'ACTIVE')
            ->first();

        if (! $user || ! in_array($user->role, ['STUDENT', 'ADMIN'], true)) {
            return redirect()->route('login')->withErrors([
                'login' => 'Akun ini belum memiliki akses aktif ke SewaKampus.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->forget('url.intended');

        $tokens = $identity->accessTokenResponseBody ?? [];
        if (is_string($tokens['id_token'] ?? null)) {
            $request->session()->put('oidc.id_token', Crypt::encryptString($tokens['id_token']));
        }
        if (is_string($identity->refreshToken ?? null)) {
            $request->session()->put('oidc.refresh_token', Crypt::encryptString($identity->refreshToken));
        }

        return redirect()->route($user->role === 'ADMIN' ? 'admin.dashboard' : 'student.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $idToken = $this->decryptSessionToken($request->session()->pull('oidc.id_token'));
        $refreshToken = $this->decryptSessionToken($request->session()->pull('oidc.refresh_token'));

        if ($refreshToken && $this->oidcConfigured()) {
            try {
                Socialite::driver('oidc_keycloak')->revoke($refreshToken, 'refresh_token');
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($idToken && $this->oidcConfigured()) {
            try {
                return Socialite::driver('oidc_keycloak')->logout(
                    $idToken,
                    route('auth.keycloak.logout.callback'),
                );
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        return redirect()->route('login')->with('status', 'Anda telah keluar.');
    }

    public function logoutCallback(Request $request): RedirectResponse
    {
        if (! Socialite::driver('oidc_keycloak')->validateLogoutState($request)) {
            abort(403);
        }

        return redirect()->route('login')->with('status', 'Anda telah keluar.');
    }

    private function oidcConfigured(): bool
    {
        $connection = config('oidc.connections.keycloak', []);

        return filled($connection['client_id'] ?? null)
            && filled($connection['client_secret'] ?? null)
            && filled($connection['server_url'] ?? null)
            && filled($connection['realm'] ?? null)
            && filled($connection['redirect'] ?? null);
    }

    private function decryptSessionToken(mixed $token): ?string
    {
        if (! is_string($token) || $token === '') {
            return null;
        }

        try {
            return Crypt::decryptString($token);
        } catch (Throwable $exception) {
            report($exception);

            return null;
        }
    }
}
