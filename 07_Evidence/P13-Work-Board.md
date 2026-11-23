# Papan Kerja P13 — SewaKampus

**Status:** Ada. Empat kartu, satu per anggota.
**Diperbarui:** 23 November 2026 (setelah langkah 1–4 Session 2)

Aturan: satu kartu satu orang. Perpindahan status hanya boleh dilakukan setelah bukti file ada. Status per butir yang berlaku ada di `P13-DELIVERABLE-MATRIX.md`; papan ini mencatat kepemilikan kartu, bukan menggantikan matriks.

## Ringkasan

Dihitung per baris tugas, bukan per deliverable; satu deliverable bisa muncul di dua baris. Status per deliverable ada di matriks.

| Anggota | Peran | Kartu | Ada menunggu review | Sebagian | Belum |
|---|---|---|---|---|---|
| Hanan | CEO/PO + Analyst formal | K-01 | 0 | 4 | 3 |
| Fharel | Analyst/UI/UX pelaksana | K-02 | 3 | 0 | 2 |
| Fazha | Programmer + Database Architect | K-03 | 3 | 2 | 2 |
| Mahesa | Network/DevOps + QA/notulis | K-04 | 1 | 3 | 1 |

Status **Ada, menunggu review** berarti file lengkap tetapi belum direview anggota lain. Belum ada kartu yang berstatus **Selesai** karena belum ada review silang. P13-05 muncul di dua baris (use case dan user story), jadi jumlah baris Ada di sini tujuh, sedangkan deliverable Ada di matriks enam.

## K-01 — Hanan: visi, prioritas, dan keputusan

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| Susun Vision v1.0 | P13-01 | Sebagian | `00_Vision/P13-Vision-v1.0.md` |
| Kunci lima Must dan MoSCoW | P13-02 | Sebagian | `00_Vision/P13-MoSCoW-Backlog.md` |
| DoD dan Team Charter | P13-03 | Sebagian | `06_Governance/P13-Definition-of-Done.md`, `06_Governance/P13-Team-Charter.md` |
| Traceability lima baris | P13-14 | Sebagian | `06_Governance/P13-Traceability-Matrix.md` |
| Minta persetujuan tiga anggota atas Vision dan charter | P13-01, P13-03 | Belum | belum ada |
| Konfirmasi mitra UAT dan jadwal P15 | PR14-01 | Belum | belum ada |
| Business Model Canvas | PR14-02 | Belum | belum ada |

## K-02 — Fharel: proses, kebutuhan, dan tampilan

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| Use case tujuh alur | P13-05 | Ada, menunggu review | `01_Business/P13-Use-Cases.md` |
| Delapan user story dan acceptance criteria | P13-05 | Ada, menunggu review | `01_Business/P13-User-Stories.md` |
| Pisahkan BPMN to-be: booking dan handover–return | P13-04 | Ada, menunggu review | `01_Business/P13-BPMN-To-Be-Booking.drawio` + `.png`, `01_Business/P13-BPMN-To-Be-Handover.drawio` + `.png` |
| Wireframe lima Must | P13-06 | Belum | belum ada |
| Prototipe clickable | PR14-03 | Belum | belum ada |

## K-03 — Fazha: data, kontrak, dan kode

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| Perbaiki kontrak foto kondisi | P13-13 | Ada, menunggu review | `03_Application/openapi.yaml` (SK-014) |
| Kamus data 14 entitas | P13-08 | Ada, menunggu review | `02_Data/P13-Data-Dictionary.md` |
| Bukti 3NF dan kecocokan ERD | P13-07 | Sebagian | `02_Data/P13-3NF-Proof.md`; ERD belum dicocokkan dengan use case |
| DDL dan seed | PR14-04, PR14-05 | Sebagian | `08_Source/database/sql/001_init.sql`, `seed.sql` |
| Jalankan DDL di database kosong | PR14-04 | Belum | belum ada MySQL |
| Struktur aplikasi dan ADR | P13-09 | Ada, menunggu review | `03_Application/P13-App-Structure.md`, `06_Governance/ADR-002-application-structure.md` |
| Login lokal dan README aplikasi | PR14-06, PR14-07 | Belum | belum ada |

## K-04 — Mahesa: teknologi, risiko, dan catatan

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| NFR | P13-11 | Sebagian | `04_Technology/P13-NFR.md` |
| Security baseline | P13-11 | Sebagian | `04_Technology/P13-Security-Baseline.md` |
| Topologi as-is dan to-be | P13-11 | Sebagian | `DESAIN/Phase D - SewaKampus.drawio` baru rancangan target |
| Notulen stand-up P13 | P13-12 | Belum | `07_Evidence/P13-Standup-Minutes.md` baru format; belum ada rapat |
| Dua opsi hosting dan biaya | PR14-08 | Ada, menunggu review | `04_Technology/P13-Hosting-Options.md`; enam butir biaya masih belum diverifikasi |

## Catatan

- Pekerjaan Session 1 dan 2 dikerjakan sebagai kerja tim, bukan kartu pribadi, sehingga tidak ada kartu yang diklaim selesai.
- Berkas pengetahuan bersama ada di `SEWAKAMPUS/AGENTS.md`, `DECISIONS.md`, dan `CONTEXT-PACK.md`. Branch `main` dan `dev` sejalan; `CODEOWNERS` masih berupa komentar karena username GitHub belum ditetapkan (SK-005).
- Yang paling menghambat Gate 1 sekarang: wireframe, uji DDL di database kosong, tanda tangan charter, dan review silang.
- Tiga baris kartu naik ke **Ada, menunggu review** pada 23 November 2026 lewat commit `55e9fca`. Semuanya belum direview anggota lain.
