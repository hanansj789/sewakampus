**Status:** Selesai. Dokumentasi prototipe FigCraft SewaKampus versi mewah-minimalis (desktop). Bukan bukti kelulusan gate.

# PR14-03 — Prototipe FigCraft SewaKampus (Desktop)

**Tanggal:** 23 November 2026  
**Alat:** FigCraft. Bukan Figma.  
**Pemilik:** Fharel Sapvela Dwipa (pelaksana Analyst/UI/UX), Hanan Rizqullah (pemegang formal).

Wireframe desktop terpisah ada di `P13-06-Wireframe.md` dan `SewaKampus-Wireframe.figcraft`. Prototipe hi-fi ini adalah pasangan wireframe tersebut.

## 1. Berkas

| Berkas | Isi |
|---|---|
| `03_Application/ux/SewaKampus-High-Fidelity.figcraft` | Dokumen sumber (2 page: Desktop, Components) |
| `03_Application/ux/DESIGN.md` | Sistem desain mewah-minimalis |
| `03_Application/ux/assets/` | Tiga foto berlisensi + `credits.json` |
| `03_Application/ux/exports/L-00-components.png` | Page komponen |
| `03_Application/ux/exports/L-01-buat-listing.png` sampai `L-07-rating.png` | Tujuh layar alur |
| `03_Application/ux/exports/SewaKampus-Prototype-Flow.pdf` | PDF alur |

## 2. Alur tujuh layar

| Layar | Must | Isi |
|---|---|---|
| 01 Buat listing | M1 | Form judul, kategori, harga, deskripsi, lokasi, unggah foto |
| 02 Katalog | M1 | Hero serif, pencarian, tiga kartu barang |
| 03 Detail & Kalender | M1, M2 | Galeri foto, harga, pemilik, deskripsi, kalender, CTA |
| 04 Pengajuan sewa | M3 | Ringkasan barang, tanggal, rincian biaya, privasi, syarat |
| 05 Persetujuan pemilik | M3 | Dua pengajuan, profil penyewa, Setujui/Tolak |
| 06 Serah terima & foto kondisi | M4 | Foto OUT terunggah, RETURN kosong, konfirmasi dua pihak |
| 07 Rating | M5 | Ringkasan, rating 1–5, aspek, komentar |

Tujuh layar 1440 × 900 disusun satu baris pada page Desktop dengan nomor langkah dan panah penghubung, sehingga alur terbaca sekaligus.

## 3. Interaksi

01 Simpan listing → 02; 02 Cari → 03; 03 Pilih tanggal → 04; 04 Ajukan sewa → 05; 05 Setujui → 06; 06 Kirim catatan kondisi → 07. Semua dengan transisi dissolve 180 ms.

## 4. Membuka preview

1. Buka `SewaKampus-High-Fidelity.figcraft` di FigCraft.
2. Buka panel Prototype.
3. Mulai dari frame `01 Buat listing` pada page Desktop, lalu klik tombol utama untuk menyusuri alur sampai rating. `02 Katalog` adalah halaman pertama yang dilihat pengunjung; `01 Buat listing` adalah titik masuk pemilik yang sudah masuk.

## 5. Aksesibilitas

Kontras terukur: tinta 16,47:1, muted 4,81:1, perunggu 5,26:1 di kanvas dan 4,73:1 di permukaan lembut. Target tombol 52 px. Status tidak hanya warna: sel kalender terisi memakai arsir, penolakan wajib alasan, NIM dimasking, KTM hanya admin, foto kondisi hanya pihak transaksi dan admin sengketa.

## 6. Gambar dan kredit

- "Optima Projector" oleh Swethasakthivel, CC0, Wikimedia Commons.
- "Nikon DSLR camera D850" oleh Wolfgang Moroder, CC BY-SA 3.0, Wikimedia Commons.
- "JBL Flip 3 bluetooth speaker (DSCF2653)" oleh Trougnouf, CC BY 4.0, Wikimedia Commons.

Kredit tampil di footer tiap layar dan tercatat di `assets/credits.json`.

## 7. Batasan

- Desktop saja. Mobile, dark mode, dan multi-bahasa ditunda.
- Playfair Display dan Arial dipakai karena hanya itu serif/sans yang tersedia di mesin kerja.
- Cek piksel akhir milik pemilik produk karena pemeriksa tidak menilai gambar.
- Versi mobile dan desktop sebelumnya pada cabang ini digantikan versi mewah-minimalis ini.
