**Status:** Ada. Handoff Session 3 untuk session berikutnya.

# P13 — Handoff Session 3: Prototipe FigCraft

**Tanggal:** 23 November 2026  
**Penerus:** Session 4 (implementasi dan kesiapan Gate 2)  
**Pembaca wajib:** `P13-STATUS.md`, `DECISIONS.md`, `03_Application/ux/DESIGN.md`, `03_Application/ux/PR14-03-Prototype-FigCraft.md`.

## 1. Apa yang dikerjakan

Session 3 dan 3b membangun prototipe hi-fi dan wireframe SewaKampus di FigCraft sesuai `DESIGN.md`.

- Prototipe hi-fi: tujuh layar desktop 1440 × 900 (Buat listing, Katalog, Detail & Kalender, Pengajuan, Persetujuan, Serah terima & foto kondisi, Rating) dalam satu alur terhubung, plus page Components. Arah gading–perunggu, Playfair Display + Arial.
- Wireframe: tujuh layar desktop 1440 × 1140 (layar + anotasi) pada page Desktop, plus page States dan Flow. Low-fi abu-abu.
- Tiga foto berlisensi Wikimedia Commons (proyektor CC0, kamera CC BY-SA 3.0, speaker CC BY 4.0) dengan kredit.
- Enam interaksi klik: 01 → 02 → 03 → 04 → 05 → 06 → 07.
- Ekspor tujuh PNG hi-fi, tujuh PNG wireframe, States, Flow, dan dua PDF.
- Lima belas test case black-box dan rencana UAT dengan SUS.

## 2. Berkas baru

| Berkas | Isi |
|---|---|
| `03_Application/ux/DESIGN.md` | Sistem desain |
| `03_Application/ux/SewaKampus-High-Fidelity.figcraft` | Prototipe hi-fi |
| `03_Application/ux/SewaKampus-Wireframe.figcraft` | Wireframe |
| `03_Application/ux/P13-06-Wireframe.md` | Dokumentasi wireframe |
| `03_Application/ux/PR14-03-Prototype-FigCraft.md` | Dokumentasi prototipe |
| `03_Application/ux/assets/` | Tiga foto berlisensi + kredit |
| `03_Application/ux/exports/` | PNG dan PDF bukti |
| `07_Evidence/P14-Test-Cases.md` | 15 test case |
| `07_Evidence/P15-UAT-Plan.md` | Rencana UAT dan SUS |

## 3. Yang sudah diverifikasi

- Tujuh frame hi-fi tepat 1440 × 900; tujuh frame wireframe 1440 × 1140.
- Dua page hi-fi (Desktop, Components); empat page wireframe (Desktop, Mobile kosong, States, Flow).
- Enam interaksi dengan tujuan valid (01 sampai 07).
- Kontras: tinta 16,47:1, muted 4,81:1, perunggu 5,26:1 di kanvas dan 4,73:1 di permukaan lembut.
- Render PNG dibaca untuk Buat listing (hi-fi dan wireframe) dan Detail & Kalender.
- Tidak ada placeholder di hi-fi; wireframe memang memakai placeholder ber-kurung sesuai gaya low-fi.

## 4. Yang belum diverifikasi

- Cek piksel akhir. Pemeriksa otomatis tidak dapat menilai gambar, sehingga pemilik produk harus melihat PNG atau preview.
- Preview FigCraft belum diklik manual oleh manusia.
- Test case belum dijalankan karena aplikasi belum ada.
- DDL dan seed belum dijalankan di database kosong.

## 5. Keputusan terbuka

- Font: Playfair Display untuk display, Arial untuk body. Keduanya tersedia di mesin kerja.
- Retensi berkas KTM belum ditetapkan.
- Endpoint pengguna untuk membuka sengketa belum ada pada kontrak API.

## 6. Langkah berikutnya

1. Pemilik produk meninjau visual prototipe di FigCraft dan mengonfirmasi `DESIGN.md`.
2. Review silang seluruh artefak Session 3 oleh anggota lain.
3. Session 4 memulai implementasi dua Must pertama, DDL, dan login lokal.
