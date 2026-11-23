**Status:** Draf untuk persetujuan pemilik. Belum menjadi bukti prototipe dan belum membekukan keputusan sebelum Gate 1 dinilai.

# Sistem Desain Prototipe SewaKampus

**Tanggal:** 23 November 2026  
**Cakupan:** S-01 sampai S-09, masing-masing pada frame mobile 390 × 844 dan desktop 1440 × 900  
**Mode permukaan:** Operate. Pengguna membuka layar untuk menyelesaikan transaksi, bukan membaca halaman promosi.  
**Arah yang disetujui:** kartu inventaris kampus modern dengan ekspansi Growlio terkendali  
**Dial desain:** ENERGY 2, RHYTHM 2, MOTION 1

## 1. Tujuan dan ukuran keberhasilan prototipe

Prototipe dipakai untuk Design Review internal dan persiapan UAT. Pemilik produk dan anggota tim memeriksa alur terlebih dahulu. Jika mitra tetap belum tersedia, minimal tiga pengguna proksi menjalankan skenario UAT pada P15. Dokumen ini tidak mencatat hasil UAT atau skor SUS karena pengujian belum dilakukan.

Prototipe dianggap berhasil secara internal jika memenuhi syarat berikut.

1. Alur lima Must dapat dijalankan tanpa tombol mati atau jalan buntu.
2. Tindakan utama pada setiap layar dapat ditemukan tanpa petunjuk lisan.
3. Status pengajuan, biaya, foto kondisi, lokasi serah terima, dan akses data pribadi dapat dipahami dari tampilan.
4. Setiap layar menautkan satu use case dan satu Must. S-08 dan S-09 menjadi kontrol pendukung, bukan Must baru.
5. Seluruh teks normal mencapai kontras minimum 4,5:1. Kontrol sentuh berukuran minimal 44 × 44 px dan memiliki fokus yang terlihat.
6. Prototipe FigCraft dapat diklik pada alur mobile dan desktop. Ekspor PNG tiap layar dan PDF alur dapat dibuka.

## 2. Prinsip desain

| Prinsip | Penerapan | Alasan |
|---|---|---|
| Tindakan utama terlihat | Setiap layar mempunyai paling banyak satu tombol utama berisi warna hijau tua | Pengguna perlu menyelesaikan tugas dengan cepat melalui HP di kampus |
| Status dibaca tanpa menebak | Status memakai label, ikon, dan warna. Warna tidak pernah menjadi satu-satunya penanda | Pengajuan, ketersediaan, dan handover mempunyai akibat transaksi |
| Bukti diletakkan dekat keputusan | Foto kondisi, tanggal, biaya, dan alasan penolakan muncul di dekat aksi yang berkaitan | Penyewa dan pemilik perlu memeriksa bukti sebelum menyetujui |
| Privasi melalui pengungkapan bertahap | KTM, NIM, lokasi rinci, dan foto kondisi hanya terlihat oleh peran yang memerlukan | Produk menangani identitas mahasiswa dan bukti transaksi |
| Tetap berguna saat koneksi lemah | Layout tidak bergeser saat memuat. Unggahan menampilkan progres, kegagalan, dan tindakan coba lagi | Pengguna dapat mengakses produk melalui jaringan kampus yang tidak stabil |
| Ramah tanpa menjadi halaman promosi | Krem, hijau tua, serif pada judul, tombol utama pill, dan bingkai foto membulat membawa karakter Growlio. Form, kalender, daftar, dan tabel tetap rapat dan datar | Pemilik memilih mengambil lebih banyak karakter Growlio, tetapi layar transaksi tetap harus mudah dipindai |
| Bukti lebih penting daripada dekorasi | Tidak ada statistik, testimoni, identitas, atau foto orang yang dibuat seolah-olah nyata | Proyek belum mempunyai data pengguna dan hasil UAT nyata |

## 3. Pengguna dan konteks pemakaian

### 3.1 Persona kerja

| Persona | Kebutuhan | Keadaan saat memakai |
|---|---|---|
| Mahasiswa penyewa | Mengetahui barang, tanggal, biaya, kondisi, dan lokasi serah terima | Memakai HP di sela kegiatan kampus dan ingin menghindari tanggal bentrok |
| Mahasiswa pemilik | Membuat listing, memeriksa calon penyewa, memutuskan pengajuan, dan menyimpan bukti kondisi | Memakai HP untuk tindakan cepat dan desktop untuk meninjau beberapa pengajuan |
| Admin | Memeriksa KTM dan bukti sengketa dengan jejak keputusan yang jelas | Lebih sering memakai desktop, tetapi alur tetap tersedia pada lebar mobile |

### 3.2 Batasan konteks

- Perangkat utama prototipe adalah HP 390 × 844. Adaptasi desktop memakai 1440 × 900.
- Penggunaan dapat terjadi di luar ruangan. Tema terang dan kontras tinggi dipilih agar teks tetap terbaca.
- Koneksi dapat tidak stabil. Foto membutuhkan progres unggah, pembatalan, dan coba lagi.
- Pengguna dapat berganti peran antara penyewa dan pemilik. Label peran dan status transaksi harus eksplisit.
- Prototipe tidak mengandalkan gestur tersembunyi. Semua tindakan tersedia melalui kontrol yang terlihat.
- Konten panjang, ukuran teks 200%, dan pesan galat dua baris tidak boleh terpotong.

## 4. Peta alur

### 4.1 Alur utama lima Must

| Urutan | Layar | Tindakan dan hasil |
|---|---|---|
| 1 | S-08 | Admin menyetujui verifikasi mahasiswa. Akun aktif dapat membuat listing dan mengajukan sewa |
| 2 | S-01 | Pemilik mengisi listing dan mengunggah foto. Listing lengkap menjadi aktif |
| 3 | S-02 | Pemilik melihat dan mengelola listing miliknya |
| 4 | S-03 | Penyewa membuka detail, memeriksa kalender, lalu memilih rentang kosong |
| 5 | S-04 | Penyewa meninjau tanggal, biaya, deposit simulasi, dan lokasi umum, lalu memilih "Ajukan sewa" |
| 6 | S-05 | Pemilik memilih "Setujui" atau "Tolak". Penolakan mewajibkan alasan |
| 7 | S-06 | Kedua pihak mencatat OUT dengan foto, lokasi, catatan, dan konfirmasi |
| 8 | S-06 | Kedua pihak mengulangi proses untuk RETURN. Perbedaan kondisi dapat membuka S-09 |
| 9 | S-07 | Setelah transaksi selesai, kedua pihak dapat memberi rating 1 sampai 5 |

### 4.2 Titik gagal yang wajib terlihat

| Titik gagal | Respons antarmuka |
|---|---|
| Akun belum terverifikasi | Aksi diblokir dengan penjelasan dan tautan menuju status verifikasi |
| Listing belum memiliki foto | Listing disimpan sebagai draf dan tidak tampil di katalog |
| Tanggal bertabrakan | Tanggal bentrok diberi pola dan label. Pengajuan tidak dapat dikirim |
| Pengajuan ditolak | Alasan tampil. Tanggal kembali tersedia |
| Pengajuan belum diputuskan | Status "Menunggu keputusan" tampil tanpa janji pembatalan otomatis |
| Foto kondisi belum ada | Handover tidak dapat dikirim. Galat muncul di dekat kontrol unggah |
| Unggahan terputus | Progres berhenti dengan pilihan "Coba lagi" dan "Batalkan" |
| Kondisi tidak sesuai | Konfirmasi ditahan dan alur membuka S-09 |
| Rating sebelum transaksi selesai | Sistem menjelaskan bahwa rating tersedia setelah status selesai |

## 5. Inventaris layar dan ketelusuran

| Layar | Nama | Aktor utama | Use case | Must | Pertanyaan utama layar | Aksi utama |
|---|---|---|---|---|---|---|
| S-01 | Form listing | Pemilik | UC-01 | M1 | Apakah data barang sudah cukup untuk dipublikasikan? | Simpan listing |
| S-02 | Daftar listing saya | Pemilik | UC-01 | M1 | Listing mana yang aktif, draf, atau dijeda? | Buat listing |
| S-03 | Detail barang dan kalender | Penyewa | UC-02 | M2 | Apakah barang tersedia pada tanggal yang dibutuhkan? | Pilih tanggal |
| S-04 | Pengajuan sewa | Penyewa | UC-03 | M3 | Apakah tanggal dan biaya pengajuan sudah benar? | Ajukan sewa |
| S-05 | Persetujuan pemilik | Pemilik | UC-03 | M3 | Pengajuan mana yang perlu diputuskan? | Setujui atau Tolak |
| S-06 | Serah terima dan foto kondisi | Penyewa dan pemilik | UC-04 | M4 | Apakah kondisi OUT atau RETURN sudah dibuktikan dan dikonfirmasi? | Kirim catatan kondisi |
| S-07 | Rating setelah transaksi | Penyewa dan pemilik | UC-05 | M5 | Bagaimana pengalaman transaksi yang sudah selesai? | Kirim rating |
| S-08 | Antrean verifikasi admin | Admin | UC-06 | M1, sebagai kontrol prasyarat | Pengajuan KTM mana yang perlu diputuskan? | Setujui atau Tolak |
| S-09 | Sengketa admin | Admin | UC-07 | M4, sebagai cabang pengecualian | Bukti mana yang mendukung keputusan sengketa? | Simpan keputusan |

S-08 mendukung M1 karena UC-01 mensyaratkan akun terverifikasi. S-09 mendukung M4 karena UC-04 membuka sengketa ketika kondisi barang berbeda. Pemetaan ini tidak menambah Must keenam.

## 6. Organisasi kanvas FigCraft

Contoh `Growpath-High-Fidelity.figcraft` memisahkan halaman Desktop, Mobile, States and Prototype, serta Components. Contoh `Growpath-Wireframe-P13.figcraft` juga menambahkan halaman Flow. SewaKampus memakai struktur yang lebih terpisah agar koneksi prototipe mudah dikelola.

| Urutan page | Nama page | Isi |
|---|---|---|
| 00 | Foundations and Components | Token, text style, paint style, komponen utama, dan varian |
| 01 | Mobile Listing | S-01 dan S-02 pada 390 × 844 |
| 02 | Mobile Sewa | S-03, S-04, dan S-05 pada 390 × 844 |
| 03 | Mobile Handover and Rating | S-06 dan S-07 pada 390 × 844 |
| 04 | Mobile Admin | S-08 dan S-09 pada 390 × 844 |
| 05 | Desktop Listing | S-01 dan S-02 pada 1440 × 900 |
| 06 | Desktop Sewa | S-03, S-04, dan S-05 pada 1440 × 900 |
| 07 | Desktop Handover and Rating | S-06 dan S-07 pada 1440 × 900 |
| 08 | Desktop Admin | S-08 dan S-09 pada 1440 × 900 |
| 09 | States and Prototype | State penting, dialog, variasi OUT dan RETURN, peta alur, serta titik awal preview |

Setiap frame diberi nama `<ID> <Nama> / <Viewport> / <State>`. Contoh: `S-03 Detail dan kalender / Mobile / Default`. Frame utama mobile dan desktop menjadi bukti layar. Frame state menjadi bukti perilaku, bukan ID layar baru.

## 7. Warna

### 7.1 Strategi

Palet memakai satu netral hangat, satu aksen hijau tua, dan warna status yang hanya muncul saat diperlukan. Krem dan hijau berasal dari keputusan referensi Growlio. Permukaan transaksi tetap datar. Tidak ada gradasi, glow, kaca, atau sidebar gelap pada tema terang.

### 7.2 Token semantik

| Token | Nilai | Peran |
|---|---|---|
| `color.bg.canvas` | `#F7F4E8` | Latar utama krem hangat |
| `color.bg.surface` | `#FFFFFF` | Form, daftar, dialog, dan panel kerja |
| `color.bg.subtle` | `#EFEBDD` | Kelompok konten dan state pasif |
| `color.text.primary` | `#17211D` | Judul, body, dan data utama |
| `color.text.secondary` | `#4D5B55` | Bantuan dan metadata |
| `color.accent.solid` | `#0F5A46` | Satu aksi utama dan pilihan aktif |
| `color.accent.hover` | `#0B4637` | Hover aksi utama |
| `color.accent.soft` | `#DDE9E3` | Pilihan dan status brand yang tidak dominan |
| `color.focus` | `#006B54` | Fokus keyboard 3 px dengan offset putih 2 px |
| `color.border.default` | `#D8D5C9` | Batas panel dan kontrol |
| `color.border.strong` | `#A6A99F` | Kontrol interaktif dan tabel |
| `color.status.success.ink` | `#17633F` | Teks status berhasil |
| `color.status.success.bg` | `#E4F3EA` | Latar status berhasil |
| `color.status.warning.ink` | `#7A4B00` | Teks peringatan |
| `color.status.warning.bg` | `#FFF0C7` | Latar peringatan |
| `color.status.error.ink` | `#A32929` | Galat dan tindakan destruktif |
| `color.status.error.bg` | `#FDE8E8` | Latar galat |
| `color.status.info.ink` | `#1E4E8C` | Informasi netral |
| `color.status.info.bg` | `#E9F1FC` | Latar informasi netral |

### 7.3 Pasangan kontras yang sudah dihitung

| Teks | Latar | Rasio | Hasil |
|---|---|---:|---|
| `#17211D` | `#F7F4E8` | 14,99:1 | Lulus AA |
| `#4D5B55` | `#F7F4E8` | 6,48:1 | Lulus AA |
| `#17211D` | `#FFFFFF` | 16,51:1 | Lulus AA |
| `#4D5B55` | `#FFFFFF` | 7,14:1 | Lulus AA |
| `#FFFFFF` | `#0F5A46` | 8,17:1 | Lulus AA |
| `#FFFFFF` | `#0B4637` | 10,79:1 | Lulus AA |
| `#0F5A46` | `#DDE9E3` | 6,55:1 | Lulus AA |
| `#17633F` | `#E4F3EA` | 6,33:1 | Lulus AA |
| `#7A4B00` | `#FFF0C7` | 6,54:1 | Lulus AA |
| `#A32929` | `#FDE8E8` | 6,15:1 | Lulus AA |
| `#1E4E8C` | `#E9F1FC` | 7,31:1 | Lulus AA |

Rasio dihitung dari nilai token, belum dari hasil raster FigCraft. Pemeriksaan visual terhadap hasil ekspor tetap wajib.

### 7.4 Ketersediaan dan status

- Tanggal tersedia memakai permukaan putih dan teks utama.
- Tanggal terpilih memakai hijau tua, teks putih, serta label awal atau akhir rentang.
- Tanggal terisi memakai arsiran diagonal ringan dan label "Terisi".
- Tanggal diblokir memakai ikon gembok dan label "Diblokir".
- Status pengajuan selalu memuat teks seperti "Menunggu keputusan", "Disetujui", atau "Ditolak".
- Galat memakai ikon, judul singkat, dan tindakan berikutnya. Warna merah hanya menjadi penguat.

## 8. Tipografi

### 8.1 Keluarga huruf

- **Judul layar dan empty state:** Libre Baskerville. Serif ini membawa karakter editorial Growlio pada ukuran yang tetap sesuai layar aplikasi.
- **Antarmuka, body, label, angka, dan form:** Source Sans 3. Huruf ini dipilih karena jelas pada ukuran kecil dan mempunyai angka tabular.
- **Fallback:** Georgia untuk serif, kemudian `system-ui` dan Arial untuk sans.
- Maksimal dua keluarga huruf pada satu layar. Monospace hanya boleh dipakai untuk ID teknis jika ID memang ditampilkan.

Ketersediaan font di FigCraft belum diverifikasi. Jika FigCraft tidak menyediakan salah satu font, penggantian dicatat sebelum eksekusi dan tidak dilakukan diam-diam.

### 8.2 Skala teks

| Text style | Font | Ukuran dan tinggi baris | Bobot | Pemakaian |
|---|---|---|---|---|
| `Display/Screen` | Libre Baskerville | 28/36 | 700 | Judul layar utama, maksimal dua baris |
| `Display/Empty` | Libre Baskerville | 24/32 | 700 | Empty state besar |
| `Heading/L` | Source Sans 3 | 24/30 | 600 | Judul bagian desktop |
| `Heading/M` | Source Sans 3 | 20/26 | 600 | Judul panel dan dialog |
| `Heading/S` | Source Sans 3 | 16/22 | 600 | Judul kartu atau kelompok form |
| `Body/L` | Source Sans 3 | 16/24 | 400 | Body utama dan seluruh input mobile |
| `Body/M` | Source Sans 3 | 14/20 | 400 | Daftar, tabel, dan bantuan ringkas |
| `Label/M` | Source Sans 3 | 14/20 | 600 | Label form dan tombol |
| `Meta/S` | Source Sans 3 | 12/16 | 400 | Metadata yang tidak kritis |

Judul menggunakan letter spacing paling rendah `-0,01em`. Body dan label memakai `0`. Harga, tanggal, jumlah hari, dan total memakai angka tabular. Teks antarmuka rata kiri. Teks bantuan panjang dibatasi sekitar 60 sampai 75 karakter per baris pada desktop.

## 9. Spacing, bentuk, elevasi, dan ikon

### 9.1 Spacing

Sistem memakai dasar 4 px dengan langkah utama 8 px.

| Token | Nilai | Pemakaian |
|---|---:|---|
| `space.1` | 4 | Jarak ikon internal dan koreksi optik |
| `space.2` | 8 | Label ke field, ikon ke teks |
| `space.3` | 12 | Jarak rapat antarelemen |
| `space.4` | 16 | Padding kontrol dan margin mobile |
| `space.5` | 24 | Padding kartu dan jarak kelompok |
| `space.6` | 32 | Jarak bagian dalam layar |
| `space.8` | 48 | Pemisah bagian besar |
| `space.10` | 64 | Ritme desktop dan tinggi navigasi mobile |

Margin mobile 16 px. Canvas desktop memakai sidebar 240 px dan area kerja dengan padding 32 px. Kolom utama tidak melebihi 1200 px.

### 9.2 Radius

| Token | Nilai | Pemakaian |
|---|---:|---|
| `radius.control` | 8 | Input, pilihan, chip, dan kontrol biasa |
| `radius.card` | 8 | Panel transaksi dan daftar |
| `radius.media` | 16 | Foto barang dan empty state visual |
| `radius.dialog` | 16 | Dialog dan bottom sheet |
| `radius.primary` | 999 | Hanya tombol utama pill yang disetujui |

Pill tidak dipakai untuk semua tombol, input, kartu, atau badge. Tombol sekunder memakai radius 8 px.

### 9.3 Elevasi

- Kartu diam memakai perbedaan warna permukaan atau border 1 px, tanpa bayangan.
- Bottom sheet dan dialog memakai `0 12 32 rgba(23, 33, 29, 0.16)`.
- Menu dan popover memakai `0 8 20 rgba(23, 33, 29, 0.12)`.
- Elemen hover tidak melayang. Hover hanya mengubah border atau warna permukaan.

### 9.4 Ikon

- Satu set ikon outline dengan stroke 1,75 px.
- Ukuran 20 px untuk ikon umum dan 24 px untuk navigasi mobile.
- Ikon tidak ditempatkan dalam kotak berwarna sebagai dekorasi.
- Ikon status selalu ditemani teks.
- Ikon tombol tanpa label hanya boleh dipakai untuk aksi yang umum, misalnya kembali atau tutup, dan harus memiliki nama aksesibel.
- Emoji tidak dipakai sebagai ikon.

## 10. Komponen bersama

| Komponen | Varian utama | Ukuran minimum dan aturan |
|---|---|---|
| App bar mobile | Default, back, action | Tinggi 56 px, target 44 px |
| Bottom navigation | Penyewa, pemilik, admin | Tinggi 64 px, maksimal lima tujuan, ikon dan label |
| Sidebar desktop | Penyewa, pemilik, admin | Lebar 240 px, item tinggi 44 px, aktif dengan permukaan netral |
| Button | Primary pill, secondary, tertiary, destructive | Tinggi 48 px mobile dan 44 px desktop |
| Field | Text, textarea, select, uang, tanggal | Tinggi 48 px, label selalu terlihat, teks input 16 px |
| Upload foto | Empty, uploading, uploaded, rejected, failed | Drop area minimal 120 px, progres dan tindakan coba lagi |
| Kartu barang | Aktif, draf, dijeda | Foto 4:3, judul dua baris, harga dan status |
| Kalender rentang | Default, selected, booked, blocked, conflict | Sel hari minimal 44 px, legenda memakai bentuk dan label |
| Ringkasan biaya | Normal, revised | Harga harian, jumlah hari, subtotal, deposit simulasi, total |
| Status chip | Pending, approved, rejected, draft, paused, completed | Tinggi minimal 24 px, label tidak terpotong |
| Baris pengajuan | Pending, approved, rejected | Nama dimasking bila perlu, tanggal, biaya, dan satu aksi relevan |
| Handover checklist | OUT, RETURN, awaiting confirmation, disputed | Foto, lokasi, catatan, waktu, dan konfirmasi kedua pihak |
| Rating | 1 sampai 5, unset, readonly | Target bintang 44 px dan label nilai yang dapat dibaca |
| Antrean admin | Verification, dispute | Filter ringkas, bukti, status, dan tindakan keputusan |
| Dialog | Confirm, reject reason, destructive | Fokus awal pada judul atau field, tombol batal selalu tersedia |
| Inline feedback | Info, success, warning, error | Ikon, judul, pesan, dan tindakan berikutnya |

Komponen dibuat sebagai component FigCraft. Layar memakai instance. Perbedaan label, ikon, status, dan ukuran dicatat sebagai property atau override instance.

## 11. State interaksi

| State | Aturan visual dan perilaku |
|---|---|
| Default | Teks dan border memakai token normal. Aksi utama tunggal terlihat |
| Hover | Border atau permukaan berubah selama 160 ms. State ini hanya pelengkap untuk pointer |
| Focus | Ring 3 px `color.focus` dengan offset putih 2 px. Fokus tidak boleh tertutup sticky navigation |
| Pressed | Tombol menggelap dan dapat bergeser 1 px selama 120 ms. Label tetap terbaca |
| Disabled | Kontrol tetap terbaca, memakai label alasan dekat kontrol. Disabled tidak dipakai untuk menyembunyikan galat form |
| Loading | Struktur akhir langsung terlihat. Nilai diganti blok abu-abu datar, tanpa shimmer dan tanpa perubahan layout |
| Empty | Frame, judul, dan konteks tetap ada. Pesan menjelaskan sebab dan satu tindakan yang dapat mengisi data |
| Error | Galat tampil pada blok atau field yang gagal, menjelaskan masalah dan cara memperbaiki. Data lama dipertahankan bila aman |
| Success | Perubahan terlihat pada status layar dan diumumkan melalui pesan singkat. Toast tidak menggantikan perubahan status |

State yang wajib digambar pada page `States and Prototype` adalah form invalid, tanggal bentrok, pengajuan ditolak, unggah foto gagal, handover menunggu konfirmasi, sengketa terbuka, verifikasi ditolak, loading, dan empty state.

## 12. Aksesibilitas

1. Teks normal harus mencapai kontras minimum 4,5:1. Teks besar dan komponen bermakna mengikuti ambang WCAG 2.2 yang sesuai.
2. Target sentuh minimum 44 × 44 px dengan jarak yang mencegah target saling tumpang tindih.
3. Semua kontrol dapat dicapai melalui urutan keyboard yang mengikuti urutan visual.
4. Fokus terlihat pada setiap kontrol. Dialog mengembalikan fokus ke pemicu setelah ditutup.
5. Setiap field memiliki label tetap. Placeholder hanya memberi contoh format.
6. Galat field muncul dekat field, memakai teks dan ikon, serta mengarahkan fokus ke field pertama yang gagal.
7. Kalender dapat dioperasikan tanpa bergantung pada warna. Tanggal mempunyai nama, status, dan penanda bentuk.
8. Foto barang mempunyai teks alternatif yang menjelaskan barang. Foto dekoratif memakai alt kosong pada implementasi.
9. Tombol ikon mempunyai nama aksesibel. Ikon dekoratif tidak dibacakan.
10. Perubahan status, progres unggah, dan hasil tindakan direncanakan untuk live region pada implementasi.
11. Layout harus bertahan pada pembesaran teks 200% dan lebar 320 px tanpa gulir horizontal halaman.
12. Prototipe tidak memakai gestur tarik sebagai satu-satunya cara. Pengurutan foto menyediakan tombol naik dan turun pada implementasi.

## 13. Copy antarmuka

### 13.1 Nada dan istilah

- Gunakan bahasa Indonesia yang lugas, tenang, dan tidak menghakimi.
- Gunakan istilah **penyewa**, **pemilik**, dan **admin** secara konsisten.
- Gunakan **listing** sebagai istilah produk karena keputusan proyek memakainya. Penjelasan pertama dapat menyebut "listing barang".
- Gunakan **Ajukan sewa**, **Setujui**, dan **Tolak** sebagai label tindakan utama sesuai keputusan pemilik.
- Gunakan **Serah terima OUT** dan **Pengembalian RETURN** saat kode status perlu ditunjukkan. Dalam teks biasa, dahulukan istilah Indonesia.
- Gunakan sentence case. Jangan memakai huruf kapital seluruhnya, emoji, slogan, atau tanda seru.
- Tombol menyebut akibat. Gunakan "Simpan listing", bukan "Kirim" atau "Submit".

### 13.2 Pola pesan

| Keadaan | Pola copy |
|---|---|
| Galat field | Sebut masalah lalu cara memperbaiki. Contoh: "Tambahkan minimal satu foto agar listing dapat dipublikasikan." |
| Konflik tanggal | Sebut rentang yang bentrok dan minta pengguna memilih rentang lain |
| Penolakan | Tampilkan alasan yang ditulis pemilik dan status tanggal setelah penolakan |
| Unggah gagal | Sebut berkas yang gagal dan sediakan "Coba lagi" |
| Privasi | Sebut siapa yang dapat melihat KTM, lokasi, atau foto sebelum pengguna mengunggah |
| Empty state | Sebut mengapa kosong dan tindakan yang tersedia. Hindari "Tidak ada data" tanpa penjelasan |

## 14. Privasi dan kepercayaan

- KTM hanya terlihat oleh admin yang berwenang. Setelah dikirim, pengguna melihat thumbnail tersamarkan dan status verifikasi.
- NIM dimasking setelah pengajuan. Daftar dan kartu tidak menampilkan NIM lengkap.
- Lokasi serah terima rinci baru terlihat setelah pengajuan disetujui. Sebelum itu, pengguna hanya melihat area kampus secara umum.
- Foto kondisi OUT dan RETURN hanya terlihat oleh penyewa, pemilik, dan admin yang menangani sengketa.
- Profil calon penyewa hanya menampilkan data yang diperlukan untuk keputusan sewa. Tidak ada nomor telepon, alamat rumah, atau data lain yang tidak dibutuhkan.
- Setiap kontrol unggah menjelaskan siapa yang dapat melihat berkas tersebut.
- Kebijakan retensi KTM belum ditetapkan. Prototipe tidak mengarang jangka waktu penyimpanan dan menandai isu ini sebagai keputusan terbuka.
- Identitas, foto orang, hasil UAT, statistik, dan testimoni memakai data nyata atau placeholder yang diberi label jelas.

## 15. Motion

| Interaksi | Durasi | Easing | Catatan |
|---|---:|---|---|
| Hover dan focus | 160 ms | `cubic-bezier(0.2, 0, 0, 1)` | Warna dan border saja |
| Pressed | 120 ms | `cubic-bezier(0.2, 0, 0, 1)` | Perubahan warna dan pergeseran 1 px |
| Dialog dan bottom sheet | 200 ms | `cubic-bezier(0.2, 0, 0, 1)` | Fade dan perpindahan maksimal 16 px |
| Perubahan status | 160 ms | `cubic-bezier(0.2, 0, 0, 1)` | Cross-fade tanpa memindahkan layout |
| Navigasi prototipe | Instan atau dissolve 150 ms | Ease out | Tidak memakai animasi arah yang menyesatkan |

Tidak ada parallax, autoplay, elemen mengambang, pulse berulang, entrance animation per section, atau shimmer. Mode reduced motion mengubah perpindahan menjadi instan atau cross-fade singkat.

## 16. Batas lingkup

### 16.1 Dibuat

- Sembilan layar S-01 sampai S-09 pada mobile dan desktop, total 18 frame utama.
- State penting dan varian transaksi yang diperlukan untuk menunjukkan titik gagal.
- Komponen, token, text style, paint style, dan interaksi prototipe FigCraft.
- Ekspor PNG setiap layar dan satu PDF alur.

### 16.2 Ditunda atau tidak dibuat

- Dark mode.
- Multi-bahasa.
- Aplikasi mobile native.
- Payment gateway asli.
- Chat real-time.
- Multi-kampus.
- Rekomendasi machine learning.
- Pelacakan lokasi langsung.
- Dashboard analitik lanjutan.
- Hasil UAT, nama responden, skor SUS, dan klaim keberhasilan yang belum terjadi.

## 17. Pemetaan ke FigCraft

### 17.1 Variable collection

Collection utama bernama `SewaKampus / Core`. Variable memakai nama semantik berikut.

| Kelompok | Variable |
|---|---|
| Warna | Seluruh token `color.*` pada §7 |
| Spacing | `space.1`, `space.2`, `space.3`, `space.4`, `space.5`, `space.6`, `space.8`, `space.10` |
| Radius | `radius.control`, `radius.card`, `radius.media`, `radius.dialog`, `radius.primary` |
| Ukuran | `size.touch.min = 44`, `size.control.mobile = 48`, `size.control.desktop = 44`, `size.nav.mobile = 64`, `size.sidebar.desktop = 240` |
| Motion | `motion.fast = 120`, `motion.normal = 160`, `motion.dialog = 200` |

Jika FigCraft tidak mendukung jenis variable tertentu, nilai tetap dibuat sebagai variable numerik atau didokumentasikan pada page Foundations. Perubahan nama fitur FigCraft harus diverifikasi melalui Context7 sebelum eksekusi.

### 17.2 Text style

- `Type / Display / Screen`
- `Type / Display / Empty`
- `Type / Heading / L`
- `Type / Heading / M`
- `Type / Heading / S`
- `Type / Body / L`
- `Type / Body / M`
- `Type / Label / M`
- `Type / Meta / S`

### 17.3 Paint style

- `Paint / Background / Canvas`
- `Paint / Background / Surface`
- `Paint / Background / Subtle`
- `Paint / Text / Primary`
- `Paint / Text / Secondary`
- `Paint / Accent / Solid`
- `Paint / Accent / Soft`
- `Paint / Border / Default`
- `Paint / Border / Strong`
- `Paint / Status / Success`
- `Paint / Status / Warning`
- `Paint / Status / Error`
- `Paint / Status / Info`
- `Paint / Focus`

### 17.4 Component naming

Komponen memakai pola `<Kategori> / <Nama> / <Varian> / <Viewport>`. Contoh: `Button / Primary / Default / Mobile`. Instance di layar tidak dilepas dari komponen kecuali FigCraft tidak mendukung override yang diperlukan. Pengecualian harus dicatat pada dokumentasi prototipe.

## 18. Referensi dan batas pemakaian

Referensi Growlio dibuka langsung melalui Playwright pada 23 November 2026. Screenshot pemeriksaan tersimpan di `references/jiro-growlio-header-2026-11-23-session3.png`.

Unsur yang dipakai adalah krem hangat, hijau tua, kontras serif dan sans, tombol utama pill, bingkai media membulat, serta nada ramah. Unsur yang tidak dipakai adalah lintasan ikon sosial, badge statistik, foto kampanye, hero raksasa, animasi dekoratif, dan layout landing page sebagai pola transaksi. Source code dan aset berbayar tidak disalin.

Contoh FigCraft Growpath hanya dipakai untuk mempelajari organisasi page, komponen, state, dan flow. SewaKampus tidak menyalin komponen, token, isi, atau struktur visual Growpath.

## 19. Keputusan yang masih terbuka sebelum menggambar

1. Ketersediaan Libre Baskerville dan Source Sans 3 di FigCraft perlu diverifikasi.
2. Retensi berkas KTM belum diputuskan oleh pemilik proyek.
3. Endpoint pengguna untuk membuka sengketa belum tersedia pada kontrak API. S-09 menunjukkan sisi admin dan asal bukti, tetapi tidak mengklaim endpoint pengguna sudah ada.
