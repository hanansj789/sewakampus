**Status:** Draf. Rencana UAT untuk P15. Belum ada UAT yang dijalankan dan belum ada skor SUS.

# P15 — Rencana UAT SewaKampus

**Tanggal:** 23 November 2026  
**Mitra:** belum dikonfirmasi. Rencana memakai minimal tiga pengguna proksi bila mitra tetap belum tersedia.  
**Prinsip:** pengguna diberi tugas, bukan ditunjukkan caranya. Kebingungan dicatat sebagai temuan.

## 1. Skenario tugas

Pengguna menjalankan alur lima Must tanpa bantuan.

| Tugas | Tindakan | Kriteria berhasil |
|---|---|---|
| T1 | Membuat listing dengan foto | Listing aktif muncul di katalog |
| T2 | Menjeda dan melanjutkan listing | Status berubah dan tercermin di katalog |
| T3 | Melihat kalender dan memilih rentang kosong | Tanggal terpilih tanpa bentrok |
| T4 | Mengajukan sewa dan meninjau biaya | Pengajuan tersimpan dengan total biaya benar |
| T5 | Menyetujui dan menolak pengajuan | Status berubah sesuai keputusan, penolakan memuat alasan |
| T6 | Mencatat serah terima OUT dengan foto | Foto wajib terunggah dan catatan tersimpan |
| T7 | Mencatat pengembalian RETURN dengan foto | Foto wajib terunggah dan keterlambatan tercatat bila ada |
| T8 | Memberi rating setelah transaksi selesai | Rating 1 sampai 5 tersimpan |

## 2. Skenario kegagalan yang diamati

Fasilitator mencatat apa yang terjadi, bukan membantu.

- Akun belum terverifikasi mencoba membuat listing.
- Unggah foto dibatalkan di tengah proses.
- Rentang tanggal yang dipilih ternyata bertabrakan.
- Pemilik mencoba menolak tanpa alasan.
- Pengguna mencoba memberi rating sebelum transaksi selesai.

## 3. Kuesioner SUS

Sepuluh butir standar, skala 1 sampai 5. Skor dihitung setelah semua pengguna menjawab.

| # | Pernyataan |
|---|---|
| 1 | Saya akan sering memakai SewaKampus. |
| 2 | Sistem ini terasa rumit. |
| 3 | Sistem ini mudah digunakan. |
| 4 | Saya perlu bantuan teknisi untuk memakainya. |
| 5 | Fungsi-fungsi sistem terintegrasi dengan baik. |
| 6 | Terlalu banyak ketidakkonsistenan pada sistem ini. |
| 7 | Orang lain akan cepat mempelajari sistem ini. |
| 8 | Sistem ini merepotkan untuk dipakai. |
| 9 | Saya percaya diri saat memakai sistem ini. |
| 10 | Saya perlu belajar banyak hal sebelum memakainya. |

Cara hitung: butir ganjil memakai skor dikurangi 1, butir genap memakai 5 dikurangi skor. Jumlahnya dikali 2,5.

## 4. Cara mencatat bukti

- Waktu penyelesaian setiap tugas.
- Kesalahan, jalan buntu, dan komentar pengguna apa adanya.
- Foto atau rekaman layar bila pengguna mengizinkan.
- Kuesioner SUS yang sudah diisi.
- Tidak ada skor, nama responden, atau hasil yang ditulis sebelum UAT benar-benar terjadi.

## 5. Rencana pengguna proksi

Minimal tiga pengguna dengan profil jelas, identitas dicatat saat UAT berlangsung.

| Peran | Profil yang dibutuhkan |
|---|---|
| Penyewa | Mahasiswa yang pernah menyewa barang lewat grup chat |
| Pemilik | Mahasiswa yang pernah menyewakan barangnya |
| Admin | Mahasiswa yang memahami proses verifikasi KTM |

## 6. Batasan

- UAT memakai prototipe atau build staging, bukan data produksi.
- Hasil UAT dan skor SUS dicatat pada P15 setelah pengujian nyata.
