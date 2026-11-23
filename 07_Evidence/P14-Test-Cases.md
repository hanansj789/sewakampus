**Status:** Draf. Lima belas test case black-box diturunkan dari user story. Belum ada satu pun yang dijalankan.

# P14 — Test Case Black-Box SewaKampus

**Tanggal:** 23 November 2026  
**Sumber:** `01_Business/P13-User-Stories.md` dan `03_Application/ux/DESIGN.md`  
**Status uji:** Belum dijalankan. Tidak ada hasil yang diklaim.

Setiap test case menautkan satu user story dan satu layar. Hasil yang diharapkan mengikuti acceptance criteria pada user story. S-08 dan S-09 adalah kontrol alur tanpa story sendiri, sehingga ditautkan ke story yang didukungnya: S-08 ke US-01, S-09 ke US-06.

| ID | Story | Layar | Prasyarat | Langkah | Data uji | Hasil yang diharapkan |
|---|---|---|---|---|---|---|
| TC-01 | US-01 | S-01 | Akun terverifikasi | Buka form listing, kosongkan judul, pilih Simpan | Judul kosong | Sistem menolak dan menandai judul dengan pesan galat |
| TC-02 | US-01 | S-02 | Akun terverifikasi | Simpan listing tanpa foto, buka daftar listing saya | Tanpa foto | Listing tampil dengan status Draf dan tidak muncul di katalog |
| TC-03 | US-02 | S-01 | Listing draf | Unggah berkas bukan gambar | `nota.pdf` | Sistem menolak dengan pesan yang jelas |
| TC-04 | US-03 | S-03 | Listing aktif | Buka kalender dan amati tanggal yang sudah dibooking | Tanggal terisi | Tanggal terisi ditandai dan tidak dapat dipilih |
| TC-05 | US-03 | S-03 | Listing aktif | Pilih rentang yang bertabrakan dengan booking aktif | Rentang bentrok | Sistem menolak sebelum pengajuan dan meminta rentang lain |
| TC-06 | US-04 | S-04 | Rentang kosong | Ajukan sewa untuk tiga hari | Harga Rp35.000, deposit Rp50.000 | Booking tersimpan Menunggu keputusan dengan snapshot harga dan total Rp155.000 |
| TC-07 | US-04 | S-04 | Barang milik sendiri | Coba mengajukan sewa pada barang sendiri | Barang sendiri | Sistem menolak karena tidak dapat menyewa barang sendiri |
| TC-08 | US-05 | S-05 | Ada pengajuan | Pemilik memilih Setujui | Pengajuan valid | Status berubah menjadi Disetujui dan tanggal terkunci |
| TC-09 | US-05 | S-05 | Ada pengajuan | Pemilik memilih Tolak tanpa alasan | Alasan kosong | Sistem mewajibkan alasan sebelum penolakan tersimpan |
| TC-10 | US-06 | S-06 | Booking disetujui | Kirim catatan OUT tanpa foto | Tanpa foto | Sistem menolak dengan kode 422 dan meminta foto wajib |
| TC-11 | US-07 | S-06 | Booking diserahkan | Kirim catatan RETURN melewati tanggal akhir | Foto valid, tanggal lewat | Sistem mencatat keterlambatan pada catatan handover |
| TC-12 | US-08 | S-07 | Booking belum selesai | Coba memberi rating | Booking belum selesai | Sistem menolak dengan kode 409 dan menjelaskan syarat |
| TC-13 | US-01 | S-08 | Ada pengajuan KTM | Admin menolak karena NIM tidak cocok | NIM tidak cocok | Pengajuan ditolak dengan alasan wajib dan status tercatat |
| TC-14 | US-01 | S-08 | Ada pengajuan KTM | Admin membuka berkas KTM | KTM valid | KTM hanya terlihat admin berwenang dan NIM tampil dimasking |
| TC-15 | US-06 | S-09 | Ada sengketa | Admin memutuskan deposit | Bukti OUT dan RETURN | Keputusan tersimpan dan status sengketa berubah |

## Catatan

- Sembilan layar terwakili. US-01 sampai US-08 masing-masing terwakili minimal satu test case.
- Hasil uji hanya diisi setelah aplikasi berjalan. File ini tidak mencatat status lulus atau gagal sebelum pengujian nyata.
