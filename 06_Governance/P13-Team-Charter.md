# Team Charter — Kelompok 1 SewaKampus

**Status:** Final (internal). Empat tanda tangan tercatat; tanggal tanda tangan ditetapkan 23 November 2026 oleh pemilik proyek.
**PDF final:** `06_Governance/P13-Team-Charter.pdf` — charter lengkap dengan empat tanda tangan tertanam.
**Tanggal dokumen:** 23 November 2026; tanggal tanda tangan 23 November 2026; bukti gambar diperiksa 24 November 2026.
**Masa berlaku:** P13 sampai P16.

## Anggota dan peran

| Nama | NIM | Peran utama | Peran tambahan | Bukti kerja yang diharapkan |
|---|---|---|---|---|
| Hanan Rizqullah | F1E124017 | CEO / Product Owner | Pemegang formal System Analyst dan UI/UX (TXT hlm. 6), pemilik keputusan lingkup | Vision, MoSCoW, DoD, charter, keputusan Change Request |
| Fharel Sapvela Dwipa | F1E124048 | System Analyst & UI/UX (pelaksana) | Reviewer ketelusuran | BPMN to-be, use case, user story, wireframe, prototipe |
| Muhammad Fazha Nararya Nugraha | F1E124041 | Programmer | Database Architect, pemilik kontrak API | Struktur aplikasi, OpenAPI, ERD 3NF, DDL, seed |
| Mahesa Kanaka Raya | F1E124062 | Network / DevOps | QA dan notulis P13 (TXT hlm. 6: QA bergilir per pertemuan) | Topologi, NFR, security baseline, host, notulen |

Pergantian peran setelah P13 hanya dengan persetujuan dosen.

## Cara kerja

- **Ritme:** satu stand-up singkat setiap pertemuan, dicatat Mahesa di `07_Evidence/`.
- **Satu kartu satu orang:** pekerjaan diambil dari `07_Evidence/P13-Work-Board.md`, tidak ada dua orang mengerjakan file yang sama bersamaan.
- **Review silang:** penulis dan reviewer selalu orang berbeda. Hanan tidak mereview pekerjaannya sendiri; Fharel tidak mereview artefak yang ia tulis. **Review silang P13 dilakukan 24 November 2026 (SK-024);** aturan ini berlaku untuk fitur Must dan gate berikutnya.
- **Batas waktu:** kartu yang lewat satu pertemuan tanpa progres dipindahkan ke anggota lain atau dipersempit lingkupnya.
- **Komunikasi:** keputusan yang mengubah lingkup, ERD, API, atau Must ditulis di `SEWAKAMPUS/DECISIONS.md`, bukan hanya di chat.

## Aturan keputusan

1. Keputusan lingkup produk diambil Hanan sebagai CEO/PO setelah mendengar tiga anggota.
2. Keputusan teknis diusulkan Fazha atau Mahesa, disetujui Hanan, dicatat sebagai ADR.
3. Jika dua anggota bertahan pada pendapat berbeda, Hanan memutuskan dan alasannya ditulis.
4. Perubahan setelah Gate 1 hanya lewat Change Request.

## Aturan kejujuran

- Tidak mengarang nama mitra, username, URL repo, angka UAT, biaya, atau status gate.
- Klaim "selesai" wajib disertai path file atau tautan yang bisa dibuka.
- Tidak ada commit atas nama anggota yang tidak mengerjakan bagian itu.
- Keterlambatan dan pekerjaan yang belum selesai dicatat apa adanya di papan kerja.

## Pembagian review

| Artefak | Penyusun | Reviewer |
|---|---|---|
| Vision, MoSCoW, DoD | Hanan | Fharel |
| BPMN, use case, user story, wireframe, prototipe | Fharel | Hanan |
| ERD, kamus data, 3NF, OpenAPI, DDL | Fazha | Mahesa |
| Topologi, NFR, security baseline, hosting | Mahesa | Fazha |
| Traceability dan checklist gate | Hanan | Fharel dan Fazha |

## Tanda tangan

| Nama | Tanda tangan | Tanggal |
|---|---|---|
| Hanan Rizqullah | Bukti gambar: `../../Tanda Tangan Kelompok/Hanan.jpeg` | 23 November 2026 |
| Fharel Sapvela Dwipa | Bukti gambar: `../../Tanda Tangan Kelompok/Fharel.jpeg` | 23 November 2026 |
| Muhammad Fazha Nararya Nugraha | Bukti gambar: `../../Tanda Tangan Kelompok/Faza.jpeg` (nama file yang diberikan) | 23 November 2026 |
| Mahesa Kanaka Raya | Bukti gambar: `../../Tanda Tangan Kelompok/Mahesa.jpeg` | 23 November 2026 |

Catatan bukti: empat JPEG berisi tanda tangan goresan tangan dan nama file masing-masing sesuai nama anggota. Review silang P13 telah dilakukan dan disetujui. Tanggal 23 November 2026 adalah tanggal yang ditetapkan pemilik proyek; tanggal itu tidak tercetak pada gambar. Waktu modifikasi file tidak dipakai sebagai bukti tanggal. Identitas penanda tangan tidak dapat diverifikasi secara kriptografis dari gambar saja. Pemilik proyek meminta bukti tersebut dicatat sebagai tanda tangan anggota. PDF final `06_Governance/P13-Team-Charter.pdf` menanamkan keempat gambar tersebut agar charter menjadi satu dokumen utuh di repo; JPEG asli tetap berada di `Tanda Tangan Kelompok/` di luar repo.
