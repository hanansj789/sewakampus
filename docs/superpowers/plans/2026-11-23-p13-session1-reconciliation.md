# Rekonsiliasi Session 1 P13 — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Menyelaraskan status, bukti, dan angka pada berkas P13 yang sudah ada, tanpa membuat artefak teknis baru dan tanpa menyatakan Gate 1 lulus.

**Architecture:** Lima berkas status dan governance diperbarui berurutan dari sumber ke turunan: audit → gap/keputusan → context/status/matriks → checklist/papan kerja → Git. Satu skrip pemeriksa di direktori temp menjadi gerbang: gagal sebelum, lulus sesudah.

**Tech Stack:** Markdown, Git lokal, Python 3.12 untuk pemeriksa.

**Spec:** `PROYEK/SEWAKAMPUS/ARCHITECTURE_REPOSITORY/docs/superpowers/specs/2026-11-23-p13-session1-design.md`

## Global Constraints

- Lima Must: listing, kalender ketersediaan, persetujuan sewa, foto kondisi, rating. Tidak ada Must keenam.
- Tidak ada remote, tidak ada push, tidak ada kode aplikasi.
- Status resmi Hijau/Kuning/Merah tetap kosong; hanya status internal.
- Jangan mengubah `LAPORAN/`, `LAPORAN/VERSI/`, `ARSIP/`, dan jangan mengisi tanda tangan.
- Setiap klaim Ada wajib punya path yang bisa dibuka.

## Review Focus

- Angka rekap di tiga berkas harus identik setelah perubahan, bukan hanya "mirip".
- Path bukti yang ditulis harus benar-benar ada, termasuk path baru hasil rekonsiliasi.
- Checklist tidak boleh menaikkan status Gate 1 menjadi siap diajukan.
- Tanggal "terakhir diperbarui" harus mencerminkan pekerjaan ini, bukan tanggal lama.

---

### Task 1: Audit sebagai snapshot + delta

**Files:**
- Modify: `ARCHITECTURE_REPOSITORY/06_Governance/P13-ASSET-AUDIT.md`

**Interfaces:**
- Produces: tabel delta 10 baris yang menjadi rujukan Task 2 dan Task 3.

- [ ] **Step 1: Tambah header snapshot dan tabel delta**
  Sisipkan setelah baris batas pemeriksaan: pernyataan bahwa dokumen ini snapshot akhir Session 1, status terkini ada di matriks, dan tabel delta P13-03, P13-05, P13-08, P13-10, P13-13, P13-14, P13-15, PR14-04, PR14-05, P15-01.
- [ ] **Step 2: Verifikasi**
  Run: `grep -c '^| P' ARCHITECTURE_REPOSITORY/06_Governance/P13-ASSET-AUDIT.md`
  Expected: jumlah baris tabel bertambah, tidak ada baris lama yang hilang.

### Task 2: Log gap dan riwayat keputusan

**Files:**
- Modify: `ARCHITECTURE_REPOSITORY/06_Governance/P13-GAP-DECISIONS.md`
- Modify: `DECISIONS.md`

- [ ] **Step 1: Perbaiki rentang SK dan catat empat gap baru sebagai tertutup** (G-12 rekap, G-13 main/dev, G-14 checklist basi, G-15 audit vs matriks).
- [ ] **Step 2: Tambah baris riwayat v1.2 di `DECISIONS.md`** untuk SK-018, tanpa mengubah isi keputusan.
- [ ] **Step 3: Verifikasi**
  Run: `grep -n 'SK-01[0-8]' ARCHITECTURE_REPOSITORY/06_Governance/P13-GAP-DECISIONS.md`
  Expected: rujukan rentang menyebut SK-018 dan G-12 sampai G-15 muncul.

### Task 3: Satu angka rekap

**Files:**
- Modify: `CONTEXT-PACK.md`
- Modify: `P13-STATUS.md`
- Modify: `P13-DELIVERABLE-MATRIX.md`

- [ ] **Step 1: Ganti rekap di `CONTEXT-PACK.md` §6** menjadi snapshot audit (0/13/21/1) dan status terkini (3/17/15) dengan rujukan matriks.
- [ ] **Step 2: Perbarui `P13-STATUS.md`** bagian 1, 2, 3, 5: commit `1119276`, `dev` di-fast-forward, hasil empat verifikasi, dan langkah berikutnya tetap Session 2.
- [ ] **Step 3: Perbarui tanggal dan catatan verifikasi di matriks.**
- [ ] **Step 4: Verifikasi**
  Run: `grep -n '3 Ada' CONTEXT-PACK.md P13-STATUS.md P13-DELIVERABLE-MATRIX.md`
  Expected: ketiga berkas menyebut 3 Ada menunggu review, 17 Sebagian, 15 Belum.

### Task 4: Checklist dan papan kerja jujur

**Files:**
- Modify: `ARCHITECTURE_REPOSITORY/06_Governance/P13-Gate-1-Checklist.md`
- Modify: `ARCHITECTURE_REPOSITORY/07_Evidence/P13-Work-Board.md`

- [ ] **Step 1: Perbarui baris 3, 7, 9, 10, 13 checklist** dengan bukti yang sekarang ada; status tetap Bersyarat/Belum siap.
- [ ] **Step 2: Perbarui kesimpulan §C dan urutan §D** agar tidak menyebut artefak yang sudah ada sebagai "belum ditulis".
- [ ] **Step 3: Perbarui papan kerja** dengan tanggal dan catatan tiga butir "Ada, menunggu review".
- [ ] **Step 4: Verifikasi**
  Run: `grep -n 'Bersyarat\\|Belum siap' ARCHITECTURE_REPOSITORY/06_Governance/P13-Gate-1-Checklist.md`
  Expected: tidak ada baris berstatus "Siap diajukan" untuk butir yang belum direview; kolom status dosen tetap kosong.

### Task 5: Git dan pemeriksaan akhir

- [ ] **Step 1: Fast-forward `dev` ke `main`** (lokal, tanpa push).
- [ ] **Step 2: Jalankan pemeriksa** `p13_check.py`: 35 ID unik, path Ada, lima Must, empat nama, rekap seragam, HEAD konsisten, `dev == main`.
- [ ] **Step 3: Commit** di `main`, lalu samakan `dev`.
