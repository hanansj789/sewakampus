**Status:** Ada. Bukti uji backup dan restore, 27 November 2026.

# P15 — Bukti Uji Restore Backup

**Pemilik:** Muhammad Fazha Nararya Nugraha (Database Architect)
**Lingkungan:** MySQL 8.0.43, port 3311, Windows 11.
**Skrip:** `08_Source/database/backup/backup.sh` dan `restore.sh`.

## 1. Backup

| Hal | Nilai |
|---|---|
| Perintah | `bash database/backup/backup.sh` |
| Waktu | 27 November 2026, 15:40 |
| Durasi | 1 detik |
| Berkas | `sewakampus-20261127-154014.sql.gz` |
| Ukuran | 12 KB |
| Lokasi | `~/sewakampus-backups` |
| Retensi | 7 hari, berkas lebih lama dihapus otomatis |

Isi dump: struktur dan data seluruh tabel, rutin (`--routines`), trigger, dan event; `--single-transaction` agar tidak mengunci tabel saat backup.

## 2. Restore ke database baru

| Hal | Nilai |
|---|---|
| Perintah | `bash database/backup/restore.sh <berkas> sewakampus_restore` |
| Durasi | **2 detik** |
| Database tujuan | `sewakampus_restore` (dibuat baru, lalu dihapus setelah uji) |

## 3. Hasil pemeriksaan

| Objek | Database asal | Database hasil restore |
|---|---|---|
| Tabel | 14 | 14 |
| View | 2 | 2 |
| Prosedur | 1 | 1 |
| Pengguna | 30 | 30 |
| Barang | 31 | 31 |
| Booking | 11 | 11 |
| Kategori | 30 | 30 |
| Handover | 3 | 3 |

Angka dihitung dengan `COUNT(*)`, bukan perkiraan `table_rows`. Semua cocok.

## 4. Yang dibuktikan

1. Backup dapat dibuat tanpa menghentikan database.
2. Restore ke database kosong berhasil dalam 2 detik.
3. Struktur, data, view, dan prosedur ikut pulih.
4. Jumlah baris tabel utama identik dengan sumber.

## 5. Batas yang harus disebut

| Batas | Akibat |
|---|---|
| Berkas backup di laptop yang sama | bila disk rusak, backup ikut hilang. Target produksi: bucket terpisah |
| Belum dijadwalkan otomatis | baru dijalankan manual; penjadwalan masuk P15 |
| Keycloak tidak termasuk | realm dan pengguna Keycloak memakai H2 terpisah, belum dibackup |
| Belum dienkripsi | berkas berisi data uji, bukan data nyata |
| Uji di server yang sama | belum diuji ke server atau mesin berbeda |

## 6. Cara mengulang

```bash
cd ARCHITECTURE_REPOSITORY/08_Source
bash database/backup/backup.sh
bash database/backup/restore.sh ~/sewakampus-backups/<berkas>.sql.gz sewakampus_restore
```
