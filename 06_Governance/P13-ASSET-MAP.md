# Peta Aset Lama ke Deliverable P13–P16

**Status:** Ada (peta), isi deliverable belum tentu ada.
**Tanggal:** 23 November 2026

Kolom "Aset lama" menunjuk file yang benar-benar ada hari ini. Kolom "Target" menunjuk lokasi yang **belum** tentu terisi. Status per 23 November 2026 mengikuti `P13-ASSET-AUDIT.md`.

Singkatan:

- **L** = `SEWAKAMPUS/LAPORAN/Progres Pertemuan 12 - Kelompok 1 - SewaKampus.docx`
- **R** = `SEWAKAMPUS/LAPORAN/Ringkasan Proyek SewaKampus - Kelompok 1.docx`
- **D** = folder `SEWAKAMPUS/DESAIN/`

## A. P13

| ID | Aset lama | Bagian / catatan | Tindakan | Target di repo |
|---|---|---|---|---|
| P13-01 | L, R, `D/Value Chain - SewaKampus.png` | L §1.1–1.4, §3.2 | Ambil masalah, nilai, lingkup; tambah 3 KPI | `00_Vision/P13-Vision-v1.0.md` (draf ada) |
| P13-02 | L §1.4, §3.2; TXT hlm. 7 | Daftar fitur lama delapan butir | Kunci lima Must, sisanya turun ke Should/Won't | `00_Vision/P13-MoSCoW-Backlog.md` (draf ada) |
| P13-03 | tidak ada | — | Susun baru, lalu minta tanda tangan | `06_Governance/P13-Definition-of-Done.md`, `P13-Team-Charter.md` (draf ada, belum ditandatangani) |
| P13-04 | `D/BPMN To-Be - SewaKampus.png`, `D/BPMN As-Is - SewaKampus.png` | Satu alur gabungan | Pisah menjadi proses booking dan handover–return, tambah foto kondisi | `01_Business/P13-BPMN-To-Be-Booking.png`, `P13-BPMN-To-Be-Handover.png` |
| P13-05 | `D/Functional Decomposition - SewaKampus.png` | Dekomposisi fungsi, bukan use case | Turunkan use case, 5–8 user story, acceptance criteria | `01_Business/P13-Use-Cases.md`, `P13-User-Stories.md` |
| P13-06 | tidak ada | — | Gambar wireframe lima Must setelah DESIGN.md | `03_Application/ux/P13-Wireframes.png` |
| P13-07 | `D/ERD - SewaKampus.drawio`, `D/Logical Data Model - SewaKampus.drawio` | 14 entitas | Periksa PK, FK, unique, check; buktikan 3NF | `02_Data/P13-ERD-3NF.drawio` |
| P13-08 | L tabel 3.6–3.8, §3.4.1.5 | Kamus dan uraian normalisasi | Lengkapi tipe, constraint, bukti 3NF per entitas | `02_Data/P13-Data-Dictionary.md`, `P13-3NF-Proof.md` |
| P13-09 | `D/Modul Aplikasi - SewaKampus.drawio`, L §3.4.2 | Modular monolith Laravel | Tetapkan struktur folder dan strategi branch | `03_Application/P13-App-Structure.md` |
| P13-10 | tidak ada | Repo lokal baru dibuat | Aktifkan branch dan kartu; remote GitHub ditunda | `README.md`, `CONTRIBUTING.md` |
| P13-11 | `D/Phase D - SewaKampus.drawio`, `D/SSO`, `D/API Gateway`, `D/Infrastruktur - SewaKampus.png` | Rancangan target, bukan as-is mitra | Tambah topologi as-is, NFR, security baseline | `04_Technology/P13-Topology-*.png`, `P13-NFR.md`, `P13-Security-Baseline.md` |
| P13-12 | tidak ada | — | Catat stand-up mulai pertemuan berikutnya | `07_Evidence/P13-Standup-Minutes.md` |
| P13-13 | `D/openapi.yaml`, `D/API - SewaKampus.drawio` | Kontrak lama; handover belum menerima foto | Perbaiki kontrak M4, selaraskan OIDC | `03_Application/openapi.yaml` |
| P13-14 | tidak ada | — | Susun matriks lima baris | `06_Governance/P13-Traceability-Matrix.md` (draf ada, kolom use case/layar masih Belum) |
| P13-15 | tidak ada | — | Papan kerja empat kartu dan checklist gate | `07_Evidence/P13-Work-Board.md`, `06_Governance/P13-Gate-1-Checklist.md` (draf ada) |

## B. PR sebelum P14

| ID | Aset lama | Bagian / catatan | Tindakan | Target di repo |
|---|---|---|---|---|
| PR14-01 | tidak ada | Belum ada mitra | Susun surat dan rencana tiga pengguna proksi | `07_Evidence/PR14-01-Partner-Confirmation.md` |
| PR14-02 | L §1.2 narasi model bisnis | Bukan kanvas | Susun sembilan blok BMC | `01_Business/P13-Business-Model-Canvas.md` |
| PR14-03 | tidak ada | FigCraft, bukan Figma (SK-019) | Brainstorm, tulis `DESIGN.md`, lalu prototipe FigCraft clickable dan ekspor PNG/PDF | `03_Application/ux/` |
| PR14-04 | `D/ERD`, `D/Logical Data Model` | Model, bukan skrip | Turunkan DDL MySQL 8.0 | `08_Source/database/sql/001_init.sql` |
| PR14-05 | tidak ada | — | Seed ≥30 baris per tabel master | `08_Source/database/sql/seed.sql` |
| PR14-06 | tidak ada | Belum ada kode | Laravel + MySQL + Keycloak lokal | `08_Source/` |
| PR14-07 | tidak ada | — | README prasyarat, env, akun uji | `08_Source/README.md` |
| PR14-08 | `D/Infrastruktur`, `D/Deployment` | Satu opsi, belum ada biaya | Bandingkan dua opsi hosting dan biaya | `04_Technology/P13-Hosting-Options.md` |

## C. P14–P16

| ID | Aset lama | Bagian / catatan | Tindakan | Target di repo |
|---|---|---|---|---|
| P14-01 | `00 - KONTEKS PROYEK.md`, L §3.4–3.5 | Keputusan tersebar | Tulis ADR tech stack | `06_Governance/ADR-001-tech-stack.md` |
| P14-02 | tidak ada | — | M1 dan M2 end-to-end | `08_Source/`, `07_Evidence/` |
| P14-03 | tidak ada | — | 15 test case black-box dan staging | `07_Evidence/P14-Test-Cases.md` |
| P14-04 | tidak ada | — | Demo gate dan bukti | `07_Evidence/P14-Gate-2.md` |
| P15-01 | tidak ada | — | Selesaikan M3–M5 | `08_Source/`, `07_Evidence/P15-MVP.md` |
| P15-02 | tidak ada | Mitra belum ada | UAT dengan proksi, hitung SUS | `07_Evidence/P15-UAT-SUS.md` |
| P15-03 | `00 - KONTEKS PROYEK.md` | Restore belum diuji | Uji restore ke database baru | `07_Evidence/P15-Restore-Test.md` |
| P15-04 | `D/Architecture Roadmap - SewaKampus.png`, L §4.2 | Lima minggu vs M1–M6 | Selaraskan ke gate, tambah TCO | `05_Opportunities/P15-Roadmap-Migration.md`, `04_Technology/P15-TCO.md` |
| P15-05 | tidak ada | — | Latihan pitch | `07_Evidence/P15-Gate-3.md` |
| P16-01 | R | Ringkasan DOCX, bukan deck | Susun deck ≤10 slide | `09_Pitch/P16-Pitch.pptx` |
| P16-02 | tidak ada | — | Rilis v1.0 dan panduan | `08_Source/CHANGELOG.md` |
| P16-03 | tidak ada | Repo lokal, tanpa remote | Bukti kontribusi dan refleksi | `07_Evidence/P16-*` |

## D. Kesimpulan pemetaan

- **Bisa dipakai sebagai bahan awal:** L (bagian relevan), `D/Value Chain`, `D/BPMN As-Is`, `D/Modul Aplikasi`, `D/ERD`, `D/Logical Data Model`, `D/Phase D`, `D/openapi.yaml`, `D/REFERENSI VISUAL.md`.
- **Wajib diperiksa sebelum dipakai:** semua diagram Phase D dan roadmap, karena dibuat untuk kebutuhan laporan Phase A–F, bukan gate P13–P16.
- **Harus dibuat baru:** Vision beku, use case dan user story, wireframe, prototipe, bukti 3NF, NFR, security baseline, topologi as-is, DDL, seed, aplikasi, UAT, TCO.
- **Tidak boleh dihitung sebagai bukti:** path target di kolom terakhir.
