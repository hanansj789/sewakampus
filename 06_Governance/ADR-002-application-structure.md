**Status:** Draf — diusulkan Session 2, belum direview anggota lain.

# ADR-002 — Struktur Aplikasi: Modular Monolith Laravel 11

**Tanggal:** 23 November 2026
**Pengusul:** Fazha (Programmer + Database Architect)
**Menjawab:** P13-09, "Pola aplikasi, struktur folder, strategi branch"
**Rujukan struktur:** `03_Application/P13-App-Structure.md`

## Catatan penomoran

ADR ini bernomor **002** karena path-nya sudah ditetapkan di `P13-STATUS.md` §5 langkah 2. **ADR-001 (keputusan tech stack) belum ada**; dokumen itu menjadi bagian P14-01 dan akan ditulis pada P14. Nomor 001 sengaja tidak dipakai untuk hal lain agar tidak terjadi tabrakan nomor.

## Konteks

- Stack sudah dikunci pada `DECISIONS.md` dan `P13-STATUS.md` §4: Laravel 11, MySQL 8, Redis 7, MinIO, Keycloak 26, Nginx, satu VPS Docker Compose, Cloudflare.
- Tim empat orang, satu di antaranya programmer utama; waktu efektif P13–P16 lima pertemuan.
- Kontrak API sudah kanonik di `03_Application/openapi.yaml` (33 path, 38 operasi, sepuluh tag).
- Dua Must pertama (P14) adalah listing dan kalender ketersediaan, lalu booking, handover, dan review.
- Laporan lama sudah memakai istilah "modular monolith" pada §3.4.2 dan `TRD.md`, tetapi belum ada aturan batas modul yang bisa diperiksa.

## Keputusan

Aplikasi dibangun sebagai **modular monolith** dalam satu proyek Laravel 11:

1. Satu aplikasi, satu deployment, satu database.
2. Kode dibagi menjadi modul di `app/Modules/<Nama>` dengan empat lapisan tetap: `Http`, `Domain`, `Application`, `Infrastructure`.
3. Setiap modul mendaftarkan route, binding, dan event listener-nya lewat service provider modul.
4. Batas antar-modul hanya lewat `Domain/Contracts` (antarmuka PHP) dan event domain. Tidak ada relasi Eloquent lintas modul.
5. Branch: `main`, `dev`, `feature/*`, `docs/*`, `fix/*`; PR ke `dev`.

## Alternatif yang ditolak

| Alternatif | Alasan ditolak |
|---|---|
| Microservices per modul | Enam layanan untuk satu VPS 4 vCPU/8 GB; menambah gateway internal, tracing, dan deployment per layanan tanpa kebutuhan yang bisa diuji pada P13–P16 |
| Laravel monolith datar (`app/Http`, `app/Models` semua di satu tempat`) | Cepat di awal, tetapi batas tanggung jawab hilang dan traceability ke use case sulit dibuktikan di Gate 1 |
| Satu package Composer per modul (monorepo) | Perlu registrasi repositori lokal dan rilis versi; tidak sepadan untuk tim kecil |
| Modular monolith dengan DDD penuh (bounded context, agregat eksplisit) | Terlalu banyak lapisan untuk 14 tabel dan lima Must; tim belum punya pengalaman menerapkannya |

## Konsekuensi

**Positif**

- Satu perintah `php artisan test`, satu pipeline, satu deployment; cocok dengan Docker Compose satu VPS.
- Batas modul bisa diperiksa saat review dan menghasilkan traceability modul → use case → tag OpenAPI.
- Modul bisa dipisah menjadi layanan sendiri nanti tanpa menulis ulang domain, karena komunikasi sudah lewat Contract dan event.

**Negatif / risiko**

- Disiplin manual: tanpa aturan statis, seorang anggota bisa mengimpor model modul lain. Mitigasi: aturan review di `P13-App-Structure.md` §5 dan rencana aturan PHP_CodeSniffer pada P14.
- Migrasi tetap satu folder, sehingga konflik nama tabel harus diselesaikan lewat prefiks modul.
- Satu database berarti satu titik kegagalan; sudah dicatat sebagai risiko pada laporan §3.5.5.

## Kepatuhan

| Aturan | Cara diperiksa |
|---|---|
| Tidak ada impor lintas modul selain `Domain/Contracts` | Review PR + grep namespace saat review |
| Setiap endpoint OpenAPI punya test | Daftar periksa P14 sebelum Gate 2 |
| Foto kondisi wajib | Feature test 422 saat `photo` kosong (SK-014) |
| Branch dan awalan commit | `CONTRIBUTING.md`, diperiksa saat PR |

## Status

Draf. Menunggu review Fazha–Mahesa dan persetujuan Hanan sebagai PO sebelum dipakai sebagai dasar kode P14. Tidak mengubah keputusan resmi mana pun di `DECISIONS.md`.
