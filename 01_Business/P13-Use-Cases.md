# Use Case — SewaKampus P13

**Status:** Final (internal), 24 November 2026. Review silang dilewati lewat SK-021.
**Tanggal:** 23 November 2026
**Diagram:** `01_Business/P13-Use-Case-Diagram.drawio` + `.png` (aktor Penyewa, Pemilik, dan Admin; tujuh use case; tanpa aktor Sistem)

## Aktor

Penyewa, Pemilik, dan Admin adalah **mahasiswa**. Admin adalah mahasiswa yang diberi role `ADMIN`; bukan staf kampus dan bukan sistem eksternal. Sistem tidak dihitung sebagai aktor: notifikasi, validasi, dan penyimpanan adalah perilaku sistem di dalam use case.

| Aktor | Deskripsi |
|---|---|
| Penyewa | Mahasiswa terverifikasi yang menyewa barang |
| Pemilik | Mahasiswa terverifikasi yang menyewakan barang |
| Admin | Mahasiswa dengan role `ADMIN`; memverifikasi KTM, memoderasi listing, dan menangani sengketa |

## Daftar use case

| ID | Nama | Must terkait | Aktor utama |
|---|---|---|---|
| UC-01 | Menawarkan barang (listing) | M1 | Pemilik |
| UC-02 | Memeriksa ketersediaan barang | M2 | Penyewa |
| UC-03 | Mengajukan dan menyetujui sewa | M3 | Penyewa dan Pemilik |
| UC-04 | Mencatat serah terima dan pengembalian | M4 | Penyewa dan Pemilik |
| UC-05 | Memberi rating dan ulasan | M5 | Penyewa dan Pemilik |
| UC-06 | Memverifikasi mahasiswa | Kontrol alur | Admin |
| UC-07 | Menyelesaikan sengketa | Kontrol alur | Admin |

---

## UC-01 Menawarkan barang

**Aktor:** Pemilik (mahasiswa).
**Prakondisi:** akun aktif dan sudah terverifikasi (UC-06).
**Pascakondisi:** listing berstatus `ACTIVE` dan bisa ditemukan penyewa.

**Alur utama:**
1. Pemilik membuka formulir listing.
2. Pemilik mengisi judul, deskripsi, kondisi, kategori, harga harian, deposit, dan titik serah terima.
3. Pemilik mengunggah minimal satu foto.
4. Sistem memvalidasi ukuran dan tipe berkas, lalu menyimpan foto di object storage privat.
5. Sistem menyimpan listing dengan status `ACTIVE`.
6. Listing tampil di katalog dengan foto utama.

**Alur alternatif:**
- 2a. Data wajib tidak lengkap → sistem menolak dan menandai kolom yang salah.
- 3a. Tidak ada foto → listing disimpan sebagai `DRAFT`, tidak tampil di katalog.
- 5a. Pemilik menjeda listing → status menjadi `PAUSED`, hilang dari katalog.

**Endpoint:** `POST /items`, `PATCH /items/{itemId}`, `POST /items/{itemId}/photos`.

---

## UC-02 Memeriksa ketersediaan

**Aktor:** Penyewa (mahasiswa).
**Prakondisi:** listing berstatus `ACTIVE`.
**Pascakondisi:** penyewa tahu tanggal yang kosong dan bisa mengajukan sewa.

**Alur utama:**
1. Penyewa membuka detail barang.
2. Sistem menampilkan kalender satu bulan dengan dua penanda: tanggal terisi dan tanggal kosong.
3. Penyewa memilih rentang tanggal.
4. Sistem menolak rentang yang bertabrakan dengan booking aktif atau blokir pemilik.
5. Sistem menampilkan total biaya sementara: harga harian dikali jumlah hari, ditambah deposit.

**Alur alternatif:**
- 4a. Rentang bertabrakan → sistem menandai tanggal yang bentrok dan meminta rentang lain.

**Endpoint:** `GET /items/{itemId}/availability`, `GET /items/{itemId}`.

---

## UC-03 Mengajukan dan menyetujui sewa

**Aktor:** Penyewa (mengajukan) dan Pemilik (memutuskan); keduanya mahasiswa.
**Prakondisi:** penyewa terverifikasi, rentang tanggal kosong.
**Pascakondisi:** booking berstatus `APPROVED` atau `REJECTED`, dan riwayat status tercatat.

**Alur utama:**
1. Penyewa mengajukan sewa untuk rentang tanggal tertentu.
2. Sistem menyimpan booking berstatus `PENDING` beserta snapshot harga.
3. Sistem memberi notifikasi ke pemilik.
4. Pemilik membuka daftar pengajuan dan memeriksa profil penyewa.
5. Pemilik menyetujui.
6. Sistem mengubah status menjadi `APPROVED` dan mencatat `BookingStatusHistory`.
7. Sistem memberi notifikasi ke penyewa.

**Alur alternatif:**
- 5a. Pemilik menolak dengan alasan → status `REJECTED`, tanggal kembali tersedia.
- 3a. Penyewa membatalkan sebelum diputuskan → status `CANCELLED`.
- 4a. Pemilik tidak memutuskan dalam 24 jam → booking tetap `PENDING` dan muncul di daftar menunggu; bukan pembatalan otomatis.

**Aturan status:** `PENDING` → `APPROVED` atau `REJECTED`; `APPROVED` → `HANDED_OVER`; `HANDED_OVER` → `RETURNED`; `RETURNED` → `COMPLETED`. Tidak ada lompatan status.

**Endpoint:** `POST /bookings`, `POST /bookings/{bookingId}/approve`, `POST /bookings/{bookingId}/reject`, `POST /bookings/{bookingId}/cancel`.

---

## UC-04 Mencatat serah terima dan pengembalian

**Aktor:** Penyewa dan Pemilik; keduanya mahasiswa.
**Prakondisi:** booking `APPROVED` untuk OUT, atau `HANDED_OVER` untuk RETURN.
**Pascakondisi:** dua catatan handover tersimpan dengan foto, booking berlanjut ke `RETURNED` lalu `COMPLETED`.

**Alur utama:**
1. Salah satu pihak membuka halaman serah terima.
2. Pihak itu mengunggah foto kondisi barang dan mengisi lokasi serta catatan kondisi.
3. Sistem menyimpan handover `OUT` dengan foto dan status menunggu konfirmasi.
4. Pihak lain mengonfirmasi setelah memeriksa barang.
5. Sistem mencatat waktu konfirmasi kedua pihak dan mengubah booking menjadi `HANDED_OVER`.
6. Saat pengembalian, langkah 2–5 diulang untuk handover `RETURN`.
7. Sistem mengubah booking menjadi `RETURNED`, lalu `COMPLETED` setelah deposit dan rating beres.

**Alur alternatif:**
- 2a. Foto tidak diunggah → sistem menolak; handover tidak bisa dibuat.
- 4a. Pihak lain menemukan kondisi berbeda → pihak itu menolak konfirmasi dan membuka sengketa (UC-07).
- 6a. Pengembalian terlambat → sistem menandai keterlambatan pada catatan handover.

**Endpoint:** `POST /bookings/{bookingId}/handovers` (multipart, foto wajib), `POST /bookings/{bookingId}/handovers/{handoverId}/confirm`.

---

## UC-05 Memberi rating dan ulasan

**Aktor:** Penyewa dan Pemilik; keduanya mahasiswa.
**Prakondisi:** booking `COMPLETED`.
**Pascakondisi:** rating tersimpan, rata-rata barang dan pengguna diperbarui.

**Alur utama:**
1. Sistem menampilkan permintaan penilaian setelah booking selesai.
2. Pengguna memilih rating 1–5 dan menulis komentar (opsional).
3. Sistem memvalidasi bahwa pengguna adalah pihak pada booking tersebut.
4. Sistem menyimpan review dengan status `PUBLISHED`.
5. Sistem menghitung ulang rata-rata rating barang dan pengguna.

**Alur alternatif:**
- 1a. Booking belum `COMPLETED` → sistem menolak dengan kode 409.
- 3a. Pengguna bukan pihak booking → sistem menolak dengan kode 403.
- 4a. Komentar melanggar aturan → admin menyembunyikan review, status `HIDDEN`.

**Endpoint:** `POST /bookings/{bookingId}/reviews`, `GET /users/{userId}/reviews`.

---

## UC-06 Memverifikasi mahasiswa

**Aktor:** Admin (mahasiswa dengan role `ADMIN`).
**Prakondisi:** mahasiswa mengunggah KTM.
**Pascakondisi:** pengajuan verifikasi berstatus `APPROVED` (akun menjadi `ACTIVE`) atau `REJECTED` dengan alasan wajib (akun tetap `PENDING_VERIFICATION` dan boleh mengajukan ulang).

**Alur utama:**
1. Mahasiswa mendaftar dan mengunggah foto KTM.
2. Sistem menyimpan berkas di penyimpanan privat dan menghitung hash untuk deteksi duplikat.
3. Admin membuka antrean verifikasi.
4. Admin memeriksa nama, NIM, dan program studi.
5. Admin menyetujui; status akun menjadi `ACTIVE`.

**Alur alternatif:**
- 4a. Berkas tidak terbaca atau NIM tidak cocok → admin menolak dengan alasan wajib.
- 2a. Hash sama dengan pengajuan lain → sistem menandai duplikat untuk diperiksa admin.

**Endpoint:** `POST /auth/register`, `POST /verifications`, `GET /admin/verifications`, `POST /admin/verifications/{verificationId}/approve`, `POST /admin/verifications/{verificationId}/reject`.

---

## UC-07 Menyelesaikan sengketa

**Aktor:** Admin (mahasiswa dengan role `ADMIN`).
**Prakondisi:** ada booking dengan masalah kerusakan, keterlambatan, atau barang tidak sesuai.
**Pascakondisi:** sengketa `RESOLVED` atau `REJECTED`, deposit diputuskan.

**Alur utama:**
1. Salah satu pihak membuka sengketa dengan kategori dan kronologi.
2. Sistem mengubah status booking menjadi `DISPUTED` dan menahan deposit.
3. Admin memeriksa bukti dari kedua pihak.
4. Admin memutuskan: deposit dikembalikan, dipotong sebagian, atau hangus.
5. Sistem mencatat keputusan dan mengubah status sengketa.

**Endpoint:** `GET /admin/disputes`, `GET /admin/disputes/{disputeId}`, `POST /admin/disputes/{disputeId}/resolve`.

**Catatan:** langkah 1 dijalankan lewat `POST /bookings/{bookingId}/disputes` (multipart, kategori dan kronologi wajib). Penanganan admin memakai `/admin/disputes`. Endpoint pengguna ini ditambahkan pada 24 November 2026 dan menutup gap G-10.

---

## Pemetaan use case ke tabel dan layar

| Use case | Tabel utama | Layar yang direncanakan |
|---|---|---|
| UC-01 | `Item`, `ItemCategory`, `ItemPhoto` | S-01 Form listing, S-02 Katalog (state "Milik saya" memuat daftar listing sendiri) |
| UC-02 | `ItemAvailability`, `Booking` | S-03 Detail barang dan kalender |
| UC-03 | `Booking`, `BookingStatusHistory` | S-04 Pengajuan sewa, S-05 Persetujuan pemilik |
| UC-04 | `Handover`, `Booking` | S-06 Serah terima dan foto kondisi |
| UC-05 | `Review` | S-07 Rating setelah transaksi |
| UC-06 | `StudentVerification`, `User` | S-08 Antrean verifikasi admin |
| UC-07 | `Dispute`, `Deposit` | S-09 Sengketa admin |

Nama layar di atas adalah rencana penamaan untuk traceability. Wireframe dan prototipe dibuat pada Session 3; S-02 dipakai untuk Katalog dengan state "Milik saya", sesuai CR-001. Kolom layar di traceability mengikuti pemetaan ini.
