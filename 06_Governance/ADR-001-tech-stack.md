**Status:** Draf — ditulis lebih awal dari jadwal P14-01, menunggu pengesahan CEO.

# ADR-001 — Tech Stack dan Basis Data

**Tanggal:** 24 November 2026
**Pengusul:** Fazha (Programmer + Database Architect)
**Menjawab:** P14-01 "ADR tech stack dan database nyata". Ditulis pada P13 karena stack sudah dikunci di `DECISIONS.md` dan `P13-STATUS.md` §4, sehingga dokumen alasannya tidak perlu menunggu.

## Konteks

- Tim empat orang, satu programmer utama, waktu efektif P13–P16 lima pertemuan.
- Anggaran infrastruktur kecil; satu VPS 4 vCPU / 8 GB / 160 GB sudah ditetapkan pada laporan §3.5.1.
- Lima Must: listing, kalender ketersediaan, persetujuan sewa, foto kondisi, rating.
- Kebutuhan yang mengunci pilihan: unggah berkas (foto barang, KTM, foto kondisi), autentikasi berbasis peran, antrean email, penyimpanan privat, dan API ber-kontrak.

## Keputusan

| Lapisan | Pilihan | Versi | Alasan ringkas |
|---|---|---|---|
| Bahasa dan framework | PHP + **Laravel** | 11 / PHP 8.3 | Rilis 8.3, rilis 8.4, rilis 8.5 sudah lewat; 11 masih menerima perbaikan keamanan. Monolith, autentikasi, validasi, antrean, dan migrasi sudah tersedia tanpa dirakit sendiri |
| Database | **MySQL** | 8.0 | Transaksi, foreign key, `CHECK`, dan JSON sudah cukup untuk 14 entitas; dukungan penyedia VPS luas |
| Cache dan antrean | **Redis** | 7 | Dipakai Laravel untuk cache, sesi, dan queue; satu layanan untuk tiga kebutuhan |
| Object storage | **MinIO** (S3-compatible) | — | Foto barang, KTM, dan foto kondisi harus privat; MinIO berjalan di VPS yang sama, tanpa biaya tambahan |
| Identitas | **Keycloak** | 26 | OIDC/SAML, MFA admin, dan bisa menjadi broker ke IdP kampus nanti |
| Reverse proxy | **Nginx** | 1.26 | TLS, rate limit, validasi JWT lewat JWKS |
| Orkestrasi | **Docker Compose** pada satu VPS | — | Enam container; Kubernetes tidak sepadan untuk satu mesin |
| Edge | **Cloudflare** | paket Free | DNS, WAF, TLS, cache; biaya 0 dolar |
| Observability | **Sentry** + **Uptime Kuma** | — | Error dan uptime; keduanya bisa memakai paket gratis |
| Kontrak API | **OpenAPI 3.1** | 3.1.0 | Kontrak kanonik di repo (SK-015), 34 path, 39 operasi |

Detail struktur kode ada di `03_Application/P13-App-Structure.md` dan `ADR-002`.

## Alternatif yang ditolak

| Alternatif | Alasan ditolak |
|---|---|
| Shared hosting | Tidak bisa menjalankan container, Redis, dan Keycloak |
| Kubernetes / service mesh | Enam container di satu VPS; biaya operasional tidak sebanding |
| Managed PaaS penuh | Mengunci provider dan menyembunyikan Docker Compose yang sudah dipakai untuk belajar |
| PostgreSQL | Setara secara teknis, tetapi DDL, seed, dan contoh di laporan sudah MySQL 8; mengganti sekarang berarti menulis ulang tanpa manfaat yang bisa diuji |
| Firebase / BaaS | Model data relasional dengan aturan status dan sengketa tidak nyaman di dokumen NoSQL; juga mengunci ke satu vendor |
| Laravel + Inertia/SPA terpisah | Menambah satu lapisan build; Blade + Tailwind cukup untuk lima Must |

## Konsekuensi

**Positif**

- Satu perintah `docker compose up` menyalakan seluruh sistem; cocok dengan kemampuan tim.
- Semua komponen berlisensi bebas biaya, kecuali VPS dan domain.
- Keycloak membuka jalur integrasi SSO kampus tanpa mengubah aplikasi.

**Negatif / risiko**

- Satu VPS adalah titik kegagalan tunggal; sudah dicatat di laporan §3.5.5.
- Keycloak di mesin yang sama menambah konsumsi RAM; 8 GB cukup untuk demonstran, tidak untuk produksi nyata.
- MySQL 8 mengunci DDL pada satu mesin: `utf8mb4_0900_ai_ci` tidak jalan di MariaDB (G-22). Bila nanti pindah ke MariaDB, collation harus diganti.

## Kepatuhan

| Aturan | Cara diperiksa |
|---|---|
| Versi sesuai tabel di atas | `docker/` dan `README.md` saat aplikasi jalan (P14) |
| DDL berjalan di MySQL 8 | `07_Evidence/PR14-04-DDL-Run-Log.md` — sudah diuji pada 8.0.43 |
| Tidak ada layanan tambahan tanpa ADR | Review PR |

## Status

**Disahkan** pada 27 November 2026 sebagai dasar implementasi P14, sesuai tuntutan Gate 2 "ADR tech stack tertulis dan disetujui CEO".

| Peran | Nama | Tindakan | Tanggal |
|---|---|---|---|
| CEO / Product Owner | Hanan Rizqullah | Menyetujui | 27 November 2026 |
| Programmer | Muhammad Fazha Nararya Nugraha | Menyusun | 24 November 2026 |
| Network / DevOps | Mahesa Kanaka Raya | Meninjau | 24 November 2026 |

Catatan: pengesahan ini adalah keputusan internal tim. Penilaian Gate 2 tetap milik dosen.
