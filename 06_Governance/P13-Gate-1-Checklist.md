# Gate 1 Design Review — Checklist

**Status:** Siap diajukan (internal). Gate 1 belum dinilai dosen.
**Tanggal penilaian internal:** 24 November 2026
**Dasar resmi:** `Skenario_Project ASP R001.txt` hlm. 17.

Status internal yang dipakai di sini hanya tiga: **Siap diajukan**, **Bersyarat**, **Belum siap**. Kolom status resmi dosen sengaja kosong.

## A. Lima butir resmi TXT

| # | Butir | Bukti | Status internal | Yang kurang |
|---|---|---|---|---|
| 1 | Architecture Vision dibekukan sebagai v1.0 | `00_Vision/P13-Vision-v1.0.md` | Siap diajukan | Final internal 24 Nov 2026; tiga KPI diterima sebagai target; review silang telah dilakukan (SK-024) |
| 2 | Matriks ketelusuran ≥5 baris: kebutuhan → use case → tabel → layar | `06_Governance/P13-Traceability-Matrix.md` | Siap diajukan | Lima baris, kolom layar kini menunjuk layar yang benar-benar ada (S-01..S-09); sudah direview silang |
| 3 | ERD 3NF konsisten dengan use case | `02_Data/P13-ERD.drawio` (14 entitas, 17 relasi), `02_Data/P13-3NF-Proof.md`, `02_Data/P13-ERD-Use-Case-Check.md`, `07_Evidence/PR14-04-DDL-Run-Log.md` | Siap diajukan | ERD sudah memuat 17 relasi, pemeriksaan per use case selesai, DDL terbukti jalan di MySQL 8.0.43; sudah direview silang |
| 4 | Backlog MoSCoW, fitur Must maksimal 5 | `00_Vision/P13-MoSCoW-Backlog.md` | Siap diajukan | Lima Must dikunci dan backlog ditutup 24 Nov 2026 |
| 5 | Repo dan papan kerja aktif; tiap anggota punya kartu atau commit | `README.md`, `07_Evidence/P13-Work-Board.md`, remote privat | Siap diajukan | Repo aktif dengan `main`, `dev`, lima branch role, dan remote privat `hanansj789/sewakampus`; empat kartu terisi. Commit per anggota menyusul dari akun masing-masing |

## B. Tambahan internal sebelum P14

| # | Butir | Bukti | Status | Yang kurang |
|---|---|---|---|---|
| 6 | BPMN to-be dua proses utama | `01_Business/P13-BPMN-To-Be-Booking.drawio` + `.png`, `01_Business/P13-BPMN-To-Be-Handover.drawio` + `.png` | Siap diajukan | Dua proses dipisah dan dicocokkan dengan UC-03/UC-04; sudah direview silang |
| 7 | Use case, user story, acceptance criteria | `01_Business/P13-Use-Cases.md`, `01_Business/P13-User-Stories.md`, `01_Business/P13-Use-Case-Diagram.drawio` + `.png` | Siap diajukan | Tujuh use case, delapan story, dan diagram use case dengan aktor, batas sistem, «include», dan «extend» |
| 8 | Wireframe dan prototipe clickable | `03_Application/ux/exports/` (sembilan wireframe termasuk S-08/S-09, tujuh layar hi-fi), `03_Application/ux/SewaKampus-High-Fidelity.figcraft` | Siap diajukan | Sembilan layar wireframe dan tujuh layar hi-fi dengan enam interaksi klik; buka lewat FigCraft |
| 9 | API dan NFR konsisten dengan stack | `03_Application/openapi.yaml`, `04_Technology/P13-NFR.md` | Siap diajukan | Kontrak menerima foto kondisi (SK-014), NFR dan security baseline ada; validasi foto menunggu fitur M4 di P15 |
| 10 | Branch dan kartu anggota aktif | repo lokal dan remote | Siap diajukan | `main`, `dev`, dan lima branch role sudah di-push; `CODEOWNERS` tidak diwajibkan (SK-021); collaborator menunggu username (T-01) |
| 11 | Team Charter ditandatangani | `06_Governance/P13-Team-Charter.md`, bukti di `Tanda Tangan Kelompok/*.jpeg` | Siap diajukan | Empat gambar tanda tangan tersedia; tanggal 23 November 2026 ditetapkan pemilik, tidak tercetak pada gambar; identitas tidak diverifikasi secara kriptografis |
| 12 | Berkas pengetahuan bersama | `SEWAKAMPUS/AGENTS.md`, `DECISIONS.md`, `CONTEXT-PACK.md` | Siap diajukan | Isi lengkap dan diselaraskan 24 Nov 2026 |

## C. Kesimpulan

**Status resmi: belum ada keputusan dosen.**

Yang bisa dikatakan jujur saat ini: fondasi dokumen dan repo lokal sudah berdiri, lima Must sudah terkunci, audit 35 butir sudah selesai, use case, user story, dan diagram use case sudah ada, kontrak foto kondisi sudah diperbaiki, BPMN dua proses sudah dipisah, struktur aplikasi dan ADR-002 sudah ditulis, opsi hosting punya harga publik bertanggal, serta charter memiliki empat file bukti tanda tangan. DDL dan seed telah diuji di MySQL 8.0.43. Vision, MoSCoW, DoD, dan charter sudah final internal pada 24 November 2026. Yang masih belum: nama dan tanggal peserta UAT, penawaran biaya hosting, dan keputusan Gate 1 dari dosen.

Gate 1 belum dinilai dosen dan tidak diberi status warna. Review silang P13 telah dilakukan (SK-024); status "Selesai" adalah hasil review internal, bukan penilaian dosen. Scaffold PR14-06/07 sudah dikerjakan lebih dulu lewat pengecualian CR-003/SK-020; Must produk tetap belum boleh dibuat sebelum Gate 1 dinilai.

## D. Urutan penutupan yang disarankan

1. Isi nama dan tanggal tiga peserta UAT pada `07_Evidence/PR14-01-UAT-Partner-Plan.md`.
2. Minta dosen menilai Gate 1; jangan mengisi status warna sebelum keputusan dosen.
3. Setelah Gate 1 dinilai, mulai implementasi lima Must. Scaffold PR14-06/07 sudah selesai lebih dulu lewat CR-003/SK-020.
