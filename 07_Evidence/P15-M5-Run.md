**Status:** Ada. Bukti uji M5, 27 November 2026.

# M5 — Bukti Rating dan Ulasan

**Pemilik:** Muhammad Fazha Nararya Nugraha (Programmer)
**Branch:** `feature/programmer-m5-rating`
**Tanggal:** 27 November 2026
**Sifat:** bukti uji fitur. Bukan penilaian gate.

## 1. Yang dikerjakan

| Bagian | Isi |
|---|---|
| Model | `Review`; relasi `Booking::reviews()` dan `Item::reviews()` lewat booking |
| Controller | `ReviewController`: form rating, simpan rating, hitung ulang rata-rata barang |
| Rute | `GET /bookings/{booking}/review`, `POST /bookings/{booking}/reviews` |
| Tampilan | halaman rating, tautan "Beri rating" pada pengajuan selesai, daftar ulasan di halaman barang |
| Uji | `tests/Feature/ReviewTest.php`, 10 kasus |

## 2. Aturan yang diberlakukan

1. Rating hanya untuk booking berstatus `COMPLETED`.
2. Hanya penyewa dan pemilik booking yang boleh menilai.
3. Peran ditentukan dari data booking: penyewa → `RENTER`, pemilik → `OWNER`.
4. Satu rating per peran per booking. Percobaan kedua ditolak 409.
5. Rating bilangan bulat 1 sampai 5; komentar opsional maksimal 1000 karakter.
6. Setelah rating tersimpan, `items.average_rating` dan `items.review_count` dihitung ulang dari seluruh review `PUBLISHED` pada barang itu.
7. Pihak yang dinilai menerima baris notifikasi `REVIEW_RECEIVED`.

## 3. Hasil uji otomatis

| Perintah | Hasil |
|---|---|
| `DB_PORT=3311 php artisan test --filter=ReviewTest` | 10 lulus, 28 assertion |
| `DB_PORT=3311 php artisan test` | 76 lulus, 235 assertion |

Yang dibuktikan: tamu ditolak, penyewa dan pemilik bisa menilai dengan peran yang benar, booking belum selesai 409, bukan pihak 403, rating ganda 409, nilai di luar 1–5 ditolak, rata-rata dua review (5 dan 3) menjadi 4,00 dengan jumlah 2, ulasan tampil di halaman barang, dan halaman rating bisa dibuka.

## 4. Yang belum

| Hal | Alasan |
|---|---|
| Moderasi ulasan oleh admin | endpoint `HIDDEN` ada di skema, antarmuka admin belum dibangun |
| Halaman profil berisi semua ulasan pengguna | endpoint `GET /users/{userId}/reviews` ada di kontrak, tampilan belum |
| Uji rating lewat peramban | alur penuh butuh booking `COMPLETED`; halaman sudah diuji render, perilaku diuji otomatis |
| Rating dari mitra nyata | bagian UAT P15 |

## 5. Catatan data

Rata-rata barang dihitung dari seluruh review yang tersimpan, termasuk empat review seed pada booking 1, 2, dan 3. Karena itu barang 1, 3, dan 5 sudah memiliki nilai awal. Barang 2 dipakai pada pengujian karena belum punya review seed, sehingga angka bisa diperiksa bersih.
