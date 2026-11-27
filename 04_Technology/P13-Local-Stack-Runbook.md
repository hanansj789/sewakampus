**Status:** Ada. Diuji pada 24 November 2026 di laptop pengembangan.

# P13-11 — Runbook Stack Lokal SewaKampus

**Pemilik:** Mahesa (Network/DevOps + QA)
**Tujuan:** satu halaman untuk menyalakan, memeriksa, dan mematikan stack lokal Laravel 11 + Keycloak 26 + MySQL 8 tanpa menebak urutan.

## 1. Layanan dan port

| Layanan | Alamat lokal | Port | Catatan |
|---|---|---|---|
| Laravel | `http://127.0.0.1:8000` | 8000 | BFF, sesi login, dashboard role |
| Keycloak | `http://127.0.0.1:8080` | 8080 | realm `sewakampus`, tema login `sewakampus` |
| MySQL | `127.0.0.1` | 3311 | instance uji lokal; port default proyek 3306 |
| Redis | belum dijalankan | 6379 | belum diperlukan scaffold login |
| MinIO | belum dijalankan | 9000 | belum diperlukan scaffold login |

## 1.1 Lokasi instalasi di mesin pengembangan

| Komponen | Path | Catatan |
|---|---|---|
| MySQL 8.0.43 | `C:/Users/ASUS/tools/mysql8/mysql-8.0.43-winx64/bin` | zip portable, bukan layanan |
| Data MySQL | `C:/Users/ASUS/tools/mysql8/data` | jangan dihapus tanpa backup |
| Keycloak 26.4.0 | `C:/Users/ASUS/tools/keycloak/keycloak-26.4.0` | mode dev, data H2 di dalam folder |
| JRE 21 | `C:/Users/ASUS/tools/jre21/jdk-21.0.13.1+2-jre` | dipakai lewat JAVA_HOME, tidak masuk PATH |
| Realm JSON | `C:/Users/ASUS/tools/keycloak/realm-sewakampus.json` | berisi client secret, jangan di-commit |

Bukti pemeriksaan: `07_Evidence/P14-Phase0-Env-Check.md`.

## 2. Urutan menyalakan

1. **MySQL** — pastikan menerima koneksi:
   ```bash
   mysqladmin -h 127.0.0.1 -P 3311 -u root ping
   ```
   Harus menjawab `mysqld is alive`.

2. **Keycloak**:
   ```powershell
   $env:KC_BOOTSTRAP_ADMIN_USERNAME = "kcadmin"
   $env:KC_BOOTSTRAP_ADMIN_PASSWORD = "<kata-sandi-lokal>"
   .\bin\kc.bat start-dev --http-port=8080 --hostname=http://127.0.0.1:8080
   ```
   Tunggu sampai:
   ```bash
   curl -s -o /dev/null -w "%{http_code}\n" \
     http://127.0.0.1:8080/realms/sewakampus/.well-known/openid-configuration
   ```
   Harus `200`.

3. **Laravel**:
   ```bash
   cd ARCHITECTURE_REPOSITORY/08_Source
   php artisan config:clear
   php artisan serve --host=127.0.0.1 --port=8000
   ```
   Cek:
   ```bash
   curl -s -o /dev/null -w "%{http_code}\n" http://127.0.0.1:8000/login
   ```
   Harus `200`.

## 3. Pemeriksaan cepat

| Pemeriksaan | Perintah | Hasil yang benar |
|---|---|---|
| Halaman login | `curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000/login` | `200` |
| Discovery Keycloak | `curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8080/realms/sewakampus/.well-known/openid-configuration` | `200` |
| Guest ke dashboard | buka `/dashboard` tanpa sesi | redirect ke `/login` |
| Login mahasiswa | login akun `STUDENT` | masuk `/student/dashboard` |
| Login admin | login akun `ADMIN` | masuk `/admin/dashboard` |
| Lintas role | admin buka `/student/dashboard` | `403` |
| Logout | klik Keluar | kembali ke `/login` |
| Test otomatis | `DB_PORT=3311 php artisan test` | `16 passed, 70 assertions` |

## 4. Tema login

Tema ada di `08_Source/keycloak/themes/sewakampus/`. Jika halaman login kembali ke tampilan default:

1. Salin folder tema ke `<KEYCLOAK_HOME>/themes/sewakampus`.
2. Di realm `sewakampus`, set **Login theme** = `sewakampus`, **Display name** = `SewaKampus`, **Internationalization** = `id` dan `en`, default `id`.
3. Restart Keycloak; tema di-cache saat proses berjalan.
4. Pastikan redirect memakai `ui_locales=id` (sudah diatur di controller).

## 5. Kegagalan yang sering terjadi

| Gejala | Penyebab | Tindakan |
|---|---|---|
| `SQLSTATE[HY000] [2002]` | MySQL mati atau port salah | Nyalakan MySQL, cek `DB_PORT` di `.env` |
| Keycloak `404` pada realm | realm belum diimpor | Impor realm `sewakampus` atau buat ulang |
| Halaman login masih default | tema belum disalin/di-restart | Salin tema, set login theme, restart |
| Login sukses tetapi `403` | role database tidak cocok | Cek `users.role` = `STUDENT`/`ADMIN` dan `account_status=ACTIVE` |
| `cURL error 7` ke Keycloak | Keycloak belum siap | Tunggu discovery endpoint `200` |
| Test gagal koneksi DB | `DB_PORT` tidak diteruskan | Jalankan `DB_PORT=3311 php artisan test` |

## 6. Menghentikan stack

- Laravel: `Ctrl+C` pada terminal `artisan serve`.
- Keycloak: `Ctrl+C` pada terminal `kc.bat`.
- MySQL: `mysqladmin -h 127.0.0.1 -P 3311 -u root shutdown`.

## 7. Batas

- Runbook ini untuk laptop pengembangan, bukan production.
- Redis, MinIO, Nginx, Cloudflare, dan Docker Compose belum dijalankan pada scaffold ini.
- Jangan menaruh kata sandi, client secret, atau token di runbook atau Git. `.env` diabaikan.
- Angka 16 test/70 assertion adalah hasil 24 November 2026; perbarui jika suite berubah.

## 9. Backup dan restore

Skrip ada di `08_Source/database/backup/`.

```bash
cd ARCHITECTURE_REPOSITORY/08_Source
bash database/backup/backup.sh                                  # membuat .sql.gz di ~/sewakampus-backups
bash database/backup/restore.sh <berkas>.sql.gz sewakampus_restore
```

Hasil uji 27 November 2026: backup 1 detik, restore 2 detik, jumlah baris identik. Bukti di `07_Evidence/P15-Restore-Test.md`.
