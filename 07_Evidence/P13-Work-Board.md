# Papan Kerja P13 — SewaKampus

**Status:** Ada. Empat kartu, satu per anggota.
**Diperbarui:** 24 November 2026 (review silang dilewati lewat SK-021)

Aturan: satu kartu satu orang. Perpindahan status hanya boleh dilakukan setelah bukti file ada. Status per butir yang berlaku ada di `P13-DELIVERABLE-MATRIX.md`; papan ini mencatat kepemilikan kartu, bukan menggantikan matriks.

## Ringkasan

Dihitung per baris tugas, bukan per deliverable; satu deliverable bisa muncul di dua baris. Status per deliverable ada di matriks.

| Anggota | Peran | Kartu | Selesai (internal) | Sebagian | Belum |
|---|---|---|---|---|---|
| Hanan | CEO/PO + Analyst formal | K-01 | 8 | 0 | 0 |
| Fharel | Analyst/UI/UX pelaksana | K-02 | 6 | 0 | 0 |
| Fazha | Programmer + Database Architect | K-03 | 10 | 0 | 0 |
| Mahesa | Network/DevOps + QA/notulis | K-04 | 5 | 0 | 0 |

Status **Selesai (internal)** berarti artefak lengkap dan diterima pemilik; review silang dilewati lewat SK-021. Ini bukan penilaian dosen dan bukan bukti review independen. P13-05 muncul di dua baris (use case dan user story), jadi jumlah baris Selesai di sini tiga puluh, sedangkan deliverable Selesai di matriks dua puluh tiga.

## K-01 — Hanan: visi, prioritas, dan keputusan

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| Susun Vision v1.0 | P13-01 | Selesai (internal) | `00_Vision/P13-Vision-v1.0.md` (final, disetujui 24 Nov 2026) |
| Kunci lima Must dan MoSCoW | P13-02 | Selesai (internal) | `00_Vision/P13-MoSCoW-Backlog.md` (final) |
| DoD dan Team Charter | P13-03 | Selesai (internal) | `06_Governance/P13-Definition-of-Done.md`, `06_Governance/P13-Team-Charter.md` (tanggal 23 Nov 2026) |
| Traceability lima baris | P13-14 | Selesai (internal) | `06_Governance/P13-Traceability-Matrix.md` |
| Brief Gate 1 dan naskah lima menit | P13-15 | Selesai (internal) | `06_Governance/P13-Gate-1-Brief.md` |
| Minta persetujuan tiga anggota atas Vision dan charter | P13-01, P13-03 | Selesai (internal) | Pernyataan pemilik proyek 24 Nov 2026; tanda tangan charter 23 Nov 2026 |
| Konfirmasi mitra UAT dan jadwal P15 | PR14-01 | Selesai (internal) | `07_Evidence/PR14-01-UAT-Partner-Plan.md` (tiga peserta proksi, jadwal P15) |
| Business Model Canvas | PR14-02 | Selesai (internal) | `01_Business/P13-BMC.drawio` + `.png` |

## K-02 — Fharel: proses, kebutuhan, dan tampilan

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| Use case tujuh alur | P13-05 | Selesai (internal) | `01_Business/P13-Use-Cases.md`, `01_Business/P13-Use-Case-Diagram.drawio` + `.png` |
| Delapan user story dan acceptance criteria | P13-05 | Selesai (internal) | `01_Business/P13-User-Stories.md` |
| Pisahkan BPMN to-be: booking dan handover–return | P13-04 | Selesai (internal) | `01_Business/P13-BPMN-To-Be-Booking.drawio` + `.png`, `01_Business/P13-BPMN-To-Be-Handover.drawio` + `.png` |
| Wireframe lima Must | P13-06 | Selesai (internal) | `03_Application/ux/SewaKampus-Wireframe.figcraft`, `03_Application/ux/P13-06-Wireframe.md`, `03_Application/ux/exports/WF-01` sampai `WF-09` |
| Prototipe clickable | PR14-03 | Selesai (internal) | `03_Application/ux/SewaKampus-High-Fidelity.figcraft`, `03_Application/ux/PR14-03-Prototype-FigCraft.md`, `03_Application/ux/exports/L-01` sampai `L-07` |
| Review UI halaman auth | P14-03 | Selesai (internal) | `07_Evidence/P14-03-UI-Review-Auth.md` (3 temuan, 4 lolos; screenshot 320/390) |

## K-03 — Fazha: data, kontrak, dan kode

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| Perbaiki kontrak foto kondisi | P13-13 | Selesai (internal) | `03_Application/openapi.yaml` (SK-014) |
| Kamus data 14 entitas | P13-08 | Selesai (internal) | `02_Data/P13-Data-Dictionary.md` |
| Bukti 3NF dan kecocokan ERD | P13-07 | Selesai (internal) | `02_Data/P13-ERD.drawio` (17 relasi), `02_Data/P13-3NF-Proof.md`, `02_Data/P13-ERD-Use-Case-Check.md` |
| DDL dan seed | PR14-04, PR14-05 | Selesai (internal) | `08_Source/database/sql/001_init.sql`, `seed.sql` (30 kategori/30 pengguna/30 barang), `07_Evidence/PR14-04-DDL-Run-Log.md` |
| Jalankan DDL di database kosong | PR14-04 | Selesai (internal) | `07_Evidence/PR14-04-DDL-Run-Log.md` (MySQL 8.0.43) |
| Verifikasi ulang skema dan seed | PR14-04 | Selesai (internal) | `08_Source/database/sql/002_verify.sql`, `07_Evidence/PR14-04-DB-Verification-Run.md` (16 pemeriksaan PASS) |
| Struktur aplikasi dan ADR | P13-09 | Selesai (internal) | `03_Application/P13-App-Structure.md`, `06_Governance/ADR-002-application-structure.md` |
| Programmer handoff Laravel | P13-09, PR14-06 | Selesai (internal) | `08_Source/docs/PROGRAMMER-HANDOFF.md` |
| Login lokal dan role | PR14-06 | Selesai (internal) | `08_Source/` (Laravel + Keycloak OIDC/PKCE + middleware role); `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md` (16 test/70 assertion dan smoke test browser lokal STUDENT/ADMIN) |
| README aplikasi lokal | PR14-07 | Selesai (internal) | `08_Source/README.md`; bukti run di `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md` |

## K-04 — Mahesa: teknologi, risiko, dan catatan

| Tugas | Deliverable | Status | Bukti |
|---|---|---|---|
| NFR | P13-11 | Selesai (internal) | `04_Technology/P13-NFR.md` |
| Security baseline | P13-11 | Selesai (internal) | `04_Technology/P13-Security-Baseline.md` |
| Topologi as-is dan to-be | P13-11 | Selesai (internal) | `04_Technology/P13-Topology-As-Is.md` (as-is kualitatif lingkungan mahasiswa), `DESAIN/Phase D - SewaKampus.drawio` (to-be) |
| Runbook stack lokal | P13-11 | Selesai (internal) | `04_Technology/P13-Local-Stack-Runbook.md` |
| Notulen dan progres jobdesc | P13-12 | Selesai (internal) | `07_Evidence/P13-Standup-Minutes.md` (catatan progres asinkron, bukan risalah rapat) |
| Opsi hosting dan biaya | PR14-08 | Selesai (internal) | `04_Technology/P13-Hosting-Options.md` (empat opsi, termasuk Oracle Always Free $0); enam butir biaya belum diverifikasi untuk TCO |

## Catatan

- Review silang P13 dilewati lewat SK-021/CR-004. Status **Selesai (internal)** hanya menyatakan artefak lengkap dan diterima pemilik; bukan penilaian dosen dan bukan bukti review independen.
- Remote privat `https://github.com/hanansj789/sewakampus` aktif (SK-022/CR-005). `main` dan `dev` sudah di-push; branch per role: `feature/ceo-governance`, `feature/analyst-usecase`, `feature/database-model`, `feature/programmer-app`, `feature/network-devops`.
- Session 3 menambah `03_Application/ux/DESIGN.md`, prototipe hi-fi desktop tujuh layar, wireframe sembilan layar, dokumentasi, test case, dan rencana UAT.
- Pada 24 November 2026, PR14-06/07 ditambahkan pada branch `feature/pr14-local-login-role` berdasarkan pengecualian CR-003/SK-020. Test otomatis 16/16 dan smoke test browser lokal berhasil.
- Arah desain mewah-minimalis (gading–perunggu, Playfair Display) mengacu ke Inspirato, Turo, dan Hygglo. Foto Wikimedia Commons dipakai dengan kredit.
- `CODEOWNERS` tidak diwajibkan (SK-021). Remote privat dan lima branch role sudah ada (SK-022); collaborator menunggu username GitHub tiga anggota (T-01).
- PR14-01 dan PR14-08 ditutup internal pada 24 November 2026. Gate 1 tetap belum dinilai dosen.
