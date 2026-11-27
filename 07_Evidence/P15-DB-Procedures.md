**Status:** Ada. Prosedur dan view diuji, 27 November 2026.

# P15 — Prosedur Transaksi Proses Kritis

**Pemilik:** Muhammad Fazha Nararya Nugraha (Database Architect)
**Berkas:** `08_Source/database/sql/003_procedures.sql`
**Lingkungan:** MySQL 8.0.43, database `sewakampus`.

## 1. Isi

| Objek | Fungsi |
|---|---|
| `sp_transition_booking` | Mengubah status booking secara atomik: kunci baris, periksa transisi, perbarui status, tulis riwayat |
| `v_booking_status_summary` | View laporan jumlah booking per status dan rata-rata nilai |

## 2. Transisi yang diizinkan

| Dari | Ke |
|---|---|
| `PENDING` | `APPROVED`, `REJECTED`, `CANCELLED` |
| `APPROVED` | `HANDED_OVER`, `CANCELLED` |
| `HANDED_OVER` | `RETURNED`, `DISPUTED` |
| `RETURNED` | `COMPLETED`, `DISPUTED` |

Transisi di luar tabel itu ditolak. Status yang tidak cocok dengan `from_status` juga ditolak, sehingga dua permintaan bersamaan tidak bisa menurunkan status yang sama dua kali.

## 3. Uji manual

| Uji | Perintah | Hasil |
|---|---|---|
| Transisi terlarang | `CALL sp_transition_booking(196,'PENDING','RETURNED',1,'uji')` | **Ditolak** `ERROR 1644 (45000): Transisi status tidak diizinkan`; status tetap `PENDING` |
| Transisi sah | `CALL sp_transition_booking(196,'PENDING','APPROVED',1,'uji transisi sah')` | Status `APPROVED`, `approved_at` terisi, riwayat `PENDING→APPROVED` tercatat |
| Data uji | booking sementara id 196 | Dihapus setelah uji beserta riwayatnya |

## 4. Sifat atomik

Prosedur berjalan dalam satu transaksi:

1. `SELECT ... FOR UPDATE` mengunci baris booking.
2. Validasi status asal dan status tujuan.
3. `UPDATE bookings` dan `INSERT booking_status_histories`.
4. `COMMIT`; bila ada galat, `ROLLBACK` dan galat diteruskan.

## 5. Cara memasang

```bash
mysql -h 127.0.0.1 -P 3311 -u root < 08_Source/database/sql/003_procedures.sql
```

## 6. Batas yang harus disebut

- Aplikasi Laravel saat ini masih menjalankan transisi status di kode PHP (`BookingController`, `HandoverController`) dengan transaksi dan kunci baris. Prosedur ini adalah jaring pengaman di level database, **belum dipanggil aplikasi**. Menyatukan keduanya dicatat sebagai pekerjaan lanjutan agar tidak ada dua jalur yang berbeda.
- Prosedur belum menangani `DISPUTED` lebih jauh; alur sengketa belum dibangun.
- Uji dilakukan manual, bukan otomatis, karena PHPUnit tidak menjalankan stored procedure.
