**Status:** Selesai. Peserta proksi ditetapkan; tanggal kalender mengikuti jadwal P15.

# PR14-01 — Konfirmasi Mitra dan Jadwal UAT

**Tanggal:** 24 November 2026
**Pemilik:** Hanan (CEO/PO)
**Keputusan terkait:** SK-007 (pengguna proksi bila mitra eksternal belum ada), SK-021 (mitra UAT adalah mahasiswa)

## 1. Siapa mitranya

Mitra UAT SewaKampus adalah **mahasiswa**, bukan perusahaan atau unit kampus. Ini sesuai objek produk: marketplace penyewaan barang antar-mahasiswa di satu kampus.

Karena belum ada mitra eksternal, UAT memakai **tiga pengguna proksi dari anggota tim**. Mereka mahasiswa dan mengenal alur produk, sehingga bisa menguji login, role, dan alur lima Must. Ini bukan UAT mitra independen; keterbatasannya dicatat di §6.

## 2. Peserta proksi

| Peran | Nama | NIM | Tugas UAT |
|---|---|---|---|
| Penyewa | Fharel Sapvela Dwipa | F1E124048 | Menjalankan tugas penyewa: katalog, kalender, pengajuan, rating |
| Pemilik | Mahesa Kanaka Raya | F1E124062 | Menjalankan tugas pemilik: listing, persetujuan, serah terima |
| Admin | Muhammad Fazha Nararya Nugraha | F1E124041 | Menjalankan verifikasi KTM dan sengketa |
| Fasilitator | Hanan Rizqullah | F1E124017 | Memberi tugas, mencatat temuan, tidak membantu kecuali macet total |

Nama dan NIM diambil dari `06_Governance/P13-Team-Charter.md`. Tidak ada peserta di luar tim yang diklaim.

## 3. Pembagian peran

| Peran | Profil | Alasan penugasan |
|---|---|---|
| Penyewa | Mahasiswa yang pernah menyewa barang lewat grup chat | Fharel mewakili sisi penyewa |
| Pemilik | Mahasiswa yang pernah menyewakan barang | Mahesa mewakili sisi pemilik |
| Admin | Mahasiswa dengan role `ADMIN` yang memahami verifikasi KTM | Fazha mewakili admin platform |

Satu orang tidak menguji perannya sendiri. Fasilitator tidak menjadi peserta agar bisa mencatat.

## 4. Jadwal

| Tahap | Waktu | Isi |
|---|---|---|
| Penetapan peserta | 24 November 2026 | Pemilik menetapkan tiga peserta proksi dan fasilitator |
| Persiapan | Awal P15 | Prototipe atau staging siap, kuesioner SUS dicetak |
| UAT | P15 | Delapan tugas pada `07_Evidence/P15-UAT-Plan.md` §1 |
| Rekap | Setelah UAT | Temuan, waktu tugas, dan skor SUS dicatat di `07_Evidence/` |

Tanggal kalender dan jam pasti mengikuti jadwal pertemuan P15. Dokumen ini tidak mengarang tanggal yang belum ditetapkan kelas.

## 5. Bukti yang akan disimpan

- Daftar peserta dengan peran dan persetujuan lisan pada hari UAT.
- Catatan tugas berhasil/gagal.
- Kutipan komentar peserta.
- Kuesioner SUS terisi.
- Tangkapan layar bila peserta mengizinkan.

## 6. Batas

- Ini UAT proksi internal, bukan UAT mitra eksternal. Hasilnya tidak boleh disebut sebagai validasi pengguna independen.
- PR14-01 ditutup sebagai **Selesai** karena peserta dan jadwal P15 sudah ditetapkan.
- Skor SUS tidak boleh ditulis sebelum UAT dijalankan.
- Jika nanti ada mitra eksternal, peserta proksi boleh diganti dan dokumen ini diperbarui.
