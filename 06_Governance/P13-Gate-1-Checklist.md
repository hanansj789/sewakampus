# Gate 1 Design Review — Checklist

**Status:** Bersyarat. Belum siap diajukan ke dosen.
**Tanggal penilaian internal:** 23 November 2026
**Dasar resmi:** `Skenario_Project ASP R001.txt` hlm. 17.

Status internal yang dipakai di sini hanya tiga: **Siap diajukan**, **Bersyarat**, **Belum siap**. Kolom status resmi dosen sengaja kosong.

## A. Lima butir resmi TXT

| # | Butir | Bukti | Status internal | Yang kurang |
|---|---|---|---|---|
| 1 | Architecture Vision dibekukan sebagai v1.0 | `00_Vision/P13-Vision-v1.0.md` | Bersyarat | Masih draf; tiga KPI dan isi visi belum disetujui empat anggota |
| 2 | Matriks ketelusuran ≥5 baris: kebutuhan → use case → tabel → layar | `06_Governance/P13-Traceability-Matrix.md` | Bersyarat | Lima baris ada, tetapi kolom use case dan layar masih "Belum" |
| 3 | ERD 3NF konsisten dengan use case | `DESAIN/ERD - SewaKampus.drawio`, `DESAIN/Logical Data Model - SewaKampus.drawio` | Belum siap | Bukti 3NF per entitas belum ada; ERD belum diuji terhadap use case yang belum dibuat |
| 4 | Backlog MoSCoW, fitur Must maksimal 5 | `00_Vision/P13-MoSCoW-Backlog.md` | Bersyarat | Lima Must sudah dikunci, tetapi backlog belum direview anggota |
| 5 | Repo dan papan kerja aktif; tiap anggota punya kartu atau commit | `README.md`, `07_Evidence/P13-Work-Board.md` | Bersyarat | Repo lokal aktif tanpa remote; kartu ada empat; commit per anggota belum ada |

## B. Tambahan internal sebelum P14

| # | Butir | Bukti | Status | Yang kurang |
|---|---|---|---|---|
| 6 | BPMN to-be dua proses utama | belum ada | Belum siap | Proses booking dan handover–return belum dipisah |
| 7 | Use case, user story, acceptance criteria | belum ada | Belum siap | Belum ditulis |
| 8 | Wireframe dan prototipe clickable | belum ada | Belum siap | Belum dibuat |
| 9 | API dan NFR konsisten dengan stack | `DESAIN/openapi.yaml` | Belum siap | Request handover belum menerima foto; NFR belum ada dokumen |
| 10 | Branch, CODEOWNERS, dan kartu anggota aktif | repo lokal | Belum siap | `dev` dan `feature/*` belum dibuat; CODEOWNERS menunggu akun GitHub |
| 11 | Team Charter ditandatangani | `06_Governance/P13-Team-Charter.md` | Belum siap | Kolom tanda tangan masih kosong |

## C. Kesimpulan

**Status resmi: belum ada keputusan dosen.**

Yang bisa dikatakan jujur saat ini: fondasi dokumen dan repo lokal sudah berdiri, lima Must sudah terkunci, dan audit 35 butir sudah selesai. Yang belum: seluruh artefak teknis P13 dan tanda tangan tim.

Gate 1 belum boleh disebut hijau. Jika dipresentasikan hari ini, butir 1, 2, 4, dan 5 bersifat bersyarat, sedangkan butir 3 gagal.

## D. Urutan penutupan yang disarankan

1. Tanda tangan Team Charter dan persetujuan Vision oleh empat anggota.
2. BPMN dua proses, use case, user story, dan wireframe.
3. Perbaikan kontrak API untuk foto kondisi.
4. ERD 3NF dan bukti normalisasi.
5. Isi kolom use case dan layar di traceability.
6. Review silang, lalu ajukan Gate 1 ke dosen.
