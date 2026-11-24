**Status:** Selesai. Login + role lokal dan tema Keycloak tersedia; alur Must belum dibuat.

# Menjalankan SewaKampus secara lokal

Panduan ini hanya menjalankan scaffold PR14-06: Laravel 11 sebagai BFF, Keycloak 26 untuk login OIDC, dan role STUDENT/ADMIN dari MySQL. Belum ada fitur listing, booking, handover, atau rating yang berjalan.

## Prasyarat

- PHP 8.3 atau lebih baru, dengan ekstensi PDO MySQL, OpenSSL, cURL, Mbstring, XML, dan Fileinfo.
- Composer 2.
- MySQL 8.0.
- Java 21 dan Keycloak 26 untuk login lokal.

Docker tidak diperlukan untuk langkah lokal ini. Untuk staging/deployment, stack tetap satu VPS Ubuntu dengan Docker Compose sesuai TRD.

## 1. Siapkan database

Buka Command Prompt pada folder `08_Source`, buat database bernama `sewakampus`, lalu impor schema dan data dummy:

```cmd
mysql -u root -p < database\sql\001_init.sql
mysql -u root -p sewakampus < database\sql\seed.sql
```

Jika akun MySQL lokal tidak memakai kata sandi, hilangkan `-p`. Jangan jalankan migrasi Laravel default: schema kanonik adalah dua file SQL di atas.

## 2. Siapkan Keycloak

Jalankan Keycloak 26 dalam mode development. Mode ini hanya untuk laptop lokal, bukan production:

```powershell
$env:KC_BOOTSTRAP_ADMIN_USERNAME = "kcadmin"
$env:KC_BOOTSTRAP_ADMIN_PASSWORD = "<kata-sandi-admin-lokal>"
.\bin\kc.bat start-dev --http-port=8080 --hostname=http://127.0.0.1:8080
```

Di Admin Console Keycloak:

1. Buat realm `sewakampus`.
2. Buat client `sewakampus-local`, protocol OpenID Connect, Client authentication **On**, Standard flow **On**, Direct access grants **Off**.
3. Set PKCE code challenge method ke `S256`.
4. Tambahkan Valid redirect URI `http://127.0.0.1:8000/auth/keycloak/callback`.
5. Tambahkan Valid post logout redirect URI `http://127.0.0.1:8000/logout/callback` dan Web origin `http://127.0.0.1:8000`.
6. Salin client secret dari Keycloak ke `.env` lokal. Jangan masukkan secret ke Git.
7. Buat user untuk demo dengan email yang sama seperti kolom `users.email` di seed, tandai email terverifikasi, lalu set kata sandi lokal sementara. Jangan pakai kata sandi kampus asli. Penyewa, pemilik, dan admin semuanya mahasiswa; admin cukup diberi `users.role=ADMIN`.
8. Pasang tema login SewaKampus:
   - salin folder `keycloak/themes/sewakampus` ke `<KEYCLOAK_HOME>/themes/`;
   - di realm, set **Login theme** ke `sewakampus`, **Display name** ke `SewaKampus`, dan **Internationalization** ke `id` (default) serta `en`;
   - restart Keycloak agar tema dimuat.

Halaman login tetap dihosting Keycloak, tetapi tampil dengan tema SewaKampus: gading, perunggu, Playfair Display, dan teks Indonesia. Laravel tidak menerima kata sandi; setelah login, Keycloak mengembalikan kode OIDC ke callback Laravel.

Role aplikasi tidak diambil dari form atau parameter URL. Laravel mencocokkan email terverifikasi dari Keycloak dengan baris `users` yang `account_status=ACTIVE`, lalu membaca role dari kolom `users.role`.

## 3. Konfigurasi Laravel

Di PowerShell:

```powershell
Copy-Item .env.example .env
composer install
php artisan key:generate
```

Edit `.env` lokal dan isi `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, serta `KEYCLOAK_CLIENT_SECRET`. Contoh OIDC loopback tersedia di `.env.example`. File `.env` diabaikan Git.

## 4. Jalankan aplikasi

```powershell
php artisan config:clear
php artisan serve --host=127.0.0.1 --port=8000
```

Buka `http://127.0.0.1:8000/login`, lalu pilih **Masuk dengan akun kampus**. Akun yang tidak ditemukan, belum aktif, atau emailnya belum diverifikasi akan ditolak. `/admin/dashboard` hanya dapat diakses role ADMIN; `/student/dashboard` hanya role STUDENT. Tombol Keluar mengakhiri sesi Laravel dan meminta Keycloak mengakhiri sesi SSO.

## 5. Uji otomatis

Test feature memakai database MySQL yang sama dan transaksi yang di-rollback. Pastikan schema dan seed sudah diimpor sebelum menjalankan:

```powershell
# Opsional: hanya jika MySQL tidak memakai port default 3306.
$env:DB_PORT = "3311"
php artisan test
```

Ganti `3311` dengan port MySQL lokal, atau hilangkan baris `$env:DB_PORT` untuk port default 3306. Suite menguji redirect OIDC, pemetaan akun aktif, penolakan email tak terverifikasi/akun nonaktif, pembatasan role, dan logout-state.

## Batasan scaffold

- Login hanya lewat Keycloak. Laravel tidak menerima atau menyimpan kata sandi pengguna.
- Halaman login memakai tema `sewakampus` di Keycloak, bukan halaman SIAKAD dan bukan form kata sandi Laravel.
- User Keycloak harus dibuat terpisah dan emailnya cocok dengan seed lokal. Pendaftaran otomatis belum dibuat.
- Penyewa, pemilik, dan admin adalah mahasiswa; admin adalah mahasiswa dengan role `ADMIN`.
- Halaman dashboard hanya membuktikan login dan role. Fungsi Must belum dibangun.
- `composer audit` masih menemukan 5 advisori Laravel 11; dua advisori Symfony sudah ditutup. Triage ada di `07_Evidence/P14-Security-Audit-Triage.md`.
- Keycloak memakai H2/dev mode untuk laptop ini. Deployment production tetap memakai konfigurasi TRD, secret yang aman, HTTPS, dan database production.
- Gate 1 belum dinilai dosen. Pekerjaan ini adalah pengecualian PR14-06/07 yang dicatat pada CR-003/SK-020; status gate tidak berubah.
