# Traceability Matrix — SewaKampus P13

**Status:** Draf. Lima baris, kolom use case, story, tabel, endpoint, dan layar sudah terisi. Kolom layar mengacu pada prototipe FigCraft `03_Application/ux/SewaKampus-High-Fidelity.figcraft`.
**Tanggal:** 23 November 2026

Format mengikuti TXT hlm. 17: kebutuhan → use case → tabel → layar. Kolom endpoint dan status ditambahkan sebagai bukti.

| Must | Masalah | Kebutuhan | Use case | Story | Tabel | Layar | Endpoint | Status |
|---|---|---|---|---|---|---|---|---|
| M1 Listing barang | Barang menganggur tidak pernah ditawarkan | Pemilik menawarkan barang dengan foto, kategori, harga, lokasi | UC-01 | US-01, US-02 | `Item`, `ItemCategory`, `ItemPhoto` | S-01, S-02 | `POST /items`, `PATCH /items/{itemId}`, `POST /items/{itemId}/photos` | Sebagian: belum diuji di kode |
| M2 Kalender ketersediaan | Penyewa tidak tahu tanggal terpakai | Penyewa melihat tanggal terisi dan kosong | UC-02 | US-03 | `ItemAvailability`, `Booking` | S-03  | `GET /items/{itemId}/availability` | Sebagian: aturan tabrakan tanggal belum diuji |
| M3 Persetujuan sewa | Pengajuan hilang di grup chat | Pemilik menyetujui atau menolak dengan status berurutan | UC-03 | US-04, US-05 | `Booking`, `BookingStatusHistory` | S-04, S-05  | `POST /bookings`, `POST /bookings/{bookingId}/approve`, `POST /bookings/{bookingId}/reject` | Sebagian: transisi status belum diuji di kode |
| M4 Foto kondisi | Kerusakan tidak bisa dibuktikan | Foto wajib saat serah terima dan pengembalian | UC-04 | US-06, US-07 | `Handover` (OUT dan RETURN) | S-06  | `POST /bookings/{bookingId}/handovers` (multipart, `photo` wajib), `POST /bookings/{bookingId}/handovers/{handoverId}/confirm` | Sebagian: kontrak sudah menerima foto; validasi wajib belum diuji |
| M5 Rating | Reputasi penyewa dan pemilik tidak terbentuk | Rating dan ulasan setelah transaksi selesai | UC-05 | US-08 | `Review` | S-07  | `POST /bookings/{bookingId}/reviews`, `GET /users/{userId}/reviews` | Sebagian: syarat "hanya setelah selesai" belum diuji |

## Bukti kolom tabel

Nama tabel dari `02_Data/P13-Data-Dictionary.md`, 14 entitas. Pemeriksaan 3NF ada di `02_Data/P13-3NF-Proof.md`; DDL ada di `08_Source/database/sql/001_init.sql` dan belum dijalankan di database kosong.

## Bukti kolom layar

Nama layar mengikuti `01_Business/P13-Use-Cases.md` dan `03_Application/ux/DESIGN.md`: S-01 form listing, S-02 daftar listing saya, S-03 detail barang dan kalender, S-04 pengajuan sewa, S-05 persetujuan pemilik, S-06 serah terima dan foto, S-07 rating, S-08 antrean verifikasi, S-09 sengketa.

**Prototipe sudah ada.** Setiap layar digambar pada mobile 390 × 844 dan desktop 1440 × 900 di `03_Application/ux/SewaKampus-High-Fidelity.figcraft`, diekspor ke `03_Application/ux/exports/`, dan didokumentasikan di `03_Application/ux/PR14-03-Prototype-FigCraft.md`. S-08 menjadi kontrol prasyarat yang mendukung M1, S-09 menjadi cabang pengecualian yang mendukung M4. Keduanya bukan Must baru.

Cek aksesibilitas struktural: kontras teks utama dan sekunder memenuhi 4,5:1, target sentuh utama 44 px atau lebih, dan data privat dimasking sesuai `DESIGN.md`. Cek piksel akhir dilakukan pemilik produk.

## Kekurangan yang masih terbuka

1. Prototipe dan kolom layar sudah ada, tetapi belum direview anggota lain.
2. DDL dan seed belum dijalankan; belum ada bukti bahwa skema benar-benar berjalan.
3. Aturan "tidak boleh ada rentang tanggal bertumpuk" belum diuji di kode.
4. Test case sudah ditulis di `07_Evidence/P14-Test-Cases.md`, tetapi belum dijalankan.
