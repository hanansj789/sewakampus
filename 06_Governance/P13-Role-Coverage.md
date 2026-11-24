**Status:** Ada. Audit kesesuaian jobdesc P13 per role; Gate 1 belum dinilai.

# P13 — Kesesuaian Jobdesc per Role

**Tanggal:** 24 November 2026
**Dasar:** `Skenario_Project ASP R001.txt` hlm. 15
**Pemilik audit:** Hanan Rizqullah (CEO/PO)

Legenda:

- **Sesuai** — bukti ada dan cocok dengan yang diminta.
- **Sesuai dengan catatan** — terpenuhi, tetapi ada penyimpangan yang dicatat dan disetujui pemilik.
- **Belum** — belum ada bukti.

## 1. CEO / PO

| Yang diminta | Bukti | Status |
|---|---|---|
| Vision v1.0: problem, nilai, lingkup, 3 KPI | `00_Vision/P13-Vision-v1.0.md` | Sesuai |
| Prioritas MoSCoW | `00_Vision/P13-MoSCoW-Backlog.md` | Sesuai |
| Definition of Done tim | `06_Governance/P13-Definition-of-Done.md` | Sesuai |
| Team charter | `06_Governance/P13-Team-Charter.md`, `Tanda Tangan Kelompok/*.jpeg` | Sesuai dengan catatan: tanggal 23 Nov ditetapkan pemilik, tidak tercetak di gambar |
| Konfirmasi tertulis mitra: lingkup MVP dan jadwal UAT P15 | `07_Evidence/PR14-01-UAT-Partner-Plan.md` | Sesuai dengan catatan: memakai tiga peserta proksi internal, bukan mitra eksternal |
| Business Model Canvas | `01_Business/P13-BMC.drawio` + `.png` | Sesuai |

## 2. Analyst & UI/UX

| Yang diminta | Bukti | Status |
|---|---|---|
| BPMN to-be 2 proses utama | `01_Business/P13-BPMN-To-Be-Booking.drawio` + `.png`, `P13-BPMN-To-Be-Handover.drawio` + `.png` | Sesuai |
| Use case | `01_Business/P13-Use-Cases.md`, `P13-Use-Case-Diagram.drawio` + `.png` | Sesuai |
| 5–8 user story + kriteria penerimaan | `01_Business/P13-User-Stories.md` (8 story) | Sesuai |
| Wireframe | `03_Application/ux/SewaKampus-Wireframe.figcraft`, `exports/WF-01`–`WF-09` | Sesuai |
| Prototipe Figma hi-fi yang bisa diklik | `03_Application/ux/SewaKampus-High-Fidelity.figcraft`, `exports/L-01`–`L-07` | Sesuai dengan catatan: memakai FigCraft, bukan Figma (SK-019) |

## 3. Database

| Yang diminta | Bukti | Status |
|---|---|---|
| ERD konseptual → logis dari use case | `02_Data/P13-ERD.drawio` + `.png` (14 entitas, 17 relasi), `P13-ERD-Use-Case-Check.md` | Sesuai |
| Kamus data | `02_Data/P13-Data-Dictionary.md` (118 atribut) | Sesuai |
| Normalisasi sampai 3NF | `02_Data/P13-3NF-Proof.md` | Sesuai |
| DDL MySQL/PostgreSQL | `08_Source/database/sql/001_init.sql` (MySQL 8.0) | Sesuai untuk MySQL; PostgreSQL tidak dibuat karena stack menetapkan MySQL 8 |
| Data dummy realistis ≥30 baris per tabel master | `08_Source/database/sql/seed.sql`: 30 kategori, 30 pengguna, 30 barang | Sesuai setelah CR-006/SK-023 |

## 4. Programmer

| Yang diminta | Bukti | Status |
|---|---|---|
| Pola aplikasi (MVC) | `03_Application/P13-App-Structure.md`, `06_Governance/ADR-002-application-structure.md` | Sesuai |
| Struktur folder | `03_Application/P13-App-Structure.md`, `08_Source/` | Sesuai |
| Repo dengan branch main/dev/feature | repo `hanansj789/sewakampus`; `main`, `dev`, lima branch role | Sesuai |
| Proyek jalan di lokal: login + role | `08_Source/`, `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md` (16 test/70 assertion) | Sesuai |
| README cara menjalankan | `08_Source/README.md` | Sesuai |

## 5. Network / DevOps (+QA)

| Yang diminta | Bukti | Status |
|---|---|---|
| Topologi as-is & to-be di lokasi mitra | `04_Technology/P13-Topology-As-Is.md` (as-is kualitatif), `DESAIN/Phase D - SewaKampus.drawio` (to-be) | Sesuai dengan catatan: belum ada kunjungan/pengukuran lapangan; mitra adalah mahasiswa |
| Kebutuhan non-fungsional | `04_Technology/P13-NFR.md` | Sesuai |
| Notulen stand-up | `07_Evidence/P13-Standup-Minutes.md` | Sesuai dengan catatan: catatan progres asinkron per jobdesc, bukan risalah rapat |
| Dua opsi hosting beserta biaya | `04_Technology/P13-Hosting-Options.md` (empat opsi, termasuk Oracle Always Free $0) | Sesuai |
| Draf deployment diagram | `DESAIN/Deployment - SewaKampus.png` | Sesuai; file berada di luar repo GitHub |

## 6. Gap yang masih terbuka

| Gap | Dampak | Pemilik |
|---|---|---|
| Mitra UAT eksternal belum ada; peserta masih proksi internal | Hasil UAT tidak boleh disebut validasi mitra independen | Hanan |
| Topologi as-is belum diukur (bandwidth, latensi, perangkat) | Konteks UAT P15 belum lengkap | Mahesa |
| PostgreSQL tidak dibuat | Tidak masalah selama stack MySQL 8 dipertahankan | Fazha |
| Prototipe memakai FigCraft, bukan Figma | Risiko dosen menuntut Figma; sudah dicatat SK-019 | Fharel |
| 5 advisori Laravel 11 | Belum audit bersih; sudah ditriase | Fazha/Mahesa |
| Dokumen induk dan tanda tangan di luar repo | Tautan tidak bisa dibuka dari GitHub | Hanan |

## 7. Kesimpulan

Semua baris jobdesc P13 punya bukti. Empat baris memakai catatan yang sudah disetujui: tanggal tanda tangan, mitra proksi, FigCraft, topologi kualitatif, dan notulen progres. Tidak ada baris yang **Belum**.

Gate 1 tetap belum dinilai dosen; audit ini hanya memastikan isi repo sesuai jobdesc, bukan memberi status warna.
