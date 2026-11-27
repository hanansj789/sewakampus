**Status:** Ada. Catatan QA P14, 28 November 2026.

# P14 — QA Dua Fitur Pertama (M1 dan M2)

**Penguji:** Hanan Rizqullah (QA P14)
**Lingkungan:** staging `https://cakes-clicks-berlin-alan.trycloudflare.com`
**Commit:** `9df8ce1`
**Sifat:** uji manual QA internal. Bukan penilaian gate.

## 1. Lingkup

Dua Must pertama sesuai SK-003: M1 listing barang dan M2 kalender ketersediaan. Pengujian dilakukan lewat peramban pada aplikasi staging, bukan tes otomatis saja.

## 2. Hasil

| Kode | Yang diuji | Langkah | Hasil | Status |
|---|---|---|---|---|
| QA-01 | Masuk lewat Keycloak | Buka `/items`, diarahkan ke login, masuk sebagai `hanan` | Sampai `/student/dashboard` | Lulus |
| QA-02 | Katalog terbuka | Buka menu Katalog | 12 kartu tampil, foto placeholder bila berkas tidak ada | Lulus |
| QA-03 | Buat listing dengan foto | Isi form lengkap, unggah PNG 640×480, simpan | Pesan "Listing aktif dan sudah tampil di katalog", status ACTIVE | Lulus |
| QA-04 | Listing muncul di "Barang saya" | Buka filter Milik saya | "Kamera QA 28 Nov" di urutan pertama | Lulus |
| QA-05 | Jeda listing | Buka kelola, klik Jeda listing | Status PAUSED, pesan "hilang dari katalog" | Lulus |
| QA-06 | Jeda benar-benar menyembunyikan | Buka katalog umum | Barang tidak tampil | Lulus |
| QA-07 | Kalender Desember 2026 | Buka `/items/1?month=2026-12` | Label "Desember 2026", tanggal 1 dan 24 bertanda terpakai | Lulus |
| QA-08 | Tanggal kosong tetap kosong | Amati 4 Desember | Bertanda tersedia | Lulus |

Bukti gambar: `07_Evidence/screenshots/P14-qa-kalender-2026-11-28.png`.

## 3. Cacat yang ditemukan pada pengujian sebelumnya

| Cacat | Dampak | Status |
|---|---|---|
| Pesan validasi berbahasa Inggris | Membingungkan pengguna | Diperbaiki, pesan Indonesia |
| Foto seed menunjuk berkas tidak ada | Katalog menampilkan gambar rusak | Diperbaiki dengan placeholder |
| Redirect tamu ke `http` di belakang tunnel | Pengunjung dilempar ke versi tidak aman | Diperbaiki lewat `trustProxies` |

Ketiganya ditemukan sebelum catatan ini dan sudah diuji ulang.

## 4. Data uji yang ditinggalkan

Satu listing "Kamera QA 28 Nov" (id 118) dibuat lalu dijeda, sebagai bukti QA-03 sampai QA-06. Listing tetap ada di database pengembangan dengan status PAUSED.

## 5. Yang tidak diuji di sini

- M3 sampai M5; sudah diuji terpisah di `P14-M3-Run.md`, `P14-M4-Run.md`, `P15-M5-Run.md`.
- Tampilan pada lebar 390 px; masuk cek UI oleh Analyst.
- Beban dan dua permintaan bersamaan.

## 6. Kesimpulan

Dua Must pertama berjalan di staging dengan database nyata dan dapat didemokan. Catatan ini memenuhi tuntutan P14 "uji 2 fitur pertama". Gate 2 tetap menunggu penilaian dosen.
