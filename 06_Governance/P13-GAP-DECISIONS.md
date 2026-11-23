# Gap, Konflik, dan Catatan Keputusan — SewaKampus P13

**Status:** Ada. Dokumen kerja analisis.
**Tanggal:** 23 November 2026 (diperbarui setelah langkah 1–4 Session 2)
**Keputusan resmi:** `SEWAKAMPUS/DECISIONS.md` (SK-001 sampai SK-019). File itu yang menang jika berbeda dengan catatan di sini.

File ini menjawab tiga hal: apa yang belum tertutup, di mana dokumen saling bertentangan, dan keputusan mana yang mengubah pekerjaan.

## Keputusan yang mengubah pekerjaan

Ringkasan efek keputusan resmi. Isi lengkap, alasan, dan pemilik ada di `DECISIONS.md`.

| Keputusan | Efek langsung ke pekerjaan |
|---|---|
| SK-001, SK-002 | Backlog hanya punya lima Must; KTM, deposit, dan serah terima masuk Should |
| SK-003 | P14 menargetkan listing dan kalender, bukan booking |
| SK-004 | Lima domain terisi oleh empat orang; Hanan memegang Analyst/UI/UX formal |
| SK-005 | Repo hanya lokal; P13-10 dan P16-03 belum bisa selesai |
| SK-007 | UAT memakai pengguna proksi bila mitra tidak ada |
| SK-008 | Prototipe harus clickable |
| SK-009 | ERD 14 entitas belum boleh disebut 3NF final |
| SK-010 | Diagram Phase D harus diperiksa, bukan disalin |
| SK-011 | Roadmap lama tidak dipakai sebagai jadwal sprint |
| SK-012 | Tiga KPI adalah target, bukan capaian |
| SK-013 | Gate 1 belum boleh disebut hijau |
| SK-014 | Foto kondisi wajib lewat multipart pada handover |
| SK-015 | Kontrak API kanonik ada di repo, bukan di `DESAIN/` |
| SK-016 | Seed minimal 30 baris untuk `users` dan `items`, bukan untuk kategori |
| SK-017 | Layar memakai ID S-01 sampai S-09; wireframe menyusul |
| SK-018 | PRD dan TRD berstatus draf dan tidak membekukan keputusan sebelum Gate 1 dinilai |

## Gap yang belum tertutup

| # | Gap | Bukti | Pemilik | Akibat jika dibiarkan |
|---|---|---|---|---|
| G-03 | Wireframe dan prototipe belum ada; kolom layar di traceability masih rencana | tidak ada file | Fharel | Butir internal nomor 7 dan 8 belum siap |
| G-04 | Bukti 3NF sudah ditulis, tetapi DDL dan seed belum dijalankan di database kosong | `02_Data/P13-3NF-Proof.md`, `08_Source/database/sql/` | Fazha | Skema belum terbukti bisa dibuat; PR14-04 belum selesai |
| G-05 | Topologi as-is lokasi mitra belum ada; NFR dan security baseline sudah ditulis | `04_Technology/P13-NFR.md`, `04_Technology/P13-Security-Baseline.md` | Mahesa | P13-11 tetap sebagian |
| G-06 | Notulen stand-up P13 belum ada | tidak ada file | Mahesa | P13-12 belum |
| G-07 | Mitra UAT dan jadwalnya belum dikonfirmasi | belum ada balasan | Hanan | PR14-01 belum |
| G-08 | Team Charter belum ditandatangani | `P13-Team-Charter.md` kolom tanda tangan kosong | Hanan | Butir internal nomor 11 belum siap |
| G-09 | Tidak ada commit per anggota | commit memakai identitas tim | semua | Butir "kartu atau commit" baru terpenuhi lewat kartu |
| G-10 | Kontrak API belum punya endpoint bagi pengguna untuk membuka sengketa | `03_Application/openapi.yaml` hanya memuat `/admin/disputes` | Fazha | UC-07 langkah 1 belum bisa dijalankan lewat API |
| G-17 | Layar verifikasi KTM (S-08) dan sengketa (S-09) belum digambar; "Masuk" muncul di Flow tanpa layar | `ux/exports/WF-flow.png`, `ux/P13-06-Wireframe.md` | Fharel | UC-06 dan UC-07 tidak punya bukti tampilan |
| G-18 | Seed tidak bisa memperagakan aturan status: satu riwayat per booking, `disputes` dan `audit_logs` kosong | `08_Source/database/sql/seed.sql` | Fazha | Demo P14 tidak bisa menunjukkan transisi status dan alur sengketa |
| G-20 | UC-06 menulis akun `REJECTED`, sedangkan `users.account_status` hanya `PENDING_VERIFICATION`/`ACTIVE`/`SUSPENDED` | `01_Business/P13-Use-Cases.md` UC-06 vs `001_init.sql` | Fharel, Fazha | Teks use case dan skema berbeda saat ditanya dosen data |

**Gap yang sudah tertutup:**

| # | Gap | Penutup | Bukti |
|---|---|---|---|
| G-01 | Request handover tidak menerima foto | SK-014 | `03_Application/openapi.yaml` memakai `multipart/form-data` dengan `photo` wajib |
| G-02 | BPMN to-be masih satu alur gabungan; dua proses utama belum dipisah | Dua diagram dipisah dan diperiksa 23 November 2026 | `01_Business/P13-BPMN-To-Be-Booking.drawio` + `.png`, `01_Business/P13-BPMN-To-Be-Handover.drawio` + `.png` |
| G-11 | Harga dua opsi hosting belum ada sumbernya | Harga publik diambil 23 November 2026 dengan URL dan tanggal; angka yang tidak bisa dipastikan ditandai belum diverifikasi | `04_Technology/P13-Hosting-Options.md` |
| G-19 | ERD tidak menggambar relasi `BookingStatusHistory → User` dan `Dispute → User` yang ada di DDL | ERD baru digambar di dalam repo dengan 17 relasi, lengkap dengan pemeriksaan per use case | `02_Data/P13-ERD.drawio` + `.png`, `02_Data/P13-ERD-Use-Case-Check.md` |
| G-16 | Form listing tidak memuat kondisi, deposit, dan kategori terstruktur | Session desain menambahkan dropdown Kategori, dropdown Kondisi, dan field Deposit pada wireframe dan hi-fi; ekspor ulang 24 November 2026 | `03_Application/ux/exports/WF-01-buat-listing.png`, `03_Application/ux/exports/L-01-buat-listing.png` |
| G-12 | Tiga angka rekap berbeda: audit 0 Ada/13 Sebagian/21 Belum/1 Belum diverifikasi, `CONTEXT-PACK` 0/18/17, matriks 3/17/15 | Audit ditandai snapshot dan diberi tabel delta; `CONTEXT-PACK` dan `P13-STATUS` menunjuk matriks; P15-01 dikoreksi menjadi Belum sehingga rekap 3/16/16 | `06_Governance/P13-ASSET-AUDIT.md` §Status dokumen, `SEWAKAMPUS/CONTEXT-PACK.md` §6 |
| G-13 | `main` dan `dev` tidak berada di commit yang sama | `dev` di-fast-forward ke `main` secara lokal | `SEWAKAMPUS/P13-STATUS.md` §3 dan `07_Evidence/P13-Work-Board.md` catatan |
| G-14 | Checklist Gate 1 menyebut use case dan NFR "belum ada" padahal file sudah ada | Baris 3, 7, 9, dan 10 diperbarui; status tetap Bersyarat | `06_Governance/P13-Gate-1-Checklist.md` |
| G-15 | Path bukti "Ada" ditulis singkat (`P13-User-Stories.md`) sehingga tidak bisa dibuka apa adanya | Path dilengkapi menjadi `ARCHITECTURE_REPOSITORY/...` | `SEWAKAMPUS/P13-DELIVERABLE-MATRIX.md` |

G-12 sampai G-15 ditutup pada rekonsiliasi 23 November 2026 dengan bukti file atau commit, bukan dengan asumsi.
G-02 dan G-11 ditutup pada 23 November 2026 melalui commit `55e9fca`. G-06 tetap terbuka: file `07_Evidence/P13-Standup-Minutes.md` baru menyiapkan format, dan belum ada rapat yang benar-benar terjadi.

## Konflik dokumen

| Konflik | Sumber A | Sumber B | Penyelesaian |
|---|---|---|---|
| Jumlah fitur MVP | Ringkasan lama menandai delapan fitur sebagai MVP | TXT hlm. 7: maksimal lima Must | SK-001 dan SK-002; ringkasan lama perlu diperbarui |
| Satuan waktu roadmap | Laporan §4.2 menyebut lima minggu | Gambar roadmap memakai M1–M6 | SK-011 |
| Pasangan Must untuk P14 | Handoff lama: "listing dan booking" | TXT: booking bukan nama Must | SK-003 |
| Foto kondisi di API | TXT hlm. 26 menuntut foto saat serah terima dan pengembalian | Kontrak lama tidak punya field foto | Selesai: handover memakai multipart dengan `photo` wajib (SK-014) |
| Nama file peta aset | Handoff menulis `P13-Asset-Map.md` | Repo memakai `P13-ASSET-MAP.md` | Diikuti nama repo; tidak material |
| Waktu pembuatan PRD/TRD | §6.1: "jangan membuat PRD atau TRD sebelum Gate 1" | §8 Session 2: PRD dan TRD adalah output Session 2, dan Gate 1 baru dinilai setelah Session 2 selesai | PRD dan TRD dibuat sebagai **draf** pada Session 2 sesuai §8; statusnya draf dan tidak dipakai membekukan keputusan sampai dosen menilai Gate 1. Dicatat sebagai SK-018 |
| Alat prototipe | TXT hlm. 15: "Prototipe Figma hi-fi yang bisa diklik" | Tidak ada akses Figma; FigCraft tersedia dan mendukung interaksi prototipe | SK-019: prototipe dibuat di FigCraft dan tidak disebut Figma. Risiko dosen menuntut Figma dicatat terbuka, bukan disembunyikan |
| Jumlah lane BPMN to-be | `P13-STATUS.md` §5 langkah 1: "dua lane (penyewa, pemilik)" | `DESAIN/REFERENSI VISUAL.md`: tiga lane (penyewa, pemilik, admin/sistem) | Dua lane dipakai untuk kedua diagram proses baru, karena UC-03 dan UC-04 hanya melibatkan penyewa dan pemilik. Admin masuk lewat cabang sengketa ke UC-07, bukan sebagai lane. Perbedaan gaya ini disengaja dan dicatat, bukan keputusan resmi baru. |
| Nomor ADR | `P13-STATUS.md` §5 menetapkan path `ADR-002-application-structure.md` | Belum ada ADR-001 (tech stack, bagian P14-01) | Path diikuti apa adanya; ADR-002 menyatakan bahwa ADR-001 menyusul pada P14 agar nomor tidak bertabrakan. ADR-001 tidak dibuat palsu untuk mengisi nomor. |
| Ikon task BPMN | `DESAIN/REFERENSI VISUAL.md`: user task dengan ikon orang, service task dengan roda gigi | Bentuk BPMN bawaan draw.io merender ikon itu membesar dan keluar kotak pada ukuran task 150×64 | Ikon dihilangkan; jenis task dijelaskan lewat label teks. Skema warna task/start/end/gateway tetap mengikuti REFERENSI VISUAL. |
| Definisi S-02 | `01_Business/P13-Use-Cases.md`: S-02 "Daftar listing saya" | `03_Application/ux/P13-06-Wireframe.md` dan prototipe: layar kedua adalah Katalog, tanpa layar daftar listing | S-02 ditetapkan sebagai **Katalog** dengan state "Milik saya" lewat CR-001; tiga dokumen diselaraskan. SK-017 tidak berubah karena rentang ID tetap S-01–S-09. |
| Penomoran layar di artefak desain | Anotasi `WF-02` sampai `WF-07` bertulis 01 sampai 06; `L-06` bertulis "LANGKAH 3" | Flow, `DESIGN.md`, dan traceability memakai urutan 01 sampai 07 dengan serah terima di langkah 6 | Artefak desain yang salah, bukan Flow. Perbaikan dijadwalkan di session desain; sampai itu terjadi, urutan resmi mengikuti `DESIGN.md` §6. |
| Grid kalender November 2026 | `WF-03` menampilkan 1–30 mulai hari Minggu | `L-03` menampilkan 2–30 mulai hari Minggu | 1 November 2026 jatuh hari Minggu, jadi `WF-03` benar dan grid hi-fi kehilangan tanggal 1. Diperbaiki di session desain. |

## Catatan

- Gap G-02 sampai G-11 tidak boleh ditutup dengan asumsi. Setiap penutupan butuh file atau keputusan baru.
- Konflik baru dicatat di sini lebih dulu, lalu keputusannya dipindahkan ke `DECISIONS.md`.
