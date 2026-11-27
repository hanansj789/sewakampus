**Status:** Ada. Checklist Gate 3, 27 November 2026. Belum dinilai dosen.

# P15 — Paket Gate 3 Dry-run Pitch

**Pemilik:** Hanan Rizqullah (CEO/PO)
**Dasar:** TXT hlm. 34.

## 1. Lima butir resmi

| # | Butir | Status | Bukti | Yang kurang |
|---|---|---|---|---|
| 1 | MVP feature-complete, ter-deploy, bisa diakses dosen | **Siap** | Staging tunnel, lima Must, 76 tes | UAT belum |
| 2 | Laporan UAT dengan bukti dan skor SUS | **Belum** | `07_Evidence/P15-UAT-Plan.md`, `P15-SUS-Template.xlsx` | Sesi UAT dan skor nyata |
| 3 | Architecture Roadmap dan rencana migrasi | **Selesai** | `05_Opportunities/P15-Roadmap-Migration.md` | — |
| 4 | Restore backup terbukti | **Selesai** | `07_Evidence/P15-Restore-Test.md` | — |
| 5 | Dry-run pitch 7 menit dan peer review | **Bersyarat** | `09_Pitch/P15-Dry-Run-Pitch.md`, `07_Evidence/P15-Peer-Review-Template.md` | Latihan dan pelaksanaan |

## 2. Yang sudah lengkap

- Lima Must berjalan dan diuji.
- Staging dapat dibuka lewat HTTPS.
- Roadmap, work package, dan migration plan tersedia.
- Backup dan restore terbukti dengan angka.
- TCO tiga skenario.
- Gap analysis 20 butir.

## 3. Yang menahan Gate 3

Hanya dua: **UAT** dan **latihan pitch**. Keduanya butuh orang, bukan dokumen.

Rencana UAT siap. Yang dibutuhkan: tiga peserta, satu pencatat, staging hidup, dan satu jam.

## 4. Setelah UAT

1. Isi `P15-SUS-Template.xlsx`, lalu tulis `07_Evidence/P15-UAT-SUS.md` dengan hasil nyata.
2. Perbaiki temuan prioritas; catat yang tidak sempat diperbaiki.
3. Perbarui slide 8 pada naskah pitch.
4. Latih pitch dua kali dengan pengatur waktu.
5. Jalankan dry-run dan kumpulkan peer review.

## 5. Aturan

- Jangan mengisi skor SUS sebelum sesi.
- Jangan menyebut peserta sebagai mitra bila mereka proksi.
- Jangan mengklaim Gate 3 hijau; status warna milik dosen.
- Jangan menambah fitur setelah Gate 3; hanya bug dan perbaikan copy.
