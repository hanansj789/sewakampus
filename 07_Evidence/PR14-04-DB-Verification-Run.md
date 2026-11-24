**Status:** Ada. Bukti uji nyata; semua pemeriksaan PASS.

# PR14-04 — Verifikasi Ulang Skema dan Seed

**Tanggal:** 24 November 2026
**Penguji:** Muhammad Fazha Nararya Nugraha (Database Architect)
**Mesin:** MySQL Community Server 8.0.43, port 3311, database `sewakampus`
**Skrip:** `08_Source/database/sql/002_verify.sql`

## 1. Perintah

```bash
mysql -h 127.0.0.1 -P 3311 -u root sewakampus \
  < 08_Source/database/sql/002_verify.sql
```

## 2. Hasil

| Pemeriksaan | Hasil | Detail |
|---|---|---|
| Jumlah tabel | PASS | 14 |
| Jumlah view | PASS | 1 |
| Pengguna minimal 30 | PASS | 30 |
| Barang minimal 30 | PASS | 30 |
| Kategori minimal 8 | PASS | 8 |
| Booking minimal 10 | PASS | 10 |
| Riwayat status minimal 20 | PASS | 23 |
| Booking tanpa item | PASS | 0 |
| Booking tanpa penyewa/pemilik | PASS | 0 |
| Sewa barang sendiri | PASS | 0 |
| Arah handover duplikat | PASS | 0 |
| Status booking tidak valid | PASS | 0 |
| View rating mencakup semua item | PASS | 30/30 |
| View rating tanpa NULL | PASS | 0 |
| Rating di luar 0–5 | PASS | 0 |
| Barang tanpa ulasan bernilai 0.00 | PASS | 0 |

## 3. Arti

- Skema masih sesuai `001_init.sql` dan seed masih memenuhi `PR14-05`.
- Foreign key tidak meninggalkan baris yatim pada booking.
- Constraint `ck_bookings_parties` dan `uq_handovers_booking_direction` tidak dilanggar seed.
- `v_item_rating` mengembalikan satu baris per item, tanpa NULL, dan 0.00 untuk barang tanpa ulasan.

## 4. Batas

- Ini verifikasi ulang di MySQL lokal 8.0.43, bukan container deployment.
- Jumlah baris mengikuti seed 24 November 2026; jika seed berubah, angka minimum pada skrip tetap berlaku, angka detail perlu diperbarui.
- Skrip tidak menguji unggahan foto, API, atau aplikasi Laravel; itu ranah test feature.
