**Status:** Ada — pemeriksaan selesai; G-19 tertutup 24 November 2026.

# P13-07 — Pemeriksaan ERD terhadap Use Case

**Tanggal:** 23 November 2026
**Pemilik:** Fazha (Database Architect)
**Menjawab:** SK-009 (14 entitas adalah baseline yang harus diperiksa, bukan 3NF final) dan butir Gate 1 nomor 3 ("ERD 3NF konsisten dengan use case").

## 1. Yang diperiksa

| Sumber | Isi |
|---|---|
| `DESAIN/ERD - SewaKampus.drawio` | 14 entitas, 15 relasi |
| `DESAIN/Logical Data Model - SewaKampus.drawio` | model logis ringkas |
| `02_Data/P13-Data-Dictionary.md` | 118 atribut |
| `02_Data/P13-3NF-Proof.md` | bukti normalisasi 14 entitas |
| `08_Source/database/sql/001_init.sql` | 14 tabel, 22 foreign key, 1 view |
| `01_Business/P13-Use-Cases.md` | UC-01 sampai UC-07 |

Metode: setiap langkah pada tujuh use case dipetakan ke tabel dan kolom. Langkah yang tidak punya tempat penyimpanan dicatat sebagai temuan. Relasi pada ERD dibandingkan satu per satu dengan foreign key pada DDL.

## 2. Hasil per use case

| UC | Langkah yang menuntut data | Tabel dan kolom | Hasil |
|---|---|---|---|
| UC-01 Menawarkan barang | judul, deskripsi, kondisi, kategori, harga harian, deposit, titik serah terima, foto, status DRAFT/ACTIVE/PAUSED | `items` (`title`, `description`, `condition`, `category_id`, `daily_rate`, `deposit_amount`, `pickup_point`, `status`), `item_photos`, `item_categories` | **Cukup** |
| UC-02 Memeriksa ketersediaan | tanggal terisi dan kosong, blokir pemilik, total biaya sementara | `bookings` (`start_date`, `end_date`, `status`), `item_availabilities` (`status` = `BLOCKED`), `items.daily_rate`, `items.deposit_amount` | **Cukup**; "terisi" dihitung dari `bookings`, bukan disimpan |
| UC-03 Mengajukan dan menyetujui | booking PENDING, snapshot harga, riwayat status, notifikasi, pembatalan | `bookings`, `booking_status_histories`, `notifications`, `bookings.cancelled_at`, `cancelled_at_reason` | **Cukup** |
| UC-04 Serah terima dan pengembalian | handover OUT dan RETURN, foto wajib, lokasi, catatan kondisi, konfirmasi dua pihak, keterlambatan | `handovers` (`direction`, `photo_path` NOT NULL, `location`, `condition_notes`, `renter_confirmed_at`, `owner_confirmed_at`) | **Cukup**, dengan dua catatan (T-04, T-05) |
| UC-05 Rating dan ulasan | rating 1–5, komentar, status tampil, rata-rata barang dan pengguna | `reviews`, view `v_item_rating` | **Sebagian**: rata-rata pengguna belum punya sumber (T-03) |
| UC-06 Verifikasi mahasiswa | NIM, nama di KTM, program studi, berkas, hash duplikat, keputusan admin, status akun | `student_verifications`, `users.account_status` | **Sebagian**: status penolakan tidak ada di `users` (T-02), hash boleh kosong (T-08) |
| UC-07 Menyelesaikan sengketa | kategori, kronologi, bukti, keputusan, deposit | `disputes`, `deposits` (`REFUNDED`/`FORFEITED`, `forfeited_amount`), `bookings.status` = `DISPUTED` | **Cukup**, kecuali tautan bukti handover (T-04) |

Tidak ada use case yang menuntut entitas baru. **14 entitas tetap cukup.**

## 3. Relasi ERD dibanding foreign key DDL

DDL memuat **22 foreign key** pada **17 pasangan entitas**. ERD lama (`DESAIN/ERD - SewaKampus.drawio`) menggambar **15 relasi**. Dua pasangan tidak tergambar. ERD baru di `02_Data/P13-ERD.drawio` sudah menggambar **17 relasi**, jadi tabel di bawah adalah catatan riwayat dan dasar perbaikan.

| # | Relasi yang ada di DDL | Ada di ERD? | Akibat |
|---|---|---|---|
| T-01a | `booking_status_histories.changed_by` → `users.id` | **Tidak** | Pembaca ERD mengira riwayat status tidak punya pelaku, padahal kolomnya dipakai untuk audit siapa mengubah status |
| T-01b | `disputes.opened_by`, `disputes.against_user_id`, `disputes.resolved_by` → `users.id` | **Tidak** | Sengketa terlihat hanya milik `Booking`, padahal tiga kolomnya menunjuk `User` |

## 4. Temuan

| ID | Temuan | Tingkat | Dampak | Tindakan |
|---|---|---|---|---|
| T-01 | ERD lama tidak menggambar 2 pasangan relasi ke `User` yang ada di DDL | **Sedang** | Dulu membuat butir Gate 1 nomor 3 tidak cocok | **Sudah diperbaiki** 24 November 2026: `02_Data/P13-ERD.drawio` + `.png` memuat 14 entitas dan 17 relasi, semua foreign key DDL tergambar |
| T-02 | UC-06 pascakondisi menulis "akun `ACTIVE` atau `REJECTED`", tetapi `users.account_status` hanya `PENDING_VERIFICATION`, `ACTIVE`, `SUSPENDED`. Penolakan tercatat di `student_verifications.status` + `rejection_reason` | **Sedang** | Teks use case dan skema berbeda; dosen data bisa menanyakan yang mana yang berlaku | Pilih satu: (a) ubah teks UC-06 menjadi "verifikasi `APPROVED` atau `REJECTED`; akun tetap `PENDING_VERIFICATION` bila ditolak", atau (b) tambah status `REJECTED` pada `users`. Rekomendasi: (a), karena alasan penolakan memang milik pengajuan, bukan milik akun |
| T-03 | UC-05 langkah 5 menghitung ulang rata-rata rating **barang dan pengguna**. Hanya ada `v_item_rating`; tidak ada padanan untuk pengguna, padahal layar S-03 menampilkan "Pemilik: … · 5,0 (4)" | **Rendah** | Angka reputasi pemilik tidak punya sumber resmi; tiap layar bisa menghitung sendiri dan hasilnya berbeda | Tambah `v_user_rating` (rata-rata `reviews.rating` per `reviewee_id`) atau nyatakan eksplisit bahwa angka dihitung per permintaan |
| T-04 | `disputes` tidak menyimpan `handover_id`, padahal bukti sengketa kondisi adalah foto `handovers` | **Rendah** | Sengketa tidak bisa menunjuk handover mana yang dipersoalkan; `evidence_path` menunjuk berkas, bukan baris data | Tambah `handover_id` NULL-able, atau nyatakan bahwa bukti diambil dari `booking_id` + `direction` |
| T-05 | UC-04 langkah 6a "sistem menandai keterlambatan" tidak punya kolom | **Rendah** | Dua programmer bisa menghitung keterlambatan dengan dua cara berbeda | Tidak perlu kolom. Nyatakan rumusnya: `handovers.created_at` (RETURN) > `bookings.end_date` → terlambat. Tulis di TRD atau komentar migrasi |
| T-06 | `items.average_rating` dan `review_count` adalah cache (E-01 di bukti 3NF), tetapi tidak ada trigger atau prosedur penyegaran | **Sedang** | Cache dan view bisa berbeda; katalog menampilkan angka lama | Tetapkan mekanisme sebelum Gate 2, misalnya perbarui di Action setelah review `PUBLISHED`. P14 menuntut prosedur untuk proses kritis |
| T-07 | `item_availabilities.status` memuat `AVAILABLE`, padahal ketiadaan baris sudah berarti tersedia | **Rendah** | Dua cara menyatakan hal yang sama; risiko data ganda | Pilih: hanya simpan rentang `BLOCKED`, atau pertahankan dan tulis aturannya di kamus data |
| T-08 | `student_verifications.ktm_file_hash` NULL-able, padahal UC-06 langkah 2a memakai hash untuk deteksi duplikat | **Rendah** | Deteksi duplikat mati diam-diam bila hash kosong | Isi wajib saat unggah, atau nyatakan deteksi duplikat sebagai best-effort |

## 5. Kesimpulan

- Peta use case ke tabel **lengkap**: tujuh use case punya tempat penyimpanan untuk setiap langkahnya, dan lima Must tertutup.
- Struktur 14 entitas **tidak perlu ditambah**. Yang kurang adalah dua garis relasi pada ERD lama (T-01, sudah ditutup lewat `02_Data/P13-ERD.drawio`), satu view agregat (T-03), dan tiga pernyataan aturan (T-02, T-05, T-07).
- Penyimpangan normalisasi sudah tercatat terkendali di bukti 3NF: cache agregat (E-01), snapshot historis (E-02), referensi polimorfik (E-03). Pemeriksaan ini tidak menemukan penyimpangan keempat.
- Butir Gate 1 nomor 3 **terpenuhi dari sisi diagram** setelah ERD baru digambar. Sisa yang belum: T-02 (teks UC-06) dan uji DDL di database kosong, yang merupakan PR14-04 dan bukan bagian P13-07.

## 6. Tindak lanjut

| Prioritas | Tindakan | Pemilik | Batas |
|---|---|---|---|
| 1 | ~~Perbaiki ERD dan Logical Data Model: tambah relasi `BookingStatusHistory → User` dan `Dispute → User`~~ **selesai 23 November 2026** lewat `02_Data/P13-ERD.drawio` | Fazha | Selesai |
| 2 | Selaraskan teks UC-06 dengan skema (T-02) | Fharel dan Fazha | Sebelum Gate 1 |
| 3 | Tambah `v_user_rating` atau nyatakan aturan hitungnya (T-03) | Fazha | Sebelum P14 |
| 4 | Tetapkan mekanisme penyegaran cache rating (T-06) | Fazha | Sebelum Gate 2 |
| 5 | Putuskan T-04, T-05, T-07, T-08 dan catat di kamus data | Fazha | Sebelum P14 |

Catatan: tindakan 1 dan 2 mengubah artefak yang sudah berstatus Ada, sehingga setelah dikerjakan statusnya perlu ditinjau ulang di `P13-DELIVERABLE-MATRIX.md`.
