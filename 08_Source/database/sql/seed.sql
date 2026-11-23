-- SewaKampus — data uji lokal
-- Status: Draf. Dijalankan setelah 001_init.sql pada database kosong.
-- PR14-05. Semua nama, email, dan nomor telepon fiktif untuk pengembangan.
-- Kata sandi seluruh akun uji: RahasiaKampus123!
-- Hash bcrypt yang dipakai: $2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC
-- Hash dibuat dengan bcrypt cost 10, diuji dengan password_verify di PHP 8.3.

USE sewakampus;
SET NAMES utf8mb4;

-- Kategori (tabel master, 8 baris)
INSERT INTO item_categories (public_id, name, slug, is_active, sort_order) VALUES
  ('01J0000000000000000000000Z', 'Kamera dan Lensa', 'kamera-lensa', TRUE, 1),
  ('01J00000000000000000000010', 'Proyektor dan Layar', 'proyektor-layar', TRUE, 2),
  ('01J00000000000000000000011', 'Audio dan Speaker', 'audio-speaker', TRUE, 3),
  ('01J00000000000000000000012', 'Tenda dan Alat Camping', 'tenda-camping', TRUE, 4),
  ('01J00000000000000000000013', 'Alat Laboratorium', 'alat-laboratorium', TRUE, 5),
  ('01J00000000000000000000014', 'Kostum dan Atribut', 'kostum-atribut', TRUE, 6),
  ('01J00000000000000000000015', 'Elektronik', 'elektronik', TRUE, 7),
  ('01J00000000000000000000016', 'Perlengkapan Acara', 'perlengkapan-acara', TRUE, 8);

-- Pengguna (tabel master, 30 baris)
INSERT INTO users (public_id, full_name, email, password_hash, phone, role, account_status) VALUES
  ('01J00000000000000000000001', 'Hanan Rizqullah', 'hanan.rizqullah@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234000000', 'STUDENT', 'ACTIVE'),
  ('01J00000000000000000000002', 'Mahesa Kanaka', 'mahesa.kanaka@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234000137', 'STUDENT', 'ACTIVE'),
  ('01J00000000000000000000003', 'Fharel Dwipa', 'fharel.dwipa@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234000274', 'STUDENT', 'ACTIVE'),
  ('01J00000000000000000000004', 'Fazha Nararya', 'fazha.nararya@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234000411', 'STUDENT', 'ACTIVE'),
  ('01J00000000000000000000005', 'Rizky Pratama', 'rizky.pratama@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234000548', 'STUDENT', 'ACTIVE'),
  ('01J00000000000000000000006', 'Nabila Safitri', 'nabila.safitri@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234000685', 'STUDENT', 'ACTIVE'),
  ('01J00000000000000000000007', 'Aditya Nugroho', 'aditya.nugroho@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234000822', 'STUDENT', 'ACTIVE'),
  ('01J00000000000000000000008', 'Salsabila Ramadhani', 'salsabila.ramadhani@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234000959', 'STUDENT', 'ACTIVE'),
  ('01J00000000000000000000009', 'Fajar Saputra', 'fajar.saputra@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234001096', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000A', 'Intan Maharani', 'intan.maharani@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234001233', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000B', 'Bayu Wijaya', 'bayu.wijaya@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234001370', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000C', 'Sari Anggraini', 'sari.anggraini@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234001507', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000D', 'Dimas Setiawan', 'dimas.setiawan@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234001644', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000E', 'Putri Handayani', 'putri.handayani@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234001781', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000F', 'Reza Firmansyah', 'reza.firmansyah@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234001918', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000G', 'Ayu Lestari', 'ayu.lestari@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234002055', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000H', 'Yoga Santoso', 'yoga.santoso@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234002192', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000J', 'Mega Puspita', 'mega.puspita@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234002329', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000K', 'Taufik Hidayat', 'taufik.hidayat@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234002466', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000M', 'Laras Sari', 'laras.sari@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234002603', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000N', 'Andi Kurniawan', 'andi.kurniawan@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234002740', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000P', 'Dewi Wulandari', 'dewi.wulandari@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234002877', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000Q', 'Fikri Maulana', 'fikri.maulana@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234003014', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000R', 'Nadia Izzati', 'nadia.izzati@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234003151', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000S', 'Rendi Fadillah', 'rendi.fadillah@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234003288', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000T', 'Ratna Safira', 'ratna.safira@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234003425', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000V', 'Ilham Ramadhan', 'ilham.ramadhan@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234003562', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000W', 'Kartika Dewanti', 'kartika.dewanti@student.unja.ac.id', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081234003699', 'STUDENT', 'ACTIVE'),
  ('01J0000000000000000000000X', 'Admin SewaKampus', 'admin@sewakampus.test', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081200000001', 'ADMIN', 'ACTIVE'),
  ('01J0000000000000000000000Y', 'Verifikator Kampus', 'verifikator@sewakampus.test', '$2y$10$q5CgPbWQZ9QbFLs5kmAx8ecbN9JDC.E2a5MthKsz3cH2shEWp0rhC', '081200000002', 'ADMIN', 'ACTIVE');

-- Verifikasi KTM (28 baris, semua disetujui)
INSERT INTO student_verifications (public_id, user_id, nim, name_on_card, study_program, faculty, ktm_file_path, status, reviewed_by, reviewed_at) VALUES
  ('01J00000000000000000000017', 1, 'F1E124041', 'Hanan Rizqullah', 'Sistem Informasi', 'Sains dan Teknologi', 'ktm/2026/F1E124041.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J00000000000000000000018', 2, 'F1E124042', 'Mahesa Kanaka', 'Teknik Informatika', 'Sains dan Teknologi', 'ktm/2026/F1E124042.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J00000000000000000000019', 3, 'F1E124043', 'Fharel Dwipa', 'Teknik Elektro', 'Teknik', 'ktm/2026/F1E124043.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001A', 4, 'F1E124044', 'Fazha Nararya', 'Matematika', 'Sains dan Teknologi', 'ktm/2026/F1E124044.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001B', 5, 'F1E124045', 'Rizky Pratama', 'Biologi', 'Sains dan Teknologi', 'ktm/2026/F1E124045.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001C', 6, 'F1E124046', 'Nabila Safitri', 'Kimia', 'Sains dan Teknologi', 'ktm/2026/F1E124046.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001D', 7, 'F1E124047', 'Aditya Nugroho', 'Manajemen', 'Ekonomi dan Bisnis', 'ktm/2026/F1E124047.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001E', 8, 'F1E124048', 'Salsabila Ramadhani', 'Akuntansi', 'Ekonomi dan Bisnis', 'ktm/2026/F1E124048.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001F', 9, 'F1E124049', 'Fajar Saputra', 'Sistem Informasi', 'Sains dan Teknologi', 'ktm/2026/F1E124049.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001G', 10, 'F1E124050', 'Intan Maharani', 'Teknik Informatika', 'Sains dan Teknologi', 'ktm/2026/F1E124050.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001H', 11, 'F1E124051', 'Bayu Wijaya', 'Teknik Elektro', 'Teknik', 'ktm/2026/F1E124051.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001J', 12, 'F1E124052', 'Sari Anggraini', 'Matematika', 'Sains dan Teknologi', 'ktm/2026/F1E124052.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001K', 13, 'F1E124053', 'Dimas Setiawan', 'Biologi', 'Sains dan Teknologi', 'ktm/2026/F1E124053.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001M', 14, 'F1E124054', 'Putri Handayani', 'Kimia', 'Sains dan Teknologi', 'ktm/2026/F1E124054.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001N', 15, 'F1E124055', 'Reza Firmansyah', 'Manajemen', 'Ekonomi dan Bisnis', 'ktm/2026/F1E124055.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001P', 16, 'F1E124056', 'Ayu Lestari', 'Akuntansi', 'Ekonomi dan Bisnis', 'ktm/2026/F1E124056.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001Q', 17, 'F1E124057', 'Yoga Santoso', 'Sistem Informasi', 'Sains dan Teknologi', 'ktm/2026/F1E124057.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001R', 18, 'F1E124058', 'Mega Puspita', 'Teknik Informatika', 'Sains dan Teknologi', 'ktm/2026/F1E124058.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001S', 19, 'F1E124059', 'Taufik Hidayat', 'Teknik Elektro', 'Teknik', 'ktm/2026/F1E124059.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001T', 20, 'F1E124060', 'Laras Sari', 'Matematika', 'Sains dan Teknologi', 'ktm/2026/F1E124060.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001V', 21, 'F1E124061', 'Andi Kurniawan', 'Biologi', 'Sains dan Teknologi', 'ktm/2026/F1E124061.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001W', 22, 'F1E124062', 'Dewi Wulandari', 'Kimia', 'Sains dan Teknologi', 'ktm/2026/F1E124062.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001X', 23, 'F1E124063', 'Fikri Maulana', 'Manajemen', 'Ekonomi dan Bisnis', 'ktm/2026/F1E124063.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001Y', 24, 'F1E124064', 'Nadia Izzati', 'Akuntansi', 'Ekonomi dan Bisnis', 'ktm/2026/F1E124064.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J0000000000000000000001Z', 25, 'F1E124065', 'Rendi Fadillah', 'Sistem Informasi', 'Sains dan Teknologi', 'ktm/2026/F1E124065.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J00000000000000000000020', 26, 'F1E124066', 'Ratna Safira', 'Teknik Informatika', 'Sains dan Teknologi', 'ktm/2026/F1E124066.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J00000000000000000000021', 27, 'F1E124067', 'Ilham Ramadhan', 'Teknik Elektro', 'Teknik', 'ktm/2026/F1E124067.jpg', 'APPROVED', 29, '2026-11-20 10:00:00'),
  ('01J00000000000000000000022', 28, 'F1E124068', 'Kartika Dewanti', 'Matematika', 'Sains dan Teknologi', 'ktm/2026/F1E124068.jpg', 'APPROVED', 29, '2026-11-20 10:00:00');

-- Barang (tabel master, 30 baris)
INSERT INTO items (public_id, owner_id, category_id, title, description, `condition`, daily_rate, deposit_amount, pickup_point, status, average_rating, review_count) VALUES
  ('01J00000000000000000000023', 1, 1, 'Canon EOS M50 + Kit 15-45mm', 'Kamera mirrorless ringan, cocok untuk foto acara kampus. Termasuk baterai cadangan dan tas.', 'GOOD', 75000, 150000, 'Gedung FST Lantai 1', 'ACTIVE', 0.00, 0),
  ('01J00000000000000000000024', 2, 1, 'Lensa Canon 50mm f/1.8', 'Lensa fixed untuk potret. Bokeh halus, kondisi mulus, tanpa jamur.', 'NEW', 50000, 100000, 'Gedung FST Lantai 1', 'ACTIVE', 0.00, 0),
  ('01J00000000000000000000025', 3, 2, 'Proyektor Epson EB-X06', 'Proyektor 3600 lumens untuk presentasi kelas dan acara organisasi. Termasuk kabel HDMI 5 meter.', 'GOOD', 125000, 250000, 'Aula Gedung B', 'ACTIVE', 0.00, 0),
  ('01J00000000000000000000026', 4, 2, 'Layar Proyektor 100 inci', 'Layar tripod, mudah dipasang sendiri. Termasuk tas jinjing.', 'GOOD', 50000, 100000, 'Aula Gedung B', 'ACTIVE', 0.00, 0),
  ('01J00000000000000000000027', 5, 3, 'Speaker JBL PartyBox 100', 'Speaker portabel untuk acara kecil sampai 50 orang. Baterai tahan 6 jam.', 'GOOD', 150000, 300000, 'Sekretariat BEM', 'ACTIVE', 0.00, 0),
  ('01J00000000000000000000028', 6, 3, 'Mixer Audio 4 Channel', 'Mixer kecil dengan phantom power, cocok untuk podcast dan seminar.', 'FAIR', 60000, 120000, 'Sekretariat BEM', 'ACTIVE', 0.00, 0),
  ('01J00000000000000000000029', 7, 4, 'Tenda Dome 4 Orang', 'Tenda double layer, sudah dipakai dua kali. Termasuk pasak dan flysheet.', 'GOOD', 40000, 80000, 'Gazebo Kampus', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002A', 8, 4, 'Sleeping Bag', 'Sleeping bag kapas, bersih dan sudah dicuci. Tersedia tiga unit.', 'GOOD', 15000, 30000, 'Gazebo Kampus', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002B', 9, 4, 'Kompor Camping Portable', 'Kompor gas portabel dengan selang. Tidak termasuk gas.', 'FAIR', 20000, 40000, 'Gazebo Kampus', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002C', 10, 5, 'Mikroskop Binokuler', 'Mikroskop laboratorium untuk praktikum biologi. Hanya dipakai di dalam kampus.', 'GOOD', 100000, 200000, 'Lab Biologi', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002D', 11, 5, 'Neraca Analitik Digital', 'Neraca presisi 0.001 gram. Dipakai untuk praktikum kimia analitik.', 'NEW', 90000, 180000, 'Lab Kimia', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002E', 12, 5, 'Gelas Ukur Set 100ml', 'Set alat gelas laboratorium, bersih dan steril.', 'GOOD', 15000, 30000, 'Lab Kimia', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002F', 13, 6, 'Kostum Tari Tradisional', 'Kostum tari Melayu lengkap dengan aksesori. Ukuran M.', 'GOOD', 35000, 70000, 'Gedung Kesenian', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002G', 14, 6, 'Kostum Wisuda Lengkap', 'Toga, topi, dan selempang ukuran L. Disewakan untuk foto wisuda.', 'GOOD', 50000, 100000, 'Gedung Rektorat', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002H', 15, 6, 'Jas Almamater', 'Jas almamater resmi ukuran M, bersih dan disetrika.', 'GOOD', 20000, 40000, 'Gedung Rektorat', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002J', 16, 7, 'Kamera GoPro Hero 9', 'Kamera aksi dengan housing tahan air. Termasuk dua baterai.', 'GOOD', 85000, 170000, 'Gedung FST Lantai 1', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002K', 17, 7, 'Tripod Kamera', 'Tripod aluminium tinggi 160 cm dengan kepala ball.', 'GOOD', 20000, 40000, 'Gedung FST Lantai 1', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002M', 18, 7, 'Stabilizer Gimbal', 'Gimbal tiga sumbu untuk ponsel dan kamera ringan.', 'NEW', 55000, 110000, 'Gedung FST Lantai 1', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002N', 19, 7, 'Lampu Ring 18 inci', 'Lampu ring untuk foto produk dan video. Termasuk stand.', 'GOOD', 25000, 50000, 'Gedung FST Lantai 2', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002P', 20, 8, 'Kursi Lipat 20 Unit', 'Kursi lipat untuk rapat dan acara. Tersedia dua puluh unit.', 'FAIR', 5000, 100000, 'Sekretariat BEM', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002Q', 21, 8, 'Meja Lipat 5 Unit', 'Meja lipat panjang untuk bazar dan pameran.', 'GOOD', 10000, 50000, 'Sekretariat BEM', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002R', 22, 8, 'Tenda Bazar 3x3', 'Tenda kanopi untuk bazar kampus. Termasuk pemberat.', 'GOOD', 60000, 120000, 'Lapangan Kampus', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002S', 23, 3, 'Sound System Portabel', 'Sistem suara lengkap dengan dua mic kabel dan stand.', 'GOOD', 175000, 350000, 'Sekretariat BEM', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002T', 24, 1, 'Kamera Analog Canon AE-1', 'Kamera film untuk latihan fotografi analog.', 'FAIR', 70000, 140000, 'Gedung FST Lantai 1', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002V', 25, 7, 'Drone Mini', 'Drone ringan dengan kamera 2.7K untuk dokumentasi acara.', 'NEW', 120000, 240000, 'Gedung FST Lantai 2', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002W', 26, 8, 'Kotak Pendingin 30 Liter', 'Cool box untuk konsumsi acara lapangan.', 'GOOD', 15000, 30000, 'Gazebo Kampus', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002X', 27, 8, 'Dispenser Air Portable', 'Dispenser kecil untuk kegiatan lapangan.', 'GOOD', 10000, 20000, 'Gazebo Kampus', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002Y', 28, 4, 'Tabung Gas 3 Kg', 'Tabung gas kosong untuk kegiatan memasak di lapangan.', 'FAIR', 5000, 20000, 'Gazebo Kampus', 'ACTIVE', 0.00, 0),
  ('01J0000000000000000000002Z', 1, 7, 'Laptop Cadangan', 'Laptop untuk presentasi dan pengolahan data ringan.', 'GOOD', 80000, 160000, 'Gedung FST Lantai 2', 'ACTIVE', 0.00, 0),
  ('01J00000000000000000000030', 2, 2, 'Proyektor Mini', 'Proyektor mini untuk kegiatan kelompok kecil.', 'FAIR', 45000, 90000, 'Gedung FST Lantai 2', 'ACTIVE', 0.00, 0);

-- Foto barang (30 foto utama)
INSERT INTO item_photos (item_id, file_path, alt_text, sort_order, is_primary) VALUES
  (1, 'items/1/01.jpg', 'Canon EOS M50 + Kit 15-45mm', 0, TRUE),
  (2, 'items/2/01.jpg', 'Lensa Canon 50mm f/1.8', 0, TRUE),
  (3, 'items/3/01.jpg', 'Proyektor Epson EB-X06', 0, TRUE),
  (4, 'items/4/01.jpg', 'Layar Proyektor 100 inci', 0, TRUE),
  (5, 'items/5/01.jpg', 'Speaker JBL PartyBox 100', 0, TRUE),
  (6, 'items/6/01.jpg', 'Mixer Audio 4 Channel', 0, TRUE),
  (7, 'items/7/01.jpg', 'Tenda Dome 4 Orang', 0, TRUE),
  (8, 'items/8/01.jpg', 'Sleeping Bag', 0, TRUE),
  (9, 'items/9/01.jpg', 'Kompor Camping Portable', 0, TRUE),
  (10, 'items/10/01.jpg', 'Mikroskop Binokuler', 0, TRUE),
  (11, 'items/11/01.jpg', 'Neraca Analitik Digital', 0, TRUE),
  (12, 'items/12/01.jpg', 'Gelas Ukur Set 100ml', 0, TRUE),
  (13, 'items/13/01.jpg', 'Kostum Tari Tradisional', 0, TRUE),
  (14, 'items/14/01.jpg', 'Kostum Wisuda Lengkap', 0, TRUE),
  (15, 'items/15/01.jpg', 'Jas Almamater', 0, TRUE),
  (16, 'items/16/01.jpg', 'Kamera GoPro Hero 9', 0, TRUE),
  (17, 'items/17/01.jpg', 'Tripod Kamera', 0, TRUE),
  (18, 'items/18/01.jpg', 'Stabilizer Gimbal', 0, TRUE),
  (19, 'items/19/01.jpg', 'Lampu Ring 18 inci', 0, TRUE),
  (20, 'items/20/01.jpg', 'Kursi Lipat 20 Unit', 0, TRUE),
  (21, 'items/21/01.jpg', 'Meja Lipat 5 Unit', 0, TRUE),
  (22, 'items/22/01.jpg', 'Tenda Bazar 3x3', 0, TRUE),
  (23, 'items/23/01.jpg', 'Sound System Portabel', 0, TRUE),
  (24, 'items/24/01.jpg', 'Kamera Analog Canon AE-1', 0, TRUE),
  (25, 'items/25/01.jpg', 'Drone Mini', 0, TRUE),
  (26, 'items/26/01.jpg', 'Kotak Pendingin 30 Liter', 0, TRUE),
  (27, 'items/27/01.jpg', 'Dispenser Air Portable', 0, TRUE),
  (28, 'items/28/01.jpg', 'Tabung Gas 3 Kg', 0, TRUE),
  (29, 'items/29/01.jpg', 'Laptop Cadangan', 0, TRUE),
  (30, 'items/30/01.jpg', 'Proyektor Mini', 0, TRUE);

-- Blokir tanggal oleh pemilik (10 baris)
INSERT INTO item_availabilities (item_id, start_date, end_date, status, note) VALUES
  (1, '2026-12-24', '2026-12-26', 'BLOCKED', 'Dipakai acara keluarga'),
  (3, '2026-12-10', '2026-12-12', 'BLOCKED', 'Perbaikan lampu proyektor'),
  (5, '2026-12-31', '2027-01-02', 'BLOCKED', 'Tahun baru'),
  (7, '2026-12-05', '2026-12-07', 'BLOCKED', 'Sedang dicuci'),
  (10, '2026-12-15', '2026-12-18', 'BLOCKED', 'Praktikum terjadwal'),
  (12, '2026-12-20', '2026-12-22', 'BLOCKED', 'Stok habis disewa'),
  (16, '2026-12-08', '2026-12-09', 'BLOCKED', 'Dipakai dokumentasi fakultas'),
  (19, '2026-12-27', '2026-12-29', 'BLOCKED', 'Acara dies natalis'),
  (22, '2026-12-13', '2026-12-14', 'BLOCKED', 'Bazar fakultas'),
  (25, '2026-12-23', '2026-12-25', 'BLOCKED', 'Libur akhir tahun');

-- Booking (8 baris, lima status berbeda)
INSERT INTO bookings (public_id, item_id, renter_id, owner_id, start_date, end_date, daily_rate_snapshot, subtotal, deposit_snapshot, total_amount, status, pickup_point, approved_at) VALUES
  ('01J00000000000000000000031', 1, 5, 1, '2026-12-01', '2026-12-03', 75000, 225000, 150000, 375000, 'COMPLETED', 'Gedung FST Lantai 1', '2026-11-24 09:00:00'),
  ('01J00000000000000000000032', 3, 6, 3, '2026-12-04', '2026-12-05', 125000, 250000, 250000, 500000, 'COMPLETED', 'Aula Gedung B', '2026-11-24 09:00:00'),
  ('01J00000000000000000000033', 5, 7, 5, '2026-12-06', '2026-12-07', 150000, 300000, 300000, 600000, 'COMPLETED', 'Sekretariat BEM', '2026-11-24 09:00:00'),
  ('01J00000000000000000000034', 7, 8, 7, '2026-12-09', '2026-12-11', 40000, 120000, 80000, 200000, 'RETURNED', 'Gazebo Kampus', '2026-11-24 09:00:00'),
  ('01J00000000000000000000035', 16, 9, 16, '2026-12-12', '2026-12-13', 85000, 170000, 170000, 340000, 'HANDED_OVER', 'Gedung FST Lantai 1', '2026-11-24 09:00:00'),
  ('01J00000000000000000000036', 19, 10, 19, '2026-12-14', '2026-12-15', 25000, 50000, 50000, 100000, 'APPROVED', 'Gedung FST Lantai 2', '2026-11-24 09:00:00'),
  ('01J00000000000000000000037', 22, 11, 22, '2026-12-16', '2026-12-17', 60000, 120000, 120000, 240000, 'PENDING', 'Lapangan Kampus', NULL),
  ('01J00000000000000000000038', 24, 12, 24, '2026-12-18', '2026-12-19', 70000, 140000, 140000, 280000, 'REJECTED', 'Gedung FST Lantai 1', NULL),
  ('01J00000000000000000000039', 1, 13, 1, '2026-12-20', '2026-12-22', 75000, 225000, 150000, 375000, 'DISPUTED', 'Gedung FST Lantai 1', '2026-11-24 10:00:00'),
  ('01J0000000000000000000003A', 3, 14, 3, '2026-12-23', '2026-12-24', 125000, 125000, 250000, 375000, 'CANCELLED', 'Aula Gedung B', '2026-11-24 10:00:00');

-- Riwayat status booking: setiap baris hanya satu langkah, tanpa lompatan
INSERT INTO booking_status_histories (booking_id, from_status, to_status, changed_by, reason, created_at) VALUES
  (1, 'PENDING',  'APPROVED',    1,  'Disetujui pemilik', '2026-11-24 09:05:00'),
  (1, 'APPROVED', 'HANDED_OVER', 5,  'Serah terima OUT', '2026-12-01 14:00:00'),
  (1, 'HANDED_OVER', 'RETURNED', 5,  'Pengembalian RETURN', '2026-12-03 17:00:00'),
  (1, 'RETURNED', 'COMPLETED',   5,  'Transaksi selesai', '2026-12-03 17:30:00'),
  (2, 'PENDING',  'APPROVED',    3,  'Disetujui pemilik', '2026-11-24 09:06:00'),
  (2, 'APPROVED', 'HANDED_OVER', 3,  'Serah terima OUT', '2026-12-04 13:00:00'),
  (2, 'HANDED_OVER', 'RETURNED', 6,  'Pengembalian RETURN', '2026-12-05 16:00:00'),
  (2, 'RETURNED', 'COMPLETED',   6,  'Transaksi selesai', '2026-12-05 16:30:00'),
  (3, 'PENDING',  'APPROVED',    5,  'Disetujui pemilik', '2026-11-24 09:07:00'),
  (3, 'APPROVED', 'HANDED_OVER', 5,  'Serah terima OUT', '2026-12-06 13:00:00'),
  (3, 'HANDED_OVER', 'RETURNED', 7,  'Pengembalian RETURN', '2026-12-07 18:00:00'),
  (3, 'RETURNED', 'COMPLETED',   7,  'Transaksi selesai', '2026-12-07 18:20:00'),
  (4, 'PENDING',  'APPROVED',    7,  'Disetujui pemilik', '2026-11-24 09:08:00'),
  (4, 'APPROVED', 'HANDED_OVER', 7,  'Serah terima OUT', '2026-12-09 13:00:00'),
  (4, 'HANDED_OVER', 'RETURNED', 8,  'Pengembalian RETURN', '2026-12-11 17:00:00'),
  (5, 'PENDING',  'APPROVED',    16, 'Disetujui pemilik', '2026-11-24 09:09:00'),
  (5, 'APPROVED', 'HANDED_OVER', 16, 'Serah terima OUT', '2026-12-12 13:00:00'),
  (6, 'PENDING',  'APPROVED',    19, 'Disetujui pemilik', '2026-11-24 09:10:00'),
  (8, 'PENDING',  'REJECTED',    22, 'Barang sedang dipakai pemilik', '2026-11-24 09:11:00'),
  (9, 'PENDING',  'APPROVED',    1,  'Disetujui pemilik', '2026-11-24 10:05:00'),
  (9, 'APPROVED', 'HANDED_OVER', 1,  'Serah terima OUT', '2026-12-20 13:00:00'),
  (9, 'HANDED_OVER', 'DISPUTED', 13, 'Barang kembali rusak', '2026-12-22 17:00:00'),
  (10, 'PENDING', 'CANCELLED',   14, 'Penyewa membatalkan sebelum diputuskan', '2026-11-24 10:06:00');

-- Deposit simulasi (booking 1 sampai 6)
INSERT INTO deposits (public_id, booking_id, amount, status, method, paid_at) VALUES
  ('01J00000000000000000000039', 1, 150000, 'REFUNDED', 'SIMULATED', '2026-11-24 09:30:00'),
  ('01J0000000000000000000003A', 2, 250000, 'REFUNDED', 'SIMULATED', '2026-11-24 09:30:00'),
  ('01J0000000000000000000003B', 3, 300000, 'REFUNDED', 'SIMULATED', '2026-11-24 09:30:00'),
  ('01J0000000000000000000003C', 4, 80000, 'REFUNDED', 'SIMULATED', '2026-11-24 09:30:00'),
  ('01J0000000000000000000003D', 5, 170000, 'HELD', 'SIMULATED', '2026-11-24 09:30:00'),
  ('01J0000000000000000000003E', 6, 50000, 'HELD', 'SIMULATED', '2026-11-24 09:30:00');

-- Handover: OUT untuk booking 4 dan 5, RETURN untuk booking 4
INSERT INTO handovers (public_id, booking_id, direction, location, condition_notes, photo_path, renter_confirmed_at, owner_confirmed_at) VALUES
  ('01J0000000000000000000003F', 4, 'OUT', 'Gazebo Kampus', 'Tenda lengkap, pasak 12 buah', 'handover/4/out.jpg', '2026-12-09 08:10:00', '2026-12-09 08:15:00'),
  ('01J0000000000000000000003G', 4, 'RETURN', 'Gazebo Kampus', 'Tenda kembali bersih, satu pasak bengkok', 'handover/4/return.jpg', '2026-12-11 17:40:00', '2026-12-11 17:45:00'),
  ('01J0000000000000000000003H', 5, 'OUT', 'Gedung FST Lantai 1', 'Kamera dan baterai lengkap', 'handover/5/out.jpg', '2026-12-12 09:00:00', NULL);

-- Review untuk tiga booking selesai
INSERT INTO reviews (public_id, booking_id, reviewer_id, reviewee_id, reviewer_role, rating, comment, status) VALUES
  ('01J0000000000000000000003J', 1, 5, 1, 'RENTER', 5, 'Kamera bersih dan pemilik responsif.', 'PUBLISHED'),
  ('01J0000000000000000000003K', 1, 1, 5, 'OWNER', 5, 'Penyewa tepat waktu dan barang kembali utuh.', 'PUBLISHED'),
  ('01J0000000000000000000003M', 2, 6, 3, 'RENTER', 4, 'Proyektor bagus, kabel agak pendek.', 'PUBLISHED'),
  ('01J0000000000000000000003N', 3, 7, 5, 'RENTER', 5, 'Speaker kencang, cocok untuk acara 50 orang.', 'PUBLISHED');

-- Sengketa (2 baris: satu terbuka, satu selesai)
INSERT INTO disputes (public_id, booking_id, opened_by, against_user_id, category, description, evidence_path, status, resolution, resolved_by, resolved_at) VALUES
  ('01J00000000000000000000041', 9, 13, 1, 'DAMAGE', 'Lensa tergores dan tutup body hilang saat dikembalikan.', 'handovers/booking-9-return.jpg', 'OPEN', NULL, NULL, NULL),
  ('01J00000000000000000000042', 3, 7, 5, 'LATE_RETURN', 'Pengembalian lewat satu hari dari tenggat.', NULL, 'RESOLVED', 'Deposit dipotong 25 persen untuk keterlambatan.', 29, '2026-12-08 10:00:00');

-- Audit log (3 baris: verifikasi, sengketa dibuka, sengketa diputuskan)
INSERT INTO audit_logs (actor_id, action, entity_type, entity_id, metadata) VALUES
  (29, 'VERIFICATION_APPROVED', 'student_verifications', 1, '{"catatan":"data uji seed"}'),
  (13, 'DISPUTE_OPENED', 'disputes', 1, '{"booking_id":9}'),
  (29, 'DISPUTE_RESOLVED', 'disputes', 2, '{"keputusan":"potong 25 persen"}');

-- Sinkronkan cache rating dari view kanonik
UPDATE items i
JOIN v_item_rating v ON v.item_id = i.id
SET i.average_rating = COALESCE(v.average_rating, 0), i.review_count = v.review_count;

-- Notifikasi (4 baris)
INSERT INTO notifications (public_id, user_id, type, title, body, channel, status, entity_type, entity_public_id, read_at) VALUES
  ('01J0000000000000000000003P', 1, 'BOOKING_REQUEST', 'Pengajuan sewa baru', 'Ada pengajuan untuk kamera Anda.', 'IN_APP', 'SENT', 'BOOKING', '01J000000000000000000000A', NULL),
  ('01J0000000000000000000003Q', 5, 'BOOKING_APPROVED', 'Pengajuan disetujui', 'Pemilik menyetujui pengajuan Anda.', 'EMAIL', 'SENT', 'BOOKING', '01J000000000000000000000A', NULL),
  ('01J0000000000000000000003R', 7, 'HANDOVER_REMINDER', 'Ingat serah terima', 'Serah terima dijadwalkan besok.', 'IN_APP', 'QUEUED', 'BOOKING', '01J000000000000000000000B', NULL),
  ('01J0000000000000000000003S', 3, 'REVIEW_RECEIVED', 'Ulasan baru', 'Penyewa memberi ulasan untuk proyektor Anda.', 'IN_APP', 'READ', 'REVIEW', '01J000000000000000000000C', '2026-11-25 10:00:00');

-- Selesai: 8 kategori, 30 pengguna, 28 verifikasi, 30 barang, 30 foto, 10 blokir, 10 booking, 6 deposit, 3 handover, 4 review, 4 notifikasi, 23 riwayat status, 2 sengketa, 3 audit log.
