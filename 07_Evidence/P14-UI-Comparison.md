**Status:** Ada. Perbandingan UI implementasi dengan prototipe, 28 November 2026.

# P14 — Cek UI Implementasi vs Prototipe

**Pemilik:** Fharel Sapvela Dwipa (System Analyst & UI/UX)
**Prototipe:** `03_Application/ux/exports/L-01` sampai `L-05`
**Implementasi:** staging, tangkapan layar di `07_Evidence/screenshots/P14-ui-*.png`
**Sifat:** pemeriksaan kesesuaian tampilan. Bukan penilaian estetika dan bukan gate.

## 1. Ringkasan

| Layar | Kesesuaian fungsi | Selisih tampilan | Keputusan |
|---|---|---|---|
| S-01 Buat listing | Setara | Tata letak satu kolom, tanpa pratinjau foto | Perbaiki pratinjau sebelum P16 |
| S-02 Katalog | Setara | Tanpa hero, pencarian, filter, dan label kondisi | Sebagian diperbaiki |
| S-03 Detail dan kalender | Setara, sebagian lebih baik | Tanpa kartu pemilik dan galeri thumbnail | Perbaiki kartu pemilik |
| S-04 Pengajuan | Setara | Menyatu di halaman detail, bukan layar sendiri | Terima |
| S-05 Persetujuan | Setara | Tanpa sidebar profil dan masking NIM | Perbaiki masking |

## 2. S-01 Buat listing

| Elemen | Prototipe | Implementasi | Selisih |
|---|---|---|---|
| Tata letak | Dua kolom: form kiri, foto kanan | Satu kolom | Visual |
| Judul, kategori, kondisi | Ada | Ada | — |
| Harga harian, deposit | Ada, dengan keterangan "dikembalikan setelah barang kembali utuh" | Ada, tanpa keterangan | Kecil |
| Deskripsi | Ada | Ada | — |
| Lokasi serah terima | Ada | Ada | — |
| Foto | Pratinjau besar di kanan, keterangan minimal satu foto | Input berkas di bawah form, tanpa pratinjau | Sedang |
| Tombol simpan | Pil hitam lebar | Pil, lebar mengikuti konten | Kecil |

Kesimpulan: fungsi lengkap. Yang hilang adalah pratinjau foto dan keterangan deposit. Pratinjau membantu pengguna memastikan foto benar sebelum menyimpan.

## 3. S-02 Katalog

| Elemen | Prototipe | Implementasi | Selisih |
|---|---|---|---|
| Hero dan judul besar | Ada | Tidak ada, langsung daftar | Besar |
| Pencarian kategori dan tanggal | Ada | Tidak ada | Besar (fungsional) |
| Filter "Milik saya" | Pil | Tab di atas daftar | Kecil |
| Kartu barang | Foto, judul, harga, kondisi | Foto, kategori, judul, harga, deposit, lokasi, pemilik | Sedang |
| Kondisi barang di kartu | Ada ("Baik") | Tidak ada | Kecil |
| Jumlah kolom | Tiga | Mengikuti lebar layar sampai empat | Kecil |
| Navigasi | Katalog, Cara kerja, Masuk, Mulai sewa | Katalog, Barang saya, Pengajuan, Tambah barang, Keluar | Sedang (sesuai fitur nyata) |

Kesimpulan: katalog memenuhi fungsi Must. Pencarian dan filter tanggal tidak dibangun karena form pengajuan memakai kalender di halaman detail; ini keputusan sadar, bukan kelalaian, dan dicatat di G-12.

## 4. S-03 Detail dan kalender

| Elemen | Prototipe | Implementasi | Selisih |
|---|---|---|---|
| Tata letak | Dua kolom: galeri kiri, detail kanan | Bertumpuk: detail, lalu kalender | Visual |
| Galeri | Foto utama dan thumbnail | Daftar foto berjajar | Kecil |
| Kartu pemilik | Nama, NIM dimasking, rating | Nama saja | Sedang |
| Harga dan deposit | Harga besar, deposit di form | Harga dan deposit di panel | Kecil |
| Kalender | Satu bulan, legenda | Satu bulan, navigasi bulan, legenda, penanda hari ini | **Lebih baik** |
| Ajakan | "Pilih tanggal & ajukan sewa" menuju layar pengajuan | Form pengajuan langsung di bawah kalender | Struktural |

Kesimpulan: fungsi lebih lengkap dari prototipe pada kalender. Kartu pemilik dengan rating belum ada karena data rating pengguna belum ditampilkan.

## 5. S-04 Pengajuan

| Elemen | Prototipe | Implementasi | Selisih |
|---|---|---|---|
| Layar terpisah | Ya | Tidak, menyatu di halaman detail | Struktural |
| Tanggal mulai dan selesai | Ada | Ada | — |
| Ringkasan biaya sebelum kirim | Ada | Belum, biaya dihitung setelah tersimpan | Sedang |
| Catatan untuk pemilik | Ada | Ada | — |
| Validasi bentrok | Pesan di layar | Pesan di layar, ditolak server | Setara |

Kesimpulan: penyatuan ke halaman detail diterima karena mengurangi satu langkah. Ringkasan biaya sebelum kirim sebaiknya ditambahkan agar pengguna tidak kaget setelah menyimpan.

## 6. S-05 Persetujuan

| Elemen | Prototipe | Implementasi | Selisih |
|---|---|---|---|
| Judul dan ringkasan | "Pengajuan masuk" dengan hitungan menunggu | "Pengajuan sewa" dengan dua bagian | Kecil |
| Kartu pengajuan | Nama penyewa, NIM masking, barang, tanggal, total, profil | Barang, status, nama, tanggal, total, deposit, catatan | Sedang |
| Tombol setujui dan tolak | Ada | Ada | — |
| Alasan penolakan | Diwajibkan, teks di samping tombol | Kolom isian di samping tombol | Setara |
| Sidebar profil penyewa | Ada, dengan catatan nama tampil setelah disetujui | Tidak ada | Sedang |
| Masking NIM | Ada | Tidak ada | Sedang (privasi) |

Kesimpulan: fungsi setujui/tolak lengkap. Masking NIM dan profil penyewa belum ada; keduanya menyangkut privasi dan kepercayaan, jadi masuk perbaikan sebelum P16.

## 7. Daftar perbaikan

| Prioritas | Perbaikan | Layar | Usaha |
|---|---|---|---|
| ~~Tinggi~~ **Selesai** | Masking NIM pada kartu pengajuan | S-05 | kecil |
| ~~Tinggi~~ **Selesai** | Pratinjau foto sebelum simpan | S-01 | sedang |
| Sedang | Ringkasan biaya sebelum kirim pengajuan | S-04 | kecil |
| Sedang | Kartu pemilik dengan rating di detail | S-03 | sedang |
| Rendah | Label kondisi pada kartu katalog | S-02 | kecil |
| Rendah | Hero dan pencarian di katalog | S-02 | besar, tunda |

## 8. Yang tidak diperbaiki sekarang

Hero katalog, pencarian tanggal, sidebar profil penyewa, dan galeri thumbnail ditunda. Tidak satu pun menghambat lima Must, dan menambahkannya sekarang berisiko mengganggu demo Gate 2.


## 9. Tindak lanjut

Dua butir prioritas tinggi sudah dikerjakan pada 28 November 2026. Bukti: `07_Evidence/P14-UI-Fixes.md`. Empat butir lain tetap ditunda dengan alasan yang sama.
