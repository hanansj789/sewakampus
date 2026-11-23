**Status:** Final (internal), 24 November 2026. Topologi as-is bersifat kualitatif; angka bandwidth dan latensi tidak diukur.

# P13-11 — Topologi As-Is Lingkungan Mitra Mahasiswa

**Tanggal:** 24 November 2026
**Pemilik:** Mahesa (Network/DevOps)
**Menjawab:** G-05 — "topologi as-is lokasi mitra belum ada".

## 1. Siapa mitranya

Mitra SewaKampus adalah **mahasiswa di satu kampus**, bukan organisasi atau badan usaha. Karena itu tidak ada jaringan kantor, server mitra, atau kontrak internet atas nama mitra yang bisa diaudit. Yang ada adalah lingkungan pemakaian mahasiswa: perangkat pribadi, Wi-Fi kampus, dan data seluler.

Keputusan ini dicatat pada SK-021 (CR-004).

## 2. Topologi as-is

Alur yang benar-benar berjalan sekarang, tanpa sistem SewaKampus:

```text
Mahasiswa pemilik                     Mahasiswa penyewa
laptop / ponsel                       laptop / ponsel
      |                                     |
      +-------- Wi-Fi kampus / data seluler -+
                          |
                 Grup WhatsApp kelas
        (foto barang, tanya harga, tawar, chat)
                          |
              Kesepakatan manual di chat
                          |
          Transfer / e-wallet pribadi (di luar sistem)
                          |
              Serah terima tatap muka di kampus
                          |
        Tidak ada kalender, foto kondisi, atau rating
```

| Lapisan | Keadaan as-is | Bukti |
|---|---|---|
| Perangkat pengguna | Laptop dan ponsel pribadi mahasiswa; aplikasi utama browser dan WhatsApp | Lingkup produk satu kampus, web responsif (Vision) |
| Jaringan | Wi-Fi kampus dan data seluler; tidak dikelola tim | Tidak ada infrastruktur mitra yang bisa diukur |
| Katalog | Grup WhatsApp; tidak ada pencarian atau filter | Vision §Masalah |
| Ketersediaan | Ditanyakan manual di chat; tidak ada kalender | Vision §Masalah |
| Pembayaran | Transfer atau e-wallet pribadi; deposit tidak tercatat sistem | Deposit simulasi di MVP, payment gateway di luar MVP |
| Serah terima | Tatap muka di kampus; tidak ada foto kondisi baku | Vision §Masalah |
| Reputasi | Tidak ada rating atau riwayat transaksi | Vision §Masalah |
| Admin | Belum ada admin platform; verifikasi KTM belum berjalan | UC-06 masih rancangan |

## 3. Yang belum diukur dan mengapa

Angka berikut **tidak diisi** karena belum ada pengukuran, bukan karena terlewat:

| Data | Status | Cara mengisi |
|---|---|---|
| Kecepatan unduh/unggah Wi-Fi kampus | **Belum diukur** | Uji kecepatan di 3 titik pada jam sibuk dan sepi |
| Latensi ke VPS target | **Belum diukur** | `ping` dan `traceroute` dari jaringan kampus |
| Komposisi perangkat | **Belum diukur** | Hitung laptop vs Android vs iOS pada peserta UAT |
| Jam sibuk pemakaian | **Belum diukur** | Catat dari peserta UAT selama satu minggu |
| Titik serah terima | **Belum ditetapkan** | Pilih 1–2 lokasi kampus dan foto lokasinya |

Untuk mitra perorangan, angka ini dipakai sebagai **konteks UAT**, bukan sebagai audit jaringan mitra. Jika nanti ada mitra institusi (misalnya unit kampus), dokumen ini harus diperluas.

## 4. Kesenjangan terhadap lima Must

| Must | Kesenjangan as-is |
|---|---|
| M1 Listing | Tidak ada katalog terstruktur; foto dan harga tersebar di chat |
| M2 Kalender | Tidak ada kalender; bentrok tanggal baru ketahuan saat chat |
| M3 Persetujuan | Persetujuan lisan di chat, tidak tercatat |
| M4 Foto kondisi | Tidak ada foto kondisi wajib saat OUT dan RETURN |
| M5 Rating | Tidak ada reputasi yang bisa diperiksa |

## 5. Topologi to-be

To-be tetap mengikuti `04_Technology/P13-Hosting-Options.md` dan `DESAIN/Phase D - SewaKampus.drawio`: satu VPS Ubuntu dengan Docker Compose, Cloudflare di depan, Nginx sebagai gateway, Laravel, MySQL, Redis, MinIO, dan Keycloak. Perangkat mahasiswa tetap laptop/ponsel melalui browser.

## 6. Batas

Dokumen ini menyatakan topologi as-is **secara kualitatif**. Angka jaringan yang belum diukur tidak boleh dikarang. Status internal P13-11 adalah Selesai (internal) untuk kelengkapan dokumen; pengukuran lapangan menjadi bahan UAT P15, bukan syarat Gate 1.
