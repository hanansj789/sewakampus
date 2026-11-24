# Data Dictionary — SewaKampus

**Status:** Final (internal), 24 November 2026. Disusun dari tabel 3.6, 3.7, dan 3.8 laporan Progres 12, lalu diperiksa terhadap kontrak API.
**Tanggal:** 23 November 2026
**Sumber asli:** `LAPORAN/Progres Pertemuan 12 - Kelompok 1 - SewaKampus.docx` bagian 3.4.1.4.

Kolom **Null** berarti atribut boleh kosong. Semua tabel memakai `id BIGINT UNSIGNED` sebagai primary key internal dan `public_id CHAR(26)` sebagai ULID publik, kecuali tabel anak yang tidak punya `public_id`.

## Daftar entitas

| Entitas | Atribut | Deskripsi |
|---|---|---|
| `User` | 9 | Akun pengguna: mahasiswa dan admin. |
| `StudentVerification` | 12 | Pengajuan verifikasi KTM dan keputusan admin. |
| `ItemCategory` | 6 | Kategori barang untuk katalog. |
| `Item` | 14 | Listing barang yang ditawarkan pemilik. |
| `ItemPhoto` | 6 | Foto listing di object storage. |
| `ItemAvailability` | 6 | Blokir tanggal oleh pemilik; ketersediaan efektif dihitung bersama Booking. |
| `Booking` | 12 | Transaksi sewa dan statusnya. |
| `BookingStatusHistory` | 5 | Jejak perubahan status booking. |
| `Deposit` | 8 | Deposit simulasi per booking. |
| `Handover` | 8 | Serah terima OUT dan pengembalian RETURN beserta foto kondisi. |
| `Review` | 8 | Rating dan ulasan setelah transaksi selesai. |
| `Dispute` | 10 | Sengketa yang ditangani admin. |
| `Notification` | 8 | Notifikasi dalam aplikasi dan email. |
| `AuditLog` | 6 | Catatan audit append-only. |

## User

Akun pengguna: mahasiswa dan admin.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK, auto increment |
| `public_id` | CHAR(26) | Tidak | UQ, ULID, dipakai di URL |
| `full_name` | VARCHAR(100) | Tidak | Nama lengkap |
| `email` | VARCHAR(150) | Tidak | UQ, format email, dipakai login |
| `password_hash` | VARCHAR(255) | Tidak | Hash Argon2id atau bcrypt; tidak pernah dikembalikan API |
| `phone` | VARCHAR(20) | Ya | Nomor kontak |
| `role` | VARCHAR(20) | Tidak | CHECK IN ('STUDENT','ADMIN'); default STUDENT |
| `account_status` | VARCHAR(20) | Tidak | CHECK IN ('PENDING_VERIFICATION','ACTIVE','SUSPENDED') |
| `deleted_at` | DATETIME | Ya | Soft delete; email tetap UQ |

## StudentVerification

Pengajuan verifikasi KTM dan keputusan admin.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `public_id` | CHAR(26) | Tidak | UQ, ULID |
| `user_id` | BIGINT UNSIGNED | Tidak | FK ke User.id; 1:N |
| `nim` | VARCHAR(20) | Tidak | Nomor induk mahasiswa |
| `name_on_card` | VARCHAR(100) | Tidak | Nama pada KTM |
| `study_program` | VARCHAR(100) | Tidak | Program studi |
| `faculty` | VARCHAR(100) | Ya | Fakultas |
| `ktm_file_path` | VARCHAR(500) | Tidak | Path privat; bukan URL publik |
| `ktm_file_hash` | CHAR(64) | Ya | SHA-256 untuk deteksi duplikat |
| `status` | VARCHAR(20) | Tidak | CHECK IN ('PENDING','APPROVED','REJECTED') |
| `reviewed_by` | BIGINT UNSIGNED | Ya | FK ke User.id; harus admin |
| `rejection_reason` | VARCHAR(500) | Ya | Wajib saat REJECTED; dicek aplikasi |

## ItemCategory

Kategori barang untuk katalog.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `public_id` | CHAR(26) | Tidak | UQ, ULID |
| `name` | VARCHAR(80) | Tidak | UQ |
| `slug` | VARCHAR(80) | Tidak | UQ; dipakai URL |
| `is_active` | BOOLEAN | Tidak | Default TRUE |
| `sort_order` | INT | Tidak | Default 0 |

## Item

Listing barang yang ditawarkan pemilik.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `public_id` | CHAR(26) | Tidak | UQ, ULID |
| `owner_id` | BIGINT UNSIGNED | Tidak | FK ke User.id; 1:N |
| `category_id` | BIGINT UNSIGNED | Tidak | FK ke ItemCategory.id; 1:N |
| `title` | VARCHAR(120) | Tidak | Judul listing |
| `description` | TEXT | Tidak | Deskripsi dan kondisi |
| `condition` | VARCHAR(20) | Tidak | CHECK IN ('NEW','GOOD','FAIR') |
| `daily_rate` | DECIMAL(12,2) | Tidak | CHECK >= 0; harga per hari |
| `deposit_amount` | DECIMAL(12,2) | Tidak | CHECK >= 0 |
| `pickup_point` | VARCHAR(120) | Tidak | Titik serah terima |
| `status` | VARCHAR(20) | Tidak | CHECK IN ('DRAFT','ACTIVE','PAUSED','ARCHIVED') |
| `average_rating` | DECIMAL(3,2) | Tidak | Agregat 0..5; dihitung ulang dari Review |
| `review_count` | INT UNSIGNED | Tidak | Agregat; dihitung ulang dari Review |
| `deleted_at` | DATETIME | Ya | Soft delete |

## ItemPhoto

Foto listing di object storage.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `item_id` | BIGINT UNSIGNED | Tidak | FK ke Item.id; ON DELETE CASCADE |
| `file_path` | VARCHAR(500) | Tidak | Path object storage |
| `alt_text` | VARCHAR(150) | Ya | Teks alternatif |
| `sort_order` | INT | Tidak | UQ (item_id, sort_order); default 0 |
| `is_primary` | BOOLEAN | Tidak | Satu foto utama per item; dicek aplikasi |

## ItemAvailability

Blokir tanggal oleh pemilik; ketersediaan efektif dihitung bersama Booking.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `item_id` | BIGINT UNSIGNED | Tidak | FK ke Item.id; ON DELETE CASCADE |
| `start_date` | DATE | Tidak | Awal rentang |
| `end_date` | DATE | Tidak | CHECK end_date >= start_date |
| `status` | VARCHAR(20) | Tidak | CHECK IN ('AVAILABLE','BLOCKED') |
| `note` | VARCHAR(255) | Ya | Alasan blokir |

## Booking

Transaksi sewa dan statusnya.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `public_id` | CHAR(26) | Tidak | UQ, ULID |
| `item_id` | BIGINT UNSIGNED | Tidak | FK ke Item.id; 1:N |
| `renter_id` | BIGINT UNSIGNED | Tidak | FK ke User.id; 1:N |
| `owner_id` | BIGINT UNSIGNED | Tidak | FK ke User.id; denormalisasi dari Item.owner_id |
| `start_date` | DATE | Tidak | Awal sewa |
| `end_date` | DATE | Tidak | CHECK end_date >= start_date |
| `daily_rate_snapshot, subtotal, deposit_snapshot, total_amount` | DECIMAL(12,2) | Tidak | Snapshot harga; total = subtotal + deposit |
| `status` | VARCHAR(20) | Tidak | CHECK IN ('PENDING','APPROVED','REJECTED','CANCELLED','HANDED_OVER','RETURNED','COMPLETED','DISPUTED') |
| `pickup_point` | VARCHAR(120) | Tidak | Titik serah terima |
| `renter_note, owner_note` | VARCHAR(500) | Ya | Catatan transaksi |
| `approved_at, cancelled_at, cancellation_reason` | DATETIME, VARCHAR(500) | Ya | Jejak persetujuan dan pembatalan |

## BookingStatusHistory

Jejak perubahan status booking.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `booking_id` | BIGINT UNSIGNED | Tidak | FK ke Booking.id; ON DELETE CASCADE |
| `from_status, to_status` | VARCHAR(20) | Tidak | Status sebelum dan sesudah |
| `changed_by` | BIGINT UNSIGNED | Ya | FK ke User.id |
| `reason` | VARCHAR(500) | Ya | Alasan perubahan |

## Deposit

Deposit simulasi per booking.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `public_id` | CHAR(26) | Tidak | UQ, ULID |
| `booking_id` | BIGINT UNSIGNED | Tidak | FK ke Booking.id; UQ; 1:1 |
| `amount` | DECIMAL(12,2) | Tidak | CHECK >= 0 |
| `status` | VARCHAR(20) | Tidak | CHECK IN ('PENDING','PAID_SIMULATED','HELD','REFUNDED','FORFEITED') |
| `method` | VARCHAR(20) | Tidak | CHECK IN ('SIMULATED') |
| `paid_at, refunded_at` | DATETIME | Ya | Waktu simulasi dan refund |
| `forfeited_amount` | DECIMAL(12,2) | Tidak | CHECK >= 0; default 0 |

## Handover

Serah terima OUT dan pengembalian RETURN beserta foto kondisi.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `public_id` | CHAR(26) | Tidak | UQ, ULID |
| `booking_id` | BIGINT UNSIGNED | Tidak | FK ke Booking.id; 1:N |
| `direction` | VARCHAR(10) | Tidak | CHECK IN ('OUT','RETURN'); UQ (booking_id, direction) |
| `location` | VARCHAR(120) | Tidak | Titik serah terima |
| `condition_notes` | TEXT | Ya | Kondisi barang |
| `photo_path` | VARCHAR(500) | Ya | Bukti foto di object storage |
| `renter_confirmed_at, owner_confirmed_at` | DATETIME | Ya | Konfirmasi kedua pihak |

## Review

Rating dan ulasan setelah transaksi selesai.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `public_id` | CHAR(26) | Tidak | UQ, ULID |
| `booking_id` | BIGINT UNSIGNED | Tidak | FK ke Booking.id; 1:N |
| `reviewer_id, reviewee_id` | BIGINT UNSIGNED | Tidak | FK ke User.id; reviewer tidak boleh sama dengan reviewee |
| `reviewer_role` | VARCHAR(10) | Tidak | CHECK IN ('RENTER','OWNER') |
| `rating` | TINYINT UNSIGNED | Tidak | CHECK 1 sampai 5 |
| `comment` | VARCHAR(1000) | Ya | Komentar publik |
| `status` | VARCHAR(20) | Tidak | CHECK IN ('PUBLISHED','HIDDEN') |

## Dispute

Sengketa yang ditangani admin.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `public_id` | CHAR(26) | Tidak | UQ, ULID |
| `booking_id` | BIGINT UNSIGNED | Tidak | FK ke Booking.id; 1:N |
| `opened_by` | BIGINT UNSIGNED | Tidak | FK ke User.id; pihak yang membuka |
| `against_user_id` | BIGINT UNSIGNED | Ya | FK ke User.id; pihak yang disengketakan |
| `category` | VARCHAR(30) | Tidak | CHECK IN ('DAMAGE','LATE_RETURN','NOT_AS_DESCRIBED','NO_SHOW','OTHER') |
| `description` | TEXT | Tidak | Kronologi sengketa |
| `evidence_path` | VARCHAR(500) | Ya | Bukti foto atau dokumen |
| `status` | VARCHAR(20) | Tidak | CHECK IN ('OPEN','IN_REVIEW','RESOLVED','REJECTED') |
| `resolution, resolved_by, resolved_at` | VARCHAR(500), BIGINT, DATETIME | Ya | Keputusan admin dan waktunya |

## Notification

Notifikasi dalam aplikasi dan email.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK |
| `public_id` | CHAR(26) | Tidak | UQ, ULID |
| `user_id` | BIGINT UNSIGNED | Tidak | FK ke User.id; 1:N |
| `type` | VARCHAR(40) | Tidak | Kode jenis notifikasi |
| `title, body` | VARCHAR(120), VARCHAR(500) | Tidak | Isi notifikasi |
| `channel, status` | VARCHAR(20) | Tidak | CHECK channel IN ('IN_APP','EMAIL'); status IN ('QUEUED','SENT','FAILED','READ') |
| `entity_type, entity_public_id` | VARCHAR(30), CHAR(26) | Ya | Referensi polimorfik tanpa FK |
| `read_at` | DATETIME | Ya | Waktu dibaca |

## AuditLog

Catatan audit append-only.

| Atribut | Tipe | Null | Constraint dan keterangan |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Tidak | PK; append-only |
| `actor_id, actor_role` | BIGINT UNSIGNED, VARCHAR(20) | Ya | Pelaku dan perannya |
| `action` | VARCHAR(60) | Tidak | Contoh: VERIFICATION_VIEWED |
| `entity_type, entity_public_id` | VARCHAR(40), CHAR(26) | Ya | Objek yang terkena aksi |
| `ip_address, user_agent` | VARBINARY(16), VARCHAR(255) | Ya | Jejak akses |
| `metadata` | JSON | Ya | Konteks tambahan; bukan data inti |

## Catatan pemeriksaan

- `Handover.photo_path` sudah ada di kamus data, tetapi kontrak API lama belum menerimanya. Kontrak repo sudah diperbaiki menjadi multipart dengan foto wajib (SK-014).
- `Booking.owner_id` adalah snapshot pemilik saat transaksi, bukan salinan yang bisa berubah mengikuti `Item.owner_id`.
- `Item.average_rating` dan `Item.review_count` adalah cache agregat. Nilai kanonik dihitung dari `Review`.
- `Notification.entity_type` dan `entity_public_id` adalah referensi polimorfik tanpa foreign key, disengaja agar notifikasi tidak terikat satu tabel.
- `AuditLog` tidak punya `public_id` karena tidak pernah ditampilkan ke pengguna.
