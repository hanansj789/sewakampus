# MoSCoW Backlog — SewaKampus P13

**Status:** Final (internal). Sudah direview tim dan diterima 24 November 2026; review silang formal dilewati lewat SK-021.
**Tanggal:** 23 November 2026 (isi), ditutup 24 November 2026

## Must (maksimal lima, terkunci)

| # | Fitur Must | Hasil yang bisa diuji | Endpoint terkait di `DESAIN/openapi.yaml` |
|---|---|---|---|
| M1 | Listing barang | Pemilik membuat listing dengan foto, kategori, harga harian, deskripsi, lokasi | `POST /items`, `PATCH /items/{itemId}`, `POST /items/{itemId}/photos` |
| M2 | Kalender ketersediaan | Penyewa melihat tanggal terisi dan tanggal kosong sebelum mengajukan | `GET /items/{itemId}/availability` |
| M3 | Persetujuan sewa | Pemilik menyetujui atau menolak pengajuan; status berubah berurutan | `POST /bookings`, `POST /bookings/{bookingId}/approve`, `POST /bookings/{bookingId}/reject` |
| M4 | Foto kondisi | Foto wajib saat serah terima (OUT) dan pengembalian (RETURN) | `POST /bookings/{bookingId}/handovers` (multipart, `photo` wajib sejak SK-014) |
| M5 | Rating | Penyewa dan pemilik memberi rating setelah transaksi selesai | `POST /bookings/{bookingId}/reviews`, `GET /users/{userId}/reviews` |

Tidak ada Must keenam. Permintaan menambah Must wajib lewat Change Request.

**Status kontrak M4:** sudah diperbaiki di `ARCHITECTURE_REPOSITORY/03_Application/openapi.yaml` (SK-014 dan SK-015). `DESAIN/openapi.yaml` hanya arsip. Validasi unggahan belum diuji karena fitur M4 belum dibangun.

## Should

Kontrol alur yang dibutuhkan agar lima Must bisa berjalan, bukan fitur tambahan:

| Fitur | Alasan masuk Should |
|---|---|
| Verifikasi KTM dan persetujuan admin | Tanpa ini, siapa pun bisa menyewa; menjadi kontrol kepercayaan |
| Deposit simulasi | Menahan risiko kerusakan tanpa uang nyata |
| Serah terima OUT dan RETURN | M4 bergantung pada dua kejadian ini |
| Moderasi listing dan penanganan sengketa | Menjaga katalog tetap layak |
| Notifikasi email status booking | Penyewa dan pemilik tahu status berubah |
| SSO Keycloak (OIDC + PKCE) | Sudah ditetapkan sebagai stack; dibangun setelah login dasar berjalan |

## Could

| Fitur | Catatan |
|---|---|
| Pencarian dan filter lanjutan (kategori, rentang harga, jarak) | Membantu, tidak menghambat alur inti |
| Riwayat transaksi dan statistik pemilik | Berguna setelah ada data |
| Sentry dan Uptime Kuma | Operasional, bukan fitur pengguna |
| Ekspor laporan admin | Untuk evaluasi pilot |

## Won't (fase ini)

Payment gateway asli, chat real-time, aplikasi mobile native, multi-kampus, rekomendasi berbasis machine learning, asuransi otomatis, loyalty, white-label, analitik lanjutan.

## Urutan pengerjaan

| Tahap | Isi | Gate |
|---|---|---|
| P13 | Desain: Vision, BPMN, use case, ERD, API, prototipe | Gate 1 |
| P14 | M1 dan M2 berjalan di database nyata | Gate 2 |
| P15 | M3, M4, M5 selesai; UAT; restore backup | Gate 3 |
| P16 | Rilis v1.0 dan pitch | Final |

M1 dan M2 dipilih lebih dulu karena keduanya satu alur dan bisa diuji tanpa membangun seluruh transaksi sewa.

## Catatan review

| Butir | Hasil |
|---|---|
| Lima Must | Tetap M1–M5, tidak ada Must keenam |
| Should, Could, Won't | Diterima tanpa perubahan isi |
| Reviewer | Empat anggota, dinyatakan lewat instruksi pemilik proyek 24 November 2026 |
| Batas | Tidak ada tanda tangan terpisah dan tidak ada review independen; status final bersifat internal (SK-021) |
