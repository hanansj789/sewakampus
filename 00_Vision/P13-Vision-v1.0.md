# Vision v1.0 — SewaKampus

**Status:** Draf v1.0. Menunggu persetujuan Hanan Rizqullah sebagai CEO/PO dan tiga anggota lain sebelum dinyatakan beku di Gate 1.
**Tanggal:** 23 November 2026
**Dasar:** laporan Progres 12 §1.1–1.4 dan §3.2, serta `Skenario_Project ASP R001.txt` hlm. 7 dan 15.

## Masalah

Mahasiswa membutuhkan barang yang hanya dipakai beberapa hari: kamera, proyektor, tenda, alat camping, kostum, alat laboratorium. Membelinya mahal dan memakan ruang kamar.

Di sisi lain, barang milik mahasiswa lain menganggur dan bisa disewakan. Transaksi sewa antar-mahasiswa hari ini berjalan di grup WhatsApp tanpa katalog, tanpa harga jelas, dan tanpa catatan. Penyewa tidak tahu kondisi barang, pemilik tidak tahu siapa penyewanya, dan tidak ada mekanisme ketika barang rusak atau terlambat kembali.

Marketplace rental umum sudah ada, tetapi bergerak di pasar luas dan sebagian berfokus pada vendor. SewaKampus mengambil ceruk satu kampus: verifikasi mahasiswa, titik serah terima di kampus, deposit, dan rating membuat transaksi lebih aman.

## Nilai yang ditawarkan

1. **Akses tanpa membeli.** Barang yang jarang dipakai menjadi bisa dipakai mahasiswa lain dengan biaya harian.
2. **Ketersediaan yang jelas.** Kalender per tanggal menggantikan tanya-jawab "masih ada tidak?" di grup chat.
3. **Transaksi yang tercatat.** Status sewa berjalan berurutan: diajukan, disetujui, diserahkan, dikembalikan, selesai.
4. **Kepercayaan yang bisa diperiksa.** Foto kondisi saat serah terima dan pengembalian, ditambah rating setelah transaksi selesai.

## Lingkup MVP

Masuk MVP:

- Listing barang: foto, kategori, harga harian, deskripsi, lokasi serah terima.
- Kalender ketersediaan per tanggal.
- Pengajuan sewa dan persetujuan pemilik.
- Foto kondisi saat barang diserahkan dan dikembalikan.
- Rating dan ulasan setelah transaksi selesai.
- Verifikasi mahasiswa lewat unggah KTM dan persetujuan admin sebagai kontrol alur.
- Deposit simulasi sebagai kontrol alur, tanpa payment gateway.
- Satu kampus, web responsif, bahasa Indonesia.

Di luar MVP:

- Payment gateway asli, chat real-time, aplikasi mobile native.
- Multi-kampus, white-label, asuransi otomatis, loyalty, analitik lanjutan.
- Rekomendasi berbasis machine learning.

## Tiga KPI

Angka di bawah adalah **target perencanaan**, bukan hasil survei atau UAT. Semuanya diukur pada lingkup pilot satu kampus.

| KPI | Target | Cara ukur |
|---|---|---|
| K1 Kelengkapan listing | ≥ 90% listing pilot punya foto, kategori, harga, dan tanggal ketersediaan | Jumlah listing yang memenuhi empat unsur dibagi seluruh listing pilot |
| K2 Kecepatan persetujuan | ≥ 80% pengajuan sewa diputuskan pemilik dalam 24 jam | Selisih waktu `BookingStatusHistory` dari `DIAJUKAN` ke `DISETUJUI` atau `DITOLAK` |
| K3 Bukti kondisi transaksi | ≥ 90% transaksi selesai punya foto kondisi OUT dan RETURN serta satu rating | Jumlah booking `SELESAI` dengan dua handover berfoto dan satu review, dibagi seluruh booking selesai |

Belum ada baseline. Ketiga angka baru bisa dinilai setelah ada data pilot, sehingga statusnya saat ini **target, bukan capaian**.

## Pemangku kepentingan

| Pemangku kepentingan | Kepentingan utama | Peran dalam MVP |
|---|---|---|
| Mahasiswa penyewa | Barang murah, tersedia, terpercaya | Pengguna utama |
| Mahasiswa pemilik | Barang menghasilkan uang dan aman | Pengguna utama |
| Admin platform | Transaksi aman, listing rapi, sengketa tertangani | Verifikasi, moderasi |
| Pihak kampus | Mahasiswa terverifikasi, aktivitas terkendali | Verifikasi KTM, izin titik serah terima |
| Mitra pembayaran | Transaksi dan deposit berjalan | Fase lanjutan, belum ada |
| Regulator | Perlindungan data dan konsumen | Kepatuhan, bukan aktor sistem |

## Asumsi yang dipertahankan

- Satu kampus, kapasitas awal 300 pengguna dan 100 listing.
- Zona waktu Asia/Jakarta.
- Deposit simulasi, tanpa uang sungguhan berpindah.
- Verifikasi KTM disimulasikan: unggah berkas, admin menyetujui.
- Produk belum dibangun. Belum ada kode produksi, belum ada mitra yang menandatangani.

## Yang belum diputuskan

1. Tiga KPI di atas belum disetujui tim. Jika berubah, Vision tetap draf.
2. Mitra UAT dan jadwal P15 belum ada.
3. Nama akun GitHub pemilik repo belum ditetapkan, karena fase GitHub ditunda.

## Kriteria Vision dianggap beku

- Hanan dan tiga anggota lain menyatakan setuju pada isi dokumen ini.
- Tiga KPI diterima apa adanya atau diganti dengan angka yang disepakati.
- Tidak ada butir "yang belum diputuskan" yang masih memengaruhi lingkup MVP.
