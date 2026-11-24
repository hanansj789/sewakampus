**Status:** Ada. Catatan progres asinkron per jobdesc; bukan notulen rapat.

# P13-12 — Notulen Progres P13

**Pemilik:** Mahesa (Network/DevOps + notulis P13)
**Diperbarui:** 24 November 2026

## 1. Sifat catatan ini

Tidak ada rapat stand-up terjadwal pada P13. Pemilik proyek memutuskan bahwa notulen diisi sebagai **catatan progres pengerjaan jobdesc masing-masing anggota**, bukan sebagai risalah rapat (SK-021). Karena itu tidak ada kolom peserta hadir, jam mulai, atau keputusan rapat yang dikarang.

Isi di bawah diambil dari artefak yang bisa dibuka dan riwayat commit repository. Keputusan resmi tetap di `DECISIONS.md`.

## 2. Progres per anggota

### Hanan Rizqullah — CEO/PO, Analyst dan UI/UX formal

| Tanggal | Pekerjaan | Bukti |
|---|---|---|
| 23 Nov 2026 | Vision v1.0: masalah, nilai, lingkup, tiga KPI | `00_Vision/P13-Vision-v1.0.md` |
| 23 Nov 2026 | MoSCoW dan penguncian lima Must | `00_Vision/P13-MoSCoW-Backlog.md` |
| 23 Nov 2026 | Definition of Done dan Team Charter | `06_Governance/P13-Definition-of-Done.md`, `06_Governance/P13-Team-Charter.md` |
| 23 Nov 2026 | Traceability dan papan kerja | `06_Governance/P13-Traceability-Matrix.md`, `07_Evidence/P13-Work-Board.md` |
| 24 Nov 2026 | Keputusan CR-001 sampai CR-004 dan SK-019 sampai SK-021 | `SEWAKAMPUS/DECISIONS.md`, `06_Governance/CHANGE-REQUEST-LOG.md` |

### Fharel Sapvela Dwipa — System Analyst dan UI/UX pelaksana

| Tanggal | Pekerjaan | Bukti |
|---|---|---|
| 23 Nov 2026 | BPMN to-be booking dan handover–return | `01_Business/P13-BPMN-To-Be-Booking.drawio` + `.png`, `01_Business/P13-BPMN-To-Be-Handover.drawio` + `.png` |
| 23 Nov 2026 | Tujuh use case dan delapan user story | `01_Business/P13-Use-Cases.md`, `01_Business/P13-User-Stories.md` |
| 23 Nov 2026 | Wireframe sembilan layar | `03_Application/ux/SewaKampus-Wireframe.figcraft`, `03_Application/ux/exports/WF-*.png` |
| 23 Nov 2026 | Prototipe hi-fi tujuh layar dan Components | `03_Application/ux/SewaKampus-High-Fidelity.figcraft`, `03_Application/ux/exports/L-*.png` |
| 24 Nov 2026 | Diagram use case | `01_Business/P13-Use-Case-Diagram.drawio` + `.png` |

### Muhammad Fazha Nararya Nugraha — Programmer dan Database Architect

| Tanggal | Pekerjaan | Bukti |
|---|---|---|
| 23 Nov 2026 | Struktur aplikasi dan ADR-002 | `03_Application/P13-App-Structure.md`, `06_Governance/ADR-002-application-structure.md` |
| 23 Nov 2026 | ERD 14 entitas dan 17 relasi, bukti 3NF, kamus data | `02_Data/P13-ERD.drawio` + `.png`, `02_Data/P13-3NF-Proof.md`, `02_Data/P13-Data-Dictionary.md` |
| 23 Nov 2026 | Kontrak API dan endpoint sengketa pengguna | `03_Application/openapi.yaml` (CR-002) |
| 23 Nov 2026 | DDL, seed, dan uji di MySQL 8.0.43 | `08_Source/database/sql/001_init.sql`, `08_Source/database/sql/seed.sql`, `07_Evidence/PR14-04-DDL-Run-Log.md` |
| 24 Nov 2026 | Scaffold login OIDC dan role lokal | `08_Source/`, `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md` |

### Mahesa Kanaka Raya — Network/DevOps, QA, dan notulis

| Tanggal | Pekerjaan | Bukti |
|---|---|---|
| 23 Nov 2026 | NFR dan security baseline | `04_Technology/P13-NFR.md`, `04_Technology/P13-Security-Baseline.md` |
| 23 Nov 2026 | Opsi hosting dan draf deployment | `04_Technology/P13-Hosting-Options.md` |
| 24 Nov 2026 | Topologi as-is lingkungan mahasiswa | `04_Technology/P13-Topology-As-Is.md` |
| 23 Nov 2026 | Test case black-box dan rencana UAT | `07_Evidence/P14-Test-Cases.md`, `07_Evidence/P15-UAT-Plan.md` |
| 24 Nov 2026 | Catatan progres ini | `07_Evidence/P13-Standup-Minutes.md` |

## 3. Keputusan yang tercatat

| Tanggal | Keputusan | Nomor |
|---|---|---|
| 23 Nov 2026 | Lima Must dan pemisahan kontrol alur | SK-001, SK-002 |
| 23 Nov 2026 | Dua Must pertama untuk P14 | SK-003 |
| 23 Nov 2026 | Pembagian peran empat anggota | SK-004 |
| 24 Nov 2026 | Scaffold login sebelum penilaian Gate 1 | SK-020, CR-003 |
| 24 Nov 2026 | Review silang P13 dilewati, status Selesai (internal), mitra UAT mahasiswa | SK-021, CR-004 |

## 4. Hambatan yang masih terbuka

| Hambatan | Dampak | Pemilik |
|---|---|---|
| Belum ada nama peserta UAT dan tanggal pasti | PR14-01 belum bisa ditutup | Hanan |
| Angka bandwidth, latensi, dan komposisi perangkat belum diukur | Konteks UAT P15 belum lengkap | Mahesa |
| Remote GitHub dan akun belum ada | P16-03 belum bisa ditutup | Hanan |

## 5. Batas

- Catatan ini **bukan** bukti rapat. Tidak ada tanggal rapat, daftar hadir, atau notula sidang yang dikarang.
- Setiap baris menunjuk file yang bisa dibuka.
- Status P13-12 adalah Selesai (internal) sebagai catatan progres, sesuai SK-021.
