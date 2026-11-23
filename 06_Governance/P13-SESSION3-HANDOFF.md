**Status:** Ada. Handoff Session 3 untuk session berikutnya.

# P13 — Handoff Session 3: Prototipe FigCraft

**Tanggal:** 23 November 2026  
**Penerus:** Session 4 (implementasi dan kesiapan Gate 2)  
**Pembaca wajib:** `P13-STATUS.md`, `DECISIONS.md`, `03_Application/ux/DESIGN.md`, `03_Application/ux/PR14-03-Prototype-FigCraft.md`.

## 1. Apa yang dikerjakan

Session 3 membangun prototipe hi-fi SewaKampus di FigCraft sesuai `DESIGN.md`.

- Sistem desain: 40 variable, 23 style, 17 komponen pada halaman Foundations and Components.
- Sembilan layar S-01 sampai S-09 pada mobile 390 × 844 dan desktop 1440 × 900.
- Delapan belas frame utama (S-01 sampai S-09 pada dua ukuran) ditambah dua varian S-06 RETURN.
- Dua belas state penting dan empat flow prototype.
- Dua puluh satu interaksi klik yang menghubungkan alur lima Must.
- Ekspor dua puluh PNG dan satu PDF alur.
- Lima belas test case black-box dan rencana UAT dengan SUS.

## 2. Berkas baru

| Berkas | Isi |
|---|---|
| `03_Application/ux/DESIGN.md` | Sistem desain |
| `03_Application/ux/SewaKampus-High-Fidelity.figcraft` | Sumber prototipe |
| `03_Application/ux/PR14-03-Prototype-FigCraft.md` | Dokumentasi prototipe |
| `03_Application/ux/exports/` | PNG dan PDF bukti |
| `07_Evidence/P14-Test-Cases.md` | 15 test case |
| `07_Evidence/P15-UAT-Plan.md` | Rencana UAT dan SUS |

## 3. Yang sudah diverifikasi

- Frame utama tepat 390 × 844 dan 1440 × 900.
- Sepuluh halaman, empat puluh variable, dua puluh tiga style, tujuh belas komponen.
- Empat flow dan dua puluh satu interaksi dengan tujuan yang valid.
- Kontras teks utama dan sekunder memenuhi 4,5:1 dari nilai token.
- Dua puluh PNG memiliki header PNG valid dan PDF berawal `%PDF`.
- Tidak ada placeholder, lorem, atau hasil UAT fiktif.

## 4. Yang belum diverifikasi

- Cek piksel akhir. Pemeriksa otomatis tidak dapat menilai gambar, sehingga pemilik produk harus melihat PNG atau preview.
- Preview FigCraft belum diklik manual oleh manusia.
- Test case belum dijalankan karena aplikasi belum ada.
- DDL dan seed belum dijalankan di database kosong.

## 5. Keputusan terbuka

- Libre Baskerville dan Source Sans 3 tidak tersedia; fallback Georgia dan Arial dipakai.
- Retensi berkas KTM belum ditetapkan.
- Endpoint pengguna untuk membuka sengketa belum ada pada kontrak API.

## 6. Langkah berikutnya

1. Pemilik produk meninjau visual prototipe di FigCraft dan mengonfirmasi `DESIGN.md`.
2. Review silang seluruh artefak Session 3 oleh anggota lain.
3. Session 4 memulai implementasi dua Must pertama, DDL, dan login lokal.
