-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 02:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crtrwl_mis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `admin_details_id` int(10) UNSIGNED DEFAULT NULL,
  `mobile_no` varchar(50) DEFAULT NULL,
  `admin_name` varchar(255) NOT NULL,
  `profile_path` varchar(255) DEFAULT NULL,
  `alt_mobile_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_id` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `prev_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('council_office','registar','superadmin') DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `otp_verified_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_created_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `admin_details_id`, `mobile_no`, `admin_name`, `profile_path`, `alt_mobile_no`, `email_id`, `password`, `prev_password`, `role`, `gender`, `otp_verified_at`, `last_login`, `last_ip`, `password_created_at`, `created_at`, `updated_at`) VALUES
(1, 1, '8092213051', '', NULL, '7979040859', 'gouravatced11@gmail.com', '$2y$12$bVRQNcgP.DtHRnTSpr0kVOHUoM0gvA4x7vPlcmkSRhgBK9IOfp72.', NULL, 'superadmin', NULL, '2026-02-06 04:23:12', '2026-02-06 05:15:49', '127.0.0.1', '2026-02-06 05:13:19', '2024-09-09 08:48:35', '2026-02-06 05:31:27'),
(3, 3, '7979040859', 'Gourav Computered', 'admin_pic/1770797011_photo-1494790108377-be9c29b29330.jpeg', '7979040859', 'gouravatced@gmail.com', '$2y$12$FBSwitUzL/xEW1.U4oPfJOEsC1hzNrE4OqY1LPRLrW/sbNJUmWCCe', NULL, 'council_office', 'Male', '2026-02-18 04:19:42', '2026-02-18 04:19:42', '127.0.0.1', NULL, '2024-10-07 09:26:19', '2026-02-18 04:19:42'),
(4, 5, '8943756934', '', NULL, NULL, 'adminjshb2@gmail.com', '$2y$12$jwhx2V/0Ulgp9ibeLUnifOtPBvqzbMOPsU73wzdnskZqSulGmTn2W', NULL, 'registar', NULL, '2026-01-27 20:02:37', '2026-01-27 20:02:37', '47.31.85.195', NULL, '2024-10-23 10:43:58', '2026-02-05 12:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female','Other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `whatsapp` varchar(15) DEFAULT NULL,
  `mobile_no` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_mobile_no` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_pic` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`id`, `name`, `gender`, `email`, `whatsapp`, `mobile_no`, `alt_mobile_no`, `profile_pic`, `created_at`, `updated_at`) VALUES
(1, 'Vikash Goswami Superadmin', 'Male', 'dsfd@gdsfsfg', '8092213051', '7979040859', '8092213051', NULL, '2024-09-09 08:47:51', '2024-09-18 15:52:27'),
(2, 'Sandeep Kumar', 'Male', 'test@gmail.com', '9709107466', '9709107466', '8804283202', NULL, '2024-10-07 09:25:26', '2024-10-07 09:25:26'),
(3, 'Vikash Goswami', 'Male', 'admin@admin.com', '8092213051', '8092213051', '7979040859', NULL, '2024-10-07 09:26:18', '2024-10-07 09:26:18'),
(4, 'Vikash Develoer', 'Male', 'registrarvg@jspc.com', '8092213051', '9939314990', NULL, NULL, '2024-10-23 10:32:54', '2024-10-23 10:32:54'),
(5, 'Vikash Develoer', 'Male', 'dev@jspc.com', '8092213051', '9905562396', NULL, NULL, '2024-10-23 10:43:58', '2024-10-23 10:43:58'),
(6, 'Dr Deepak Lakra', 'Male', 'registrar@jspc.com', '9470932501', '9470932501', '7004954544', 'jspc.jpg', '2024-10-23 10:45:20', '2024-10-23 10:45:20'),
(7, 'Ravi', 'Male', 'ravi@jspc.com', '7004220173', '7004220173', '7004220173', NULL, '2025-02-20 10:25:22', '2025-02-20 10:25:22'),
(8, 'COMPUTER Ed. Office', 'Male', 'office@ced.com', '7545900666', '7545900666', '9999999999', 'admin_pic/1760427763_payment ref.jpg', '2025-10-13 23:19:24', '2025-10-14 02:12:54'),
(9, 'COMPUTER Ed. Office', 'Other', 'office@ced.com', '7545900666', '1234567890', '7545900666', NULL, '2025-10-13 23:22:15', '2025-10-13 23:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `admin_otp_logs`
--

CREATE TABLE `admin_otp_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login_with` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_otp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','verified','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `otp_expiration` timestamp NULL DEFAULT NULL,
  `otp_hmac` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `attempts` int(11) NOT NULL DEFAULT 0,
  `send_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `veified_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin_otp_logs`
--

INSERT INTO `admin_otp_logs` (`id`, `login_with`, `hashed_otp`, `status`, `otp_expiration`, `otp_hmac`, `description`, `attempts`, `send_ip`, `veified_ip`, `created_at`, `updated_at`) VALUES
(1, '7979040859', '$2y$12$3CdESOAJvHY3v6Cv/2RJQu3tWdlQkjD.Sm5qXw5L6MD99ZELKmDqK', 'expired', '2026-02-03 06:18:02', '5f04c0beb35f9a7fa095ccb1e1b9128246a21b39124e236f4b38aed578cb2d4e', 'Login', 2, '127.0.0.1', '0', '2026-02-03 06:03:02', '2026-02-03 12:18:55'),
(2, '7979040859', '$2y$12$4A3DNZbrFID3qsJ9RrJAv.G2zw22pRvVwgyYD9e/Q.VPAC3e4LTMe', 'expired', '2026-02-03 06:19:06', 'fbd086f6d7da712fe1b979c57fb783ef80795528021fac4ea9e4ca2bd9ef7818', 'Login', 0, '127.0.0.1', '0', '2026-02-03 06:04:06', '2026-02-03 12:18:35'),
(3, '7979040859', '$2y$12$40lD0o7xdc4r9ZiOpTOVXOn96MtzUvPgZrE0551VP084dc5U7nI8K', 'pending', '2026-02-03 12:33:11', 'e27eaeae19900b11a27f66956fc51d7236f966ef1e1176ddef240ff34aead8a4', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-03 12:18:11', '2026-02-03 12:19:15'),
(4, '7979040859', '$2y$12$K80qgwKgQVQRszCXhlPGbOlcnyTUXUY6J5kVIcr.MO.i366NJzV9a', 'pending', '2026-02-03 12:35:49', '81dfecfaf8583cc2220d9e9c50db16956ab90dc3d00a6060501afcf0bd509862', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-03 12:20:49', '2026-02-03 12:21:07'),
(5, '8092213051', '$2y$12$fJvmq1r6BDAAkm7/eH0D9.fMl9GQwejda2rrYez6GMVkRPBuqdOvi', 'pending', '2026-02-05 12:55:45', 'd5190c95e0194156fc79f29a567e0e00377bb624b5c7c7ce43fb81ee830d76a3', 'Login', 0, '127.0.0.1', '0', '2026-02-05 12:40:45', '2026-02-05 12:40:45'),
(6, 'gouravatced@gmail.com', '$2y$12$fbc4CCc9ZOef1hsoIbOXpOU/ONrq3dX9SEfoqH8ARtj131DWOBwoa', 'pending', '2026-02-06 04:30:04', '55d68daac0885a6c6686c15f0a4fbde37567ed24fd5109eb6184b611278b94b3', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 04:15:04', '2026-02-06 04:15:04'),
(7, 'gouravatced@gmail.com', '$2y$12$WVfD3HQDTka3648uUkk7rudiTJZTEmuFvQ1w0evuZBgyj.hJSjoPS', 'pending', '2026-02-06 04:32:49', '9fc4e0d66553c5dfc455715f48b4a75ce430d80db84a730dbfbd10aebda5764f', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 04:17:49', '2026-02-06 04:17:49'),
(8, 'gouravatced@gmail.com', '$2y$12$4eQUOPNowYuOmDRvp.SLQeyhqKujX.lswbprPaZT77PTrxziEtq8i', 'pending', '2026-02-06 04:34:53', '4971430cc6bbb5fc7622ce615e835fa923affe72c04ec91a93fd681151dcf2e5', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 04:19:53', '2026-02-06 04:19:53'),
(9, 'gouravatced@gmail.com', '$2y$12$pq1/4Izwbau7vIFRYeJYmOpfJEp4jhyk0mJgEGYM0M6G8jkFMe7Ni', 'verified', '2026-02-06 04:37:54', '53dc7862b0d3a4cb206b316dae15fec23555d213b92051d5692d90022d02ca2c', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 04:22:54', '2026-02-06 04:23:12'),
(10, 'gouravatced@gmail.com', '$2y$12$tfbglX5HIcP3Jj5u2OrtbemB5xyF0rgjd2dzgeKIZEc6SOnAXZRGK', 'pending', '2026-02-06 04:38:45', 'b40d5b510f8b9290ca9a7d08d56890baccf31626ce8a6c4dd868e26268964c77', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 04:23:45', '2026-02-06 04:23:45'),
(11, 'gouravatced@gmail.com', '$2y$12$48ABM/xCcCZO6QF6zWs40e1LyDLUiiYXNDX0DXFABaQnWi4FV8nq.', 'pending', '2026-02-06 04:43:39', '63cc059d19669ffbf96bf45eaabcf73042b24e9a1a7a29297929a89bf72d1153', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 04:28:39', '2026-02-06 04:28:39'),
(12, 'gouravatced@gmail.com', '$2y$12$RmWglyM9tx8PxcTnV3PibO4ujmb0O13q1SNTaT32dqvqXK4SDzPM.', 'pending', '2026-02-06 04:44:45', 'b71ea9ed76d78df359e250fdfc0587292274e426fd8ecfd448ca9fe0846d8f24', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 04:29:45', '2026-02-06 04:29:45'),
(13, 'gouravatced@gmail.com', '$2y$12$5u5uAVovyzW4ah6dswB5ee3uUo0uLYdGwd7AXu2obUJxezn7dAs7y', 'pending', '2026-02-06 05:25:03', '18e73fe5a6146728a25dd32bbc39bf7d61b4d7c533a062783fef3afc7adb7a90', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 05:10:03', '2026-02-06 05:10:03'),
(14, 'gouravatced@gmail.com', '$2y$12$U4sSOV.Kb98wiOJF9g/LGOEt2oPIxLD2l9Q1QvECrCXfoWS/oUbva', 'pending', '2026-02-06 05:27:58', 'bd890b5af6b65c21d06f075d57358fe23c255ec3ff3e3c3188079869949b8171', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 05:12:58', '2026-02-06 05:12:58'),
(15, 'gouravatced@gmail.com', '$2y$12$i8Wd10N3F6vkhKic.pn7h.4dy11W3e0jTdpxIeKn3NIdYKDjc1Uh2', 'verified', '2026-02-06 05:46:48', 'edaee214149f01911d49bc7dbf6f7dd90053e46c54a760a89e0e40a3db389c23', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 05:31:48', '2026-02-06 05:32:27'),
(16, 'gouravatced@gmail.com', '$2y$12$TbAUS4YuLPuDDRj63d2seer1zOL2nRVU3hw9WtLriXynW3zGWnRdG', 'verified', '2026-02-06 09:56:54', 'dabe844737c7b883d18d86177016295dc405be2f143443270ab9f205aa3bffb4', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-06 09:41:54', '2026-02-06 09:42:18'),
(17, 'gouravatced@gmail.com', '$2y$12$pGtPGOtQNwZRP98Gu2XPCepR3c0rTxs0mrvzPdXheB0Gx8uVEg./q', 'verified', '2026-02-07 04:21:37', '72ed27f742a29429d0c4f2aa80bbe281bcde4492117d2cb70f3619f72e9d9d77', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-07 04:06:37', '2026-02-07 04:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `allottee_file_details`
--

CREATE TABLE `allottee_file_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allottee_file_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `actual_pages` int(11) NOT NULL DEFAULT 0,
  `scanned_pages` int(11) NOT NULL DEFAULT 0,
  `damage_pages` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allottee_file_details`
--

INSERT INTO `allottee_file_details` (`id`, `allottee_file_id`, `file_name`, `actual_pages`, `scanned_pages`, `damage_pages`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 10, 'File 1', 55, 9, 19, 1, NULL, '2026-02-19 08:01:28', '2026-02-19 08:01:28'),
(2, 10, 'File 2', 43, 8, 38, 1, NULL, '2026-02-19 08:01:28', '2026-02-19 08:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `application_number` varchar(255) DEFAULT NULL,
  `allotment_date` varchar(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `pan_card_number` varchar(255) NOT NULL,
  `aadhar_card_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login_id` varchar(255) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `caste` varchar(50) NOT NULL,
  `fathers_name` varchar(255) NOT NULL,
  `full_name_hindi` varchar(255) NOT NULL,
  `annual_income` varchar(255) NOT NULL,
  `present_address` text NOT NULL,
  `post_office` varchar(255) NOT NULL,
  `police_station` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `pin_code` varchar(255) NOT NULL,
  `telephone_number` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `nominee_name` varchar(255) DEFAULT NULL,
  `nominee_relationship` varchar(255) DEFAULT NULL,
  `nominee_pan_card` varchar(255) DEFAULT NULL,
  `nominee_aadhaar` varchar(255) DEFAULT NULL,
  `family_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`family_details`)),
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `bank_branch` varchar(255) DEFAULT NULL,
  `division_office` varchar(255) DEFAULT NULL,
  `property_location` varchar(255) DEFAULT NULL,
  `yojana_name` varchar(255) DEFAULT NULL,
  `property_area` varchar(255) DEFAULT NULL,
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_details`)),
  `current_step` int(11) DEFAULT 1,
  `is_completed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `user_id`, `application_number`, `allotment_date`, `first_name`, `middle_name`, `last_name`, `marital_status`, `gender`, `pan_card_number`, `aadhar_card_number`, `email`, `login_id`, `date_of_birth`, `caste`, `fathers_name`, `full_name_hindi`, `annual_income`, `present_address`, `post_office`, `police_station`, `state`, `district`, `pin_code`, `telephone_number`, `mobile_number`, `nominee_name`, `nominee_relationship`, `nominee_pan_card`, `nominee_aadhaar`, `family_details`, `bank_name`, `bank_account_no`, `bank_branch`, `division_office`, `property_location`, `yojana_name`, `property_area`, `payment_details`, `current_step`, `is_completed`, `created_at`, `updated_at`) VALUES
(1, 1, 'JSHBA-1748087931', '2003-10-22', 'gourav', NULL, 'atced', 'Unmarried', 'Female', 'ABCDE1234Z', '534534534534', 'gouravatced3311@gmail.com', 'greenid345', '2026-02-24', 'General', 'Genevieve Wiggins', 'gourav atced', '2', 'test', 'Quasi laboriosam in', 'Atque eius77', 'JHARKHAND', 'PALAMU', '666656', NULL, '5465464566', 'Daniel Davenport', 'Similique ullam culp', 'ABCDE1234F', '093485028450', '[{\"name\":\"Chiquita Coffey\"},{\"gender\":\"Other\"},{\"dob\":\"2015-11-10\"},{\"relationship\":\"Eiusmod cillum delec\"},{\"aadhaar\":\"093862375973\"},{\"pan\":\"Ut inventore quis ap\"}]', 'Evan Luna', 'Deleniti enim est v', 'Ea obcaecati illo ex', NULL, NULL, NULL, NULL, NULL, 1, 0, '2026-02-20 12:00:41', '2026-02-20 13:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('captcha_0da9e66f8f545cfd72eb6d13f95c29bc', 'a:5:{i:0;s:1:\"n\";i:1;s:1:\"o\";i:2;s:1:\"6\";i:3;s:1:\"h\";i:4;s:1:\"d\";}', 1771647562),
('captcha_26c1b3b9f5705a13278f45790037c5c0', 'a:6:{i:0;s:1:\"s\";i:1;s:1:\"v\";i:2;s:1:\"4\";i:3;s:1:\"m\";i:4;s:1:\"7\";i:5;s:1:\"v\";}', 1771648076),
('captcha_31c743274faea0d5dbc14e0ea86552aa', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"h\";i:2;s:1:\"c\";i:3;s:1:\"x\";i:4;s:1:\"q\";}', 1771648177),
('captcha_3569878e3a36955e26c1646d88eb5fde', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"i\";i:2;s:1:\"b\";i:3;s:1:\"6\";i:4;s:1:\"m\";}', 1771648143),
('captcha_4458919a27f720a88640920c9f9b7d8d', 'a:6:{i:0;s:1:\"l\";i:1;s:1:\"w\";i:2;s:1:\"3\";i:3;s:1:\"s\";i:4;s:1:\"4\";i:5;s:1:\"k\";}', 1771648070),
('captcha_44e24286de8555624f33f6be603d5ea2', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"j\";i:2;s:1:\"t\";i:3;s:1:\"c\";i:4;s:1:\"v\";}', 1771648147),
('captcha_4b1efe71f1c3d45136d8e73c2a30ebb4', 'a:6:{i:0;s:1:\"e\";i:1;s:1:\"k\";i:2;s:1:\"x\";i:3;s:1:\"y\";i:4;s:1:\"f\";i:5;s:1:\"w\";}', 1771647926),
('captcha_4c247ef8421d8c6786c0d4a9318318b2', 'a:5:{i:0;s:1:\"c\";i:1;s:1:\"s\";i:2;s:1:\"f\";i:3;s:1:\"0\";i:4;s:1:\"n\";}', 1771648189),
('captcha_4eb3d29dfa71e0cf2c8f0d2e78ad70f6', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"h\";i:2;s:1:\"g\";i:3;s:1:\"7\";i:4;s:1:\"h\";}', 1771490996),
('captcha_4f7317d7fbb5deb319e6f9bf2a3a286e', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"q\";i:2;s:1:\"f\";i:3;s:1:\"v\";i:4;s:1:\"y\";}', 1771838469),
('captcha_52a23f4dcb28ec849d37530d839951bc', 'a:6:{i:0;s:1:\"y\";i:1;s:1:\"6\";i:2;s:1:\"e\";i:3;s:1:\"t\";i:4;s:1:\"k\";i:5;s:1:\"q\";}', 1771647909),
('captcha_5513a391a164160f824a05e649de2ee4', 'a:5:{i:0;s:1:\"b\";i:1;s:1:\"s\";i:2;s:1:\"u\";i:3;s:1:\"w\";i:4;s:1:\"v\";}', 1771648178),
('captcha_5db6bfd0c63a87cdc994cd6bc8a8a103', 'a:5:{i:0;s:1:\"7\";i:1;s:1:\"r\";i:2;s:1:\"8\";i:3;s:1:\"z\";i:4;s:1:\"m\";}', 1771648168),
('captcha_5ea9ed93135461ed24fb27b0177b7304', 'a:5:{i:0;s:1:\"p\";i:1;s:1:\"y\";i:2;s:1:\"t\";i:3;s:1:\"n\";i:4;s:1:\"f\";}', 1771648427),
('captcha_63fd02b2891fe39993e8a3f80f16487b', 'a:5:{i:0;s:1:\"w\";i:1;s:1:\"8\";i:2;s:1:\"w\";i:3;s:1:\"e\";i:4;s:1:\"w\";}', 1771571077),
('captcha_6f685cc5146095fe87d7d269164b115c', 'a:5:{i:0;s:1:\"e\";i:1;s:1:\"b\";i:2;s:1:\"e\";i:3;s:1:\"j\";i:4;s:1:\"z\";}', 1771648425),
('captcha_75e004c08aa6ef06f0a32dbc20d46196', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"4\";i:2;s:1:\"y\";i:3;s:1:\"r\";i:4;s:1:\"r\";}', 1771578153),
('captcha_7834933589aed19a8c9a167bf6cb4f48', 'a:5:{i:0;s:1:\"8\";i:1;s:1:\"g\";i:2;s:1:\"o\";i:3;s:1:\"o\";i:4;s:1:\"l\";}', 1771648187),
('captcha_7df46d033b029ef64b0188246b835c02', 'a:5:{i:0;s:1:\"x\";i:1;s:1:\"d\";i:2;s:1:\"7\";i:3;s:1:\"p\";i:4;s:1:\"z\";}', 1771560863),
('captcha_95f8ee38e02f9c585bbda01329dd7953', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"y\";i:2;s:1:\"j\";i:3;s:1:\"f\";i:4;s:1:\"h\";}', 1771648177),
('captcha_97db0f9a9398a205685b6dab182dfb3c', 'a:5:{i:0;s:1:\"u\";i:1;s:1:\"k\";i:2;s:1:\"s\";i:3;s:1:\"o\";i:4;s:1:\"t\";}', 1771647570),
('captcha_a0cb3c3d05cda43480c4c876757a4d98', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"c\";i:2;s:1:\"r\";i:3;s:1:\"0\";i:4;s:1:\"u\";}', 1771648173),
('captcha_a5ec07157cb405265b682ce3bb0f675d', 'a:6:{i:0;s:1:\"a\";i:1;s:1:\"d\";i:2;s:1:\"e\";i:3;s:1:\"w\";i:4;s:1:\"a\";i:5;s:1:\"u\";}', 1771648075),
('captcha_ab56751ca75d0965d47211f954497666', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"y\";i:2;s:1:\"3\";i:3;s:1:\"m\";i:4;s:1:\"7\";}', 1771648179),
('captcha_af86538007bd5edb5244d11dad503b19', 'a:6:{i:0;s:1:\"7\";i:1;s:1:\"5\";i:2;s:1:\"2\";i:3;s:1:\"y\";i:4;s:1:\"l\";i:5;s:1:\"d\";}', 1771647984),
('captcha_c143fef5dce66e2b50232ee0e0beb14f', 'a:5:{i:0;s:1:\"7\";i:1;s:1:\"q\";i:2;s:1:\"c\";i:3;s:1:\"d\";i:4;s:1:\"l\";}', 1771648199),
('captcha_cb0f8a44a5105b3ceeb826fc9f2d1f3a', 'a:6:{i:0;s:1:\"4\";i:1;s:1:\"d\";i:2;s:1:\"m\";i:3;s:1:\"4\";i:4;s:1:\"x\";i:5;s:1:\"s\";}', 1771647875),
('captcha_cb746b8aac9b55df7c71361d5ece9559', 'a:6:{i:0;s:1:\"5\";i:1;s:1:\"4\";i:2;s:1:\"y\";i:3;s:1:\"4\";i:4;s:1:\"p\";i:5;s:1:\"6\";}', 1771647990),
('captcha_d2f037f31bd75095506234c4493a5c87', 'a:6:{i:0;s:1:\"m\";i:1;s:1:\"r\";i:2;s:1:\"b\";i:3;s:1:\"d\";i:4;s:1:\"m\";i:5;s:1:\"h\";}', 1771648111),
('captcha_dc09a3162147595f7fb9f76180d2c78f', 'a:5:{i:0;s:1:\"q\";i:1;s:1:\"n\";i:2;s:1:\"a\";i:3;s:1:\"o\";i:4;s:1:\"1\";}', 1771648188),
('captcha_e8f0b5a4cc560152c975e4bb00ebaa8d', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"b\";i:2;s:1:\"y\";i:3;s:1:\"x\";i:4;s:1:\"j\";}', 1771648201),
('captcha_f898eb87164d0d99b62216c00321c320', 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"c\";i:2;s:1:\"f\";i:3;s:1:\"h\";i:4;s:1:\"j\";}', 1771648175);

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
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `duration_year` int(1) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ranchi Division', 1, '2026-02-05 17:09:52', '2026-02-06 12:54:53'),
(2, 'Jamshedpur Division', 1, '2026-02-05 17:14:35', NULL),
(3, 'Dumka Division', 1, '2026-02-05 17:15:43', NULL),
(4, 'Dhanbad Division', 1, '2026-02-05 17:15:43', '2026-02-06 12:54:51'),
(5, 'Hazaribagh Division', 1, '2026-02-05 17:15:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exported_files`
--

CREATE TABLE `exported_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `register_no` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exported_files`
--

INSERT INTO `exported_files` (`id`, `register_no`, `file_name`, `file_path`, `file_size`, `created_at`, `updated_at`) VALUES
(1, '1402264703', 'Files-Receiving-1402264703-1771216170.pdf', 'uploads/1402264703/files/Files-Receiving-1402264703-1771216170.pdf', 178654, '2026-02-16 04:29:33', NULL),
(2, '1402264703', 'Files-Receiving-1402264703-1771216187.pdf', 'uploads/1402264703/files/Files-Receiving-1402264703-1771216187.pdf', 178655, '2026-02-16 04:29:48', NULL),
(3, '1602268647', '1702269267-ced-jshb-receiving.pdf', 'uploads/1602268647/files/1702269267-ced-jshb-receiving.pdf', 178530, '2026-02-17 04:55:14', NULL),
(4, '1602268647', '1702266024-ced-jshb-receiving.pdf', 'uploads/1602268647/files/1702266024-ced-jshb-receiving.pdf', 178530, '2026-02-17 04:55:31', NULL),
(5, '1602268647', '1702266475-ced-jshb-receiving.pdf', 'uploads/1602268647/files/1702266475-ced-jshb-receiving.pdf', 178390, '2026-02-17 05:00:14', NULL),
(6, '1702264923', '1702262059-ced-jshb-receiving.pdf', 'uploads/1702264923/files/1702262059-ced-jshb-receiving.pdf', 177736, '2026-02-17 06:18:20', NULL),
(7, '2302269882', '2302267298-ced-jshb-receiving.pdf', 'uploads/2302269882/files/2302267298-ced-jshb-receiving.pdf', 179320, '2026-02-23 09:35:22', NULL);

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
-- Table structure for table `file_registrations`
--

CREATE TABLE `file_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lot_no` varchar(50) DEFAULT NULL,
  `register_no` varchar(20) NOT NULL,
  `total_files` int(11) DEFAULT 0,
  `allowed_files` varchar(50) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` enum('handover','received','scanned') DEFAULT 'received',
  `scanned_by` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_registrations`
--

INSERT INTO `file_registrations` (`id`, `lot_no`, `register_no`, `total_files`, `allowed_files`, `remarks`, `status`, `scanned_by`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Lot-1', '2302266678', 2, '2', NULL, 'scanned', 1, 1, '2026-02-23 09:24:56', '2026-02-23 11:11:35'),
(2, 'Lot-2', '2302269882', 3, '3', NULL, 'received', NULL, 2, '2026-02-23 09:29:51', '2026-02-23 09:29:51');

-- --------------------------------------------------------

--
-- Table structure for table `headquater`
--

CREATE TABLE `headquater` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `headquater`
--

INSERT INTO `headquater` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'HQ (Ranchi)', 1, '2026-02-05 17:09:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `indian_states`
--

CREATE TABLE `indian_states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` enum('State','Union Territory') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `indian_states`
--

INSERT INTO `indian_states` (`id`, `name`, `type`, `created_at`) VALUES
(1, 'Andhra Pradesh', 'State', '2024-07-29 01:51:51'),
(2, 'Arunachal Pradesh', 'State', '2024-07-29 01:51:51'),
(3, 'Assam', 'State', '2024-07-29 01:51:51'),
(4, 'Bihar', 'State', '2024-07-29 01:51:51'),
(5, 'Chhattisgarh', 'State', '2024-07-29 01:51:51'),
(6, 'Goa', 'State', '2024-07-29 01:51:51'),
(7, 'Gujarat', 'State', '2024-07-29 01:51:51'),
(8, 'Haryana', 'State', '2024-07-29 01:51:51'),
(9, 'Himachal Pradesh', 'State', '2024-07-29 01:51:51'),
(10, 'Jharkhand', 'State', '2024-07-29 01:51:51'),
(11, 'Karnataka', 'State', '2024-07-29 01:51:51'),
(12, 'Kerala', 'State', '2024-07-29 01:51:51'),
(13, 'Madhya Pradesh', 'State', '2024-07-29 01:51:51'),
(14, 'Maharashtra', 'State', '2024-07-29 01:51:51'),
(15, 'Manipur', 'State', '2024-07-29 01:51:51'),
(16, 'Meghalaya', 'State', '2024-07-29 01:51:51'),
(17, 'Mizoram', 'State', '2024-07-29 01:51:51'),
(18, 'Nagaland', 'State', '2024-07-29 01:51:51'),
(19, 'Odisha', 'State', '2024-07-29 01:51:51'),
(20, 'Punjab', 'State', '2024-07-29 01:51:51'),
(21, 'Rajasthan', 'State', '2024-07-29 01:51:51'),
(22, 'Sikkim', 'State', '2024-07-29 01:51:51'),
(23, 'Tamil Nadu', 'State', '2024-07-29 01:51:51'),
(24, 'Telangana', 'State', '2024-07-29 01:51:51'),
(25, 'Tripura', 'State', '2024-07-29 01:51:51'),
(26, 'Uttar Pradesh', 'State', '2024-07-29 01:51:51'),
(27, 'Uttarakhand', 'State', '2024-07-29 01:51:51'),
(28, 'West Bengal', 'State', '2024-07-29 01:51:51'),
(29, 'Andaman and Nicobar Islands', 'Union Territory', '2024-07-29 01:51:51'),
(30, 'Chandigarh', 'Union Territory', '2024-07-29 01:51:51'),
(31, 'Dadra and Nagar Haveli and Daman and Diu', 'Union Territory', '2024-07-29 01:51:51'),
(32, 'Delhi', 'Union Territory', '2024-07-29 01:51:51'),
(33, 'Jammu and Kashmir', 'Union Territory', '2024-07-29 01:51:51'),
(34, 'Ladakh', 'Union Territory', '2024-07-29 01:51:51'),
(35, 'Lakshadweep', 'Union Territory', '2024-07-29 01:51:51'),
(36, 'Puducherry', 'Union Territory', '2024-07-29 01:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `institute_id` int(11) NOT NULL,
  `category` enum('Government','Private') NOT NULL,
  `code` char(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL DEFAULT 'Jharkhand',
  `district` varchar(100) DEFAULT NULL,
  `pin` char(6) DEFAULT NULL,
  `primary_mobile_no` varchar(15) DEFAULT NULL,
  `alternate_mobile_no` varchar(15) DEFAULT NULL,
  `landline` varchar(20) DEFAULT NULL,
  `whatsapp_mobile_no` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `principal_name` varchar(255) DEFAULT NULL,
  `exam_dept_contact_person` varchar(255) DEFAULT NULL,
  `exam_dept_mobile_no` varchar(15) DEFAULT NULL,
  `exam_dept_whatsapp_mobile_no` varchar(15) DEFAULT NULL,
  `exam_dept_email` varchar(255) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`institute_id`, `category`, `code`, `name`, `address`, `city`, `state`, `district`, `pin`, `primary_mobile_no`, `alternate_mobile_no`, `landline`, `whatsapp_mobile_no`, `email`, `website`, `principal_name`, `exam_dept_contact_person`, `exam_dept_mobile_no`, `exam_dept_whatsapp_mobile_no`, `exam_dept_email`, `created_on`, `created_by`, `updated_on`, `updated_by`) VALUES
(1, 'Government', '01', 'Government Paramedical Institute, RIMS', 'Ranchi', 'Ranchi', 'Jharkhand', 'Ranchi', '834009', '9876543210', NULL, NULL, NULL, 'gpirimsranchi@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'admin', '2024-10-28 03:38:32', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `institutes_web`
--

CREATE TABLE `institutes_web` (
  `institute_id` int(11) NOT NULL,
  `category` enum('Government','Private') NOT NULL,
  `code` char(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL DEFAULT 'Jharkhand',
  `district` varchar(100) DEFAULT NULL,
  `pin` char(6) DEFAULT NULL,
  `primary_mobile_no` varchar(15) DEFAULT NULL,
  `alternate_mobile_no` varchar(15) DEFAULT NULL,
  `landline` varchar(20) DEFAULT NULL,
  `whatsapp_mobile_no` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `principal_name` varchar(255) DEFAULT NULL,
  `exam_dept_contact_person` varchar(255) DEFAULT NULL,
  `exam_dept_mobile_no` varchar(15) DEFAULT NULL,
  `exam_dept_whatsapp_mobile_no` varchar(15) DEFAULT NULL,
  `exam_dept_email` varchar(255) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institutes_web`
--

INSERT INTO `institutes_web` (`institute_id`, `category`, `code`, `name`, `address`, `city`, `state`, `district`, `pin`, `primary_mobile_no`, `alternate_mobile_no`, `landline`, `whatsapp_mobile_no`, `email`, `website`, `principal_name`, `exam_dept_contact_person`, `exam_dept_mobile_no`, `exam_dept_whatsapp_mobile_no`, `exam_dept_email`, `created_on`, `created_by`, `updated_on`, `updated_by`) VALUES
(1, 'Government', '01', 'Government Paramedical Institute, RIMS', 'Ranchi', 'Ranchi', 'Jharkhand', 'Ranchi', '834009', '9876543210', NULL, NULL, NULL, 'gpirimsranchi@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'admin', '2024-10-28 03:38:32', 'admin');

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
(2, '0001_01_01_000001_create_cache_table', 2),
(3, '0001_01_01_000002_create_jobs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `otp_logs`
--

CREATE TABLE `otp_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login_with` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_otp` varchar(255) NOT NULL,
  `status` enum('pending','verified','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `otp_expiration` timestamp NULL DEFAULT NULL,
  `otp_hmac` varchar(255) DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `description` varchar(15) DEFAULT NULL,
  `send_ip` varchar(50) DEFAULT NULL,
  `veified_ip` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `otp_logs`
--

INSERT INTO `otp_logs` (`id`, `login_with`, `hashed_otp`, `status`, `otp_expiration`, `otp_hmac`, `attempts`, `description`, `send_ip`, `veified_ip`, `created_at`, `updated_at`) VALUES
(1, 'gouravatced@gmail.com', '$2y$12$1CtE5SDixFjB7IH0KbdAn.lH7Cl8K.oGTZCB/v1YmJKgpwYPL3JdS', 'pending', '2026-02-04 06:34:50', 'd8869ac65d8f12811d2958b081760190a35b5fd66b18fd23239539e1ec703fe3', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 06:19:50', '2026-02-04 06:19:50'),
(2, 'gouravatced@gmail.com', '$2y$12$7g76bt.Ni6dNYrCHwcjmUOJZCdN9.I5HxtQk3yMHrqr/X2TUa4Sam', 'verified', '2026-02-04 06:36:16', '75b9de0167b834402be28500ab4828be455f39c0f194edf60955ab0cc2c666b3', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 06:21:16', '2026-02-04 06:21:38'),
(3, 'gouravatced@gmail.com', '$2y$12$HIzj01aVl9LHT4qW/Z6jr.ywcX3MgeIns93daZMfUA6u2Trz/okc.', 'pending', '2026-02-04 06:50:08', 'f4c21e553a5e811d1a870e2a16682df67d50076e61cdb25787416faa57c465ac', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 06:35:08', '2026-02-04 06:35:08'),
(4, 'gouravatced@gmail.com', '$2y$12$Xxl7uDTEooD1.6WXfkvMH.CFK7xukqya6ycmDP.aMlF62Rlmj5Ljq', 'pending', '2026-02-04 07:01:58', '98ff01d8ead364251b4ddd332fd7cf104de3b5baf9f1d32214efe30229ea5269', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 06:46:58', '2026-02-04 06:46:58'),
(5, 'gouravatced@gmail.com', '$2y$12$cSLndaJY8FZS/ciix7e68Od00Xj.pae2frCPeimV1VIjd8ubO5O1G', 'pending', '2026-02-04 07:04:07', 'a4b45a9b2705fe692dc39a68a08685fe514714d86c3e6d63b7ec9b1c34a38ecf', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 06:49:07', '2026-02-04 06:49:07'),
(6, 'gouravatced@gmail.com', '$2y$12$lvNgosEly3xZNoBuzdw0Re.Cvrsm72yCFm5NW8PpmYeY3Jnnmewue', 'pending', '2026-02-04 07:04:54', '9df87957ca849938267316df91a9029829d219fa9adf12d6f2c2ef97ea1bdd7e', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 06:49:54', '2026-02-04 06:49:54'),
(7, 'gouravatced@gmail.com', '$2y$12$PhFVLVzWbuo4z.NTUP1pwetaguVTIiSyZXPMtUkRS3abSUI6S9rk2', 'pending', '2026-02-04 07:05:51', '1e93c8032993e2b88dfbec1e8211cd57252579837cb2ff12b032f17de3eca7b2', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 06:50:51', '2026-02-04 06:50:51'),
(8, 'gouravatced@gmail.com', '$2y$12$Wdr2esVzyB50bFkFHyedUOL3cz6Y4HWIesJNU.zeQ36/tKyEK3qNi', 'pending', '2026-02-04 07:08:57', '3df17b4820256b25b0c4d61eb85fe77dc161e9e25198ff8a3dbed114c846aa84', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 06:53:57', '2026-02-04 06:53:57'),
(9, 'gouravatced@gmail.com', '$2y$12$AZyVhEUDNbA.kyOCVStSHOm5X9xljJaPzSrWg.zNOOyFfhyYUZ7nq', 'pending', '2026-02-04 07:18:39', 'c7ca453cb542778633eba1c2dcb29cc7984ddb9e6596d71c11bc0e182ef3ac04', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 07:03:39', '2026-02-04 07:03:39'),
(10, 'gouravatced@gmail.com', '$2y$12$bptDwTkFub9dPBNZLyVnKeus1RvGTXW9iS4mTXIAXYrKJQxw1CZSi', 'pending', '2026-02-04 07:20:22', '8d15a167c4be16a5b5e7fd10cb5f6aad9053e2e57c836aa0352980c4f05d2243', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 07:05:22', '2026-02-04 07:05:22'),
(11, 'gouravatced@gmail.com', '$2y$12$Er8CEmPWrmIxpvC/Ox1llOjwIhChp9.VF74WSDoECw0YP.Syi6PPy', 'pending', '2026-02-04 07:33:02', '287cd8fb29d5ed9e4832eb291dd9a44d00f6087af5f9244f45759c7893d6c598', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 07:18:02', '2026-02-04 07:18:02'),
(12, 'gouravatced@gmail.com', '$2y$12$3uQfYq49gyHXp.JRKL.85e8DsLKaMeH2UsPrfs3SVlyWDW2YtKHhu', 'pending', '2026-02-04 07:35:17', 'eecfe7d637edcfdf7406bfeb41f6d9917539cf14b1bad3ea77a0428ebb0c6f2f', 0, NULL, NULL, NULL, '2026-02-04 07:20:17', '2026-02-04 07:20:17'),
(13, '7979040859', '$2y$12$Yuf7UEDF4TZCIxTbUAAfNO6ORgSBDIgIWSIUhwvxSH8OaISO.PJ9O', 'pending', '2026-02-04 07:36:12', '943ba7e2749665d1f6ddc9654d5639656988fd2d2839ad8f1ab553f03d69cb6f', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 07:21:12', '2026-02-04 07:21:12'),
(14, '7979040859', '$2y$12$kZbSm0NUPhGQisBG3rLmb.Z0KhZQz38RYKe8MYKvO4PPkIYYY/1Oy', 'pending', '2026-02-04 07:39:26', 'eb57cc40e43acc6b368d629e3b6a5e03b09029dfe911555c6188868c3fbcf19d', 0, NULL, NULL, NULL, '2026-02-04 07:24:26', '2026-02-04 07:24:26'),
(15, '7979040859', '$2y$12$4B3xfZwTTaxuzrSdKgy/AumaPzADDTuqNgERQ5BuN6HQjjDIrVEpC', 'pending', '2026-02-04 07:44:32', 'bc7ce83df78a1b8c9abaae5e8b0822d8bc372af8d3a092355517fff6cf90f78d', 0, NULL, NULL, NULL, '2026-02-04 07:29:32', '2026-02-04 07:29:32'),
(16, '7979040859', '$2y$12$wbS5.OirSWUfDZscx4teTebE5V1R/RHNeegi4THuGsY0Hj0HdQmli', 'verified', '2026-02-04 07:46:44', 'f598f1590c7fea3e12aa207e706f6184f4ce2b378ac4eb6b72d2c02d2e1ae1e8', 0, NULL, NULL, NULL, '2026-02-04 07:31:44', '2026-02-04 07:32:19'),
(17, 'gouravatced@gmail.com', '$2y$12$w97P06Kds45S.Bqr400O3Onoy1ouR/1HiShKKzbu529k.rVEMtEKC', 'pending', '2026-02-04 08:13:31', '3af6dee4a21421f7f3812f69f03d701b25df053749b1d0b383c171dfa5a1c53a', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 07:58:31', '2026-02-04 07:58:31'),
(18, 'gouravatced@gmail.com', '$2y$12$te5UmVrOnunwXufZOKhpx.iyjT3tJKb0nIvDRAZBXu8XrPcmbCYlS', 'verified', '2026-02-04 10:33:54', '20907d30e8747fd5658ee896d6743be7fc737ccbbc1e162c9b4a3e23c14c0ac3', 1, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 10:18:54', '2026-02-04 10:19:42'),
(19, 'gouravatced@gmail.com', '$2y$12$4luWOY0IYzY45Bc/UZqMXunc6NPn9UJawNzLR49uIMixdv5AlYD9G', 'pending', '2026-02-04 12:42:54', 'ece833c86d43679565952a76322f987a242c7a38059f6cefc34cbc418c5d370c', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 12:27:54', '2026-02-04 12:27:54'),
(20, 'gouravatced@gmail.com', '$2y$12$1ATyWHGRRvmGKPwrwjS9IOMbRXWGVP2Ltu.VMWWw1beuQuxEkMfk.', 'pending', '2026-02-04 12:52:31', '144f1e8d0be7576df12648af4ad43a2e2cc6f2a78dcf6e0785f22f9d0659fa8c', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 12:37:31', '2026-02-04 12:37:31'),
(21, 'gouravatced@gmail.com', '$2y$12$UzfYNA0I0gCPSxZl8KI6PuoQBDKSYB.iQjpM77dxyiiwxFb3HbShe', 'pending', '2026-02-04 13:12:41', '1ebe927fb48862fd1b961d42db01382924fb74a98523d72e2213b267a79b7275', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 12:57:41', '2026-02-04 12:57:41'),
(22, 'gouravatced@gmail.com', '$2y$12$C5fzkUQsPSmt8GziBGHmLueRQkv3BanrzTrfdHNJCFe17CkMu6ayO', 'verified', '2026-02-04 13:18:17', '117f1a975707739978aab30cc1868177b43c66dd1fdb45405545c989c5982650', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-04 13:03:17', '2026-02-04 13:03:50'),
(23, 'gouravatced@gmail.com', '$2y$12$7Haf.BClpWyKjZv8VZEQ/.FDHWYUu07xdkFjep7.f.mls1OX/9Qiy', 'pending', '2026-02-05 04:23:08', '0f096793a0521514d3e6469233491a01e1ae17ba0539cb3895d039245217a9c2', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 04:08:08', '2026-02-05 04:08:08'),
(24, 'gouravatced@gmail.com', '$2y$12$6PysE/CtwvKx0nhO2ko7ouqoz0GxlmwLoDHPqTg1x6yG9LTSNVxBS', 'pending', '2026-02-05 04:48:03', 'af07cfcb74f16ffbec9874bba25bbe6e893c241aa0648c8c45ee5aab1b3f3d4a', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 04:33:03', '2026-02-05 04:33:03'),
(25, 'gouravatced@gmail.com', '$2y$12$xp6sutfLK04VdI5oZTagbO66qX5pSLG4RuSMTNTHm/bIdgG3nshr6', 'pending', '2026-02-05 04:54:36', 'e3313032f4f4dbc66a9558155a1f72aea095ab22a0799ae98e366129d183f403', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 04:39:36', '2026-02-05 04:39:36'),
(26, 'gouravatced@gmail.com', '$2y$12$ZgRCu5QrVrra8noUMc592OIR/gYk00bL5lIlPC/JM5MI2DgiHkJW6', 'pending', '2026-02-05 04:57:31', '463f167088cd3e370ed062fc6302c46d482f13d3b322f5a7dfdd4d2d261fbd36', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 04:42:31', '2026-02-05 04:42:31'),
(27, 'gouravatced@gmail.com', '$2y$12$BQpDGp8W.DbS7..c4Dz1ROoC624KrSP//jwqgcAzFAdicaWJp4C3y', 'verified', '2026-02-05 05:06:36', 'ef9eec45e05bb9bb2d7ac195c92761682ef1835f9d9afea8ed27d2906ab30b8a', 0, NULL, NULL, NULL, '2026-02-05 04:51:36', '2026-02-05 04:51:58'),
(28, 'gouravatced@gmail.com', '$2y$12$uYako9JG81.KUjYy1gPMz.OfPN74pM7H0cCeDIxbgcbT6S408dADy', 'pending', '2026-02-05 05:23:43', '935acddcbb7d760c41b37c8636a6b0f1340436021ff9916f504e775d95da541b', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 05:08:43', '2026-02-05 05:08:43'),
(29, 'gouravatced@gmail.com', '$2y$12$B1W.ic8x2tXwnrb8CUQX3O3J4f8sx7JBXpNgYkAeDfB6mEEX3XDOK', 'pending', '2026-02-05 05:46:34', 'f93e1da5d256565cdbe4aca0daf74c7afe47ae27da03fa629d2382efedb74d6f', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 05:31:34', '2026-02-05 05:31:34'),
(30, 'gouravatced@gmail.com', '$2y$12$csyff/cnPQSrlMohYzmOSumhtjX0fAWpDxQw76CC53Qbmn5Vxlxz.', 'pending', '2026-02-05 05:47:56', 'cf1c4ec03a8ea3eb65acecb88e85f837ece38c8fbb19601245458edcce1a3b3a', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 05:32:56', '2026-02-05 05:32:56'),
(31, 'gouravatced@gmail.com', '$2y$12$nelxRQHJtCup3UxLfTOmIuw0UiMVqp2dtQuS4WYr6dRymjPAe6tyy', 'pending', '2026-02-05 05:49:11', '2e9c7bf39a3b636e0932984ff28a0f59566d064bcfca92ca2b137a092bf43a4f', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 05:34:11', '2026-02-05 05:34:11'),
(32, 'gouravatced@gmail.com', '$2y$12$j7PaORjbbJOxMw9WBbN3ruy9iFWuCITdIe.yLMx4zBu77quMJzqzO', 'pending', '2026-02-05 05:52:29', '677bdae29515f5f2cedeb822535714c34dfaa1d2fdb50fc71addbc9878e75988', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 05:37:29', '2026-02-05 05:37:29'),
(33, 'gouravatced@gmail.com', '$2y$12$wdATs0HGqoNzyK1jOyEskOPKfPufcWrCjkINqpvX3nI3fzO9p9Ngq', 'pending', '2026-02-05 05:53:33', '5f65d6eca03c7d4be17e5b8b49c1517edbf48738d22b1309a6ecde194a25d82c', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 05:38:33', '2026-02-05 05:38:33'),
(34, 'gouravatced@gmail.com', '$2y$12$N0a1MzG9FUFWjsRF9RqKfOF3bQLLedLWzJGDAvj8d9kXpEcXGzjfu', 'pending', '2026-02-05 05:57:33', '9649e86f22f95085b5763a3d793dcba95f117c4f49069f07b5fe5d803f272327', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 05:42:33', '2026-02-05 05:42:33'),
(35, 'gouravatced@gmail.com', '$2y$12$74cYe5Zbv.rMZs3sPYrH8eiA0qG6MbGsVikfMw/foB06HtXlmI81.', 'pending', '2026-02-05 06:01:50', '9e0e20767f12f5415fbaf87ed85448463642163af0bcb37b8d7f69682100ab17', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 05:46:50', '2026-02-05 05:46:50'),
(36, 'gouravatced@gmail.com', '$2y$12$fg/uwiSfPmjgI7EvRe7Fx.IbpzVduS5lnYtOUiJ4G3H6SZuFBg5wK', 'verified', '2026-02-05 07:21:40', '5c38ed9ce411e77038469da51e92e886c72d6e2ec5f68caac8cffc667bb1bd2c', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-05 07:06:40', '2026-02-05 07:06:59'),
(37, 'computered3896@gmail.com', '$2y$12$1Yfg8dBVWJsPy5QUEPwtVe/0Sr45vOMu9uXSlvloEhTFcnKm6MbZO', 'pending', '2026-02-07 10:43:36', '4d75d77f572e8fc84d41c782dd646366bfe63a697e72b0a550cc2a24abe78c90', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-07 10:28:36', '2026-02-07 10:28:36'),
(38, 'computered3896@gmail.com', '$2y$12$Q5fzgyxzXOVuGz3dnYx6teLD7tvohw5f/lKPBZF5CJ4792QkjE5bK', 'verified', '2026-02-07 10:44:19', '079a00810c5aa87464cd0d4a5c412e73adf55e0e25e32d5200ce565c369588a5', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-07 10:29:19', '2026-02-07 10:29:32'),
(39, 'computered3896@gmail.com', '$2y$12$NKpeiyBXt15T0txENyVlyOLzExLvHJHD392hYPNKnhq4nX2v0Hgn2', 'verified', '2026-02-09 04:26:19', 'b548d0405472e7429e94a039cc48f16f364ee6dc8e6cae7ab1046b0a43f6ca30', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-09 04:11:19', '2026-02-09 04:11:50'),
(40, 'computered3896@gmail.com', '$2y$12$HqSie2YMhOoVPx3hqzKiEOnrH/u66wp4yMEuK.jNW4KzdnBW1.6cm', 'verified', '2026-02-10 04:20:11', 'd8299c1c688c431a81beb63339f80af66cd7e0923d024da4c2d6001705c72ec1', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-10 04:05:11', '2026-02-10 04:05:29');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_application_id` bigint(20) UNSIGNED NOT NULL,
  `passing_state` enum('Jharkhand','Other') DEFAULT NULL,
  `other_state` varchar(20) DEFAULT NULL,
  `registration_no` varchar(20) NOT NULL,
  `result_date` date NOT NULL,
  `category` enum('General','OBC','ST','SC') DEFAULT NULL,
  `payment_receipt_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `dated` date NOT NULL,
  `payment_receipt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_uploaded_document_path` varchar(255) DEFAULT NULL,
  `doc_status` enum('Pending','Accept','Revert') NOT NULL DEFAULT 'Pending',
  `revert_reason` varchar(150) DEFAULT NULL,
  `revert_by` int(11) DEFAULT NULL,
  `stu_revert_date` datetime DEFAULT NULL,
  `actionDate` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `student_application_id`, `passing_state`, `other_state`, `registration_no`, `result_date`, `category`, `payment_receipt_no`, `amount`, `dated`, `payment_receipt`, `user_uploaded_document_path`, `doc_status`, `revert_reason`, `revert_by`, `stu_revert_date`, `actionDate`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jharkhand', NULL, '1225452002', '2011-11-04', 'General', '234352500001', 1800.00, '2025-11-25', 'uploads/2511/payment_receipt/2511431167.jpg', NULL, 'Pending', NULL, NULL, NULL, NULL, '2025-11-24 23:04:38', '2025-12-23 02:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `property_category`
--

CREATE TABLE `property_category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) DEFAULT 1 COMMENT '0=Inactive, 1=Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_category`
--

INSERT INTO `property_category` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Residential', 1, '2026-02-06 11:11:46', '2026-02-06 11:11:46'),
(2, 'Commercial', 1, '2026-02-06 11:12:06', '2026-02-06 11:18:10');

-- --------------------------------------------------------

--
-- Table structure for table `property_sub_type`
--

CREATE TABLE `property_sub_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `ptype_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 1 COMMENT '0=Inactive, 1=Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_sub_type`
--

INSERT INTO `property_sub_type` (`id`, `name`, `ptype_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '1 BHK', 1, 1, '2026-02-06 12:49:34', '2026-02-07 04:23:22'),
(2, '2 BHK', 1, 1, '2026-02-06 12:50:54', '2026-02-06 12:50:54'),
(3, '3 BHK', 1, 1, '2026-02-06 12:51:41', '2026-02-06 12:59:39'),
(4, '2 Rooms', 5, 1, '2026-02-07 04:40:58', '2026-02-07 04:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `parent_type_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1 COMMENT '0=Inactive, 1=Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`id`, `name`, `category_id`, `parent_type_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Flat', 1, NULL, 1, '2026-02-06 11:56:35', '2026-02-06 11:56:35'),
(2, 'House', 1, NULL, 1, '2026-02-06 11:56:53', '2026-02-06 11:56:53'),
(3, 'Plot', 1, NULL, 1, '2026-02-06 11:57:01', '2026-02-06 11:57:01'),
(4, 'Plot', 2, NULL, 1, '2026-02-06 11:57:10', '2026-02-06 11:57:10'),
(5, 'Shop', 2, NULL, 1, '2026-02-06 11:57:21', '2026-02-06 12:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `quarter_type`
--

CREATE TABLE `quarter_type` (
  `quarter_id` int(11) NOT NULL,
  `quarter_code` varchar(10) NOT NULL COMMENT 'HIG, LIG, MIG, EWS',
  `quarter_name` varchar(100) NOT NULL,
  `quarter_full_name` varchar(200) DEFAULT NULL,
  `min_income` decimal(12,2) DEFAULT NULL COMMENT 'Minimum annual income in lakhs',
  `max_income` decimal(12,2) DEFAULT NULL COMMENT 'Maximum annual income in lakhs',
  `display_order` int(11) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1 COMMENT '0=Inactive, 1=Active',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quarter_type`
--

INSERT INTO `quarter_type` (`quarter_id`, `quarter_code`, `quarter_name`, `quarter_full_name`, `min_income`, `max_income`, `display_order`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'HIG', 'High Income Group', 'High Income Group Quarters', 12.00, NULL, 1, 1, NULL, '2026-02-07 05:58:34', '2026-02-07 06:09:34'),
(3, 'LIG', 'Low Income Group', 'Low Income Group Quarters', 3.00, 6.00, 2, 1, NULL, '2026-02-07 05:58:56', '2026-02-07 05:58:56'),
(4, 'MIG', 'Middle Income Group', 'Middle Income Group Quarters', 6.00, 12.00, 0, 1, NULL, '2026-02-13 06:08:59', '2026-02-13 06:08:59'),
(5, 'EWS', 'Economically Weaker Section', 'Economically Weaker Section Quarters', 1.00, 3.00, 0, 1, NULL, '2026-02-13 06:12:12', '2026-02-13 06:12:12');

-- --------------------------------------------------------

--
-- Table structure for table `quota_types`
--

CREATE TABLE `quota_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quota_types`
--

INSERT INTO `quota_types` (`id`, `name`, `code`) VALUES
(1, 'General', 'GENERAL'),
(2, 'General Divyang', 'GENERAL_DIVYANG'),
(3, 'SC', 'SC'),
(4, 'SC Divyang', 'SC_DIVYANG'),
(5, 'ST', 'ST'),
(6, 'ST Divyang', 'ST_DIVYANG'),
(7, 'OBC', 'OBC'),
(8, 'OBC Divyang', 'OBC_DIVYANG'),
(9, 'Sports', 'SPORTS'),
(10, 'Ex Serviceman', 'EX_SERVICEMAN'),
(11, 'Govt Employee', 'GOVT_EMPLOYEE'),
(12, 'MLA/MP Quota', 'MLA_MP'),
(13, 'Direct Allotment', 'DIRECT_ALLOTMENT');

-- --------------------------------------------------------

--
-- Table structure for table `register_allottees`
--

CREATE TABLE `register_allottees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `register_id` varchar(20) NOT NULL,
  `confirm_received` varchar(10) NOT NULL DEFAULT 'No',
  `confirm_same_allottee_name` varchar(10) NOT NULL DEFAULT 'No',
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `sub_division_id` bigint(20) UNSIGNED NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `pcategory_id` bigint(20) UNSIGNED NOT NULL,
  `p_type_id` bigint(20) UNSIGNED NOT NULL,
  `property_number` varchar(50) NOT NULL,
  `quarter_type` varchar(20) DEFAULT NULL,
  `prefix` varchar(50) NOT NULL DEFAULT 'Shri',
  `allottee_name` varchar(150) NOT NULL,
  `allottee_middle_name` varchar(100) DEFAULT NULL,
  `allottee_surname` varchar(100) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `no_of_files` int(11) NOT NULL,
  `no_of_supplement` int(11) DEFAULT 0,
  `json_pages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_pages`)),
  `total_pages` int(11) DEFAULT NULL,
  `allottee_status` enum('received','scanned','handover','') NOT NULL DEFAULT 'received',
  `parent_id` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `scanned_by` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip_address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register_allottees`
--

INSERT INTO `register_allottees` (`id`, `register_id`, `confirm_received`, `confirm_same_allottee_name`, `division_id`, `sub_division_id`, `area`, `pcategory_id`, `p_type_id`, `property_number`, `quarter_type`, `prefix`, `allottee_name`, `allottee_middle_name`, `allottee_surname`, `remarks`, `no_of_files`, `no_of_supplement`, `json_pages`, `total_pages`, `allottee_status`, `parent_id`, `is_active`, `scanned_by`, `created_by`, `updated_by`, `created_at`, `updated_at`, `ip_address`) VALUES
(1, '2302266678', 'No', 'No', 4, 7, NULL, 1, 2, 'C-234', '2', 'Shri', 'Krishna', 'Dev', 'Murthy', 'All Old Pages', 3, 2, '[{\"file_name\":\"File-1\",\"pages\":87},{\"file_name\":\"File-2\",\"pages\":59},{\"file_name\":\"File-3\",\"pages\":97},{\"file_name\":\"File-4\",\"pages\":61},{\"file_name\":\"File-5\",\"pages\":45}]', 349, 'scanned', NULL, 1, 1, 1, 1, '2026-02-23 09:22:04', '2026-02-23 11:12:08', '127.0.0.1'),
(2, '2302266678', 'Yes', 'No', 5, 10, NULL, 1, 1, 'FLT-5897', '2', 'Shri', 'Ritik', 'Kumar', 'Pandey', 'All Fresh Pages', 2, 1, '[{\"file_name\":\"File-1\",\"pages\":8},{\"file_name\":\"File-2\",\"pages\":36},{\"file_name\":\"File-3\",\"pages\":48}]', 92, 'scanned', NULL, 1, 1, 1, 1, '2026-02-23 09:23:42', '2026-02-23 11:11:35', '127.0.0.1'),
(3, '2302269882', 'No', 'No', 2, 5, NULL, 1, 3, 'Plt-344', '2', 'Shri', 'Aditya', NULL, 'Kumar', 'All Fresh Pages', 1, 2, NULL, NULL, 'received', NULL, 1, NULL, 2, NULL, '2026-02-23 09:27:29', '2026-02-23 09:27:29', '127.0.0.1'),
(4, '2302269882', 'No', 'No', 1, 1, NULL, 1, 2, 'H-EWS-233', '5', 'Shri', 'Kiran', 'Kumar', 'Dev', 'All Fresh Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 2, NULL, '2026-02-23 09:28:51', '2026-02-23 09:28:51', '127.0.0.1'),
(5, '2302269882', 'Yes', 'Yes', 4, 7, NULL, 1, 2, 'C-234', '2', 'Shri', 'Krishna', 'Dev', 'Murthy', 'All Old Pages', 3, 2, NULL, NULL, 'received', 1, 1, NULL, 2, NULL, '2026-02-23 09:29:45', '2026-02-23 09:29:45', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `schemes`
--

CREATE TABLE `schemes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `sub_division_id` bigint(20) UNSIGNED NOT NULL,
  `pcategory_id` bigint(20) UNSIGNED NOT NULL,
  `p_type_id` bigint(20) UNSIGNED NOT NULL,
  `p_sub_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quarter_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scheme_name` varchar(255) NOT NULL,
  `scheme_name_hindi` varchar(255) DEFAULT NULL,
  `scheme_code` varchar(255) DEFAULT NULL,
  `total_units` int(11) NOT NULL,
  `lease_period` int(11) NOT NULL DEFAULT 90,
  `initiation_year` year(4) NOT NULL,
  `scheme_start_date` date NOT NULL,
  `scheme_end_date` date DEFAULT NULL,
  `status` enum('draft','active','completed','cancelled') NOT NULL DEFAULT 'active',
  `is_active` tinyint(1) DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schemes`
--

INSERT INTO `schemes` (`id`, `division_id`, `sub_division_id`, `pcategory_id`, `p_type_id`, `p_sub_type_id`, `quarter_type_id`, `scheme_name`, `scheme_name_hindi`, `scheme_code`, `total_units`, `lease_period`, `initiation_year`, `scheme_start_date`, `scheme_end_date`, `status`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 2, 5, 1, 1, 1, 2, '44 HIG -dityapur Dindli Basti , Seraikela-kharsawan', '44 एचआईजी-दित्यपुर दिंदली बस्ती, सरायकेला-खरसावां', 'SCH-44-DINDLI-ADTP', 44, 90, '1962', '1962-12-12', NULL, 'active', 1, 3, NULL, '2026-02-18 07:24:13', '2026-02-18 07:24:13'),
(5, 1, 1, 1, 1, 1, 3, '67 - RNC HI FLAT HARMU, RANCHI', '67 - आरएनसी हाई फ्लैट हारमू, रांची', 'SCH-67-RNC-HRMU', 67, 90, '1990', '1990-12-02', NULL, 'active', 1, 3, NULL, '2026-02-18 07:54:39', '2026-02-18 07:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_blocks`
--

CREATE TABLE `scheme_blocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_id` bigint(20) UNSIGNED NOT NULL,
  `scheme_property_type` varchar(100) DEFAULT NULL,
  `block_name` varchar(255) NOT NULL,
  `area_sqft` decimal(10,2) DEFAULT NULL,
  `undivided_land_share` decimal(10,2) DEFAULT NULL,
  `total_buildup` decimal(10,2) DEFAULT NULL,
  `total_area_of_construction` decimal(10,2) DEFAULT NULL,
  `dimension_east` varchar(50) DEFAULT NULL,
  `dimension_west` varchar(50) DEFAULT NULL,
  `dimension_north` varchar(50) DEFAULT NULL,
  `dimension_south` varchar(50) DEFAULT NULL,
  `arm_east_west_north` varchar(50) DEFAULT NULL,
  `arm_east_west_south` varchar(50) DEFAULT NULL,
  `arm_north_south_east` varchar(50) DEFAULT NULL,
  `arm_north_south_west` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheme_blocks`
--

INSERT INTO `scheme_blocks` (`id`, `scheme_id`, `scheme_property_type`, `block_name`, `area_sqft`, `undivided_land_share`, `total_buildup`, `total_area_of_construction`, `dimension_east`, `dimension_west`, `dimension_north`, `dimension_south`, `arm_east_west_north`, `arm_east_west_south`, `arm_north_south_east`, `arm_north_south_west`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 5, 'Flat', 'Block 1', 1200.00, 200.00, 1000.00, NULL, '20 ft', '20 ft', '20 ft', '20 ft', '4 ft', '4 ft', '4 ft', '4 ft', 1, 3, 3, '2026-02-18 10:21:25', '2026-02-18 10:24:32'),
(2, 5, 'Flat', 'Block Type 2', 1400.00, 250.00, 1150.00, NULL, '30 ft', '30 ft', '30 ft', '30 ft', '4 ft', '4 ft', '4 ft', '4 ft', 1, 3, NULL, '2026-02-18 10:23:05', '2026-02-18 10:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_block_dimensions`
--

CREATE TABLE `scheme_block_dimensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_block_id` bigint(20) UNSIGNED NOT NULL,
  `east` varchar(50) DEFAULT NULL,
  `west` varchar(50) DEFAULT NULL,
  `north` varchar(50) DEFAULT NULL,
  `south` varchar(50) DEFAULT NULL,
  `east_west_north` varchar(50) DEFAULT NULL,
  `east_west_south` varchar(50) DEFAULT NULL,
  `north_south_east` varchar(50) DEFAULT NULL,
  `north_south_west` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scheme_financials`
--

CREATE TABLE `scheme_financials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_id` bigint(20) UNSIGNED NOT NULL,
  `property_total_cost` decimal(15,2) NOT NULL,
  `down_payment_percentage` decimal(5,2) NOT NULL,
  `down_payment_amount` decimal(15,2) NOT NULL,
  `balance_amount` decimal(15,2) NOT NULL,
  `emi_count` int(11) NOT NULL,
  `normal_interest_rate` decimal(5,2) NOT NULL DEFAULT 13.50,
  `emi_without_penalty` decimal(15,2) NOT NULL,
  `penalty_interest_rate` decimal(5,2) NOT NULL DEFAULT 2.50,
  `emi_with_penalty` decimal(15,2) NOT NULL,
  `admin_charges` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheme_financials`
--

INSERT INTO `scheme_financials` (`id`, `scheme_id`, `property_total_cost`, `down_payment_percentage`, `down_payment_amount`, `balance_amount`, `emi_count`, `normal_interest_rate`, `emi_without_penalty`, `penalty_interest_rate`, `emi_with_penalty`, `admin_charges`, `created_at`, `updated_at`) VALUES
(2, 4, 2088000.00, 25.00, 522000.00, 1566000.00, 60, 13.50, 36034.00, 2.50, 38083.00, 5.00, '2026-02-18 07:24:13', '2026-02-18 07:24:13'),
(3, 5, 522000.00, 39.00, 200000.00, 322000.00, 50, 13.50, 8456.00, 2.50, 8865.00, 10.00, '2026-02-18 07:54:39', '2026-02-18 10:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_master_old`
--

CREATE TABLE `scheme_master_old` (
  `scheme_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `sub_division_id` int(11) NOT NULL,
  `pcategory_id` int(11) NOT NULL,
  `p_type_id` int(11) NOT NULL,
  `p_sub_type_id` int(11) DEFAULT NULL,
  `quarter_type_id` int(11) DEFAULT NULL,
  `scheme_name` varchar(255) NOT NULL,
  `scheme_name_hindi` text DEFAULT NULL,
  `scheme_code` varchar(50) DEFAULT NULL COMMENT 'Optional short code for reference',
  `total_units` int(11) NOT NULL DEFAULT 1,
  `area_sqft` decimal(10,2) DEFAULT NULL,
  `dimensions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `arms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `scheme_value` decimal(15,2) NOT NULL COMMENT 'Total scheme value',
  `down_payment_percentage` decimal(5,2) NOT NULL DEFAULT 25.00 COMMENT 'Percentage of scheme value',
  `down_payment_amount` decimal(15,2) DEFAULT NULL,
  `application_deposit_amount` decimal(15,2) DEFAULT NULL,
  `extra_amount` decimal(10,2) DEFAULT 0.00 COMMENT 'Additional charges',
  `registry_time_deposit` decimal(15,2) NOT NULL COMMENT 'Amount deposited at registry time',
  `emi_count` int(11) NOT NULL DEFAULT 60 COMMENT 'Number of installments',
  `emi_amount` decimal(15,2) DEFAULT NULL COMMENT 'Monthly installment amount',
  `compound_interest_rate` decimal(5,2) NOT NULL DEFAULT 13.50 COMMENT 'Annual compound interest rate in %',
  `late_compound_interest_rate` decimal(5,2) NOT NULL DEFAULT 2.50 COMMENT 'Late payment interest rate in %',
  `administrative_charges` decimal(5,2) DEFAULT 5.00 COMMENT 'Administrative Charges of Pentalty',
  `lease_period` varchar(100) NOT NULL,
  `scheme_start_date` date NOT NULL,
  `scheme_end_date` date DEFAULT NULL COMMENT 'Optional end date',
  `status` enum('draft','active','completed','cancelled') DEFAULT 'active',
  `is_active` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID who created',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID who last updated',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scheme_master_old`
--

INSERT INTO `scheme_master_old` (`scheme_id`, `division_id`, `sub_division_id`, `pcategory_id`, `p_type_id`, `p_sub_type_id`, `quarter_type_id`, `scheme_name`, `scheme_name_hindi`, `scheme_code`, `total_units`, `area_sqft`, `dimensions`, `arms`, `scheme_value`, `down_payment_percentage`, `down_payment_amount`, `application_deposit_amount`, `extra_amount`, `registry_time_deposit`, `emi_count`, `emi_amount`, `compound_interest_rate`, `late_compound_interest_rate`, `administrative_charges`, `lease_period`, `scheme_start_date`, `scheme_end_date`, `status`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 1, 1, 2, 2, '48 H.I Flat, Dindli , Adityapur', '48 ,p0 vkbZ0 ¶ySV] fMaMyh] vkfnR;iqj', 'SCH-48-DINDLI-ADTP', 48, NULL, NULL, NULL, 2088000.00, 25.00, 522000.00, 213200.00, 300.00, 313800.00, 60, 36034.00, 13.50, 2.50, 5.00, '99', '2026-02-24', NULL, 'draft', 1, 3, NULL, '2026-02-13 09:40:20', '2026-02-13 09:40:20'),
(2, 5, 11, 2, 4, NULL, NULL, '67 - RNC MI PLOT HARMU, RANCHI', '67 ,p0 vkbZ0', 'SCH-67-RNC-HRMU', 67, 800.00, '\"{\\\"east\\\":\\\"21 ft\\\",\\\"west\\\":\\\"21 ft\\\",\\\"north\\\":\\\"21 ft\\\",\\\"south\\\":\\\"21 ft\\\"}\"', '\"{\\\"east_to_west_north_side\\\":\\\"40 ft\\\",\\\"east_to_west_south_side\\\":\\\"40 ft\\\",\\\"north_to_south_east_side\\\":\\\"40 ft\\\",\\\"north_to_south_west_side\\\":\\\"40 ft\\\"}\"', 1088000.00, 25.00, 222000.00, 150000.00, 200.00, 122000.00, 20, 20000.00, 13.50, 2.50, 5.00, '90', '2026-02-11', NULL, 'draft', 1, 3, 3, '2026-02-13 10:06:55', '2026-02-13 10:51:18'),
(3, 4, 7, 1, 3, NULL, NULL, '48- RNC HI FLAT HARMU, RANCHI', '48 ,p0 fMaMyh] vkfnR;iqj', 'SCH-48-DNLI-ADTP', 48, 600.00, '\"{\\\"east\\\":\\\"20 ft\\\",\\\"west\\\":\\\"20 ft\\\",\\\"north\\\":\\\"20 ft\\\",\\\"south\\\":\\\"20 ft\\\"}\"', '\"{\\\"east_to_west_north_side\\\":\\\"4 ft\\\",\\\"east_to_west_south_side\\\":\\\"4 ft\\\",\\\"north_to_south_east_side\\\":\\\"4 ft\\\",\\\"north_to_south_west_side\\\":\\\"4 ft\\\"}\"', 600000.00, 25.00, 180000.00, 120000.00, 200.00, 320000.00, 60, 26525.00, 13.50, 2.50, 5.00, '99', '2026-02-23', NULL, 'draft', 1, 3, NULL, '2026-02-13 10:54:52', '2026-02-13 10:54:52');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_quarter_fees`
--

CREATE TABLE `scheme_quarter_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_id` bigint(20) UNSIGNED NOT NULL,
  `quarter_type_id` bigint(20) UNSIGNED NOT NULL,
  `application_fee` decimal(15,2) NOT NULL,
  `emd_amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheme_quarter_fees`
--

INSERT INTO `scheme_quarter_fees` (`id`, `scheme_id`, `quarter_type_id`, `application_fee`, `emd_amount`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 3000.00, 10000.00, '2026-02-18 07:24:13', '2026-02-18 07:24:13'),
(2, 4, 3, 2000.00, 7000.00, '2026-02-18 07:24:13', '2026-02-18 07:24:13'),
(3, 4, 4, 1000.00, 4000.00, '2026-02-18 07:24:13', '2026-02-18 07:24:13'),
(4, 4, 5, 1000.00, 4000.00, '2026-02-18 07:24:13', '2026-02-18 07:24:13'),
(5, 5, 2, 2500.00, 8000.00, '2026-02-18 07:54:39', '2026-02-18 07:54:39'),
(6, 5, 3, 1500.00, 4000.00, '2026-02-18 07:54:39', '2026-02-18 07:54:39'),
(7, 5, 4, 500.00, 2000.00, '2026-02-18 07:54:39', '2026-02-18 07:54:39'),
(8, 5, 5, 500.00, 2000.00, '2026-02-18 07:54:39', '2026-02-18 07:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_unit_quotas`
--

CREATE TABLE `scheme_unit_quotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_id` bigint(20) UNSIGNED NOT NULL,
  `quota_type_id` varchar(100) NOT NULL,
  `total_units` int(11) NOT NULL DEFAULT 0,
  `allotted_units` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `sub_divisions`
--

CREATE TABLE `sub_divisions` (
  `id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_divisions`
--

INSERT INTO `sub_divisions` (`id`, `division_id`, `name`, `status`, `created_at`) VALUES
(1, 1, 'Harmu Colony', 1, '2026-02-05 17:19:24'),
(2, 1, 'Argora', 1, '2026-02-05 17:19:24'),
(3, 1, 'Bariatu', 1, '2026-02-05 17:19:24'),
(4, 1, 'Kadru', 1, '2026-02-05 17:19:24'),
(5, 2, 'Adityapur', 1, '2026-02-05 17:23:25'),
(6, 3, 'Sahibganj', 1, '2026-02-05 17:23:25'),
(7, 4, 'Dhanbad', 1, '2026-02-05 17:23:25'),
(8, 4, 'Bokaro', 1, '2026-02-05 17:23:25'),
(9, 4, 'Gomia', 1, '2026-02-05 17:23:25'),
(10, 5, 'Sarle', 1, '2026-02-05 17:23:25'),
(11, 5, 'Hazaribagh', 1, '2026-02-05 17:23:25'),
(12, 5, 'Daltanganj II', 0, '2026-02-06 14:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `temp_registers`
--

CREATE TABLE `temp_registers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `register_no` varchar(20) NOT NULL,
  `total_files` int(11) DEFAULT 0,
  `allowed_files` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` enum('draft','submitted') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_registers`
--

INSERT INTO `temp_registers` (`id`, `register_no`, `total_files`, `allowed_files`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, '2302266678', 2, 2, NULL, 'draft', '2026-02-23 09:21:09', '2026-02-23 09:23:42'),
(2, '2302269882', 3, 3, NULL, 'draft', '2026-02-23 09:25:13', '2026-02-23 09:29:45'),
(3, '2302267597', 0, 2, NULL, 'draft', '2026-02-23 09:41:09', '2026-02-23 09:41:14'),
(4, '2302264424', 0, NULL, NULL, 'draft', '2026-02-23 11:25:39', '2026-02-23 11:25:39'),
(5, '2302263032', 0, NULL, NULL, 'draft', '2026-02-23 11:25:51', '2026-02-23 11:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_documents`
--

CREATE TABLE `uploaded_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_application_id` bigint(20) UNSIGNED NOT NULL,
  `document_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_uploaded_document_path` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Accept','Revert') NOT NULL DEFAULT 'Pending',
  `reason` varchar(150) DEFAULT NULL,
  `auth_id` int(11) DEFAULT NULL,
  `actionDate` timestamp NULL DEFAULT NULL,
  `stu_revert_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `uploaded_documents`
--

INSERT INTO `uploaded_documents` (`id`, `student_application_id`, `document_name`, `document_path`, `user_uploaded_document_path`, `status`, `reason`, `auth_id`, `actionDate`, `stu_revert_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'applicant_photo', 'uploads/2511/applicant_photo/2511431167.jpg', NULL, 'Pending', NULL, NULL, NULL, NULL, '2025-11-24 23:06:48', '2025-11-24 23:06:48'),
(2, 1, 'applicant_signature', 'uploads/2511/applicant_signature/2511431167.jpg', NULL, 'Pending', NULL, NULL, NULL, NULL, '2025-11-24 23:06:56', '2025-11-24 23:06:56'),
(3, 1, 'aadhaar_card', 'uploads/2511/aadhaar_card/2511431167.jpg', NULL, 'Pending', NULL, NULL, NULL, NULL, '2025-11-24 23:07:02', '2025-11-24 23:07:13'),
(4, 1, 'twelfth_certificate', 'uploads/2511/twelfth_certificate/2511431167.jpg', NULL, 'Pending', NULL, NULL, NULL, NULL, '2025-11-24 23:07:23', '2025-11-24 23:07:23'),
(5, 1, 'admit_card_1', 'uploads/2511/admit_card_1/2511431167.jpg', NULL, 'Pending', NULL, NULL, NULL, NULL, '2025-11-24 23:07:33', '2025-11-24 23:07:33'),
(6, 1, 'marksheet_1', 'uploads/2511/marksheet_1/2511431167.jpg', NULL, 'Pending', NULL, NULL, NULL, NULL, '2025-11-24 23:07:47', '2025-11-24 23:07:47'),
(7, 1, 'provisional_1', 'uploads/2511/provisional_1/2511431167.jpg', NULL, 'Pending', NULL, NULL, NULL, NULL, '2025-11-24 23:07:53', '2025-11-24 23:07:53'),
(8, 1, 'last_issued_certificate', 'uploads/2511/last_issued_certificate/2511431167.jpg', NULL, 'Pending', NULL, NULL, NULL, NULL, '2025-11-24 23:08:00', '2025-11-24 23:08:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female','Other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` enum('General','OBC','SC','ST') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aadhaar_no` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `mobile_no` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `email_id` varchar(100) NOT NULL,
  `profile_pic` varchar(250) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('scanner','dataentry','admin','superadmin') NOT NULL DEFAULT 'dataentry',
  `password_created_at` datetime DEFAULT NULL,
  `otp_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `last_ip` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `category`, `aadhaar_no`, `date_of_birth`, `mobile_no`, `email_id`, `profile_pic`, `password`, `role`, `password_created_at`, `otp_verified_at`, `created_at`, `last_login`, `last_ip`, `updated_at`) VALUES
(1, 'COMPUTER Ed.', 'Other', 'General', '012222222222', '1996-07-12', '7979040859', 'computered3896@gmail.com', NULL, '$2y$12$FBSwitUzL/xEW1.U4oPfJOEsC1hzNrE4OqY1LPRLrW/sbNJUmWCCe', 'scanner', '2026-02-11 15:20:00', '2026-02-23 06:12:59', '2025-11-24 17:22:13', '2026-02-23 06:12:59', '127.0.0.1', '2026-02-23 06:12:59'),
(2, 'Namita Kumari', 'Other', 'General', '89734578954', '2000-07-12', '9873578345', 'namita.jshb@computered.co.in', NULL, '$2y$12$FBSwitUzL/xEW1.U4oPfJOEsC1hzNrE4OqY1LPRLrW/sbNJUmWCCe', 'scanner', '2026-02-11 15:20:00', '2026-02-23 09:20:46', '2026-02-23 17:22:13', '2026-02-23 09:20:46', '127.0.0.1', '2026-02-23 09:20:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `username` (`mobile_no`) USING BTREE,
  ADD KEY `admin_id` (`admin_details_id`) USING BTREE;

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `mobile_no` (`mobile_no`) USING BTREE;

--
-- Indexes for table `admin_otp_logs`
--
ALTER TABLE `admin_otp_logs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `allottee_file_details`
--
ALTER TABLE `allottee_file_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `application_number` (`application_number`),
  ADD UNIQUE KEY `login_id` (`login_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exported_files`
--
ALTER TABLE `exported_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `file_registrations`
--
ALTER TABLE `file_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `headquater`
--
ALTER TABLE `headquater`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indian_states`
--
ALTER TABLE `indian_states`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`institute_id`);

--
-- Indexes for table `institutes_web`
--
ALTER TABLE `institutes_web`
  ADD PRIMARY KEY (`institute_id`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_logs`
--
ALTER TABLE `otp_logs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `payment_receipt_no` (`payment_receipt_no`) USING BTREE,
  ADD KEY `payments_student_application_id_foreign` (`student_application_id`) USING BTREE;

--
-- Indexes for table `property_category`
--
ALTER TABLE `property_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_sub_type`
--
ALTER TABLE `property_sub_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quarter_type`
--
ALTER TABLE `quarter_type`
  ADD PRIMARY KEY (`quarter_id`);

--
-- Indexes for table `quota_types`
--
ALTER TABLE `quota_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `register_allottees`
--
ALTER TABLE `register_allottees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schemes`
--
ALTER TABLE `schemes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scheme_code` (`scheme_code`);

--
-- Indexes for table `scheme_blocks`
--
ALTER TABLE `scheme_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scheme_id` (`scheme_id`);

--
-- Indexes for table `scheme_block_dimensions`
--
ALTER TABLE `scheme_block_dimensions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scheme_block_id` (`scheme_block_id`);

--
-- Indexes for table `scheme_financials`
--
ALTER TABLE `scheme_financials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheme_master_old`
--
ALTER TABLE `scheme_master_old`
  ADD PRIMARY KEY (`scheme_id`),
  ADD UNIQUE KEY `scheme_name` (`scheme_name`);

--
-- Indexes for table `scheme_quarter_fees`
--
ALTER TABLE `scheme_quarter_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheme_unit_quotas`
--
ALTER TABLE `scheme_unit_quotas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sub_divisions`
--
ALTER TABLE `sub_divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_registers`
--
ALTER TABLE `temp_registers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `register_no` (`register_no`);

--
-- Indexes for table `uploaded_documents`
--
ALTER TABLE `uploaded_documents`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `uploaded_documents_student_application_id_foreign` (`student_application_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admin_details`
--
ALTER TABLE `admin_details`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_otp_logs`
--
ALTER TABLE `admin_otp_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `allottee_file_details`
--
ALTER TABLE `allottee_file_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exported_files`
--
ALTER TABLE `exported_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_registrations`
--
ALTER TABLE `file_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `headquater`
--
ALTER TABLE `headquater`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `indian_states`
--
ALTER TABLE `indian_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `institute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `institutes_web`
--
ALTER TABLE `institutes_web`
  MODIFY `institute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `otp_logs`
--
ALTER TABLE `otp_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `property_category`
--
ALTER TABLE `property_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property_sub_type`
--
ALTER TABLE `property_sub_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quarter_type`
--
ALTER TABLE `quarter_type`
  MODIFY `quarter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quota_types`
--
ALTER TABLE `quota_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `register_allottees`
--
ALTER TABLE `register_allottees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schemes`
--
ALTER TABLE `schemes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `scheme_blocks`
--
ALTER TABLE `scheme_blocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `scheme_block_dimensions`
--
ALTER TABLE `scheme_block_dimensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scheme_financials`
--
ALTER TABLE `scheme_financials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scheme_master_old`
--
ALTER TABLE `scheme_master_old`
  MODIFY `scheme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scheme_quarter_fees`
--
ALTER TABLE `scheme_quarter_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `scheme_unit_quotas`
--
ALTER TABLE `scheme_unit_quotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_divisions`
--
ALTER TABLE `sub_divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `temp_registers`
--
ALTER TABLE `temp_registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uploaded_documents`
--
ALTER TABLE `uploaded_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1356;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_student_application_id_foreign` FOREIGN KEY (`student_application_id`) REFERENCES `student_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploaded_documents`
--
ALTER TABLE `uploaded_documents`
  ADD CONSTRAINT `uploaded_documents_student_application_id_foreign` FOREIGN KEY (`student_application_id`) REFERENCES `student_applications` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
