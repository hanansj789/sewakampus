**Status:** Ada. Papan kerja P14 dan PR sebelum P15. Semua kartu belum selesai.

# Papan Kerja P14 dan PR sebelum P15

**Diperbarui:** 27 November 2026
**Dasar:** `P14-PLAN.md`, `P14-WORKFLOW.md`, `Skenario_Project ASP R001.txt` hlm. 24 dan 28.
**Aturan:** satu kartu satu pemilik. Kartu pindah status hanya setelah bukti path ada.

## Ringkasan

| Kartu | Isi | Pemilik | Status |
|---|---|---|---|
| K-M1 | Listing end-to-end | Fazha | Menunggu review |
| K-M2 | Kalender ketersediaan | Fazha | Menunggu review |
| K-TEST | Jalankan 15 test case dan cek UI | Fharel | Sebagian |
| K-STG | IP plan, deployment, staging | Mahesa | Belum |
| K-GATE2 | Paket Gate 2 | Hanan | Belum |
| K-M3 | Persetujuan sewa | Fazha | Menunggu review |
| K-M4 | Foto kondisi serah terima | Fazha | Menunggu review |
| K-DB | Prosedur transaksi dan backup | Fazha | Belum |
| K-TCO | Biaya infrastruktur 12 bulan | Mahesa | Belum |
| K-GAP | Gap analysis per domain | Hanan | Belum |
| K-UAT | Finalisasi skenario UAT dan SUS | Fharel | Belum |

## K-M1 — Listing end-to-end

**Pemilik:** Fazha. **Branch:** `feature/programmer-m1-listing`. **Reviewer:** Fharel.

- [x] Model dan relasi `Item`, `ItemCategory`, `ItemPhoto`.
- [x] Rute katalog, form buat, simpan, ubah, jeda.
- [x] Validasi server: judul ≤120, harga ≥0, kondisi salah satu dari tiga nilai, kategori wajib ada.
- [x] Otorisasi: hanya pemilik yang bisa mengubah atau menjeda.
- [x] Unggah foto ke disk privat, satu foto utama, path tersimpan di `item_photos`.
- [x] Listing tampil di katalog dan tetap ada setelah aplikasi dinyalakan ulang.
- [x] Test: buat valid, tolak tidak valid, tolak pengguna lain, tolak berkas bukan gambar.

**Status:** Menunggu review. Bukti: `07_Evidence/P14-M1-Run.md`, 11 tes lulus (37 assertion), total suite 27 lulus (107 assertion).

## K-M2 — Kalender ketersediaan

**Pemilik:** Fazha, pair Mahesa. **Branch:** `feature/programmer-m2-calendar`. **Reviewer:** Mahesa.

- [x] Tanggal terisi dari booking aktif dan blokir pemilik.
- [x] Tanggal kosong ditampilkan sebagai tersedia.
- [x] Rentang bentrok ditolak di server lewat endpoint ketersediaan.
- [ ] Indeks `(item_id, start_date, end_date)` diperiksa dengan EXPLAIN.
- [ ] Dua permintaan bersamaan tidak menghasilkan double booking. **Dipindah ke K-M3**, karena hanya bisa diuji setelah pembuatan booking ada.

**Status:** Menunggu review. Bukti: `07_Evidence/P14-M2-Run.md`, 10 tes lulus (20 assertion), total suite 37 lulus (127 assertion).

## K-TEST — Jalankan 15 test case dan cek UI

**Pemilik:** Fharel. **Branch:** `docs/analyst-test-run`. **Reviewer:** Hanan.

- [x] TC-01 sampai TC-05 dijalankan pada M1 dan M2 lewat peramban (pemeriksaan awal).
- [ ] TC-06 sampai TC-15 menunggu M3, M4, dan M5.
- [x] Dua cacat ditemukan dan diperbaiki: pesan validasi bahasa Inggris, foto seed hilang.
- [ ] Uji formal 15 kasus oleh Analyst.
- [ ] Cek UI membandingkan layar nyata dengan prototipe S-01, S-02, S-03.
- [ ] Selisih UI dicatat per layar.

**Status:** Sebagian. Bukti awal: `07_Evidence/P14-M1M2-Precheck.md` dan dua tangkapan layar di `07_Evidence/screenshots/`.

## K-STG — IP plan, deployment, staging

**Pemilik:** Mahesa. **Branch:** `feature/network-staging`. **Reviewer:** Fazha.

- [ ] IP plan: segmen, port yang dibuka, alasan tiap port.
- [ ] Deployment diagram final: node, artefak, protokol, port.
- [ ] Checklist keamanan dijalankan pada aplikasi hidup.
- [ ] Staging diakses lewat tunnel dari laptop (keputusan SK-026), bukan VPS.
- [ ] Catat batas staging: single node, bukan produksi, mati bila laptop mati.

**Bukti:** `07_Evidence/P14-Staging-Deploy.md` dan `04_Technology/P14-Deployment-Diagram.png`.

## K-GATE2 — Paket Gate 2

**Pemilik:** Hanan. **Branch:** `docs/ceo-gate2`. **Reviewer:** Mahesa.

- [ ] ADR-001 diberi baris persetujuan CEO bertanggal.
- [ ] CR Kartu Kejutan diisi lengkap: permintaan, dampak, keputusan, komunikasi.
- [ ] Bukti demo dua fitur dari database nyata.
- [ ] Ringkasan Gate 2: apa yang bisa dan belum bisa didemokan.

**Bukti:** `07_Evidence/P14-Gate-2.md`.

## K-M3 — Persetujuan sewa

**Pemilik:** Fazha. **Branch:** `feature/programmer-m3-booking`. **Reviewer:** Fharel.

- [x] Pengajuan sewa tersimpan dengan snapshot harga.
- [x] Setujui dan tolak mengubah status berurutan, tercatat di `booking_status_histories`.
- [x] Tolak mewajibkan alasan.
- [x] Notifikasi minimal tercatat di tabel.
- [x] Test transisi status: tidak boleh melompat.
- [x] Kunci baris item saat booking dibuat (dipindah dari K-M2).

**Status:** Menunggu review. Bukti: `07_Evidence/P14-M3-Run.md`, 12 tes lulus (40 assertion), total suite 51 lulus (172 assertion), plus uji peramban dua akun.

## K-M4 — Foto kondisi serah terima

**Pemilik:** Fazha. **Branch:** `feature/programmer-m4-handover`. **Reviewer:** Mahesa.

- [x] Handover OUT dan RETURN, foto wajib (kontrak sudah multipart).
- [x] Konfirmasi dua pihak.
- [x] Status booking berubah sesuai aturan, termasuk catatan keterlambatan.
- [x] Test: permintaan tanpa foto ditolak 422.
- [x] Tombol selesaikan transaksi setelah RETURNED, deposit simulasi dikembalikan.

**Status:** Menunggu review. Bukti: `07_Evidence/P14-M4-Run.md`, 15 tes lulus, total suite 66 lulus (207 assertion).

## K-DB — Prosedur transaksi dan backup

**Pemilik:** Fazha. **Branch:** `feature/database-transactions`. **Reviewer:** Mahesa.

- [ ] Prosedur atau transaksi perubahan status booking.
- [ ] Skrip backup dan perintah restore.
- [ ] Uji restore ke database baru, catat durasi.
- [ ] Hasil ditulis apa adanya.

**Bukti:** `07_Evidence/P15-Restore-Test.md`.

## K-TCO — Biaya infrastruktur 12 bulan

**Pemilik:** Mahesa. **Branch:** `docs/network-tco`. **Reviewer:** Hanan.

- [ ] Komponen biaya: VPS, domain, Cloudflare, monitoring, penyimpanan.
- [ ] Setiap angka punya sumber dan tanggal.
- [ ] Komponen belum pasti ditandai belum diverifikasi.
- [ ] Total 12 bulan dengan skenario hemat dan aman.

**Bukti:** `04_Technology/P15-TCO.md`.

## K-GAP — Gap analysis per domain

**Pemilik:** Hanan. **Branch:** `docs/ceo-gap-analysis`. **Reviewer:** Fazha.

- [ ] Gap bisnis, data, aplikasi, teknologi.
- [ ] Setiap gap punya dampak dan tindakan.
- [ ] Tidak ada gap yang ditutup dengan asumsi.

**Bukti:** `05_Opportunities/P15-Gap-Analysis.md`.

## K-UAT — Finalisasi skenario UAT dan SUS

**Pemilik:** Fharel. **Branch:** `docs/analyst-uat`. **Reviewer:** Hanan.

- [ ] Skenario tugas disesuaikan dengan fitur yang benar-benar ada.
- [ ] Kuesioner SUS 10 butir final.
- [ ] Rencana peserta: mitra atau minimal tiga pengguna proksi.
- [ ] Cara mencatat bukti: waktu, kesalahan, komentar, foto.

**Bukti:** `07_Evidence/P15-UAT-Plan.md` versi final.

## Catatan

- P14 dianggap siap Gate 2 hanya bila K-M1, K-M2, K-TEST, K-STG, dan K-GATE2 selesai.
- PR sebelum P15 mencakup K-M3, K-M4, K-DB, K-TCO, K-GAP, dan K-UAT.
- Status gate tetap milik dosen. Papan ini hanya mencatat pekerjaan.
