# Traceability Matrix — SewaKampus P13

**Status:** Final, 24 November 2026. Lima baris, kolom use case, story, tabel, endpoint, dan layar sudah terisi. Review silang telah dilakukan (SK-024). Kolom layar mengacu pada prototipe FigCraft `03_Application/ux/SewaKampus-High-Fidelity.figcraft`.
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

Nama tabel dari `02_Data/P13-Data-Dictionary.md`, 14 entitas. Pemeriksaan 3NF ada di `02_Data/P13-3NF-Proof.md`; DDL ada di `08_Source/database/sql/001_init.sql` dan **sudah dijalankan di MySQL 8.0.43**. Bukti: `07_Evidence/PR14-04-DDL-Run-Log.md` dan verifikasi ulang `07_Evidence/PR14-04-DB-Verification-Run.md` (16 pemeriksaan PASS).

## Bukti kolom layar

Nama layar mengikuti `01_Business/P13-Use-Cases.md` dan `03_Application/ux/DESIGN.md`: S-01 form listing, S-02 Katalog (state "Milik saya" untuk daftar listing sendiri), S-03 detail barang dan kalender, S-04 pengajuan sewa, S-05 persetujuan pemilik, S-06 serah terima dan foto, S-07 rating, S-08 antrean verifikasi, S-09 sengketa.

**Prototipe dan wireframe sudah ada (desktop).** Prototipe hi-fi `03_Application/ux/SewaKampus-High-Fidelity.figcraft` berisi tujuh layar 1440 × 900 dalam satu alur terhubung, memetakan lima Must: Buat listing (S-01/M1/UC-01), Katalog (S-02/M1/UC-01), Detail & Kalender (S-03/M2/UC-02), Pengajuan dan Persetujuan (S-04, S-05/M3/UC-03), Serah terima & foto kondisi (S-06/M4/UC-04), Rating (S-07/M5/UC-05). Wireframe desktop terpisah ada di `03_Application/ux/SewaKampus-Wireframe.figcraft` dengan anotasi, States, dan Flow. Ekspor PNG/PDF ada di `03_Application/ux/exports/`.

Mobile tidak digambar pada versi ini; desktop ditargetkan lebih dulu sesuai arahan pemilik. S-08 (verifikasi) dan S-09 (sengketa) adalah kontrol alur. Keduanya punya layar wireframe sendiri (`WF-08`, `WF-09`) tetapi tidak masuk prototipe hi-fi lima Must; keduanya bukan Must baru.

Cek aksesibilitas struktural: kontras teks utama dan sekunder memenuhi 4,5:1, target sentuh utama 44 px atau lebih, dan data privat dimasking sesuai `DESIGN.md`. Cek piksel akhir dilakukan pemilik produk.

## Review silang

Review silang P13 telah dilakukan dan disetujui pada 24 November 2026. Catatan lengkap ada di `06_Governance/P13-Cross-Review-Log.md`.

## Kekurangan yang masih terbuka

1. Prototipe dan kolom layar sudah ada dan sudah direview silang; cek piksel akhir tetap dilakukan pemilik produk.
2. DDL dan seed **sudah dijalankan** di MySQL 8.0.43; verifikasi ulang 16 pemeriksaan PASS. Tidak ada lagi gap eksekusi DDL.
3. Aturan "tidak boleh ada rentang tanggal bertumpuk" belum diuji di kode karena fitur M2 belum dibangun.
4. Test case Must di `07_Evidence/P14-Test-Cases.md` belum dijalankan; test auth/role sudah 16/70 dan review UI auth sudah dicatat.
