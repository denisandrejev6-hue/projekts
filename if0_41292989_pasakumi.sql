-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql303.infinityfree.com
-- Generation Time: Mar 26, 2026 at 06:40 AM
-- Server version: 11.4.10-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41292989_pasakumi`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jaunumi`
--

CREATE TABLE `jaunumi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `virsraksts` varchar(255) NOT NULL,
  `apraksts` text NOT NULL,
  `publicets_datums` date NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jaunumi`
--

INSERT INTO `jaunumi` (`id`, `virsraksts`, `apraksts`, `publicets_datums`, `created_at`, `updated_at`) VALUES
(1, 'Jauna biblioteka', 'Musu biblioteka atver jaunu filialu.', '2025-03-01', '2026-03-13 11:53:26', '2026-03-13 11:53:26'),
(2, 'Gramatu izstade', 'Notiks gramatu izstade svetdien.', '2025-03-05', '2026-03-13 11:53:26', '2026-03-13 11:53:26'),
(3, 'Lasitaju vakars', 'Aicinam visus uz lasitaju vakaru.', '2025-03-10', '2026-03-13 11:53:26', '2026-03-13 11:53:26'),
(4, 'Jaunums 1', 'Šis ir pirmais testa jaunums ar īsu aprakstu.', '2024-01-01', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(5, 'Jaunums 2', 'Otrs jaunums ar informāciju par notikumiem pilsētā.', '2024-01-02', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(6, 'Jaunums 3', 'Trešais jaunums – sistēmas darbības pārbaude.', '2024-01-03', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(7, 'Jaunums 4', 'Jaunums par jaunu funkciju ieviešanu.', '2024-01-04', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(8, 'Jaunums 5', 'Informācija par plānotajiem uzlabojumiem.', '2024-01-05', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(9, 'Jaunums 6', 'Ziņojums par veiksmīgu sistēmas atjauninājumu.', '2024-01-06', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(10, 'Jaunums 7', 'Jaunums par sabiedrības aktivitātēm.', '2024-01-07', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(11, 'Jaunums 8', 'Paziņojums par gaidāmajiem pasākumiem.', '2024-01-08', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(12, 'Jaunums 9', 'Neliels apskats par pēdējām izmaiņām.', '2024-01-09', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(13, 'Jaunums 10', 'Jaunums par sadarbības iespējām.', '2024-01-10', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(14, 'Jaunums 11', 'Aktualitātes par projekta progresu.', '2024-01-11', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(15, 'Jaunums 12', 'Svarīga informācija lietotājiem.', '2024-01-12', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(16, 'Jaunums 13', 'Jaunums par sistēmas drošības uzlabojumiem.', '2024-01-13', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(17, 'Jaunums 14', 'Pārskats par pēdējām aktivitātēm.', '2024-01-14', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(18, 'Jaunums 15', 'Jaunums par tehniskajiem darbiem.', '2024-01-15', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(19, 'Jaunums 16', 'Informācija par jaunu sadarbību.', '2024-01-16', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(20, 'Jaunums 17', 'Jaunums par lietotāju statistiku.', '2024-01-17', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(21, 'Jaunums 18', 'Paziņojums par sistēmas uzturēšanas darbiem.', '2024-01-18', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(22, 'Jaunums 19', 'Jaunums par jaunu saturu platformā.', '2024-01-19', '2026-03-17 10:35:58', '2026-03-17 10:35:58'),
(23, 'Jaunums 20', 'Noslēdzošais testa jaunums ar aprakstu.', '2024-01-20', '2026-03-17 10:35:58', '2026-03-17 10:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `jaunumi_images`
--

CREATE TABLE `jaunumi_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jaunumi_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategorijas`
--

CREATE TABLE `kategorijas` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nosaukums` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategorijas`
--

INSERT INTO `kategorijas` (`ID`, `nosaukums`) VALUES
(9, 'Bērniem'),
(10, 'Darbnīca'),
(6, 'Izglītība'),
(12, 'Izglītības pasākums'),
(8, 'Izklaide'),
(4, 'Izstāde'),
(3, 'Koncerts'),
(1, 'Konference'),
(7, 'Kultūra'),
(11, 'Kultūras pasākums'),
(2, 'Seminārs'),
(5, 'Sporta pasākums');

-- --------------------------------------------------------

--
-- Table structure for table `lietotaji`
--

CREATE TABLE `lietotaji` (
  `ID` int(10) UNSIGNED NOT NULL,
  `vards` varchar(45) NOT NULL,
  `uzvards` varchar(25) NOT NULL,
  `epasts` varchar(50) NOT NULL,
  `loma` enum('Admin','Darbinieks','Lietotajs') NOT NULL,
  `parole` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `aktivs` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lietotaji`
--

INSERT INTO `lietotaji` (`ID`, `vards`, `uzvards`, `epasts`, `loma`, `parole`, `email`, `email_verified_at`, `password`, `remember_token`, `aktivs`) VALUES
(1, 'Sergejs', 'Ozols', 'sergejs@gmail.com', 'Admin', '$2y$12$M4AKVyASHWm1eWm.ZneQCe1iPOod950GROBj.GsKSyMMJXpbo.pSC', '', NULL, '', NULL, 1),
(2, 'Janis', 'Bērziņš', 'janis@gmail.com', 'Darbinieks', '$2y$12$iDv1J9.2oI99PuZWy4ljCu4e.J0iuAQ/ifIJ/pGpE.E5DEpSkoi0W', '', NULL, '', NULL, 1),
(3, 'Anna', 'Kalniņa', 'anna@gmail.com', 'Darbinieks', '$2y$12$gT1F59lHe8Gxcn3EbN/63OLAcIlJUmf9.Jhkxn5OIr5Vfalz5sKXO', '', NULL, '', NULL, 1),
(4, 'Peteris', 'Liepiņš', 'peteris@gmail.com', 'Darbinieks', '$2y$12$feZ/0EI1YM3X8xEy9drpCeAo42D3AU8oK.fEPulR43hz8dAz5mgqa', '', NULL, '', NULL, 1),
(5, 'Laura', 'Krūmiņa', 'laura@gmail.com', 'Darbinieks', '$2y$12$ZW1LzqtjdehwkSnVGeqNCOiSla3gBbPNMeFE8Z/E6D1l0NGaNVike', '', NULL, '', NULL, 1),
(6, 'Martins', 'Zariņš', 'martins@gmail.com', 'Darbinieks', '$2y$12$WOA5OnE4doQbS7QHspexZuvo1dAxmwDHW5UMAP6SOl0wySkIp7n52', '', NULL, '', NULL, 1),
(7, 'Elina', 'Vītola', 'elina@gmail.com', 'Lietotajs', '$2y$12$wxuLkUUW7k4CE6ImT61lM.dNuiZ9OFD05RZ5vAjyF40bCtKVsoao.', '', NULL, '', NULL, 1),
(8, 'Admin', 'User', 'admin@example.com', 'Admin', '$2y$12$tubuRWD3Og4oQNge/s9Vt.ZEOfK7TwgDmzGnt3nRqPt4Lw4S383SW', 'admin@example.com', NULL, '$2y$12$JPkieSEOEGwUSUnlLnQ9I.NSfcasueE9WpZnWeW8hpcqzJxieoAXS', NULL, 1),
(9, 'Darbinieks', 'User', 'darbinieks@example.com', 'Darbinieks', '$2y$12$cba1TWbtybrylQvRzTFVFuHn9VeN8DpcgQUxBlYYwsPPCCTTzNsFC', 'darbinieks@example.com', NULL, '$2y$12$2ksXVl4LY7Rrv3Hcn1UqTO.IMLzHG7hLkiTPFos5l1fgxrQmrMl7a', NULL, 1),
(10, 'Lietotajs', 'User', 'lietotajs@example.com', 'Lietotajs', '$2y$12$dcmidUPYqSISkTPZM3XhJesPy6cP/vb8CGBArwo./xrl62F5jT/Xu', 'lietotajs@example.com', NULL, '$2y$12$W.BnVYl4IeFdO0r.UFeRmetT1gUQqn4gM8oSUj89nhEpmtC5wvHvK', NULL, 1),
(11, 'Mareks', 'Fortinate', 'tifomos396@smkanba.com', 'Lietotajs', '$2y$12$2g0qb.xzvO.CdbEJFhm03eNn1eu2DE9a/N1oR0oiu.IHtVDUMKziS', 'tifomos396@smkanba.com', NULL, '$2y$12$2g0qb.xzvO.CdbEJFhm03eNn1eu2DE9a/N1oR0oiu.IHtVDUMKziS', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_04_000000_create_telpa_table', 1),
(5, '2026_03_04_000001_create_lietotajs_table', 1),
(6, '2026_03_04_000002_create_rezerves_kopija_table', 1),
(7, '2026_03_04_000003_create_pasakumi_table', 1),
(8, '2026_03_11_000000_create_jaunumi_table', 1),
(9, '2026_03_11_201346_drop_ietilpiba_from_telpa_table', 2),
(10, '2026_03_13_110458_add_ietilpiba_to_telpa_table', 3),
(11, '2026_03_13_111901_add_email_password_to_lietotaji_table', 4),
(12, '2026_03_13_114337_change_parole_column_length_in_lietotaji_table', 4),
(13, '2026_03_04_000004_create_kategorijas_table', 5),
(14, '2026_03_21_094419_add_uzvards_to_lietotaji_table', 6),
(15, '2026_03_21_095208_create_pasakumi_images_table', 7),
(16, '2026_03_21_101629_add_registracijas_fields_to_pasakumi_table', 8),
(17, '2026_03_21_103459_create_jaunumi_images_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `pasakumi`
--

CREATE TABLE `pasakumi` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nosaukums` varchar(45) NOT NULL,
  `kategorija` varchar(45) DEFAULT NULL,
  `datums_no` date DEFAULT NULL,
  `datums_lidz` date NOT NULL,
  `sakuma_laiks` time DEFAULT NULL,
  `beigu_laiks` time DEFAULT NULL,
  `apraksts` varchar(255) DEFAULT NULL,
  `darbinieks_id` int(11) DEFAULT NULL,
  `telpa_id` int(11) DEFAULT NULL,
  `registracijas_beigu_datums` date DEFAULT NULL,
  `registracijas_beigu_laiks` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pasakumi`
--

INSERT INTO `pasakumi` (`ID`, `nosaukums`, `kategorija`, `datums_no`, `datums_lidz`, `sakuma_laiks`, `beigu_laiks`, `apraksts`, `darbinieks_id`, `telpa_id`, `registracijas_beigu_datums`, `registracijas_beigu_laiks`) VALUES
(1, 'Gramatu klubss', 'Izglitiba', '2025-04-01', '0000-00-00', '19:00:00', '20:00:00', 'Diskusija par jaunakam gramata', 2, NULL, NULL, NULL),
(2, 'Bernu pasaku vakars', 'Berniem', '2025-04-05', '0000-00-00', '17:00:00', '19:00:00', 'Pasaku lasisana berniem', 2, 2, NULL, NULL),
(3, 'Rakstnieka tikšanās', 'Kultura', '2025-04-10', '0000-00-00', '19:00:00', '21:00:00', 'Tikšanās ar slaveno rakstnieku', 1, 1, NULL, NULL),
(6, 'Radošā darbnīca bērniem', 'Izglītība', '2024-03-10', '2024-03-10', '10:00:00', '12:00:00', 'Radoša nodarbība bērniem ar dažādām aktivitātēm.', 1, 2, NULL, NULL),
(7, 'Sporta diena jauniešiem', 'Sports', '2024-03-12', '2024-03-12', '14:00:00', '17:00:00', 'Sporta pasākums ar sacensībām un spēlēm.', 2, 3, NULL, NULL),
(8, 'Mūzikas vakars', 'Kultūra', '2024-03-15', '2024-03-15', '18:00:00', '20:00:00', 'Neliels koncerts ar vietējiem māksliniekiem.', 3, 1, NULL, NULL),
(9, 'Veselības lekcija', 'Izglītība', '2024-03-18', '2024-03-18', '11:00:00', '12:30:00', 'Lekcija par veselīgu dzīvesveidu un uzturu.', 4, 4, NULL, NULL),
(10, 'Teātra izrāde', 'Kultūra', '2024-03-20', '2024-03-20', '19:00:00', '21:00:00', 'Amatierteātra izrāde visām vecuma grupām.', 5, 1, NULL, NULL),
(11, 'Rīta joga', 'Sports', '2024-03-22', '2024-03-22', '08:00:00', '09:00:00', 'Relaksējoša jogas nodarbība iesācējiem.', 2, 5, NULL, NULL),
(12, 'Digitālo prasmju kurss', 'Izglītība', '2024-03-25', '2024-03-26', '10:00:00', '13:00:00', 'Ievadkurss datorprasmēs un interneta lietošanā.', 1, 6, NULL, NULL),
(13, 'Kino vakars', 'Izklaide', '2024-03-28', '2024-03-28', '18:30:00', '20:30:00', 'Filmas vakars ar diskusiju pēc seansa.', 3, 2, NULL, NULL),
(14, 'Pavasara talka', 'Sabiedriskie darbi', '2024-03-30', '2024-03-30', '09:00:00', '12:00:00', 'Kopīga teritorijas sakopšana un darbi svaigā gaisā.', 4, 7, NULL, NULL),
(15, 'Rokdarbu meistarklase', 'Kultūra', '2024-04-02', '2024-04-02', '13:00:00', '15:00:00', 'Meistarklase rokdarbu tehnikās iesācējiem.', 5, 3, '2026-03-31', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pasakumi_images`
--

CREATE TABLE `pasakumi_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pasakumi_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pasakumu_atsauksmes`
--

CREATE TABLE `pasakumu_atsauksmes` (
  `ID` int(10) UNSIGNED NOT NULL,
  `pasakums_id` int(10) UNSIGNED NOT NULL,
  `lietotajs_id` int(10) UNSIGNED NOT NULL,
  `vertejums` tinyint(3) UNSIGNED NOT NULL,
  `atsauksme` varchar(1000) DEFAULT NULL,
  `izveidots_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pasakumu_pieteikumi`
--

CREATE TABLE `pasakumu_pieteikumi` (
  `ID` int(10) UNSIGNED NOT NULL,
  `pasakums_id` int(10) UNSIGNED NOT NULL,
  `lietotajs_id` int(10) UNSIGNED NOT NULL,
  `statuss` enum('Pieteikts','Atcelts','Apmeklets') NOT NULL DEFAULT 'Pieteikts',
  `pieteikts_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `apmeklets_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rezerveskopija`
--

CREATE TABLE `rezerveskopija` (
  `ID` int(10) UNSIGNED NOT NULL,
  `fails` varchar(45) NOT NULL,
  `izveides_datums` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rezerveskopija`
--

INSERT INTO `rezerveskopija` (`ID`, `fails`, `izveides_datums`) VALUES
(1, 'halo everynyan vzlomali', '2026-03-18');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('m9KN1Gg0QH1BPiZRZCilRnxaM5MEt8U3ocldyPMJ', 1, '77.111.247.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 OPR/128.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQ3NUWUFQcnhwMEFkV1FkRFRxdUhkekNCYUlGVGRPUHBNd3hIcEppRCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM4OiJodHRwczovL3Bhc2FrdW1pLmd0LnRjL3Bhc2FrdW1pL2NyZWF0ZSI7czo1OiJyb3V0ZSI7czoxNToicGFzYWt1bWkuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1774520898),
('MMgNAPMJsa8gUgtQFsI1rih1BgyhbEF1YzuPw3Ba', 1, '80.232.249.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNlBIU0xkMFdlUGZPVEN6VEIyeVBNUkk5a01yaTN3WVZUQkpGYVR0dyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wYXNha3VtaS5ndC50Yy9wYXNha3VtaSI7czo1OiJyb3V0ZSI7czoxNDoicGFzYWt1bWkuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1774447800),
('RkGKhw1uckVm9dXgFeOm0TwghFukEAOYLOY4huD8', 1, '77.111.247.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 OPR/128.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNno0a1BEaEZKVkgzWkd6SEFsSjBJU09jMWdWcmphdXpjSzBReFZJVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vcGFzYWt1bWkuZ3QudGMvcGFzYWt1bWkvMTUvZWRpdCI7czo1OiJyb3V0ZSI7czoxMzoicGFzYWt1bWkuZWRpdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1774447705),
('SUt6wHo53ZQIndbOsob1FdVZ6rVhjE5JTEtLbUpK', 1, '77.111.246.47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 OPR/128.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV3pKWjVxVkZrUnNLUXJIVDM2SkhDNk95Z0ZXbjlOaFBqUTRUMzY3cSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwczovL3Bhc2FrdW1pLmd0LnRjLz9pPTEiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1774447173),
('zyFIFckfTHySThtrmNKsPSxztm23cIY9DPWpI7XF', 1, '77.111.247.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 OPR/128.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYTZPZUd4SEdNc1N6WnlhR3E4RkpmRVFBN09CNEU3QWZnc2ZFQ1JVSSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM4OiJodHRwczovL3Bhc2FrdW1pLmd0LnRjL3Bhc2FrdW1pL2NyZWF0ZSI7czo1OiJyb3V0ZSI7czoxNToicGFzYWt1bWkuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1774511126);

-- --------------------------------------------------------

--
-- Table structure for table `telpa`
--

CREATE TABLE `telpa` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nosaukums` varchar(45) NOT NULL,
  `ietilpiba` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `telpa`
--

INSERT INTO `telpa` (`ID`, `nosaukums`, `ietilpiba`) VALUES
(2, 'Lielā lasītava', 50),
(3, 'Bērnu literatūras nodaļa', 20),
(4, 'Konferenču zāle', 100),
(5, 'Arhīvs', 10),
(6, 'Klusā studiju telpa', 15),
(7, 'Datorklase', 12),
(8, 'Periodikas nodaļa', 25);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-03-21 07:43:58', '$2y$12$xbpRUVNiueQ8IWUVMfFIbeazSCKxKYhDFFM/VBAaHtxtRfo3vUrV2', 'J4ZlpuO8hx', '2026-03-21 07:43:58', '2026-03-21 07:43:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jaunumi`
--
ALTER TABLE `jaunumi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jaunumi_images`
--
ALTER TABLE `jaunumi_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jaunumi_images_jaunumi_id_foreign` (`jaunumi_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategorijas`
--
ALTER TABLE `kategorijas`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `kategorijas_nosaukums_unique` (`nosaukums`);

--
-- Indexes for table `lietotaji`
--
ALTER TABLE `lietotaji`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `lietotaji_epasts_unique` (`epasts`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasakumi`
--
ALTER TABLE `pasakumi`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pasakumi_images`
--
ALTER TABLE `pasakumi_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasakumu_atsauksmes`
--
ALTER TABLE `pasakumu_atsauksmes`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique_atsauksme` (`pasakums_id`,`lietotajs_id`),
  ADD KEY `fk_atsauksme_pasakums` (`pasakums_id`),
  ADD KEY `fk_atsauksme_lietotajs` (`lietotajs_id`);

--
-- Indexes for table `pasakumu_pieteikumi`
--
ALTER TABLE `pasakumu_pieteikumi`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique_pasakums_lietotajs` (`pasakums_id`,`lietotajs_id`),
  ADD KEY `fk_pieteikums_pasakums` (`pasakums_id`),
  ADD KEY `fk_pieteikums_lietotajs` (`lietotajs_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `rezerveskopija`
--
ALTER TABLE `rezerveskopija`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `telpa`
--
ALTER TABLE `telpa`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jaunumi`
--
ALTER TABLE `jaunumi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `jaunumi_images`
--
ALTER TABLE `jaunumi_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategorijas`
--
ALTER TABLE `kategorijas`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lietotaji`
--
ALTER TABLE `lietotaji`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pasakumi`
--
ALTER TABLE `pasakumi`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pasakumi_images`
--
ALTER TABLE `pasakumi_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pasakumu_atsauksmes`
--
ALTER TABLE `pasakumu_atsauksmes`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasakumu_pieteikumi`
--
ALTER TABLE `pasakumu_pieteikumi`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rezerveskopija`
--
ALTER TABLE `rezerveskopija`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `telpa`
--
ALTER TABLE `telpa`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jaunumi_images`
--
ALTER TABLE `jaunumi_images`
  ADD CONSTRAINT `jaunumi_images_jaunumi_id_foreign` FOREIGN KEY (`jaunumi_id`) REFERENCES `jaunumi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pasakumu_atsauksmes`
--
ALTER TABLE `pasakumu_atsauksmes`
  ADD CONSTRAINT `fk_atsauksme_lietotajs` FOREIGN KEY (`lietotajs_id`) REFERENCES `lietotaji` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_atsauksme_pasakums` FOREIGN KEY (`pasakums_id`) REFERENCES `pasakumi` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `pasakumu_pieteikumi`
--
ALTER TABLE `pasakumu_pieteikumi`
  ADD CONSTRAINT `fk_pieteikums_lietotajs` FOREIGN KEY (`lietotajs_id`) REFERENCES `lietotaji` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pieteikums_pasakums` FOREIGN KEY (`pasakums_id`) REFERENCES `pasakumi` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
