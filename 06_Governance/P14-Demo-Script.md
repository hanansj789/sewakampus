**Status:** Ada. Naskah demo Gate 2, 27 November 2026.

# P14 — Naskah Demo Gate 2

**Pembawa:** Hanan (CEO/PO), dibantu Fazha untuk bagian teknis.
**Durasi:** 5 menit demo + tanya jawab.
**Aturan kelas:** presenter ditunjuk dosen di tempat, jadi seluruh anggota harus bisa menjelaskan.

## 1. Persiapan 30 menit sebelum sesi

- [ ] Nyalakan MySQL, Keycloak, Laravel, dan dua tunnel sesuai `07_Evidence/P14-Staging-Deploy.md`.
- [ ] Perbarui `.env` bila nama tunnel berubah.
- [ ] Perbarui redirect URI client Keycloak bila nama tunnel berubah.
- [ ] Buka `/login` di peramban dan pastikan HTTP 200.
- [ ] Login sebagai `hanan`, lalu keluar, untuk memastikan Keycloak hidup.
- [ ] Siapkan tab cadangan: server lokal `http://127.0.0.1:8000`.
- [ ] Siapkan folder tangkapan layar bila internet gagal.

## 2. Alamat dan akun

| Hal | Nilai |
|---|---|
| Aplikasi | `https://cakes-clicks-berlin-alan.trycloudflare.com` |
| Keycloak | `https://because-corpus-davis-pack.trycloudflare.com` |
| Akun penyewa | `hanan` / `RahasiaKampus123!` |
| Akun pemilik | `mahesa` / `RahasiaKampus123!` |
| Akun admin | `admin` / `RahasiaKampus123!` |

Nama tunnel berubah setiap restart. Periksa sebelum tampil.

## 3. Alur lima menit

| Waktu | Yang dilakukan | Yang dikatakan |
|---|---|---|
| 0:00 | Buka URL aplikasi | "Ini staging SewaKampus, berjalan di laptop dengan dua tunnel Cloudflare." |
| 0:20 | Masuk lewat Keycloak sebagai `hanan` | "Login memakai OIDC PKCE; aplikasi tidak menyimpan kata sandi." |
| 0:50 | Buka katalog, tunjukkan 12 barang | "Katalog membaca dari MySQL, bukan data contoh di kode." |
| 1:20 | Tambah barang: isi form, unggah foto, simpan | "Listing dengan foto langsung aktif; tanpa foto menjadi draf." |
| 2:10 | Tunjukkan barang baru di katalog dan halaman kelola | "Data tersimpan; kalau server dinyalakan ulang, data tetap ada." |
| 2:40 | Buka detail barang, kalender Desember 2026 | "Tanggal 1–3 terisi karena booking aktif, 24–26 diblokir pemilik." |
| 3:20 | Tunjukkan endpoint ketersediaan lewat rentang bentrok | "Server menolak rentang yang bertabrakan, bukan hanya tampilan." |
| 3:50 | (Opsional) Ajukan sewa sebagai `hanan`, setujui sebagai `mahesa` | "Status berjalan berurutan dan tercatat di riwayat." |
| 4:30 | Tutup | "Dua Must P14 sudah jalan di database nyata; staging bisa dibuka dosen." |

## 4. Pertanyaan yang harus siap dijawab

| Pertanyaan | Jawaban singkat |
|---|---|
| Di mana datanya? | MySQL 8.0.43 port 3311, 14 tabel, seed 30 pengguna dan 30 barang. |
| Apa bedanya dengan prototipe? | Prototipe tidak menyimpan data; demo ini menulis dan membaca database nyata. |
| Kalau laptop mati? | Staging mati. Itu batas yang dicatat; target produksi memakai VPS. |
| Kenapa bukan Figma? | Gate 2 menilai aplikasi berjalan, bukan prototipe. |
| Bagaimana mencegah double booking? | Transaksi dengan kunci baris item, lalu cek ketersediaan sebelum simpan. |
| Apa yang belum? | Foto kondisi dan rating sudah ada di kode, tetapi demo Gate 2 fokus dua Must pertama. Backup dan TCO menyusul di PR sebelum P15. |

## 5. Rencana cadangan

1. **Tunnel mati.** Nyalakan ulang cloudflared, perbarui `.env` dan redirect URI, lalu lanjut.
2. **Internet mati.** Demo dari `http://127.0.0.1:8000` di laptop yang sama; dosen melihat langsung.
3. **Keycloak gagal.** Tunjukkan tangkapan layar login dan lanjut ke katalog dengan sesi yang sudah ada; jangan mengarang keberhasilan.
4. **Data rusak.** Jalankan ulang `001_init.sql` dan `seed.sql` di database kosong, lalu ulangi demo.

## 6. Yang tidak boleh dilakukan

- Menyebut gate sudah hijau sebelum dosen memutuskan.
- Menampilkan slide sebagai pengganti demo.
- Mengklaim fitur yang belum ada.
- Menyebut angka UAT atau pengguna yang belum diuji.
