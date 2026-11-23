# Kebutuhan Non-Fungsional (NFR) — SewaKampus

**Status:** Final (internal). Target perencanaan, belum ada pengukuran.
**Tanggal:** 23 November 2026
**Dasar:** TXT hlm. 15 (kebutuhan non-fungsional) dan asumsi satu VPS pada laporan Phase D.

Setiap angka di bawah adalah **target**, bukan hasil uji. Kolom "Bukti" masih kosong sampai ada pengukuran pada P14–P15.

## 1. Kinerja

| ID | Kebutuhan | Target | Bukti |
|---|---|---|---|
| NFR-P01 | Waktu muat halaman katalog pada 3G cepat | ≤ 3 detik untuk 90% permintaan | belum diukur |
| NFR-P02 | Waktu respons API baca | ≤ 400 ms p95 | belum diukur |
| NFR-P03 | Waktu respons API tulis | ≤ 800 ms p95 | belum diukur |
| NFR-P04 | Unggah foto 5 MB | ≤ 5 detik pada 10 Mbps | belum diukur |
| NFR-P05 | Pencarian katalog | ≤ 1 detik untuk 100 listing | belum diukur |

## 2. Kapasitas

| ID | Kebutuhan | Target |
|---|---|---|
| NFR-C01 | Pengguna terdaftar pada MVP | 300 |
| NFR-C02 | Listing aktif | 100 |
| NFR-C03 | Booking per bulan | 150 |
| NFR-C04 | Penyimpanan foto | 5 GB, satu bucket privat |
| NFR-C05 | Pengguna bersamaan | 30 |

Angka ini berasal dari asumsi laporan Phase D, bukan hasil survei. Jika pilot lebih besar, target ditinjau ulang.

## 3. Ketersediaan dan pemulihan

| ID | Kebutuhan | Target |
|---|---|---|
| NFR-A01 | Ketersediaan layanan | 99% per bulan, di luar pemeliharaan terjadwal |
| NFR-A02 | RPO (kehilangan data maksimum) | 24 jam, dari backup harian |
| NFR-A03 | RTO (waktu pemulihan) | 4 jam |
| NFR-A04 | Uji restore | satu kali sebelum P15, hasil dicatat |

Satu VPS adalah single point of failure. Target 99% hanya berlaku selama VPS dan penyedia layanan berjalan normal.

## 4. Keamanan

| ID | Kebutuhan | Target |
|---|---|---|
| NFR-S01 | Autentikasi | OIDC Authorization Code + PKCE melalui Keycloak; Laravel sebagai BFF |
| NFR-S02 | MFA admin | wajib untuk peran `ADMIN` |
| NFR-S03 | Otorisasi | setiap endpoint memeriksa peran dan kepemilikan objek |
| NFR-S04 | Transport | HTTPS saja, HSTS aktif |
| NFR-S05 | Berkas KTM | disimpan privat, hanya admin yang boleh membuka |
| NFR-S06 | Rahasia | tidak ada token atau kunci di repo atau di browser |
| NFR-S07 | Rate limit | baca 60/menit, tulis 30/menit, unggah 10/menit, auth 5/menit per IP |
| NFR-S08 | Audit | aksi admin dan perubahan status booking tercatat di `AuditLog` |

## 5. Kebergunaan dan aksesibilitas

| ID | Kebutuhan | Target |
|---|---|---|
| NFR-U01 | Kontras teks | minimal 4.5:1 |
| NFR-U02 | Target sentuh | minimal 44 × 44 px |
| NFR-U03 | Navigasi keyboard | semua aksi utama bisa dicapai tanpa mouse |
| NFR-U04 | Ukuran layar | 390 px sampai 1440 px tanpa scroll horizontal |
| NFR-U05 | Bahasa | Indonesia, istilah teknis dijelaskan di layar |

## 6. Kompatibilitas

| ID | Kebutuhan | Target |
|---|---|---|
| NFR-K01 | Peramban | dua versi terakhir Chrome, Firefox, Safari, Edge |
| NFR-K02 | Zona waktu | Asia/Jakarta pada semua tampilan tanggal |
| NFR-K03 | Format uang | rupiah, dua desimal, pemisah ribuan Indonesia |

## 7. Pemeliharaan

| ID | Kebutuhan | Target |
|---|---|---|
| NFR-M01 | Cakupan tes aturan bisnis | status booking, perhitungan biaya, hak akses |
| NFR-M02 | Log terstruktur | setiap permintaan punya ID yang bisa dilacak |
| NFR-M03 | Migrasi database | dapat dijalankan ulang dari database kosong |
| NFR-M04 | Dokumentasi API | OpenAPI 3.1 menjadi kontrak, bukan dokumentasi pasif |

## 8. Yang belum ditetapkan

- SLA penyedia VPS.
- Kebijakan retensi berkas KTM dan penghapusan data pribadi.
- Batas biaya operasional per bulan.
