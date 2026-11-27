**Status:** Ada. Paket bukti Gate 2, 27 November 2026. Belum dinilai dosen.

# P14 — Paket Gate 2 Build Review

**Pemilik:** Hanan Rizqullah (CEO/PO, QA P14)
**Dasar:** `Skenario_Project ASP R001.txt` hlm. 27.

## 1. Lima butir resmi Gate 2

| # | Butir | Status | Bukti | Yang kurang |
|---|---|---|---|---|
| 1 | Demo langsung 2 fitur Must end-to-end dengan database nyata | **Siap** | `07_Evidence/P14-M1-Run.md`, `07_Evidence/P14-M2-Run.md`, staging hidup | demo dijalankan saat gate |
| 2 | ADR tech stack tertulis dan disetujui CEO | **Selesai** | `06_Governance/ADR-001-tech-stack.md` bagian Status | — |
| 3 | Topologi + deployment diagram final; versi awal ter-deploy ke staging | **Selesai** | `04_Technology/P14-Deployment-Final.md`, `07_Evidence/P14-Staging-Deploy.md` | staging bergantung laptop hidup |
| 4 | Change Request dari Kartu Kejutan terdokumentasi dengan keputusan | **Menunggu kelas** | `06_Governance/P14-Kartu-Kejutan-Worksheet.md` | kartu baru dibagikan saat briefing P14 |
| 5 | Tidak ada anggota dengan nol kontribusi di repo atau artefak | **Bersyarat** | commit per akun, PR #20–#33 | Fharel baru 1 commit; perlu PR uji 15 kasus sebelum gate |

## 2. Bukti demo dua Must

| Must | Fitur | Bukti otomatis | Bukti manual |
|---|---|---|---|
| M1 | Listing barang | 13 tes `ItemListingTest` | katalog + form + foto di staging |
| M2 | Kalender ketersediaan | 10 tes `ItemAvailabilityTest` | kalender Desember 2026 di staging |

Total suite saat paket ini disusun: **76 lulus, 235 assertion**.

## 3. Naskah demo

Ada di `06_Governance/P14-Demo-Script.md`, lima menit, termasuk rencana cadangan bila tunnel mati.

## 4. Kontribusi per anggota

| Anggota | Bukti kontribusi | Status |
|---|---|---|
| Hanan | 31 commit, PR #16–#34, ADR, paket gate | cukup |
| Fazha | 9 commit, PR #20, #22, #26, #28, #30 | cukup |
| Mahesa | 3 commit, PR #33, IP plan, staging, security checklist | cukup |
| Fharel | 1 commit (review halaman auth) | **perlu ditambah** |

Rencana penutup: Fharel menjalankan 15 kasus black-box, membandingkan tampilan dengan prototipe, lalu membuka PR atas namanya. Itu sekaligus memenuhi butir 5 dan menyelesaikan K-TEST.

## 5. Yang harus dilakukan sebelum gate

1. Fharel membuka PR hasil uji 15 kasus (butir 5 dan K-TEST).
2. Saat briefing P14, Kartu Kejutan diisi ke worksheet dan menjadi CR resmi (butir 4).
3. Menyalakan staging 30 menit sebelum sesi dan memeriksa `/login` serta login Keycloak.
4. Menyiapkan cadangan: tangkapan layar dan server lokal bila internet bermasalah.

## 6. Setelah gate

- Perbaiki temuan dosen, catat di `P13-GAP-DECISIONS.md` bila mengubah keputusan.
- Lanjut sisa PR sebelum P15: prosedur transaksi + backup, TCO, gap analysis, finalisasi UAT.
