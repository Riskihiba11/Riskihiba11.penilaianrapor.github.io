-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Okt 2024 pada 03.49
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `capaian_hasil`
--

CREATE TABLE `capaian_hasil` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `predikat_spiritual` varchar(2) DEFAULT NULL,
  `deskripsi_spiritual` text DEFAULT NULL,
  `predikat_sosial` varchar(2) DEFAULT NULL,
  `deskripsi_sosial` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `capaian_hasil`
--

INSERT INTO `capaian_hasil` (`id`, `student_id`, `predikat_spiritual`, `deskripsi_spiritual`, `predikat_sosial`, `deskripsi_sosial`) VALUES
(3, 3, 'A', 'afssadfsdf', 'A', 'dsafdsw'),
(4, 1, 'B', 'fdsZhgfxchgc', 'C', 'jhgfdckuydfchgj'),
(5, 11, 'A', 'good', 'A', 'good');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ekstrakurikuler`
--

CREATE TABLE `ekstrakurikuler` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `sakit` int(11) DEFAULT 0,
  `ijin` int(11) DEFAULT 0,
  `tanpa_kabar` int(11) DEFAULT 0,
  `juz` varchar(255) DEFAULT NULL,
  `surat_tahfizh` varchar(255) DEFAULT NULL,
  `jilid_tahsin` varchar(255) DEFAULT NULL,
  `halaman_tahsin` varchar(255) DEFAULT NULL,
  `surat_tilawah` varchar(255) DEFAULT NULL,
  `halaman_tilawah` varchar(255) DEFAULT NULL,
  `berat_badan` float DEFAULT NULL,
  `tinggi_badan` float DEFAULT NULL,
  `fisik_keterangan` text DEFAULT NULL,
  `catatan_wali` text DEFAULT NULL,
  `pramuka_predikat` varchar(2) DEFAULT NULL,
  `pramuka_keterangan` text DEFAULT NULL,
  `silat_predikat` varchar(2) DEFAULT NULL,
  `silat_keterangan` text DEFAULT NULL,
  `jurnalistik_predikat` varchar(2) DEFAULT NULL,
  `jurnalistik_keterangan` text DEFAULT NULL,
  `melukis_predikat` varchar(2) DEFAULT NULL,
  `melukis_keterangan` text DEFAULT NULL,
  `futsal_predikat` varchar(2) DEFAULT NULL,
  `futsal_keterangan` text DEFAULT NULL,
  `kir_predikat` varchar(2) DEFAULT NULL,
  `kir_keterangan` text DEFAULT NULL,
  `leader_community_predikat` varchar(2) DEFAULT NULL,
  `leader_community_keterangan` text DEFAULT NULL,
  `english_club_predikat` varchar(2) DEFAULT NULL,
  `english_club_keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ekstrakurikuler`
--

INSERT INTO `ekstrakurikuler` (`id`, `student_id`, `sakit`, `ijin`, `tanpa_kabar`, `juz`, `surat_tahfizh`, `jilid_tahsin`, `halaman_tahsin`, `surat_tilawah`, `halaman_tilawah`, `berat_badan`, `tinggi_badan`, `fisik_keterangan`, `catatan_wali`, `pramuka_predikat`, `pramuka_keterangan`, `silat_predikat`, `silat_keterangan`, `jurnalistik_predikat`, `jurnalistik_keterangan`, `melukis_predikat`, `melukis_keterangan`, `futsal_predikat`, `futsal_keterangan`, `kir_predikat`, `kir_keterangan`, `leader_community_predikat`, `leader_community_keterangan`, `english_club_predikat`, `english_club_keterangan`) VALUES
(1, 3, 0, 0, 0, '12', 'asd', 'asd', 'ads', 'ads', 'asd', 213, 213, 'ads', 'ads', '-', '-', 'A', 'asd', 'A', 'ads', 'A', 'asd', 'A', 'asd', 'A', 'asd', 'A', 'as', 'A', 'ads'),
(8, 1, 3, 2, 0, '12', 'Al-Kahfi', '30', 'Al-fatihah', 'Al-fatihah', '7', 250, 150, 'Bogel', 'Terlalu aktif agar diet', '-', '-', 'A', 'fgdshdfsghdfhdfh', 'A', 'dfhsfdhfdhfdhgdsf', 'A', 'hsdffgsdgsgwsdg', 'A', 'fdshgjnhgmfghj,jyhl.hjkljhlfjg', '-', '-', '-', '-', '-', '-'),
(9, 11, 0, 0, 0, '2', '4', '2', '4', '21', '3', 213, 123, 'good', 'v', 'A', 'good', 'A', 'good', 'A', 'good', 'A', 'good', 'A', 'good', 'A', 'good', 'go', 'A', 'A', 'good');

-- --------------------------------------------------------

--
-- Struktur dari tabel `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `semester` enum('ganjil','genap') NOT NULL,
  `knowledge_grade` varchar(3) DEFAULT NULL,
  `knowledge_predicate` varchar(2) DEFAULT NULL,
  `knowledge_description` text DEFAULT NULL,
  `skill_grade` varchar(3) DEFAULT NULL,
  `skill_predicate` varchar(2) DEFAULT NULL,
  `skill_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `created_at`, `semester`, `knowledge_grade`, `knowledge_predicate`, `knowledge_description`, `skill_grade`, `skill_predicate`, `skill_description`) VALUES
(103, 3, 1, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(104, 3, 2, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(105, 3, 3, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(106, 3, 4, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(107, 3, 5, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(108, 3, 6, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(109, 3, 7, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(110, 3, 8, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(111, 3, 9, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(112, 3, 10, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(113, 3, 11, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(114, 3, 12, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(115, 3, 13, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(116, 3, 14, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(117, 3, 15, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(118, 3, 16, '2024-10-14 12:36:06', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(119, 3, 1, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(120, 3, 2, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(121, 3, 3, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(122, 3, 4, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(123, 3, 5, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(124, 3, 6, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(125, 3, 7, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(126, 3, 8, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(127, 3, 9, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(128, 3, 10, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(129, 3, 11, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(130, 3, 12, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(131, 3, 13, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(132, 3, 14, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(133, 3, 15, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(134, 3, 16, '2024-10-14 12:37:29', 'genap', '55', 'A', '55', '55', 'A', '55'),
(135, 1, 1, '2024-10-15 01:50:41', 'ganjil', '89', 'A', 'lebih baik', '87', 'A', 'lebih giat lagi belajar'),
(136, 1, 2, '2024-10-15 01:50:41', 'ganjil', '78', 'B', 'tingkatkan lagi', '98', 'A', 'lebih giat lagi belajar'),
(137, 1, 3, '2024-10-15 01:50:41', 'ganjil', '89', 'A', 'sudah cukup lebih baik', '89', 'A', 'lebih giat lagi belajar'),
(138, 1, 4, '2024-10-15 01:50:41', 'ganjil', '78', 'B', 'lebih giat lagi belajar rumusnya', '78', 'B', 'lebih giat lagi belajar'),
(139, 1, 5, '2024-10-15 01:50:41', 'ganjil', '89', 'A', 'cukup baik', '78', 'B', 'lebih giat lagi belajar'),
(140, 1, 6, '2024-10-15 01:50:41', 'ganjil', '79', 'B', 'lebih giat lagi belajar prounosesoun nya dan noun atau grammar', '87', 'A', 'lebih giat lagi belajar'),
(141, 1, 7, '2024-10-15 01:50:41', 'ganjil', '89', 'A', 'cukup baik', '89', 'A', 'lebih giat lagi belajar'),
(142, 1, 8, '2024-10-15 01:50:41', 'ganjil', '78', 'B', 'lebih giat lagi belajar', '98', 'A', 'lebih giat lagi belajar'),
(143, 1, 9, '2024-10-15 01:50:41', 'ganjil', '89', 'A', 'lebih giat lagi belajar', '87', 'A', 'lebih giat lagi belajar'),
(144, 1, 10, '2024-10-15 01:50:41', 'ganjil', '78', 'B', 'lebih giat lagi belajar', '78', 'B', 'lebih giat lagi belajar'),
(145, 1, 11, '2024-10-15 01:50:41', 'ganjil', '89', 'A', 'lebih giat lagi belajar', '89', 'A', 'lebih giat lagi belajar'),
(146, 1, 12, '2024-10-15 01:50:41', 'ganjil', '78', 'B', 'lebih giat lagi belajar', '87', 'A', 'lebih giat lagi belajar'),
(147, 1, 13, '2024-10-15 01:50:41', 'ganjil', '78', 'B', 'lebih giat lagi belajar', '78', 'B', 'lebih giat lagi belajar'),
(148, 1, 14, '2024-10-15 01:50:41', 'ganjil', '78', 'B', 'lebih giat lagi belajar', '98', 'A', 'lebih giat lagi belajar'),
(149, 1, 15, '2024-10-15 01:50:41', 'ganjil', '67', 'C', 'lebih giat lagi belajar', '89', 'A', 'lebih giat lagi belajar'),
(150, 1, 16, '2024-10-15 01:50:41', 'ganjil', '78', 'B', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(151, 1, 1, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(152, 1, 2, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(153, 1, 3, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(154, 1, 4, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(155, 1, 5, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(156, 1, 6, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(157, 1, 7, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(158, 1, 8, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(159, 1, 9, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(160, 1, 10, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(161, 1, 11, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(162, 1, 12, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(163, 1, 13, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(164, 1, 14, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(165, 1, 15, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(166, 1, 16, '2024-10-15 01:52:22', 'genap', '99', 'A', 'lebih giat lagi belajar', '99', 'A', 'lebih giat lagi belajar'),
(167, 11, 1, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '432', 'A', 'good'),
(168, 11, 2, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '23', 'A', 'good'),
(169, 11, 3, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '123', 'A', 'good'),
(170, 11, 4, '2024-10-18 04:21:06', 'ganjil', '132', 'A', 'good', '24', 'A', 'good'),
(171, 11, 5, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '214', 'A', 'good'),
(172, 11, 6, '2024-10-18 04:21:06', 'ganjil', '132', 'A', 'good', '234', 'A', 'good'),
(173, 11, 7, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '142', 'A', 'good'),
(174, 11, 8, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '235', 'A', 'good'),
(175, 11, 9, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '12', 'A', 'good'),
(176, 11, 10, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'v', '32', 'A', 'good'),
(177, 11, 11, '2024-10-18 04:21:06', 'ganjil', '324', 'A', 'good', '213', 'A', 'good'),
(178, 11, 12, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '12', 'A', 'good'),
(179, 11, 13, '2024-10-18 04:21:06', 'ganjil', '12', 'A', 'good', '21', 'A', 'good'),
(180, 11, 14, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '23', 'A', 'good'),
(181, 11, 15, '2024-10-18 04:21:06', 'ganjil', '234', 'A', 'good', '12', 'A', 'good'),
(182, 11, 16, '2024-10-18 04:21:06', 'ganjil', '123', 'A', 'good', '342', 'A', 'good'),
(183, 6, 1, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(184, 6, 2, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(185, 6, 3, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(186, 6, 4, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(187, 6, 5, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(188, 6, 6, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(189, 6, 7, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(190, 6, 8, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(191, 6, 9, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(192, 6, 10, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(193, 6, 11, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(194, 6, 12, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(195, 6, 13, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(196, 6, 14, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(197, 6, 15, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99'),
(198, 6, 16, '2024-10-24 01:27:43', 'ganjil', '99', 'A', '99', '99', 'A', '99');

-- --------------------------------------------------------

--
-- Struktur dari tabel `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `student_class` varchar(50) NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `address` text DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `father_job` varchar(50) NOT NULL,
  `mother_job` varchar(50) NOT NULL,
  `parent_phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `place_of_birth` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `previous_education` varchar(100) DEFAULT NULL,
  `student_address` text DEFAULT NULL,
  `parent_address` text DEFAULT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `guardian_job` varchar(100) DEFAULT NULL,
  `guardian_address` text DEFAULT NULL,
  `photo` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `students`
--

INSERT INTO `students` (`id`, `nis`, `student_name`, `student_class`, `gender`, `address`, `father_name`, `mother_name`, `father_job`, `mother_job`, `parent_phone`, `created_at`, `place_of_birth`, `date_of_birth`, `religion`, `previous_education`, `student_address`, `parent_address`, `guardian_name`, `guardian_job`, `guardian_address`, `photo`) VALUES
(1, '2345234321', 'Pecun', 'Class 2', 'Laki-laki', 'Kolong', 'Kelong', 'Kelong', 'Kelong', 'Kelong', '091280129', '2024-10-08 19:18:32', 'Kelong', '2024-10-14', 'Kelong', 'Kelong', 'Kelong', 'Kelong', 'Kelong', 'Kelong', 'Kelong', 0x313732383937333133325f626972752e6a7067),
(3, '23542423532', 'Si A', 'Class 1', 'Laki-laki', 'a', 'a', 'a', 'sA', 'da', '12', '2024-10-08 19:18:44', 'asd', '2024-10-09', 'a', 'a', 'a', 'aasf', 'a', 'a', 'a', 0x313732383930393537305f34362d3436353235335f6a65737369652d7468652d6e65772d6769726c2d6a65737369652d746f792d73746f72792d706e672e706e67),
(6, 'kontol', 'kontol', 'Class 1', 'Laki-laki', NULL, 'kontol', 'kontol', 'job', 'job', NULL, '2024-10-17 05:13:03', 'kontol', '2024-10-17', 'kontol', 'kontol', 'kontol', 'kontol', 'kontol', 'kontol', 'kontol', 0x313732393134313938335f494d475f32303233303932395f3135343330322e6a7067),
(7, 'asd', 'asd', 'Class 1', 'Laki-laki', NULL, 'asd', 'asd', 'asd', 'asd', NULL, '2024-10-18 03:27:12', 'asd', '2024-10-18', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 0x313732393232323033325f70757469682e6a7067),
(9, '312', '123', 'Class 1', 'Laki-laki', NULL, 'sdrf', 'asgdf', 'asf', 'asdfasd', NULL, '2024-10-18 03:30:00', '123', '2024-10-18', '213', '1234', '234r', 'sdgsfdgcvxz', 'rdasgfvzzrf', 'asdvc', 'zxfawsd', 0x313732393232323230305f706e6777696e672e636f6d2e706e67),
(10, 'zsgd nbsdf', 'gzfsdgbsrdtgfbsdv', 'Class 1', 'Laki-laki', NULL, 'dfzgbdfz', 'zsfdgbs', 'zdfgsb', 'zsgrdfb', NULL, '2024-10-18 03:32:35', 'dtgzsdbgzdsbgzsd', '2024-10-18', 'zsdGBSD', 'zfsgdbsfd', 'dzsfgbdzf', 'zsb df', 'zdsfgb', 'dfzbgzdf', 'zgsfb sf', 0x313732393232323335355f6c6f676f20706f6e646f6b2e706e67),
(11, '325425r', 'asdfasdf', 'Class 1', 'Perempuan', NULL, 'asdfasdfvasdfg', 'sadgfvdsc', 'sdfgsdf', 'sdfsdf', NULL, '2024-10-18 04:18:44', 'sdafasd', '2024-10-18', 'asfdasfvasd', 'dfsasd', 'BITUNG', 'esdfgsdzcvx', 'egdfvzxc', 'edsfxc', 'edsfczx', 0x313732393232353138325f622e6a706567);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_class` varchar(50) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_class`, `teacher_id`, `created_at`) VALUES
(1, 'Pendidikan Agama', 'Class 1', 6, '2024-10-14 12:18:38'),
(2, 'PPKn', 'Class 1', 4, '2024-10-14 12:18:57'),
(3, 'Bahasa Indonesia', 'Class 1', 4, '2024-10-14 12:19:14'),
(4, 'Matematika', 'Class 1', 4, '2024-10-14 12:22:03'),
(5, 'Sejarah Indonesia', 'Class 1', 4, '2024-10-14 12:22:12'),
(6, 'Bahasa Inggris', 'Class 1', 4, '2024-10-14 12:22:23'),
(7, 'Seni Budaya', 'Class 1', 4, '2024-10-14 12:22:34'),
(8, 'PJOK', 'Class 1', 4, '2024-10-14 12:22:44'),
(9, 'PKWU', 'Class 1', 4, '2024-10-14 12:22:54'),
(10, 'Matematika Peminatan', 'Class 1', 4, '2024-10-14 12:23:09'),
(11, 'Fisika', 'Class 1', 6, '2024-10-14 12:23:18'),
(12, 'Biologi', 'Class 1', 4, '2024-10-14 12:25:07'),
(13, 'Kimia', 'Class 1', 4, '2024-10-14 12:25:19'),
(14, 'Bahasa Arab', 'Class 1', 4, '2024-10-14 12:25:27'),
(15, 'Tahfiz Al-Qur\'an', 'Class 1', 4, '2024-10-14 12:31:01'),
(16, 'Tahsin Al-Qur\'an', 'Class 1', 4, '2024-10-14 12:31:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','wali_kelas') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2024-10-08 18:01:33'),
(3, 'wali kelas', 'dcf52f84dbf511ee4a0abcfc18093ee4', 'wali_kelas', '2024-10-08 18:01:33'),
(4, 'husein', '016403c29cc2d69584968fd1e8d4bfca', 'guru', '2024-10-08 18:22:26'),
(6, 'guru', '77e69c137812518e359196bb2f5e9bb9', 'guru', '2024-10-14 12:13:31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `capaian_hasil`
--
ALTER TABLE `capaian_hasil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indeks untuk tabel `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_ibfk_2` (`subject_id`),
  ADD KEY `grades_ibfk_1` (`student_id`);

--
-- Indeks untuk tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `capaian_hasil`
--
ALTER TABLE `capaian_hasil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT untuk tabel `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `capaian_hasil`
--
ALTER TABLE `capaian_hasil`
  ADD CONSTRAINT `capaian_hasil_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
