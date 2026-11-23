# SewaKampus FigCraft Prototype Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membuat prototipe hi-fi SewaKampus yang dapat diklik untuk S-01 sampai S-09 pada mobile dan desktop, kemudian menghasilkan bukti PNG, PDF, test case, rencana UAT, dan traceability.

**Architecture:** Satu dokumen FigCraft memisahkan foundations, empat alur mobile, empat alur desktop, serta state dan prototype. Token, text style, paint style, dan komponen dibuat lebih dulu. Delapan belas frame utama memakai instance komponen yang sama dan interaksi lintas page.

**Tech Stack:** FigCraft MCP, Context7 `/storytold/figcraft`, Markdown, PNG, PDF.

**Spec:** `ARCHITECTURE_REPOSITORY/03_Application/ux/DESIGN.md`

## Global Constraints

- Gunakan FigCraft, bukan Figma. Ekspor `.fig` eksperimental bukan bukti utama.
- Jangan menulis kode aplikasi sebelum Gate 1 dinilai.
- Jangan menambah fitur di luar M1 sampai M5.
- Buat S-01 sampai S-09 pada 390 × 844 dan 1440 × 900.
- Tema terang memakai token dan text style dari `DESIGN.md`.
- Kontras teks normal minimum 4,5:1 dan target sentuh minimum 44 × 44 px.
- Gunakan istilah penyewa, pemilik, admin, "Ajukan sewa", "Setujui", dan "Tolak".
- KTM, NIM, lokasi rinci, dan foto kondisi mengikuti aturan privasi pada `DESIGN.md`.
- Jangan mengarang nama responden, skor SUS, hasil UAT, statistik, identitas, atau kebijakan retensi KTM.
- Jangan menyalin kode atau aset dari Growlio maupun contoh Growpath.
- Jangan mengubah `LAPORAN/`, `LAPORAN/VERSI/`, atau `ARSIP/`.
- Setiap klaim Ada harus memiliki file yang dapat dibuka. Setiap klaim Selesai memerlukan bukti uji atau review.

## Review Focus

- Koneksi lemah saat unggah foto harus menampilkan progres, kegagalan, "Coba lagi", dan "Batalkan" tanpa menghilangkan data form.
- Rentang tanggal bertabrakan harus ditolak sebelum pengajuan, dengan label dan pola selain warna.
- Pengguna belum terverifikasi harus memperoleh penjelasan dan jalur menuju status verifikasi, bukan tombol mati tanpa alasan.
- S-06 harus membedakan OUT dan RETURN, mewajibkan foto pada keduanya, serta membuka sengketa ketika kondisi berbeda.
- Data privat harus tetap dimasking dan hanya terlihat oleh peran yang memerlukan pada mobile maupun desktop.

---

### Task 1: Siapkan dokumen, page, token, style, dan komponen

**Files:**
- Create: `ARCHITECTURE_REPOSITORY/03_Application/ux/SewaKampus-High-Fidelity.figcraft`
- Reference: `ARCHITECTURE_REPOSITORY/03_Application/ux/DESIGN.md`

**Interfaces:**
- Consumes: token, text style, paint style, page map, dan component naming dari `DESIGN.md`.
- Produces: dokumen FigCraft dengan collection `SewaKampus / Core`, sepuluh page, styles, serta komponen yang dipakai Task 2 dan Task 3.

- [ ] **Step 1: Mulai session FigCraft dan baca drawing guide**

Panggil `start_session`. Catat aturan layout, routing, naming, dan verifikasi yang dikembalikan. Jangan membuat layer sebelum guide terbaca.

- [ ] **Step 2: Verifikasi command FigCraft yang akan dipakai**

Gunakan Context7 `/storytold/figcraft` dan `figcraft.list_commands` untuk `variable`, `style`, `component`, `page`, dan `proto`. Command minimum yang harus tersedia adalah `variable.createCollection`, `variable.create`, `style.create`, `component.create`, `component.combineVariants`, `instance.create`, `page.add`, `proto.interaction.add`, `proto.flow.add`, dan `proto.preview`.

Expected: seluruh command ditemukan dengan parameter yang sesuai dokumentasi saat eksekusi.

- [ ] **Step 3: Buat sepuluh page**

Gunakan `page.add` untuk membuat page 00 sampai 09 sesuai §6 `DESIGN.md`.

Expected: `inspect_document {allPages:true}` menampilkan tepat sepuluh page SewaKampus dengan nama yang ditentukan.

- [ ] **Step 4: Buat variable collection dan variables**

Gunakan `variable.createCollection {name:"SewaKampus / Core"}`. Buat seluruh color, spacing, radius, size, dan motion variables pada §17.1 `DESIGN.md` dengan `variable.create`.

Expected: `variable.list` memuat semua token dan nilainya tanpa variable tanpa peran.

- [ ] **Step 5: Buat text style dan paint style**

Gunakan `style.create` untuk sembilan text style dan empat belas paint style pada §17.2 dan §17.3. Bind nilai style ke variables dengan `style.bind` jika field mendukungnya.

Expected: `style.list` memuat seluruh nama style. `text.missingFonts` tidak melaporkan font hilang. Jika font hilang, catat ruling sebelum mengganti font.

- [ ] **Step 6: Buat komponen dan varian**

Buat app bar, bottom navigation, sidebar, button, field, upload foto, kartu barang, kalender, ringkasan biaya, status chip, baris pengajuan, handover checklist, rating, antrean admin, dialog, dan inline feedback. Gunakan `component.create`, `component.addVariant` atau `component.combineVariants`, serta component properties yang relevan.

Expected: `component.list` menampilkan seluruh komponen. `component.playground` pada button, field, upload foto, kalender, dan status chip menghasilkan preview yang sesuai `DESIGN.md`.

- [ ] **Step 7: Inspeksi foundations**

Gunakan `inspect_document`, `get_node`, dan `screenshot` pada page Foundations and Components.

Expected: tidak ada tumpang tindih, style terikat, komponen mempunyai state yang dibutuhkan, dan nama komponen mengikuti pola `<Kategori> / <Nama> / <Varian> / <Viewport>`.

- [ ] **Step 8: Simpan file**

Gunakan `save_file` ke path `.figcraft` yang ditetapkan.

Expected: file dapat dibuka kembali dengan `open_file` tanpa warning kritis.

### Task 2: Bangun sembilan layar mobile

**Files:**
- Modify: `ARCHITECTURE_REPOSITORY/03_Application/ux/SewaKampus-High-Fidelity.figcraft`

**Interfaces:**
- Consumes: components, variables, text styles, dan paint styles dari Task 1.
- Produces: sembilan frame utama mobile 390 × 844 dan state pendukung untuk Task 4.

- [ ] **Step 1: Buat checklist RED mobile**

Catat S-01 sampai S-09 sebagai belum ada. Untuk setiap layar, tulis UC, Must, pertanyaan utama, dan aksi utama dari §5 `DESIGN.md`.

Expected: sembilan entri belum lulus sebelum frame dibuat.

- [ ] **Step 2: Bangun Mobile Listing**

Buat S-01 dan S-02 pada page 01. Gunakan instance komponen. S-01 memuat field wajib dan upload foto. S-02 membedakan aktif, draf, dan dijeda.

Expected: kedua frame 390 × 844, memakai M1 dan UC-01, serta mempunyai satu aksi utama.

- [ ] **Step 3: Bangun Mobile Sewa**

Buat S-03, S-04, dan S-05 pada page 02. Kalender menampilkan tersedia, terisi, diblokir, terpilih, dan bentrok. S-04 memuat rincian biaya. S-05 memuat keputusan dan alasan penolakan.

Expected: ketiga frame 390 × 844, menutup UC-02 dan UC-03, serta memakai istilah copy yang disetujui.

- [ ] **Step 4: Bangun Mobile Handover and Rating**

Buat S-06 dan S-07 pada page 03. S-06 memiliki varian OUT dan RETURN dengan foto wajib, lokasi, catatan, dan konfirmasi kedua pihak. S-07 hanya aktif untuk transaksi selesai.

Expected: kedua frame 390 × 844, menutup M4 dan M5, serta menunjukkan jalur ke sengketa dari kondisi berbeda.

- [ ] **Step 5: Bangun Mobile Admin**

Buat S-08 dan S-09 pada page 04. S-08 memasking NIM dan membatasi KTM. S-09 menyandingkan bukti OUT dan RETURN dengan keputusan sengketa.

Expected: kedua frame 390 × 844. S-08 tercatat sebagai kontrol pendukung M1 dan S-09 sebagai kontrol pendukung M4.

- [ ] **Step 6: Inspeksi seluruh mobile**

Gunakan `inspect_document` dan `screenshot` untuk setiap frame.

Expected: sembilan frame berukuran tepat 390 × 844, margin minimum 16 px, target minimum 44 px, tidak ada overflow horizontal, dan teks tidak terpotong.

- [ ] **Step 7: Ubah checklist mobile menjadi GREEN**

Tandai layar lulus hanya setelah hasil inspeksi dibaca.

Expected: sembilan dari sembilan layar mobile mempunyai UC, Must, satu aksi utama, dan bukti screenshot FigCraft.

### Task 3: Bangun sembilan layar desktop

**Files:**
- Modify: `ARCHITECTURE_REPOSITORY/03_Application/ux/SewaKampus-High-Fidelity.figcraft`

**Interfaces:**
- Consumes: layar mobile dari Task 2 dan komponen responsif dari Task 1.
- Produces: sembilan frame desktop 1440 × 900 untuk Task 4 dan ekspor Task 6.

- [ ] **Step 1: Buat checklist RED desktop**

Catat S-01 sampai S-09 sebagai belum mempunyai adaptasi desktop.

- [ ] **Step 2: Bangun Desktop Listing**

Buat S-01 dan S-02 pada page 05. Gunakan sidebar 240 px dan area kerja maksimal 1200 px. Form dan daftar memakai ruang tambahan untuk bukti foto dan status, bukan untuk dekorasi.

- [ ] **Step 3: Bangun Desktop Sewa**

Buat S-03, S-04, dan S-05 pada page 06. S-03 menyandingkan media, detail, kalender, dan ringkasan biaya. S-05 mengutamakan daftar yang perlu diputuskan.

- [ ] **Step 4: Bangun Desktop Handover and Rating**

Buat S-06 dan S-07 pada page 07. Bukti kondisi tampil berdampingan bila ruang cukup. Urutan baca tetap sama dengan mobile.

- [ ] **Step 5: Bangun Desktop Admin**

Buat S-08 dan S-09 pada page 08. Desktop memanfaatkan tabel atau list-detail tanpa menampilkan data pribadi tambahan.

- [ ] **Step 6: Inspeksi seluruh desktop**

Gunakan `inspect_document` dan `screenshot` untuk setiap frame.

Expected: sembilan frame berukuran tepat 1440 × 900, sidebar konsisten, area kerja tidak menyisakan dead space, fungsi tetap sama dengan mobile, dan data privat tetap dimasking.

- [ ] **Step 7: Ubah checklist desktop menjadi GREEN**

Expected: sembilan dari sembilan layar desktop mempunyai padanan mobile dengan UC, Must, aksi, dan state yang sama.

### Task 4: Buat state, flow, dan interaksi prototipe

**Files:**
- Modify: `ARCHITECTURE_REPOSITORY/03_Application/ux/SewaKampus-High-Fidelity.figcraft`

**Interfaces:**
- Consumes: 18 frame utama dari Task 2 dan Task 3.
- Produces: state frames, interaksi lintas page, flow mobile dan desktop, serta preview yang dapat diklik.

- [ ] **Step 1: Buat state frames**

Pada page 09, buat form invalid, tanggal bentrok, pengajuan ditolak, unggah gagal, handover menunggu konfirmasi, sengketa terbuka, verifikasi ditolak, loading, dan empty state.

Expected: setiap state menjelaskan sebab dan tindakan berikutnya. Galat tidak hanya memakai warna.

- [ ] **Step 2: Tambahkan flow mobile dan desktop**

Gunakan `proto.flow.add` untuk minimal `SewaKampus / Mobile / Alur utama`, `SewaKampus / Desktop / Alur utama`, `SewaKampus / Mobile / Admin`, dan `SewaKampus / Desktop / Admin`.

- [ ] **Step 3: Tambahkan interaksi utama**

Gunakan `proto.interaction.add`. Hubungkan S-01 ke S-02, S-02 ke S-03, S-03 ke S-04, S-04 ke S-05, S-05 approved ke S-06 OUT, S-06 OUT ke RETURN, S-06 RETURN ke S-07, S-06 mismatch ke S-09, serta S-08 approved ke S-01. Tambahkan back, dialog, reject reason, retry upload, dan close overlay.

Expected: destination node dapat berada pada page berbeda. Gunakan transition instant atau dissolve 150 ms sesuai `DESIGN.md`.

- [ ] **Step 4: Jalankan preview**

Gunakan `proto.preview {start:true}` dari flow mobile, desktop, dan admin.

Expected: semua tombol yang tampak interaktif menjalankan aksi. Tidak ada link mati, target salah, atau state yang tidak dapat ditutup.

- [ ] **Step 5: Inspeksi interaksi**

Gunakan `inspect_document` dengan field `interactions` dan `flows`.

Expected: seluruh frame utama mempunyai jalur maju atau kembali yang masuk akal. Empat flow mempunyai start frame yang benar.

### Task 5: Audit visual, aksesibilitas, copy, dan privasi

**Files:**
- Modify: `ARCHITECTURE_REPOSITORY/03_Application/ux/SewaKampus-High-Fidelity.figcraft`
- Reference: `ARCHITECTURE_REPOSITORY/03_Application/ux/DESIGN.md`

**Interfaces:**
- Consumes: prototipe interaktif Task 4.
- Produces: prototipe yang siap diekspor dan catatan audit untuk dokumentasi Task 7.

- [ ] **Step 1: Audit visual dua viewport**

Periksa screenshot seluruh layar mobile dan desktop dalam satu putaran. Bandingkan hierarchy, spacing, penggunaan accent, serif, radius, dan kepadatan dengan `DESIGN.md`.

Expected: tidak ada gradient, glow, glass, ikon dalam kotak berwarna berulang, statistik fiktif, atau tampilan landing page pada layar transaksi.

- [ ] **Step 2: Audit target dan fokus**

Periksa ukuran setiap kontrol utama melalui `inspect_document` atau `get_node`.

Expected: kontrol sentuh minimum 44 × 44 px. Focus state terlihat dan tidak hanya mengubah warna teks.

- [ ] **Step 3: Audit warna dan copy**

Periksa paint variables dan seluruh teks UI.

Expected: pasangan teks memakai token kontras terukur. Copy konsisten memakai penyewa, pemilik, admin, "Ajukan sewa", "Setujui", dan "Tolak". Tidak ada lorem, emoji, atau klaim tanpa bukti.

- [ ] **Step 4: Audit privasi**

Periksa S-05, S-06, S-08, dan S-09 pada kedua viewport.

Expected: NIM dimasking, KTM admin-only, lokasi rinci hanya sesudah approval, dan foto kondisi hanya untuk pihak transaksi serta admin sengketa.

- [ ] **Step 5: Perbaiki tiga masalah terpenting dan periksa ulang sekali**

Expected: screenshot akhir tidak mempunyai masalah material yang ditemukan pada putaran pertama.

### Task 6: Simpan dan ekspor bukti

**Files:**
- Modify: `ARCHITECTURE_REPOSITORY/03_Application/ux/SewaKampus-High-Fidelity.figcraft`
- Create: `ARCHITECTURE_REPOSITORY/03_Application/ux/exports/S-01-mobile.png` sampai `S-09-mobile.png`
- Create: `ARCHITECTURE_REPOSITORY/03_Application/ux/exports/S-01-desktop.png` sampai `S-09-desktop.png`
- Create: `ARCHITECTURE_REPOSITORY/03_Application/ux/exports/SewaKampus-Prototype-Flow.pdf`

**Interfaces:**
- Consumes: prototipe yang lulus Task 5.
- Produces: file bukti yang dipakai Task 7 dan pembaruan status Task 8.

- [ ] **Step 1: Simpan versi final `.figcraft`**

Gunakan `save_file` dan buka ulang dengan `open_file`.

Expected: dokumen terbuka, sepuluh page ada, dan `dirty:false` setelah penyimpanan.

- [ ] **Step 2: Ekspor 18 PNG**

Gunakan `export {ids:[frameId],format:"png",scale:2,path:"..."}` untuk setiap frame utama.

Expected: 18 PNG mempunyai dimensi dan isi sesuai nama file. Buka setiap file setidaknya sekali.

- [ ] **Step 3: Ekspor satu PDF alur**

Gunakan `export` format PDF pada frame alur atau page yang disiapkan untuk bukti.

Expected: PDF dapat dibuka, urutan layar terbaca, dan tidak memuat source berbayar atau ekspor `.fig` sebagai bukti.

- [ ] **Step 4: Verifikasi file**

Gunakan file reader atau preview pada 18 PNG dan PDF.

Expected: tidak ada file kosong, hitam, terpotong, salah layar, atau gagal dibuka.

### Task 7: Tulis dokumentasi prototipe, test case, dan rencana UAT

**Files:**
- Create: `ARCHITECTURE_REPOSITORY/03_Application/ux/PR14-03-Prototype-FigCraft.md`
- Create: `ARCHITECTURE_REPOSITORY/07_Evidence/P14-Test-Cases.md`
- Create: `ARCHITECTURE_REPOSITORY/07_Evidence/P15-UAT-Plan.md`
- Modify: `ARCHITECTURE_REPOSITORY/06_Governance/P13-Traceability-Matrix.md`

**Interfaces:**
- Consumes: file bukti Task 6, flow Task 4, user story, use case, dan `DESIGN.md`.
- Produces: dokumentasi dan ketelusuran yang dapat direview.

- [ ] **Step 1: Tulis dokumentasi prototipe**

Isi path file, 18 frame, daftar S-01 sampai S-09, peta interaksi, cara membuka preview FigCraft, hasil cek aksesibilitas, dan batasan. Sebut FigCraft, bukan Figma.

- [ ] **Step 2: Tulis 15 test case black-box**

Setiap kasus memuat ID, story, layar, prasyarat, langkah, data uji, hasil yang diharapkan, dan status `Belum dijalankan`. Pastikan US-01 sampai US-08 terwakili.

Expected: tepat 15 ID unik. Setiap test case menautkan minimal satu user story dan satu layar.

- [ ] **Step 3: Tulis rencana UAT**

Isi tugas listing sampai rating, skenario kegagalan penting, SUS 10 butir, cara mencatat waktu, kesalahan, komentar, foto atau rekaman, serta rencana minimal tiga pengguna proksi. Jangan menulis identitas atau hasil.

- [ ] **Step 4: Perbarui traceability**

Hapus label `(rencana)` setelah bukti layar tersedia. Tautkan S-01 sampai S-09 dan catat hasil cek aksesibilitas dengan status jujur.

- [ ] **Step 5: Verifikasi ketelusuran**

Run: gunakan `grep` untuk menghitung `TC-`, `US-`, `S-`, `UC-`, dan `M` pada dokumen terkait, kemudian baca hasilnya.

Expected: 15 test case unik, delapan story terwakili, sembilan layar terwakili, setiap layar mempunyai UC dan Must, serta tidak ada hasil UAT fiktif.

### Task 8: Perbarui status proyek dan handoff

**Files:**
- Modify: `P13-STATUS.md`
- Modify: `P13-DELIVERABLE-MATRIX.md`
- Modify: `ARCHITECTURE_REPOSITORY/07_Evidence/P13-Work-Board.md`
- Modify: `00 - KONTEKS PROYEK.md` jika konteks panjang berubah
- Create: `ARCHITECTURE_REPOSITORY/06_Governance/P13-SESSION3-HANDOFF.md`

**Interfaces:**
- Consumes: seluruh hasil Task 1 sampai Task 7.
- Produces: status dan handoff yang dapat dipakai session berikutnya.

- [ ] **Step 1: Perbarui status hanya dari bukti yang dapat dibuka**

Catat path `.figcraft`, PNG, PDF, dokumentasi prototipe, test case, rencana UAT, dan hasil verifikasi. Jangan menyebut Selesai tanpa review anggota lain.

- [ ] **Step 2: Perbarui matriks deliverable dan work board**

Naikkan status hanya bila definisi status terpenuhi. Pertahankan Gate 1 sebagai belum dinilai dosen.

- [ ] **Step 3: Tulis handoff Session 3**

Catat apa yang ada, apa yang sudah diuji, apa yang belum diverifikasi, keputusan terbuka, dan langkah berikutnya.

- [ ] **Step 4: Verifikasi akhir**

Periksa semua tautan relatif, buka semua bukti, dan pastikan tidak ada perubahan pada `LAPORAN/`, `LAPORAN/VERSI/`, atau `ARSIP/`.

Expected: status setiap artefak jujur, path dapat dibuka, serta tidak ada klaim Hijau, Kuning, atau Merah dari tim.
