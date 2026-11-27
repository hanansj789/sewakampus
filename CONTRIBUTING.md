# Panduan Kontribusi

Berlaku untuk empat anggota Kelompok 1 dan siapa pun yang mengerjakan repo ini.

## Branch

- `main` — rilis dan submission. Jangan commit langsung.
- `dev` — integrasi. Jangan commit langsung.
- `feature/*` — fitur aplikasi.
- `docs/*` — artefak arsitektur dan dokumen.
- `fix/*` — perbaikan.

Semua pull request masuk ke `dev`, kecuali sinkronisasi rilis `dev` ke `main`. Minimal satu reviewer selain penulis.

## Commit

Awalan wajib, sesuai folder yang berubah:

`[Vision]`, `[Business]`, `[Data]`, `[App]`, `[Tech]`, `[Source]`, `[Evidence]`, `[Pitch]`, `[Governance]`.

Contoh: `[Vision] tambah tiga KPI dan batas MVP`.

Dilarang masuk repo: `.env`, password, token, file KTM asli, data pribadi, `node_modules`, `vendor`, dan file sementara `~$`.

## Identitas commit

Commit harus dibuat oleh orang yang benar-benar mengerjakan bagian itu.

Sebelum commit pertama, setiap anggota mengatur identitasnya di repo ini:

```bash
git config user.name "Nama Lengkap"
git config user.email "email-yang-terverifikasi-di-akun-github"
```

Commit fondasi Session 1 memakai identitas tim `SewaKampus Kelompok 1`, bukan nama anggota, karena tidak ada anggota yang mengerjakan bagian itu secara pribadi.

## Satu laptop, empat akun GitHub

Fase GitHub belum dimulai. Saat nanti dijalankan:

1. Sebelum commit: periksa `git config user.name` dan `git config user.email` sudah milik orang yang bekerja.
2. Sebelum push: `gh auth status`, lalu `gh auth switch --user <akun>`.
3. Periksa remote dan izin repo sebelum push.

Nama di commit (author) dan akun yang melakukan push adalah dua hal berbeda. Jangan memakai token orang lain, dan jangan mengaku-ngaku commit orang lain sebagai kontribusi sendiri.

Jika `git push` ditolak dengan 403 padahal `gh auth status` sudah benar, Windows Credential Manager masih menyimpan akun lain. Arahkan repo ini memakai token `gh`:

```bash
git config --local credential.https://github.com.helper "!gh auth git-credential"
```

Periksa dengan `git config --local --get credential.https://github.com.helper`. Pengaturan ini hanya berlaku untuk repo ini, bukan global.

## Review

- Penulis dan reviewer harus orang berbeda.
- Reviewer memeriksa isi, bukan hanya nama file.
- Klaim "Ada" tanpa file yang bisa dibuka ditolak.
- Angka, tanggal, nama mitra, dan status gate tidak boleh dikarang.

## Artefak

Setiap file artefak diawali label status: **Ada**, **Draf**, **Belum**, atau **Belum diverifikasi**. Alasan dan bukti ditulis di dalam file, bukan hanya di chat.
