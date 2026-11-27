**Status:** Ada. Bukti pemeriksaan lingkungan Fase 0, 27 November 2026.

# P14 — Bukti Pemeriksaan Lingkungan Fase 0

**Tanggal:** 27 November 2026
**Branch:** `dev`, commit `c1fba62`
**Tujuan:** memastikan stack lokal benar-benar hidup sebelum fitur Must ditulis.
**Sifat:** pemeriksaan teknis. Bukan penilaian gate, bukan klaim fitur selesai.

## 1. Perangkat yang dipakai

| Komponen | Versi | Lokasi |
|---|---|---|
| Windows | 11 (10.0.26200) | — |
| PHP CLI | 8.4.0 | Herd Lite |
| Laravel | 11.57.1 | `08_Source/` |
| MySQL | 8.0.43 Community (zip portable) | `C:\Users\ASUS\tools\mysql8\mysql-8.0.43-winx64` |
| Data MySQL | baru, terpisah dari data lain | `C:\Users\ASUS\tools\mysql8\data` |
| Keycloak | 26.4.0 | `C:\Users\ASUS\tools\keycloak\keycloak-26.4.0` |
| JRE | Temurin 21.0.13.1 | `C:\Users\ASUS\tools\jre21\jdk-21.0.13.1+2-jre` |

Catatan: MySQL dan Keycloak sebelumnya tidak terpasang sebagai layanan. Keduanya dijalankan manual dari folder di atas. Docker tidak tersedia di mesin ini.

## 2. Hasil pemeriksaan

| # | Pemeriksaan | Perintah | Hasil |
|---|---|---|---|
| 1 | MySQL menerima koneksi | `mysqladmin -h 127.0.0.1 -P 3311 -u root ping` | `mysqld is alive` |
| 2 | DDL di database kosong | `mysql ... < 001_init.sql` | lolos, tanpa galat |
| 3 | Seed | `mysql ... < seed.sql` | lolos, tanpa galat |
| 4 | Jumlah tabel | `information_schema.tables` | 14 tabel, 1 view |
| 5 | Isi tabel master | `SELECT COUNT(*)` | 30 pengguna, 30 kategori, 30 barang, 10 booking |
| 6 | Test otomatis | `DB_PORT=3311 php artisan test` | 16 lulus, 70 assertion |
| 7 | Keycloak hidup | `GET /realms/master/.../openid-configuration` | HTTP 200 |
| 8 | Realm proyek | `GET /realms/sewakampus/.../openid-configuration` | HTTP 200 |
| 9 | Tema login | isi halaman login | tema `sewakampus` terpakai, teks Indonesia |
| 10 | Pengguna realm | Admin API | 3 pengguna, semua email terverifikasi |
| 11 | Halaman login Laravel | `GET http://127.0.0.1:8000/login` | HTTP 200 |
| 12 | Redirect ke Keycloak | `GET /auth/keycloak/redirect` | HTTP 302 ke realm `sewakampus`, `code_challenge_method=S256`, `ui_locales=id` |

## 3. Isi realm `sewakampus`

| Item | Nilai |
|---|---|
| Client | `sewakampus-local`, confidential, PKCE S256 |
| Redirect URI | `http://127.0.0.1:8000/auth/keycloak/callback` |
| Tema | `sewakampus` |
| Pengguna | `hanan` (STUDENT), `mahesa` (STUDENT), `admin` (ADMIN) |
| Email pengguna | dicocokkan dengan tabel `users` hasil seed |
| Kata sandi pengguna uji | sama dengan data seed, hanya untuk lokal |

Kredensial admin Keycloak dan client secret tidak ditulis di repo. Keduanya ada di `.env` lokal (diabaikan Git) dan di catatan pemilik.

## 4. Yang belum ada

| Komponen | Status | Dampak |
|---|---|---|
| Redis | belum dijalankan | belum dibutuhkan sampai antrean notifikasi |
| MinIO | belum dijalankan | foto memakai disk privat lokal dulu |
| Docker | tidak tersedia | stack dijalankan langsung di Windows |
| Java di PATH global | tidak ada | Keycloak dijalankan dengan `JAVA_HOME` eksplisit |
| Staging | belum ada | dibahas di Fase 4 |

## 5. Cara menyalakan ulang

```bash
# MySQL (port 3311)
C:/Users/ASUS/tools/mysql8/mysql-8.0.43-winx64/bin/mysqld.exe \
  --datadir=C:/Users/ASUS/tools/mysql8/data \
  --port=3311 --console

# Keycloak (port 8080)
cd C:/Users/ASUS/tools/keycloak/keycloak-26.4.0
JAVA_HOME=C:/Users/ASUS/tools/jre21/jdk-21.0.13.1+2-jre \
  bash bin/kc.sh start-dev --http-port=8080 --hostname=http://127.0.0.1:8080

# Laravel (port 8000)
cd ARCHITECTURE_REPOSITORY/08_Source
DB_PORT=3311 php artisan serve --host=127.0.0.1 --port=8000
```

Mematikan: `mysqladmin -h 127.0.0.1 -P 3311 -u root shutdown`, `Ctrl+C` pada Keycloak, `Ctrl+C` pada Laravel.

## 6. Peringatan

- Keycloak berjalan pada mode dev dengan basis data H2 di dalam foldernya. Menghapus folder Keycloak berarti realm `sewakampus` ikut hilang dan harus dibuat ulang.
- Data MySQL ada di `C:\Users\ASUS\tools\mysql8\data`, bukan di folder proyek. Jangan menghapusnya tanpa backup.
- Ini lingkungan pengembangan. Tidak ada HTTPS, tidak ada backup terjadwal, dan tidak boleh disebut staging.
