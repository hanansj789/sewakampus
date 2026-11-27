**Status:** Ada. Bukti uji M3, 27 November 2026.

# M3 — Bukti Pengajuan dan Persetujuan Sewa

**Pemilik:** Muhammad Fazha Nararya Nugraha (Programmer)
**Branch:** `feature/programmer-m3-booking`
**Tanggal:** 27 November 2026
**Sifat:** bukti uji fitur. Bukan penilaian gate.

## 1. Yang dikerjakan

| Bagian | Isi |
|---|---|
| Controller | `BookingController`: ajukan, daftar, setujui, tolak, batalkan |
| Model | `Notification`; `Booking` dan `BookingStatusHistory` dipakai penuh |
| Rute | `POST /items/{item}/bookings`, `GET /bookings`, `POST /bookings/{booking}/approve`, `/reject`, `/cancel` |
| Tampilan | form pengajuan di halaman detail, halaman `bookings/index` dengan dua bagian: masuk sebagai pemilik dan pengajuan saya |
| Uji | `tests/Feature/BookingTest.php`, 12 kasus |

## 2. Aturan yang diberlakukan

1. Penyewa tidak boleh mengajukan barang miliknya sendiri.
2. Tanggal mulai tidak boleh di masa lalu; tanggal selesai tidak boleh sebelum mulai.
3. Rentang harus lolos pemeriksaan ketersediaan yang sama dengan M2.
4. Harga disimpan sebagai snapshot: `daily_rate_snapshot`, `subtotal`, `deposit_snapshot`, `total_amount`. Jumlah hari dihitung inklusif.
5. Booking baru berstatus `PENDING`, dicatat di `booking_status_histories` dengan `from_status = NEW`.
6. Hanya pemilik yang boleh menyetujui atau menolak, dan hanya saat status `PENDING`.
7. Penolakan mewajibkan alasan.
8. Penyewa boleh membatalkan selama masih `PENDING`.
9. Setiap keputusan membuat baris `notifications` untuk pihak lain.

## 3. Pencegahan double booking

Pembuatan booking berjalan di dalam transaksi:

1. `SELECT ... FOR UPDATE` pada baris item, sehingga dua pengajuan untuk barang yang sama diantrikan.
2. Pemeriksaan ketersediaan dijalankan setelah kunci didapat.
3. Booking disimpan, lalu transaksi di-commit.

Dengan urutan ini, pengajuan kedua pada rentang yang sama akan melihat booking pertama dan ditolak. Uji otomatis membuktikan penolakan berurutan; uji beban dua permintaan benar-benar bersamaan belum dijalankan.

## 4. Hasil uji otomatis

| Perintah | Hasil |
|---|---|
| `DB_PORT=3311 php artisan test --filter=BookingTest` | 12 lulus, 40 assertion |
| `DB_PORT=3311 php artisan test` | 51 lulus, 172 assertion |

## 5. Uji di peramban

Alur nyata dengan dua akun:

1. Masuk sebagai `hanan`, buka Lensa Canon 50mm milik akun lain, ajukan 10–12 Januari 2027.
2. Sistem menampilkan "Pengajuan untuk Lensa Canon 50mm f/1.8 terkirim ke pemilik."
3. Keluar, masuk sebagai `mahesa` (pemilik), buka `/bookings`.
4. Pengajuan tampil `PENDING` dengan tombol Setujui dan Tolak beserta kolom alasan.
5. Setujui; status berubah menjadi `APPROVED` dan pesan "Pengajuan disetujui."

Bukti: `07_Evidence/screenshots/P14-pengajuan-pemilik-2026-11-27.png`.

## 6. Yang belum

| Hal | Alasan |
|---|---|
| Status `HANDED_OVER`, `RETURNED`, `COMPLETED` | bagian M4 dan M5 |
| Deposit simulasi | belum ada alur pembayaran simulasi |
| Notifikasi email | baru tercatat di tabel dengan status `QUEUED`, worker belum ada |
| Kedaluwarsa pengajuan otomatis | belum diputuskan; saat ini pengajuan tetap `PENDING` sampai diputuskan |
| Uji dua permintaan benar-benar bersamaan | butuh alat uji beban, bukan feature test |
