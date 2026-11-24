**Status:** Ada. Triage keamanan dependensi; 5 advisori Laravel 11 diterima dengan kontrol, 2 advisori Symfony sudah ditutup.

# P14 — Triage Audit Composer

**Tanggal:** 24 November 2026
**Pemilik:** Fazha (Programmer/DBA) dan Mahesa (QA)
**Lingkup:** `08_Source/` Laravel 11.57.1, PHP 8.4.0, lock file 24 November 2026.

## 1. Hasil sebelum dan sesudah

| Tahap | Perintah | Hasil |
|---|---|---|
| Awal | `composer audit --locked` | 7 advisori, 2 paket: `laravel/framework`, `symfony/yaml` |
| Perbaikan | `composer update "symfony/yaml:7.4.23" --with-dependencies` | `symfony/yaml` 8.0.15 → 7.4.23 |
| Akhir | `composer audit --locked` | **5 advisori, 1 paket: `laravel/framework` 11.57.1** |

Dua advisori Symfony (CVE-2026-123792 dan CVE-2026-109413) tertutup oleh 7.4.23. Laravel 11.57.1 adalah rilis 11.x terbaru; tidak ada patch 11.x untuk lima advisori di bawah karena perbaikannya berada di Laravel 12.60+/12.71+ atau 13.x.

## 2. Lima advisori yang tersisa

| ID | Severity | Judul | Versi terdampak | Paparan di aplikasi ini | Keputusan |
|---|---|---|---|---|---|
| PKSA-3r5d-mb8f-1qw9 | high | CRLF injection in default email rule | `<12.60.0`, `13.0.0–13.9.0` | Tidak ada pengiriman email, tidak ada validasi `email` atas input yang masuk ke header | Terima sementara; jangan tambah fitur email sebelum upgrade |
| PKSA-mdq4-51ck-6kdq | — | CVE-2026-48019, CRLF yang sama | `11.x`, `<12.60.0`, `13.0.0–13.10.0` | Sama dengan di atas | Terima sementara; satu akar masalah |
| PKSA-m5cs-t1y6-qpcs | medium | Temporary Signed URL path confusion | `<12.61.1`, `13.0.0–13.12.0` | Tidak memakai `temporarySignedRoute` atau middleware `signed` | Terima sementara; jangan pakai signed URL |
| PKSA-yxbx-3c9s-cjt9 | low | Task Output Injection — Concurrency Process | `<12.71.0`, `13.0.0–13.40.0` | Tidak memakai `Process` atau `Concurrency` | Terima sementara; jangan jalankan proses dari input pengguna |
| PKSA-d5tc-s1qs-h781 | low | XSS in Debug Page Information | `<12.69.0`, `13.0.0–13.30.0` | `APP_DEBUG=false` untuk staging/production; halaman debug hanya lokal | Terima sementara; jangan aktifkan debug di publik |

Bukti paparan: pencarian `Process::`, `Concurrency`, `temporarySignedRoute`, `signed`, `Mail::`, dan aturan validasi `email` di `app/` dan `routes/` tidak menemukan pemakaian berisiko. Satu-satunya kecocokan `email` adalah scope OIDC, bukan validasi email Laravel.

## 3. Kontrol pengganti

1. `APP_DEBUG=false` di staging dan production; halaman debug tidak diekspos.
2. Tidak ada fitur email, signed URL, atau pemrosesan eksternal di scaffold saat ini.
3. Keycloak menangani autentikasi; Laravel tidak menerima kata sandi.
4. Dependency dikunci dengan `composer.lock`; audit dijalankan ulang setiap ada perubahan dependensi.
5. Sebelum fitur email atau unggahan publik dibangun, Laravel harus dinaikkan ke rilis yang sudah ditambal.

## 4. Batas dan pemicu review ulang

- Ini **bukan** audit bersih. `composer audit` masih gagal dengan 5 advisori.
- Perbaikan penuh menuntut upgrade Laravel 11 → 12.71+ atau 13.40+. Itu perubahan stack dan butuh CR/ADR; belum dilakukan.
- Review ulang wajib sebelum staging, sebelum fitur email, sebelum fitur signed URL, dan sebelum deployment production.
- Jika dosen atau penguji menuntut audit bersih, ajukan CR upgrade Laravel, bukan menghapus advisori dari konfigurasi audit.
