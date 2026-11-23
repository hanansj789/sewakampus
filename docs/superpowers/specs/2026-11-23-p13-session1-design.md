# Desain Session 1 P13 SewaKampus

**Status:** untuk ditinjau pemilik; belum memberi izin implementasi.  
**Dasar:** `PROYEK/GROWPATH/Skenario_Project ASP R001.txt` lebih tinggi daripada laporan lama dan `PROYEK/SEWAKAMPUS/HANDOFF-PROMPT-P13-P16.md`. Audit faktual ada di `06_Governance/P13-ASSET-AUDIT.md`.

## Tujuan

Menyiapkan fondasi P13 SewaKampus dari aset Phase A–F yang sudah ada, tanpa menyatakan aplikasi atau Gate 1 selesai. Hasil Session 1 harus memberi empat anggota peta pekerjaan yang bisa diperiksa, lima Must yang tegas, dan titik mulai yang jelas untuk Session 2. Seluruh pekerjaan tetap lokal. Tidak ada push, pull request, akun GitHub, atau kode fitur aplikasi pada sesi ini.

## Pendekatan yang dipilih

1. **Bukti dan keputusan dahulu, lalu Git lokal (dipilih).** Audit 35 butir menjadi rujukan; catat jawaban pemilik; susun Vision, MoSCoW, kepemilikan artefak dan mapping; buat fondasi Git lokal serta work board; terakhir isi checklist Gate 1. Urutan ini mengurangi risiko menyiapkan repo untuk keputusan yang masih berubah.
2. **Git dan work board dahulu.** Jejak kerja muncul lebih awal, tetapi kartu dan struktur perlu diubah jika keputusan Vision berubah. Tidak dipilih.

Pekerjaan semua deliverable P13 dan PR sebelum P14 **bukan** satu tugas dalam Session 1. Sesi berikutnya melanjutkan artefak teknis, prototipe, DDL, dan aplikasi lokal. Sebuah prompt handoff tetap menjadi salah satu output Session 1, bukan pengganti artefak utama.

## Scope dan batas

- **Masuk Session 1:** cek audit terhadap TXT, catatan keputusan/gap, klasifikasi dan mapping aset, Vision v1.0 yang ditandai menunggu persetujuan, backlog MoSCoW, Definition of Done, draf Team Charter, pembagian pemilik/reviewer, traceability awal, folder 00–09, Git lokal, work board, checklist Gate 1, matriks 35 butir, dan handoff Session 2.
- **Di luar Session 1:** membuat ulang BPMN, ERD, prototipe, DDL, seed, login, staging, UAT, biaya hosting, serta menulis ulang laporan Progres 12. Tidak ada GitHub remote/push.
- **Anti-target:** tidak membuat tanda tangan, nama mitra, akun GitHub, hasil KPI, hasil UAT, nilai SUS, atau status gate yang belum punya bukti. Tidak memindahkan atau mengubah `LAPORAN/`, `LAPORAN/VERSI/`, dan `ARSIP/`.

## Keputusan produk dan peran

Lima Must resmi dari TXT hlm. 7 adalah **listing barang, kalender ketersediaan, persetujuan sewa, foto kondisi, dan rating**. Verifikasi KTM, deposit simulasi, serta handover–return masuk sebagai kontrol dan langkah proses, bukan Must keenam. Pengguna sudah menyetujui interpretasi ini, tetapi persetujuan tim/mitra belum terbukti. Untuk P14, dua Must pertama yang ditargetkan berjalan di basis data nyata adalah **listing dan kalender ketersediaan**. Target itu belum berarti aplikasinya sudah ada.

| Anggota menurut cover laporan | Peran yang disepakati | Tanggung jawab Session 1 |
|---|---|---|
| Hanan Rizqullah | CEO/PO, merangkap penanggung jawab formal Analyst/UI/UX sesuai TXT hlm. 6 | Vision, MoSCoW, DoD, charter, keputusan bisnis dan persetujuan lintas domain |
| Fharel Sapvela Dwipa | pelaksana Analyst/UI/UX di bawah tanggung jawab Hanan | definisi alur, use case dan prototipe untuk sesi berikutnya; review Vision |
| Muhammad Fazha Nararya Nugraha | Programmer sekaligus Database Architect | telaah struktur aplikasi, OpenAPI, 14 entitas dan rencana pembuktian 3NF |
| Mahesa Kanaka Raya | Network/DevOps sekaligus QA dan notulis P13 | topologi/NFR dan catatan rapat; review risiko teknis |

Penetapan peran dalam dokumen bukan bukti bahwa anggota sudah mengerjakan atau menyetujui artefaknya. Setiap artefak yang diajukan untuk review memiliki penyusun dan reviewer berbeda; identitas ini ditulis sebagai **rencana review** sampai pemeriksaan benar-benar dilakukan.

## KPI Vision yang diusulkan, bukan hasil lapangan

TXT hlm. 15 meminta tiga KPI. Target berikut menjadi usulan yang harus Hanan setujui bersama tim sebelum Vision dibekukan. Persetujuan pengguna pada dokumen desain berarti setuju untuk **mencatatnya sebagai usulan**, bukan tanda tangan atas nama Hanan:

1. **Kelengkapan listing:** paling sedikit 90% listing dalam pilot memiliki foto, kategori, harga, dan tanggal ketersediaan. Ukur dari jumlah listing yang memenuhi empat unsur dibagi seluruh listing pilot.
2. **Kecepatan persetujuan:** paling sedikit 80% pengajuan sewa pilot mendapat keputusan pemilik dalam 24 jam. Ukur dari `BookingStatusHistory` atau catatan waktu status.
3. **Bukti kondisi transaksi:** paling sedikit 90% transaksi sewa yang selesai memiliki foto kondisi saat diserahkan dan dikembalikan, serta satu rating. Ukur dari handover OUT/RETURN dan review yang terhubung ke booking.

Angka 90%, 80%, dan 24 jam adalah **target perencanaan**, bukan temuan mitra atau hasil UAT. Jika Hanan tidak menyetujui salah satunya, Vision tetap draf dan checklist Gate 1 menandai butir itu belum siap.

## Ketelusuran dan penanganan aset lama

Laporan Progres 12 dipakai sebagai baseline, bukan disalin ke repository. `P13-Asset-Map.md` menunjuk bagian laporan dan aset desain untuk setiap deliverable. Setiap status harus menyebut path yang benar-benar ada. Target path tidak dihitung sebagai bukti.

Traceability awal memakai lima baris, satu per Must, dengan kolom masalah → kebutuhan → use case → tabel → layar → endpoint → status verifikasi. Penamaan use case/layar yang belum ada ditulis **Belum**; tidak mengarang diagram atau tampilan. Gate 1 menuntut matriks minimal lima baris yang betul-betul tersambung; baris yang masih Belum membuat gate tetap bersyarat.

ERD 14 entitas dipertahankan sebagai **baseline pemeriksaan**, bukan langsung dinyatakan 3NF final. Foto kondisi pada OUT dan RETURN harus terbaca di BPMN, data model, dan API; kontrak saat ini belum menerima foto melalui `HandoverCreateRequest`. Dua BPMN target untuk booking dan handover–return dijadwalkan pada Session 2. Diagram Phase D dan stack infrastruktur dipakai hanya setelah dicek terhadap permintaan TXT tentang topologi as-is di lokasi mitra, NFR, dan keamanan. Roadmap lima minggu/M1–M6 dianggap historis dan harus diselaraskan dengan gate P13–P16, bukan dipakai sebagai jadwal sprint final.

## Fondasi lokal dan bukti kontribusi

`ARCHITECTURE_REPOSITORY/` ditata ke folder `00_Vision` sampai `09_Pitch`, dengan README dan CONTRIBUTING yang menjelaskan sumber aturan, struktur, serta cara kerja lokal. `git init -b main` dilakukan **tanpa remote**. Work board lokal berisi empat kartu atas nama anggota, status nyata, dan path bukti. Tidak ada commit atas nama anggota yang tidak hadir. Branch `dev` dan `feature/*` dibuat setelah anggota yang bersangkutan membuat commit pertama dengan identitas Git yang benar; bila belum, checklist menulis Belum.

Satu laptop dapat dipakai bergantian saat fase GitHub nanti. Sebelum tiap commit, periksa `git config user.name` dan `user.email` yang terverifikasi pada akun orang itu. Sebelum push, cek `gh auth status --active`, pilih akun dengan `gh auth switch --user ...`, dan periksa izin repo. Pengaturan author commit dan akun autentikasi push berbeda; tidak membagikan token dan tidak menganggap commit yang dibuat orang lain sebagai kontribusi anggota. Instruksi ini dicatat sebagai prosedur masa depan, **tidak dijalankan** pada Session 1.

## Mitra, Gate 1, dan batas status

Mitra belum dikonfirmasi. Session 1 menyimpan rencana permintaan konfirmasi dan cadangan UAT minimal tiga pengguna proksi yang profilnya relevan. Tidak membuat surat balasan atau laporan UAT fiktif.

Checklist Gate 1 mencatat bukti untuk Vision, traceability, ERD 3NF, MoSCoW, repo/work board, dan kartu atau commit setiap anggota. Status internal boleh **siap diajukan**, **bersyarat**, atau **belum siap**. Status resmi **Hijau/Kuning/Merah hanya diisi setelah dosen menilai** sesuai TXT hlm. 17. Belum ada persetujuan dosen; istilah “freeze” pada Session 1 berarti baseline keputusan internal yang terdokumentasi, bukan kelulusan gate.

## Output dan pemeriksaan

- `06_Governance/P13-ASSET-AUDIT.md` sebagai audit faktual, lalu `06_Governance/P13-GAP-DECISIONS.md` yang mencatat keputusan pengguna dan bagian yang masih terbuka.
- `00_Vision/P13-Vision-v1.0.md`, `00_Vision/P13-MoSCoW-Backlog.md`.
- `06_Governance/P13-Definition-of-Done.md`, `P13-Team-Charter.md`, `P13-Asset-Map.md`, `P13-Traceability-Matrix.md`, `P13-Gate-1-Checklist.md`.
- `07_Evidence/P13-Work-Board.md`, `SEWAKAMPUS/P13-DELIVERABLE-MATRIX.md`, README/CONTRIBUTING lokal, serta `06_Governance/P13-SESSION1-HANDOFF.md` yang memuat prompt Session 2.
- Perbarui `SEWAKAMPUS/00 - KONTEKS PROYEK.md` setelah keputusan benar-benar dibuat. Jangan mengubah laporan lama atau menduplikasi 44 halaman di repo.

Verifikasi akhir menghitung 35 ID unik, memastikan setiap klaim Ada memiliki path terbuka, mencocokkan lima Must dan empat nama ke TXT/cover, memeriksa tautan relatif, serta memeriksa keadaan Git lokal tanpa remote. Daftarkan kekurangan apa adanya. Session 1 berhenti dengan checklist yang jujur, meskipun masih bersyarat.
