**Status:** Ada. Handoff programmer untuk scaffold Laravel 11; belum ada fitur Must.

# P14 — Programmer Handoff Laravel

**Pemilik:** Muhammad Fazha Nararya Nugraha (Programmer/DBA)
**Tanggal:** 24 November 2026
**Lingkup:** `08_Source/` — Laravel 11, Keycloak 26 OIDC, role dari MySQL.

## 1. Apa yang sudah ada

- Laravel 11.57.1 di `08_Source/`.
- Login OIDC Authorization Code + PKCE lewat Keycloak.
- Callback yang memetakan email terverifikasi ke `users` aktif.
- Middleware role `STUDENT`/`ADMIN`.
- Dashboard terpisah dan logout dengan revoke + end-session.
- Halaman login Keycloak bertema `sewakampus`.
- 16 feature test, 70 assertion.

Yang **belum** ada: lima Must (listing, kalender, persetujuan, foto kondisi, rating). Jangan menambahkannya sebelum Gate 1 dinilai.

## 2. Struktur yang dibaca programmer berikutnya

```text
08_Source/
├── app/
│   ├── Http/
│   │   ├── Controllers/Auth/KeycloakAuthController.php
│   │   └── Middleware/EnsureRole.php
│   ├── Models/User.php
│   └── Providers/AppServiceProvider.php
├── bootstrap/app.php              # alias middleware role
├── config/oidc.php                # server, realm, client, redirect
├── routes/web.php                 # login, callback, logout, dashboard
├── resources/views/
│   ├── auth/login.blade.php
│   └── dashboard.blade.php
├── keycloak/themes/sewakampus/    # tema halaman login
├── tests/Feature/
│   ├── IdentityRoutesTest.php
│   ├── KeycloakLoginTest.php
│   └── RoleAuthorizationTest.php
└── database/sql/001_init.sql, seed.sql, 002_verify.sql
```

## 3. Alur request

```text
Browser
  → GET /login                     halaman SewaKampus
  → GET /auth/keycloak/redirect    Socialite OIDC + PKCE + ui_locales=id
  → Keycloak                       pengguna memasukkan kredensial
  → GET /auth/keycloak/callback    tukar code, validasi state/nonce
  → cek email_verified + users ACTIVE + role STUDENT/ADMIN
  → Auth::login + session regenerate
  → GET /dashboard                 redirect sesuai role
  → /student/dashboard | /admin/dashboard
```

## 4. Route

| Method | Path | Middleware | Handler |
|---|---|---|---|
| GET | `/login` | guest | view `auth.login` |
| GET | `/auth/keycloak/redirect` | — | `KeycloakAuthController@redirect` |
| GET | `/auth/keycloak/callback` | — | `KeycloakAuthController@callback` |
| POST | `/logout` | auth | `KeycloakAuthController@logout` |
| GET | `/logout/callback` | — | `KeycloakAuthController@logoutCallback` |
| GET | `/dashboard` | auth | redirect sesuai role |
| GET | `/student/dashboard` | auth, role:STUDENT | view `dashboard` |
| GET | `/admin/dashboard` | auth, role:ADMIN | view `dashboard` |
| GET | `/` | — | redirect `/dashboard` |

## 5. Aturan yang tidak boleh dilanggar

1. **Password tidak pernah masuk Laravel.** Halaman kredensial ada di Keycloak; Laravel hanya menerima kode OIDC.
2. **Role dari database.** `users.role` adalah sumber otorisasi; jangan percaya query string, form, atau klaim role dari token.
3. **Hanya user ACTIVE.** Email harus terverifikasi dan cocok dengan baris `users` berstatus `ACTIVE`.
4. **Session regenerate setelah login.** Logout harus menghapus sesi lokal, revoke refresh token, dan memanggil end-session Keycloak.
5. **Token tidak disimpan di browser-readable storage.** ID/refresh token disimpan terenkripsi di session server.
6. **Jangan commit secret.** `.env` diabaikan; `.env.example` hanya placeholder.

## 6. Cara menambah fitur Must nanti (setelah Gate 1)

1. Ambil endpoint dari `03_Application/openapi.yaml`.
2. Buat controller/service di `app/Http/Controllers` dan `app/Services`; jangan menaruh logika di route.
3. Gunakan policy/gate untuk kepemilikan resource (pemilik barang, penyewa booking).
4. Tambah feature test untuk aturan bisnis dan role.
5. Perbarui `README.md` bila ada perintah baru.
6. Jangan mengubah skema tanpa memperbarui `001_init.sql` dan `002_verify.sql`.

## 7. Test yang sudah ada

| Berkas | Yang diuji |
|---|---|
| `IdentityRoutesTest` | halaman login 200; guest dashboard redirect ke login |
| `KeycloakLoginTest` | redirect OIDC, callback user aktif, penolakan email tidak dikenal/tidak terverifikasi/akun nonaktif, state invalid, config kosong, logout dan state logout |
| `RoleAuthorizationTest` | student/admin dashboard, penolakan lintas role, redirect berdasarkan role database |

Perintah:

```bash
cd 08_Source
DB_PORT=3311 php artisan test
```

Hasil terakhir: **16 passed, 70 assertions**.

## 8. Batas dan risiko

- Scaffold lokal, bukan production.
- Keycloak berjalan dev mode.
- 5 advisori Laravel 11 tersisa; lihat `07_Evidence/P14-Security-Audit-Triage.md`.
- Belum ada staging, Redis, MinIO, atau Nginx.
- Lima Must belum dibangun; implementasi menunggu Gate 1.

## 9. Rujukan

- `08_Source/README.md` — cara menjalankan.
- `04_Technology/P13-Local-Stack-Runbook.md` — urutan layanan dan troubleshooting.
- `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md` — bukti login/role.
- `06_Governance/ADR-003-local-oidc-login-role.md` — keputusan auth.
