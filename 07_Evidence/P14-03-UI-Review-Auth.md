**Status:** Ada. Review UI halaman auth; 3 temuan, 4 pemeriksaan lolos. Bukan UAT.

# P14-03 — Review UI Halaman Auth

**Tanggal:** 24 November 2026
**Pemilik:** Fharel Sapvela Dwipa (Analyst & UI/UX)
**Alat:** Playwright, Chromium; viewport 1440×900, 390×844, 320×700.
**Ruang lingkup:** `/login`, halaman login Keycloak bertema `sewakampus`, dashboard mahasiswa dan admin.

## 1. Ringkasan

| # | Pemeriksaan | Hasil |
|---|---|---|
| 1 | Konsistensi merek halaman masuk | Lolos |
| 2 | Kontras teks utama, sekunder, aksen, dan galat | Lolos |
| 3 | Tidak ada overflow horizontal di 320 px | Lolos |
| 4 | Fokus keyboard terlihat | Lolos |
| 5 | Lebar form Keycloak di 320 px | **Temuan F-01** |
| 6 | Tombol CTA halaman masuk di 320 px | **Temuan F-02** |
| 7 | Pemilih bahasa | **Temuan F-03** |
| 8 | Dashboard per role | Catatan F-04 |

## 2. Temuan

### F-01 — Form Keycloak terlalu sempit di 320 px (medium)

Pada 320×700, kartu Keycloak selebar 288 px, tetapi kolom input hanya sekitar **174 px**. Label “Nama pengguna atau email” pecah menjadi dua baris, dan input terasa sempit.

Bukti: `07_Evidence/screenshots/p14-ui-review-keycloak-320.png`.

Dugaan penyebab: grid/padding PatternFly pada `.pf-v5-c-login__main-body` ditambah pemilih bahasa yang memenuhi lebar. Perbaikan di tema, bukan di Laravel:

```css
@media (max-width: 40rem) {
  .pf-v5-c-login__main-body,
  .pf-v5-c-login__main-header {
    width: 100%;
  }
}
```

Perlu diuji ulang setelah diubah; jangan dianggap selesai sebelum screenshot baru.

### F-02 — CTA halaman masuk membungkus di 320 px (low)

Di 1440 px, tombol “Masuk dengan akun kampus” setinggi 52 px. Di 320 px, tombol menjadi **74 px** karena teks membungkus dua baris.

Bukti: `07_Evidence/screenshots/p14-login-entry-320.png`.

Pilihan: pendekkan label di layar kecil, kecilkan padding horizontal, atau ubah ukuran font. Jangan menghilangkan teks yang menjelaskan konteks.

### F-03 — Pemilih bahasa masih tampil (low)

Halaman Keycloak menampilkan combobox bahasa di kanan judul. `ui_locales=id` membuat default Indonesia, tetapi pengguna bisa berpindah ke Inggris. Label aksesibilitas combobox masih `languages` (Inggris), bukan “Bahasa”.

Pilihan: sembunyikan jika hanya ada dua bahasa, atau beri label Indonesia dan pastikan seluruh halaman tetap konsisten.

### F-04 — Dashboard masih scaffold (catatan)

Dashboard mahasiswa/admin lolos secara layout di 390 px: tidak ada overflow, judul dan role terbaca. Tetapi belum ada navigasi, daftar tugas, atau keadaan kosong yang membedakan role selain judul. Ini wajar untuk scaffold; kebutuhan dashboard akhir masuk P14 setelah Gate 1.

Bukti: `07_Evidence/screenshots/p14-student-dashboard-390.png`.

## 3. Kontras yang diukur

| Pasangan | Rasio | Ambang | Hasil |
|---|---|---|---|
| `#6E6A63` teks sekunder di `#FFFFFF` | 5,38:1 | 4,5:1 | Lolos |
| `#6E6A63` di `#F5F2EA` | 4,81:1 | 4,5:1 | Lolos |
| `#7E5F33` aksen di `#FFFFFF` | 5,88:1 | 4,5:1 | Lolos |
| `#9F2D20` galat di `#FFFFFF` | 7,32:1 | 4,5:1 | Lolos |
| `#FFFFFF` tombol di `#141414` | 18,42:1 | 4,5:1 | Lolos |

## 4. Rekomendasi

1. Perbaiki F-01 di tema Keycloak, lalu ambil screenshot 320 px baru.
2. Ringkas CTA atau padding di 320 px untuk F-02.
3. Lokalkan atau sembunyikan pemilih bahasa untuk F-03.
4. Setelah Gate 1, tambahkan navigasi dan keadaan kosong di dashboard; jangan menambah fitur Must sekarang.
5. Simpan screenshot sebagai baseline P14; review berikutnya membandingkan dengan gambar ini.

## 5. Batas

- Ini review visual dan layout, bukan UAT dan bukan uji aksesibilitas penuh dengan pembaca layar.
- Belum menguji 200% zoom, mode gelap, atau keyboard trap.
- Temuan F-01 dan F-02 belum diperbaiki; dokumen ini hanya mencatat.
