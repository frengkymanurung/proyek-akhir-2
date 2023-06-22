-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jun 2023 pada 04.19
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doorlocksystem`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `ruangan` varchar(50) NOT NULL,
  `catatan_tambahan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Menunggu','Disetujui','Ditolak') DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `nama`, `email`, `tanggal_booking`, `waktu_mulai`, `waktu_selesai`, `ruangan`, `catatan_tambahan`, `created_at`, `status`) VALUES
(31, 'muliadi', 'muliadi@gmail.com', '2023-06-12', '20:43:00', '20:45:00', 'lab cisco', 'qefrg', '2023-06-12 13:41:52', 'Disetujui'),
(32, 'oma', 'muliadi@gmail.com', '2023-06-12', '20:50:00', '20:52:00', 'lab cisco', 'wdefrv', '2023-06-12 13:49:03', 'Disetujui'),
(33, 'ultop', 'admin@admin.com', '2023-06-12', '20:52:00', '20:54:00', 'lab cisco', 'wdqefr', '2023-06-12 13:51:07', 'Disetujui'),
(34, 'ultop', 'admin@admin.com', '2023-06-12', '20:52:00', '20:54:00', 'lab cisco', 'wdqefr', '2023-06-12 13:52:04', 'Menunggu'),
(35, 'asita', 'asita@gmail.com', '2023-06-12', '21:04:00', '21:05:00', 'lab cisco', 'sadfv', '2023-06-12 14:02:34', 'Disetujui'),
(36, 'asita', 'asita@gmail.com', '2023-06-12', '21:04:00', '21:05:00', 'lab cisco', 'sadfv', '2023-06-12 14:04:40', 'Menunggu'),
(37, 'oma', 'admin@admin.com', '2023-06-12', '21:07:00', '21:08:00', 'lab cisco', 'dewfv', '2023-06-12 14:05:18', 'Disetujui'),
(38, 'edwfgsbfwqerwfgwer', 'admin@admin.com', '2023-06-12', '21:11:00', '21:12:00', 'lab cisco', 'w', '2023-06-12 14:09:30', 'Disetujui'),
(39, 'wpofnkls ', 'muliadi@gmail.com', '2023-06-12', '21:18:00', '21:19:00', 'lab cisco', 'ucgvhjbk ', '2023-06-12 14:16:39', 'Disetujui'),
(40, 'muliadi', 'muliadi@gmail.com', '2023-06-12', '21:22:00', '21:23:00', 'lab cisco', 'biuojnklm', '2023-06-12 14:20:53', 'Disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `registrations`
--

INSERT INTO `registrations` (`id`, `username`, `password`, `status`, `role`, `email`) VALUES
(1, 'kelompokpa', '$2y$10$MgILxbidaqqOnCk9bkprtOjfAONX0H9eAxV0hZpqdBsXK2NOfNvh2', 'approved', 'admin', ''),
(14, 'aku', '$2y$10$.iQ1sBOx5ISa1Ws9R3xQFOsGfdA01yBHVmxdJ8d2macxP9jey9Yx6', 'pending', 'user', ''),
(15, 'dia', '$2y$10$FlzWJ0UMt0KbDIp.OYMmSOlTOpsGhz7V43oVHu.u02dyHdYRiZ12e', 'approved', 'user', 'satu@gmail.com'),
(16, 'frengky', '$2y$10$ZcacpegRa9v7ECMrNcXp4OsuOYR4MdUZ2oDMhwr1rgAX1vW/Fow9.', 'approved', 'user', 'frengky@gmail.com'),
(17, 'test', '$2y$10$FczbWkKHYCIYxwa3JL/AjubgGQT5NV70.lGVk7QfrAv.NDPduXF1W', 'approved', 'user', 'test@gmail.com'),
(18, 'test2', '$2y$10$JCaSdTi.M9.c32KPg36PM.zH7x2ipyun66ozY6PFisrN0CMSziuSG', 'pending', 'user', 'test2@gmail.com'),
(19, 'happyshop', '$2y$10$.peHBf7sc9EbIvBy07q91eNIrQDEw0peHJS2i4c5GxZo97qPTuut.', 'approved', 'user', 'frengkymanurung445@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(50) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `ip_device` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `status`, `ip_device`) VALUES
(513, 'lab cisco', 'Terbuka', '172.40.170.10'),
(514, 'lab komputer', 'Tertutup', '172.40.156.24');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
