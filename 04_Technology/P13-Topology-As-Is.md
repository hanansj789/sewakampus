**Status:** Draf — kerangka pengamatan. Isi lapangan **belum diverifikasi** karena mitra belum dikonfirmasi.

# P13-11 — Topologi As-Is Lokasi Mitra

**Tanggal:** 24 November 2026
**Pemilik:** Mahesa (Network/DevOps)
**Menjawab:** G-05 — "topologi as-is lokasi mitra belum ada".

## 1. Keadaan sebenarnya

Sampai 24 November 2026 belum ada mitra yang dikonfirmasi (G-07, PR14-01). Karena itu dokumen ini **tidak** memuat nama lokasi, nama jaringan, alamat IP, atau angka bandwidth. Mengisinya sekarang berarti mengarang.

Yang bisa dikerjakan tanpa mitra: menetapkan **apa yang harus diamati** dan **format pencatatannya**, supaya begitu mitra ada, pengambilan data selesai dalam satu kunjungan.

## 2. Daftar periksa kunjungan

| # | Yang diamati | Cara mengambil | Satuan | Terisi? |
|---|---|---|---|---|
| 1 | Penyedia internet kampus/mitra | Lihat kontrak atau tanya admin | nama | **belum diverifikasi** |
| 2 | Jenis sambungan | Fiber, DSL, seluler, campuran | — | **belum diverifikasi** |
| 3 | Bandwidth unduh/unggah | Uji kecepatan di 3 titik, jam sibuk dan sepi | Mbps | **belum diverifikasi** |
| 4 | Latensi ke server target | `ping` dan `traceroute` dari lokasi | ms, jumlah hop | **belum diverifikasi** |
| 5 | Perangkat yang dipakai pengguna | Hitung laptop dan ponsel yang benar-benar dipakai | jumlah | **belum diverifikasi** |
| 6 | Jaringan nirkabel | SSID, jumlah titik akses, luas jangkauan | jumlah titik | **belum diverifikasi** |
| 7 | Titik serah terima fisik | Foto lokasi, jam operasional, siapa yang menjaga | foto + catatan | **belum diverifikasi** |
| 8 | Daya dan ruang | Ketersediaan stopkontak, apakah ada ruang terkunci | — | **belum diverifikasi** |
| 9 | Kebijakan jaringan | Apakah port masuk dibatasi, apakah ada firewall kampus | catatan | **belum diverifikasi** |
| 10 | Kontak teknis | Nama dan saluran hubungi admin jaringan | catatan | **belum diverifikasi** |

## 3. Format yang dipakai setelah data masuk

Setelah kunjungan, dokumen ini diubah menjadi tiga bagian:

1. **Topologi as-is** — gambar sederhana: internet → perangkat kampus → pengguna, dengan angka bandwidth dan latensi yang benar-benar diukur.
2. **Kesenjangan** — apa yang tidak memadai untuk lima Must, misalnya latensi unggah foto di jam sibuk.
3. **Topologi to-be** — satu VPS dengan Cloudflare di depan, sesuai `04_Technology/P13-Hosting-Options.md`.

## 4. Alasan dokumen ini tetap berguna walau kosong

- Butir P13-11 menuntut "topologi as-is & to-be". Bagian to-be sudah ada (laporan §3.5, `P13-Hosting-Options.md`); bagian as-is belum bisa diisi tanpa lokasi.
- Dosen dapat melihat bahwa yang kurang adalah **data lapangan**, bukan pemahaman. Daftar periksa ini buktinya.
- Saat mitra dikonfirmasi, pekerjaan tinggal eksekusi, bukan mulai dari nol.

## 5. Batas

Dokumen ini **tidak boleh** dipakai sebagai klaim bahwa topologi as-is sudah ada. Status di matriks tetap **Sebagian** sampai ada hasil kunjungan atau pengukuran jarak jauh atas izin mitra.
