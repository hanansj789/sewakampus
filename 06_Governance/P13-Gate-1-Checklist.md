# Gate 1 Design Review — Checklist

**Status:** Bersyarat. Belum siap diajukan ke dosen.
**Tanggal penilaian internal:** 24 November 2026
**Dasar resmi:** `Skenario_Project ASP R001.txt` hlm. 17.

Status internal yang dipakai di sini hanya tiga: **Siap diajukan**, **Bersyarat**, **Belum siap**. Kolom status resmi dosen sengaja kosong.

## A. Lima butir resmi TXT

| # | Butir | Bukti | Status internal | Yang kurang |
|---|---|---|---|---|
| 1 | Architecture Vision dibekukan sebagai v1.0 | `00_Vision/P13-Vision-v1.0.md` | Bersyarat | Masih draf; tiga KPI dan isi visi belum disetujui empat anggota |
| 2 | Matriks ketelusuran ≥5 baris: kebutuhan → use case → tabel → layar | `06_Governance/P13-Traceability-Matrix.md` | Siap diajukan | Lima baris, kolom layar kini menunjuk layar yang benar-benar ada (S-01..S-09); menunggu review silang |
| 3 | ERD 3NF konsisten dengan use case | `02_Data/P13-ERD.drawio` (14 entitas, 17 relasi), `02_Data/P13-3NF-Proof.md`, `02_Data/P13-ERD-Use-Case-Check.md`, `07_Evidence/PR14-04-DDL-Run-Log.md` | Siap diajukan | ERD sudah memuat 17 relasi, pemeriksaan per use case selesai, DDL terbukti jalan di MySQL 8.0.43; menunggu review silang |
| 4 | Backlog MoSCoW, fitur Must maksimal 5 | `00_Vision/P13-MoSCoW-Backlog.md` | Bersyarat | Lima Must sudah dikunci, tetapi backlog belum direview anggota |
| 5 | Repo dan papan kerja aktif; tiap anggota punya kartu atau commit | `README.md`, `07_Evidence/P13-Work-Board.md` | Bersyarat | Repo lokal aktif dengan branch `main` dan `dev`, tanpa remote; kartu ada empat; commit per anggota belum ada |

## B. Tambahan internal sebelum P14

| # | Butir | Bukti | Status | Yang kurang |
|---|---|---|---|---|
| 6 | BPMN to-be dua proses utama | `01_Business/P13-BPMN-To-Be-Booking.drawio` + `.png`, `01_Business/P13-BPMN-To-Be-Handover.drawio` + `.png` | Siap diajukan | Dua proses dipisah dan dicocokkan dengan UC-03/UC-04; menunggu review silang |
| 7 | Use case, user story, acceptance criteria | `01_Business/P13-Use-Cases.md`, `01_Business/P13-User-Stories.md` | Bersyarat | Tujuh use case dan delapan story sudah ada dengan acceptance criteria; belum direview silang |
| 8 | Wireframe dan prototipe clickable | `03_Application/ux/exports/` (sembilan wireframe termasuk S-08/S-09, tujuh layar hi-fi), `03_Application/ux/SewaKampus-High-Fidelity.figcraft` | Siap diajukan | Sembilan layar wireframe dan tujuh layar hi-fi dengan enam interaksi klik; buka lewat FigCraft |
| 9 | API dan NFR konsisten dengan stack | `03_Application/openapi.yaml`, `04_Technology/P13-NFR.md` | Bersyarat | Kontrak sudah menerima foto kondisi (SK-014) dan NFR sudah ada; validasi foto belum diuji karena kode belum ada |
| 10 | Branch, CODEOWNERS, dan kartu anggota aktif | repo lokal | Bersyarat | `main`, `dev`, dan tiga `feature/*` lokal ada; `CODEOWNERS` hanya komentar karena username GitHub belum ada (SK-005) |
| 11 | Team Charter ditandatangani | `06_Governance/P13-Team-Charter.md`, bukti di `Tanda Tangan Kelompok/*.jpeg` | Siap diajukan | Empat gambar tanda tangan tersedia; tanggal tidak tercantum, dan identitas tidak diverifikasi secara kriptografis |
| 12 | Berkas pengetahuan bersama | `SEWAKAMPUS/AGENTS.md`, `DECISIONS.md`, `CONTEXT-PACK.md` | Bersyarat | Isi lengkap; belum dibaca ulang empat anggota |

## C. Kesimpulan

**Status resmi: belum ada keputusan dosen.**

Yang bisa dikatakan jujur saat ini: fondasi dokumen dan repo lokal sudah berdiri, lima Must sudah terkunci, audit 35 butir sudah selesai, use case dan user story sudah ada, kontrak foto kondisi sudah diperbaiki, BPMN dua proses sudah dipisah, struktur aplikasi dan ADR-002 sudah ditulis, opsi hosting punya harga publik bertanggal, serta charter memiliki empat file bukti tanda tangan. DDL dan seed telah diuji di MySQL 8.0.43. Yang masih belum: persetujuan Vision dan MoSCoW, review artefak, konfirmasi mitra, dan keputusan Gate 1 dari dosen.

Gate 1 belum dinilai dosen dan tidak diberi status warna. Pemilik meminta review silang dilewati untuk kerja lokal; karena tidak ada reviewer berbeda, artefak tetap berstatus menunggu review dan tidak diklaim telah direview. Butir 11 kini siap diajukan berdasarkan empat berkas tanda tangan, dengan tanggal tidak tercantum. Sesuai `AGENTS.md`, PR14-06 (kode login + role) dan README run belum boleh dibuat sampai Gate 1 dinilai dosen.

## D. Urutan penutupan yang disarankan

1. Minta persetujuan Vision dan MoSCoW dari empat anggota.
2. Minta dosen menilai Gate 1; jangan mengisi status warna sebelum keputusan dosen.
3. Setelah Gate 1 dinilai, mulai kode fitur PR14-06/07 sesuai hasil gate.
