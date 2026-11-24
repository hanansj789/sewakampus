# User Story dan Acceptance Criteria — SewaKampus P13

**Status:** Final (internal), 24 November 2026. Delapan story, diturunkan dari lima Must. Review silang telah dilakukan (SK-024).
**Tanggal:** 23 November 2026

Setiap story memakai format "Sebagai … saya ingin … agar …", dengan kriteria penerimaan yang bisa diuji. Kriteria ditulis sebagai daftar centang; satu kriteria yang gagal berarti story belum selesai.

---

## US-01 Membuat listing barang

**Must:** M1 · **Use case:** UC-01 · **Prioritas:** P14

Sebagai mahasiswa pemilik, saya ingin menawarkan barang dengan harga dan titik serah terima yang jelas, agar barang saya bisa disewa mahasiswa lain.

**Kriteria penerimaan:**
- [ ] Form meminta judul, deskripsi, kondisi, kategori, harga harian, deposit, dan titik serah terima.
- [ ] Judul maksimal 120 karakter dan tidak boleh kosong.
- [ ] Harga harian dan deposit berupa angka ≥ 0 dengan dua desimal.
- [ ] Kondisi hanya boleh `NEW`, `GOOD`, atau `FAIR`.
- [ ] Listing tanpa foto tersimpan sebagai `DRAFT` dan tidak muncul di katalog.
- [ ] Listing dengan minimal satu foto tampil di katalog sebagai `ACTIVE`.
- [ ] Pemilik bisa menjeda listing, dan listing `PAUSED` hilang dari katalog.
- [ ] Pengguna yang belum terverifikasi tidak bisa membuat listing.

**Endpoint:** `POST /items`, `PATCH /items/{itemId}`.

---

## US-02 Mengunggah foto barang

**Must:** M1 · **Use case:** UC-01 · **Prioritas:** P14

Sebagai mahasiswa pemilik, saya ingin mengunggah beberapa foto barang, agar penyewa tahu kondisi sebenarnya.

**Kriteria penerimaan:**
- [ ] Unggahan menerima JPEG atau PNG dengan ukuran maksimal 5 MB.
- [ ] Berkas disimpan di object storage privat; URL publik tidak disimpan di database.
- [ ] Satu listing punya tepat satu foto utama.
- [ ] Urutan foto bisa diatur dan tersimpan.
- [ ] Berkas yang bukan gambar ditolak dengan pesan yang jelas.
- [ ] Foto milik listing lain tidak bisa diubah pengguna lain (403).

**Endpoint:** `POST /items/{itemId}/photos`.

---

## US-03 Melihat kalender ketersediaan

**Must:** M2 · **Use case:** UC-02 · **Prioritas:** P14

Sebagai mahasiswa penyewa, saya ingin melihat tanggal yang masih kosong, agar tidak mengajukan sewa pada tanggal yang sudah terisi.

**Kriteria penerimaan:**
- [ ] Kalender menampilkan satu bulan dan bisa berpindah bulan.
- [ ] Tanggal yang sudah dibooking berstatus aktif ditandai terisi.
- [ ] Tanggal yang diblokir pemilik ditandai terisi dengan alasan blokir.
- [ ] Rentang yang bertabrakan dengan booking aktif ditolak sebelum pengajuan dikirim.
- [ ] Total biaya sementara dihitung dari harga harian dikali jumlah hari, ditambah deposit.
- [ ] Barang berstatus `PAUSED` atau `ARCHIVED` tidak menampilkan kalender yang bisa diajukan.

**Endpoint:** `GET /items/{itemId}/availability`, `GET /items/{itemId}`.

---

## US-04 Mengajukan sewa

**Must:** M3 · **Use case:** UC-03 · **Prioritas:** P15

Sebagai mahasiswa penyewa, saya ingin mengajukan sewa untuk rentang tanggal tertentu, agar barang bisa saya pakai pada tanggal itu.

**Kriteria penerimaan:**
- [ ] Pengajuan menyimpan snapshot harga harian dan deposit pada saat diajukan.
- [ ] Booking baru berstatus `PENDING` dan tercatat di `BookingStatusHistory`.
- [ ] Pengajuan pada rentang yang bentrok ditolak dengan kode 409.
- [ ] Penyewa tidak bisa mengajukan sewa pada barang miliknya sendiri.
- [ ] Penyewa bisa membatalkan booking selama status masih `PENDING`.
- [ ] Pemilik menerima notifikasi berisi nama penyewa dan rentang tanggal.

**Endpoint:** `POST /bookings`, `POST /bookings/{bookingId}/cancel`.

---

## US-05 Menyetujui atau menolak pengajuan

**Must:** M3 · **Use case:** UC-03 · **Prioritas:** P15

Sebagai mahasiswa pemilik, saya ingin memutuskan pengajuan sewa, agar saya bisa menolak penyewa yang tidak saya kenal atau tanggal yang tidak cocok.

**Kriteria penerimaan:**
- [ ] Daftar pengajuan menampilkan nama penyewa, rentang tanggal, dan total biaya.
- [ ] Setujui mengubah status `PENDING` menjadi `APPROVED` dan mengisi `approved_at`.
- [ ] Tolak mengubah status menjadi `REJECTED` dan mewajibkan alasan.
- [ ] Setelah `REJECTED`, tanggal kembali tersedia untuk pengajuan lain.
- [ ] Status yang sudah `APPROVED` tidak bisa ditolak.
- [ ] Setiap perubahan status tercatat dengan pelaku dan waktu.

**Endpoint:** `POST /bookings/{bookingId}/approve`, `POST /bookings/{bookingId}/reject`.

---

## US-06 Mencatat serah terima dengan foto

**Must:** M4 · **Use case:** UC-04 · **Prioritas:** P15

Sebagai pemilik atau penyewa, saya ingin mencatat serah terima beserta foto kondisi, agar kondisi barang terdokumentasi sebelum dipakai.

**Kriteria penerimaan:**
- [ ] Handover hanya bisa dibuat saat booking `APPROVED`.
- [ ] Foto kondisi wajib; permintaan tanpa foto ditolak dengan kode 422.
- [ ] Lokasi serah terima wajib diisi, maksimal 120 karakter.
- [ ] Catatan kondisi opsional, maksimal 1000 karakter.
- [ ] Hanya satu handover `OUT` per booking.
- [ ] Setelah kedua pihak mengonfirmasi, status booking menjadi `HANDED_OVER`.

**Endpoint:** `POST /bookings/{bookingId}/handovers`, `POST /bookings/{bookingId}/handovers/{handoverId}/confirm`.

---

## US-07 Mencatat pengembalian dengan foto

**Must:** M4 · **Use case:** UC-04 · **Prioritas:** P15

Sebagai pemilik, saya ingin mencatat pengembalian beserta foto kondisi akhir, agar kerusakan atau keterlambatan bisa dibuktikan.

**Kriteria penerimaan:**
- [ ] Handover `RETURN` hanya bisa dibuat saat booking `HANDED_OVER`.
- [ ] Foto kondisi wajib pada pengembalian.
- [ ] Sistem mencatat selisih hari terhadap `end_date` bila pengembalian terlambat.
- [ ] Setelah kedua pihak mengonfirmasi, status booking menjadi `RETURNED`.
- [ ] Booking menjadi `COMPLETED` setelah deposit diselesaikan dan kedua pihak boleh menilai.

**Endpoint:** `POST /bookings/{bookingId}/handovers`.

---

## US-08 Memberi rating setelah transaksi selesai

**Must:** M5 · **Use case:** UC-05 · **Prioritas:** P15

Sebagai penyewa atau pemilik, saya ingin memberi rating setelah transaksi selesai, agar pengguna lain tahu siapa yang bisa dipercaya.

**Kriteria penerimaan:**
- [ ] Rating hanya bisa diberikan jika booking berstatus `COMPLETED`; selain itu 409.
- [ ] Rating berupa bilangan bulat 1 sampai 5.
- [ ] Komentar opsional, maksimal 1000 karakter.
- [ ] Satu pengguna hanya bisa memberi satu review per booking per peran.
- [ ] Pengguna yang bukan pihak pada booking ditolak dengan 403.
- [ ] Rata-rata rating barang dihitung ulang setelah review tersimpan.
- [ ] Review yang disembunyikan admin tidak dihitung dalam rata-rata.

**Endpoint:** `POST /bookings/{bookingId}/reviews`, `GET /users/{userId}/reviews`.

---

## Pemetaan story ke Must

| Story | Must | Use case | Fase |
|---|---|---|---|
| US-01 | M1 | UC-01 | P14 |
| US-02 | M1 | UC-01 | P14 |
| US-03 | M2 | UC-02 | P14 |
| US-04 | M3 | UC-03 | P15 |
| US-05 | M3 | UC-03 | P15 |
| US-06 | M4 | UC-04 | P15 |
| US-07 | M4 | UC-04 | P15 |
| US-08 | M5 | UC-05 | P15 |

## Catatan

- Kriteria penerimaan di atas menjadi dasar 15 test case black-box pada Session 3.
- Story untuk verifikasi KTM, deposit, dan sengketa sengaja tidak dibuat karena ketiganya kontrol alur, bukan Must. Perilakunya diatur di use case UC-06 dan UC-07.
