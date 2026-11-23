**Status:** Ada. Dokumentasi prototipe FigCraft SewaKampus. Bukan bukti kelulusan gate.

# PR14-03 — Prototipe FigCraft SewaKampus

**Tanggal:** 23 November 2026  
**Alat:** FigCraft. Bukan Figma.  
**Pemilik:** Fharel Sapvela Dwipa (pelaksana Analyst/UI/UX), Hanan Rizqullah (pemegang formal).

## 1. Berkas

| Berkas | Isi |
|---|---|
| `03_Application/ux/SewaKampus-High-Fidelity.figcraft` | Dokumen sumber prototipe |
| `03_Application/ux/DESIGN.md` | Sistem desain yang menjadi acuan |
| `03_Application/ux/exports/S-01-mobile.png` sampai `S-09-mobile.png` | PNG tiap layar mobile |
| `03_Application/ux/exports/S-01-desktop.png` sampai `S-09-desktop.png` | PNG tiap layar desktop |
| `03_Application/ux/exports/S-06-mobile-return.png` | Varian RETURN mobile |
| `03_Application/ux/exports/S-06-desktop-return.png` | Varian RETURN desktop |
| `03_Application/ux/exports/SewaKampus-Prototype-Flow.pdf` | PDF alur utama |

## 2. Daftar layar

| Layar | Nama | Use case | Must |
|---|---|---|---|
| S-01 | Form listing | UC-01 | M1 |
| S-02 | Daftar listing saya | UC-01 | M1 |
| S-03 | Detail barang dan kalender | UC-02 | M2 |
| S-04 | Pengajuan sewa | UC-03 | M3 |
| S-05 | Persetujuan pemilik | UC-03 | M3 |
| S-06 | Serah terima dan foto kondisi | UC-04 | M4 |
| S-07 | Rating setelah transaksi | UC-05 | M5 |
| S-08 | Antrean verifikasi admin | UC-06 | M1, kontrol prasyarat |
| S-09 | Sengketa admin | UC-07 | M4, cabang pengecualian |

Setiap layar dibuat pada dua ukuran: mobile 390 × 844 dan desktop 1440 × 900. S-06 memiliki varian OUT dan RETURN pada kedua ukuran, sehingga total frame utama berjumlah dua puluh.

## 3. Peta interaksi

Alur utama mobile dan desktop sama. Panah berikut memakai tombol utama setiap layar.

1. S-01 Simpan listing ke S-02.
2. S-02 ke S-03 katalog.
3. S-03 Pilih tanggal ke S-04.
4. S-04 Ajukan sewa ke S-05.
5. S-05 Setujui ke S-06 OUT.
6. S-06 OUT kirim catatan ke S-06 RETURN.
7. S-06 RETURN kirim catatan ke S-07.
8. S-07 Kirim rating mengakhiri alur.
9. S-08 setujui verifikasi ke S-01.
10. S-05 Tolak ke state pengajuan ditolak.

Titik gagal lain diwakili state pada halaman `States and Prototype`: form invalid, tanggal bentrok, pengajuan ditolak, unggah gagal, handover menunggu konfirmasi, sengketa terbuka, verifikasi ditolak, loading, dan empty state.

## 4. Membuka preview

1. Buka `SewaKampus-High-Fidelity.figcraft` di FigCraft.
2. Buka panel Prototype.
3. Pilih flow pada daftar berikut.

| Flow | Mulai dari |
|---|---|
| SewaKampus / Mobile / Alur utama | S-03 |
| SewaKampus / Desktop / Alur utama | S-03 |
| SewaKampus / Mobile / Admin | S-08 |
| SewaKampus / Desktop / Admin | S-08 |

## 5. Hasil cek aksesibilitas

Cek dilakukan secara struktural pada dokumen, bukan pada hasil raster.

- Semua frame utama tepat 390 × 844 atau 1440 × 900.
- Teks utama memakai `#17211D` dengan kontras 14,99:1 pada krem dan 16,51:1 pada putih.
- Teks sekunder memakai `#4D5B55` dengan kontras 6,48:1 pada krem dan 7,14:1 pada putih.
- Tombol utama setinggi 48 px dan app bar 56 px, memenuhi target sentuh 44 px.
- Status selalu memuat label teks, bukan hanya warna.
- NIM dimasking, KTM dibatasi untuk admin, lokasi rinci ditahan sampai persetujuan, dan foto kondisi dibatasi untuk pihak transaksi serta admin sengketa.
- Cek piksel akhir dilakukan oleh pemilik produk karena pemeriksa otomatis tidak dapat menilai gambar.

## 6. Batasan

- FigCraft dipakai karena tidak ada akses Figma. Ekspor `.fig` eksperimental tidak dijadikan bukti utama.
- Libre Baskerville dan Source Sans 3 tidak tersedia di mesin kerja. Font fallback Georgia dan Arial dipakai sesuai `DESIGN.md`.
- Kalender digambar sebagai teks, bukan sel interaktif individual.
- Interaksi S-08 memakai klik frame, bukan tombol, karena keputusan Setujui dan Tolak digambar sebagai teks inline.
- S-02 memakai rantai maju ke S-03 sesuai rencana; label "Buat listing" secara semantik kembali ke S-01 dan terbuka untuk ditinjau pemilik.
- Endpoint pengguna untuk membuka sengketa belum ada pada kontrak API. S-09 menampilkan sisi admin dan asal bukti tanpa mengklaim endpoint pengguna.

## 7. Referensi dan batas pemakaian

Referensi Growlio dipakai untuk lapisan brand. Contoh FigCraft Growpath dipakai untuk mempelajari organisasi page, komponen, state, dan flow. SewaKampus tidak menyalin komponen, token, isi, atau struktur visual keduanya.
