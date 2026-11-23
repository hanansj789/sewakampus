# Bukti Normalisasi 3NF — SewaKampus

**Status:** Draf. Diperiksa terhadap 118 atribut pada `P13-Data-Dictionary.md`.
**Tanggal:** 23 November 2026

## Cara membaca

Untuk setiap entitas dituliskan kunci kandidat, ketergantungan fungsional (FD) yang berlaku, lalu tiga pemeriksaan: tidak ada grup berulang (1NF), tidak ada ketergantungan parsial (2NF), tidak ada ketergantungan transitif (3NF).

Entitas yang sengaja menyimpang ditandai **penyimpangan terkendali**, dengan alasan dan cara menjaganya. Norma bukan tujuan akhir; yang penting setiap penyimpangan diketahui dan dijaga.

## Ringkasan

| Entitas | Kunci kandidat | 1NF | 2NF | 3NF | Catatan |
|---|---|---|---|---|---|
| `User` | `id`, `public_id`, `email` | ya | ya | ya | — |
| `StudentVerification` | `id`, `public_id` | ya | ya | ya | Riwayat pengajuan, bukan 1:1 |
| `ItemCategory` | `id`, `public_id`, `name`, `slug` | ya | ya | ya | — |
| `Item` | `id`, `public_id` | ya | ya | ya | Dua kolom agregat, lihat E-01 |
| `ItemPhoto` | `id`, (`item_id`,`sort_order`) | ya | ya | ya | — |
| `ItemAvailability` | `id` | ya | ya | ya | Tumpang tindih dijaga aplikasi |
| `Booking` | `id`, `public_id` | ya | ya | ya | Snapshot harga dan pemilik, lihat E-02 |
| `BookingStatusHistory` | `id` | ya | ya | ya | — |
| `Deposit` | `id`, `public_id`, `booking_id` | ya | ya | ya | 1:1 dengan booking |
| `Handover` | `id`, `public_id`, (`booking_id`,`direction`) | ya | ya | ya | — |
| `Review` | `id`, `public_id` | ya | ya | ya | — |
| `Dispute` | `id`, `public_id` | ya | ya | ya | — |
| `Notification` | `id`, `public_id` | ya | ya | ya | Referensi polimorfik, lihat E-03 |
| `AuditLog` | `id` | ya | ya | ya | Tanpa `public_id` |

## Pemeriksaan per entitas

### User

Kunci kandidat: `id`, `public_id`, `email`.
FD: `id → public_id, full_name, email, password_hash, phone, role, account_status, deleted_at`; `public_id → id`; `email → id`.

1NF: semua atribut atomik, tidak ada grup berulang.
2NF: kunci tunggal, sehingga tidak mungkin ada ketergantungan parsial.
3NF: tidak ada atribut non-kunci yang menentukan atribut non-kunci lain. `role` dan `account_status` adalah klasifikasi akun, bukan turunan dari atribut lain.

### StudentVerification

Kunci kandidat: `id`, `public_id`.
FD: `id → public_id, user_id, nim, name_on_card, study_program, faculty, ktm_file_path, ktm_file_hash, status, reviewed_by, rejection_reason`.

1NF dan 2NF terpenuhi. 3NF: `status` bergantung pada pengajuan, bukan pada `reviewed_by`. `rejection_reason` hanya bermakna saat `status = REJECTED`; aturan itu dijaga aplikasi (constraint kondisional, bukan ketergantungan transitif).
Catatan: `user_id` tidak unik karena mahasiswa bisa mengajukan ulang setelah ditolak. Verifikasi aktif ditentukan oleh baris terbaru berstatus `APPROVED`.

### ItemCategory

Kunci kandidat: `id`, `public_id`, `name`, `slug`.
FD: `id → public_id, name, slug, is_active, sort_order`; `name → id`; `slug → id`.

Tiga kunci kandidat, semuanya tunggal. Tidak ada ketergantungan parsial maupun transitif. `sort_order` adalah preferensi tampilan, bukan turunan `name`.

### Item

Kunci kandidat: `id`, `public_id`.
FD: `id → public_id, owner_id, category_id, title, description, condition, daily_rate, deposit_amount, pickup_point, status, average_rating, review_count, deleted_at`.

1NF dan 2NF terpenuhi. 3NF terpenuhi untuk atribut deskriptif. Dua pengecualian:

**E-01 Agregat rating.** `average_rating` dan `review_count` adalah fungsi dari `Review`. Secara murni ini melanggar 3NF karena nilai diturunkan dari tabel lain, bukan dari kunci `Item`.
Keputusan: dipertahankan sebagai cache baca agar katalog tidak menjalankan agregasi setiap permintaan. Nilai kanonik tetap hasil hitung `Review`. Cache dihitung ulang setiap review ditambah, diubah, atau disembunyikan. Jika cache dihapus, sistem tetap benar; yang hilang hanya kecepatan.

### ItemPhoto

Kunci kandidat: `id`, (`item_id`, `sort_order`).
FD: `id → item_id, file_path, alt_text, sort_order, is_primary`.

2NF: kunci komposit (`item_id`, `sort_order`) hanya dipakai untuk keunikan urutan. Semua atribut bergantung pada `id`, kunci tunggal. Tidak ada atribut yang hanya bergantung pada sebagian kunci komposit.
3NF: `is_primary` tidak diturunkan dari `sort_order`; aturan "tepat satu foto utama" dijaga aplikasi dalam satu transaksi.

### ItemAvailability

Kunci kandidat: `id`.
FD: `id → item_id, start_date, end_date, status, note`.

1NF sampai 3NF terpenuhi. Yang tidak dijamin skema adalah larangan rentang bertumpuk untuk `item_id` yang sama. Aturan itu dijaga transaksi aplikasi saat menyimpan blokir.

### Booking

Kunci kandidat: `id`, `public_id`.
FD: `id → public_id, item_id, renter_id, owner_id, start_date, end_date, daily_rate_snapshot, subtotal, deposit_snapshot, total_amount, status, pickup_point, renter_note, owner_note, approved_at, cancelled_at, cancellation_reason`.

**E-02 Snapshot historis.** `owner_id`, `daily_rate_snapshot`, `deposit_snapshot`, dan `pickup_point` secara teknis dapat diturunkan dari `Item`. Secara 3NF itu ketergantungan transitif `id → item_id → owner_id`.
Keputusan: dipertahankan karena nilainya adalah fakta pada saat transaksi. Jika harga barang naik atau barang berpindah pemilik, booking lama tidak boleh ikut berubah. Mengambil nilai langsung dari `Item` justru merusak kebenaran data historis.
Konsekuensi: `total_amount` dihitung dari snapshot, bukan dari harga terkini. `subtotal = daily_rate_snapshot × jumlah hari`; `total_amount = subtotal + deposit_snapshot`. Keduanya dijaga di satu tempat pada kode, bukan dihitung ulang di beberapa layar.

### BookingStatusHistory

Kunci kandidat: `id`.
FD: `id → booking_id, from_status, to_status, changed_by, reason, created_at`.

1NF sampai 3NF terpenuhi. Tabel ini append-only; baris lama tidak diubah. `from_status` sengaja disimpan walau bisa dilihat dari baris sebelumnya, karena riwayat harus tetap terbaca meski ada baris yang hilang.

### Deposit

Kunci kandidat: `id`, `public_id`, `booking_id`.
FD: `id → public_id, booking_id, amount, status, method, paid_at, refunded_at, forfeited_amount`.

Relasi 1:1 dijaga oleh `UNIQUE(booking_id)`. Tidak ada ketergantungan transitif; `forfeited_amount` adalah keputusan admin, bukan turunan `amount`.

### Handover

Kunci kandidat: `id`, `public_id`, (`booking_id`, `direction`).
FD: `id → public_id, booking_id, direction, location, condition_notes, photo_path, renter_confirmed_at, owner_confirmed_at`.

2NF: kunci komposit hanya untuk keunikan; atribut bergantung pada `id`.
3NF: `photo_path` bergantung pada handover, bukan pada booking. Maksimal dua baris per booking (OUT dan RETURN), dijaga `UNIQUE(booking_id, direction)`.

### Review

Kunci kandidat: `id`, `public_id`.
FD: `id → public_id, booking_id, reviewer_id, reviewee_id, reviewer_role, rating, comment, status`.

3NF terpenuhi. Aturan "satu review per booking per peran" adalah kunci unik bisnis yang perlu dijaga di aplikasi, bukan ketergantungan fungsional.

### Dispute

Kunci kandidat: `id`, `public_id`.
FD: `id → public_id, booking_id, opened_by, against_user_id, category, description, evidence_path, status, resolution, resolved_by, resolved_at`.

3NF terpenuhi. `resolution`, `resolved_by`, dan `resolved_at` hanya terisi saat status `RESOLVED` atau `REJECTED`; aturan itu dijaga aplikasi.

### Notification

Kunci kandidat: `id`, `public_id`.
FD: `id → public_id, user_id, type, title, body, channel, status, entity_type, entity_public_id, read_at`.

**E-03 Referensi polimorfik.** `entity_type` dan `entity_public_id` menunjuk ke tabel berbeda tanpa foreign key. Ini bukan ketergantungan transitif, melainkan referensi lemah.
Keputusan: dipertahankan karena notifikasi bisa menunjuk booking, item, atau sengketa. Integritas dijaga di aplikasi: notifikasi yang menunjuk data terhapus tetap ditampilkan tanpa tautan.

### AuditLog

Kunci kandidat: `id`.
FD: `id → actor_id, action, entity_type, entity_id, metadata, created_at`.

3NF terpenuhi. Tabel append-only, tanpa update dan tanpa delete. Tidak punya `public_id` karena tidak diekspos ke pengguna.

## Kesimpulan

- 14 entitas memenuhi 1NF dan 2NF.
- 14 entitas memenuhi 3NF untuk atribut faktualnya.
- Tiga penyimpangan terkendali dicatat: cache agregat (E-01), snapshot historis (E-02), dan referensi polimorfik (E-03). Ketiganya punya alasan operasional dan tidak mengubah sumber kebenaran.
- Yang masih harus dijaga di kode, bukan di skema: larangan rentang tanggal bertumpuk, tepat satu foto utama, satu review per booking per peran, dan transisi status booking yang tidak boleh melompat.

**Batas dokumen ini:** pemeriksaan dilakukan dengan membaca kamus data dan kontrak API, belum diuji dengan DDL yang dijalankan di database kosong. Pengujian DDL adalah bagian PR14-04.
