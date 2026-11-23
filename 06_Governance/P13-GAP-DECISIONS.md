# Keputusan dan Gap P13 — SewaKampus

**Status:** Ada. Berisi keputusan yang disetujui pemilik proyek pada 23 November 2026 dan butir yang masih terbuka.
**Dasar:** audit di `P13-ASSET-AUDIT.md`, desain `docs/superpowers/specs/2026-11-23-p13-session1-design.md`, `Skenario_Project ASP R001.txt`.

Aturan: keputusan di bawah tidak diubah diam-diam. Perubahan wajib lewat Change Request di `CHANGE-REQUEST-LOG.md` dan dicatat ulang di sini.

## Keputusan yang sudah disetujui

| ID | Keputusan | Alasan | Dampak |
|---|---|---|---|
| SK-001 | Lima Must = listing, kalender ketersediaan, persetujuan sewa, foto kondisi, rating | TXT hlm. 7 menetapkan daftar itu untuk kelompok 1 | Backlog, traceability, dan ERD mengikuti lima nama ini; Must keenam ditolak |
| SK-002 | Verifikasi KTM, deposit simulasi, dan serah terima bukan Must tambahan, melainkan kontrol di dalam alur booking dan handover | TXT hlm. 7 membatasi Must maksimal lima; handoff §1 memakai pembacaan yang sama | Ketiganya masuk Should dan tetap wajib dibangun karena menopang M3 dan M4 |
| SK-003 | Dua Must pertama untuk P14 = listing dan kalender ketersediaan | Satu alur, bisa diuji tanpa membangun seluruh transaksi | Target P14 di roadmap memakai pasangan ini, bukan "listing dan booking" |
| SK-004 | Peran: Hanan CEO/PO sekaligus pemegang formal System Analyst dan UI/UX; Fharel pelaksana Analyst/UI/UX; Fazha Programmer sekaligus Database Architect; Mahesa Network/DevOps sekaligus QA dan notulis P13 | TXT hlm. 6 mewajibkan CEO merangkap Analyst/UI/UX untuk kelompok empat orang; lima domain harus terisi | Pembagian kerja dan reviewer mengikuti tabel di Team Charter |
| SK-005 | Pekerjaan P13 dan PR sebelum P14 diselesaikan lokal; tidak ada remote GitHub, akun, token, atau push pada Session 1 | Pemilik ingin progres lokal dulu; akun per anggota baru dipakai saat fase GitHub | `P13-10` dan `P16-03` berstatus belum; CODEOWNERS ditunda |
| SK-006 | Satu laptop boleh dipakai bergantian oleh empat akun GitHub nanti | Pemilik menanyakan kelayakannya; `gh auth switch` mendukung ini | Identitas commit dan akun push diperiksa terpisah sebelum setiap push |
| SK-007 | Mitra UAT belum ada; disiapkan rencana minimal tiga pengguna proksi, konfirmasi mitra tetap diupayakan sebelum P15 | Belum ada balasan mitra | `PR14-01` belum; tidak ada surat atau laporan UAT fiktif |
| SK-008 | Prototipe tetap harus hi-fi dan bisa diklik | TXT hlm. 15 menuntut prototipe Figma hi-fi clickable | Wireframe statis tidak dihitung memenuhi `PR14-03` |
| SK-009 | 14 entitas ERD dipertahankan sebagai baseline yang harus diperiksa, bukan langsung dibekukan sebagai 3NF final | ERD lama belum diuji terhadap use case dan foto kondisi | P13-07 tetap sebagian sampai pemeriksaan 3NF selesai; penambahan entitas hanya jika terbukti perlu |
| SK-010 | Diagram Phase D lama dipakai setelah dicocokkan dengan TXT; tidak disalin mentah | Pemilik meminta kesesuaian diperiksa lebih dulu | Topologi as-is lokasi mitra tetap belum ada; stack diagram hanya dipakai jika lolos pemeriksaan |
| SK-011 | Roadmap lima minggu/M1–M6 dianggap rancangan historis; jadwal diselaraskan ke gate P13–P16 | TXT hlm. 24, 27, 32, 34 menetapkan isi tiap gate | P15-04 harus diperbarui sebelum dipakai sebagai jadwal sprint |
| SK-012 | Tiga KPI Vision dipakai sebagai target perencanaan: 90% kelengkapan listing, 80% persetujuan ≤24 jam, 90% transaksi punya foto kondisi OUT+RETURN dan rating | TXT hlm. 15 menuntut tiga KPI; belum ada data lapangan | Angkanya boleh diganti pemilik; sampai itu terjadi, Vision tetap draf |
| SK-013 | Istilah "freeze" pada Session 1 berarti baseline keputusan internal, bukan kelulusan gate | TXT hlm. 17 menyatakan dosen yang menentukan Hijau/Kuning/Merah | Checklist Gate 1 memakai status internal siap diajukan, bersyarat, belum siap |

## Gap yang belum ditutup

| # | Gap | Bukti | Pemilik | Akibat jika dibiarkan |
|---|---|---|---|---|
| G-01 | `HandoverCreateRequest` tidak menerima foto, padahal M4 mewajibkan foto OUT dan RETURN | `DESAIN/openapi.yaml` skema `Handover` dan `HandoverCreateRequest` | Fazha | M4 tidak bisa diuji end-to-end; kontrak harus diperbaiki di Session 2 |
| G-02 | BPMN to-be masih satu alur gabungan; dua proses utama belum dipisah | `DESAIN/BPMN To-Be - SewaKampus.png` | Fharel | Gate 1 butir internal BPMN belum siap |
| G-03 | Use case, user story, acceptance criteria, dan wireframe belum ada | tidak ada file | Fharel | Traceability kolom use case dan layar masih kosong |
| G-04 | Bukti 3NF per entitas belum ada | laporan §3.4.1.5 baru uraian | Fazha | Gate 1 butir ERD 3NF belum siap |
| G-05 | Topologi as-is di lokasi mitra, NFR, dan security baseline belum ada sebagai dokumen terpisah | laporan §3.5 adalah rancangan target | Mahesa | P13-11 tetap sebagian |
| G-06 | Notulen stand-up P13 belum ada | tidak ada file | Mahesa | P13-12 belum |
| G-07 | Mitra UAT dan jadwalnya belum dikonfirmasi | belum ada balasan | Hanan | PR14-01 belum |
| G-08 | Team Charter belum ditandatangani | `P13-Team-Charter.md` masih kosong di kolom tanda tangan | Hanan | Gate 1 butir internal charter belum siap |
| G-09 | Tidak ada commit per anggota | repo baru berisi commit fondasi atas nama tim | semua | Gate 1 butir "tiap anggota punya kartu atau commit" baru terpenuhi lewat kartu |

## Konflik dokumen yang ditemukan

| Konflik | Sumber A | Sumber B | Penyelesaian |
|---|---|---|---|
| Jumlah fitur MVP | Ringkasan lama menandai delapan fitur sebagai MVP | TXT hlm. 7: maksimal lima Must | SK-001 dan SK-002; ringkasan lama perlu diperbarui |
| Satuan waktu roadmap | Laporan §4.2 menyebut lima minggu | Gambar roadmap memakai M1–M6 | SK-011; roadmap disusun ulang mengikuti gate |
| Pasangan Must untuk P14 | Handoff lama: "listing dan booking" | TXT: booking bukan nama Must | SK-003 |
| Foto kondisi di API | TXT hlm. 26 menuntut foto saat serah terima dan pengembalian | Kontrak API belum punya field foto pada request handover | G-01, diperbaiki di Session 2 |
