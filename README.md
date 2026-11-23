# SewaKampus Architecture Repository

Repositori kerja arsitektur dan MVP SewaKampus untuk sprint P13–P16, Kelas R001, Kelompok 1.

## Sumber aturan

Urutan kekuatan aturan, dari tertinggi:

1. `PROYEK/GROWPATH/Skenario_Project ASP R001.txt` — tugas dosen. Jika ada dokumen lain yang berbeda, file ini yang menang.
2. `PROYEK/SEWAKAMPUS/HANDOFF-PROMPT-P13-P16.md` — turunan aturan dan keputusan tim.
3. `PROYEK/SEWAKAMPUS/ARCHITECTURE_REPOSITORY/06_Governance/P13-GAP-DECISIONS.md` — keputusan yang disetujui pemilik proyek.
4. Laporan `Progres Pertemuan 12` — baseline rancangan Phase A–F, bukan aturan.

Konflik yang belum diputuskan dicatat di `06_Governance/P13-GAP-DECISIONS.md` dan tidak diselesaikan diam-diam.

## Struktur

| Folder | Isi | Status Session 1 |
|---|---|---|
| `00_Vision/` | Vision v1.0, MoSCoW | Draf, menunggu persetujuan |
| `01_Business/` | BPMN to-be, use case, user story, BMC | Kosong |
| `02_Data/` | ERD 3NF, kamus data, bukti normalisasi | Kosong |
| `03_Application/` | struktur aplikasi, OpenAPI, wireframe, prototipe | Kosong |
| `04_Technology/` | topologi, NFR, security baseline, hosting, TCO | Kosong |
| `05_Opportunities/` | roadmap dan migration plan | Kosong |
| `06_Governance/` | audit, keputusan, DoD, charter, traceability, checklist gate | Terisi sebagian |
| `07_Evidence/` | papan kerja, notulen, bukti uji | Papan kerja |
| `08_Source/` | kode aplikasi Laravel 11 | Belum ada kode |
| `09_Pitch/` | deck presentasi | Kosong |

Laporan Word 44 halaman dan PDF lama tetap di `SEWAKAMPUS/LAPORAN`, tidak disalin ke sini.

## Status artefak

Setiap artefak wajib memakai salah satu label ini di baris pertamanya:

- **Ada** — file lengkap dan bisa dipakai.
- **Draf** — isinya ada, tetapi belum disetujui atau belum lengkap.
- **Belum** — belum dibuat.
- **Belum diverifikasi** — bergantung pada pihak luar atau data yang tidak ada di repo.

Path tujuan di dokumen perencanaan bukan bukti. Klaim "Ada" hanya sah jika filenya ada di repo ini.

## Cara kerja

1. Baca `00 - KONTEKS PROYEK.md` di `SEWAKAMPUS/`, lalu `06_Governance/P13-GAP-DECISIONS.md`.
2. Ambil satu kartu di `07_Evidence/P13-Work-Board.md`.
3. Kerjakan artefak, tulis label status di baris pertama.
4. Minta review anggota lain sebelum menyatakan selesai.
5. Catat keputusan baru di `06_Governance/P13-GAP-DECISIONS.md`.

Aturan branch, commit, dan review ada di `CONTRIBUTING.md`.

## Keadaan repo saat ini

- Git lokal aktif, branch `main`, **tanpa remote**. GitHub ditunda sampai artefak P13 dan PR sebelum P14 selesai.
- Belum ada kode aplikasi. `08_Source/` masih kerangka folder.
- Gate 1 belum dinilai dosen. Lihat `06_Governance/P13-Gate-1-Checklist.md`.
