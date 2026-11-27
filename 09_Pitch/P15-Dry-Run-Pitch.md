**Status:** Ada. Naskah dry-run, 27 November 2026. Belum dilatih dan belum dinilai.

# P15 — Dry-Run Pitch 7 Menit

**Pembawa utama:** Hanan. **Pendamping:** Fharel (proses dan UAT), Fazha (aplikasi dan demo), Mahesa (teknologi).
**Aturan kelas:** presenter bisa ditunjuk acak, jadi semua harus bisa menjelaskan alurnya.

## 1. Struktur 10 slide

| # | Slide | Pembawa | Waktu | Isi wajib |
|---|---|---|---|---|
| 1 | Masalah dan bukti | Hanan | 0:45 | Barang jarang dipakai, transaksi di WhatsApp, tidak ada catatan kondisi |
| 2 | Vision dan KPI | Hanan | 0:45 | Tiga KPI dan batas MVP |
| 3 | Arsitektur bisnis | Fharel | 0:45 | BPMN to-be: pengajuan sampai selesai |
| 4 | Arsitektur data | Fazha | 0:45 | 14 entitas, status booking, bukti 3NF |
| 5 | Arsitektur aplikasi | Fazha | 0:45 | Lima Must, kontrak API, peran |
| 6 | Teknologi dan keamanan | Mahesa | 0:45 | Staging tunnel, HTTPS, cookie, batas single node |
| 7 | Demo live | Fazha | 1:00 | Dua sampai tiga alur dari database nyata |
| 8 | UAT dan SUS | Fharel | 0:45 | Hasil nyata; **kosong sampai UAT dijalankan** |
| 9 | Roadmap dan biaya | Hanan | 0:30 | WP1–WP7, TCO tiga skenario |
| 10 | Governance dan penutup | Hanan | 0:15 | CR, ADR, apa yang belum |

Total 7:00. Latihan memakai pengatur waktu, bukan perkiraan.

## 2. Naskah per slide

### Slide 1 — Masalah (0:45)

"Mahasiswa butuh kamera, proyektor, tenda, atau alat lab untuk beberapa hari. Membelinya mahal. Di sisi lain, barang mahasiswa lain menganggur. Sekarang transaksinya di grup WhatsApp: tidak ada katalog, tidak ada harga jelas, dan tidak ada catatan kondisi. SewaKampus mengambil satu kampus sebagai pasar awal."

### Slide 2 — Vision dan KPI (0:45)

"Visi kami: membuat barang yang jarang dipakai lebih mudah diakses tanpa membeli. Tiga KPI: 90 persen listing lengkap, 80 persen pengajuan diputuskan dalam 24 jam, dan 90 persen transaksi punya foto kondisi serta rating. Angka ini target perencanaan, bukan hasil."

### Slide 3 — Bisnis (0:45)

"Alurnya: pengajuan, persetujuan, serah terima dengan foto, pengembalian dengan foto, lalu selesai. Status dijaga berurutan, tidak boleh melompat. Verifikasi KTM, deposit, dan sengketa adalah kontrol di dalam alur, bukan fitur Must keenam."

### Slide 4 — Data (0:45)

"Empat belas entitas. Yang paling menentukan: `Booking` dan `BookingStatusHistory` untuk status, `Handover` untuk OUT dan RETURN, `Review` untuk reputasi. Tiga penyimpangan 3NF dicatat: cache rating, snapshot harga, dan referensi notifikasi."

### Slide 5 — Aplikasi (0:45)

"Lima Must sudah berjalan: listing, kalender, persetujuan, foto kondisi, rating. Kontrak API 34 path, handover memakai multipart karena foto wajib. Hak akses diperiksa di server, bukan di tampilan."

### Slide 6 — Teknologi (0:45)

"Laravel 11, MySQL 8, Keycloak 26. Staging berjalan lewat dua tunnel Cloudflare dengan HTTPS, cookie secure dan httponly. Batasnya jujur: satu laptop, bukan VPS, dan belum ada uji beban."

### Slide 7 — Demo (1:00)

1. Buka katalog, tunjukkan barang.
2. Buat listing dengan foto, tunjukkan muncul di katalog.
3. Buka kalender Desember, tunjukkan tanggal terpakai.
4. Bila waktu cukup, ajukan sewa dan setujui dari akun pemilik.

Jangan menambah langkah di luar rencana. Bila satu langkah gagal, lanjut ke langkah berikutnya dan sebut apa adanya.

### Slide 8 — UAT (0:45)

**Diisi setelah sesi UAT.** Yang wajib ada: jumlah peserta, tingkat keberhasilan tugas, skor SUS, tiga temuan utama, dan tindak lanjut. Jangan menulis skor sebelum sesi terjadi.

### Slide 9 — Roadmap dan biaya (0:30)

"Tujuh work package sampai P16. Biaya 12 bulan: Rp5,8 juta dengan Biznet Gio, Rp7,9 juta dengan Hetzner, Rp0,9 juta dengan Oracle untuk demo. Rekomendasi: Biznet Gio, dengan backup offsite wajib."

### Slide 10 — Penutup (0:15)

"Yang sudah: lima Must, staging, backup terbukti. Yang belum: verifikasi KTM, sengketa, UAT dengan mitra. Semua perubahan tercatat di change request log."

## 3. Pertanyaan yang harus siap

| Pertanyaan | Jawaban inti |
|---|---|
| Kenapa bukan aplikasi mobile? | MVP web responsif; mobile di fase 2. |
| Bagaimana mencegah double booking? | Kunci baris item dalam transaksi, cek ketersediaan sebelum simpan. |
| Bagaimana kalau barang rusak? | Foto OUT dan RETURN, sengketa, deposit diputuskan admin. |
| Apa bukti pengguna nyata? | UAT dan SUS; bila mitra belum ada, peserta proksi disebut apa adanya. |
| Berapa biaya sebenarnya? | TCO dengan enam komponen belum diverifikasi; angka final menunggu penawaran. |
| Apa risiko terbesar? | Satu VPS, satu laptop untuk staging, dan ketergantungan pada satu orang untuk beberapa WP. |

## 4. Rencana cadangan

- **Tunnel mati:** nyalakan ulang, atau demo dari `127.0.0.1`.
- **Internet mati:** tangkapan layar berurutan dan video pendek.
- **Database rusak:** jalankan ulang DDL dan seed, ulangi demo.
- **Waktu habis:** lewati demo booking, langsung ke kalender dan penutup.

## 5. Peer review

Format kelas: satu kekuatan, satu risiko, satu masukan perbaikan. Lembar ada di `07_Evidence/P15-Peer-Review-Template.md`. Hasil peer review wajib ditindaklanjuti sebelum P16.
