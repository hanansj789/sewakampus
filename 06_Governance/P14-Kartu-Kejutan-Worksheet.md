**Status:** Ada. Lembar kerja Kartu Kejutan P14, 27 November 2026. Belum ada CR karena kartu dibagikan di kelas.

# P14 — Lembar Kerja Kartu Kejutan dan Change Request

**Pemilik:** Hanan Rizqullah (CEO/PO)
**Dasar:** TXT hlm. 23 dan 25.

## 1. Aturan

1. Kartu Kejutan berisi satu permintaan baru dari "mitra" saat briefing P14.
2. Permintaan tidak otomatis masuk MVP. Lima Must tetap lima.
3. Setiap permintaan dijawab dengan empat langkah: catat, analisis dampak, putuskan, komunikasikan.
4. Keputusan dicatat di `06_Governance/CHANGE-REQUEST-LOG.md` dengan nomor CR berikutnya.
5. Yang dinilai adalah kualitas alasan, bukan apakah permintaan diterima.

## 2. Empat langkah

| Langkah | Isi yang harus ditulis |
|---|---|
| Catat | Permintaan apa adanya, siapa yang meminta, kapan |
| Analisis dampak | Data: entitas atau kolom baru? Aplikasi: layar dan endpoint? Teknologi: layanan baru? Jadwal: berapa hari? |
| Putuskan | Masuk MVP, tunda ke roadmap, atau tolak; sebutkan alasannya |
| Komunikasikan | Siapa yang diberi tahu dan bagaimana |

## 3. Tiga pilihan keputusan

| Pilihan | Kapan dipakai | Konsekuensi |
|---|---|---|
| Masuk MVP | Menopang salah satu dari lima Must dan muat dalam sisa waktu | Menambah pekerjaan; harus mengganti pekerjaan lain, bukan menumpuk |
| Tunda ke roadmap | Layak, tetapi tidak menopang Must P14 | Dicatat di `05_Opportunities/` dan roadmap P15 |
| Tolak | Bertentangan dengan lima Must, keamanan, atau waktu | Alasan ditulis dan disampaikan ke peminta |

## 4. Contoh analisis yang benar (bukan permintaan nyata)

> Permintaan: "Tolong tambahkan fitur chat antara penyewa dan pemilik."
>
> Dampak data: entitas `Message` baru, relasi ke `Booking`, kebijakan retensi.
> Dampak aplikasi: dua layar, endpoint baru, notifikasi.
> Dampak teknologi: WebSocket atau polling, menambah beban server.
> Dampak jadwal: 4–6 hari, melebihi sisa waktu P14.
> Keputusan: **tolak untuk MVP**, tunda ke roadmap fase 2.

Contoh ini hanya memperlihatkan bentuk jawaban. Jangan dimasukkan sebagai CR.

## 5. Lembar isian (diisi saat kelas)

| Kolom | Isi |
|---|---|
| Nomor CR | CR-009 (menunggu) |
| Tanggal | |
| Peminta | |
| Permintaan | |
| Dampak data | |
| Dampak aplikasi | |
| Dampak teknologi | |
| Dampak jadwal | |
| Keputusan | |
| Alasan | |
| Komunikasi | |

## 6. Setelah diisi

1. Salin ke `CHANGE-REQUEST-LOG.md` sebagai baris CR baru.
2. Bila keputusan mengubah lingkup, catat di `DECISIONS.md` dengan nomor SK baru.
3. Bila keputusan mengubah teknologi, buat ADR.
4. Perbarui `P13-DELIVERABLE-MATRIX.md` bila status deliverable berubah.
