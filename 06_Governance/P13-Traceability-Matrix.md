# Traceability Matrix — SewaKampus P13

**Status:** Draf. Lima baris ada, tetapi kolom use case dan layar masih kosong karena artefaknya belum dibuat.
**Tanggal:** 23 November 2026

Format mengikuti TXT hlm. 17: kebutuhan → use case → tabel → layar. Kolom endpoint ditambahkan sebagai bukti kontrak API.

| Must | Masalah yang diselesaikan | Kebutuhan | Use case | Tabel | Layar | Endpoint | Status |
|---|---|---|---|---|---|---|---|
| M1 Listing barang | Barang menganggur tidak pernah ditawarkan karena tidak ada katalog | Pemilik dapat menawarkan barang dengan foto, kategori, harga harian, lokasi | Belum | `Item`, `ItemCategory`, `ItemPhoto` | Belum | `POST /items`, `PATCH /items/{itemId}`, `POST /items/{itemId}/photos` | Sebagian: tabel dan endpoint ada; use case dan layar belum |
| M2 Kalender ketersediaan | Penyewa tidak tahu barang terpakai pada tanggal tertentu | Penyewa melihat tanggal terisi dan kosong sebelum mengajukan | Belum | `ItemAvailability` | Belum | `GET /items/{itemId}/availability` | Sebagian: tabel dan endpoint ada; use case dan layar belum |
| M3 Persetujuan sewa | Pengajuan sewa hilang di grup chat tanpa status | Pemilik menyetujui atau menolak; status berjalan berurutan | Belum | `Booking`, `BookingStatusHistory` | Belum | `POST /bookings`, `POST /bookings/{bookingId}/approve`, `POST /bookings/{bookingId}/reject` | Sebagian: tabel dan endpoint ada; aturan transisi status belum diuji |
| M4 Foto kondisi | Kerusakan tidak bisa dibuktikan setelah barang kembali | Foto wajib saat serah terima dan pengembalian | Belum | `Handover` (OUT dan RETURN) | Belum | `POST /bookings/{bookingId}/handovers`, `POST /bookings/{bookingId}/handovers/{handoverId}/confirm` | Belum: request handover belum menerima foto |
| M5 Rating | Penyewa dan pemilik tidak punya reputasi | Rating dan ulasan setelah transaksi selesai | Belum | `Review` | Belum | `POST /bookings/{bookingId}/reviews`, `GET /users/{userId}/reviews` | Sebagian: tabel dan endpoint ada; syarat "setelah selesai" belum diuji |

## Bukti kolom tabel

Nama tabel diambil dari `DESAIN/Logical Data Model - SewaKampus.drawio`: `User`, `StudentVerification`, `ItemCategory`, `Item`, `ItemPhoto`, `ItemAvailability`, `Booking`, `BookingStatusHistory`, `Handover`, `Deposit`, `Review`, `Dispute`, `Notification`, `AuditLog`. Keberadaan entitas di diagram belum berarti 3NF terbukti; itu tugas P13-07 dan P13-08.

## Kekurangan yang harus ditutup sebelum Gate 1

1. Kolom use case wajib berisi ID dari `01_Business/P13-Use-Cases.md` — belum ada.
2. Kolom layar wajib berisi nama layar dari wireframe — belum ada.
3. M4 harus punya field foto di request API, atau kolom endpoint dinyatakan belum memenuhi.
4. Setiap baris yang masih "Belum" membuat Gate 1 berstatus **bersyarat**, bukan hijau.
