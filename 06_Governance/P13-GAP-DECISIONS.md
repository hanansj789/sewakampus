# Gap, Konflik, dan Catatan Keputusan — SewaKampus P13

**Status:** Ada. Dokumen kerja analisis.
**Tanggal:** 23 November 2026
**Keputusan resmi:** `SEWAKAMPUS/DECISIONS.md` (SK-001 sampai SK-013). File itu yang menang jika berbeda dengan catatan di sini.

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

## Gap yang belum tertutup

| # | Gap | Bukti | Pemilik | Akibat jika dibiarkan |
|---|---|---|---|---|
| G-01 | `HandoverCreateRequest` tidak menerima foto, padahal M4 mewajibkan foto OUT dan RETURN | `DESAIN/openapi.yaml`, skema `Handover` dan `HandoverCreateRequest` | Fazha | M4 tidak bisa diuji end-to-end |
| G-02 | BPMN to-be masih satu alur gabungan; dua proses utama belum dipisah | `DESAIN/BPMN To-Be - SewaKampus.png` | Fharel | Butir internal Gate 1 nomor 6 belum siap |
| G-03 | Use case, user story, acceptance criteria, dan wireframe belum ada | tidak ada file | Fharel | Kolom use case dan layar di traceability kosong |
| G-04 | Bukti 3NF per entitas belum ada | laporan §3.4.1.5 baru uraian | Fazha | Butir resmi Gate 1 nomor 3 gagal |
| G-05 | Topologi as-is lokasi mitra, NFR, dan security baseline belum ada sebagai dokumen | laporan §3.5 berisi rancangan target | Mahesa | P13-11 tetap sebagian |
| G-06 | Notulen stand-up P13 belum ada | tidak ada file | Mahesa | P13-12 belum |
| G-07 | Mitra UAT dan jadwalnya belum dikonfirmasi | belum ada balasan | Hanan | PR14-01 belum |
| G-08 | Team Charter belum ditandatangani | `P13-Team-Charter.md` kolom tanda tangan kosong | Hanan | Butir internal nomor 11 belum siap |
| G-09 | Tidak ada commit per anggota | commit fondasi memakai identitas tim | semua | Butir "kartu atau commit" baru terpenuhi lewat kartu |

## Konflik dokumen

| Konflik | Sumber A | Sumber B | Penyelesaian |
|---|---|---|---|
| Jumlah fitur MVP | Ringkasan lama menandai delapan fitur sebagai MVP | TXT hlm. 7: maksimal lima Must | SK-001 dan SK-002; ringkasan lama perlu diperbarui |
| Satuan waktu roadmap | Laporan §4.2 menyebut lima minggu | Gambar roadmap memakai M1–M6 | SK-011 |
| Pasangan Must untuk P14 | Handoff lama: "listing dan booking" | TXT: booking bukan nama Must | SK-003 |
| Foto kondisi di API | TXT hlm. 26 menuntut foto saat serah terima dan pengembalian | Kontrak API belum punya field foto pada request handover | G-01, diperbaiki di Session 2 |
| Nama file peta aset | Handoff menulis `P13-Asset-Map.md` | Repo memakai `P13-ASSET-MAP.md` | Diikuti nama repo; tidak material |

## Catatan

- Gap G-01 sampai G-09 tidak boleh ditutup dengan asumsi. Setiap penutupan butuh file atau keputusan baru.
- Konflik baru dicatat di sini lebih dulu, lalu keputusannya dipindahkan ke `DECISIONS.md`.
