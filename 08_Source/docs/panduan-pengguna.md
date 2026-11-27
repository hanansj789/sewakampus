**Status:** Ada. Panduan pengguna singkat, 27 November 2026.
**Versi aplikasi:** P14, lima Must berjalan di staging.

# Panduan Pengguna SewaKampus

Panduan ini untuk mahasiswa yang menyewa barang dan mahasiswa yang menyewakan barang di SewaKampus. Isinya hanya fitur yang benar-benar tersedia saat ini.

## 1. Masuk dan keluar

1. Buka alamat SewaKampus yang diberikan panitia.
2. Klik **Masuk dengan akun kampus**.
3. Isi nama pengguna dan kata sandi pada halaman Keycloak.
4. Setelah masuk, Anda diarahkan ke halaman sesuai peran: mahasiswa atau admin.
5. Untuk keluar, klik **Keluar** di kanan atas.

Akun uji yang disediakan panitia: `hanan` (penyewa), `mahesa` (pemilik), `admin` (admin). Kata sandi diberikan terpisah, tidak ditulis di panduan ini.

## 2. Mencari dan menyewa barang

1. Buka menu **Katalog**.
2. Pilih barang yang ingin disewa. Halaman detail menampilkan harga harian, deposit, titik serah terima, dan foto.
3. Lihat **Ketersediaan**. Tanggal bergaris berarti sudah terpakai atau diblokir pemilik.
4. Isi **Tanggal mulai** dan **Tanggal selesai**, lalu klik **Kirim pengajuan**.
5. Pengajuan masuk ke menu **Pengajuan**, bagian **Pengajuan saya**, dengan status `PENDING`.
6. Tunggu pemilik memutuskan. Anda bisa membatalkan selama status masih `PENDING`.

Catatan: deposit dihitung dan dicatat, tetapi tidak ada uang yang benar-benar berpindah. Ini simulasi.

## 3. Menawarkan barang

1. Buka menu **Tambah barang**.
2. Isi nama barang, deskripsi, kategori, kondisi, harga per hari, deposit, dan titik serah terima.
3. Unggah foto (JPG atau PNG, maksimal 5 MB).
4. Klik **Simpan listing**.
   - Dengan foto: listing langsung aktif dan tampil di katalog.
   - Tanpa foto: listing disimpan sebagai draf dan belum tampil.
5. Untuk mengubah atau menambah foto, buka **Barang saya**, lalu **Kelola listing**.
6. Untuk menghentikan sementara, klik **Jeda listing**. Listing hilang dari katalog sampai diaktifkan lagi.

## 4. Memutuskan pengajuan

1. Buka **Pengajuan**, bagian **Masuk sebagai pemilik**.
2. Periksa nama penyewa, tanggal, dan total biaya.
3. Klik **Setujui**, atau isi alasan lalu klik **Tolak**.
4. Setelah disetujui, tanggal tersebut tidak bisa diajukan penyewa lain.

## 5. Serah terima dan pengembalian

1. Buka **Pengajuan**, lalu klik **Serah terima** pada pengajuan yang sudah disetujui.
2. Isi lokasi, catatan kondisi, dan unggah foto kondisi. Foto wajib.
3. Klik **Simpan serah terima**.
4. Pihak lain membuka halaman yang sama dan klik **Konfirmasi**.
5. Setelah kedua pihak mengonfirmasi, status berubah menjadi `HANDED_OVER`.
6. Saat barang dikembalikan, ulangi langkah 2–4 untuk pengembalian. Status berubah menjadi `RETURNED`.
7. Klik **Tandai selesai** untuk menutup transaksi. Status menjadi `COMPLETED` dan deposit simulasi dikembalikan.

Bila pengembalian melewati tanggal selesai, jumlah hari terlambat dicatat pada riwayat transaksi.

## 6. Memberi rating

1. Setelah transaksi `COMPLETED`, buka **Pengajuan**.
2. Klik **Beri rating**.
3. Pilih nilai 1 sampai 5 dan tulis komentar bila perlu.
4. Klik **Kirim rating**. Rating tampil di halaman barang.

Satu pengguna hanya bisa memberi satu rating per transaksi.

## 7. Arti status

| Status | Arti |
|---|---|
| `PENDING` | Pengajuan menunggu keputusan pemilik |
| `APPROVED` | Disetujui, menunggu serah terima |
| `HANDED_OVER` | Barang sudah diserahkan |
| `RETURNED` | Barang sudah dikembalikan |
| `COMPLETED` | Transaksi selesai, rating bisa diberikan |
| `REJECTED` | Ditolak pemilik, alasan tercatat |
| `CANCELLED` | Dibatalkan penyewa |

## 8. Bila ada masalah

| Gejala | Arti dan tindakan |
|---|---|
| Diarahkan ke halaman masuk terus | Sesi berakhir. Masuk ulang lewat Keycloak. |
| Halaman 403 | Anda membuka halaman milik peran lain. Kembali ke menu Anda. |
| Halaman 409 | Status transaksi sudah berubah. Muat ulang halaman. |
| Tanggal ditolak | Rentang bertabrakan. Pilih tanggal lain. |
| Foto ditolak | Pastikan JPG atau PNG dan kurang dari 5 MB. |
| Alamat tidak bisa dibuka | Staging hanya hidup saat laptop panitia menyala. Hubungi panitia. |

## 9. Yang belum tersedia

- Verifikasi KTM di dalam aplikasi; akun uji sudah aktif.
- Pembayaran deposit dengan uang sungguhan.
- Sengketa dan pemotongan deposit.
- Notifikasi email; notifikasi baru tercatat di sistem.
- Halaman profil berisi semua ulasan pengguna.

## 10. Bantuan

Hubungi panitia kelompok 1: Hanan (CEO/PO), Fharel (analis/UI), Fazha (programmer), Mahesa (jaringan/operasional). Sertakan tangkapan layar dan waktu kejadian.
