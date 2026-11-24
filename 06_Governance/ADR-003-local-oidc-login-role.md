**Status:** Draf, menunggu review.

# ADR-003 — Scaffold login OIDC dan role lokal

**Tanggal:** 24 November 2026  
**Status Gate 1:** Belum dinilai.

## Konteks

PR14-06 meminta aplikasi lokal berjalan dengan login dan role sebelum P14. CR-003/SK-020 memberi pengecualian terbatas untuk scaffold ini, tanpa mengizinkan implementasi lima Must. Stack Laravel 11, MySQL 8, dan Keycloak 26 tidak berubah.

## Keputusan

- Laravel menjadi BFF dan memakai Keycloak OpenID Connect Authorization Code dengan PKCE.
- Halaman login dihosting Keycloak dan memakai tema `sewakampus` di `08_Source/keycloak/themes/`. Laravel tidak menampilkan form kata sandi. Ini mempertahankan OIDC/PKCE dan menghindari password grant.
- Hanya user Keycloak dengan email terverifikasi yang cocok ke baris MySQL berstatus `ACTIVE` dapat login. Role otorisasi bersumber dari kolom role lokal (`STUDENT`/`ADMIN`), bukan klaim/form/request pengguna.
- Middleware role melindungi dashboard mahasiswa dan admin secara terpisah. Sesi diregenerasi setelah login.
- Logout mengakhiri sesi Laravel, mencabut refresh token bila ada, dan memakai endpoint logout Keycloak dengan validasi state callback.
- Kredensial lokal diletakkan di `.env` yang diabaikan Git; `.env.example` hanya berisi placeholder.
- Satu view dashboard dipakai untuk dua route ber-role karena saat ini hanya membuktikan akses; Must dan alur produk tidak ditambahkan.

## Konsekuensi

- User Keycloak lokal harus dibuat terpisah dan emailnya cocok dengan seed lokal.
- Lingkungan lokal memakai Keycloak dev mode; bukan konfigurasi deployment production.
- Verifikasi otomatis 16 test/70 assertion dan smoke test browser lokal STUDENT/ADMIN tercatat pada `P13-STATUS.md`; review silang tetap belum dilakukan.
- Gate 1 tetap belum dinilai. Perubahan ini hanya untuk PR14-06/07.
