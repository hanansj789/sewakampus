# 08_Source — Aplikasi SewaKampus

**Status:** Belum ada kode. Folder ini masih kerangka dari struktur yang ditetapkan handoff.

Kode aplikasi dimulai setelah Gate 1 dinilai dosen, mengikuti urutan di `07_Evidence/P13-Work-Board.md`.

Rencana isi:

- Laravel 11, PHP 8.3, MySQL 8.0, Redis 7, MinIO.
- `docker/` berisi `docker-compose.yml` untuk Nginx, Keycloak, Laravel, worker, MySQL, Redis, dan MinIO.
- `database/migrations/` mengikuti ERD 3NF di `02_Data/`.
- `database/sql/` berisi DDL dan seed yang bisa dijalankan ulang.
- `tests/` berisi test aturan status booking dan perhitungan deposit.

Jangan menaruh `.env`, token, atau berkas KTM asli di folder ini.
