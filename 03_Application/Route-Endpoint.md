**Status:** Ada. Dokumentasi route dan endpoint, 27 November 2026.

# Dokumentasi Route dan Endpoint

**Pemilik:** Muhammad Fazha Nararya Nugraha (Programmer)
**Sumber:** `php artisan route:list` pada 27 November 2026, `routes/web.php`, `03_Application/openapi.yaml`.
**Tujuan:** memenuhi tuntutan PR sebelum P15 "dokumentasi route/endpoint" dan menunjukkan selisih nyata antara aplikasi dan kontrak.

## 1. Ringkasan

| Hal | Jumlah |
|---|---|
| Route aplikasi (termasuk bawaan Laravel) | 33 |
| Route fitur SewaKampus | 30 |
| Path pada kontrak OpenAPI | 34 |
| Path kontrak yang sudah punya padanan aplikasi | 15 |
| Path kontrak yang belum dibangun | 19 |

## 2. Route aplikasi

| Metode | URI | Nama | Akses | Fungsi |
|---|---|---|---|---|
| GET | `/login` | `login` | publik | Halaman masuk |
| GET | `/auth/keycloak/redirect` | `auth.keycloak.redirect` | publik | Mulai OIDC |
| GET | `/auth/keycloak/callback` | `auth.keycloak.callback` | publik | Callback OIDC |
| POST | `/logout` | `logout` | masuk | Keluar |
| GET | `/logout/callback` | `auth.keycloak.logout.callback` | publik | Callback logout |
| GET | `/dashboard` | `dashboard` | masuk | Arahkan sesuai peran |
| GET | `/student/dashboard` | `student.dashboard` | STUDENT | Beranda mahasiswa |
| GET | `/admin/dashboard` | `admin.dashboard` | ADMIN | Beranda admin |
| GET | `/items` | `items.index` | masuk | Katalog dan "Milik saya" |
| GET | `/items/create` | `items.create` | masuk | Form listing |
| POST | `/items` | `items.store` | masuk | Simpan listing |
| GET | `/items/{item}` | `items.show` | masuk | Detail dan kalender |
| GET | `/items/{item}/edit` | `items.edit` | pemilik | Kelola listing |
| PATCH | `/items/{item}` | `items.update` | pemilik | Ubah listing |
| POST | `/items/{item}/pause` | `items.pause` | pemilik | Jeda atau aktifkan |
| POST | `/items/{item}/photos` | `items.photos.store` | pemilik | Unggah foto |
| GET | `/items/{item}/photos/{photo}` | `items.photos.show` | masuk | Sajikan foto |
| GET | `/items/{item}/availability` | `items.availability` | masuk | Cek rentang (JSON) |
| POST | `/items/{item}/bookings` | `bookings.store` | masuk | Ajukan sewa |
| GET | `/bookings` | `bookings.index` | masuk | Daftar pengajuan |
| POST | `/bookings/{booking}/approve` | `bookings.approve` | pemilik | Setujui |
| POST | `/bookings/{booking}/reject` | `bookings.reject` | pemilik | Tolak |
| POST | `/bookings/{booking}/cancel` | `bookings.cancel` | penyewa | Batalkan |
| GET | `/bookings/{booking}/handover` | `bookings.handover` | pihak booking | Halaman serah terima |
| POST | `/bookings/{booking}/handovers` | `bookings.handovers.store` | pihak booking | Catat OUT atau RETURN |
| POST | `/bookings/{booking}/handovers/{handover}/confirm` | `bookings.handovers.confirm` | pihak booking | Konfirmasi |
| GET | `/bookings/{booking}/handovers/{handover}/photo` | `bookings.handovers.photo` | pihak booking | Sajikan foto kondisi |
| POST | `/bookings/{booking}/complete` | `bookings.complete` | pihak booking | Selesaikan transaksi |
| GET | `/bookings/{booking}/review` | `bookings.reviews.create` | pihak booking | Form rating |
| POST | `/bookings/{booking}/reviews` | `bookings.reviews.store` | pihak booking | Simpan rating |
| GET | `/storage/{path}` | `storage.local` | masuk | Berkas privat bertanda tangan |

## 3. Pemetaan ke lima Must

| Must | Route utama |
|---|---|
| M1 Listing | `items.index`, `items.store`, `items.update`, `items.pause`, `items.photos.*` |
| M2 Kalender | `items.show`, `items.availability` |
| M3 Persetujuan | `bookings.store`, `bookings.approve`, `bookings.reject`, `bookings.cancel` |
| M4 Foto kondisi | `bookings.handovers.*`, `bookings.complete` |
| M5 Rating | `bookings.reviews.*`, `items.show` (daftar ulasan) |

## 4. Selisih dengan kontrak OpenAPI

### 4.1 Kontrak yang sudah punya padanan

`POST /items`, `PATCH /items/{itemId}`, `POST /items/{itemId}/photos`, `GET /items/{itemId}/availability`, `POST /bookings`, `POST /bookings/{bookingId}/approve`, `reject`, `cancel`, `GET/POST /bookings/{bookingId}/handovers`, `confirm`, `POST /bookings/{bookingId}/reviews`, `GET /users/{userId}/reviews` (data tersedia lewat relasi, belum ada halaman).

### 4.2 Kontrak yang belum dibangun di aplikasi

| Kelompok | Path | Alasan |
|---|---|---|
| Auth API | `/auth/register`, `/auth/login`, `/auth/me`, `/auth/logout` | Login memakai OIDC web, bukan API token |
| Verifikasi KTM | `/verifications*`, `/admin/verifications*` | G-01, belum dibangun |
| Sengketa | `/admin/disputes*`, `POST /bookings/{id}/disputes` | G-02, belum dibangun |
| Notifikasi | `/notifications*` | G-11, worker belum ada |
| Admin lain | `/categories`, `/admin/analytics/summary`, `/admin/audit-logs` | fase berikutnya |
| Rating pengguna | `/users/{userId}/reviews` | halaman profil belum ada |

### 4.3 Route aplikasi yang tidak ada di kontrak

Route halaman HTML (`/items`, `/bookings`, `/login`, dashboard, handover) tidak tercantum di OpenAPI karena kontrak hanya mengatur API JSON. Ini bukan selisih cacat, tetapi harus disebut saat ditanya.

## 5. Catatan teknis

- `POST /bookings/{bookingId}/handovers` memakai `multipart/form-data` dengan field `photo` wajib, sama dengan kontrak (SK-014).
- `GET /items/{item}/availability` mengembalikan `available` dan `conflicts`, dipakai halaman detail.
- Semua route fitur berada di middleware `auth`; endpoint admin memakai middleware `role:ADMIN`.
- Route `storage/{path}` hanya melayani berkas privat dengan URL bertanda tangan.

## 6. Cara memeriksa ulang

```bash
cd ARCHITECTURE_REPOSITORY/08_Source
DB_PORT=3311 php artisan route:list
```
