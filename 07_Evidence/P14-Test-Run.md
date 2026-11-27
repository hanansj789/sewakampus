**Status:** Ada. Hasil uji black-box 15 kasus, 27 November 2026.

# P14 — Hasil Uji Black-Box (15 Kasus)

**Penyusun:** Fharel Sapvela Dwipa (System Analyst & UI/UX)
**Format:** mengikuti template Test Case Design dari mata kuliah Pengujian Perangkat Lunak (dua sheet: Index dan Test Case).
**Berkas kerja:** `07_Evidence/P14-Test-Run.xlsx`
**Lingkungan:** staging `https://cakes-clicks-berlin-alan.trycloudflare.com`, Laravel 11, MySQL 8.0.43, Keycloak 26.4.0.

## Ringkasan

| Hal | Nilai |
|---|---|
| Jumlah kasus | 15 |
| Dijalankan | 12 |
| Positive | 7 |
| Negative | 5 |
| Hasil | **12 Pass, 0 Fail, 3 Blocked** |
| EC coverage (fitur terbangun) | 100% |
| Boundary coverage | 100% |
| Redundancy | 0% |
| Requirement traceability | 5 dari 7 requirement terbangun |

Tiga kasus **Blocked** bukan gagal: alur verifikasi KTM (TC-13, TC-14) dan sengketa (TC-15) belum dibangun. Keduanya kontrol alur, bukan lima Must, dan sudah tercatat sebagai pekerjaan PR sebelum P15.

## Rincian

| TC | Requirement | Skenario | Hasil |
|---|---|---|---|
| TC-SK-01 | FR-SK-01 | Simpan listing tanpa judul | Pass |
| TC-SK-02 | FR-SK-01 | Simpan listing tanpa foto | Pass |
| TC-SK-03 | FR-SK-01 | Unggah berkas bukan gambar | Pass |
| TC-SK-04 | FR-SK-02 | Kalender menandai tanggal terpakai | Pass |
| TC-SK-05 | FR-SK-02 | Rentang bertabrakan ditolak | Pass |
| TC-SK-06 | FR-SK-03 | Ajukan sewa tiga hari | Pass |
| TC-SK-07 | FR-SK-03 | Sewa barang sendiri | Pass |
| TC-SK-08 | FR-SK-03 | Pemilik menyetujui pengajuan | Pass |
| TC-SK-09 | FR-SK-03 | Tolak tanpa alasan | Pass |
| TC-SK-10 | FR-SK-04 | Serah terima tanpa foto | Pass |
| TC-SK-11 | FR-SK-04 | Pengembalian terlambat dua hari | Pass |
| TC-SK-12 | FR-SK-05 | Rating sebelum transaksi selesai | Pass |
| TC-SK-13 | FR-SK-06 | Admin menolak KTM | Blocked |
| TC-SK-14 | FR-SK-06 | Admin membuka KTM dengan masking | Blocked |
| TC-SK-15 | FR-SK-07 | Admin memutuskan sengketa | Blocked |

## Metode

- **Equivalence Partitioning:** memisahkan input sah dan tidak sah pada judul, berkas, tanggal, dan rating.
- **Boundary Value Analysis:** batas tanggal (hari terakhir booking, keterlambatan), rating 1 dan 5, panjang judul 0 dan 120.
- **State Transition:** `PENDING` → `APPROVED`/`REJECTED`, `APPROVED` → `HANDED_OVER` → `RETURNED` → `COMPLETED`.

## Bukti per kasus

Kolom Evidence pada XLSX menunjuk salah satu dari:

- berkas tes otomatis: `ItemListingTest`, `ItemAvailabilityTest`, `BookingTest`, `HandoverTest`, `ReviewTest`;
- tangkapan layar: `P14-kalender-desember-2026.png`, `P14-pengajuan-pemilik-2026-11-27.png`;
- catatan pemeriksaan awal: `P14-M1M2-Precheck.md`.

Total tes otomatis pendukung: **76 lulus, 235 assertion**.

## Temuan selama pengujian

| Temuan | Dampak | Status |
|---|---|---|
| Pesan validasi berbahasa Inggris | Tidak sesuai aturan bahasa | Diperbaiki, diuji ulang |
| Foto seed menunjuk berkas yang tidak ada | Katalog menampilkan gambar rusak | Diperbaiki dengan pemeriksaan berkas |
| Redirect tamu jatuh ke `http` di belakang Cloudflare | Pengunjung dilempar ke versi tidak aman | Diperbaiki lewat `trustProxies` |

## Yang belum diuji

- Alur verifikasi KTM dan sengketa (blocked).
- UAT dengan mitra atau pengguna proksi dan skor SUS; dijadwalkan P15.
- Uji beban dan uji dua pengajuan benar-benar bersamaan.
