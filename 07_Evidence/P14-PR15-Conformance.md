**Status:** Ada. Kesesuaian P14 dan PR sebelum P15, 27 November 2026.
**Dasar:** `Skenario_Project ASP R001.txt` hlm. 24 dan 27.

# P14 dan PR sebelum P15 — Kesesuaian

Dokumen ini menjawab satu hal: dari tabel jobdesc P14 dan PR sebelum P15, mana yang benar-benar selesai, mana yang belum, dan buktinya di mana. Gate 2 belum dinilai dosen.

## 1. P14 di kelas

| Peran | Tuntutan | Status | Bukti | Yang kurang |
|---|---|---|---|---|
| CEO (+QA) | ADR tech stack bersama Programmer dan Network | **Selesai** | `06_Governance/ADR-001-tech-stack.md` disahkan 27 Nov 2026 | — |
| CEO (+QA) | Ubah Kartu Kejutan menjadi CR | **Menunggu kelas** | `06_Governance/P14-Kartu-Kejutan-Worksheet.md` | Kartu baru dibagikan saat briefing |
| CEO (+QA) | Uji 2 fitur pertama | **Belum** | hasil uji otomatis ada, catatan QA formal belum | Catatan uji manual CEO untuk M1 dan M2 |
| Analyst | ≥15 test case black-box | **Selesai** | `07_Evidence/P14-Test-Run.xlsx` (15 kasus) | — |
| Analyst | Cek UI implementasi vs prototipe | **Belum** | prototipe ada di `03_Application/ux/`, tangkapan staging ada | Perbandingan S-01 sampai S-05 |
| Database | Implementasi DB: PK, FK, unique, check, indeks, view | **Selesai** | `001_init.sql`, `PR14-04-DDL-Run-Log.md`, `003_procedures.sql` | — |
| Database | Pair dengan Programmer | **Selesai secara peran** | SK-004: Database dan Programmer dipegang anggota yang sama (Fazha), sehingga pairing berlangsung dalam satu orang dan direview Mahesa | Catatan sesi pair tertulis |
| Programmer | 2 fitur Must end-to-end | **Selesai** | `P14-M1-Run.md`, `P14-M2-Run.md` | — |
| Programmer | Merge lewat PR yang direview | **Selesai** | PR #20, #22 direview Hanan | — |
| Network | Topologi final + IP plan | **Selesai** | `04_Technology/P14-IP-Plan.md` | — |
| Network | Deployment diagram | **Selesai** | `04_Technology/P14-Deployment-Final.md` | — |
| Network | Checklist keamanan | **Selesai** | `04_Technology/P14-Security-Checklist.md` | — |
| Network | Deploy ke staging | **Selesai** | `07_Evidence/P14-Staging-Deploy.md` | — |

## 2. PR sebelum P15

| Peran | Tuntutan | Status | Bukti | Yang kurang |
|---|---|---|---|---|
| CEO | Gap analysis per domain | **Selesai** | `05_Opportunities/P15-Gap-Analysis.md` (20 butir) | — |
| CEO | Jadwal UAT P15 terkonfirmasi | **Belum** | belum ada konfirmasi mitra atau tanggal | Tanggal dan peserta |
| Analyst | Skenario UAT + SUS 10 butir | **Selesai** | `07_Evidence/P15-UAT-Plan.md`, `P15-SUS-Template.xlsx` | — |
| Database | Transaksi/stored procedure proses kritis | **Selesai** | `003_procedures.sql`, `P15-DB-Procedures.md` | Prosedur belum dipanggil aplikasi |
| Database | Skrip backup | **Selesai** | `database/backup/backup.sh`, `P15-Restore-Test.md` | Backup belum terjadwal dan belum offsite |
| Programmer | Fitur Must ke-3 dan ke-4 | **Selesai** | `P14-M3-Run.md`, `P14-M4-Run.md`, PR #26, #28 | — |
| Programmer | Dokumentasi route/endpoint | **Sedang dikerjakan** | `03_Application/Route-Endpoint.md` | — |
| Network | Estimasi TCO 12 bulan | **Selesai** | `04_Technology/P15-TCO.md` | Enam komponen belum diverifikasi |

## 3. DoD Gate 2

| Butir | Status | Bukti |
|---|---|---|
| Demo 2 Must end-to-end, database nyata | Siap | M1 dan M2, staging hidup |
| ADR tech stack disetujui CEO | Selesai | ADR-001 bagian Status |
| Topologi + deployment final, staging | Selesai | IP plan, deployment final, bukti staging |
| CR Kartu Kejutan terdokumentasi | Menunggu kelas | Worksheet siap |
| Tidak ada anggota nol kontribusi | Selesai | PR per anggota: Hanan, Fazha, Mahesa, Fharel (#36, #51) |

## 4. Sisa pekerjaan, berurutan

| # | Pekerjaan | Pemilik | Ukuran |
|---|---|---|---|
| 1 | Dokumentasi route/endpoint | Fazha | sedang, dikerjakan sekarang |
| 2 | Catatan QA CEO untuk M1 dan M2 | Hanan | kecil |
| 3 | Perbandingan UI S-01 sampai S-05 dengan prototipe | Fharel | sedang |
| 4 | Konfirmasi tanggal dan peserta UAT | Hanan | butuh pihak luar |
| 5 | Isi CR Kartu Kejutan saat kelas | Hanan | kecil, saat briefing |

Setelah lima ini, P14 dan PR sebelum P15 selesai secara internal. Gate 2 tetap menunggu penilaian dosen.
