**Status:** Ada. Bukti uji M2 di lingkungan lokal, 27 November 2026.

# M2 — Bukti Kalender Ketersediaan

**Pemilik:** Muhammad Fazha Nararya Nugraha (Programmer), pair Mahesa Kanaka Raya (Database)
**Branch:** `feature/programmer-m2-calendar`
**Tanggal:** 27 November 2026
**Sifat:** bukti uji fitur. Bukan penilaian gate.

## 1. Yang dikerjakan

| Bagian | Isi |
|---|---|
| Model | `Booking`, `BookingStatusHistory`, `ItemAvailability`; relasi `Item::bookings()` dan `Item::availabilities()` |
| Layanan | `ItemAvailabilityService`: tanggal terpakai per bulan, cek rentang, daftar konflik |
| Halaman | `/items/{item}` — detail barang, galeri foto, kalender bulanan, navigasi bulan |
| Endpoint | `GET /items/{item}/availability?start_date=&end_date=` mengembalikan `available` dan `conflicts` |
| Gaya | kalender, legenda, dan panel detail di `items.css` |
| Uji | `tests/Feature/ItemAvailabilityTest.php`, 10 kasus |

## 2. Aturan ketersediaan

Tanggal dianggap terpakai bila memenuhi salah satu:

1. Pemilik memblokir tanggal: baris `item_availabilities` dengan status `BLOCKED`.
2. Ada booking dengan status `PENDING`, `APPROVED`, `HANDED_OVER`, `RETURNED`, `COMPLETED`, atau `DISPUTED`.

Booking `REJECTED` dan `CANCELLED` tidak menempati tanggal. Rentang dihitung inklusif: booking 1–3 Desember membuat 1, 2, dan 3 Desember terpakai, dan pengajuan 3–4 Desember ditolak.

## 3. Perilaku yang dibuktikan

| Perilaku | Bukti |
|---|---|
| Halaman detail menampilkan kalender bulan yang dipilih | tes: HTTP 200, teks bulan, tanggal tampil |
| Tanggal yang dibooking ditandai terpakai | tes: 1 Des 2026 bertanda `data-unavailable` |
| Tanggal yang diblokir pemilik ditandai terpakai | tes: 24 Des 2026 bertanda |
| Tanggal kosong tidak ditandai | tes: 4 Des 2026 |
| Rentang yang menimpa booking ditolak | tes: 1–2 Des, `available=false`, konflik `BOOKING` |
| Batas akhir booking ikut terpakai | tes: 3–4 Des ditolak |
| Rentang setelah booking tersedia | tes: 4–5 Des, `available=true` |
| Rentang yang menimpa blokir pemilik ditolak | tes: 25–27 Des, konflik `BLOCKED` |
| Rentang tanggal terbalik ditolak | tes: 422 |
| Draf hanya terlihat pemiliknya | tes: 404 untuk mahasiswa lain, 200 untuk pemilik |

## 4. Hasil uji

| Perintah | Hasil |
|---|---|
| `DB_PORT=3311 php artisan test --filter=ItemAvailabilityTest` | 10 lulus, 20 assertion |
| `DB_PORT=3311 php artisan test` | 37 lulus, 127 assertion |

## 5. Yang belum

| Hal | Alasan |
|---|---|
| Form pengajuan sewa | bagian M3; halaman saat ini hanya menampilkan ketersediaan |
| Kunci baris saat booking dibuat | harus ada di alur M3 agar dua pengajuan bersamaan tidak lolos. Belum bisa diuji karena pembuatan booking belum ada |
| Uji `EXPLAIN` pemakaian indeks tanggal | indeks `(item_id, start_date, end_date)` ada di DDL, tetapi rencana eksekusi belum diperiksa |
| Pemeriksaan tampilan di peramban | Fase 3 oleh Fharel |

## 6. Catatan untuk M3

`ItemAvailabilityService::isRangeAvailable()` sudah menjadi satu-satunya tempat aturan bentrok. Saat M3 membuat booking, alur yang benar: buka transaksi, kunci baris item, panggil layanan ini, simpan booking, lalu commit. Jangan menduplikasi aturan bentrok di controller.
