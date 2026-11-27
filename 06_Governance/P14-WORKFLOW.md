# Alur Kerja P14 dan PR sebelum P15

**Status:** Ada (rencana kerja). Belum ada pekerjaan yang diklaim selesai.
**Tanggal:** 27 November 2026
**Dasar:** `Skenario_Project ASP R001.txt` hlm. 22–28, `P14-PLAN.md`, `DECISIONS.md`.

## 1. Prinsip

1. **Lokal dulu, GitHub belakangan.** Pekerjaan diselesaikan dan diuji di laptop, baru di-push setelah satu tugas benar-benar utuh.
2. **Satu tugas, satu branch, satu PR.** Jangan menumpuk beberapa tugas dalam satu branch.
3. **Commit atas nama orang yang mengerjakan.** Satu laptop boleh dipakai bergantian, tetapi identitas commit dan akun push harus orang yang benar.
4. **Tidak ada push langsung ke `main` atau `dev`.** Semua lewat PR ke `dev`, lalu `dev` ke `main` saat rilis.
5. **Reviewer bukan penulis.** Setiap PR punya minimal satu reviewer dari peran lain.
6. **Tidak ada klaim tanpa bukti.** Test lulus, tangkapan layar, atau log. Status gate tetap milik dosen.

## 2. Alur satu tugas, dari lokal sampai merge

| Langkah | Perintah atau tindakan | Bukti |
|---|---|---|
| 1 | `git switch dev && git pull --ff-only` | branch bersih |
| 2 | `git switch -c feature/<peran>-<tugas>` | branch baru dari `dev` |
| 3 | Set identitas: `git config user.name`, `git config user.email` | `git config --get user.email` |
| 4 | Kerjakan, jalankan `php artisan test` dan uji manual | keluaran test |
| 5 | `git add` hanya file tugas, lalu commit `[App] ...` | `git log -1 --stat` |
| 6 | `gh auth switch --user <akun>` lalu `gh auth status` | akun aktif benar |
| 7 | `git push -u origin <branch>` | branch ada di remote |
| 8 | `gh pr create --base dev --reviewer <anggota>` | nomor PR |
| 9 | Reviewer memeriksa, penulis memperbaiki, lalu merge | PR merged |
| 10 | Perbarui kartu papan kerja dan `P13-STATUS.md` | kartu menautkan PR |

### Perintah ganti identitas dan akun

```bash
git config user.name "Nama Lengkap"
git config user.email "email-terverifikasi-di-github"
gh auth switch --user <username-github>
gh auth status
git log -1 --format='%an <%ae>'
```

Periksa `gh auth status` sebelum `git push`. Nama di commit (author) dan akun yang melakukan push adalah dua hal berbeda; keduanya harus orang yang sama.

### Larangan saat push

- Jangan push `.env`, `vendor/`, `node_modules/`, kunci, atau berkas KTM.
- Jangan memakai token akun lain.
- Jangan mengubah identitas orang lain untuk commit yang bukan pekerjaannya.
- Jangan push pekerjaan setengah jadi hanya agar "ada commit".

## 3. Fase kerja

Urutan ini disusun agar tiap fase membuka fase berikutnya, dan agar dua fitur Must selesai lebih dulu sebelum pekerjaan yang bergantung padanya.

| Fase | Fokus | Pemilik | Perkiraan | Selesai jika |
|---|---|---|---|---|
| 0 | Prasyarat: MySQL 3311, Keycloak 8080, storage lokal, kartu kerja | Fazha + Mahesa | 0,5 hari | `php artisan test` 16 lulus, database bisa dibuka, kartu M1–M4 ada |
| 1 | **M1 listing** end-to-end | Fazha | 2 hari | Listing tersimpan di MySQL, foto terunggah, tampil di katalog, bisa dijeda, test lulus |
| 2 | **M2 kalender** + aturan bentrok | Fazha, pair Mahesa | 1,5 hari | Tanggal kosong dan terisi tampil benar, rentang bentrok ditolak di server |
| 3 | Uji 15 kasus + cek UI vs prototipe | Fharel, QA Hanan | 1 hari | Setiap kasus berstatus lulus atau gagal apa adanya, selisih UI dicatat |
| 4 | Staging + IP plan + deployment final | Mahesa | 1 hari | URL staging bisa dibuka dosen, diagram final, checklist keamanan dijalankan |
| 5 | Paket Gate 2 | Hanan | 0,5 hari | Bukti demo 2 fitur, ADR ditandatangani, CR Kartu Kejutan, ringkasan gate |
| 6 | PR sebelum P15 | semua | 3–4 hari | M3 dan M4 jalan, backup diuji, TCO, gap analysis, UAT siap |

Fase 1–5 adalah P14. Fase 6 adalah PR sebelum P15. Fase 4 dan 6 bisa berjalan sebagian paralel setelah M2 selesai.

## 4. Pembagian per peran

| Peran | Branch | Tugas P14 | Tugas PR sebelum P15 | Reviewer |
|---|---|---|---|---|
| Hanan (CEO/PO + QA P14) | `feature/ceo-governance` | ADR-001 disetujui, CR Kartu Kejutan, uji 2 fitur, paket Gate 2 | Gap analysis per domain, konfirmasi jadwal UAT | Mahesa |
| Fharel (Analyst/UI/UX) | `feature/analyst-usecase` | Jalankan 15 test case, cek UI vs prototipe | Finalkan skenario UAT + SUS | Hanan |
| Fazha (Programmer + DB) | `feature/programmer-app` | M1 listing, M2 kalender | M3 persetujuan, M4 foto kondisi, dokumentasi route | Fharel |
| Mahesa (Network/DevOps + QA P13) | `feature/network-devops` | IP plan, deployment final, staging, checklist keamanan | TCO 12 bulan, prosedur transaksi + skrip backup | Fazha |

QA bergilir: P14 dipegang CEO, P15 dipegang Database (TXT hlm. 6). Artinya Hanan menguji fitur di P14, Fazha menguji di P15.

## 5. Rincian teknis per fase

### Fase 0 — Prasyarat

- Pastikan MySQL port 3311 hidup dan database `sewakampus` berisi 14 tabel hasil `001_init.sql` dan `seed.sql`.
- Keycloak port 8080 hidup dengan realm `sewakampus` dan client `sewakampus-local`.
- Storage lokal memakai disk privat; aturan unggah foto TIDAK boleh jatuh ke `public/` tanpa kontrol akses.
- `.env` berisi client secret lokal. Jangan pernah menyalinnya ke dokumen, commit, atau chat.

### Fase 1 — M1 listing

- Model dan relasi: `Item`, `ItemCategory`, `ItemPhoto`.
- Rute: daftar katalog, form buat, simpan, ubah, jeda, unggah foto.
- Validasi server: judul wajib ≤120, harga ≥0, kondisi salah satu dari tiga nilai, kategori harus ada.
- Otorisasi: hanya pemilik yang bisa mengubah atau menjeda listingnya.
- Foto: simpan ke disk privat, simpan path di `item_photos`, satu foto utama.
- Test: buat listing valid, tolak data tidak valid, tolak pengguna lain mengubah, unggah foto bukan gambar ditolak.

### Fase 2 — M2 kalender

- Tampilkan tanggal terisi dari booking aktif dan blokir pemilik.
- Tolak pengajuan yang bertabrakan, dihitung di server dalam transaksi, bukan hanya di tampilan.
- Indeks `(item_id, start_date, end_date)` dipakai; uji dengan dua permintaan bersamaan.
- Test: rentang bentrok ditolak, rentang bersebelahan diterima, blokir pemilik dihormati.

### Fase 3 — Uji

- 15 kasus yang sudah ada dijalankan pada M1 dan M2.
- Setiap hasil ditulis lulus atau gagal; kasus yang gagal menjadi tugas perbaikan, bukan dihapus.
- Cek UI membandingkan layar nyata dengan prototipe S-01, S-02, S-03.

### Fase 4 — Staging

- IP plan: segmen, port yang dibuka, alasan.
- Deployment diagram final: node, artefak, protokol, port.
- Staging: bila belum ada VPS, jalankan stack di laptop dan buka lewat tunnel gratis; catat bahwa ini bukan produksi dan bukan jaminan ketersediaan.
- Checklist keamanan dijalankan pada aplikasi yang hidup: HTTPS, cookie, role, unggah berkas, rate limit.

### Fase 5 — Gate 2

- Demo dua fitur dari database nyata, bukan prototipe.
- ADR-001 diberi baris persetujuan CEO bertanggal.
- CR Kartu Kejutan diisi lengkap: permintaan, dampak, keputusan, komunikasi.
- Ringkasan Gate 2 menulis apa yang bisa dan belum bisa didemokan.

### Fase 6 — PR sebelum P15

- M3 persetujuan sewa: transisi status di server, riwayat status, notifikasi.
- M4 foto kondisi: handover OUT dan RETURN, foto wajib, dua konfirmasi.
- Database: prosedur transisi status + skrip backup + uji restore ke database baru.
- TCO 12 bulan: harga bersumber, komponen belum pasti ditandai belum diverifikasi.
- Gap analysis per domain: bisnis, data, aplikasi, teknologi.

## 6. Titik henti dan pemeriksaan

| Titik | Periksa | Jika gagal |
|---|---|---|
| Sebelum push | `git status` bersih dari `.env`/`vendor`, test lulus, identitas benar | perbaiki dulu, jangan push |
| Setelah PR | Reviewer memberi catatan | perbaiki di branch yang sama |
| Sebelum Gate 2 | Dua fitur didemokan dari MySQL | jangan isi bukti gate |
| Sebelum P15 | UAT punya pengguna, jadwal, dan bukti | tulis belum, jangan dikarang |

## 7. Risiko

| Risiko | Dampak | Mitigasi |
|---|---|---|
| MySQL lokal mati | M1/M2 tidak bisa diuji | catat cara menyalakan di `04_Technology/P13-Local-Stack-Runbook.md` |
| Staging tanpa VPS | Gate 2 butir 3 gagal | tunnel dari laptop, catat batasnya, atau sewa VPS termurah |
| Satu orang mengerjakan semua | nilai individu jatuh | branch dan commit per orang, reviewer silang |
| M3 dan M4 terlalu besar | PR sebelum P15 tidak selesai | kerjakan M3 dulu, M4 menyusul; M4 sudah punya kontrak multipart |
| Identitas commit tertukar | bukti kontribusi salah | periksa `git log -1 --format='%an <%ae>'` sebelum push |

## 8. Keputusan yang sudah diambil

| ID | Keputusan | Alasan |
|---|---|---|
| SK-026 | Staging memakai tunnel dari laptop, bukan VPS berbayar | tidak menambah biaya; batasnya dicatat sebagai bukan produksi |
| SK-027 | Foto P14 disimpan di disk privat Laravel (`storage/app/private`); MinIO dipakai di staging | menunda dependensi layanan tambahan sampai dibutuhkan |
| SK-028 | MySQL 8.0.43 portable di `C:/Users/ASUS/tools/mysql8` menjadi database lokal; Keycloak 26.4.0 dengan JRE 21 di folder tools | menyamakan dengan stack yang diklaim, tanpa instalasi layanan |

Yang masih terbuka: tanggal mulai tiap fase dan siapa yang duduk di laptop pada tiap blok kerja.
