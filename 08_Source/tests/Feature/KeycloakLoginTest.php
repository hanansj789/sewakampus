<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use SocialiteProviders\Manager\OAuth2\User as OidcUser;
use SocialiteProviders\OpenIDConnect\Provider as OidcProvider;
use Tests\TestCase;

class KeycloakLoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_redirects_to_the_keycloak_oidc_driver(): void
    {
        config($this->oidcConfig());
        $provider = Mockery::mock(OidcProvider::class);
        $provider->shouldReceive('scopes')->once()->with(['openid', 'email', 'profile'])->andReturnSelf();
        $provider->shouldReceive('with')->once()->with(['ui_locales' => 'id'])->andReturnSelf();
        $provider->shouldReceive('redirect')->once()->andReturn(redirect('https://id.test/authorize'));
        Socialite::shouldReceive('driver')->once()->with('oidc_keycloak')->andReturn($provider);

        $this->get('/auth/keycloak/redirect')->assertRedirect('https://id.test/authorize');
    }

    public function test_callback_authenticates_an_active_user_with_verified_email(): void
    {
        $localUser = User::query()->where('email', 'hanan.rizqullah@student.unja.ac.id')->firstOrFail();
        $before = $this->app['session.store']->getId();
        $this->mockKeycloakUser($localUser->email, true);

        $response = $this->get('/auth/keycloak/callback');

        $response->assertRedirect('/student/dashboard');
        $this->assertAuthenticatedAs($localUser);
        $this->assertNotSame($before, $this->app['session.store']->getId());
    }

    public function test_callback_rejects_an_unknown_email(): void
    {
        $this->mockKeycloakUser('nobody@sewakampus.test', true);

        $this->get('/auth/keycloak/callback')
            ->assertRedirect('/login')
            ->assertSessionHasErrors('login');

        $this->assertGuest();
    }

    public function test_callback_rejects_an_unverified_email(): void
    {
        $this->mockKeycloakUser('hanan.rizqullah@student.unja.ac.id', false);

        $this->get('/auth/keycloak/callback')
            ->assertRedirect('/login')
            ->assertSessionHasErrors('login');

        $this->assertGuest();
    }

    public function test_callback_rejects_a_non_active_local_account(): void
    {
        $localUser = User::query()->where('email', 'hanan.rizqullah@student.unja.ac.id')->firstOrFail();
        $localUser->account_status = 'SUSPENDED';
        $localUser->save();
        $this->mockKeycloakUser($localUser->email, true);

        $this->get('/auth/keycloak/callback')
            ->assertRedirect('/login')
            ->assertSessionHasErrors('login');

        $this->assertGuest();
    }

    public function test_logout_clears_the_local_session(): void
    {
        $user = User::query()->where('email', 'hanan.rizqullah@student.unja.ac.id')->firstOrFail();
        config($this->oidcConfig());
        $provider = Mockery::mock(OidcProvider::class);
        $provider->shouldReceive('revoke')->once()->with('refresh-token', 'refresh_token')->andReturn(true);
        $provider->shouldReceive('logout')->once()->with('id-token', route('auth.keycloak.logout.callback'))
            ->andReturn(redirect('https://id.test/logout'));
        Socialite::shouldReceive('driver')->twice()->with('oidc_keycloak')->andReturn($provider);

        $this->withSession([
            'oidc.id_token' => Crypt::encryptString('id-token'),
            'oidc.refresh_token' => Crypt::encryptString('refresh-token'),
        ])->actingAs($user)->post('/logout')->assertRedirect('https://id.test/logout');

        $this->assertGuest();
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_callback_rejects_an_invalid_oidc_state(): void
    {
        $provider = Mockery::mock(OidcProvider::class);
        $provider->shouldReceive('user')->once()->andThrow(new \InvalidArgumentException('Callback: invalid state.'));
        Socialite::shouldReceive('driver')->once()->with('oidc_keycloak')->andReturn($provider);

        $this->get('/auth/keycloak/callback')
            ->assertRedirect('/login')
            ->assertSessionHasErrors('login');

        $this->assertGuest();
    }

    public function test_login_redirect_fails_closed_when_oidc_is_not_configured(): void
    {
        config(['oidc.connections.keycloak.client_id' => null]);

        $this->get('/auth/keycloak/redirect')
            ->assertRedirect('/login')
            ->assertSessionHasErrors('login');
    }

    public function test_logout_callback_rejects_an_invalid_oidc_logout_state(): void
    {
        config($this->oidcConfig());
        $provider = Mockery::mock(OidcProvider::class);
        $provider->shouldReceive('validateLogoutState')->once()->andReturn(false);
        Socialite::shouldReceive('driver')->once()->with('oidc_keycloak')->andReturn($provider);

        $this->get('/logout/callback')->assertForbidden();
    }

    public function test_logout_callback_returns_to_login_after_valid_oidc_state(): void
    {
        config($this->oidcConfig());
        $provider = Mockery::mock(OidcProvider::class);
        $provider->shouldReceive('validateLogoutState')->once()->andReturn(true);
        Socialite::shouldReceive('driver')->once()->with('oidc_keycloak')->andReturn($provider);

        $this->get('/logout/callback')->assertRedirect('/login')->assertSessionHas('status');
    }

    private function mockKeycloakUser(string $email, bool $verified): void
    {
        $claims = [
            'sub' => 'keycloak-test-subject',
            'email' => $email,
            'email_verified' => $verified,
        ];
        $identity = (new OidcUser())
            ->setRaw($claims)
            ->map(['id' => $claims['sub'], 'email' => $email, 'name' => 'Test User'])
            ->setToken('access-token')
            ->setRefreshToken('refresh-token')
            ->setExpiresIn(300)
            ->setApprovedScopes(['openid', 'email', 'profile'])
            ->setAccessTokenResponseBody(['id_token' => 'id-token', 'refresh_token' => 'refresh-token']);

        $provider = Mockery::mock(OidcProvider::class);
        $provider->shouldReceive('user')->once()->andReturn($identity);

        Socialite::shouldReceive('driver')->once()->with('oidc_keycloak')->andReturn($provider);
    }

    private function oidcConfig(): array
    {
        return [
            'oidc.connections.keycloak.client_id' => 'sewakampus-local',
            'oidc.connections.keycloak.client_secret' => 'test-client-secret',
            'oidc.connections.keycloak.server_url' => 'http://127.0.0.1:8080',
            'oidc.connections.keycloak.realm' => 'sewakampus',
            'oidc.connections.keycloak.redirect' => 'http://127.0.0.1:8000/auth/keycloak/callback',
        ];
    }
}
