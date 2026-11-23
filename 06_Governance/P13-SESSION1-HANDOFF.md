# Handoff Session 1 — P13 SewaKampus

**Tanggal:** 23 November 2026
**Commit fondasi:** `e2aa158` di branch `main`, tanpa remote
**Status Gate 1:** belum dinilai dosen. Status internal: **bersyarat**, bukan hijau.

Dokumen ini adalah titik masuk session berikutnya. Baca berurutan: file ini, `P13-GAP-DECISIONS.md`, `07_Evidence/P13-Work-Board.md`, lalu `Skenario_Project ASP R001.txt` hlm. 15–17.

## 1. Yang sudah dikerjakan

| Artefak | Path | Status |
|---|---|---|
| Audit 35 deliverable | `06_Governance/P13-ASSET-AUDIT.md` | Ada |
| Keputusan dan gap | `06_Governance/P13-GAP-DECISIONS.md` | Ada |
| Vision v1.0 | `00_Vision/P13-Vision-v1.0.md` | Draf |
| MoSCoW dan lima Must | `00_Vision/P13-MoSCoW-Backlog.md` | Draf |
| Definition of Done | `06_Governance/P13-Definition-of-Done.md` | Draf |
| Team Charter | `06_Governance/P13-Team-Charter.md` | Draf, belum ditandatangani |
| Peta aset lama | `06_Governance/P13-ASSET-MAP.md` | Ada |
| Traceability 5 baris | `06_Governance/P13-Traceability-Matrix.md` | Draf, kolom use case dan layar kosong |
| Checklist Gate 1 | `06_Governance/P13-Gate-1-Checklist.md` | Ada, bersyarat |
| Papan kerja 4 kartu | `07_Evidence/P13-Work-Board.md` | Ada |
| Matriks 35 butir | `../P13-DELIVERABLE-MATRIX.md` | Ada |
| Fondasi repo | `README.md`, `CONTRIBUTING.md`, `.github/pull_request_template.md` | Ada |
| Desain session | `docs/superpowers/specs/2026-11-23-p13-session1-design.md` | Ada |

Struktur folder `00_Vision` sampai `09_Pitch` sudah dibuat. `08_Source/` masih kerangka kosong.

## 2. Keputusan yang terkunci

SK-001 sampai SK-013 di `P13-GAP-DECISIONS.md`. Ringkasnya:

- Lima Must: listing, kalender ketersediaan, persetujuan sewa, foto kondisi, rating. Tidak ada Must keenam.
- KTM, deposit simulasi, dan serah terima adalah kontrol alur, bukan Must.
- Dua Must untuk P14: listing dan kalender ketersediaan.
- Peran: Hanan CEO/PO + Analyst formal, Fharel pelaksana Analyst/UI/UX, Fazha Programmer + Database Architect, Mahesa Network/DevOps + QA/notulis.
- Semua pekerjaan lokal. Tidak ada remote GitHub pada Session 1.
- Mitra UAT belum ada; siapkan tiga pengguna proksi.
- Prototipe wajib hi-fi dan clickable.
- 14 entitas ERD adalah baseline yang harus diperiksa, bukan 3NF final.
- Roadmap lima minggu/M1–M6 dianggap historis.
- Tiga KPI adalah target perencanaan, bukan capaian.
- "Freeze" berarti baseline internal, bukan kelulusan gate.

## 3. Yang belum dikerjakan

1. Persetujuan dan tanda tangan empat anggota atas Vision serta Team Charter.
2. BPMN to-be dua proses: booking dan handover–return.
3. Use case, 5–8 user story, acceptance criteria, wireframe.
4. Perbaikan `HandoverCreateRequest` agar menerima foto kondisi.
5. Bukti 3NF per entitas dan DDL.
6. NFR, security baseline, topologi as-is lokasi mitra.
7. Notulen stand-up P13.
8. Konfirmasi mitra dan jadwal UAT.
9. Branch `dev` dan `feature/*`, CODEOWNERS, remote GitHub.
10. Commit per anggota.

## 4. Urutan kerja Session 2

1. **Kontrak API (Fazha).** Tambah field foto pada request handover, lalu pastikan `Handover` OUT dan RETURN menerima berkas. Tanpa ini M4 tidak bisa diuji.
2. **BPMN dua proses (Fharel).** Booking: diajukan, disetujui atau ditolak, diserahkan, dikembalikan, selesai. Handover: OUT dan RETURN dengan foto kondisi.
3. **Use case dan user story (Fharel).** Lima Must, satu use case per Must, 5–8 story dengan acceptance criteria.
4. **ERD 3NF (Fazha).** Periksa 14 entitas terhadap use case; tulis bukti normalisasi per entitas.
5. **Wireframe (Fharel).** Lima layar utama, lalu prototipe clickable.
6. **NFR dan topologi (Mahesa).** Dokumen terpisah dari diagram lama.
7. **Isi kolom use case dan layar di traceability (Hanan).** Gate 1 baru bisa diajukan setelah langkah ini.
8. **Tanda tangan charter dan persetujuan Vision (Hanan).** Tanpa ini Gate 1 tetap bersyarat.

Batas Session 2: berhenti sebelum menulis kode aplikasi. Kode dimulai setelah Gate 1 dinilai.

## 5. Peringatan untuk session berikutnya

- Jangan membuat remote GitHub atau push.
- Jangan mengubah `LAPORAN/`, `LAPORAN/VERSI/`, atau `ARSIP/`.
- Jangan mengubah SK-001 sampai SK-013 tanpa Change Request.
- Jangan menandai sesuatu "Ada" tanpa file yang bisa dibuka.
- Jangan mengisi status Hijau, Kuning, atau Merah. Itu hak dosen.
- Commit fondasi memakai identitas tim `SewaKampus Kelompok 1`, bukan nama anggota. Setiap anggota mengatur identitasnya sendiri sebelum commit berikutnya.

## 6. Prompt untuk Session 2

```text
Ini session baru untuk SewaKampus, sprint P13-P16, Session 2.

Baca berurutan sebelum menulis apa pun:
1. PROYEK/SEWAKAMPUS/ARCHITECTURE_REPOSITORY/06_Governance/P13-SESSION1-HANDOFF.md
2. PROYEK/SEWAKAMPUS/ARCHITECTURE_REPOSITORY/06_Governance/P13-GAP-DECISIONS.md
3. PROYEK/SEWAKAMPUS/ARCHITECTURE_REPOSITORY/07_Evidence/P13-Work-Board.md
4. PROYEK/SEWAKAMPUS/ARCHITECTURE_REPOSITORY/00_Vision/P13-Vision-v1.0.md
5. PROYEK/GROWPATH/Skenario_Project ASP R001.txt halaman 15, 16, dan 17

Sumber aturan tertinggi adalah TXT. Jangan mengubah keputusan SK-001 sampai SK-013.
Kerjakan sesuai urutan di bagian 4 handoff: perbaikan kontrak foto kondisi, BPMN dua proses,
use case dan user story, ERD 3NF, wireframe, NFR dan topologi, lalu traceability.
Jangan menulis kode aplikasi. Jangan membuat remote GitHub. Jangan mengklaim Gate 1 hijau.
Perbarui papan kerja dan matriks deliverable setelah setiap artefak selesai, dan sebut path buktinya.
```
