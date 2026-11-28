**Status:** Ada. Perbaikan dua temuan UI, 28 November 2026.

# P14 — Perbaikan Temuan UI

**Pemilik:** Muhammad Fazha Nararya Nugraha (Programmer)
**Branch:** `feature/programmer-ui-fixes`
**Dasar:** `07_Evidence/P14-UI-Comparison.md` butir prioritas tinggi.

## 1. Masking NIM

| Hal | Sebelum | Sesudah |
|---|---|---|
| Kartu pengajuan | Hanya nama penyewa atau pemilik | Nama dan NIM bertopeng, mis. `NIM ******4045` |
| NIM lengkap | Tidak ditampilkan karena tidak dimuat | Tetap tidak pernah dikirim ke tampilan |
| Sumber | — | `student_verifications.nim` status `APPROVED`, diambil lewat relasi `User::verification()` |

Aturan: hanya empat digit terakhir yang tampil. Nama lengkap tetap muncul, sesuai prototipe yang menyebut nama ditampilkan setelah pengajuan diputuskan; masking NIM berlaku sejak awal.

## 2. Pratinjau foto

| Hal | Sebelum | Sesudah |
|---|---|---|
| Form buat listing | Hanya input berkas | Pratinjau muncul setelah memilih gambar |
| Form tambah foto | Hanya input berkas | Pratinjau muncul setelah memilih gambar |
| Berkas bukan gambar | Tidak ada pratinjau | Pratinjau disembunyikan |
| Unggahan | Tetap baru terjadi saat form disimpan | Tidak berubah; pratinjau hanya di peramban |

Berkas: `public/js/items.js`, `public/css/items.css`, dua form.

## 3. Bukti uji otomatis

| Perintah | Hasil |
|---|---|
| `DB_PORT=3311 php artisan test --filter="BookingTest\|ItemListingTest"` | 27 lulus, 89 assertion |
| `DB_PORT=3311 php artisan test` | 78 lulus, 242 assertion |

Dua tes baru:

- Pemilik melihat `NIM ******` dan halaman tidak memuat NIM lengkap.
- Form buat listing memuat kait pratinjau foto.

## 4. Bukti di peramban staging

| Uji | Hasil |
|---|---|
| Buka `/bookings` | Kartu menampilkan `Penyewa: Rizky Pratama · NIM ******4045` |
| Pilih gambar di form buat | Pratinjau tampil, sumber `blob:`, lebar asli 640 px |

## 5. Yang belum

- Pratinjau belum diuji pada Safari dan Firefox.
- Masking NIM pada halaman detail pemilik belum ada; baru di kartu pengajuan.
- Nama penyewa belum disembunyikan sebelum keputusan; prototipe menyarankan nama tampil setelah disetujui. Ini butuh keputusan produk, bukan perbaikan teknis.
