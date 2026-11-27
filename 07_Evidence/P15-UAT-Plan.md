**Status:** Ada. Rencana UAT siap dijalankan, 27 November 2026.
**Catatan:** belum ada UAT yang dijalankan dan belum ada skor SUS. Dokumen ini hanya alat; hasil diisi setelah sesi.

# P15 — Rencana dan Perangkat UAT SewaKampus

**Pemilik:** Fharel Sapvela Dwipa (System Analyst & UI/UX)
**Fasilitator:** Fharel. **Pencatat:** Hanan. **Operator teknis:** Fazha.
**Lingkungan:** staging `https://cakes-clicks-berlin-alan.trycloudflare.com` (periksa ulang sebelum sesi).
**Berkas pendukung:** `07_Evidence/P15-SUS-Template.xlsx`.

## 1. Tujuan

Menguji apakah lima fitur Must dapat diselesaikan pengguna tanpa diarahkan, lalu mengukur kepuasan dengan SUS. Yang dicari bukan pujian, tetapi titik bingung.

## 2. Peserta

Minimal tiga pengguna proksi bila mitra tidak tersedia. Setiap peserta diberi kode, bukan nama asli, di laporan.

| Kode | Profil yang dicari | Peran dalam sesi |
|---|---|---|
| P1 | Mahasiswa yang pernah menyewa barang | Penyewa |
| P2 | Mahasiswa yang punya barang untuk disewakan | Pemilik |
| P3 | Mahasiswa non-teknis yang belum pernah memakai aplikasi sewa | Penyewa kedua dan penilai |

Peserta tidak boleh anggota tim yang membangun fitur yang diujinya. Bila terpaksa memakai anggota tim, catat sebagai **proksi internal** dan jangan sebut sebagai mitra.

## 3. Skenario tugas

Tugas dibacakan apa adanya. Fasilitator tidak menunjukkan tombol atau langkah.

| Kode | Untuk | Tugas | Berhasil bila |
|---|---|---|---|
| U1 | P1, P3 | Masuk ke SewaKampus dengan akun yang diberikan | Sampai halaman katalog |
| U2 | P2 | Tawarkan satu barang dengan foto, harga, dan titik serah terima | Listing aktif muncul di katalog |
| U3 | P2 | Hentikan sementara barang itu, lalu aktifkan lagi | Status berubah dan katalog mengikuti |
| U4 | P1, P3 | Cari barang dan tentukan tanggal yang masih kosong | Memilih rentang tanpa bentrok |
| U5 | P1 | Ajukan sewa untuk tiga hari | Pengajuan tersimpan dengan total benar |
| U6 | P2 | Setujui satu pengajuan, tolak satu pengajuan dengan alasan | Status berubah; alasan tercatat |
| U7 | P1, P2 | Catat serah terima dengan foto | Foto terunggah, status menunggu konfirmasi |
| U8 | P2 | Konfirmasi serah terima dari pihak lain | Status menjadi diserahkan |
| U9 | P1, P2 | Catat dan konfirmasi pengembalian dengan foto | Status menjadi dikembalikan |
| U10 | P2 | Selesaikan transaksi | Status selesai, deposit simulasi dikembalikan |
| U11 | P1, P3 | Beri rating dan ulasan setelah transaksi selesai | Rating tampil di halaman barang |

## 4. Skenario negatif yang diamati

Fasilitator mencatat reaksi pengguna, bukan membantu:

- Menyimpan listing tanpa judul.
- Mengunggah berkas bukan gambar.
- Memilih tanggal yang bertabrakan.
- Menolak pengajuan tanpa alasan.
- Memberi rating sebelum transaksi selesai.

## 5. Jalannya sesi (60 menit)

| Menit | Kegiatan |
|---|---|
| 0–5 | Sambutan, izin rekaman, penjelasan bahwa yang diuji aplikasi bukan peserta |
| 5–10 | P1 dan P3 masuk, P2 menyiapkan listing (U1–U3) |
| 10–25 | P1 mencari dan mengajukan sewa; P2 memutuskan (U4–U6) |
| 25–40 | Serah terima, pengembalian, penyelesaian (U7–U10) |
| 40–50 | Rating, ulasan, dan penjelajahan bebas (U11) |
| 50–60 | Kuesioner SUS dan wawancara singkat |

Aturan: satu peserta satu perangkat. Jangan membantu kecuali peserta benar-benar berhenti lebih dari dua menit; bantuan dicatat sebagai temuan.

## 6. Yang dicatat

| Data | Cara |
|---|---|
| Keberhasilan tugas | Berhasil, berhasil dengan bantuan, gagal |
| Waktu | Detik, dari tugas dibacakan sampai selesai |
| Kesalahan | Salah klik, salah paham, kembali berulang |
| Kutipan | Kalimat peserta apa adanya |
| Ekspektasi | Apa yang peserta cari tetapi tidak ada |

Lembar observasi ada di `P15-SUS-Template.xlsx` sheet `Tugas`.

## 7. Kuesioner SUS

Sepuluh pernyataan, skala 1 (sangat tidak setuju) sampai 5 (sangat setuju).

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

Perhitungan: butir ganjil = skor − 1; butir genap = 5 − skor; jumlah × 2,5. Rentang 0–100. Rata-rata tiga peserta menjadi skor SUS.

Pembanding, bukan target yang dikarang: SUS di atas 68 dianggap di atas rata-rata pada literatur umum. Tim boleh memakai 68 sebagai garis pembanding, tetapi hasil nyata tetap apa adanya.

## 8. Etika dan bukti

- Minta izin tertulis atau lisan sebelum merekam layar atau suara.
- Jangan menyimpan nama, nomor telepon, atau berkas KTM peserta.
- Rekaman disimpan di folder privat, tidak di repo.
- Peserta boleh berhenti kapan saja.
- Laporan memakai kode P1–P3, bukan nama.

## 9. Kerangka laporan hasil

Diisi setelah sesi, bukan sebelumnya:

| Bagian | Isi |
|---|---|
| Tanggal dan tempat | |
| Peserta | P1, P2, P3 beserta profil singkat |
| Keberhasilan tugas | x dari 11 per peserta |
| Rata-rata waktu | per tugas |
| Kesalahan terbanyak | |
| Kutipan penting | |
| Skor SUS | per peserta dan rata-rata |
| Temuan prioritas | dampak × kemudahan perbaikan |
| Tindak lanjut | siapa, kapan |

## 10. Batas

Rencana ini belum dijalankan. Tidak ada skor, kutipan, atau temuan yang boleh ditulis sebelum sesi benar-benar terjadi. Mitra eksternal belum dikonfirmasi; bila tetap tidak ada, laporan harus menyebut peserta sebagai proksi.
