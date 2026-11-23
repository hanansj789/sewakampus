**Status:** Ada. Bukti uji nyata, bukan rencana. Satu cacat ditemukan dan diperbaiki dalam uji ini.

# PR14-04 / PR14-05 — Bukti Uji DDL dan Seed di Database Kosong

**Tanggal uji:** 24 November 2026
**Penguji:** session audit repo (atas nama Fazha, Database Architect)
**Mesin:** Windows, MySQL Community Server 8.0.43 (zip portable, tanpa instalasi layanan)
**Data dir:** kosong, dibuat baru dengan `mysqld --initialize-insecure`
**Berkas yang diuji:** `08_Source/database/sql/001_init.sql`, `08_Source/database/sql/seed.sql`

## 1. Hasil ringkas

| Uji | Hasil |
|---|---|
| DDL pada database kosong | **Lolos** tanpa galat |
| Seed setelah DDL | **Lolos** tanpa galat |
| Jumlah tabel | **14** |
| Jumlah view | **1** (`v_item_rating`) |
| Baris `users` | 30 |
| Baris `items` | 30 |
| Baris `item_categories` | 8 |
| Baris `bookings` | 10 |
| Baris `handovers` | 3 |
| Baris `reviews` | 4 |
| Baris `disputes` | 2 |
| Baris `audit_logs` | 3 |
| `v_item_rating` | `item 1 = 5.00 / 2`, `item 2 = 0.00 / 0`, `item 3 = 4.00 / 1` (barang tanpa ulasan kini 0.00, bukan NULL) |
| Riwayat status | 23 baris, 0 lompatan status, 1 booking berstatus PENDING tanpa riwayat (benar) |

Perintah yang dipakai:

```bash
mysqld --initialize-insecure --basedir=<mysql8> --datadir=<dir kosong>
mysqld --basedir=<mysql8> --datadir=<dir> --port=3311 --bind-address=127.0.0.1
mysql -h 127.0.0.1 -P 3311 -u root < 001_init.sql
mysql -h 127.0.0.1 -P 3311 -u root sewakampus < seed.sql
```

## 2. Cacat yang ditemukan uji ini

### D-01 `condition` adalah reserved word MySQL 8 — **sudah diperbaiki**

Uji pertama gagal:

```
ERROR 1064 (42000) at line 73: You have an error in your SQL syntax ...
near 'condition      VARCHAR(20)     NOT NULL,'
```

`CONDITION` termasuk reserved word MySQL 8.0, sehingga kolom `items.condition` tidak bisa ditulis tanpa tanda kutip. Perbaikan: nama kolom ditulis `` `condition` `` pada `001_init.sql` (definisi kolom dan `CHECK`) dan pada daftar kolom `INSERT` di `seed.sql`. Nama kolom tidak berubah, jadi kontrak API (`condition`) dan kamus data tetap sama.

Pelajaran: pemeriksaan "parse dialek MySQL" yang dilakukan sebelumnya tidak menangkap reserved word. Hanya eksekusi nyata yang menangkapnya.

### D-02 DDL tidak jalan di MariaDB — **bukan cacat, tapi perlu dicatat**

MariaDB 11.4.2 menolak baris 8:

```
ERROR 1273 (HY000) at line 8: Unknown collation: 'utf8mb4_0900_ai_ci'
```

`utf8mb4_0900_ai_ci` hanya ada di MySQL 8. Karena stack proyek adalah MySQL 8.0, file tidak diubah. Konsekuensinya: klaim "DDL MySQL/PostgreSQL" pada matriks **tidak akurat untuk PostgreSQL** — belum ada versi PostgreSQL dari skrip ini.

## 3. Uji integritas (semua dijalankan pada database hasil DDL)

| Uji | Input | Hasil yang diharapkan | Hasil nyata |
|---|---|---|---|
| A | `INSERT items` dengan `condition = 'RUSAK'` | ditolak | `ERROR 3819 Check constraint 'ck_items_condition' is violated` |
| B | `INSERT items` dengan `condition = 'GOOD'` | diterima | diterima tanpa galat |
| C | `INSERT items` dengan `category_id = 999` | ditolak | `ERROR 1452 ... fk_items_category` |
| D | `INSERT handovers` dengan `booking_id` + `direction` yang sudah ada | ditolak | `ERROR 1062 Duplicate entry '4-OUT' for key 'uq_handovers_booking_direction'` |
| E | `INSERT reviews` dengan `rating = 6` | ditolak | `ERROR 3819 Check constraint 'ck_reviews_rating' is violated` |
| F | `INSERT bookings` dengan `renter_id = owner_id` | ditolak | `ERROR 3819 Check constraint 'ck_bookings_parties' is violated` |

Artinya `CHECK`, foreign key, dan unique key benar-benar aktif, bukan hanya tertulis di skrip.

## 4. Yang masih kurang (tidak ditutup oleh uji ini)

1. ~~Data demo belum memperagakan aturan status~~ **sudah diperbaiki 24 November 2026**: 10 booking dengan rantai status bertingkat, 23 baris riwayat, nol lompatan, dan status akhir tiap booking cocok dengan baris terakhir riwayatnya. Ada booking `DISPUTED` dan `CANCELLED` sebagai contoh.
2. ~~`disputes` dan `audit_logs` kosong~~ **sudah diisi**: 2 sengketa (satu `OPEN`, satu `RESOLVED`) dan 3 baris audit log.
3. ~~`v_item_rating` mengembalikan `NULL`~~ **sudah diperbaiki**: view memakai `COALESCE(..., 0.00)` sehingga barang tanpa ulasan bernilai 0.00, sama dengan default kolom `items.average_rating`.
4. Uji ini memakai MySQL 8.0.43 di Windows. Versi final di VPS (P14) tetap harus diulang pada container Docker yang dipakai deploy.
5. `notifications` belum memuat notifikasi sengketa; belum wajib, tetapi akan terasa saat demo alur sengketa.

## 5. Kesimpulan

PR14-04 (DDL jalan) dan PR14-05 (seed ≥30 baris pada tabel master) **terbukti** pada database kosong. Skema bisa dibuat, constraint menolak data salah, dan seed memuat 30 pengguna, 30 barang, 8 kategori sesuai SK-016. Yang belum: kualitas data demo untuk demonstrasi alur status (G-18) dan penyelarasan angka rating (G-21).
