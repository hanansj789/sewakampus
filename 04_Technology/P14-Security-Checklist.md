**Status:** Ada. Checklist keamanan dijalankan pada staging, 27 November 2026.

# P14 — Checklist Keamanan Staging

**Pemilik:** Mahesa Kanaka Raya (Network/DevOps)
**Objek uji:** `https://cakes-clicks-berlin-alan.trycloudflare.com`, 27 November 2026.

| # | Butir | Cara uji | Hasil | Tindakan |
|---|---|---|---|---|
| 1 | Transport HTTPS | `curl -I http://<app>/login` | 301 ke HTTPS | — |
| 2 | Redirect tamu memakai HTTPS | buka `/items` tanpa sesi | 302 ke `https://` | diperbaiki lewat `trustProxies` |
| 3 | Cookie sesi | periksa `Set-Cookie` | `secure`, `httponly`, `samesite=lax` | — |
| 4 | Halaman 404 tidak membocorkan kode | buka URL acak | 404 polos, tanpa stack trace | — |
| 5 | Debug mati | `APP_DEBUG` | `false`, `APP_ENV=production` | jangan dikembalikan ke `true` saat staging |
| 6 | Rahasia tidak masuk repo | `git ls-files` | `.env` tidak terlacak | — |
| 7 | Otorisasi peran | tes `RoleAuthorizationTest` | lulus; mahasiswa 403 di area admin | ulangi manual saat demo |
| 8 | Otorisasi objek | tes `ItemListingTest`, `BookingTest` | lulus; bukan pemilik 403 | — |
| 9 | Validasi unggahan | tes `HandoverTest` | tanpa foto 422, bukan gambar 422 | — |
| 10 | Rate limit | belum diimplementasikan | **gagal** | tambahkan di Nginx/Cloudflare sebelum P16 |
| 11 | HSTS | header respons | **tidak ada** | aktifkan HSTS di Cloudflare |
| 12 | Uji beban | belum | **belum** | lakukan sebelum P15 |
| 13 | Backup | belum ada | **belum** | K-DB |
| 14 | MFA admin | Keycloak belum diwajibkan | **belum** | konfigurasi realm sebelum P15 |

## Ringkasan

Lulus: 1, 2, 3, 4, 5, 6, 7, 8, 9.
Belum: 10, 11, 12, 13, 14.

Yang belum bukan kegagalan tersembunyi; semuanya sudah tercatat sebagai pekerjaan di `07_Evidence/P14-Work-Board.md` dan `04_Technology/P13-Security-Baseline.md`.
