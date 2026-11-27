**Status:** Ada. Pemeriksaan awal dengan peramban nyata, 27 November 2026.

# Pemeriksaan Awal M1 dan M2 di Peramban

**Penguji:** sesi pengembangan atas nama Fazha (Programmer), sebelum uji formal Analyst
**Alat:** Chromium melalui Playwright, layar 1440 × 900
**Lingkungan:** Laravel 8000, Keycloak 8080, MySQL 3311
**Sifat:** pemeriksaan awal untuk menemukan cacat sebelum uji black-box formal. **Bukan** UAT dan bukan uji formal Fharel.

## 1. Yang diperiksa

Masuk lewat Keycloak sebagai `hanan`, lalu menjalankan lima test case yang bisa diuji sekarang (TC-01 sampai TC-05). Sepuluh kasus lain menuntut M3 sampai M5 yang belum dibangun.

| TC | Skenario | Hasil | Catatan |
|---|---|---|---|
| TC-01 | Simpan listing tanpa mengisi judul | Lulus | Peramban menahan lewat validasi `required`; validasi server dibuktikan tes otomatis |
| TC-02 | Simpan listing tanpa foto | Lulus | Tersimpan `DRAFT`, pesan "Listing disimpan sebagai draf", tampil di "Barang saya", tidak di katalog |
| TC-03 | Unggah berkas bukan gambar | Lulus setelah perbaikan | Sebelumnya pesan bahasa Inggris, sekarang "Foto harus berupa gambar." |
| TC-04 | Kalender menandai tanggal terpakai | Lulus | 1 Des dan 24 Des bertanda terpakai, 4 Des tersedia |
| TC-05 | Rentang bertabrakan dengan booking | Lulus | Endpoint menjawab `available=false` dengan konflik `BOOKING` 1–3 Des |

## 2. Cacat yang ditemukan

| # | Cacat | Dampak | Perbaikan |
|---|---|---|---|
| 1 | Pesan validasi berbahasa Inggris ("The photo field must be an image.") | Tidak sesuai aturan bahasa Indonesia | `lang/id/validation.php` dan `APP_LOCALE` bawaan `id` |
| 2 | Foto hasil seed menunjuk berkas yang tidak ada, sehingga katalog menampilkan gambar rusak dan 12 galat konsol | Tampilan katalog terlihat rusak | Tampilan memeriksa keberadaan berkas; jika tidak ada, tampil "Belum ada foto" |
| 3 | Seluruh 30 baris `item_photos` seed tidak punya berkas nyata | Data uji tidak lengkap | Dicatat sebagai keterbatasan seed; foto akan diisi lewat unggahan nyata |

Cacat 1 dan 2 diperbaiki pada PR ini dan diuji ulang di peramban:

- Katalog: 0 gambar rusak, 12 placeholder.
- Unggah PDF: pesan "Foto harus berupa gambar."

## 3. Bukti

| Berkas | Isi |
|---|---|
| `07_Evidence/screenshots/P14-katalog-2026-11-27.png` | Katalog setelah perbaikan |
| `07_Evidence/screenshots/P14-kalender-desember-2026.png` | Kalender Desember 2026 dengan tanggal terpakai |

## 4. Hasil tes otomatis

| Perintah | Hasil |
|---|---|
| `DB_PORT=3311 php artisan test` | 39 lulus, 132 assertion |

Dua tes baru: pesan validasi berbahasa Indonesia, dan katalog menampilkan placeholder saat berkas foto tidak ada.

## 5. Yang belum

- TC-06 sampai TC-15 menunggu M3 (pengajuan, persetujuan), M4 (handover), M5 (rating).
- Uji formal 15 kasus oleh Analyst dan perbandingan tampilan dengan prototipe tetap tugas Fharel pada Fase 3.
- Halaman belum diuji pada lebar 390 px setelah perubahan ini.
