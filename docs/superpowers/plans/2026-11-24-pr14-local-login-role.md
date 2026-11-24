# PR14-06/07 Local Login and Role Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Run the local SewaKampus Laravel app with Keycloak OIDC login, database-backed STUDENT/ADMIN roles, and verified setup instructions.

**Architecture:** Laravel 11 is the BFF and holds the authenticated session in an HttpOnly cookie. Keycloak 26 authenticates users using OIDC Authorization Code + PKCE through SocialiteProviders' generic OpenID Connect driver; Laravel maps the verified email to an existing ACTIVE row in MySQL `users`, and authorizes routes using the database `role`. This scaffold implements no Must product workflow.

**Tech Stack:** PHP 8.3+, Laravel 11, MySQL 8.0, Keycloak 26, Laravel Socialite, SocialiteProviders OpenID Connect, Blade, PHPUnit.

**Spec:** `07_Evidence/P14-Test-Cases.md` (auth/role prerequisites), `03_Application/P13-App-Structure.md` §3, §6, §8; project-root `TRD.md` §1, §5; project-root `DECISIONS.md` SK-004, SK-005, SK-020; `06_Governance/CHANGE-REQUEST-LOG.md` CR-003.

## Global Constraints

- Five Must remain unchanged; this work is login + role scaffold only.
- Use the existing MySQL 8.0 schema and seeded users; do not create a second users table.
- Keycloak is the identity provider; password authentication must not happen in Laravel.
- Only an existing `users` row with `account_status = ACTIVE` may create a Laravel session.
- Role is read from the existing `users.role` (`STUDENT` or `ADMIN`); never trust a submitted role or client-side claim for authorization.
- Session ID must be regenerated after login and invalidated on logout; unauthenticated routes redirect to login, wrong-role routes return 403.
- No `.env`, client secret, token, or test credential may be committed.
- CR-003/SK-020 authorizes this local auth scaffold before lecturer Gate 1 evaluation; it does not authorize implementing any Must flow or changing Gate 1 status.
- Feature work happens on `feature/pr14-local-login-role`, not directly on `main` or `dev`.

## Review Focus

1. OIDC callback with missing state/session match is rejected and creates no Laravel session.
2. Keycloak identity with absent/unverified email, unknown email, inactive account, or invalid role is rejected.
3. A STUDENT cannot access ADMIN pages; a request parameter cannot override the database role.
4. Logout clears the local session and subsequent protected requests require authentication again.
5. Missing OIDC configuration fails closed; no secret is rendered into HTML or logged.

---

### Task 1: Laravel 11 application bootstrap and test harness

**Files:**
- Create generated Laravel 11 application files under `08_Source/` (`artisan`, `composer.json`, `bootstrap/`, `config/`, `routes/`, `resources/`, `tests/`, and related framework files).
- Remove only the placeholder `.gitkeep` files replaced by generated application files.
- Test: `08_Source/tests/Feature/IdentityRoutesTest.php`.

**Interfaces:**
- Produces a Laravel 11 app root at `08_Source/` with `php artisan test`.
- DB schema remains sourced from `database/sql/001_init.sql`; Laravel default users/session migrations are not run against this schema.

- [x] Generate the Laravel 11 skeleton into a temporary folder, then copy the generated files into `08_Source/`; leave `database/sql/001_init.sql` and `seed.sql` unchanged.
- [x] Write `guest_can_open_login_page_and_protected_pages_redirect_to_login` and `login_routes_exist` feature tests asserting GET `/login` is 200 and guest GET `/dashboard` redirects to `/login`.
- [x] Run `php artisan test --filter=IdentityRoutesTest`; expected: tests fail because local identity routes/views are not implemented.
- [x] Add Socialite and the generic OpenID Connect provider with Composer; configure MySQL from environment and file-backed local sessions. Do not add an auth starter kit.
- [x] Re-run the two route tests; expected: login page loads and guest is redirected.

### Task 2: Keycloak OIDC callback and role authorization

**Files:**
- Create `08_Source/app/Http/Controllers/Auth/KeycloakAuthController.php`.
- Create `08_Source/app/Http/Middleware/EnsureRole.php`.
- Create `08_Source/app/Models/User.php`.
- Create `08_Source/resources/views/auth/login.blade.php`, `dashboard.blade.php`, and `08_Source/config/oidc.php`.
- Modify `08_Source/routes/web.php` and `08_Source/bootstrap/app.php`.
- Test: `08_Source/tests/Feature/KeycloakLoginTest.php`, `08_Source/tests/Feature/RoleAuthorizationTest.php`.

**Interfaces:**
- Routes: `GET /login`, `GET /auth/keycloak/redirect`, `GET /auth/keycloak/callback`, `POST /logout`, `GET /logout/callback`, `GET /dashboard`, `GET /admin/dashboard`, `GET /student/dashboard`.
- `KeycloakAuthController::redirect(): RedirectResponse`.
- `KeycloakAuthController::callback(Request $request): RedirectResponse`.
- `KeycloakAuthController::logout(Request $request): RedirectResponse`.
- `EnsureRole::handle(Request $request, Closure $next, string $role): Response`.
- Database role is canonical; only ACTIVE local users can sign in.

- [x] Write tests first: active user callback logs in and regenerates session; unknown user and non-ACTIVE user are rejected; missing verified email is rejected; STUDENT/ADMIN routes enforce role; logout invalidates local session and initiates Keycloak RP-initiated logout; logout callback validates state.
- [x] Run the two test files; expected: fail because callback and role middleware are not implemented.
- [x] Implement OIDC using `Socialite::driver('oidc_keycloak')`; use OIDC PKCE/state held in the server-side session. Never use password grant or store IdP tokens in browser-readable storage.
- [x] Map verified Keycloak email to existing `users.email`; reject if no row, `account_status !== ACTIVE`, or role is not `STUDENT`/`ADMIN`. Call `Auth::login($user)` and regenerate the session.
- [x] Register a `role` middleware alias in Laravel 11 `bootstrap/app.php`; return 403 on role mismatch.
- [x] Implement POST logout by revoking the refresh token best-effort when present, invalidating the local session, then redirecting to the Keycloak end-session endpoint with the saved ID token; implement a callback that validates OIDC logout state.
- [x] Re-run targeted tests and then `php artisan test`; expected: all pass.

### Task 3: Local setup and run README

**Files:**
- Modify `08_Source/README.md`.
- Create `08_Source/.env.example` with placeholders only.
- Create `08_Source/config/oidc.php` only if required by the provider configuration; otherwise use `config/services.php`.
- Test: documented setup smoke-test checklist in the README, verified against the local MySQL 8.0.43 and Keycloak 26 instance.

**Interfaces:**
- README documents local PHP/Composer, MySQL 8, Keycloak 26, database import, environment variables, user mapping, start/stop commands, and role URLs.
- No passwords or generated client secrets are included in committed files.

- [x] Write a setup smoke checklist: database imports DDL/seed, Keycloak redirect returns to callback, seeded active users reach role-specific dashboards, and denied identities cannot get a session.
- [x] Verify fail-closed behavior before OIDC config using a feature test; record remaining deployment limitations.
- [x] Document Keycloak 26 manual realm/client setup using OIDC Authorization Code + PKCE and exact redirect URI `http://127.0.0.1:8000/auth/keycloak/callback`; use environment variables for client secret.
- [x] Document import of `001_init.sql` and `seed.sql`, then `composer install`, `.env` creation, `php artisan key:generate`, and `php artisan serve`.
- [x] Complete a local end-to-end smoke run with MySQL 8.0.43 and Keycloak 26; record outputs and platform prerequisites in `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md`.
- [x] Re-run `php artisan test` after documentation/config updates; all 16 tests pass (70 assertions).

### Task 4: Evidence and deliverable status

**Files:**
- Create `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md`.
- Modify root `P13-STATUS.md`, `P13-DELIVERABLE-MATRIX.md`, `07_Evidence/P13-Work-Board.md`, and `06_Governance/P13-GAP-DECISIONS.md`.

- [x] Record exact local versions, commands, test counts, and login/role smoke-test results; do not claim Gate 1 was evaluated or passed.
- [x] Update PR14-06/07 only to the status supported by runnable evidence (Ada, sudah direview).
- [x] Keep P14/P15 deliverables out of scope.
