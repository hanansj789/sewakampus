# Definition of Done — SewaKampus

**Status:** Final (internal), 23 November 2026. Disetujui tim; review silang telah dilakukan (SK-024).
**Tanggal:** 23 November 2026

"DoD" di sini dipakai pada tiga tingkat: artefak, fitur, dan gate.

## 1. Definition of Done untuk artefak

Sebuah artefak dianggap selesai jika seluruh butir berikut terpenuhi.

- [ ] File ada di path yang tercantum di `06_Governance/P13-ASSET-MAP.md`.
- [ ] Baris pertama memuat label status: Ada, Draf, Belum, atau Belum diverifikasi.
- [ ] Isinya bisa dipakai orang lain tanpa bertanya ke penulis.
- [ ] Setiap angka, nama, tanggal, atau kutipan punya sumber yang bisa dibuka.
- [ ] Tidak ada placeholder seperti `TBD`, `Lorem`, atau `nama-mitra`.
- [ ] Sudah direview minimal satu anggota lain, dan nama reviewer tercatat. Review silang P13 dilakukan 24 November 2026 (SK-024).
- [ ] Tautan relatif di dalam repo tidak rusak.

## 2. Definition of Done untuk fitur Must

Berlaku untuk M1–M5 pada P14–P15.

- [ ] Perilaku sesuai acceptance criteria di user story.
- [ ] Berjalan dari antarmuka sampai database nyata, bukan data contoh di kode.
- [ ] Ada validasi di frontend dan backend.
- [ ] Ada minimal satu test otomatis untuk aturan bisnis yang penting.
- [ ] Status dan pesan galat tampil dalam bahasa Indonesia yang jelas.
- [ ] Kondisi kosong, memuat, dan galat ditangani.
- [ ] Kontras teks minimal 4.5:1 dan target sentuh minimal 44 px.
- [ ] Bisa dipakai pada lebar 390 px dan desktop.
- [ ] Terhubung ke endpoint yang ada di `03_Application/openapi.yaml`.
- [ ] Lint, build, dan test lulus; hasilnya dilampirkan di `07_Evidence/`.
- [ ] Reviewer selain penulis menyatakan setuju.

## 3. Definition of Done untuk gate

Gate hanya boleh disebut lolos jika buktinya bisa dibuka, bukan karena sudah dikerjakan.

| Gate | Butir wajib | Bukti |
|---|---|---|
| Gate 1 | Vision beku, traceability ≥5 baris, ERD 3NF, MoSCoW maksimal lima Must, repo dan papan kerja aktif, tiap anggota punya kartu atau commit | `00_Vision/`, `06_Governance/P13-Traceability-Matrix.md`, `02_Data/`, `07_Evidence/P13-Work-Board.md` |
| Gate 2 | Dua Must berjalan end-to-end, ADR tech stack, topologi dan staging, tidak ada anggota tanpa kontribusi | `08_Source/`, `04_Technology/`, `07_Evidence/P14-*` |
| Gate 3 | Lima Must selesai, UAT dan SUS, roadmap dan migration plan, restore backup terbukti | `07_Evidence/P15-*`, `05_Opportunities/` |
| Final | Pitch ≤10 slide, demo atau video cadangan, rilis v1.0 | `09_Pitch/`, tag `v1.0` |

Status resmi Hijau, Kuning, atau Merah hanya diisi dosen. Repo hanya mencatat status internal: siap diajukan, bersyarat, atau belum siap.

## 4. Yang tidak termasuk DoD

- Menyebut sesuatu "hampir selesai" tanpa file.
- Menutup butir gate karena sudah dijanjikan di chat.
- Menghitung diagram lama sebagai artefak baru tanpa pemeriksaan.
