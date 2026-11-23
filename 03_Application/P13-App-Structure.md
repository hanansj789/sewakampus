**Status:** Draf — ditulis Session 2, belum direview anggota lain.

# P13-09 — Struktur Aplikasi SewaKampus

**Tanggal:** 23 November 2026
**Pemilik:** Fazha (Programmer + Database Architect)
**Keputusan terkait:** SK-001 (lima Must), SK-003 (P14: listing dan kalender), SK-015 (kontrak API kanonik), SK-014 (foto kondisi wajib)
**ADR:** `06_Governance/ADR-002-application-structure.md`

## 1. Tujuan

Dokumen ini menetapkan pola aplikasi, pembagian modul, struktur folder, dan aturan branch sesuai tugas P13 hlm. 15 kolom Programmer: "Pola aplikasi (mis. MVC); struktur folder; repo dengan branch main/dev/feature".

Dokumen ini **tidak** berisi kode fitur. Sesuai `AGENTS.md`, kode fitur baru ditulis setelah Gate 1 dinilai dosen.

## 2. Keputusan

Satu aplikasi Laravel 11 (PHP 8.3) berbentuk **modular monolith**: satu deployment, satu database MySQL 8, tetapi kode dibagi menjadi modul dengan batas namespace dan kontrak yang jelas. Modul tinggal di `app/Modules/<Nama>` dan didaftarkan oleh service provider masing-masing.

Alasan singkat: tim empat orang, satu VPS, dan tenggat P13–P16. Microservices menambah biaya operasional tanpa manfaat yang bisa diuji pada lima Must.

## 3. Struktur folder

```
sewakampus/
├── app/
│   ├── Modules/
│   │   ├── Identity/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   └── Requests/
│   │   │   ├── Domain/
│   │   │   │   ├── Models/
│   │   │   │   ├── Actions/
│   │   │   │   └── Contracts/          # antarmuka publik modul
│   │   │   ├── Infrastructure/
│   │   │   │   ├── Repositories/
│   │   │   │   └── Keycloak/
│   │   │   ├── Tests/
│   │   │   └── IdentityServiceProvider.php
│   │   ├── Catalog/
│   │   ├── Search/
│   │   ├── Booking/
│   │   ├── Deposit/
│   │   ├── Handover/
│   │   ├── Review/
│   │   ├── Moderation/
│   │   ├── Notification/
│   │   └── Analytics/
│   ├── Providers/AppServiceProvider.php
│   └── Support/                        # helper lintas modul: ULID, uang, waktu
├── bootstrap/app.php                   # routing, middleware, exception Laravel 11
├── config/
├── database/
│   ├── migrations/                     # satu folder, nama tabel berprefiks modul
│   ├── seeders/
│   └── sql/001_init.sql, seed.sql      # sumber DDL yang sudah ada
├── docker/                             # Nginx, PHP-FPM, Keycloak, MySQL, Redis, MinIO
├── public/
├── resources/                          # Blade/JS untuk web penyewa, pemilik, admin
├── routes/
│   ├── web.php
│   └── console.php
├── storage/
└── tests/
```

Modul mendaftarkan route-nya sendiri lewat service provider (pola yang sama dengan `bootstrap/providers.php` pada dokumentasi Laravel 11), sehingga `routes/web.php` hanya memuat route halaman, bukan route API.

Setiap modul memakai empat lapisan yang sama:

| Lapisan | Isi | Aturan |
|---|---|---|
| `Http` | Controller dan FormRequest | Hanya validasi, otorisasi, dan memanggil satu Action |
| `Domain` | Model Eloquent, Action (satu use case satu kelas), Contract | Tidak boleh memanggil Http |
| `Application` | Service yang mengoordinasikan beberapa Action atau modul | Opsional; dipakai bila satu use case menyentuh dua modul |
| `Infrastructure` | Repository, klien eksternal (Keycloak, MinIO, SMTP) | Implementasi Contract |

## 4. Daftar modul

Sepuluh modul mengikuti Functional Decomposition (laporan §3.3.2) dan diagram `DESAIN/Modul Aplikasi - SewaKampus.png`.

| # | Modul | Tanggung jawab | Tabel utama | Tag OpenAPI | Must |
|---|---|---|---|---|---|
| 1 | Identity | Registrasi, login lewat Keycloak, profil, peran | `users` | `Auth` | prasyarat |
| 2 | Verification | Unggah KTM, antrean verifikasi, keputusan admin | `student_verifications` | `Verification` | kontrol alur |
| 3 | Catalog | Barang, kategori, foto, harga, deposit, kalender ketersediaan | `items`, `item_categories`, `item_photos`, `item_availabilities` | `Catalog` | M1, M2 |
| 4 | Search | Filter kategori, tanggal, lokasi; urutan hasil | — (baca Catalog) | `Search` | M2 |
| 5 | Booking | Pengajuan, persetujuan, penolakan, pembatalan, riwayat status | `bookings`, `booking_status_histories` | `Booking` | M3 |
| 6 | Deposit | Deposit simulasi, tahan, refund, potong | `deposits` | `Deposit` | Should (menopang M3) |
| 7 | Handover | Serah terima OUT dan RETURN, foto kondisi wajib, konfirmasi dua pihak | `handovers` | `Handover` | M4 |
| 8 | Review | Rating 1–5, komentar, agregat reputasi | `reviews` | `Review` | M5 |
| 9 | Moderation | Verifikasi KTM, moderasi listing, sengketa, audit akses | `disputes` | `Admin` | kontrol alur |
| 10 | Notification | Email dan notifikasi in-app lewat antrean | `notifications` | `Notification` | pendukung |
| 11 | Analytics | Ringkasan transaksi dan pengguna, ekspor | — (baca saja) | `Admin` | pendukung |

Empat belas tabel pada `001_init.sql` terbagi ke modul di atas ditambah `audit_logs` yang dimiliki Moderation. Tidak ada tabel tanpa pemilik modul.

Peta modul ke use case: M1 = UC-01 (Catalog), M2 = UC-02 (Catalog + Search), M3 = UC-03 (Booking + Deposit), M4 = UC-04 (Handover), M5 = UC-05 (Review), kontrol alur UC-06 (Verification) dan UC-07 (Moderation).

## 5. Batas antar-modul

1. **Satu tabel, satu modul pemilik.** Modul lain membaca lewat Contract modul pemilik, bukan `Model::query()` langsung. Contoh: Booking memanggil `Catalog\Domain\Contracts\ItemAvailability` untuk memeriksa tanggal.
2. **Contract adalah antarmuka PHP** di `Domain/Contracts`, diikat ke implementasi di service provider modul. Mengganti implementasi tidak boleh mengubah modul pemanggil.
3. **Tidak ada relasi Eloquent lintas modul.** Relasi hanya di dalam modul. Data lintas modul digabung di Application service atau lewat query khusus.
4. **Kejadian lintas modul memakai event domain** (mis. `BookingApproved`, `HandoverConfirmed`), didengar modul Notification dan Analytics. Pengirim tidak tahu siapa pendengarnya.
5. **Tidak ada impor namespace modul lain kecuali `Domain/Contracts`.** Aturan ini diperiksa saat review PR dan bisa ditegakkan dengan aturan PHP_CodeSniffer buatan sendiri pada P14.
6. **Migrasi bernama tabel, bukan bernama modul.** Satu folder `database/migrations` agar urutan `php artisan migrate` deterministik.

## 6. Alur permintaan

```
Browser → Cloudflare → Nginx (TLS, rate limit, validasi JWT Keycloak)
        → Laravel route /api/v1
        → Modul: Controller → FormRequest → Action → Contract/Repository → MySQL
        → Event domain → Queue worker (email, notifikasi, audit)
```

Unggahan foto kondisi (SK-014) dan foto KTM tidak melewati JSON: keduanya `multipart/form-data`, divalidasi di FormRequest (`image`, maksimum ukuran, tipe MIME), lalu disimpan ke bucket **privat** MinIO/S3. URL yang dikembalikan adalah signed URL berumur pendek, bukan URL publik.

## 7. Uji per modul

- Unit test untuk Action dan aturan status booking (`PENDING` → `APPROVED`/`REJECTED`, tanpa lompatan status).
- Feature test per modul untuk endpoint yang tercantum di `03_Application/openapi.yaml`.
- Test kontrak: setiap endpoint di OpenAPI punya minimal satu feature test sebelum P14.
- Uji foto: unggahan handover tanpa `photo` harus 422 (bukti SK-014).

Test tinggal di `app/Modules/<Nama>/Tests` dan didaftarkan di `phpunit.xml` agar `php artisan test` tetap satu perintah.

## 8. Aturan branch dan commit

Mengikuti `ARCHITECTURE_REPOSITORY/CONTRIBUTING.md`, ditegaskan di sini:

| Branch | Fungsi | Aturan |
|---|---|---|
| `main` | Rilis dan submission | Tidak boleh commit langsung; hanya merge dari `dev` |
| `dev` | Integrasi | Tidak boleh commit langsung; menerima PR |
| `feature/<modul>-<ringkas>` | Fitur aplikasi | Satu modul per branch; contoh `feature/booking-approval` |
| `docs/<ringkas>` | Artefak arsitektur | Contoh `docs/p13-session2-bpmn-app-hosting` |
| `fix/<ringkas>` | Perbaikan | Bercabang dari `dev` |

- PR selalu ke `dev`; minimal satu reviewer selain penulis.
- Awalan commit sesuai folder: `[App]`, `[Business]`, `[Data]`, `[Tech]`, dst.
- Remote GitHub belum ada (SK-005). Branch `feature/*` dibuat lokal pada P14.

## 9. Yang sengaja tidak dilakukan

- Microservices, service mesh, atau Kubernetes: satu VPS, empat orang, tidak ada beban yang menuntutnya.
- Satu package Composer per modul: menambah overhead rilis tanpa manfaat pada MVP.
- Repository pattern di semua modul: hanya dipakai bila modul menyentuh layanan eksternal.
- Lapisan DTO/assembler terpisah: FormRequest dan Resource Laravel sudah cukup.

## 10. Rujukan

- Laravel 11, *Directory Structure* dan *Service Providers*: https://laravel.com/docs/11.x/structure
- `ARCHITECTURE_REPOSITORY/03_Application/openapi.yaml` (33 path, tag per modul)
- `ARCHITECTURE_REPOSITORY/08_Source/database/sql/001_init.sql` (14 tabel)
- `DESAIN/Modul Aplikasi - SewaKampus.png` (10 modul, dependensi runtime)
- `LAPORAN/Progres Pertemuan 12 - Kelompok 1 - SewaKampus.docx` §3.3.2 dan §3.4.2
