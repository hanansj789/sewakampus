# Security Baseline — SewaKampus

**Status:** Draf. Kontrol yang direncanakan, belum diuji.
**Tanggal:** 23 November 2026
**Rujukan:** OWASP API Security Top 10 (2023), OWASP ASVS ringkas, dan tag `x-owasp-api-top10` pada `03_Application/openapi.yaml`.

## 1. Autentikasi

- Keycloak 26 sebagai identity provider, protokol OpenID Connect Authorization Code Flow dengan PKCE.
- Laravel menjadi Backend for Frontend: menyimpan sesi, tidak menyimpan token di browser.
- Nginx memvalidasi JWT memakai JWKS sebelum meneruskan permintaan.
- Admin wajib MFA. Mahasiswa boleh tanpa MFA pada MVP.
- KTM tetap menjadi fallback bila IdP kampus belum tersedia.
- Sesi berakhir setelah 30 menit tanpa aktivitas; refresh token dirotasi.
- Login gagal 5 kali per IP per menit dibatasi.

## 2. Otorisasi

| Risiko | Kontrol |
|---|---|
| BOLA (API1) — pengguna membuka objek milik orang lain | setiap query menyertakan `owner_id` atau `renter_id`; kepemilikan diperiksa di kebijakan Laravel, bukan di komponen UI |
| BFLA (API5) — pengguna biasa memanggil endpoint admin | middleware peran pada semua rute `/admin/*`; `x-required-role: ADMIN` di kontrak |
| Eskalasi peran | `role` tidak bisa diubah lewat endpoint profil |

Aturan kepemilikan yang harus diuji: booking hanya bisa dilihat penyewa, pemilik, dan admin; handover hanya oleh dua pihak booking; review hanya oleh pihak booking yang statusnya `COMPLETED`.

## 3. Validasi masukan

- Validasi di frontend untuk kenyamanan, di backend untuk kepastian.
- Semua nominal uang `DECIMAL(12,2)`, tidak pernah `float`.
- Tanggal divalidasi: `end_date >= start_date`, tidak boleh di masa lalu untuk booking baru.
- Parameter paginasi dibatasi maksimum 100 baris per halaman.
- Respons galat memakai `application/problem+json` tanpa membocorkan jejak kode.

## 4. Unggah berkas

- Tipe yang diterima: JPEG dan PNG untuk foto barang dan foto kondisi; PDF dan JPEG untuk KTM.
- Ukuran maksimum 5 MB.
- Nama berkas diacak; path asli tidak dipakai.
- Disimpan di bucket privat. URL bertanda tangan berumur pendek untuk admin.
- Berkas KTM tidak pernah disajikan lewat URL publik.
- Pemeriksaan isi berkas, bukan hanya ekstensi.

## 5. Perlindungan data

- `password_hash` memakai Argon2id atau bcrypt; tidak pernah dikembalikan API.
- Data pribadi minimum: nama, email, nomor telepon opsional, NIM.
- KTM disimpan terpisah dengan akses admin saja; hash SHA-256 untuk deteksi duplikat.
- `AuditLog` append-only, tanpa endpoint ubah atau hapus.
- Soft delete pada `User` dan `Item` agar riwayat transaksi tetap utuh.

## 6. Rahasia dan konfigurasi

- Semua kredensial di `.env`, tidak masuk repo.
- Service role key tidak pernah dikirim ke browser.
- Kunci JWT dirotasi dengan masa berlaku terbatas.
- Konfigurasi produksi dibedakan dari lokal.

## 7. Transport dan header

- HTTPS wajib, HTTP dialihkan permanen.
- HSTS, `X-Content-Type-Options: nosniff`, `X-Frame-Options: DENY`, `Referrer-Policy: strict-origin-when-cross-origin`.
- CSP dasar: hanya skrip dari domain sendiri.
- Cookie sesi: `Secure`, `HttpOnly`, `SameSite=Lax`.

## 8. Pencatatan dan pemantauan

- Sentry untuk galat aplikasi, Uptime Kuma untuk ketersediaan.
- Setiap perubahan status booking menulis `BookingStatusHistory` dan `AuditLog`.
- Log tidak memuat kata sandi, token, atau isi berkas KTM.
- Peringatan bila login gagal berulang atau unggahan gagal berulang.

## 9. Backup

- Backup harian ke bucket terpisah dari bucket aplikasi.
- Retensi 7 harian, 4 mingguan.
- Restore diuji ke database baru sebelum P15; hasil dan durasi dicatat.

## 10. Yang belum bisa diklaim

- Belum ada pengujian penetrasi.
- Belum ada pengujian OIDC end-to-end.
- Belum ada pengujian otorisasi objek pada kode, karena kode belum ada.
- Semua butir di atas adalah rencana sampai ada bukti uji.
