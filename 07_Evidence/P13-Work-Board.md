# Papan Kerja P13 — SewaKampus

**Status:** Ada. Empat kartu, satu per anggota.
**Diperbarui:** 23 November 2026 (akhir pekerjaan Session 2)

Aturan: satu kartu satu orang. Perpindahan status hanya boleh dilakukan setelah bukti file ada.

## Ringkasan

| Anggota | Peran | Kartu | Selesai | Draf | Belum |
|---|---|---|---|---|---|
| Hanan | CEO/PO + Analyst formal | K-01 | 0 | 3 | 3 |
| Fharel | Analyst/UI/UX pelaksana | K-02 | 0 | 2 | 3 |
| Fazha | Programmer + Database Architect | K-03 | 0 | 4 | 3 |
| Mahesa | Network/DevOps + QA/notulis | K-04 | 0 | 2 | 3 |

Status **Selesai** berarti sudah direview anggota lain. Saat ini belum ada artefak yang direview, sehingga tidak ada yang berstatus selesai.

## K-01 — Hanan: visi, prioritas, dan keputusan

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| Susun Vision v1.0 | P13-01 | Draf | `00_Vision/P13-Vision-v1.0.md` |
| Kunci lima Must dan MoSCoW | P13-02 | Draf | `00_Vision/P13-MoSCoW-Backlog.md` |
| Traceability lima baris | P13-14 | Draf | `06_Governance/P13-Traceability-Matrix.md` |
| Minta persetujuan tiga anggota atas Vision dan charter | P13-01, P13-03 | Belum | belum ada |
| Konfirmasi mitra UAT dan jadwal P15 | PR14-01 | Belum | belum ada |
| Business Model Canvas | PR14-02 | Belum | belum ada |

## K-02 — Fharel: proses, kebutuhan, dan tampilan

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| Use case tujuh alur | P13-05 | Draf | `01_Business/P13-Use-Cases.md` |
| Delapan user story dan acceptance criteria | P13-05 | Draf | `01_Business/P13-User-Stories.md` |
| Pisahkan BPMN to-be: booking dan handover–return | P13-04 | Belum | `DESAIN/BPMN To-Be - SewaKampus.png` baru satu alur |
| Wireframe lima Must | P13-06 | Belum | belum ada |
| Prototipe clickable | PR14-03 | Belum | belum ada |

## K-03 — Fazha: data, kontrak, dan kode

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| Perbaiki kontrak foto kondisi | P13-13 | Draf | `03_Application/openapi.yaml` (SK-014) |
| Kamus data 14 entitas | P13-08 | Draf | `02_Data/P13-Data-Dictionary.md` |
| Bukti 3NF | P13-07, P13-08 | Draf | `02_Data/P13-3NF-Proof.md` |
| DDL dan seed | PR14-04, PR14-05 | Draf | `08_Source/database/sql/001_init.sql`, `seed.sql` |
| Jalankan DDL di database kosong | PR14-04 | Belum | belum ada MySQL |
| Struktur aplikasi dan ADR | P13-09 | Belum | belum ada |
| Login lokal dan README aplikasi | PR14-06, PR14-07 | Belum | belum ada |

## K-04 — Mahesa: teknologi, risiko, dan catatan

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| NFR | P13-11 | Draf | `04_Technology/P13-NFR.md` |
| Security baseline | P13-11 | Draf | `04_Technology/P13-Security-Baseline.md` |
| Topologi as-is dan to-be | P13-11 | Belum | `DESAIN/Phase D - SewaKampus.drawio` baru rancangan target |
| Notulen stand-up P13 | P13-12 | Belum | belum ada |
| Dua opsi hosting dan biaya | PR14-08 | Belum | belum ada |

## Catatan

- Pekerjaan Session 1 dan 2 dikerjakan sebagai kerja tim, bukan kartu pribadi, sehingga tidak ada kartu yang diklaim selesai.
- Berkas pengetahuan bersama ada di `SEWAKAMPUS/AGENTS.md`, `DECISIONS.md`, dan `CONTEXT-PACK.md`. Branch `main` dan `dev` aktif; `CODEOWNERS` masih kosong.
- Yang paling menghambat Gate 1: BPMN dua proses, wireframe, tanda tangan charter, dan uji DDL.
