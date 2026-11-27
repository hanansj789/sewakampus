**Status:** Ada. Bukti uji M1 di lingkungan lokal, 27 November 2026.

# M1 — Bukti Listing Barang End-to-End

**Pemilik:** Muhammad Fazha Nararya Nugraha (Programmer)
**Branch:** `feature/programmer-m1-listing`
**Tanggal:** 27 November 2026
**Lingkungan:** MySQL 8.0.43 port 3311, Laravel 11.57.1, PHP 8.4.0
**Sifat:** bukti uji fitur. Bukan penilaian gate dan bukan klaim bahwa P14 selesai.

## 1. Yang dikerjakan

| Bagian | Isi |
|---|---|
| Model | `Item`, `ItemCategory`, `ItemPhoto` |
| Controller | `ItemController`: katalog, form, simpan, ubah, jeda, unggah foto, sajikan foto |
| Rute | `/items`, `/items/create`, `/items/{item}/edit`, `PATCH`, `/pause`, `/photos` |
| Tampilan | `layouts/app`, `items/index`, `items/create`, `items/edit`, `items/_form` |
| Gaya | `public/css/items.css` memakai variabel warna `auth.css` |
| Uji | `tests/Feature/ItemListingTest.php`, 11 kasus |

## 2. Perilaku yang dibuktikan

| Perilaku | Bukti |
|---|---|
| Tamu tidak bisa membuka katalog | tes: redirect ke `/login` |
| Mahasiswa bisa membuka katalog dan form | tes: HTTP 200 |
| Listing dengan foto langsung `ACTIVE` dan tampil di katalog | tes: status, jumlah foto, foto utama, file ada di disk |
| Listing tanpa foto menjadi `DRAFT` dan tidak tampil | tes: status dan katalog |
| Validasi menolak judul kosong dan kondisi tidak sah | tes: error `title`, `condition` |
| Bukan pemilik tidak bisa mengubah atau menjeda | tes: 403 |
| Unggahan bukan gambar ditolak | tes: error `photo` |
| Pemilik bisa menjeda dan mengaktifkan lagi | tes: status `PAUSED` lalu `ACTIVE`, hilang dan muncul di katalog |
| Pemilik bisa mengubah listing | tes: judul berubah |
| Form edit menampilkan foto dan penanda foto utama | tes: halaman edit HTTP 200 |

## 3. Hasil uji

| Perintah | Hasil |
|---|---|
| `DB_PORT=3311 php artisan test --filter=ItemListingTest` | 11 lulus, 37 assertion |
| `DB_PORT=3311 php artisan test` | 27 lulus, 107 assertion |

Sebelas tes M1 ditambah enam belas tes auth lama; tidak ada regresi.

## 4. Cacat yang ditemukan dan diperbaiki

Waktu membuat listing baru, item tidak muncul di halaman pertama katalog. Penyebabnya: zona waktu aplikasi masih `UTC`, sementara MySQL menulis `CURRENT_TIMESTAMP` pada zona sistem (UTC+7). Baris seed tercatat tujuh jam lebih maju, sehingga listing baru dianggap paling lama.

Perbaikan: `config/app.php` memakai `env('APP_TIMEZONE', 'Asia/Jakarta')`, sesuai NFR-K02. Setelah itu urutan katalog benar.

## 5. Yang belum

| Hal | Alasan |
|---|---|
| Pemeriksaan tampilan di peramban | dilakukan Fharel pada Fase 3 (cek UI vs prototipe) |
| Penyimpanan foto di MinIO | staging memakai MinIO; lokal memakai disk privat (SK-027) |
| Gaya halaman paginasi | masih memakai markup bawaan Laravel, belum ditata |
| Foto lebih dari satu dari form awal | form awal menerima satu foto; foto tambahan lewat halaman kelola |

## 6. Perintah reproduksi

```bash
cd ARCHITECTURE_REPOSITORY/08_Source
DB_PORT=3311 php artisan test
DB_PORT=3311 php artisan serve --host=127.0.0.1 --port=8000
```

Catatan: `pint --test` masih gagal pada hampir semua berkas lama karena perbedaan line ending CRLF/LF di repo. Kegagalan itu sudah ada sebelum M1 dan tidak ditutup di sini.
