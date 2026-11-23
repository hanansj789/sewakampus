**Status:** Draf untuk persetujuan pemilik. Arah mewah-minimalis, desktop saja. Menggantikan arah Growlio sebelumnya.

# Sistem Desain Prototipe SewaKampus

**Tanggal:** 23 November 2026  
**Cakupan:** desktop 1440 × 900, satu page Desktop berisi enam layar alur dan satu page Components  
**Mode permukaan:** Operate, diformat seperti etalase mewah  
**Arah:** mewah minimalis, gading dan perunggu

## 1. Tujuan

Prototipe desktop yang benar-benar menunjukkan alur lima Must dari katalog sampai rating, bukan tumpukan frame lepas. Setiap layar tersambung lewat panah dan nomor langkah pada kanvas, dan setiap tombol utama dapat diklik di preview FigCraft.

## 2. Referensi nyata (dibuka dan diukur langsung)

| Sumber | Yang diambil | Nilai terukur |
|---|---|---|
| Inspirato (inspirato.com) | Arah mewah-minimalis: serif display, putih–hitam, whitespace, CTA pill | Serif *The Seasons* 80 px bobot 300; body *Aeonik Pro*; nav 11 px tracking 2 px huruf besar; CTA pill 13 px |
| Turo (turo.com) | Pola rental: kalender, persetujuan host, foto kondisi, rating | h1 51 px bobot 900; kontrol datar; alur persetujuan dan trip photo |
| Hygglo (hygglo.com) | Pola P2P rental | Kartu putih, radius 24 px, bayangan halus; Lato |

Situs ini hanya menjadi acuan pola, warna, dan layout. Tidak ada aset, teks, atau kode yang disalin.

## 3. Palet

| Token | Nilai | Peran |
|---|---|---|
| `color.bg.canvas` | `#F5F2EA` | Latar gading |
| `color.bg.surface` | `#FFFFFF` | Kartu dan panel |
| `color.accent.soft` | `#EDE6D8` | Permukaan lembut |
| `color.ink` | `#141414` | Teks utama |
| `color.muted` | `#6E6A63` | Teks sekunder |
| `color.accent` | `#7E5F33` | Perunggu, harga dan aksen kecil |
| `color.border` | `#E4DFD4` | Garis tipis |

Kontras terukur: tinta 16,47:1 di kanvas; muted 4,81:1; perunggu 5,26:1 di kanvas, 5,88:1 di putih, 4,73:1 di permukaan lembut; putih 18,42:1 di tinta. Semua teks memenuhi 4,5:1.

## 4. Tipografi

- Display: **Playfair Display**, 26–56 px, Regular/SemiBold, tracking -1% sampai -2%.
- Body dan UI: **Arial**, 13–16 px, line-height 1.5.
- Label dan meta: 11 px huruf besar, tracking +16%, warna muted atau perunggu.

## 5. Layout

- Kanvas 1440 × 900 per layar, margin 72 px, kolom konten 1296 px.
- Header seragam: wordmark di kiri, nav huruf kecil huruf besar, satu CTA pill di kanan.
- Kartu gambar radius 10–16 px, tanpa bayangan pada kartu diam.
- Satu CTA pill per layar: isi tinta `#141414`, teks putih; sekunder outline.
- Sanity: bukan tumpukan frame, tetapi enam layar berurutan dengan nomor langkah dan panah penghubung pada kanvas.

## 6. Alur lima Must

| Urutan | Layar | Must | Yang dituntaskan |
|---|---|---|---|
| 1 | 01 Katalog | M1 | Listing tampil dengan foto, harga, kondisi |
| 2 | 02 Detail & Kalender | M1, M2 | Detail barang + kalender ketersediaan |
| 3 | 03 Pengajuan sewa | M3 | Rentang, biaya, privasi, ajukan |
| 4 | 04 Persetujuan pemilik | M3 | Setujui/Tolak dengan alasan |
| 5 | 05 Serah terima & foto kondisi | M4 | Foto OUT dan RETURN wajib |
| 6 | 06 Rating | M5 | Rating dan komentar |

Interaksi klik menghubungkan 01 → 02 → 03 → 04 → 05 → 06.

## 7. Komponen dan state

Page Components memuat palet, spesimen tipografi, tombol primer/sekunder, chip, field, sel kalender (dipilih/terisi/kosong), dan rating. State layar: harga, kondisi, ketersediaan, privasi (NIM dimasking, KTM admin, lokasi rinci setelah setuju), galat, dan empty ditangani di tingkat layar.

## 8. Aksesibilitas

Kontras teks ≥ 4,5:1 (terukur). Target sentuh tombol 52 px. Fokus memakai cincin perunggu. Status tidak hanya lewat warna: sel terisi memakai arsir, tanggal dipilih diberi label, penolakan wajib alasan. NIM dimasking, KTM hanya admin, foto kondisi hanya pihak transaksi dan admin sengketa.

## 9. Copy

Bahasa Indonesia lugas: penyewa, pemilik, admin; "Ajukan sewa", "Setujui", "Tolak", "Kirim catatan kondisi", "Kirim rating". Tanpa emoji, tanpa slogan.

## 10. Gambar dan kredit

Tiga foto nyata berlisensi diimpor langsung ke kanvas:

- "Optima Projector" oleh Swethasakthivel, CC0, Wikimedia Commons.
- "Nikon DSLR camera D850" oleh Wolfgang Moroder, CC BY-SA 3.0, Wikimedia Commons.
- "JBL Flip 3 bluetooth speaker (DSCF2653)" oleh Trougnouf, CC BY 4.0, Wikimedia Commons.

Kredit tercatat di `03_Application/ux/assets/credits.json` dan di footer tiap layar.

## 11. Batas lingkup

Desktop saja. Mobile, dark mode, dan multi-bahasa ditunda. Tidak ada hasil UAT atau skor SUS yang dikarang.
