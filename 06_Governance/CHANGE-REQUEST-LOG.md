**Status:** Ada. Satu CR tercatat (CR-001). Belum ada CR yang berasal dari mitra.

# Change Request Log — SewaKampus

Setelah Gate 1, perubahan lingkup, ERD, API, atau lima Must hanya boleh lewat catatan di sini. Perubahan teknologi memakai ADR.

| CR | Tanggal | Pengusul | Perubahan yang diminta | Alasan | Dampak | Keputusan |
|---|---|---|---|---|---|---|
| CR-001 | 23 Nov 2026 | Fazha (audit repo) | S-02 didefinisikan sebagai **Katalog**, dengan state "Milik saya" untuk daftar listing sendiri; sebelumnya S-02 tertulis "Daftar listing saya" | Prototipe dan wireframe Session 3 membangun layar Katalog sebagai halaman pertama produk, sedangkan "Daftar listing saya" tidak dibangun. Tanpa pemetaan ini, layar pertama produk tidak punya ID dan kolom layar di traceability memuat dua arti untuk S-02 | Tiga dokumen diselaraskan: `01_Business/P13-Use-Cases.md`, `06_Governance/P13-Traceability-Matrix.md`, `03_Application/ux/DESIGN.md`. SK-017 tidak berubah karena rentang ID tetap S-01 sampai S-09 | Diterima sebagai perbaikan konsistensi; bukan fitur baru |

Catatan: CR-001 tidak menambah fitur dan tidak mengubah lima Must. Jika pemilik memutuskan "Daftar listing saya" harus menjadi layar tersendiri, CR baru harus memberi ID S-10 dan mengembalikan S-02 ke arti lama.
