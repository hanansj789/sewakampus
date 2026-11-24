**Status:** Selesai — dua opsi dan komponen biaya tersedia dari harga publik 23 November 2026. Enam butir belum diverifikasi dan tidak boleh dipakai untuk TCO sebelum ditutup.

# PR14-08 — Dua Opsi Hosting dan Komponen Biaya

**Tanggal pengambilan harga:** 23 November 2026
**Pemilik:** Mahesa (Network/DevOps)
**Kebutuhan acuan:** laporan §3.5.1 — satu VPS dengan Docker Compose, 4 vCPU, 8 GB RAM, 160 GB SSD, menjalankan Nginx, Laravel 11, queue worker, Keycloak 26, MySQL 8, Redis 7, dan MinIO.

## 1. Aturan yang dipakai

1. Semua angka di bawah disalin dari halaman harga publik penyedia pada tanggal pengambilan. URL sumber ditulis di setiap baris.
2. Angka yang tidak bisa dipastikan **tidak** diisi. Baris seperti itu ditandai **belum diverifikasi**.
3. Tidak ada konversi EUR ke IDR di dokumen ini, karena kurs pada tanggal pembelian belum ditetapkan. Perbandingan dilakukan per mata uang.
4. Harga belum termasuk PPN/VAT kecuali dinyatakan lain oleh penyedia.

## 2. Opsi A — Hetzner Cloud (Jerman/Finlandia/Singapura)

| Komponen | Spesifikasi | Harga publik | Sumber (diambil 23 Nov 2026) |
|---|---|---|---|
| VPS CPX32, lokasi Helsinki (HEL1) | 4 vCPU AMD, 8 GB RAM, 160 GB NVMe, IPv4 termasuk, 20 TB traffic | **€30,49/bulan**, di luar VAT | https://www.hetzner.com/cloud/regular-performance/ |
| VPS CPX32, lokasi Nuremberg (NBG1) | sama | **€35,99/bulan**, di luar VAT | idem |
| VPS CPX32, lokasi Singapura (SIN1) | sama, traffic termasuk 2 TB | **€49,49/bulan**, di luar VAT | idem |
| Add-on backup otomatis | 7 slot backup per server | Halaman mencantumkan "mulai €1,0980" untuk instance terkecil; angka untuk CPX32 **belum diverifikasi** | idem |
| Object storage | MinIO berjalan di dalam VPS | €0 tambahan (memakai disk VPS) | rancangan laporan §3.5.1 |
| Cloudflare (DNS, WAF, TLS, cache) | paket Free | **$0/bulan** | https://www.cloudflare.com/plans/network-cdn |
| Cloudflare Pro (opsional) | WAF lanjutan, image optimization | **$20/bulan** (tagihan tahunan) atau $25/bulan (bulanan) | idem |
| Domain | Cloudflare Registrar, harga at-cost | "mulai $7,85" per pendaftaran; harga domain `.id` **belum diverifikasi** | idem |

**Perkiraan biaya berjalan:** €30,49–49,49 per bulan, yaitu €365,88–593,88 per tahun di luar VAT dan di luar backup. Angka tahunan adalah hasil kali dua belas bulan, bukan angka yang tercantum di halaman.

**Catatan:** lokasi terdekat ke Indonesia adalah Singapura (SIN1), dengan harga tertinggi dan kuota traffic 2 TB. Pembayaran memakai kartu kredit/kartu debit internasional dan ditagih dalam EUR.

## 3. Opsi B — Biznet Gio NEO Lite (Indonesia)

| Komponen | Spesifikasi | Harga publik | Sumber (diambil 23 Nov 2026) |
|---|---|---|---|
| VPS NEO Lite MM 8.4 | 4 vCPU, 8 GB RAM, 60 GB SSD, data center Indonesia, bandwidth hingga 10 Gbps | **Rp269.000/bulan** (harga promo; harga normal Rp399.000) | https://www.biznetgio.com/product/neo-lite |
| Tambahan SSD sampai 160 GB | kapasitas awal 60 GB, dapat ditambah tanpa pindah paket | Harga per GB **belum diverifikasi**; halaman produk tidak mencantumkan tarif tambahan SSD | idem |
| Object storage | MinIO berjalan di dalam VPS | Rp0 tambahan (memakai disk VPS) | rancangan laporan §3.5.1 |
| Cloudflare (DNS, WAF, TLS, cache) | paket Free | **$0/bulan** | https://www.cloudflare.com/plans/network-cdn |
| Domain `.id` | registrar mana pun | **belum diverifikasi** | — |
| PPN atas layanan | tarif yang berlaku | **belum diverifikasi**; halaman tidak menyatakan harga termasuk atau tidak termasuk PPN | — |

**Perkiraan biaya berjalan:** Rp269.000 per bulan, yaitu Rp3.228.000 per tahun pada harga promo, belum termasuk tambahan SSD dan PPN.

**Catatan:** VPS MM 8.4 hanya menyediakan 60 GB SSD, sedangkan kebutuhan acuan 160 GB. Selisih 100 GB harus dibeli sebagai tambahan atau ditutup dengan object storage terpisah, dan biayanya belum bisa dipastikan hari ini.

## 3b. Opsi C — Oracle Cloud Always Free (gratis)

| Komponen | Spesifikasi | Harga publik | Sumber (diambil 24 Nov 2026) |
|---|---|---|---|
| VM Ampere A1 Flex | 2 OCPU ARM, 12 GB RAM, hingga 200 GB block storage | **$0/bulan** pada Always Free | https://docs.oracle.com/iaas/Content/FreeTier/freetier_topic-Always_Free_Resources.htm |
| Region | Singapura, jika kapasitas tersedia | termasuk | idem |
| Cloudflare (DNS, WAF, TLS, cache) | paket Free | **$0/bulan** | https://www.cloudflare.com/plans/network-cdn |
| Domain | registrar mana pun | tetap berbayar; bukan bagian free tier | — |

**Catatan penting:**

- Oracle memangkas Always Free Ampere A1 dari 4 OCPU/24 GB menjadi **2 OCPU/12 GB** pada Juni 2026. Angka 2/12 adalah batas resmi saat ini.
- Akun tetap memerlukan kartu kredit/debit untuk verifikasi, meskipun pemakaian dalam batas Always Free tidak ditagih.
- Kapasitas ARM di region tertentu sering penuh; pembuatan instance bisa gagal dan perlu dicoba lagi.
- Kebijakan reclaim untuk instance idle perlu dicek sebelum dipakai jangka panjang; jangan anggap ini SLA produksi.
- 2 core ARM cukup untuk demo/UAT satu kampus, tetapi Keycloak, MySQL, Redis, MinIO, dan Laravel sekaligus akan terasa berat. Uji beban sebelum memakai untuk staging.
- Semua image Docker (Laravel/PHP, MySQL, Redis, MinIO, Keycloak) harus tersedia untuk `linux/arm64`.

## 3c. Opsi D — Laptop + Cloudflare Quick Tunnel (gratis, demo saja)

Laptop yang sudah menjalankan stack lokal diekspos lewat Cloudflare Quick Tunnel. Biaya **Rp0**, tetapi laptop harus menyala, URL berubah, dan tidak ada jaminan ketersediaan. Hanya untuk demo atau UAT singkat, bukan staging.

## 4. Perbandingan

| Kriteria | Opsi A — Hetzner CPX32 | Opsi B — Biznet Gio MM 8.4 |
|---|---|---|
| vCPU / RAM | 4 / 8 GB | 4 / 8 GB |
| Disk | 160 GB NVMe (sesuai kebutuhan) | 60 GB SSD, perlu tambahan |
| Lokasi terdekat | Singapura (SIN1) | Indonesia |
| Harga bulanan | €30,49–49,49 | Rp269.000 |
| Mata uang dan pembayaran | EUR, kartu internasional | IDR, kanal pembayaran lokal |
| Traffic termasuk | 20 TB (EU), 2 TB (SIN1) | hingga 10 Gbps tanpa biaya tambahan menurut halaman produk |
| Obral biaya yang belum jelas | backup CPX32, harga domain `.id` | tambahan SSD 100 GB, PPN, harga domain `.id` |
| Kepatuhan data | GDPR, sertifikasi ISO 27001 pada data center EU | penyedia Indonesia, sertifikasi ISO 27001/27017/27018/27701 tercantum di halaman produk |
| Risiko utama | latensi ke pengguna kampus dari EU; pembayaran valas | disk kurang 100 GB; harga promo dapat berubah |

## 5. Rekomendasi

Jika target utama adalah biaya paling murah, urutannya:

1. **Opsi C — Oracle Cloud Always Free ($0)** untuk staging/UAT, selama kartu verifikasi diterima dan kapasitas ARM tersedia. Ini satu-satunya opsi yang benar-benar gratis untuk stack penuh.
2. **Opsi D — laptop + Cloudflare Quick Tunnel (Rp0)** untuk demo singkat; bukan staging.
3. **Opsi B — Biznet Gio Rp269.000/bulan** bila ingin latensi Indonesia dan pembayaran lokal, dengan tambahan SSD.
4. **Opsi A — Hetzner CPX32** bila disk 160 GB dan RAM 8 GB harus tersedia tanpa tambahan; harga €30,49–49,49/bulan.

Opsi A dan B sama-sama bisa menjalankan Docker Compose dengan Keycloak, MySQL, Redis, dan MinIO pada 4 vCPU/8 GB. Perbedaan yang menentukan bukan harga, melainkan disk 160 GB di Opsi A dan latensi/pembayaran lokal di Opsi B.

Usulan Mahesa: **coba Opsi C lebih dulu** karena gratis; jika provisioning ARM gagal atau performa tidak memadai, jatuh ke Opsi B untuk latensi lokal atau Opsi A untuk disk dan RAM. Keputusan akhir tetap di Hanan dan belum dicatat di `DECISIONS.md`.

## 6. Yang belum diverifikasi

1. Harga add-on backup untuk CPX32.
2. Harga tambahan SSD pada Biznet Gio dari 60 GB ke 160 GB.
3. Harga domain `.id` dan biaya perpanjangan tahunan.
4. Tarif PPN yang berlaku dan apakah harga Biznet Gio sudah termasuk PPN.
5. Harga paket Sentry dan Uptime Kuma yang dipakai pada operasi (keduanya bisa memakai paket gratis, tetapi batas paket gratis tidak diperiksa pada sesi ini).
6. Kurs EUR/IDR pada tanggal pembelian.

Nomor 1 sampai 6 harus ditutup dengan tangkapan layar atau penawaran resmi sebelum angka ini dipakai pada TCO 12 bulan (P15-04).
