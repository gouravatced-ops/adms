-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2026 at 02:05 PM
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
(3, 3, '7979040859', 'Gourav Computered', 'admin_pic/1770797011_photo-1494790108377-be9c29b29330.jpeg', '7979040859', 'gouravatced@gmail.com', '$2y$12$FBSwitUzL/xEW1.U4oPfJOEsC1hzNrE4OqY1LPRLrW/sbNJUmWCCe', NULL, 'council_office', 'Male', '2026-03-06 06:16:16', '2026-03-06 06:16:16', '127.0.0.1', NULL, '2024-10-07 09:26:19', '2026-03-06 06:16:16'),
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
-- Table structure for table `allottees`
--

CREATE TABLE `allottees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `register_file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `division_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subdivision_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `property_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quarter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `cedjshb` longtext DEFAULT NULL,
  `scheme_id` bigint(20) UNSIGNED DEFAULT NULL,
  `application_no` varchar(100) DEFAULT NULL,
  `application_day` tinyint(4) DEFAULT NULL,
  `application_month` varchar(4) DEFAULT NULL,
  `application_year` year(4) DEFAULT NULL,
  `allotment_no` varchar(100) DEFAULT NULL,
  `allotment_day` tinyint(4) DEFAULT NULL,
  `allotment_month` varchar(4) DEFAULT NULL,
  `allotment_year` year(4) DEFAULT NULL,
  `property_number` varchar(100) DEFAULT NULL,
  `prefix` varchar(20) DEFAULT NULL,
  `allottee_name` varchar(100) DEFAULT NULL,
  `allottee_middle_name` varchar(100) DEFAULT NULL,
  `allottee_surname` varchar(100) DEFAULT NULL,
  `allottee_prefix_hindi` varchar(20) DEFAULT NULL,
  `allottee_name_hindi` varchar(100) DEFAULT NULL,
  `allottee_middle_hindi` varchar(100) DEFAULT NULL,
  `allottee_surname_hindi` varchar(100) DEFAULT NULL,
  `allottee_relation_type` varchar(20) DEFAULT NULL,
  `relation_name` varchar(150) DEFAULT NULL,
  `marital_status` varchar(20) DEFAULT NULL,
  `allottee_gender` varchar(20) DEFAULT NULL,
  `pan_card_number` varchar(10) DEFAULT NULL,
  `aadhar_card_number` varchar(12) DEFAULT NULL,
  `allottee_category` varchar(30) DEFAULT NULL,
  `allottee_religion` varchar(30) DEFAULT NULL,
  `allottee_nationality` varchar(50) DEFAULT NULL,
  `age_number_of_birth_application` varchar(50) DEFAULT NULL,
  `age_number_of_birth_application_hindi` varchar(50) DEFAULT NULL,
  `age_word_of_birth_application` varchar(100) DEFAULT NULL,
  `age_word_hindi_of_birth_application` varchar(100) DEFAULT NULL,
  `date_of_birth_day` tinyint(4) DEFAULT NULL,
  `date_of_birth_month` varchar(4) DEFAULT NULL,
  `date_of_birth_year` year(4) DEFAULT NULL,
  `no_of_files` int(11) DEFAULT NULL,
  `no_of_supplement` int(11) DEFAULT NULL,
  `json_pages` longtext DEFAULT NULL,
  `total_pages` int(11) DEFAULT NULL,
  `name_transfer_status` varchar(50) NOT NULL DEFAULT 'no',
  `is_parents` int(11) NOT NULL DEFAULT 0,
  `current_step` int(11) DEFAULT 1,
  `allottee_create_date` date DEFAULT NULL,
  `create_ip_address` varchar(100) DEFAULT NULL,
  `update_ip_address` varchar(100) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allottees`
--

INSERT INTO `allottees` (`id`, `register_file_id`, `division_id`, `subdivision_id`, `pcategory_id`, `property_type_id`, `quarter_id`, `username`, `password`, `cedjshb`, `scheme_id`, `application_no`, `application_day`, `application_month`, `application_year`, `allotment_no`, `allotment_day`, `allotment_month`, `allotment_year`, `property_number`, `prefix`, `allottee_name`, `allottee_middle_name`, `allottee_surname`, `allottee_prefix_hindi`, `allottee_name_hindi`, `allottee_middle_hindi`, `allottee_surname_hindi`, `allottee_relation_type`, `relation_name`, `marital_status`, `allottee_gender`, `pan_card_number`, `aadhar_card_number`, `allottee_category`, `allottee_religion`, `allottee_nationality`, `age_number_of_birth_application`, `age_number_of_birth_application_hindi`, `age_word_of_birth_application`, `age_word_hindi_of_birth_application`, `date_of_birth_day`, `date_of_birth_month`, `date_of_birth_year`, `no_of_files`, `no_of_supplement`, `json_pages`, `total_pages`, `name_transfer_status`, `is_parents`, `current_step`, `allottee_create_date`, `create_ip_address`, `update_ip_address`, `updated_by`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 2, 5, 10, 1, 1, 2, 'HZB1970SLE987023', '$2y$12$f/FoPVJ0iOoIueD5U5TMvebFjhuR4Fg717kLX3CVXYITjsOLn0Vhm', 'eyJpdiI6InRYbUllY1VWL2ltWmUvVXZGMnhSUFE9PSIsInZhbHVlIjoiVHZ6VWovS1Z5ZXhIZ1VEZWVUbG1MM05scXFnOVdrVnBkdnIzc2paaVM1OD0iLCJtYWMiOiJkZTQ5MWVjNjJkMGI4N2I4OWRmZDU1ZGVmZmQ1YmYxZmExODkyNjI2OWZiZGI5N2I5NDcwOTFlMTQ3N2ZmNTI5IiwidGFnIjoiIn0=', 8, 'JSHBA-1748087931', 3, '07', '2003', '7845/2003', 9, '10', '2003', 'FLT-5897', 'Shri', 'Ritik', 'Kumar', 'Pandey', 'श्री', 'रितिक', NULL, 'पांडे', 'Father', 'Shiv Kumar', 'Unmarried', 'Male', NULL, NULL, 'EWS', 'Hindu', 'Indian', '15', '15', 'Fifteen Years', 'पंद्रह साल', 30, '08', '1990', 2, 1, '[{\"file_name\":\"File-1\",\"pages\":8},{\"file_name\":\"File-2\",\"pages\":36},{\"file_name\":\"File-3\",\"pages\":48}]', 92, 'no', 0, 5, '2026-03-09', '127.0.0.1', '127.0.0.1', 1, 1, '2026-03-09 04:54:01', '2026-03-09 11:56:52'),
(4, 1, 4, 7, 1, 2, 2, 'DHN1970KRD375821', '$2y$12$Tq6f2nL4UPRlsfTzg8MP..PGiXuA/Db1mKyi.ZAcqAZ0dS7JVK.Eu', 'eyJpdiI6IndRc25RSWhQUlBPOWpGUVcvOXRUT0E9PSIsInZhbHVlIjoiT0VrKzJhRGZDSnhhWXpRQy96VmZZTFM3b2l2elR3RCszYllPRSsvaWtRND0iLCJtYWMiOiI4ZDc0OGQxOGM5ZDA0NTg3NmE4ODhiODI0MTNmNzRlZWZiZDVmMGM5ZThlZDg2MWVlM2Y4YjQ0Yzc5YTdlNjk3IiwidGFnIjoiIn0=', 9, 'JSHBA-174808854345', 11, '06', '1999', '89556/2000', 3, '03', '2000', 'C-234', 'Shri', 'Krishna', 'Dev', 'Murthy', 'श्री', 'कृष्ण', 'देव', 'पांडे', 'Father', 'Ganesh Dev Murthy', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '25', '25', 'Twenty Five Years', 'पच्चीस साल', 5, '5', '1971', 3, 2, '[{\"file_name\":\"File-1\",\"pages\":87},{\"file_name\":\"File-2\",\"pages\":59},{\"file_name\":\"File-3\",\"pages\":97},{\"file_name\":\"File-4\",\"pages\":61},{\"file_name\":\"File-5\",\"pages\":45}]', 349, 'no', 0, 2, '2026-03-09', '127.0.0.1', NULL, NULL, 1, '2026-03-09 07:29:31', '2026-03-09 11:26:07');

-- --------------------------------------------------------

--
-- Table structure for table `allottees_contact_details`
--

CREATE TABLE `allottees_contact_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allottee_id` bigint(20) DEFAULT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `alternate_mobile` varchar(15) DEFAULT NULL,
  `stdCode` varchar(10) DEFAULT NULL,
  `landline` varchar(15) DEFAULT NULL,
  `whatsapp_number` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `relation_type` varchar(50) DEFAULT NULL,
  `prefix_relation_eng` varchar(20) DEFAULT NULL,
  `relation_name` varchar(150) DEFAULT NULL,
  `prefix_relation_hindi` varchar(20) DEFAULT NULL,
  `relation_name_hindi` varchar(150) DEFAULT NULL,
  `relation_address` text DEFAULT NULL,
  `relation_address_hindi` text DEFAULT NULL,
  `relation_state` int(11) DEFAULT NULL,
  `relation_district` int(11) DEFAULT NULL,
  `relation_pincode` varchar(10) DEFAULT NULL,
  `relation_post_office` varchar(150) DEFAULT NULL,
  `relation_post_office_hindi` varchar(150) DEFAULT NULL,
  `relation_police_station` varchar(150) DEFAULT NULL,
  `relation_police_station_hindi` varchar(150) DEFAULT NULL,
  `same_as_relation_copy` varchar(10) DEFAULT NULL,
  `present_address` text DEFAULT NULL,
  `present_address_hindi` text DEFAULT NULL,
  `present_state` int(11) DEFAULT NULL,
  `present_district` int(11) DEFAULT NULL,
  `present_pincode` varchar(10) DEFAULT NULL,
  `present_post_office` varchar(150) DEFAULT NULL,
  `present_post_office_hindi` varchar(150) DEFAULT NULL,
  `present_police_station` varchar(150) DEFAULT NULL,
  `present_police_station_hindi` varchar(150) DEFAULT NULL,
  `same_as_present_place_residance` varchar(10) DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `permanent_address_hindi` text DEFAULT NULL,
  `permanent_state` int(11) DEFAULT NULL,
  `permanent_district` int(11) DEFAULT NULL,
  `permanent_pincode` varchar(10) DEFAULT NULL,
  `permanent_post_office` varchar(150) DEFAULT NULL,
  `permanent_post_office_hindi` varchar(150) DEFAULT NULL,
  `permanent_police_station` varchar(150) DEFAULT NULL,
  `permanent_police_station_hindi` varchar(150) DEFAULT NULL,
  `same_as_permanent_address` varchar(10) DEFAULT NULL,
  `correspondence_address` text DEFAULT NULL,
  `correspondence_address_hindi` text DEFAULT NULL,
  `correspondence_state` int(11) DEFAULT NULL,
  `correspondence_district` int(11) DEFAULT NULL,
  `correspondence_pincode` varchar(10) DEFAULT NULL,
  `correspondence_post_office` varchar(150) DEFAULT NULL,
  `correspondence_post_office_hindi` varchar(150) DEFAULT NULL,
  `correspondence_police_station` varchar(150) DEFAULT NULL,
  `correspondence_police_station_hindi` varchar(150) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `create_ip_address` varchar(45) DEFAULT NULL,
  `update_ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allottees_contact_details`
--

INSERT INTO `allottees_contact_details` (`id`, `allottee_id`, `mobile_number`, `alternate_mobile`, `stdCode`, `landline`, `whatsapp_number`, `email`, `relation_type`, `prefix_relation_eng`, `relation_name`, `prefix_relation_hindi`, `relation_name_hindi`, `relation_address`, `relation_address_hindi`, `relation_state`, `relation_district`, `relation_pincode`, `relation_post_office`, `relation_post_office_hindi`, `relation_police_station`, `relation_police_station_hindi`, `same_as_relation_copy`, `present_address`, `present_address_hindi`, `present_state`, `present_district`, `present_pincode`, `present_post_office`, `present_post_office_hindi`, `present_police_station`, `present_police_station_hindi`, `same_as_present_place_residance`, `permanent_address`, `permanent_address_hindi`, `permanent_state`, `permanent_district`, `permanent_pincode`, `permanent_post_office`, `permanent_post_office_hindi`, `permanent_police_station`, `permanent_police_station_hindi`, `same_as_permanent_address`, `correspondence_address`, `correspondence_address_hindi`, `correspondence_state`, `correspondence_district`, `correspondence_pincode`, `correspondence_post_office`, `correspondence_post_office_hindi`, `correspondence_police_station`, `correspondence_police_station_hindi`, `created_by`, `updated_by`, `create_ip_address`, `update_ip_address`, `created_at`, `updated_at`) VALUES
(3, 3, '9546798457', '8975694576', '06456', '6546456', '9836798456', 'ritikumarPandey@gmail.com', NULL, 'Shri', 'Shiv Kumar', 'श्री', 'शिव कुमार', 'TEST ADDRESS FATHER ADDRESS ENG', 'TEST ADDRESS FATHER ADDRESS HIN', 9, 168, '786578', 'Indian Green', 'भारतीय हरा', 'Indian Gov', 'भारतीय सरकार', 'on', 'TEST ADDRESS PRESENT ADDRESS ENG', 'TEST ADDRESS PRESENT ADDRESS HIN', 9, 168, '786578', 'Indian Green', 'भारतीय हरा', 'Indian Gov', 'भारतीय सरकार', 'on', 'TEST ADDRESS Permanent ADDRESS ENG', 'TEST ADDRESS Permanent ADDRESS HIN', 9, 172, '786578', 'Indian Green', 'भारतीय हरा', 'Indian Gov', 'भारतीय सरकार', 'on', 'TEST ADDRESS CORRESPONDANCE ADDRESS ENG', 'TEST ADDRESS CORRESPONDANCE ADDRESS HIN', 9, 162, '786578', 'Indian Green', 'भारतीय हरा', 'Indian Gov', 'भारतीय सरकार', 1, 1, '127.0.0.1', '127.0.0.1', '2026-03-09 04:56:42', '2026-03-09 04:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `allottee_documents`
--

CREATE TABLE `allottee_documents` (
  `id` bigint(20) NOT NULL,
  `allottee_id` bigint(20) NOT NULL,
  `document_id` int(11) NOT NULL,
  `doc_no` varchar(100) DEFAULT NULL,
  `doc_day` char(2) DEFAULT NULL,
  `doc_month` char(2) DEFAULT NULL,
  `doc_year` char(4) DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `allottee_nominee_bank_details`
--

CREATE TABLE `allottee_nominee_bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allottee_id` bigint(20) UNSIGNED NOT NULL,
  `nominee_prefix` varchar(10) DEFAULT NULL,
  `nominee_name` varchar(150) DEFAULT NULL,
  `nominee_relationship` varchar(100) DEFAULT NULL,
  `nominee_pan_card` varchar(20) DEFAULT NULL,
  `nominee_aadhaar` varchar(20) DEFAULT NULL,
  `family_name_prefix` varchar(10) DEFAULT NULL,
  `family_name` varchar(150) DEFAULT NULL,
  `family_gender` varchar(20) DEFAULT NULL,
  `family_dob` date DEFAULT NULL,
  `family_relationship` varchar(100) DEFAULT NULL,
  `family_aadhaar` varchar(20) DEFAULT NULL,
  `family_pan` varchar(20) DEFAULT NULL,
  `bank_name` varchar(150) DEFAULT NULL,
  `bank_account_no` varchar(50) DEFAULT NULL,
  `bank_branch` varchar(150) DEFAULT NULL,
  `bank_ifsc` varchar(20) DEFAULT NULL,
  `bank_account_holder` varchar(150) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `create_ip_address` varchar(45) DEFAULT NULL,
  `update_ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allottee_nominee_bank_details`
--

INSERT INTO `allottee_nominee_bank_details` (`id`, `allottee_id`, `nominee_prefix`, `nominee_name`, `nominee_relationship`, `nominee_pan_card`, `nominee_aadhaar`, `family_name_prefix`, `family_name`, `family_gender`, `family_dob`, `family_relationship`, `family_aadhaar`, `family_pan`, `bank_name`, `bank_account_no`, `bank_branch`, `bank_ifsc`, `bank_account_holder`, `created_by`, `updated_by`, `create_ip_address`, `update_ip_address`, `created_at`, `updated_at`) VALUES
(1, 3, 'Shri', 'Kavita Murthy Devi', 'Mother', 'ABCDE1234F', '93485028444', 'Shri', 'Kavita Murthy Devi', 'Female', '1981-03-15', 'Mother', '93485028444', 'ABCDE1234F', 'HDTC Bank', '598609458698', 'HDTC JSR BRANCH', 'HDTC0534503', 'Krishna Dev Murithy', 1, 1, '127.0.0.1', '127.0.0.1', '2026-03-09 08:03:16', '2026-03-09 09:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `allottee_property_fin_details`
--

CREATE TABLE `allottee_property_fin_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allottee_id` bigint(20) UNSIGNED NOT NULL,
  `tentative_price` decimal(12,2) DEFAULT NULL,
  `amount_words` varchar(255) DEFAULT NULL,
  `maav_day` tinyint(4) DEFAULT NULL,
  `maav_month` tinyint(4) DEFAULT NULL,
  `maav_year` year(4) DEFAULT NULL,
  `high_income_percent` decimal(5,2) DEFAULT NULL,
  `low_income_percent` decimal(5,2) DEFAULT NULL,
  `deposited_amount` decimal(12,2) DEFAULT NULL,
  `legal_fee` decimal(10,2) DEFAULT NULL,
  `legal_document_fee` decimal(10,2) DEFAULT NULL,
  `total_payment` decimal(12,2) DEFAULT NULL,
  `interim_price` decimal(12,2) DEFAULT NULL,
  `remaining_amount` decimal(12,2) DEFAULT NULL,
  `payment_months` int(11) DEFAULT NULL,
  `payment_start_month` tinyint(4) DEFAULT NULL,
  `payment_start_year` year(4) DEFAULT NULL,
  `last_payment_due_date` varchar(50) DEFAULT NULL,
  `interest_type` enum('simple','compound') DEFAULT NULL,
  `pre_interest` decimal(5,2) DEFAULT NULL,
  `late_interest` decimal(5,2) DEFAULT NULL,
  `pre_interest_amount` decimal(12,2) DEFAULT NULL,
  `late_interest_amount` decimal(12,2) DEFAULT NULL,
  `allot_day` tinyint(4) DEFAULT NULL,
  `allot_month` tinyint(4) DEFAULT NULL,
  `allot_year` year(4) DEFAULT NULL,
  `lottery_details` varchar(255) DEFAULT NULL,
  `colony_name` varchar(255) DEFAULT NULL,
  `plot_number` varchar(100) DEFAULT NULL,
  `area_sqft` decimal(10,2) DEFAULT NULL,
  `mohalla` varchar(150) DEFAULT NULL,
  `post_office` varchar(150) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `police_station` varchar(150) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `district` int(11) DEFAULT NULL,
  `north_boundary` varchar(100) DEFAULT NULL,
  `south_boundary` varchar(100) DEFAULT NULL,
  `east_boundary` varchar(100) DEFAULT NULL,
  `west_boundary` varchar(100) DEFAULT NULL,
  `ew_north` varchar(100) DEFAULT NULL,
  `ew_south` varchar(100) DEFAULT NULL,
  `ns_east` varchar(100) DEFAULT NULL,
  `ns_west` varchar(100) DEFAULT NULL,
  `specified_days` varchar(50) DEFAULT NULL,
  `last_day` tinyint(4) DEFAULT NULL,
  `last_month` tinyint(4) DEFAULT NULL,
  `last_year` year(4) DEFAULT NULL,
  `created_ip` varchar(45) DEFAULT NULL,
  `updated_ip` varchar(45) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allottee_property_fin_details`
--

INSERT INTO `allottee_property_fin_details` (`id`, `allottee_id`, `tentative_price`, `amount_words`, `maav_day`, `maav_month`, `maav_year`, `high_income_percent`, `low_income_percent`, `deposited_amount`, `legal_fee`, `legal_document_fee`, `total_payment`, `interim_price`, `remaining_amount`, `payment_months`, `payment_start_month`, `payment_start_year`, `last_payment_due_date`, `interest_type`, `pre_interest`, `late_interest`, `pre_interest_amount`, `late_interest_amount`, `allot_day`, `allot_month`, `allot_year`, `lottery_details`, `colony_name`, `plot_number`, `area_sqft`, `mohalla`, `post_office`, `city`, `police_station`, `state`, `district`, `north_boundary`, `south_boundary`, `east_boundary`, `west_boundary`, `ew_north`, `ew_south`, `ns_east`, `ns_west`, `specified_days`, `last_day`, `last_month`, `last_year`, `created_ip`, `updated_ip`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 3, 2088000.00, 'Twenty Lakh Eighty Eight Thousand Only', 4, 5, '2011', 25.00, NULL, 522000.00, 3000.00, 200.00, 519200.00, 2088000.00, 1566000.00, 60, 2, '2015', 'January 2020', 'compound', 13.50, 2.50, 36034.00, 38083.00, 21, 8, '2013', 'Indian Loatery', 'Sarle Colony', 'PLT-546464', 1200.00, 'Sarle', 'Sarle Post office', 'Sarle', 'Kikudih Police Station', 15, 265, '30', '40', '60', '40', '60', '60', '70', '40', '75 days', 15, 11, '2012', '127.0.0.1', '127.0.0.1', 1, 1, '2026-03-09 05:13:34', '2026-03-09 11:22:17');

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
('captcha_07eb5699d0182ab751db2e9578f6f549', 'a:5:{i:0;s:1:\"h\";i:1;s:1:\"8\";i:2;s:1:\"w\";i:3;s:1:\"n\";i:4;s:1:\"c\";}', 1772098076),
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
('captcha_66c9021f6a2ae235e8396305535f857b', 'a:5:{i:0;s:1:\"5\";i:1;s:1:\"s\";i:2;s:1:\"t\";i:3;s:1:\"b\";i:4;s:1:\"i\";}', 1771917449),
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
('captcha_cc917c1f03b1e9c4c5379a92fb88f6c8', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"f\";i:2;s:1:\"o\";i:3;s:1:\"0\";i:4;s:1:\"n\";}', 1771907819),
('captcha_d2f037f31bd75095506234c4493a5c87', 'a:6:{i:0;s:1:\"m\";i:1;s:1:\"r\";i:2;s:1:\"b\";i:3;s:1:\"d\";i:4;s:1:\"m\";i:5;s:1:\"h\";}', 1771648111),
('captcha_dc09a3162147595f7fb9f76180d2c78f', 'a:5:{i:0;s:1:\"q\";i:1;s:1:\"n\";i:2;s:1:\"a\";i:3;s:1:\"o\";i:4;s:1:\"1\";}', 1771648188),
('captcha_de2ec868cb5f1a3d2c929449ffd543f0', 'a:5:{i:0;s:1:\"h\";i:1;s:1:\"p\";i:2;s:1:\"y\";i:3;s:1:\"w\";i:4;s:1:\"k\";}', 1772777821),
('captcha_e8f0b5a4cc560152c975e4bb00ebaa8d', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"b\";i:2;s:1:\"y\";i:3;s:1:\"x\";i:4;s:1:\"j\";}', 1771648201),
('captcha_f47dd315d9ef1894c42fd4c27fa51eb2', 'a:5:{i:0;s:1:\"t\";i:1;s:1:\"x\";i:2;s:1:\"z\";i:3;s:1:\"i\";i:4;s:1:\"3\";}', 1772781046),
('captcha_f898eb87164d0d99b62216c00321c320', 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"c\";i:2;s:1:\"f\";i:3;s:1:\"h\";i:4;s:1:\"j\";}', 1771648175),
('captcha_f9fb98840e90451088ab2a5c78f35668', 'a:5:{i:0;s:1:\"5\";i:1;s:1:\"v\";i:2;s:1:\"6\";i:3;s:1:\"v\";i:4;s:1:\"g\";}', 1772165478);

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
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(10) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `name_hi` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `state_id`, `name_en`, `name_hi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nicobar', 'निकोबार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(2, 1, 'North and Middle Andaman', 'उत्तर और मध्य अंडमान', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(3, 1, 'South Andaman', 'दक्षिण अंडमान', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(4, 2, 'Alluri Sitharama Raju', 'अल्लूरी सीताराम राजू', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(5, 2, 'Anakapalli', 'अनकापल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(6, 2, 'Anantapur', 'अनंतपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(7, 2, 'Annamayya', 'अन्नमय्या', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(8, 2, 'Bapatla', 'बपटला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(9, 2, 'Chittoor', 'चित्तूर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(10, 2, 'Dr. B.R. Ambedkar Konaseema', 'डॉ. बी.आर. अंबेडकर कोनसीमा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(11, 2, 'East Godavari', 'पूर्व गोदावरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(12, 2, 'Eluru', 'एलुरु', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(13, 2, 'Guntur', 'गुंटूर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(14, 2, 'Kakinada', 'काकिनाडा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(15, 2, 'Krishna', 'कृष्णा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(16, 2, 'Kurnool', 'कुरनूल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(17, 2, 'Nandyal', 'नंद्याल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(18, 2, 'NTR', 'एन.टी.आर.', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(19, 2, 'Palnadu', 'पालनाडु', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(20, 2, 'Parvathipuram Manyam', 'पार्वतीपुरम मन्यम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(21, 2, 'Prakasam', 'प्रकाशम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(22, 2, 'Sri Sathya Sai', 'श्री सत्य साई', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(23, 2, 'Sri Balaji', 'श्री बालाजी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(24, 2, 'Srikakulam', 'श्रीकाकुलम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(25, 2, 'Tirupati', 'तिरुपति', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(26, 2, 'Visakhapatnam', 'विशाखापत्तनम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(27, 2, 'Vizianagaram', 'विजयनगरम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(28, 2, 'West Godavari', 'पश्चिम गोदावरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(29, 2, 'YSR Kadapa', 'वाई.एस.आर. कडप्पा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(30, 3, 'Anjaw', 'अंजाव', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(31, 3, 'Changlang', 'चांगलांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(32, 3, 'Dibang Valley', 'दिबांग घाटी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(33, 3, 'East Kameng', 'पूर्वी कामेंग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(34, 3, 'East Siang', 'पूर्वी सियांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(35, 3, 'Kamle', 'कामले', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(36, 3, 'Kra Daadi', 'क्रा दादी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(37, 3, 'Kurung Kumey', 'कुरुंग कुमेय', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(38, 3, 'Lepa Rada', 'लेपा राडा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(39, 3, 'Lohit', 'लोहित', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(40, 3, 'Longding', 'लॉन्गदिंग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(41, 3, 'Lower Dibang Valley', 'निचली दिबांग घाटी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(42, 3, 'Lower Subansiri', 'निचली सुबनसिरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(43, 3, 'Namsai', 'नामसाई', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(44, 3, 'Pakke Kessang', 'पक्के केस्सांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(45, 3, 'Papum Pare', 'पापुम पारे', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(46, 3, 'Shi Yomi', 'शी योमी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(47, 3, 'Siang', 'सियांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(48, 3, 'Tawang', 'तवांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(49, 3, 'Tirap', 'तिराप', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(50, 3, 'Upper Siang', 'ऊपरी सियांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(51, 3, 'Upper Subansiri', 'ऊपरी सुबनसिरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(52, 3, 'West Kameng', 'पश्चिमी कामेंग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(53, 3, 'West Siang', 'पश्चिमी सियांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(54, 4, 'Baksa', 'बक्सा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(55, 4, 'Barpeta', 'बारपेटा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(56, 4, 'Biswanath', 'बिश्वनाथ', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(57, 4, 'Bongaigaon', 'बोंगईगांव', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(58, 4, 'Cachar', 'कछार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(59, 4, 'Charaideo', 'चराईदेव', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(60, 4, 'Chirang', 'चिरांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(61, 4, 'Darrang', 'दरांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(62, 4, 'Dhemaji', 'धेमाजी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(63, 4, 'Dhubri', 'धुबरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(64, 4, 'Dibrugarh', 'डिब्रूगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(65, 4, 'Dima Hasao', 'दिमा हसाओ', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(66, 4, 'Goalpara', 'गोआलपारा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(67, 4, 'Golaghat', 'गोलाघाट', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(68, 4, 'Hailakandi', 'हैलाकांडी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(69, 4, 'Hojai', 'होजाई', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(70, 4, 'Jorhat', 'जोरहाट', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(71, 4, 'Kamrup', 'कामरूप', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(72, 4, 'Kamrup Metropolitan', 'कामरूप महानगरीय', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(73, 4, 'Karbi Anglong', 'कार्बी आंगलोंग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(74, 4, 'Karimganj', 'करीमगंज', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(75, 4, 'Kokrajhar', 'कोकराझार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(76, 4, 'Lakhimpur', 'लखीमपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(77, 4, 'Majuli', 'माजुली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(78, 4, 'Morigaon', 'मोरिगांव', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(79, 4, 'Nagaon', 'नगांव', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(80, 4, 'Nalbari', 'नलबाड़ी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(81, 4, 'Sivasagar', 'शिवसागर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(82, 4, 'Sonitpur', 'सोनितपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(83, 4, 'South Salmara Mankachar', 'दक्षिण सलमारा मानकचार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(84, 4, 'Tinsukia', 'तिनसुकिया', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(85, 4, 'Udalguri', 'उदालगुड़ी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(86, 4, 'West Karbi Anglong', 'पश्चिम कार्बी आंगलोंग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(87, 5, 'Araria', 'अररिया', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(88, 5, 'Arwal', 'अरवल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(89, 5, 'Aurangabad', 'औरंगाबाद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(90, 5, 'Banka', 'बांका', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(91, 5, 'Begusarai', 'बेगूसराय', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(92, 5, 'Bhagalpur', 'भागलपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(93, 5, 'Bhojpur', 'भोजपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(94, 5, 'Buxar', 'बक्सर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(95, 5, 'Darbhanga', 'दरभंगा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(96, 5, 'East Champaran', 'पूर्वी चंपारण', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(97, 5, 'Gaya', 'गया', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(98, 5, 'Gopalganj', 'गोपालगंज', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(99, 5, 'Jamui', 'जमुई', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(100, 5, 'Jehanabad', 'जहानाबाद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(101, 5, 'Kaimur', 'कैमूर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(102, 5, 'Katihar', 'कटिहार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(103, 5, 'Khagaria', 'खगड़िया', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(104, 5, 'Kishanganj', 'किशनगंज', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(105, 5, 'Lakhisarai', 'लखीसराय', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(106, 5, 'Madhepura', 'मधेपुरा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(107, 5, 'Madhubani', 'मधुबनी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(108, 5, 'Munger', 'मुंगेर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(109, 5, 'Muzaffarpur', 'मुजफ्फरपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(110, 5, 'Nalanda', 'नालंदा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(111, 5, 'Nawada', 'नवादा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(112, 5, 'Patna', 'पटना', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(113, 5, 'Purnia', 'पूर्णिया', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(114, 5, 'Rohtas', 'रोहतास', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(115, 5, 'Saharsa', 'सहरसा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(116, 5, 'Samastipur', 'समस्तीपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(117, 5, 'Saran', 'सारण', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(118, 5, 'Sheikhpura', 'शेखपुरा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(119, 5, 'Sheohar', 'शिवहर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(120, 5, 'Sitamarhi', 'सीतामढ़ी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(121, 5, 'Siwan', 'सिवान', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(122, 5, 'Supaul', 'सुपौल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(123, 5, 'Vaishali', 'वैशाली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(124, 5, 'West Champaran', 'पश्चिमी चंपारण', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(125, 6, 'Chandigarh', 'चंडीगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(126, 7, 'Balod', 'बालोद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(127, 7, 'Baloda Bazar', 'बलौदा बाजार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(128, 7, 'Balrampur', 'बलरामपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(129, 7, 'Bastar', 'बस्तर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(130, 7, 'Bemetara', 'बेमेतरा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(131, 7, 'Bijapur', 'बीजापुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(132, 7, 'Bilaspur', 'बिलासपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(133, 7, 'Dantewada', 'दंतेवाड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(134, 7, 'Dhamtari', 'धमतरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(135, 7, 'Durg', 'दुर्ग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(136, 7, 'Gariaband', 'गरियाबंद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(137, 7, 'Gaurela-Pendra-Marwahi', 'गौरेला-पेंड्रा-मारवाही', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(138, 7, 'Janjgir-Champa', 'जांजगीर-चांपा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(139, 7, 'Jashpur', 'जशपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(140, 7, 'Kabirdham', 'कबीरधाम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(141, 7, 'Kanker', 'कांकेर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(142, 7, 'Khairagarh-Chhuikhadan-Gandai', 'खैरागढ़-छुईखदान-गंडई', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(143, 7, 'Kondagaon', 'कोंडागांव', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(144, 7, 'Korba', 'कोरबा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(145, 7, 'Korea', 'कोरिया', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(146, 7, 'Mahasamund', 'महासमुंद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(147, 7, 'Manendragarh-Chirmiri-Bharatpur', 'मनेन्द्रगढ़-चिरमिरी-भारतपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(148, 7, 'Mohla-Manpur-Ambagarh', 'मोहला-मानपुर-अंबागढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(149, 7, 'Mungeli', 'मुंगेली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(150, 7, 'Narayanpur', 'नारायणपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(151, 7, 'Raigarh', 'रायगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(152, 7, 'Raipur', 'रायपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(153, 7, 'Rajnandgaon', 'राजनांदगांव', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(154, 7, 'Sakti', 'सकती', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(155, 7, 'Sarangarh-Bilaigarh', 'सारंगढ़-बिलाईगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(156, 7, 'Sukma', 'सुकमा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(157, 7, 'Surajpur', 'सूरजपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(158, 7, 'Surguja', 'सurguja', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(159, 8, 'Dadra and Nagar Haveli', 'दादरा और नगर हवेली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(160, 8, 'Daman', 'दमन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(161, 8, 'Diu', 'दीव', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(162, 9, 'Central Delhi', 'मध्य दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(163, 9, 'East Delhi', 'पूर्वी दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(164, 9, 'New Delhi', 'नई दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(165, 9, 'North Delhi', 'उत्तरी दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(166, 9, 'North East Delhi', 'उत्तर-पूर्वी दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(167, 9, 'North West Delhi', 'उत्तर-पश्चिमी दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(168, 9, 'Shahdara', 'शाहदरा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(169, 9, 'South Delhi', 'दक्षिण दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(170, 9, 'South East Delhi', 'दक्षिण-पूर्वी दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(171, 9, 'South West Delhi', 'दक्षिण-पश्चिमी दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(172, 9, 'West Delhi', 'पश्चिमी दिल्ली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(173, 10, 'North Goa', 'उत्तर गोवा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(174, 10, 'South Goa', 'दक्षिण गोवा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(175, 11, 'Ahmedabad', 'अहमदाबाद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(176, 11, 'Amreli', 'अमरेली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(177, 11, 'Anand', 'आनंद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(178, 11, 'Aravalli', 'अरावली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(179, 11, 'Banaskantha', 'बनासकांठा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(180, 11, 'Bharuch', 'भरूच', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(181, 11, 'Bhavnagar', 'भावनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(182, 11, 'Botad', 'बोटाद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(183, 11, 'Chhota Udaipur', 'छोटा उदयपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(184, 11, 'Dahod', 'दाहोद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(185, 11, 'Dang', 'डांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(186, 11, 'Devbhoomi Dwarka', 'देवभूमि द्वारका', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(187, 11, 'Gandhinagar', 'गांधीनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(188, 11, 'Gir Somnath', 'गिर सोमनाथ', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(189, 11, 'Jamnagar', 'जामनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(190, 11, 'Junagadh', 'जूनागढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(191, 11, 'Kheda', 'खेड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(192, 11, 'Kutch', 'कच्छ', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(193, 11, 'Mahisagar', 'माहीसागर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(194, 11, 'Mehsana', 'मेहसाणा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(195, 11, 'Morbi', 'मोरबी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(196, 11, 'Narmada', 'नर्मदा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(197, 11, 'Navsari', 'नवसारी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(198, 11, 'Panchmahal', 'पंचमहाल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(199, 11, 'Patan', 'पाटण', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(200, 11, 'Porbandar', 'पोरबंदर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(201, 11, 'Rajkot', 'राजकोट', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(202, 11, 'Sabarkantha', 'साबरकांठा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(203, 11, 'Surat', 'सूरत', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(204, 11, 'Surendranagar', 'सुरेंद्रनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(205, 11, 'Tapi', 'तापी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(206, 11, 'Vadodara', 'वडोदरा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(207, 11, 'Valsad', 'वलसाड', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(208, 12, 'Ambala', 'अंबाला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(209, 12, 'Bhiwani', 'भिवानी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(210, 12, 'Charkhi Dadri', 'चरखी दादरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(211, 12, 'Faridabad', 'फरीदाबाद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(212, 12, 'Fatehabad', 'फतेहाबाद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(213, 12, 'Gurugram', 'गुरुग्राम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(214, 12, 'Hisar', 'हिसार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(215, 12, 'Jhajjar', 'झज्जर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(216, 12, 'Jind', 'जींद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(217, 12, 'Kaithal', 'कैथल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(218, 12, 'Karnal', 'करनाल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(219, 12, 'Kurukshetra', 'कुरुक्षेत्र', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(220, 12, 'Mahendragarh', 'महेंद्रगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(221, 12, 'Nuh', 'नूंह', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(222, 12, 'Palwal', 'पलवल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(223, 12, 'Panchkula', 'पंचकूला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(224, 12, 'Panipat', 'पानीपत', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(225, 12, 'Rewari', 'रेवाड़ी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(226, 12, 'Rohtak', 'रोहतक', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(227, 12, 'Sirsa', 'सिरसा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(228, 12, 'Sonipat', 'सोनीपत', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(229, 12, 'Yamunanagar', 'यमुनानगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(230, 13, 'Bilaspur', 'बिलासपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(231, 13, 'Chamba', 'चंबा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(232, 13, 'Hamirpur', 'हमीरपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(233, 13, 'Kangra', 'कांगड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(234, 13, 'Kinnaur', 'किन्नौर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(235, 13, 'Kullu', 'कुल्लू', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(236, 13, 'Lahaul and Spiti', 'लाहौल और स्पीति', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(237, 13, 'Mandi', 'मंडी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(238, 13, 'Shimla', 'शिमला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(239, 13, 'Sirmaur', 'सिरमौर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(240, 13, 'Solan', 'सोलन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(241, 13, 'Una', 'ऊना', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(242, 14, 'Anantnag', 'अनंतनाग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(243, 14, 'Bandipora', 'बांदीपोरा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(244, 14, 'Baramulla', 'बारामूला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(245, 14, 'Budgam', 'बडगाम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(246, 14, 'Doda', 'डोडा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(247, 14, 'Ganderbal', 'गांदरबल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(248, 14, 'Jammu', 'जम्मू', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(249, 14, 'Kathua', 'कठुआ', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(250, 14, 'Kishtwar', 'किश्तवाड़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(251, 14, 'Kulgam', 'कुलगाम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(252, 14, 'Kupwara', 'कुपवाड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(253, 14, 'Poonch', 'पुंछ', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(254, 14, 'Pulwama', 'पुलवामा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(255, 14, 'Rajouri', 'राजौरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(256, 14, 'Ramban', 'रामबन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(257, 14, 'Reasi', 'रियासी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(258, 14, 'Samba', 'सांबा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(259, 14, 'Shopian', 'शोपियां', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(260, 14, 'Srinagar', 'श्रीनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(261, 14, 'Udhampur', 'उधमपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(262, 15, 'Bokaro', 'बोकारो', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(263, 15, 'Chatra', 'चतरा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(264, 15, 'Deoghar', 'देवघर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(265, 15, 'Dhanbad', 'धनबाद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(266, 15, 'Dumka', 'दुमका', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(267, 15, 'East Singhbhum', 'पूर्वी सिंहभूम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(268, 15, 'Garhwa', 'गढ़वा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(269, 15, 'Giridih', 'गिरिडीह', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(270, 15, 'Godda', 'गोड्डा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(271, 15, 'Gumla', 'गुमला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(272, 15, 'Hazaribagh', 'हजारीबाग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(273, 15, 'Jamtara', 'जामताड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(274, 15, 'Khunti', 'खूंटी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(275, 15, 'Koderma', 'कोडरमा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(276, 15, 'Latehar', 'लातेहार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(277, 15, 'Lohardaga', 'लोहरदगा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(278, 15, 'Pakur', 'पाकुड़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(279, 15, 'Palamu', 'पलामू', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(280, 15, 'Ramgarh', 'रामगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(281, 15, 'Ranchi', 'रांची', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(282, 15, 'Sahibganj', 'साहिबगंज', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(283, 15, 'Seraikela Kharsawan', 'सरायकेला खरसावां', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(284, 15, 'Simdega', 'सिमडेगा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(285, 15, 'West Singhbhum', 'पश्चिमी सिंहभूम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(286, 16, 'Bagalkot', 'बागलकोट', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(287, 16, 'Ballari', 'बल्लारी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(288, 16, 'Belagavi', 'बेलगावी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(289, 16, 'Bengaluru Rural', 'बेंगलुरु ग्रामीण', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(290, 16, 'Bengaluru Urban', 'बेंगलुरु शहरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(291, 16, 'Bidar', 'बीदर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(292, 16, 'Chamarajanagar', 'चामराजनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(293, 16, 'Chikkaballapur', 'चikkaballapur', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(294, 16, 'Chikkamagaluru', 'चिक्कमगलुरु', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(295, 16, 'Chitradurga', 'चित्रदुर्ग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(296, 16, 'Dakshina Kannada', 'दक्षिण कन्नड़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(297, 16, 'Davanagere', 'दावणगेरे', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(298, 16, 'Dharwad', 'धारवाड़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(299, 16, 'Gadag', 'गदग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(300, 16, 'Hassan', 'हासन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(301, 16, 'Haveri', 'हावेरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(302, 16, 'Kalaburagi', 'कलबुरगी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(303, 16, 'Kodagu', 'कोडगु', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(304, 16, 'Kolar', 'कोलार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(305, 16, 'Koppal', 'कोप्पल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(306, 16, 'Mandya', 'मंड्या', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(307, 16, 'Mysuru', 'मैसूरु', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(308, 16, 'Raichur', 'रायचूर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(309, 16, 'Ramanagara', 'रामनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(310, 16, 'Shivamogga', 'शिवमोग्गा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(311, 16, 'Tumakuru', 'तुमकुरु', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(312, 16, 'Udupi', 'उडुपी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(313, 16, 'Uttara Kannada', 'उत्तर कन्नड़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(314, 16, 'Vijayanagara', 'विजयनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(315, 16, 'Vijayapura', 'विजयपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(316, 16, 'Yadgir', 'यादगीर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(317, 17, 'Alappuzha', 'अलप्पुझा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(318, 17, 'Ernakulam', 'एर्नाकुलम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(319, 17, 'Idukki', 'इडुक्की', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(320, 17, 'Kannur', 'कन्नूर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(321, 17, 'Kasaragod', 'कासरगोड', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(322, 17, 'Kollam', 'कोल्लम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(323, 17, 'Kottayam', 'कोट्टायम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(324, 17, 'Kozhikode', 'कोझिकोड', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(325, 17, 'Malappuram', 'मलप्पुरम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(326, 17, 'Palakkad', 'पालक्काड़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(327, 17, 'Pathanamthitta', 'पठानमथिट्टा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(328, 17, 'Thiruvananthapuram', 'तिरुवनंतपुरम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(329, 17, 'Thrissur', 'त्रिशूर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(330, 17, 'Wayanad', 'वायनाड', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(331, 18, 'Kargil', 'कारगिल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(332, 18, 'Leh', 'लेह', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(333, 19, 'Lakshadweep', 'लक्षद्वीप', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(334, 20, 'Agar Malwa', 'अगर मालवा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(335, 20, 'Alirajpur', 'अलीराजपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(336, 20, 'Anuppur', 'अनूपपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(337, 20, 'Ashoknagar', 'अशोकनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(338, 20, 'Balaghat', 'बालाघाट', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(339, 20, 'Barwani', 'बरवानी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(340, 20, 'Betul', 'बैतूल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(341, 20, 'Bhind', 'भिंड', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(342, 20, 'Bhopal', 'भोपाल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(343, 20, 'Burhanpur', 'बुरहानपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(344, 20, 'Chhatarpur', 'छतरपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(345, 20, 'Chhindwara', 'छिंदवाड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(346, 20, 'Damoh', 'दमोह', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(347, 20, 'Datia', 'दतिया', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(348, 20, 'Dewas', 'देवास', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(349, 20, 'Dhar', 'धार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(350, 20, 'Dindori', 'डिंडोरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(351, 20, 'Guna', 'गुना', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(352, 20, 'Gwalior', 'ग्वालियर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(353, 20, 'Harda', 'हारदा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(354, 20, 'Hoshangabad', 'होशंगाबाद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(355, 20, 'Indore', 'इंदौर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(356, 20, 'Jabalpur', 'जबलपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(357, 20, 'Jhabua', 'झाबुआ', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(358, 20, 'Katni', 'कटनी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(359, 20, 'Khandwa', 'खंडवा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(360, 20, 'Khargone', 'खरगोन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(361, 20, 'Maihar', 'मैहर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(362, 20, 'Mandla', 'मंडला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(363, 20, 'Mandsaur', 'मंदसौर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(364, 20, 'Morena', 'मुरैना', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(365, 20, 'Narmadapuram', 'नर्मदापुरम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(366, 20, 'Narsinghpur', 'नरसिंहपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(367, 20, 'Neemuch', 'नीमच', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(368, 20, 'Niwari', 'निवाड़ी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(369, 20, 'Panna', 'पन्ना', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(370, 20, 'Raisen', 'रायसेन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(371, 20, 'Rajgarh', 'राजगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(372, 20, 'Ratlam', 'रतलाम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(373, 20, 'Rewa', 'रीवा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(374, 20, 'Sagar', 'सागर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(375, 20, 'Satna', 'सतना', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(376, 20, 'Sehore', 'सीहोर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(377, 20, 'Seoni', 'सिवनी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(378, 20, 'Shahdol', 'शहडोल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(379, 20, 'Shajapur', 'शाजापुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(380, 20, 'Sheopur', 'श्योपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(381, 20, 'Shivpuri', 'शिवपुरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(382, 20, 'Sidhi', 'सीधी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(383, 20, 'Singrauli', 'सिंगरौली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(384, 20, 'Tikamgarh', 'टीकमगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(385, 20, 'Ujjain', 'उज्जैन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(386, 20, 'Umaria', 'उमरिया', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(387, 20, 'Vidisha', 'विदिशा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(388, 21, 'Ahmednagar', 'अहमदनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(389, 21, 'Akola', 'अकोला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(390, 21, 'Amravati', 'अमरावती', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(391, 21, 'Aurangabad', 'औरंगाबाद', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(392, 21, 'Beed', 'बीड़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(393, 21, 'Bhandara', 'भंडारा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(394, 21, 'Buldhana', 'बुलढाणा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(395, 21, 'Chandrapur', 'चंद्रपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(396, 21, 'Dhule', 'धुले', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(397, 21, 'Gadchiroli', 'गढ़चिरौली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(398, 21, 'Gondia', 'गोंदिया', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(399, 21, 'Hingoli', 'हिंगोली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(400, 21, 'Jalgaon', 'जलगांव', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(401, 21, 'Jalna', 'जालना', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(402, 21, 'Kolhapur', 'कोल्हापुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(403, 21, 'Latur', 'लातूर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(404, 21, 'Mumbai City', 'मुंबई शहर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(405, 21, 'Mumbai Suburban', 'मुंबई उपनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(406, 21, 'Nagpur', 'नागपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(407, 21, 'Nanded', 'नांदेड़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(408, 21, 'Nandurbar', 'नंदुरबार', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(409, 21, 'Nashik', 'नासिक', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(410, 21, 'Osmanabad', ' Osmanabad', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(411, 21, 'Palghar', 'पालघर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(412, 21, 'Parbhani', 'परभणी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(413, 21, 'Pune', 'पुणे', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(414, 21, 'Raigad', 'रायगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(415, 21, 'Ratnagiri', 'रत्नागिरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(416, 21, 'Sangli', 'सांगली', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(417, 21, 'Satara', 'सातारा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(418, 21, 'Sindhudurg', 'सिंधुदुर्ग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(419, 21, 'Solapur', 'सोलापुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(420, 21, 'Thane', 'ठाणे', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(421, 21, 'Wardha', 'वर्धा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(422, 21, 'Washim', 'वाशिम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(423, 21, 'Yavatmal', 'यवतमाल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(424, 22, 'Bishnupur', 'बिश्नुपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(425, 22, 'Chandel', 'चंदेल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(426, 22, 'Churachandpur', 'चुराचांदपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(427, 22, 'Imphal East', 'इंफाल पूर्वी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(428, 22, 'Imphal West', 'इंफाल पश्चिमी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(429, 22, 'Jiribam', 'जिरिबाम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(430, 22, 'Kakching', 'काकचिंग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(431, 22, 'Kamjong', 'कामजोंग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(432, 22, 'Kangpokpi', 'कांगपोकपी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(433, 22, 'Noney', 'नोनी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(434, 22, 'Pherzawl', 'फेरजावल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(435, 22, 'Senapati', 'सेनापति', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(436, 22, 'Tamenglong', 'तामेंगलॉन्ग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(437, 22, 'Tengnoupal', 'तेंगनौपाल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(438, 22, 'Thoubal', 'थौबाल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(439, 22, 'Ukhrul', 'उखरुल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(440, 23, 'East Garo Hills', 'पूर्वी गारो हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(441, 23, 'East Jaintia Hills', 'पूर्वी जैंतिया हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(442, 23, 'East Khasi Hills', 'पूर्वी खासी हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(443, 23, 'Mawkyrwat', 'मावकिरवट', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(444, 23, 'North Garo Hills', 'उत्तरी गारो हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(445, 23, 'Ri Bhoi', 'री भोई', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(446, 23, 'South Garo Hills', 'दक्षिण गारो हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(447, 23, 'South West Garo Hills', 'दक्षिण पश्चिम गारो हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(448, 23, 'South West Khasi Hills', 'दक्षिण पश्चिम खासी हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(449, 23, 'West Garo Hills', 'पश्चिम गारो हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(450, 23, 'West Jaintia Hills', 'पश्चिम जैंतिया हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(451, 23, 'West Khasi Hills', 'पश्चिम खासी हिल्स', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(452, 24, 'Aizawl', 'आइजोल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(453, 24, 'Champhai', 'चम्फाई', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(454, 24, 'Hnahthial', 'ह्नाथ्थियाल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(455, 24, 'Khawzawl', 'खावजॉल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(456, 24, 'Kolasib', 'कोलासिब', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(457, 24, 'Lawngtlai', 'लॉन्गतलाई', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(458, 24, 'Lunglei', 'लुंगलेई', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(459, 24, 'Mamit', 'मामित', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(460, 24, 'Saiha', 'सैहा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(461, 24, 'Saitual', 'सैतुअल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(462, 24, 'Serchhip', 'सेरछिप', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(463, 25, 'Chumukedima', 'चुमुकेदिमा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(464, 25, 'Dimapur', 'दीमापुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(465, 25, 'Kiphire', 'किफिरे', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(466, 25, 'Kohima', 'कोहिमा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(467, 25, 'Longleng', 'लॉन्गलेंग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(468, 25, 'Mokokchung', 'मोकोकचुंग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(469, 25, 'Mon', 'मोन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(470, 25, 'Niuland', 'न्यूलैंड', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(471, 25, 'Noklak', 'नोकलाक', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(472, 25, 'Peren', 'पेरेन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(473, 25, 'Phek', 'फेक', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(474, 25, 'Shamator', 'शामاتور', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(475, 25, 'Tseminyu', 'त्सेमिन्यू', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(476, 25, 'Tuensang', 'तुएंसांग', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(477, 25, 'Wokha', 'वोखा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(478, 25, 'Zunheboto', 'जुन्हेबोटो', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(479, 26, 'Angul', 'अंगुल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(480, 26, 'Balangir', 'बलांगिर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(481, 26, 'Balasore', 'बालासोर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(482, 26, 'Bargarh', 'बरगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(483, 26, 'Bhadrak', 'भद्रक', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(484, 26, 'Boudh', 'बौध', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(485, 26, 'Cuttack', 'कटक', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(486, 26, 'Deogarh', 'देवगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(487, 26, 'Dhenkanal', 'धेंकनाल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(488, 26, 'Gajapati', 'गजपति', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(489, 26, 'Ganjam', 'गंजाम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(490, 26, 'Jagatsinghpur', 'जगतसिंहपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(491, 26, 'Jajpur', 'जाजपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(492, 26, 'Jharsuguda', 'झारसुगुड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(493, 26, 'Kalahandi', 'कलाहांडी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(494, 26, 'Kandhamal', 'कंधमाल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(495, 26, 'Kendrapara', 'केन्द्रपाड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(496, 26, 'Kendujhar', 'केन्द्रझर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(497, 26, 'Khordha', 'खोरधा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(498, 26, 'Koraput', 'कोरापुट', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(499, 26, 'Malkangiri', 'मलकांगिरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(500, 26, 'Mayurbhanj', 'मयूरभंज', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(501, 26, 'Nabarangpur', 'नबरंगपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(502, 26, 'Nayagarh', 'नयागढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(503, 26, 'Nuapada', 'नुआपड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(504, 26, 'Puri', 'पुरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(505, 26, 'Rayagada', 'रायगड़ा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(506, 26, 'Sambalpur', 'संभलपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(507, 26, 'Subarnapur', 'सुबर्णपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(508, 26, 'Sundargarh', 'सुंदरगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(509, 27, 'Karaikal', 'कराईकल', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(510, 27, 'Mahe', 'माहे', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(511, 27, 'Puducherry', 'पुडुचेरी', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(512, 27, 'Yanam', 'यानम', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(513, 28, 'Amritsar', 'अमृतसर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(514, 28, 'Barnala', 'बरनाला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(515, 28, 'Bathinda', 'बठिंडा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(516, 28, 'Faridkot', 'फरीदकोट', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(517, 28, 'Fatehgarh Sahib', 'फतेहगढ़ साहिब', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(518, 28, 'Fazilka', 'फजिल्का', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(519, 28, 'Ferozepur', 'फिरोजपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(520, 28, 'Gurdaspur', 'गुरदासपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(521, 28, 'Hoshiarpur', 'होशियारपुर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(522, 28, 'Jalandhar', 'जालंधर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(523, 28, 'Kapurthala', 'कपूरथला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(524, 28, 'Ludhiana', 'लुधियाना', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(525, 28, 'Malerkotla', 'मलेरकोटला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(526, 28, 'Mansa', 'मानसा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(527, 28, 'Moga', 'मोगा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(528, 28, 'Pathankot', 'पठानकोट', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(529, 28, 'Patiala', 'पटियाला', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(530, 28, 'Rupnagar', 'रूपनगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(531, 28, 'Sangrur', 'संगरूर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(532, 28, 'SAS Nagar', 'एस.ए.एस. नगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(533, 28, 'SBS Nagar', 'एस.बी.एस. नगर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(534, 28, 'Sri Muktsar Sahib', 'श्री मुक्तसर साहिब', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(535, 28, 'Tarn Taran', 'तरन तारन', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(536, 29, 'Ajmer', 'अजमेर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(537, 29, 'Alwar', 'अलवर', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(538, 29, 'Anupgarh', 'अनूपगढ़', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(539, 29, 'Balotra', 'बालोतरा', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(540, 29, 'Banswara', 'बांसवाड़ा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(541, 29, 'Baran', 'बारां', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(542, 29, 'Barmer', 'बाड़मेर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(543, 29, 'Beawar', 'ब्यावर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(544, 29, 'Bharatpur', 'भरतपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(545, 29, 'Bhilwara', 'भीलवाड़ा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(546, 29, 'Bikaner', 'बीकानेर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(547, 29, 'Bundi', 'बूंदी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(548, 29, 'Chittorgarh', 'चित्तौड़गढ़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(549, 29, 'Churu', 'चूरू', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(550, 29, 'Dausa', 'दौसा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(551, 29, 'Deeg', 'डीग', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(552, 29, 'Dholpur', 'धौलपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(553, 29, 'Didwana-Kuchaman', 'दिदवाना-कुचामन', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(554, 29, 'Dudu', 'दूदू', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(555, 29, 'Dungarpur', 'डूंगरपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(556, 29, 'Ganganagar', 'गंगानगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(557, 29, 'Gangapur City', 'गंगापुर सिटी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(558, 29, 'Hanumangarh', 'हनुमानगढ़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(559, 29, 'Jaipur', 'जयपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(560, 29, 'Jaipur Rural', 'जयपुर ग्रामीण', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(561, 29, 'Jaisalmer', 'जैसलमेर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(562, 29, 'Jalore', 'जालोर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(563, 29, 'Jhalawar', 'झालावाड़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(564, 29, 'Jhunjhunu', 'झुंझुनू', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(565, 29, 'Jodhpur', 'जोधपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(566, 29, 'Jodhpur Rural', 'जोधपुर ग्रामीण', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(567, 29, 'Karauli', 'करौली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(568, 29, 'Kekri', 'केकड़ी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(569, 29, 'Khairthal-Tijara', 'खैरथल-तिजारा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(570, 29, 'Kotputli-Behror', 'कोटपूतली-बहरोड़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(571, 29, 'Nagaur', 'नागौर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(572, 29, 'Neem ka Thana', 'नीम का थाना', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(573, 29, 'Pali', 'पाली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(574, 29, 'Phalodi', 'फलोदी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(575, 29, 'Pratapgarh', 'प्रतापगढ़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(576, 29, 'Rajsamand', 'राजसमंद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(577, 29, 'Salumbar', 'सलुम्बर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(578, 29, 'Sanchore', 'सांचोर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(579, 29, 'Sawai Madhopur', 'सवाई माधोपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(580, 29, 'Shahpura', 'शाहपुरा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(581, 29, 'Sikar', 'सीकर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(582, 29, 'Sirohi', 'सिरोही', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(583, 29, 'Tonk', 'टोंक', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(584, 29, 'Udaipur', 'उदयपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(585, 30, 'Gangtok', 'गंगटोक', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(586, 30, 'Gyalshing', 'ग्यालशिंग', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(587, 30, 'Mangan', 'मंगन', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(588, 30, 'Namchi', 'नामची', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(589, 30, 'Pakyong', 'पाकयोंग', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(590, 30, 'Soreng', 'सोरेंग', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(591, 31, 'Ariyalur', 'अरियालुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(592, 31, 'Chengalpattu', 'चेंगलपट्टू', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(593, 31, 'Chennai', 'चेन्नई', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(594, 31, 'Coimbatore', 'कोयंबटूर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(595, 31, 'Cuddalore', 'कडलूर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(596, 31, 'Dharmapuri', 'धर्मपुरी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(597, 31, 'Dindigul', 'दिंडिगुल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(598, 31, 'Erode', 'ईरोड', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(599, 31, 'Kallakurichi', 'कल्लाकुरिची', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(600, 31, 'Kancheepuram', 'कांचीपुरम', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(601, 31, 'Kanniyakumari', 'कन्याकुमारी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(602, 31, 'Karur', 'करूर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(603, 31, 'Krishnagiri', 'कृष्णगिरि', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(604, 31, 'Madurai', 'मदुरै', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(605, 31, 'Mayiladuthurai', 'मयिलादुतुरै', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(606, 31, 'Nagapattinam', 'नागपट्टिनम', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(607, 31, 'Namakkal', 'नामक्कल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(608, 31, 'Nilgiris', 'नीलगिरि', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(609, 31, 'Perambalur', 'पेरंबलूर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(610, 31, 'Pudukkottai', 'पुदुक्कोट्टै', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(611, 31, 'Ramanathapuram', 'रामनाथपुरम', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(612, 31, 'Ranipet', 'रणिपेट', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(613, 31, 'Salem', 'सेलम', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(614, 31, 'Sivaganga', 'शिवगंगा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(615, 31, 'Tenkasi', 'तेनकासी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(616, 31, 'Thanjavur', 'तंजावुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(617, 31, 'Theni', 'थेनी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(618, 31, 'Thoothukudi', 'तूथुकुडी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(619, 31, 'Tiruchirappalli', 'तिरुचिरापल्ली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(620, 31, 'Tirunelveli', 'तिरुनेलवेली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(621, 31, 'Tirupathur', 'तिरुपत्तूर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(622, 31, 'Tiruppur', 'तिरुप्पूर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(623, 31, 'Tiruvallur', 'तिरुवल्लूर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(624, 31, 'Tiruvannamalai', 'तिरुवन्नामलै', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(625, 31, 'Tiruvarur', 'तिरुवारूर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(626, 31, 'Vellore', 'वेल्लोर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(627, 31, 'Viluppuram', 'विलुप्पुरम', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(628, 31, 'Virudhunagar', 'विरुद्धुनगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(629, 32, 'Adilabad', 'आदिलाबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(630, 32, 'Bhadradri Kothagudem', 'भद्राद्री कोठागुडेम', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(631, 32, 'Hyderabad', 'हैदराबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(632, 32, 'Jagtial', 'जगतियाल', '2026-02-28 11:03:31', '2026-02-28 11:03:31');
INSERT INTO `districts` (`id`, `state_id`, `name_en`, `name_hi`, `created_at`, `updated_at`) VALUES
(633, 32, 'Jangaon', 'जंगांव', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(634, 32, 'Jayashankar Bhupalpally', 'जयशंकर भूपालपल्ली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(635, 32, 'Jogulamba Gadwal', 'जोगुलंबा गडवाल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(636, 32, 'Kamareddy', 'कामारेड्डी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(637, 32, 'Karimnagar', 'करीमनगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(638, 32, 'Khammam', 'खम्मम', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(639, 32, 'Komaram Bheem Asifabad', 'कोमारम भीम असिफाबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(640, 32, 'Mahabubabad', 'महबूबाबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(641, 32, 'Mahbubnagar', 'महबूबनगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(642, 32, 'Mancherial', 'मंचेरियाल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(643, 32, 'Medak', 'मेदक', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(644, 32, 'Medchal Malkajgiri', 'मेडचल मलकजगिरी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(645, 32, 'Mulugu', 'मुलुगु', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(646, 32, 'Nagarkurnool', 'नागरकुरनूल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(647, 32, 'Nalgonda', 'नलगोंडा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(648, 32, 'Narayanpet', 'नारायणपेट', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(649, 32, 'Nirmal', 'निर्मल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(650, 32, 'Nizamabad', 'निजामाबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(651, 32, 'Peddapalli', 'पेद्दापल्ली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(652, 32, 'Rajanna Sircilla', 'राजन्ना सिरसिल्ला', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(653, 32, 'Ranga Reddy', 'रंगा रेड्डी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(654, 32, 'Sangareddy', 'संगारेड्डी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(655, 32, 'Siddipet', 'सिद्दीपेट', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(656, 32, 'Suryapet', 'सूर्यापेट', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(657, 32, 'Vikarabad', 'विकाराबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(658, 32, 'Wanaparthy', 'वानापर्ती', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(659, 32, 'Warangal', 'वारंगल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(660, 32, 'Warangal Rural', 'वारंगल ग्रामीण', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(661, 32, 'Yadadri Bhuvanagiri', 'यादाद्री भुवनगिरि', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(662, 33, 'Dhalai', 'धलाई', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(663, 33, 'Gomati', 'गोमती', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(664, 33, 'Khowai', 'खोवाई', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(665, 33, 'North Tripura', 'उत्तर त्रिपुरा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(666, 33, 'Sepahijala', 'सेपाहिजला', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(667, 33, 'South Tripura', 'दक्षिण त्रिपुरा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(668, 33, 'Unakoti', 'उनाकोटी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(669, 33, 'West Tripura', 'पश्चिम त्रिपुरा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(670, 34, 'Agra', 'आगरा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(671, 34, 'Aligarh', 'अलीगढ़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(672, 34, 'Ambedkar Nagar', 'अंबेडकर नगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(673, 34, 'Amethi', 'अमेठी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(674, 34, 'Amroha', 'अमरोहा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(675, 34, 'Auraiya', 'औरैया', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(676, 34, 'Ayodhya', 'अयोध्या', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(677, 34, 'Azamgarh', 'आजमगढ़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(678, 34, 'Baghpat', 'बागपत', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(679, 34, 'Bahraich', 'बहराइच', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(680, 34, 'Ballia', 'बलिया', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(681, 34, 'Balrampur', 'बलरामपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(682, 34, 'Banda', 'बांदा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(683, 34, 'Barabanki', 'बाराबंकी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(684, 34, 'Bareilly', 'बरेली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(685, 34, 'Basti', 'बस्ती', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(686, 34, 'Bhadohi', 'भदोही', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(687, 34, 'Bijnor', 'बिजनौर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(688, 34, 'Budaun', 'बदायूं', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(689, 34, 'Bulandshahr', 'बुलंदशहर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(690, 34, 'Chandauli', 'चंदौली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(691, 34, 'Chitrakoot', 'चित्रकूट', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(692, 34, 'Deoria', 'देवरिया', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(693, 34, 'Etah', 'एटा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(694, 34, 'Etawah', 'इटावा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(695, 34, 'Farrukhabad', 'फर्रुखाबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(696, 34, 'Fatehpur', 'फतेहपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(697, 34, 'Firozabad', 'फिरोजाबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(698, 34, 'Gautam Buddha Nagar', 'गौतम बुद्ध नगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(699, 34, 'Ghaziabad', 'गाजियाबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(700, 34, 'Ghazipur', 'गाजीपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(701, 34, 'Gonda', 'गोंडा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(702, 34, 'Gorakhpur', 'गोरखपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(703, 34, 'Hamirpur', 'हमीरपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(704, 34, 'Hapur', 'हापुड़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(705, 34, 'Hardoi', 'हरदोई', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(706, 34, 'Hathras', 'हाथरस', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(707, 34, 'Jalaun', 'जालौन', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(708, 34, 'Jaunpur', 'जौनपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(709, 34, 'Jhansi', 'झांसी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(710, 34, 'Kannauj', 'कन्नौज', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(711, 34, 'Kanpur Dehat', 'कानपुर देहात', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(712, 34, 'Kanpur Nagar', 'कानपुर नगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(713, 34, 'Kasganj', 'कासगंज', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(714, 34, 'Kaushambi', 'कौशांबी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(715, 34, 'Kheri', 'खीरी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(716, 34, 'Kushinagar', 'कुशीनगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(717, 34, 'Lalitpur', 'ललितपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(718, 34, 'Lucknow', 'लखनऊ', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(719, 34, 'Maharajganj', 'महाराजगंज', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(720, 34, 'Mahoba', 'महोबा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(721, 34, 'Mainpuri', 'मैनपुरी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(722, 34, 'Mathura', 'मथुरा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(723, 34, 'Mau', 'मऊ', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(724, 34, 'Meerut', 'मेरठ', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(725, 34, 'Mirzapur', 'मिर्ज़ापुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(726, 34, 'Moradabad', 'मुरादाबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(727, 34, 'Muzaffarnagar', 'मुजफ्फरनगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(728, 34, 'Pilibhit', 'पीलीभीत', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(729, 34, 'Pratapgarh', 'प्रतापगढ़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(730, 34, 'Prayagraj', 'प्रयागराज', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(731, 34, 'Raebareli', 'रायबरेली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(732, 34, 'Rampur', 'रामपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(733, 34, 'Saharanpur', 'सहारनपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(734, 34, 'Sambhal', 'संभल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(735, 34, 'Sant Kabir Nagar', 'संत कबीर नगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(736, 34, 'Shahjahanpur', 'शाहजहांपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(737, 34, 'Shamli', 'शामली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(738, 34, 'Shravasti', 'श्रावस्ती', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(739, 34, 'Siddharthnagar', 'सिद्धार्थनगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(740, 34, 'Sitapur', 'सीतापुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(741, 34, 'Sonbhadra', 'सोनभद्र', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(742, 34, 'Sultanpur', 'सुल्तानपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(743, 34, 'Unnao', 'उन्नाव', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(744, 34, 'Varanasi', 'वाराणसी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(745, 35, 'Almora', 'अल्मोड़ा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(746, 35, 'Bageshwar', 'बागेश्वर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(747, 35, 'Chamoli', 'चमोली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(748, 35, 'Champawat', 'चंपावत', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(749, 35, 'Dehradun', 'देहरादून', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(750, 35, 'Haridwar', 'हरिद्वार', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(751, 35, 'Nainital', 'नैनीताल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(752, 35, 'Pauri Garhwal', 'पौड़ी गढ़वाल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(753, 35, 'Pithoragarh', 'पिथौरागढ़', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(754, 35, 'Rudraprayag', 'रुद्रप्रयाग', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(755, 35, 'Tehri Garhwal', 'टिहरी गढ़वाल', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(756, 35, 'Udham Singh Nagar', 'उधम सिंह नगर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(757, 35, 'Uttarkashi', 'उत्तरकाशी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(758, 36, 'Alipurduar', 'अलीपुरद्वार', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(759, 36, 'Bankura', 'बांकुड़ा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(760, 36, 'Birbhum', 'बी रभूम', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(761, 36, 'Cooch Behar', 'कूच बिहार', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(762, 36, 'Dakshin Dinajpur', 'दक्षिण दिनाजपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(763, 36, 'Darjeeling', 'दार्जिलिंग', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(764, 36, 'Hooghly', 'हुगली', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(765, 36, 'Howrah', 'हावड़ा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(766, 36, 'Jalpaiguri', 'जलपाईगुड़ी', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(767, 36, 'Jhargram', 'झाड़ग्राम', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(768, 36, 'Kalimpong', 'कालिम्पोंग', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(769, 36, 'Kolkata', 'कोलकाता', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(770, 36, 'Malda', 'मालदा', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(771, 36, 'Murshidabad', 'मुर्शिदाबाद', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(772, 36, 'Nadia', 'नादिया', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(773, 36, 'North 24 Parganas', 'उत्तर 24 परगना', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(774, 36, 'Paschim Bardhaman', 'पश्चिम बर्धमान', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(775, 36, 'Paschim Medinipur', 'पश्चिम मेदिनीपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(776, 36, 'Purba Bardhaman', 'पूर्व बर्धमान', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(777, 36, 'Purba Medinipur', 'पूर्व मेदिनीपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(778, 36, 'Purulia', 'पुरुलिया', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(779, 36, 'South 24 Parganas', 'दक्षिण 24 परगना', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(780, 36, 'Uttar Dinajpur', 'उत्तर दिनाजपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `division_code` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `division_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ranchi Division', 'RNC', 1, '2026-02-05 17:09:52', '2026-02-24 13:12:41'),
(2, 'Jamshedpur Division', 'JSR', 1, '2026-02-05 17:14:35', '2026-02-24 13:12:47'),
(3, 'Dumka Division', 'DUM', 1, '2026-02-05 17:15:43', '2026-02-24 13:12:54'),
(4, 'Dhanbad Division', 'DHN', 1, '2026-02-05 17:15:43', '2026-02-24 13:13:03'),
(5, 'Hazaribag Division', 'HZB', 1, '2026-02-05 17:15:43', '2026-02-24 13:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `document_master`
--

CREATE TABLE `document_master` (
  `id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `document_key` varchar(100) NOT NULL,
  `document_category` varchar(50) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_master`
--

INSERT INTO `document_master` (`id`, `document_name`, `document_key`, `document_category`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Application Letter', 'application_letter', 'basic', 1, 1, '2026-03-09 09:26:18', '2026-03-09 10:20:45'),
(2, 'Allotment Letter', 'allotment_letter', 'basic', 2, 1, '2026-03-09 09:26:18', '2026-03-09 10:20:42'),
(3, 'Agreement Copy', 'agreement_copy', 'basic', 3, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(4, 'Allotment Cancellation Letter', 'allotment_cancellation', 'basic', 4, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(5, 'Re-Allotment Letter', 'reallotment_letter', 'basic', 5, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(6, 'Final Calculation', 'final_calculation', 'basic', 6, 1, '2026-03-09 09:26:18', '2026-03-09 10:18:17'),
(7, 'NOC before Registry', 'noc_before_registry', 'basic', 7, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(8, 'Registry Deed', 'registry_deed', 'basic', 8, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(9, 'Name Transfer Request Order', 'name_transfer_request', 'nameTransfer', 1, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(10, 'Name Transfer forwarding from JSHB', 'name_transfer_forwarding', 'nameTransfer', 2, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(11, 'Dividend Calculation Letter', 'dividend_calculation', 'nameTransfer', 3, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(12, 'Letter for Deed to New Allottee', 'deed_letter', 'nameTransfer', 4, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(13, 'Site Verification Document', 'site_verification', 'nameTransfer', 5, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(14, 'NOC Letter', 'noc_letter', 'nameTransfer', 6, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(15, 'Name Transfer Confirmation Order', 'name_transfer_confirmation', 'nameTransfer', 7, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(16, 'Ground Rent before Registry', 'ground_rent', 'nameTransfer', 8, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(17, 'Registry Deed', 'name_transfer_registry_deed', 'nameTransfer', 9, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18');

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
(2, 'Lot-2', '2302269882', 3, '3', NULL, 'received', NULL, 2, '2026-02-23 09:29:51', '2026-02-23 09:29:51'),
(3, 'Lot-3', '2702263190', 1, '10', NULL, 'received', NULL, 1, '2026-02-27 09:56:51', '2026-02-27 09:56:51');

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
(4, '2 Rooms', 5, 1, '2026-02-07 04:40:58', '2026-02-07 04:40:58'),
(5, 'H 1 BHK', 2, 1, '2026-02-24 05:00:26', '2026-02-24 05:00:26'),
(6, 'H 2 BHK', 2, 1, '2026-02-24 05:00:43', '2026-02-24 05:00:43'),
(7, 'H 3 BHK', 2, 1, '2026-02-24 05:00:55', '2026-02-24 05:00:55');

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
(5, '2302269882', 'Yes', 'Yes', 4, 7, NULL, 1, 2, 'C-234', '2', 'Shri', 'Krishna', 'Dev', 'Murthy', 'All Old Pages', 3, 2, NULL, NULL, 'received', 1, 1, NULL, 2, NULL, '2026-02-23 09:29:45', '2026-02-23 09:29:45', '127.0.0.1'),
(6, '2702263190', 'Yes', 'No', 4, 9, NULL, 2, 4, 'PLT-34234', '2', 'Shri', 'Shiva', 'Shakti', 'Kumar', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 1, 1, '2026-02-27 09:56:51', '2026-02-27 10:04:20', '127.0.0.1');

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
(4, 2, 5, 1, 1, 1, 2, '44 HIG -adityapur Dindli Basti , Seraikela-kharsawan', '44 एचआईजी-दित्यपुर दिंदली बस्ती, सरायकेला-खरसावां', 'SCH-44-DINDLI-ADTP', 44, 90, '1962', '1962-12-12', NULL, 'active', 1, 3, NULL, '2026-02-18 07:24:13', '2026-02-24 04:56:43'),
(5, 1, 1, 1, 1, 1, 3, '67 - RNC HI FLAT HARMU, RANCHI', '67 - आरएनसी हाई फ्लैट हारमू, रांची', 'SCH-67-RNC-HRMU', 67, 90, '1990', '1990-12-02', NULL, 'active', 1, 3, NULL, '2026-02-18 07:54:39', '2026-02-18 07:54:39'),
(6, 4, 8, 1, 1, 1, 2, '55 HIG FLAT DHANBAD BOKARO', NULL, 'SCHEME-DND-42398', 55, 90, '1995', '2026-02-25', NULL, 'active', 1, 3, NULL, '2026-02-24 04:59:30', '2026-02-24 04:59:30'),
(7, 3, 6, 1, 2, 6, 3, '33 LIG-DUM-SHG Lower Income Group Jharkhand State', NULL, 'SCH-33-DUM-SHG', 33, 90, '2006', '2026-02-17', NULL, 'active', 1, 3, NULL, '2026-02-24 05:04:18', '2026-02-24 05:04:18'),
(8, 5, 10, 1, 1, 2, 2, '44 HIG -HZB-SARLE-JHARKHAND HOUSING SCHEME', NULL, 'SCH-44-HZB-SLE', 44, 99, '1998', '2026-02-19', NULL, 'active', 1, 3, NULL, '2026-02-24 05:06:28', '2026-02-24 05:06:28'),
(9, 4, 7, 1, 2, 6, 2, '110-HIG-DNB-2026-JHSB', NULL, 'SCH-110-DNB-DNBK', 110, 90, '2017', '2026-02-26', NULL, 'active', 1, 3, NULL, '2026-02-24 05:08:54', '2026-02-24 05:08:54');

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
(3, 5, 522000.00, 39.00, 200000.00, 322000.00, 50, 13.50, 8456.00, 2.50, 8865.00, 10.00, '2026-02-18 07:54:39', '2026-02-18 10:03:46'),
(4, 6, 60000.00, 20.00, 12000.00, 48000.00, 45, 13.50, 1366.00, 2.50, 1426.00, 5.00, '2026-02-24 04:59:30', '2026-02-24 04:59:30'),
(5, 7, 800000.00, 20.00, 160000.00, 640000.00, 80, 13.50, 12175.00, 2.50, 13060.00, 5.00, '2026-02-24 05:04:18', '2026-02-24 05:04:18'),
(6, 8, 250000.00, 15.00, 37500.00, 212500.00, 60, 13.50, 4890.00, 2.50, 5168.00, 5.00, '2026-02-24 05:06:28', '2026-02-24 05:06:28'),
(7, 9, 1200000.00, 21.00, 252000.00, 948000.00, 40, 13.50, 29562.00, 2.50, 30734.00, 5.00, '2026-02-24 05:08:54', '2026-02-24 05:08:54');

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
(8, 5, 5, 500.00, 2000.00, '2026-02-18 07:54:39', '2026-02-18 07:54:39'),
(9, 6, 2, 200.00, 3000.00, '2026-02-24 04:59:30', '2026-02-24 04:59:30'),
(10, 6, 3, 100.00, 2000.00, '2026-02-24 04:59:30', '2026-02-24 04:59:30'),
(11, 6, 4, 50.00, 1500.00, '2026-02-24 04:59:30', '2026-02-24 04:59:30'),
(12, 6, 5, 50.00, 1500.00, '2026-02-24 04:59:30', '2026-02-24 04:59:30'),
(13, 7, 2, 1000.00, 6000.00, '2026-02-24 05:04:18', '2026-02-24 05:04:18'),
(14, 7, 3, 700.00, 5000.00, '2026-02-24 05:04:18', '2026-02-24 05:04:18'),
(15, 7, 4, 500.00, 3000.00, '2026-02-24 05:04:18', '2026-02-24 05:04:18'),
(16, 7, 5, 500.00, 3000.00, '2026-02-24 05:04:18', '2026-02-24 05:04:18'),
(17, 8, 2, 600.00, 2500.00, '2026-02-24 05:06:28', '2026-02-24 05:06:28'),
(18, 8, 3, 400.00, 1000.00, '2026-02-24 05:06:28', '2026-02-24 05:06:28'),
(19, 8, 4, 100.00, 700.00, '2026-02-24 05:06:28', '2026-02-24 05:06:28'),
(20, 8, 5, 100.00, 700.00, '2026-02-24 05:06:28', '2026-02-24 05:06:28'),
(21, 9, 2, 2600.00, 9000.00, '2026-02-24 05:08:54', '2026-02-24 05:08:54'),
(22, 9, 3, 2000.00, 6000.00, '2026-02-24 05:08:54', '2026-02-24 05:08:54'),
(23, 9, 4, 1000.00, 3000.00, '2026-02-24 05:08:54', '2026-02-24 05:08:54'),
(24, 9, 5, 1000.00, 3000.00, '2026-02-24 05:08:54', '2026-02-24 05:08:54');

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
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `name_hi` varchar(150) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name_en`, `name_hi`, `code`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Andaman and Nicobar Islands', 'अंडमान और निकोबार द्वीप समूह', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(2, 'Andhra Pradesh', 'आंध्र प्रदेश', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(3, 'Arunachal Pradesh', 'अरुणाचल प्रदेश', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(4, 'Assam', 'असम', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(5, 'Bihar', 'बिहार', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(6, 'Chandigarh', 'चंडीगढ़', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(7, 'Chhattisgarh', 'छत्तीसगढ़', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(8, 'Dadra and Nagar Haveli and Daman and Diu', 'दादरा और नगर हवेली और दमन और दीव', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(9, 'Delhi', 'दिल्ली', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(10, 'Goa', 'गोवा', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(11, 'Gujarat', 'गुजरात', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(12, 'Haryana', 'हरियाणा', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(13, 'Himachal Pradesh', 'हिमाचल प्रदेश', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(14, 'Jammu and Kashmir', 'जम्मू और कश्मीर', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(15, 'Jharkhand', 'झारखंड', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(16, 'Karnataka', 'कर्नाटक', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(17, 'Kerala', 'केरल', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(18, 'Ladakh', 'लद्दाख', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(19, 'Lakshadweep', 'लक्षद्वीप', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(20, 'Madhya Pradesh', 'मध्य प्रदेश', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(21, 'Maharashtra', 'महाराष्ट्र', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(22, 'Manipur', 'मणिपुर', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(23, 'Meghalaya', 'मेघालय', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(24, 'Mizoram', 'मिजोरम', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(25, 'Nagaland', 'नागालैंड', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(26, 'Odisha', 'ओडिशा', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(27, 'Puducherry', 'पुडुचेरी', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(28, 'Punjab', 'पंजाब', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(29, 'Rajasthan', 'राजस्थान', NULL, 'State', '2026-02-28 11:03:30', '2026-02-28 11:03:30'),
(30, 'Sikkim', 'सिक्किम', NULL, 'State', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(31, 'Tamil Nadu', 'तमिलनाडु', NULL, 'State', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(32, 'Telangana', 'तेलंगाना', NULL, 'State', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(33, 'Tripura', 'त्रिपुरा', NULL, 'State', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(34, 'Uttar Pradesh', 'उत्तर प्रदेश', NULL, 'State', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(35, 'Uttarakhand', 'उत्तराखंड', NULL, 'State', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(36, 'West Bengal', 'पश्चिम बंगाल', NULL, 'State', '2026-02-28 11:03:31', '2026-02-28 11:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `step_skips`
--

CREATE TABLE `step_skips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_id` bigint(20) UNSIGNED NOT NULL,
  `step_number` int(11) NOT NULL,
  `step_name` varchar(100) DEFAULT NULL,
  `remark` text NOT NULL,
  `reason_category` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `skiped_by` int(11) DEFAULT NULL,
  `skipped_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_divisions`
--

CREATE TABLE `sub_divisions` (
  `id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subdivision_code` varchar(50) DEFAULT NULL,
  `colony_name` varchar(255) DEFAULT NULL,
  `locality_address` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_divisions`
--

INSERT INTO `sub_divisions` (`id`, `division_id`, `name`, `subdivision_code`, `colony_name`, `locality_address`, `status`, `created_at`) VALUES
(1, 1, 'Harmu-Ranchi', 'HR', 'Harmu Housing Colony', 'Harmu', 1, '2026-02-05 17:19:24'),
(2, 1, 'Argora-Ranchi', 'AR', 'Argora Colony', 'Argora', 1, '2026-02-05 17:19:24'),
(3, 1, 'Bariatu-Ranchi', 'BR', 'Bariatu Colony', 'Bariatu', 1, '2026-02-05 17:19:24'),
(4, 1, 'Kadru-Ranchi', 'KR', 'Kadru Colony', 'Kadru', 1, '2026-02-05 17:19:24'),
(5, 2, 'Dindli-Adityapur', 'DA', 'Dindli Colony', 'Dindli', 1, '2026-02-05 17:23:25'),
(6, 3, 'Sahibganj', 'SBG', 'Sahibganj Colony', 'Sahibganj', 1, '2026-02-05 17:23:25'),
(7, 4, 'Kumardhubi-Dhanbad', 'KRD', 'Kumardhubi Colony', 'Kumardhubi', 1, '2026-02-05 17:23:25'),
(8, 4, 'Balidih-Bokaro', 'BLH', 'Balidih Colony', 'Balidih', 1, '2026-02-05 17:23:25'),
(9, 4, 'Gomia-Bokaro', 'GM', 'Gomia Colony', 'Gomia', 1, '2026-02-05 17:23:25'),
(10, 5, 'Sarle-Hazaribag', 'SLE', 'Sarle Colony', 'Sarle', 1, '2026-02-05 17:23:25'),
(11, 5, 'Hazaribagh', 'HZB', 'Hazaribag Colony', 'Hazaribag', 1, '2026-02-05 17:23:25'),
(12, 5, 'Daltanganj', 'DTO', 'Daltanganj Colony', 'Daltanganj', 1, '2026-02-06 14:27:48'),
(13, 4, 'Hirapur-Dhanbad', 'HRP', 'Hirapur Colony', 'Hirapur', 1, '2026-02-10 19:05:56'),
(14, 2, 'Adityapur-Jamshedpur', 'ADP', 'Adityapur Colony', 'Adityapur', 1, '2026-02-10 19:12:21'),
(15, 2, 'Bagbera-Jamshedpur', 'BGB', 'Bagbera Colony', 'Bagbera', 1, '2026-02-10 19:13:19'),
(16, 2, 'Chhotagovindpur-Jamshedpur', 'CGP', 'Chhotagovindpur Colony', 'Chhota Govindpur', 1, '2026-02-10 19:13:53'),
(17, 2, 'Adityapur-1', 'ADP1', NULL, NULL, 0, '2026-02-10 19:14:29');

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
(5, '2302263032', 0, NULL, NULL, 'draft', '2026-02-23 11:25:51', '2026-02-23 11:25:51'),
(6, '2402264904', 0, 4, NULL, 'draft', '2026-02-24 09:06:38', '2026-02-24 09:06:42'),
(7, '2502266046', 0, 3, NULL, 'draft', '2026-02-25 04:32:18', '2026-02-25 04:32:22'),
(8, '2502267386', 0, NULL, NULL, 'draft', '2026-02-25 04:34:05', '2026-02-25 04:34:05'),
(9, '2502264812', 0, 15, NULL, 'draft', '2026-02-25 04:35:19', '2026-02-25 04:35:27'),
(10, '2502262656', 0, NULL, NULL, 'draft', '2026-02-25 04:35:32', '2026-02-25 04:35:32'),
(11, '2702263190', 1, 10, NULL, 'draft', '2026-02-27 09:56:07', '2026-02-27 09:56:51');

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
(1, 'COMPUTER Ed.', 'Other', 'General', '012222222222', '1996-07-12', '7979040859', 'computered3896@gmail.com', NULL, '$2y$12$FBSwitUzL/xEW1.U4oPfJOEsC1hzNrE4OqY1LPRLrW/sbNJUmWCCe', 'scanner', '2026-02-11 15:20:00', '2026-03-09 04:27:32', '2025-11-24 17:22:13', '2026-03-09 04:27:32', '127.0.0.1', '2026-03-09 04:27:32'),
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
-- Indexes for table `allottees`
--
ALTER TABLE `allottees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `allottees_contact_details`
--
ALTER TABLE `allottees_contact_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allottee_documents`
--
ALTER TABLE `allottee_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `allottee_id` (`allottee_id`);

--
-- Indexes for table `allottee_file_details`
--
ALTER TABLE `allottee_file_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allottee_nominee_bank_details`
--
ALTER TABLE `allottee_nominee_bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_allottee_id` (`allottee_id`);

--
-- Indexes for table `allottee_property_fin_details`
--
ALTER TABLE `allottee_property_fin_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_allottee_id` (`allottee_id`);

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
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_master`
--
ALTER TABLE `document_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_key` (`document_key`);

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
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `step_skips`
--
ALTER TABLE `step_skips`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `allottees`
--
ALTER TABLE `allottees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `allottees_contact_details`
--
ALTER TABLE `allottees_contact_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `allottee_documents`
--
ALTER TABLE `allottee_documents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allottee_file_details`
--
ALTER TABLE `allottee_file_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `allottee_nominee_bank_details`
--
ALTER TABLE `allottee_nominee_bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `allottee_property_fin_details`
--
ALTER TABLE `allottee_property_fin_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=781;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schemes`
--
ALTER TABLE `schemes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `scheme_master_old`
--
ALTER TABLE `scheme_master_old`
  MODIFY `scheme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scheme_quarter_fees`
--
ALTER TABLE `scheme_quarter_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `scheme_unit_quotas`
--
ALTER TABLE `scheme_unit_quotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `step_skips`
--
ALTER TABLE `step_skips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_divisions`
--
ALTER TABLE `sub_divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `temp_registers`
--
ALTER TABLE `temp_registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Constraints for table `allottee_documents`
--
ALTER TABLE `allottee_documents`
  ADD CONSTRAINT `allottee_documents_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `document_master` (`id`);

--
-- Constraints for table `allottee_nominee_bank_details`
--
ALTER TABLE `allottee_nominee_bank_details`
  ADD CONSTRAINT `fk_allottee_nominee` FOREIGN KEY (`allottee_id`) REFERENCES `allottees` (`id`) ON DELETE CASCADE;

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
