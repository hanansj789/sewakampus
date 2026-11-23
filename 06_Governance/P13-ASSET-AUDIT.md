# Audit Aset SewaKampus P13–P16 — Session 1

**Tanggal pemeriksaan:** 23 November 2026  
**Status dokumen:** audit bukti lokal; **belum** mapping final, keputusan scope, atau Gate 1 freeze.  
**Sumber aturan tertinggi:** `PROYEK/GROWPATH/Skenario_Project ASP R001.txt`, terutama halaman 1–12, 15–17, 20, 24, 27, 32, 34, dan 36.  
**Daftar 35 butir yang diuji:** `PROYEK/SEWAKAMPUS/HANDOFF-PROMPT-P13-P16.md`, bagian 4.  
**Batas pemeriksaan:** aset lokal dan bagian relevan DOCX dibaca; PDF lama tidak dijadikan bukti; repo daring, persetujuan mitra, serta tanda tangan tidak diverifikasi.

## Cara membaca status

- **Ada:** artefak yang diminta tersedia dan bentuknya sesuai, dengan path yang bisa dibuka.
- **Sebagian:** bahan lama ada, tetapi belum cukup untuk deliverable sprint atau belum direview.
- **Belum:** belum ditemukan artefak yang bisa dinilai untuk butir itu.
- **Belum diverifikasi:** klaim memerlukan pemeriksaan eksternal atau keputusan pemilik; tidak disimpulkan dari nama target file.

Semua path di kolom bukti relatif terhadap `PROYEK/SEWAKAMPUS/`. Singkatan berikut dipakai agar tabel tetap terbaca:

| Singkatan | Path bukti yang tersedia |
|---|---|
| L | `LAPORAN/Progres Pertemuan 12 - Kelompok 1 - SewaKampus.docx` |
| R | `LAPORAN/Ringkasan Proyek SewaKampus - Kelompok 1.docx` |
| K | `00 - KONTEKS PROYEK.md` |
| O | `DESAIN/openapi.yaml` |
| B | `DESAIN/BPMN To-Be - SewaKampus.png` |
| F | `DESAIN/Functional Decomposition - SewaKampus.png` |
| E | `DESAIN/ERD - SewaKampus.drawio` |
| D | `DESAIN/Logical Data Model - SewaKampus.drawio` |
| M | `DESAIN/Modul Aplikasi - SewaKampus.drawio` |
| T | `DESAIN/Phase D - SewaKampus.drawio` |
| I | `DESAIN/Infrastruktur - SewaKampus.png` |
| DP | `DESAIN/Deployment - SewaKampus.png` |
| RM | `DESAIN/Architecture Roadmap - SewaKampus.png` |

`ARCHITECTURE_REPOSITORY/` **belum ada sebagai repo Git saat audit dimulai**. Folder `06_Governance/` yang memuat audit ini hanyalah tempat catatan awal, bukan bukti bahwa repo, branch, atau Gate 1 sudah siap. Path dalam handoff berawalan `00_Vision/` sampai `09_Pitch/` adalah **target**, bukan bukti keberadaan file.

## A. P13 di kelas — 15 butir

| ID | Deliverable | Status | Bukti lokal dan kekurangan |
|---|---|---|---|
| P13-01 | Vision v1.0, problem, nilai, lingkup, 3 KPI | Sebagian | L §3.2 dan R §1–3 memuat ide serta lingkup; Vision v1.0 beku dan 3 KPI belum ditemukan. |
| P13-02 | MoSCoW dan lima Must | Sebagian | L §1.4 dan R tabel “Fitur Utama” memuat daftar rancangan, tetapi bukan MoSCoW lima Must resmi. |
| P13-03 | Definition of Done dan Team Charter | Belum | Tidak ditemukan dokumen DoD maupun charter yang disetujui empat anggota. |
| P13-04 | BPMN to-be dua proses utama | Sebagian | B dan L §3.3.1 hanya menampilkan satu proses gabungan; booking dan handover–return belum dipisahkan. |
| P13-05 | Use case, 5–8 user story, acceptance criteria | Sebagian | F dan L §3.3.2 memetakan fungsi, tetapi bukan use case atau story dengan kriteria uji. |
| P13-06 | Wireframe | Belum | Tidak ditemukan wireframe formal untuk lima Must. |
| P13-07 | ERD konseptual–logis, 3NF | Sebagian | E, D, L §3.4.1 memuat 14 entitas; konsistensi terhadap use case dan bukti 3NF yang direview belum ada. |
| P13-08 | Kamus data dan bukti normalisasi | Sebagian | L tabel 3.6–3.8 dan §3.4.1.5 memuat kamus/uraian; bukti 3NF per entitas belum ditunjukkan. |
| P13-09 | Pola aplikasi, struktur folder, strategi branch | Sebagian | M, L §3.4.2, K menetapkan modular monolith Laravel; struktur folder dan aturan branch formal belum ditemukan. |
| P13-10 | Repo dengan main/dev/feature | Belum diverifikasi | Tidak ada `ARCHITECTURE_REPOSITORY/.git` lokal; URL repo dan branch GitHub belum diketahui, tidak boleh diasumsikan. |
| P13-11 | Topologi as-is/to-be, NFR, security baseline | Sebagian | T, I, DP, L §3.5 memberi rancangan target; topologi as-is di lokasi mitra, NFR tersendiri, dan baseline keamanan belum ada. |
| P13-12 | Notulen stand-up | Belum | Tidak ditemukan notulen P13 yang mencatat peserta, keputusan, risiko, dan pemilik aksi. |
| P13-13 | OpenAPI 3.1 yang menutup kontrak MVP | Sebagian | O tersedia sebagai kontrak lama. `HandoverCreateRequest` (`openapi.yaml:1806–1819`) tidak menerima foto kondisi; `/items/{itemId}/photos` adalah foto listing, bukan handover. |
| P13-14 | Traceability ≥5 baris | Belum | Tidak ditemukan matriks kebutuhan → use case → tabel → layar. |
| P13-15 | Work board dan Gate 1 checklist | Belum | Belum ditemukan papan kerja, kartu per anggota, ataupun keputusan gate dari dosen. |

## B. PR sebelum P14 — 8 butir

“PR” di TXT berarti **Pekerjaan Rumah**, bukan pull request GitHub.

| ID | Deliverable | Status | Bukti lokal dan kekurangan |
|---|---|---|---|
| PR14-01 | Konfirmasi tertulis mitra dan jadwal UAT P15 | Belum | L §1 menyatakan data lapangan belum dikumpulkan; belum ditemukan balasan mitra atau jadwal. |
| PR14-02 | Business Model Canvas | Belum | Ada narasi model bisnis di L, tetapi bukan kanvas bisnis. |
| PR14-03 | Prototipe Figma hi-fi clickable | Belum | Tidak ditemukan file/tautan prototipe yang bisa diklik. |
| PR14-04 | DDL MySQL/PostgreSQL | Belum | E/D adalah model, bukan skrip DDL yang dapat dijalankan. |
| PR14-05 | Data dummy ≥30 baris per tabel master | Belum | Tidak ditemukan seed SQL atau bukti jumlah baris. |
| PR14-06 | Aplikasi lokal login + role | Belum | R §6–7 menyatakan web belum dibangun; kode aplikasi tidak ditemukan. |
| PR14-07 | README cara menjalankan | Belum | `08_Source/` dan README aplikasi belum ada. |
| PR14-08 | Dua opsi hosting, biaya, draf deployment | Sebagian | I dan DP tersedia; dua opsi hosting dengan biaya yang bersumber belum ditemukan. |

## C. P14–P16 — 12 butir

| ID | Deliverable | Status | Bukti lokal dan kekurangan |
|---|---|---|---|
| P14-01 | ADR tech stack dan database nyata | Sebagian | K dan L §3.4–3.5 memuat keputusan stack/rancangan constraint; belum ada ADR atau implementasi DB. |
| P14-02 | Dua Must end-to-end | Belum | Tidak ditemukan kode, demo, atau PR dengan DB nyata. |
| P14-03 | ≥15 test case black-box dan staging | Belum | Tidak ditemukan kasus uji maupun bukti staging. |
| P14-04 | Gate 2 Build Review | Belum | Tidak ditemukan keputusan gate atau bukti demo langsung. |
| P15-01 | Lima Must selesai | Belum | Lima Must masih berupa rancangan. |
| P15-02 | UAT dengan mitra/proksi dan SUS | Belum | Tidak ditemukan laporan, responden, rekaman, atau skor SUS. |
| P15-03 | Bukti restore backup | Belum | K §Isu terbuka menyatakan restore belum diuji. |
| P15-04 | Architecture Roadmap, migration plan, TCO 12 bulan | Sebagian | RM dan L §4.2/tabel 4.2 ada; belum sesuai gate P13–P16 dan belum ada TCO bersumber. |
| P15-05 | Gate 3 Dry-run Pitch | Belum | Tidak ditemukan bukti pitch 7 menit atau peer review. |
| P16-01 | Pitch ≤10 slide | Sebagian | R adalah ringkasan DOCX 9 halaman, bukan deck presentasi. |
| P16-02 | Rilis v1.0, changelog, panduan pengguna | Belum | Tidak ditemukan tag rilis, changelog, atau panduan. |
| P16-03 | Repository final dan peer assessment | Belum | Repo final dan bukti penilaian belum ditemukan; status remote tetap belum diverifikasi. |

**Rekap:** 13 Sebagian, 21 Belum, 1 Belum diverifikasi, 0 Ada dalam bentuk deliverable sprint yang lengkap. Ini **tidak** berarti bahan proyek tidak ada; diagram, dokumen lama, dan kontrak API memang ada, tetapi belum memenuhi bentuk/bukti yang diminta TXT.

## Konflik dan celah wajib diputuskan sebelum mapping/freeze

1. **Lima Must resmi, bukan delapan label MVP.** TXT hlm. 7: listing, kalender ketersediaan, persetujuan sewa, foto kondisi, rating. R tabel “Fitur Utama” menandai delapan baris sebagai MVP. Handoff mengusulkan KTM, deposit simulasi, dan handover sebagai kontrol di dalam proses, bukan Must tambahan. Usulan itu masih perlu persetujuan pemilik/tim; jangan menulis backlog final sebelum ada keputusan.
2. **Foto kondisi belum tertutup kontrak.** O `Handover` memiliki `photo_url` (`openapi.yaml:1773–1804`), tetapi request membuat handover tidak menerima foto (`openapi.yaml:1806–1819`). Unggah foto pada `/items/{itemId}/photos` (`openapi.yaml:467`) untuk listing; TXT hlm. 26 meminta foto kondisi saat serah-terima **dan** pengembalian.
3. **Status transaksi belum terbukti di BPMN.** TXT hlm. 16 mensyaratkan diajukan → disetujui → diserahkan → dikembalikan → selesai. B masih menggabungkan alur dan tidak menggambarkan dua proses utama maupun foto kondisi pada OUT/RETURN.
4. **Roadmap tidak serasi dengan gate.** L §4.2 menyebut lima minggu, RM memakai M1–M6. TXT hlm. 24/27 menuntut dua Must berjalan pada P14; hlm. 32/34 menuntut lima Must, UAT, staging, dan restore pada P15. Roadmap lama adalah baseline, bukan jadwal sprint yang disetujui.
5. **Bukti manusia dan repo belum ada.** Identitas empat anggota/peran, reviewer domain, akun pemilik repo, mitra/jadwal UAT, tanda tangan charter, serta keputusan dosen belum diverifikasi. Jangan mengarang dan jangan menyatakan Gate 1 Hijau.

## Klasifikasi aset lama untuk mapping berikutnya

- **Dapat dipakai langsung sebagai bahan:** L (bagian yang relevan), `DESAIN/Value Chain - SewaKampus.png`, `DESAIN/BPMN As-Is - SewaKampus.png`, M, dan diagram Phase D sebagai baseline rancangan. “Dipakai langsung” tidak berarti deliverable P13 sudah final.
- **Perlu diperbarui:** R, `DESAIN/Solution Concept - SewaKampus.png`, B, E/D, O, DP, RM.
- **Dibuat baru:** Vision v1.0 dan 3 KPI, MoSCoW, DoD, charter, use case/story, wireframe/prototipe, 3NF proof, NFR, topologi as-is mitra, pilihan hosting, traceability, papan kerja, checklist gate, serta artefak implementasi dan bukti P14–P16.
- **Belum diverifikasi:** repo GitHub/branch, nama anggota dan reviewer, mitra, tanggal UAT, persetujuan dosen, serta bukti kontribusi eksternal.

**Batas berikutnya:** tunggu keputusan pemilik lewat brainstorming. Jangan membuat matrix final, repo Git, Vision freeze, atau klaim status Gate 1 dari audit ini saja.
