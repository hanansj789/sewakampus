**Status:** Ada. Bukti staging berjalan, 27 November 2026.

# P14 — Bukti Staging

**Pemilik:** Mahesa Kanaka Raya (Network/DevOps)
**Tanggal:** 27 November 2026
**Sifat:** bukti teknis. Bukan penilaian Gate 2.

## 1. Alamat staging

| Layanan | URL |
|---|---|
| Aplikasi | `https://cakes-clicks-berlin-alan.trycloudflare.com` |
| Keycloak | `https://because-corpus-davis-pack.trycloudflare.com` |

Nama ini sementara. Setiap `cloudflared` dijalankan ulang, nama berubah dan tiga nilai harus diselaraskan: `APP_URL`, `KEYCLOAK_SERVER_URL`, dan redirect URI di client Keycloak.

## 2. Hasil pemeriksaan

| # | Pemeriksaan | Hasil |
|---|---|---|
| 1 | Halaman login lewat tunnel | HTTP 200 |
| 2 | HTTP dipaksa ke HTTPS | HTTP 301 ke `https://` |
| 3 | Halaman tidak ditemukan | HTTP 404 tanpa jejak kode |
| 4 | Tamu membuka `/items` | 302 ke `/login` dengan skema **https** |
| 5 | Cookie sesi | `secure`, `httponly`, `samesite=lax` |
| 6 | Login lengkap lewat dua tunnel | `hanan` masuk sampai `/student/dashboard` |
| 7 | Katalog lewat tunnel | 12 kartu tampil |
| 8 | Debug | `APP_ENV=production`, `APP_DEBUG=false` |

Bukti gambar:

- `07_Evidence/screenshots/P14-staging-dashboard-2026-11-27.png`
- `07_Evidence/screenshots/P14-staging-katalog-2026-11-27.png`

## 3. Cacat yang ditemukan dan diperbaiki

Redirect tamu keluar sebagai `http://...` karena Laravel tidak mempercayai header `X-Forwarded-Proto` dari Cloudflare. Akibatnya, pengguna yang membuka halaman tanpa sesi akan dilempar ke versi HTTP.

Perbaikan: `bootstrap/app.php` memanggil `trustProxies` untuk header `X-Forwarded-For`, `Proto`, `Host`, dan `Port`. Setelah itu redirect memakai `https`.

## 4. Cara menyalakan ulang

```bash
# 1. MySQL
C:/Users/ASUS/tools/mysql8/mysql-8.0.43-winx64/bin/mysqld.exe \
  --datadir=C:/Users/ASUS/tools/mysql8/data --port=3311 --console

# 2. Keycloak (ganti nama host sesuai tunnel baru)
cd C:/Users/ASUS/tools/keycloak/keycloak-26.4.0
JAVA_HOME=C:/Users/ASUS/tools/jre21/jdk-21.0.13.1+2-jre \
  bash bin/kc.sh start-dev --http-port=8080 \
  --hostname=https://<nama-tunnel-keycloak>.trycloudflare.com

# 3. Tunnel aplikasi dan tunnel Keycloak
C:/Users/ASUS/tools/cloudflared.exe tunnel --url http://127.0.0.1:8000 --no-autoupdate
C:/Users/ASUS/tools/cloudflared.exe tunnel --url http://127.0.0.1:8080 --no-autoupdate

# 4. Laravel
cd ARCHITECTURE_REPOSITORY/08_Source
DB_PORT=3311 php artisan serve --host=127.0.0.1 --port=8000
```

Setelah nama tunnel baru muncul, perbarui `.env` (`APP_URL`, `KEYCLOAK_SERVER_URL`, `KEYCLOAK_REDIRECT_URI`) dan redirect URI client Keycloak.

## 5. Batas yang harus disebut jujur

| Batas | Akibat |
|---|---|
| Berjalan di laptop | staging mati bila laptop mati atau tidur |
| Nama tunnel sementara | URL berubah setiap restart, tidak cocok untuk tautan permanen |
| Tanpa Redis, MinIO, worker | antrean email tidak berjalan, foto di disk lokal |
| Tanpa HSTS dari aplikasi | perlu diaktifkan di Cloudflare |
| Tanpa uji beban | kapasitas 300 pengguna belum terbukti |
| Keycloak H2 | data realm hilang bila folder Keycloak dihapus |
