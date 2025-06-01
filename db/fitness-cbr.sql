-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Bulan Mei 2025 pada 08.55
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
-- Database: `fitness-cbr`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cases`
--

CREATE TABLE `cases` (
  `case_id` int(11) NOT NULL,
  `case_name` varchar(100) NOT NULL,
  `age_range` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `height_range` varchar(20) DEFAULT NULL,
  `weight_range` varchar(20) DEFAULT NULL,
  `fitness_level` varchar(20) DEFAULT NULL,
  `fitness_goal` varchar(30) DEFAULT NULL,
  `available_time_range` varchar(20) DEFAULT NULL,
  `equipment_needed` text DEFAULT NULL,
  `exercise_program` text DEFAULT NULL,
  `duration_weeks` int(11) DEFAULT NULL,
  `success_rate` decimal(5,2) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `frequency` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cases`
--

INSERT INTO `cases` (`case_id`, `case_name`, `age_range`, `gender`, `height_range`, `weight_range`, `fitness_level`, `fitness_goal`, `available_time_range`, `equipment_needed`, `exercise_program`, `duration_weeks`, `success_rate`, `created_by`, `created_at`, `frequency`) VALUES
(1, 'Program Latihan Pemula Laki-laki 50-70kg', NULL, 'male', '165-175', '50-70', NULL, NULL, NULL, NULL, 'Latihan: Push-up, Squat, Running', NULL, 85.50, NULL, '2025-05-27 14:12:25', '3_times'),
(2, 'Program Latihan Pemula Perempuan 50-70kg', NULL, 'female', '165-175', '50-70', NULL, NULL, NULL, NULL, 'Latihan: Jumping Jack, Plank, Walking', NULL, 80.20, NULL, '2025-05-27 14:12:25', '3_times');

-- --------------------------------------------------------

--
-- Struktur dari tabel `exercises`
--

CREATE TABLE `exercises` (
  `exercise_id` int(11) NOT NULL,
  `exercise_name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `muscle_group` varchar(100) DEFAULT NULL,
  `equipment_needed` varchar(100) DEFAULT NULL,
  `difficulty_level` enum('beginner','intermediate','advanced') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekomendasi`
--

CREATE TABLE `rekomendasi` (
  `rekomendasi_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `matched_case_id` int(11) DEFAULT NULL,
  `similarity_score` decimal(5,2) DEFAULT NULL,
  `rekomendasi_program` text DEFAULT NULL,
  `feedback_rating` int(11) DEFAULT NULL,
  `feedback_comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `full_name`, `role`, `created_at`) VALUES
(1, 'daffakhsnl', 'uyeedaffa@gmail.com', '$2y$10$tEufPVkRL/r3FNUgXDcU8unI3yZWOwDmHkN1o.aOLmpRgPrbqPzqy', 'Daffa Akhsanul Hamid', 'user', '2025-05-27 10:06:39'),
(3, '123r', 's@d.com', '$2y$10$EyuXZsNjfFj7bNbbsMMiEeSaBYnx6n1NKOgJlu7kWMgxkqP3DHCOG', '12s', 'user', '2025-05-28 10:13:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_profiles`
--

CREATE TABLE `user_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `fitness_level` enum('beginner','intermediate','advanced') DEFAULT NULL,
  `fitness_goal` enum('weight_loss','muscle_gain','endurance','general_fitness') DEFAULT NULL,
  `available_time` int(11) DEFAULT NULL,
  `equipment_access` text DEFAULT NULL,
  `health_conditions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`case_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`exercise_id`);

--
-- Indeks untuk tabel `rekomendasi`
--
ALTER TABLE `rekomendasi`
  ADD PRIMARY KEY (`rekomendasi_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `matched_case_id` (`matched_case_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cases`
--
ALTER TABLE `cases`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `exercises`
--
ALTER TABLE `exercises`
  MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rekomendasi`
--
ALTER TABLE `rekomendasi`
  MODIFY `rekomendasi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `rekomendasi`
--
ALTER TABLE `rekomendasi`
  ADD CONSTRAINT `rekomendasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `rekomendasi_ibfk_2` FOREIGN KEY (`matched_case_id`) REFERENCES `cases` (`case_id`);

--
-- Ketidakleluasaan untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO fitness_cbr.roles
(id, `role`, created_at)
VALUES(1, 'Admin', '2025-06-01 20:31:28');
INSERT INTO fitness_cbr.roles
(id, `role`, created_at)
VALUES(2, 'User Input', '2025-06-01 20:32:34');