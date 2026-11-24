**Status:** Ada. Bukti uji otomatis dan smoke test lokal.

# PR14-06 — Log uji login dan role lokal

**Tanggal uji:** 24 November 2026  
**Branch:** `feature/pr14-local-login-role`  
**Gate 1:** Belum dinilai; tidak ada status warna yang disimpulkan.

## Lingkungan yang dipakai

- Windows 11, PHP 8.4.0 CLI, Composer 2.10.1.
- Laravel Framework 11.57.1.
- MySQL 8.0.43 lokal, port 3311, database `sewakampus` dengan schema dan seed proyek.
- Temurin JRE 21.0.13.1; Keycloak 26.4.0, realm lokal `sewakampus`.
- App lokal `http://127.0.0.1:8000`; Keycloak lokal `http://127.0.0.1:8080`.
- Credential admin/client hanya berada pada konfigurasi lokal ignored; tidak dicatat di log ini.

## Uji otomatis

Perintah:

```powershell
$env:DB_PORT = "3311"
php artisan test
```

Hasil: **16 tests passed, 70 assertions**, 1.09 detik pada run terakhir.

Uji mencakup halaman login dan redirect guest, redirect OIDC, callback akun ACTIVE dengan email terverifikasi, penolakan email tidak dikenal/tidak terverifikasi dan akun nonaktif, state callback, konfigurasi OIDC kosong, logout, validasi state logout, otorisasi dashboard STUDENT/ADMIN, dan role dari database.

## Smoke test browser Keycloak nyata

1. Discovery document realm lokal tersedia; issuer cocok dengan URL server Keycloak dan endpoint logout terpapar.
2. Halaman login Keycloak memakai tema `sewakampus`: latar gading, kartu putih, Playfair Display, teks Indonesia, dan tombol pill hitam.
3. Login dengan user demo STUDENT mencapai `/student/dashboard` dan menampilkan role Mahasiswa.
4. POST logout kembali ke `/login`.
5. Login dengan user demo ADMIN mencapai `/admin/dashboard`.
6. Saat sesi ADMIN aktif, akses langsung ke `/student/dashboard` menghasilkan HTTP **403 Forbidden**.
7. Authorization request memuat `code_challenge_method=S256`, `ui_locales=id`, dan redirect URI yang didaftarkan.

Test memakai akun demo lokal dari realm sementara. Jangan gunakan password kampus pribadi. Realm dan secret untuk smoke test tidak menjadi artefak repository.

## Batas verifikasi

- Belum diuji pada mesin anggota lain atau staging.
- Keycloak berjalan dalam dev mode dengan storage lokal; bukan bukti kesiapan produksi.
- `composer audit --locked` menghasilkan exit code 1 dan melaporkan **7 security advisories** pada `laravel/framework` dan `symfony/yaml`. Belum ditriase atau diperbaiki; jangan klaim dependency bersih atau sistem siap produksi.
- Review silang independen belum dilakukan. Status deliverable tetap Ada, menunggu review.
- Tidak ada Must/alur produk yang diimplementasikan.
