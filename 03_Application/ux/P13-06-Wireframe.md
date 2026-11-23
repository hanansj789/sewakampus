**Status:** Ada. Wireframe desktop untuk P13-06. Bukan prototipe interaktif.

# P13-06 — Wireframe SewaKampus (Desktop)

**Tanggal:** 23 November 2026  
**Alat:** FigCraft. Bukan Figma.  
**Struktur mengikuti:** `PROYEK/GROWPATH/APP-DEV/design/Growpath-Wireframe-P13.figcraft`.

## 1. Berkas

| Berkas | Isi |
|---|---|
| `03_Application/ux/SewaKampus-Wireframe.figcraft` | Sumber wireframe |
| `03_Application/ux/exports/WF-01-buat-listing.png` sampai `WF-07-rating.png` | Tujuh layar wireframe |
| `03_Application/ux/exports/WF-states.png` | Halaman States |
| `03_Application/ux/exports/WF-flow.png` | Halaman Flow |
| `03_Application/ux/exports/SewaKampus-Wireframe.pdf` | PDF tujuh layar |

## 2. Gaya

Low-fi abu-abu: latar putih, panel `#F2F2F2`, foto `#E6E6E6`, garis `#D9D9D9`, tinta `#333333`. Tanpa warna merek, tanpa foto berwarna, tanpa bayangan. Isi dinamis ditulis sebagai placeholder ber-kurung, misalnya `[Nama barang]` dan `[Harga]`. Arial untuk semua teks.

## 3. Halaman

| Page | Isi |
|---|---|
| Desktop | Tujuh layar: Buat listing, Katalog, Detail & Kalender, Pengajuan, Persetujuan, Serah terima & foto kondisi, Rating. Tiap layar 1440 × 1140 (area layar 900 px + blok anotasi 200 px) |
| States | Contoh empty, loading, error data, error form, dan lima state form Buat listing (kosong, terisi, validasi gagal, unggah berhasil, unggah gagal) |
| Flow | Diagram alur: MULAI, kotak layar (Buat listing → Katalog → … → Rating), panah, catatan perulangan dan cabang |

Setiap layar desktop 1440 × 1140: area layar 900 px dan blok anotasi 200 px.

## 4. Anotasi per layar

Setiap layar memuat: Pertanyaan, Primary, Blok, Data, dan State. Contoh untuk Detail & Kalender: pertanyaan "Apakah barang tersedia pada tanggal yang saya butuhkan?", primary "Pilih tanggal", data `item, item_photo, availability, booking`, state "tersedia, terisi, diblokir, bentrok".

## 5. Kaitan dengan lima Must

Buat listing (M1), Katalog (M1), Detail & Kalender (M2), Pengajuan dan Persetujuan (M3), Serah terima & foto kondisi (M4), Rating (M5). Verifikasi KTM dan sengketa menjadi kontrol alur yang dicatat di Flow.

## 6. Catatan

- Wireframe desktop saja, sesuai arahan pemilik. Mobile tidak dibuat.
- Wireframe ini melengkapi prototipe hi-fi `SewaKampus-High-Fidelity.figcraft` (PR14-03), sesuai tuntutan TXT hlm. 15: wireframe dan prototipe hi-fi.
- Cek piksel akhir milik pemilik produk.
