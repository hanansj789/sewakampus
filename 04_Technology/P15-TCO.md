**Status:** Ada. Estimasi 12 bulan dengan asumsi yang dinyatakan, 27 November 2026.

# P15 — TCO Infrastruktur 12 Bulan

**Pemilik:** Mahesa Kanaka Raya (Network/DevOps)
**Dasar harga:** `04_Technology/P13-Hosting-Options.md`, harga publik diambil 23–24 November 2026.
**Sifat:** estimasi perencanaan. Angka yang belum punya sumber ditandai **asumsi**, bukan harga penyedia.

## 1. Asumsi

| Asumsi | Nilai | Status |
|---|---|---|
| Kurs EUR → IDR | Rp17.500 | asumsi perencanaan, bukan kurs transaksi |
| Kurs USD → IDR | Rp16.000 | asumsi perencanaan |
| Kapasitas | 300 pengguna, 100 listing | dari laporan Phase D |
| Periode | 12 bulan | TXT hlm. 24 |
| Tenaga kerja | tidak dihitung | tim sendiri |
| Payment gateway | tidak ada | di luar MVP |

## 2. Skenario A — Biznet Gio, harga rupiah

| Komponen | Perhitungan | 12 bulan |
|---|---|---|
| VPS NEO Lite MM 8.4 (promo) | Rp269.000 × 12 | Rp3.228.000 |
| Tambahan SSD 100 GB | asumsi Rp100.000 × 12 | Rp1.200.000 |
| Domain `.id` | asumsi Rp250.000/tahun | Rp250.000 |
| Backup offsite | asumsi Rp50.000 × 12 | Rp600.000 |
| Cloudflare Free | $0 | Rp0 |
| Monitoring (Uptime Kuma, Sentry free) | $0 | Rp0 |
| Email transaksional (free tier) | $0 | Rp0 |
| SSL (Let's Encrypt) | $0 | Rp0 |
| **Subtotal** | | **Rp5.278.000** |
| Kontingensi 10% | | Rp527.800 |
| **Total 12 bulan** | | **Rp5.805.800** |

## 3. Skenario B — Hetzner Helsinki, mata uang euro

| Komponen | Perhitungan | 12 bulan |
|---|---|---|
| VPS CPX32 HEL1 | €30,49 × 12 | €365,88 |
| Backup add-on | asumsi €3,00 × 12 | €36,00 |
| Domain | asumsi $10 | $10,00 |
| Cloudflare Free | $0 | $0 |
| Monitoring, email, SSL | $0 | $0 |
| **Subtotal** | | **€401,88 + $10** |
| Setara rupiah (asumsi kurs) | €401,88 × 17.500 + $10 × 16.000 | **Rp7.192.900** |
| Kontingensi 10% | | Rp719.290 |
| **Total 12 bulan** | | **Rp7.912.190** |

## 4. Skenario C — Oracle Always Free

| Komponen | Perhitungan | 12 bulan |
|---|---|---|
| VM Ampere A1 (2 OCPU, 12 GB) | $0 | Rp0 |
| Domain | asumsi Rp250.000 | Rp250.000 |
| Backup offsite | asumsi Rp50.000 × 12 | Rp600.000 |
| **Subtotal** | | **Rp850.000** |
| Kontingensi 10% | | Rp85.000 |
| **Total 12 bulan** | | **Rp935.000** |

Risiko yang melekat: kapasitas ARM sering penuh, kebijakan reclaim instance idle, dan semua image harus tersedia untuk `arm64`. Murah, tetapi tidak boleh disebut produksi.

## 5. Perbandingan

| Kriteria | A — Biznet Gio | B — Hetzner | C — Oracle |
|---|---|---|---|
| Biaya 12 bulan | Rp5,81 juta | Rp7,91 juta | Rp0,94 juta |
| Mata uang | IDR | EUR/USD | USD |
| Latensi dari Jambi | rendah (Indonesia) | sedang (Singapura/Helsinki) | sedang (Singapura) |
| Pembayaran | lokal | kartu internasional | kartu untuk verifikasi |
| Risiko utama | promo berakhir, SSD terbatas | tagihan valuta asing | kapasitas dan reclaim |
| Layak untuk | staging dan pilot | pilot dengan kualitas jaringan Eropa | demo dan uji singkat |

## 6. Komponen yang belum diverifikasi

Enam butir ini masih terdaftar di `P13-Hosting-Options.md` dan belum boleh dipakai sebagai angka final di pitch:

1. Harga tambahan SSD Biznet Gio per GB.
2. Harga domain `.id`.
3. Tarif PPN layanan Biznet Gio.
4. Harga backup add-on Hetzner untuk CPX32.
5. Harga domain di Cloudflare Registrar untuk `.id`.
6. Biaya object storage atau backup offsite.

Angka yang dipakai di atas adalah asumsi perencanaan untuk menghitung skenario, bukan penawaran resmi.

## 7. Rekomendasi

**Skenario A** untuk pilot satu kampus: harga rupiah, latensi rendah, dan pembayaran lokal. Dengan catatan:

- Tambahan SSD dan backup offsite wajib dikonfirmasi sebelum pembelian.
- Cloudflare Free cukup untuk MVP; Pro ($20/bulan, sekitar Rp3,8 juta setahun) baru dipertimbangkan bila WAF lanjutan dibutuhkan.
- Skenario C hanya untuk demo; jangan dipakai menyimpan data mitra.

## 8. Yang tidak dihitung

- Waktu tim dan biaya tenaga kerja.
- Biaya hukum, perizinan, dan penyimpanan berkas KTM.
- Biaya akuisisi pengguna dan promosi.
- Denda atau kompensasi bila layanan mati.
