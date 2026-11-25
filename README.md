# SewaKampus Architecture Repository

Repositori kerja arsitektur dan MVP SewaKampus untuk sprint P13–P16, Kelas R001, Kelompok 1.

**Status:** 24 November 2026. P13 dan PR sebelum P14 selesai secara internal; Gate 1 belum dinilai dosen. Lima Must belum diimplementasikan.

## 1. Ringkasan status

| Kelompok | Status internal |
|---|---|
| P13 (15 butir) | 15/15 Selesai |
| PR sebelum P14 (8 butir) | 8/8 Selesai |
| P14–P16 (12 butir) | Belum; menunggu Gate 1 |
| Total matriks | 23 Selesai, 1 Ada, 3 Sebagian, 8 Belum |

Status “Selesai” berarti artefak lengkap, sudah direview silang internal (SK-024), dan diterima pemilik. Ini **bukan** penilaian dosen.

## 2. Dokumen yang paling sering dibuka

| Kebutuhan | File |
|---|---|
| Brief dan naskah Gate 1 | `06_Governance/P13-Gate-1-Brief.md` |
| Checklist Gate 1 | `06_Governance/P13-Gate-1-Checklist.md` |
| Papan kerja dan bukti | `07_Evidence/P13-Work-Board.md` |
| Bukti login dan role | `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md` |
| Triage keamanan | `07_Evidence/P14-Security-Audit-Triage.md` |
| Verifikasi database | `07_Evidence/PR14-04-DB-Verification-Run.md` |
| Handoff programmer | `08_Source/docs/PROGRAMMER-HANDOFF.md` |
| Cara menjalankan aplikasi | `08_Source/README.md` |
| Runbook stack lokal | `04_Technology/P13-Local-Stack-Runbook.md` |
| Diagram use case | `01_Business/P13-Use-Case-Diagram.png` |

## 3. Stack

Laravel 11, MySQL 8, Redis 7, MinIO, Keycloak 26 (OIDC + PKCE, Laravel sebagai BFF), Nginx, satu VPS Ubuntu dengan Docker Compose, Cloudflare, OpenAPI 3.1.

Lokal saat ini: Laravel 11.57.1, MySQL 8.0.43, Keycloak 26.4.0. Redis, MinIO, dan Nginx belum dijalankan pada scaffold.

## 4. Struktur repo

| Folder | Isi |
|---|---|
| `00_Vision/` | Vision v1.0 dan MoSCoW |
| `01_Business/` | BPMN, use case, user story, diagram use case, BMC |
| `02_Data/` | ERD, kamus data, bukti 3NF |
| `03_Application/` | struktur aplikasi, OpenAPI, wireframe, prototipe |
| `04_Technology/` | topologi, NFR, security baseline, hosting, runbook |
| `05_Opportunities/` | roadmap dan migration plan |
| `06_Governance/` | audit, keputusan, DoD, charter, traceability, Gate 1 |
| `07_Evidence/` | papan kerja, bukti uji, triage, notulen progres |
| `08_Source/` | aplikasi Laravel 11, database SQL, tema Keycloak |
| `09_Pitch/` | deck presentasi |

## 5. Menjalankan aplikasi

Panduan lengkap ada di `08_Source/README.md`. Ringkasnya:

```bash
cd 08_Source
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8000
```

Butuh MySQL 8, Keycloak 26, dan realm `sewakampus`. Test:

```bash
DB_PORT=3311 php artisan test
```

Hasil terakhir: 16 passed, 70 assertions.

## 6. Alur branch

- `main` dan `dev` adalah branch tetap.
- Pekerjaan baru lewat branch role:
  - `feature/ceo-governance`
  - `feature/analyst-usecase`
  - `feature/database-model`
  - `feature/programmer-app`
  - `feature/network-devops`
- Commit memakai akun GitHub masing-masing anggota, bukan identitas tim.
- Pull Request ke `dev`; `main` menerima merge dari `dev`.

Remote **publik**: `https://github.com/hanansj789/sewakampus`. Repo ini bisa dibuka siapa saja; jangan commit rahasia atau data pribadi.

## 7. Batas dan risiko

- Gate 1 belum dinilai dosen; jangan mengisi status Hijau/Kuning/Merah.
- Lima Must belum dibangun; implementasi menunggu Gate 1.
- Scaffold login memakai Keycloak dev mode, bukan konfigurasi production.
- `composer audit` masih menemukan 5 advisori Laravel 11; rincian dan kontrol ada di `07_Evidence/P14-Security-Audit-Triage.md`.
- UAT P15 memakai tiga peserta proksi internal, bukan mitra eksternal dan bukan mitra independen.
- Harga hosting memakai harga publik; enam butir biaya belum diverifikasi.

## 8. Dokumen di luar repo ini

`AGENTS.md`, `DECISIONS.md`, `P13-STATUS.md`, `P13-DELIVERABLE-MATRIX.md`, `CONTEXT-PACK.md`, `LAPORAN/`, `DESAIN/`, dan `Tanda Tangan Kelompok/` berada di folder induk `SEWAKAMPUS`, **tidak** ikut di repo GitHub ini. Tautan ke file tersebut tidak dapat dibuka dari GitHub.

Jika dokumen induk perlu ikut terlihat di GitHub, salin ke folder `00_Project/` dan perbarui tautannya. Jangan mengubah folder induk secara diam-diam.
