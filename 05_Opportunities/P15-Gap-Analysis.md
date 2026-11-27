**Status:** Ada. Analisis gap per domain, 27 November 2026.

# P15 — Gap Analysis per Domain

**Pemilik:** Hanan Rizqullah (CEO/PO)
**Dasar:** TXT hlm. 24 (PR sebelum P15) dan Phase E TOGAF.
**Sumber bukti:** `07_Evidence/P14-Gate-2.md`, `07_Evidence/P14-Test-Run.md`, `04_Technology/P15-TCO.md`, `04_Technology/P14-Security-Checklist.md`.

## 1. Metode

Gap disusun dengan membandingkan tiga hal: apa yang dijanjikan di rancangan, apa yang benar-benar berjalan, dan apa yang dituntut gate berikutnya. Setiap gap harus punya bukti path. Gap yang tidak punya bukti tidak ditulis.

## 2. Ringkasan

| # | Domain | Gap | Dampak | Tindakan | Pemilik | Target |
|---|---|---|---|---|---|---|
| G-01 | Bisnis | Alur verifikasi KTM belum dibangun | Pengguna belum benar-benar terverifikasi | Bangun unggah KTM + antrean admin | Fharel dan Fazha | P15 |
| G-02 | Bisnis | Alur sengketa belum dibangun | Kerusakan tidak punya jalur penyelesaian | Bangun buka sengketa + keputusan admin | Fazha | P15 |
| G-03 | Bisnis | Deposit hanya simulasi dan belum dipotong | Tidak ada konsekuensi kerusakan | Tetapkan aturan potong, catat sebagai kebijakan | Hanan | P15 |
| G-04 | Bisnis | Mitra UAT belum ada, baru pengguna proksi | Validasi pengguna lemah | Jalankan UAT dengan mitra atau tiga proksi | Hanan dan Fharel | P15 |
| G-05 | Bisnis | KPI belum punya baseline | Klaim manfaat belum terbukti | Ukur K1–K3 saat UAT | Hanan | P15 |
| G-06 | Data | Prosedur transisi status belum dipanggil aplikasi | Dua jalur aturan bisa berbeda | Satukan ke satu jalur atau hapus salah satu | Fazha | P16 |
| G-07 | Data | Belum ada rencana migrasi data dari spreadsheet mitra | Data lama tidak bisa masuk | Tulis rencana impor dan anonimisasi | Fazha | P15 |
| G-08 | Data | Backup masih di laptop yang sama | Kehilangan data bila disk rusak | Pindahkan ke bucket terpisah, jadwalkan | Mahesa | P15 |
| G-09 | Data | Retensi dan masking KTM belum ditetapkan | Risiko privasi | Tetapkan masa simpan dan masking NIM | Hanan | P16 |
| G-10 | Aplikasi | Layar admin (verifikasi, moderasi, sengketa) belum ada | Operasional bergantung database manual | Bangun tiga layar admin minimal | Fazha | P15 |
| G-11 | Aplikasi | Worker antrean email belum jalan | Notifikasi hanya tercatat | Jalankan worker atau hapus klaim email | Mahesa | P15 |
| G-12 | Aplikasi | Halaman profil berisi semua ulasan belum ada | Reputasi sulit diperiksa | Tambah daftar ulasan pengguna | Fharel | P16 |
| G-13 | Aplikasi | Cek UI baru sampai S-03 | Selisih tampilan belum terdokumentasi | Bandingkan S-01 sampai S-05 | Fharel | P15 |
| G-14 | Teknologi | Staging berjalan di laptop | Tidak tahan laptop mati | Pindahkan ke VPS sebelum demo P16 | Mahesa | P16 |
| G-15 | Teknologi | Rate limit belum aktif | Rentan penyalahgunaan | Aktifkan di Cloudflare atau Nginx | Mahesa | P15 |
| G-16 | Teknologi | HSTS belum aktif | Downgrade HTTPS | Aktifkan di Cloudflare | Mahesa | P15 |
| G-17 | Teknologi | MFA admin belum diwajibkan | Akun admin rentan | Konfigurasi realm Keycloak | Mahesa | P15 |
| G-18 | Teknologi | Uji beban belum ada | Kapasitas 300 pengguna hanya asumsi | Uji dengan alat beban sederhana | Mahesa | P16 |
| G-19 | Teknologi | Keycloak memakai H2 tanpa backup | Realm hilang bila folder dihapus | Ekspor realm terjadwal | Mahesa | P15 |
| G-20 | Bisnis | Roadmap dan migration plan belum selaras Gate 3 | Gate 3 butir roadmap belum siap | Susun ulang roadmap per gate | Hanan | P15 |

## 3. Rincian per domain

### 3.1 Bisnis

Lima Must sudah berjalan, tetapi dua kontrol alur belum: verifikasi KTM dan sengketa. Keduanya bukan Must, namun tanpa verifikasi KTM, klaim "mahasiswa terverifikasi" belum benar. Deposit juga masih simulasi tanpa aturan pemotongan, sehingga cerita perlindungan pemilik belum utuh.

UAT baru memakai pengguna proksi internal. Mitra belum mengonfirmasi, sehingga bukti lapangan masih lemah dan KPI belum punya baseline.

### 3.2 Data

Skema 14 entitas sudah diuji di MySQL 8.0.43 dan restore terbukti. Yang belum: prosedur transisi status belum dipanggil aplikasi, belum ada rencana impor data mitra, backup masih satu mesin, dan kebijakan retensi KTM belum ada.

### 3.3 Aplikasi

Kelima Must lulus uji, tetapi sisi operasional belum: layar admin untuk verifikasi, moderasi, dan sengketa belum dibangun. Worker email belum berjalan sehingga notifikasi hanya tersimpan. Cek UI baru sampai halaman auth dan katalog.

### 3.4 Teknologi

Staging membuktikan aplikasi bisa diakses lewat HTTPS, tetapi berjalan di laptop. Rate limit, HSTS, dan MFA admin belum aktif; uji beban belum dilakukan; Keycloak menyimpan realm di H2 tanpa backup.

## 4. Prioritas

| Prioritas | Gap | Alasan |
|---|---|---|
| **Tinggi, usaha rendah** | G-15 rate limit, G-16 HSTS, G-17 MFA, G-19 ekspor realm | Konfigurasi, bukan pengembangan |
| **Tinggi, usaha sedang** | G-01 verifikasi KTM, G-10 layar admin, G-13 cek UI, G-04 UAT | Menopang kredibilitas dan Gate 3 |
| **Sedang** | G-02 sengketa, G-07 migrasi data, G-20 roadmap | Dibutuhkan, tetapi bisa menyusul setelah UAT |
| **Rendah untuk MVP** | G-06 penyatuan prosedur, G-12 profil ulasan, G-18 uji beban | Penting jangka panjang, tidak menahan gate |

## 5. Rencana penutupan

| Gate | Gap yang harus ditutup |
|---|---|
| Gate 3 (P15) | G-01, G-04, G-05, G-08, G-13, G-15, G-16, G-17, G-20 |
| P16 | G-02, G-06, G-09, G-10, G-11, G-12, G-14, G-18, G-19 |

## 6. Yang bukan gap

Payment gateway asli, chat real-time, aplikasi mobile, multi-kampus, rekomendasi machine learning, asuransi, loyalty, white-label, dan analitik lanjutan memang di luar MVP. Tidak dihitung sebagai kekurangan.

## 7. Catatan

Daftar ini akan berubah setelah UAT. Temuan pengguna nyata lebih penting daripada daftar ini, dan harus masuk ke sini sebelum ditutup.
