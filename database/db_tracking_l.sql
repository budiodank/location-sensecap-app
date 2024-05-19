-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2024 at 05:10 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tracking_l`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_09_044210_create_tbl_device_table', 1),
(6, '2024_05_09_044253_create_tbl_location_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 'c77f157e-437e-4b41-a347-7581ff453233', 'MyApp', '54ee0cfb35ababaf3fd1712477a53c9ef20c0fb913069f2b226dfd30c74859c2', '{\"expires_at\":\"2024-05-09T17:38:31.959325Z\"}', NULL, NULL, '2024-05-09 15:38:31', '2024-05-09 15:38:31'),
(2, 'App\\Models\\User', 'c77f157e-437e-4b41-a347-7581ff453233', 'MyApp', 'ebaa4e1ac3f074b9d77b53cde8abb90862107c9c7ae5abbf742c78dddee06375', '{\"expires_at\":\"2024-05-09T17:39:22.119175Z\"}', NULL, NULL, '2024-05-09 15:39:22', '2024-05-09 15:39:22'),
(3, 'App\\Models\\User', 'c77f157e-437e-4b41-a347-7581ff453233', 'MyApp', '5ad8a156789d61205d9caea2d43b72add1e35cc8bded6b6be03cd0b59f1dccf8', '{\"expires_at\":\"2024-05-11T06:04:59.535347Z\"}', NULL, NULL, '2024-05-11 04:04:59', '2024-05-11 04:04:59'),
(4, 'App\\Models\\User', 'c77f157e-437e-4b41-a347-7581ff453233', 'MyApp', '6e1f7ba8efa30dd805f5f6e83ea2f62484804b78ccd22309542655932464caa0', '{\"expires_at\":\"2024-05-12T16:38:18.275000Z\"}', '2024-05-12 15:49:05', NULL, '2024-05-12 14:38:18', '2024-05-12 15:49:05'),
(5, 'App\\Models\\User', 'c77f157e-437e-4b41-a347-7581ff453233', 'MyApp', '97d7d658b5d8377a8fe5e0cd89e9d5a8c3ea17cd35545bea3fb3a6fca8f8c151', '{\"expires_at\":\"2024-05-13T15:16:34.493244Z\"}', '2024-05-13 14:34:09', NULL, '2024-05-13 13:16:34', '2024-05-13 14:34:09'),
(6, 'App\\Models\\User', 'c77f157e-437e-4b41-a347-7581ff453233', 'MyApp', '35ea97edf3bcbb0fd29150f922f470ab27b9260a55a5f6bc5aca829206a7de18', '{\"expires_at\":\"2024-05-13T16:46:08.843264Z\"}', NULL, NULL, '2024-05-13 14:46:08', '2024-05-13 14:46:08'),
(7, 'App\\Models\\User', 'c77f157e-437e-4b41-a347-7581ff453233', 'MyApp', 'dcc9c0fa6c36e4421386ca8a72455228d745a5f8020d4944e187f4b71e743f09', '{\"expires_at\":\"2024-05-13T16:48:42.633302Z\"}', NULL, NULL, '2024-05-13 14:48:42', '2024-05-13 14:48:42'),
(8, 'App\\Models\\User', 'c77f157e-437e-4b41-a347-7581ff453233', 'MyApp', 'f02841835cc7c8811ab4b0e28c9e5a233da24bc2a2bd188a731836e21d0e195b', '{\"expires_at\":\"2024-05-13T16:49:55.918693Z\"}', NULL, NULL, '2024-05-13 14:49:55', '2024-05-13 14:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device`
--

CREATE TABLE `tbl_device` (
  `device_uuid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `online_status` enum('Online','Offline') COLLATE utf8mb4_unicode_ci NOT NULL,
  `node_eui` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_device`
--

INSERT INTO `tbl_device` (`device_uuid`, `device_name`, `online_status`, `node_eui`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
('9c06aff9-0e55-4950-994c-5fc8eec9f222', 'Tracker T1000-A', 'Offline', '2CF7F1C0530003E4', 'Admin', 'Admin', '2024-05-12 14:49:20', '2024-05-12 14:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `node_eui` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_tm` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`id`, `longitude`, `latitude`, `node_eui`, `created_tm`, `created_at`) VALUES
(1, '106.596504', '-6.186363', '2CF7F1C0530003E4', '2024-05-05 01:24:40', '2024-05-13 21:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('SuperAdmin','Admin','User') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
('c77f157e-437e-4b41-a347-7581ff453233', 'Admin', 'admin@admin.id', NULL, '$2y$12$AySa1PO.cPX.MPzlJSWLtOQQ4/V.xzViG1JOOqZxPO2xN9w/tgKui', NULL, 'Admin', '2024-05-09 10:10:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tbl_device`
--
ALTER TABLE `tbl_device`
  ADD PRIMARY KEY (`device_uuid`),
  ADD UNIQUE KEY `tbl_device_node_eui_unique` (`node_eui`);

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
