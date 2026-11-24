**Status:** Ada. Brief internal untuk Gate 1; Gate 1 belum dinilai dosen.

# P13 — Brief Gate 1 dan Naskah Presentasi

**Tanggal:** 24 November 2026
**Pemilik:** Hanan Rizqullah (CEO/PO)
**Dasar:** `Skenario_Project ASP R001.txt` hlm. 15–17

## 1. Tujuan brief

Menyiapkan Hanan untuk Gate 1 besok: satu halaman bukti, naskah lima menit, dan daftar risiko yang harus disebut jujur. Brief ini tidak mengubah status gate dan tidak mengisi warna.

## 2. Ringkasan yang harus dihafal

- Produk: **SewaKampus**, marketplace sewa barang antar-mahasiswa di satu kampus.
- Masalah: barang mahal jarang dipakai, sementara transaksi sewa masih di grup WhatsApp tanpa katalog, ketersediaan, bukti kondisi, dan rating.
- Solusi: katalog, kalender, persetujuan sewa, foto kondisi OUT/RETURN, rating.
- **Lima Must, tidak ada Must keenam:** listing, kalender ketersediaan, persetujuan sewa, foto kondisi, rating.
- Stack tetap: Laravel 11, MySQL 8, Redis 7, MinIO, Keycloak 26, Nginx, satu VPS Docker Compose, Cloudflare, OpenAPI 3.1.
- Login lokal: Keycloak OIDC + PKCE, role `STUDENT`/`ADMIN` dari MySQL, halaman login bertema SewaKampus.
- Repo: `https://github.com/hanansj789/sewakampus` (privat), `main`/`dev` di `1aef366`.

## 3. Status artefak

| Kelompok | Status internal |
|---|---|
| P13 (15 butir) | **15/15 Selesai (internal)** |
| PR sebelum P14 (8 butir) | **8/8 Selesai (internal)** |
| P14–P16 (12 butir) | Belum; menunggu Gate 1 |
| Total matriks | 23 Selesai (internal), 1 Ada, 3 Sebagian, 8 Belum |

Angka pendukung:

- ERD 14 entitas, 17 relasi; bukti 3NF tersedia.
- DDL 14 tabel + 1 view; seed 30 pengguna, 30 barang, 30 kategori; diuji di MySQL 8.0.43.
- API 34 path, 39 operasi, 38 skema; foto kondisi wajib pada handover.
- Wireframe 9 layar; prototipe hi-fi 7 layar; 15 test case.
- Aplikasi lokal Laravel 11.57.1; 16 test lulus, 70 assertion; login STUDENT/ADMIN dan penolakan lintas role 403 sudah diuji.
- Tema login Keycloak `sewakampus` sudah dipasang dan diperiksa di browser.

## 4. Checklist Gate 1

| # | Butir resmi | Status |
|---|---|---|
| 1 | Architecture Vision dibekukan v1.0 | Siap diajukan |
| 2 | Traceability ≥5 baris | Siap diajukan |
| 3 | ERD 3NF konsisten dengan use case | Siap diajukan |
| 4 | MoSCoW, Must maksimal 5 | Siap diajukan |
| 5 | Repo dan papan kerja aktif | Siap diajukan |

Status resmi dosen: **belum ada**. Jangan menyebut Hijau, Kuning, atau Merah.

## 5. Naskah lima menit

| Waktu | Isi |
|---|---|
| 0:00–0:30 | Perkenalan: Kelompok 1, SewaKampus, masalah barang mahal yang jarang dipakai versus barang menganggur. |
| 0:30–1:15 | Vision dan tiga KPI target: kelengkapan listing ≥90%, persetujuan ≤24 jam ≥80%, bukti kondisi + rating ≥90%. Sebut bahwa itu target, bukan capaian. |
| 1:15–2:00 | Lima Must dan batas lingkup: tidak ada Must keenam; KTM, deposit, dan serah terima adalah kontrol alur. |
| 2:00–3:00 | Arsitektur: Laravel 11 sebagai BFF, Keycloak 26 OIDC/PKCE, MySQL 8, Redis, MinIO, Nginx, satu VPS Docker Compose. Data 14 entitas/17 relasi, API 34 path. |
| 3:00–3:45 | Bukti lokal: repo, branch, tag, 16 test/70 assertion, login mahasiswa/admin, role 403. Tunjukkan halaman login bertema SewaKampus. |
| 3:45–4:30 | Cara kerja: branch per role, PR ke `dev`, papan kerja, review silang dilewati secara internal (SK-021) dan itu bukan review independen. |
| 4:30–5:00 | Risiko dan permintaan: Gate 1 belum dinilai; UAT masih proksi internal; 5 advisori Laravel 11 sudah ditriase; hosting termurah Oracle Always Free $0; minta keputusan Gate 1. |

## 6. Tanya-jawab yang mungkin muncul

| Pertanyaan | Jawaban singkat |
|---|---|
| Mengapa hanya lima Must? | TXT hlm. 7 membatasi maksimal lima; KTM, deposit, dan serah terima adalah kontrol alur, bukan Must baru. |
| Mengapa Laravel 11, bukan 12? | Stack sudah ditetapkan di TRD/ADR-001. Laravel 11.57.1 adalah rilis 11.x terbaru; 5 advisori tersisa sudah ditriase dan perbaikan penuh menuntut upgrade major yang harus lewat CR. |
| Mengapa Keycloak? | SSO kampus, OIDC + PKCE, Laravel tidak menyimpan kata sandi. Halaman login Keycloak sudah bertema SewaKampus. |
| Apakah 3NF terbukti? | Ya, 14 entitas dan 17 relasi; bukti ada di `02_Data/P13-3NF-Proof.md` dan DDL diuji di MySQL 8.0.43. |
| Apakah aplikasi sudah jadi? | Baru scaffold login + role. Lima Must belum dibangun; implementasi menunggu Gate 1. |
| UAT dengan siapa? | Tiga peserta proksi dari tim: Fharel (penyewa), Mahesa (pemilik), Fazha (admin). Mitra eksternal belum ada. |
| Hosting berapa? | Opsi utama Oracle Always Free $0 (2 OCPU/12 GB/200 GB), fallback Biznet Gio Rp269.000/bulan atau Hetzner. |
| Apakah aman? | Belum bisa diklaim aman untuk production. 5 advisori Laravel 11 tersisa; kontrol dan batasnya ada di `07_Evidence/P14-Security-Audit-Triage.md`. |

## 7. Yang tidak boleh diklaim

- Gate 1 sudah lolos atau berwarna Hijau/Kuning/Merah.
- Lima Must sudah selesai.
- UAT sudah dilakukan bersama mitra eksternal.
- Audit dependensi bersih.
- Semua artefak sudah direview independen.

## 8. Bukti yang dibuka saat presentasi

1. `P13-DELIVERABLE-MATRIX.md` — rekap status.
2. `06_Governance/P13-Gate-1-Checklist.md` — lima butir resmi.
3. `02_Data/P13-ERD.png` — ERD 17 relasi.
4. `03_Application/openapi.yaml` — kontrak API.
5. `03_Application/ux/exports/L-01` sampai `L-07` — prototipe.
6. `08_Source/README.md` — cara menjalankan.
7. `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md` — bukti login/role.
8. `07_Evidence/P14-Security-Audit-Triage.md` — risiko keamanan.
