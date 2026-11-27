**Status:** Ada. Bukti uji M4, 27 November 2026.

# M4 — Bukti Foto Kondisi Serah Terima dan Pengembalian

**Pemilik:** Muhammad Fazha Nararya Nugraha (Programmer)
**Branch:** `feature/programmer-m4-handover`
**Tanggal:** 27 November 2026
**Sifat:** bukti uji fitur. Bukan penilaian gate.

## 1. Yang dikerjakan

| Bagian | Isi |
|---|---|
| Model | `Handover` (OUT/RETURN, konfirmasi dua pihak), `Deposit` |
| Controller | `HandoverController`: halaman, simpan handover, konfirmasi, selesaikan transaksi, sajikan foto |
| Rute | `GET /bookings/{booking}/handover`, `POST /bookings/{booking}/handovers`, `POST .../handovers/{handover}/confirm`, `POST /bookings/{booking}/complete`, `GET .../handovers/{handover}/photo` |
| Tampilan | halaman serah terima: ringkasan booking, daftar handover, form OUT/RETURN, tombol konfirmasi, tombol selesaikan |
| Uji | `tests/Feature/HandoverTest.php`, 15 kasus |

## 2. Aturan yang diberlakukan

1. Hanya penyewa dan pemilik booking yang boleh membuka, membuat, dan mengonfirmasi handover.
2. Arah ditentukan status, bukan masukan pengguna: `APPROVED` → OUT, `HANDED_OVER` → RETURN. Status lain ditolak 409.
3. Foto kondisi wajib. Tanpa foto, permintaan ditolak 422.
4. Satu handover per arah. Percobaan kedua ditolak 409.
5. Pembuat handover otomatis mengonfirmasi sisi dirinya; pihak lain mengonfirmasi lewat tombol.
6. Kedua pihak mengonfirmasi OUT → status `HANDED_OVER`.
7. Kedua pihak mengonfirmasi RETURN → status `RETURNED`. Jika melewati `end_date`, alasannya mencatat jumlah hari terlambat.
8. Transaksi diselesaikan dari `RETURNED` → `COMPLETED`, deposit simulasi berstatus `REFUNDED`.
9. Setiap pembuatan handover mengirim baris notifikasi ke pihak lain.
10. Pembuatan handover memakai kunci baris booking agar dua pihak tidak membuat arah yang sama bersamaan.

## 3. Hasil uji otomatis

| Perintah | Hasil |
|---|---|
| `DB_PORT=3311 php artisan test --filter=HandoverTest` | 15 lulus |
| `DB_PORT=3311 php artisan test` | 66 lulus, 207 assertion |

Yang dibuktikan antara lain: tamu ditolak, foto wajib, bukan pihak ditolak 403, OUT butuh status disetujui, konfirmasi pemilik memindahkan status, handover ganda ditolak, RETURN butuh status diserahkan, keterlambatan tercatat, penyelesaian transaksi mengembalikan deposit, dan konfirmasi ganda ditolak.

## 4. Yang belum

| Hal | Alasan |
|---|---|
| Uji unggah foto lewat peramban | belum dijalankan; halaman sudah diuji render, unggahan diuji otomatis. Pemeriksaan tampilan penuh ada di Fase 3 |
| Notifikasi email | masih tercatat `QUEUED`, worker belum ada |
| Sengketa ketika kondisi tidak cocok | bagian alur sengketa, belum dibangun |
| Deposit dipotong untuk kerusakan | keputusan bisnis belum ditetapkan |
