# P14 dan PR sebelum P15 — Rencana Kerja

**Status:** Ada (rencana). Bukan bukti selesai.
**Tanggal:** 27 November 2026
**Dasar:** `Skenario_Project ASP R001.txt` hlm. 22–28.
**Posisi:** P13 selesai secara internal (23 dari 35 butir, Gate 1 belum dinilai dosen). P14 baru selesai di bagian infrastruktur, autentikasi, dan basis data. Fitur Must belum ada.

## 1. Yang sudah ada untuk P14

| Artefak | Path | Bukti |
|---|---|---|
| ADR tech stack | `06_Governance/ADR-001-tech-stack.md` | Ada, belum ada tanda persetujuan CEO |
| DDL dijalankan di MySQL 8.0.43 | `07_Evidence/PR14-04-DDL-Run-Log.md` | 14 tabel, 1 view, 22 FK, lolos di database kosong |
| Seed ≥30 baris | `07_Evidence/PR14-04-DB-Verification-Run.md`, `database/sql/seed.sql` | 30 kategori, 30 pengguna, 30 barang |
| Login + role lokal | `08_Source/`, `07_Evidence/PR14-06-Local-Login-Role-Run-Log.md`, ADR-003 | Laravel 11.57.1, Keycloak OIDC + PKCE, middleware role |
| 16 feature test auth | `08_Source/tests/Feature/` | 70 assertion |
| Topologi as-is dan to-be | `04_Technology/P13-Topology-As-Is.md` | Kualitatif, belum ada IP plan |
| Security baseline dan triage | `04_Technology/P13-Security-Baseline.md`, `07_Evidence/P14-Security-Audit-Triage.md` | 5 advisori diterima dengan kontrol |
| 15 test case black-box | `07_Evidence/P14-Test-Cases.md` | Belum dijalankan |
| CR log | `06_Governance/CHANGE-REQUEST-LOG.md` | CR-001 sampai CR-008 |

## 2. Deliverable P14 di kelas, per peran

| Peran | Deliverable (TXT hlm. 24) | Bukti yang harus ada | Status sekarang |
|---|---|---|---|
| CEO / PO (+QA P14) | ADR tech stack bersama Programmer dan Network; Kartu Kejutan menjadi CR; uji 2 fitur pertama | ADR-001 disetujui CEO; satu CR baru dari Kartu Kejutan berisi analisis dampak dan keputusan; catatan uji dua fitur | **Sebagian** — ADR ada tanpa persetujuan, CR Kartu Kejutan belum ada, fitur belum ada sehingga belum bisa diuji |
| Analyst / UI/UX | ≥15 test case black-box dari user story; cek UI implementasi vs prototipe | 15 kasus dengan hasil lulus/gagal; catatan selisih UI vs prototipe per layar | **Sebagian** — 15 kasus ada tetapi belum dijalankan; UI baru dicek pada halaman auth |
| Database | Implementasi DB: PK, FK, unique, check, indeks, view laporan; pair dengan Programmer | Bukti uji DDL; daftar constraint; view laporan; catatan pair | **Ada** untuk DDL dan constraint; view laporan baru `v_item_rating`; pair belum tercatat |
| Programmer | 2 fitur Must end-to-end (UI → logika → DB), merge lewat PR yang direview | Dua alur bisa didemokan dari database nyata; PR dengan reviewer | **Belum** — `routes/web.php` hanya auth dan dashboard |
| Network / DevOps | Topologi final + IP plan; deployment diagram; checklist keamanan; deploy ke staging | Dokumen IP plan; diagram deployment final; checklist keamanan; URL staging | **Sebagian** — topologi dan security ada; IP plan, deployment final, dan staging belum |

## 3. PR sebelum P15, per peran

| Peran | Deliverable (TXT hlm. 24 dan 28) | Bukti yang harus ada | Status sekarang |
|---|---|---|---|
| CEO / PO | Gap analysis per domain; jadwal UAT P15 terkonfirmasi | Dokumen gap per domain; bukti konfirmasi jadwal | **Belum** — `05_Opportunities/` kosong; UAT baru rencana tiga pengguna proksi internal |
| Analyst / UI/UX | Skenario UAT berbasis tugas + kuesioner SUS 10 butir | Skenario tugas, kuesioner, cara mencatat bukti | **Ada** — `07_Evidence/P15-UAT-Plan.md`, perlu disesuaikan setelah fitur jadi |
| Database | Transaksi/stored procedure proses kritis + skrip backup yang sudah dicoba | Prosedur transisi status di DB; skrip backup; log uji restore | **Belum** — belum ada prosedur maupun skrip backup |
| Programmer | Fitur Must ke-3 dan ke-4; dokumentasi route/endpoint | M3 dan M4 jalan; daftar route aktual | **Belum** |
| Network / DevOps | Estimasi biaya infrastruktur 12 bulan (TCO) | TCO dengan komponen dan sumber harga | **Belum** — dua opsi hosting ada, enam komponen biaya belum diverifikasi |

## 4. Definition of Done Gate 2 (TXT hlm. 27)

| # | Butir | Status |
|---|---|---|
| 1 | Demo langsung 2 fitur Must end-to-end dengan database nyata | Belum |
| 2 | ADR tech stack tertulis dan disetujui CEO | ADR ada, persetujuan belum |
| 3 | Topologi + deployment diagram final; versi awal ter-deploy ke staging | Belum |
| 4 | CR dari Kartu Kejutan terdokumentasi dengan keputusan | Belum (baru muncul di kelas P14) |
| 5 | Tidak ada anggota dengan nol kontribusi di repo atau artefak | Terpenuhi — 13 PR merged dari branch role berbeda, 88 commit |

## 5. DoD per peran

### CEO / PO (+QA)

- [ ] ADR-001 memuat pilihan stack, alternatif yang ditolak, dan konsekuensi.
- [ ] ADR-001 punya baris persetujuan CEO bertanggal.
- [ ] Kartu Kejutan tercatat sebagai CR dengan empat bagian: permintaan, analisis dampak ke data/aplikasi/teknologi/jadwal, keputusan, komunikasi.
- [ ] Dua fitur pertama diuji manual dan hasilnya dicatat sebagai bukti.
- [ ] Papan kerja menautkan setiap fitur ke kartu dan PR.

### Analyst / UI/UX

- [ ] 15 kasus black-box menautkan ID user story dan kriteria penerimaan.
- [ ] Setiap kasus punya langkah, data uji, hasil yang diharapkan, dan status lulus atau gagal.
- [ ] Selisih antara prototipe dan implementasi dicatat per layar, bukan hanya "sudah dicek".
- [ ] Temuan yang memengaruhi kontrak API diteruskan sebagai CR, bukan diubah diam-diam.

### Database

- [ ] Semua tabel punya PK, dan setiap FK punya indeks.
- [ ] Constraint unik dan check aktif, dibuktikan dengan uji sisip data yang melanggar.
- [ ] View laporan minimal satu, dipakai atau direncanakan dipakai oleh layar.
- [ ] Ada prosedur atau transaksi untuk perubahan status booking yang tidak boleh melompat.
- [ ] Skrip backup ada dan pernah dijalankan; hasil dan durasinya dicatat.

### Programmer

- [ ] M1 listing: buat, ubah, jeda, unggah foto, tampil di katalog.
- [ ] M2 kalender: tanggal terisi dan kosong, tolak rentang bentrok.
- [ ] Keduanya menulis dan membaca dari MySQL, bukan data contoh di kode.
- [ ] Validasi di server, bukan hanya di form.
- [ ] Merge lewat PR dengan minimal satu reviewer dan deskripsi bukti.
- [ ] Dokumentasi route aktual diperbarui di `03_Application/openapi.yaml` bila ada selisih.

### Network / DevOps

- [ ] IP plan: segmen, port yang dibuka, dan alasan tiap port.
- [ ] Deployment diagram final memuat node, artefak, protokol, dan port.
- [ ] Checklist keamanan dijalankan pada aplikasi yang berjalan, bukan hanya dokumen.
- [ ] Staging bisa diakses dan menampilkan aplikasi versi terkini.
- [ ] TCO 12 bulan memakai harga bersumber; komponen yang belum pasti ditandai belum diverifikasi.

## 6. Urutan kerja yang disarankan

1. Commit dan push lima file yang masih menggantung di branch `dev`.
2. M1 listing end-to-end, termasuk unggah foto ke object storage.
3. M2 kalender ketersediaan, termasuk penolakan rentang bentrok.
4. Jalankan 15 test case terhadap dua fitur itu; ubah statusnya apa adanya.
5. IP plan, deployment diagram final, lalu staging.
6. Kartu Kejutan menjadi CR, disetujui CEO; ADR-001 ditandatangani.
7. Isi bukti Gate 2, lalu PR sebelum P15: M3, M4, prosedur transaksi, backup, gap analysis, TCO.

## 7. Aturan

- Jangan menambah Must keenam.
- Jangan mengklaim Gate 2 hijau; status warna hanya diisi dosen.
- Jangan menandai test case lulus tanpa keluaran uji.
- Jangan mengarang jadwal mitra, URL staging, atau harga TCO.
- Perubahan skema setelah Gate 2 hanya untuk bug, keamanan, atau Must berikutnya.
