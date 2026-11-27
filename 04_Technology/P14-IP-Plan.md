**Status:** Ada. IP plan staging, 27 November 2026.

# P14 — IP Plan Staging

**Pemilik:** Mahesa Kanaka Raya (Network/DevOps)
**Dasar:** SK-026 (staging lewat tunnel, bukan VPS), `P13-Topology-As-Is.md`.

## 1. Segmen

| Segmen | Alamat | Isi | Akses dari luar |
|---|---|---|---|
| Loopback laptop | `127.0.0.1` | Laravel 8000, Keycloak 8080, MySQL 3311 | tidak |
| LAN kampus/kos | DHCP, tidak dicatat | perangkat pengembang | tidak dibuka |
| Tepi Cloudflare | `*.trycloudflare.com` | tunnel masuk | ya, HTTPS |

Alamat LAN tidak dicatat karena berubah-ubah dan tidak dipakai untuk staging. Semua layanan hanya mendengar di loopback.

## 2. Port

| Port | Protokol | Layanan | Bind | Terbuka ke internet |
|---|---|---|---|---|
| 8000 | HTTP | Laravel (BFF) | `127.0.0.1` | tidak langsung; hanya lewat tunnel |
| 8080 | HTTP | Keycloak 26.4.0 | `127.0.0.1` | tidak langsung; hanya lewat tunnel |
| 3311 | MySQL | basis data | `127.0.0.1` | tidak |
| 443 | HTTPS keluar | `cloudflared` ke Cloudflare | keluar | — |
| 7844 | QUIC keluar | `cloudflared` (fallback HTTP/2) | keluar | — |

Aturan: tidak ada port forwarding di router, tidak ada DMZ, dan MySQL tidak pernah diekspos. Satu-satunya jalan masuk adalah dua tunnel Cloudflare.

## 3. Nama host staging

| Nama | Fungsi | Sifat |
|---|---|---|
| `https://cakes-clicks-berlin-alan.trycloudflare.com` | aplikasi Laravel | sementara, berubah setiap `cloudflared` dijalankan ulang |
| `https://because-corpus-davis-pack.trycloudflare.com` | Keycloak | sementara, harus cocok dengan `KEYCLOAK_SERVER_URL` dan issuer |

Karena nama berubah, setiap kali staging dinyalakan ulang tiga nilai harus diselaraskan: `APP_URL`, `KEYCLOAK_SERVER_URL`, dan redirect URI client di Keycloak. Prosedurnya ada di `07_Evidence/P14-Staging-Deploy.md`.

## 4. Yang tidak termasuk

- Tidak ada IP publik tetap.
- Tidak ada load balancer.
- Tidak ada VPS, Redis, MinIO, atau worker pada staging ini. Foto memakai disk privat laptop.
- Tidak ada jaminan ketersediaan; laptop mati berarti staging mati.
