-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 11:25 AM
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
-- Database: `jshb_adms_db`
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
(3, 3, '809221305', '', NULL, '7979040859', 'gouravatced@gmail.com', '$2y$12$bVRQNcgP.DtHRnTSpr0kVOHUoM0gvA4x7vPlcmkSRhgBK9IOfp72.', NULL, 'council_office', NULL, '2026-02-25 11:41:45', '2026-02-25 11:41:45', '49.37.72.67', NULL, '2024-10-07 09:26:19', '2026-02-25 11:41:45'),
(4, 5, '8943756934', '', NULL, NULL, 'adminjshb2@gmail.com', '$2y$12$jwhx2V/0Ulgp9ibeLUnifOtPBvqzbMOPsU73wzdnskZqSulGmTn2W', NULL, 'registar', NULL, '2026-01-27 20:02:37', '2026-01-27 20:02:37', '47.31.85.195', NULL, '2024-10-23 10:43:58', '2026-02-05 12:51:44'),
(10, 3, '9435843944', 'Ajit Kumar', NULL, '9894664455', 'ajit.jshb@computered.co.in', '$2y$12$xLoMuZloZe2lFZLLpdvbj.IatRXz0Iwgoxuc07MG8P0jgtQ7jH76.', NULL, 'superadmin', NULL, '2026-03-21 05:42:16', '2026-03-21 05:42:16', '49.37.74.97', NULL, '2026-02-04 09:26:19', '2026-03-21 05:42:16'),
(11, 4, '9835310900', 'Rakesh Mathur', NULL, '9746598755', 'rakesh.sadmin@computered.co.in', '$2y$12$kydyORdyxUaaPqx6E.3wxe5Tpx8R9kWuqbTG9BXiGM4FGEz0yHxAK', NULL, 'council_office', NULL, '2026-03-21 10:19:10', '2026-03-21 10:19:10', '127.0.0.1', NULL, '2026-02-04 09:26:19', '2026-03-21 10:19:10'),
(13, 4, '9854793555', 'Rajesh Kumar', NULL, '98574938573', 'rajesh.sadmin@computered.co.in', '$2y$12$kydyORdyxUaaPqx6E.3wxe5Tpx8R9kWuqbTG9BXiGM4FGEz0yHxAK', NULL, 'council_office', NULL, '2026-03-21 09:13:25', '2026-03-21 09:13:25', '49.37.74.97', NULL, '2026-02-04 09:26:19', '2026-03-21 09:13:25');

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
(3, 'Ashish Kumar', 'Male', 'admin@admin.com', '8092213051', '8092213051', '7979040859', NULL, '2024-10-07 09:26:18', '2024-10-07 09:26:18'),
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
(17, 'gouravatced@gmail.com', '$2y$12$pGtPGOtQNwZRP98Gu2XPCepR3c0rTxs0mrvzPdXheB0Gx8uVEg./q', 'verified', '2026-02-07 04:21:37', '72ed27f742a29429d0c4f2aa80bbe281bcde4492117d2cb70f3619f72e9d9d77', 'Reset Password', 0, '127.0.0.1', '0', '2026-02-07 04:06:37', '2026-02-07 04:07:01'),
(18, 'gouravatced@gmail.com', '$2y$12$62O94rhJJmt9bba3j2Bxhe4e6tJlpXoBKtQGYEwna8r4yv2cFi92G', 'verified', '2026-02-10 04:58:18', 'e80adb836ac903a38a1857cce72540de41435c9614f255c4d1818294b5190612', 'Reset Password', 0, '49.37.72.81', '0', '2026-02-10 04:43:18', '2026-02-10 04:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `allottees`
--

CREATE TABLE `allottees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `register_id` varchar(10) DEFAULT NULL,
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
  `remarks_for_dob` varchar(255) DEFAULT NULL,
  `no_of_files` int(11) DEFAULT NULL,
  `no_of_supplement` int(11) DEFAULT NULL,
  `json_pages` longtext DEFAULT NULL,
  `total_pages` int(11) DEFAULT NULL,
  `name_transfer_status` varchar(50) NOT NULL DEFAULT 'no',
  `parent_id` int(11) DEFAULT NULL,
  `is_emi_active` enum('false','true','no_information') DEFAULT 'false',
  `current_step` int(11) DEFAULT 1,
  `is_step_completed` int(11) NOT NULL DEFAULT 0,
  `step_remarks` longtext DEFAULT NULL,
  `is_trans_entry_completed` int(11) NOT NULL DEFAULT 0,
  `allottee_document_path` varchar(255) DEFAULT NULL,
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

INSERT INTO `allottees` (`id`, `register_id`, `register_file_id`, `division_id`, `subdivision_id`, `pcategory_id`, `property_type_id`, `quarter_id`, `username`, `password`, `cedjshb`, `scheme_id`, `application_no`, `application_day`, `application_month`, `application_year`, `allotment_no`, `allotment_day`, `allotment_month`, `allotment_year`, `property_number`, `prefix`, `allottee_name`, `allottee_middle_name`, `allottee_surname`, `allottee_prefix_hindi`, `allottee_name_hindi`, `allottee_middle_hindi`, `allottee_surname_hindi`, `allottee_relation_type`, `relation_name`, `marital_status`, `allottee_gender`, `pan_card_number`, `aadhar_card_number`, `allottee_category`, `allottee_religion`, `allottee_nationality`, `age_number_of_birth_application`, `age_number_of_birth_application_hindi`, `age_word_of_birth_application`, `age_word_hindi_of_birth_application`, `date_of_birth_day`, `date_of_birth_month`, `date_of_birth_year`, `remarks_for_dob`, `no_of_files`, `no_of_supplement`, `json_pages`, `total_pages`, `name_transfer_status`, `parent_id`, `is_emi_active`, `current_step`, `is_step_completed`, `step_remarks`, `is_trans_entry_completed`, `allottee_document_path`, `allottee_create_date`, `create_ip_address`, `update_ip_address`, `updated_by`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '1602268136', 6, 1, 1, 1, 3, 4, 'RNCMI1980HRM80712', '$2y$12$I8nMVFZQrIMBfHA/WFUNHO5uURENXkDqDRSMCJoLnofY2M/0KXN2y', 'eyJpdiI6Im1QWGc5aGp4Q205RUN0dEZrNzNVOUE9PSIsInZhbHVlIjoiY3JzT0N1dm9CMUswOXFzUDVDQlU5MWdOOHM0T3ZkZllMdVRXK09SWGZabz0iLCJtYWMiOiI1NzUzYzM2MTFiZjZhZmRiODQ5N2ZhMzA0ZTk1OTcyZDFkOGU3ZjJiMWM4NTZlNGI5MDljYTdlNWY0OTc3ZWUwIiwidGFnIjoiIn0=', NULL, '128788', 28, '12', '1976', '2684/1980', 26, '04', '1980', 'C-87', 'Shri', 'Madan', 'Lal', 'Shah', 'श्री', 'मदन', 'लाल', 'साह', 'Father', 'Sri Ramdhani Sah', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '41', NULL, 'Forty One Years', NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":43}]', 43, 'yes', NULL, 'false', 6, 1, 'Step 1 : -Registry Deed not found\nStep 2 : -NOC Letter not found\nStep 3 : -Property map not found\nStep 4 : -Name transfer case, all name transfer details are found in another file.\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-87/MadanLalShah', '2026-03-19', '117.233.170.156', '117.233.180.137', 2, 2, '2026-03-19 12:25:31', '2026-03-20 05:34:54'),
(2, '1602268136', 9, 1, 1, 1, 3, 4, 'RNCMI1979HRM42180', '$2y$12$aUokEWZpZmh6.SYTdj9/ue/Xnxan/xUkDsmrBvEz0.vlJs0bgPpvK', 'eyJpdiI6InF4NzhjL3NHVDVLUjJDdHM5enhQRFE9PSIsInZhbHVlIjoiL014TXJrRnczK0tKQ0xIR01lMklvYUlpemdobEQ3TzNpQU9kVWR4Mm1FYz0iLCJtYWMiOiIxMTUwYWZmOTZhNTBmYzllOTJkNzQ1ZWU1MTBlNjlhZDUzMDgyNDAyODI2NDllNjc3YTAxYTg5NTQ3ZTA0ZWZlIiwidGFnIjoiIn0=', NULL, '127276', 14, '05', '1975', '1302/1979', 3, '06', '1979', 'C-37', 'Shri', 'Kamlesh', 'Kumar', 'Gupta', 'श्री', 'कमलेश', 'कुमार', 'गुप्त', 'Father', 'Tek Chand Gupta', 'Married', 'Male', NULL, NULL, 'OBC', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":249}]', 249, 'yes', NULL, 'false', 6, 1, 'Step 1 : - Application Form Not Found.\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1979/06/Plot/MIG/C-37/KamleshKumarGupta', '2026-03-20', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 04:49:51', '2026-03-20 05:28:13'),
(3, '1602268136', NULL, 1, 1, 1, 3, 4, 'RNCMI2010HRM78910', '$2y$12$LulOsa4tCivQFpXiSMU4z.Nc1Bk3uC7ys7S7IlhS47Dcz/iinCt..', 'eyJpdiI6ImFDZ0ZGWFFtNzlIZWlWQ2FNTTlkalE9PSIsInZhbHVlIjoicVJhQThrbEJjZXlPWjRNbnB1NitJditBVC9XK2I5MHNjZ1FpMlV1MUlzVT0iLCJtYWMiOiI5ODA0M2RmNDcyYjc1N2Y3NjNiMjAzMzBlZDM2ODMwOWIzNTJmNjFjNTgxZmVmNDg2NGJjZTg2YTM2MjY2MDZiIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 9, '09', '2010', 'C-37', 'Dr.', 'Subodh', 'Kumar', 'Sinha', 'डॉ.', 'सुबोध', 'कुमार', 'सिन्हा', 'Father', 'Late Bhagwati Kumar Sinha', 'Married', 'Male', 'AHOPS8862K', NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, 2, '03', '1949', NULL, NULL, NULL, NULL, NULL, 'no', 2, 'false', 6, 0, NULL, 0, 'documents/RNC/HRM/Residential/2010/09/Plot/MIG/C-37/SubodhKumarSinha', '2026-03-20', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 05:28:13', '2026-03-20 05:49:49'),
(4, '1602268136', NULL, 1, 1, 1, 3, 4, 'RNCMI1983HRM79264', '$2y$12$4WC8ftWGCsEb30f7H.pxu.g16jyA0xRx3Z0A0DxezcClw1BwLo4wy', 'eyJpdiI6IkxLTlN0WklUTVhnWmpneEsyWWFTQVE9PSIsInZhbHVlIjoiSEJydElmRElGSmxzOHUxZmJ2dEMvMzhMekdkaTFtNWZyUzYxWkl6Y0lVZz0iLCJtYWMiOiJlOGI1YjNhOTRjMGJkMTYxYzBhMzJlNWE3MGIxYWM3ODU5NjY2ODQ0MjBhZTcyMTA5YjE4OGE2YTY2OTgwOGIzIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 22, '07', '1983', 'C-87', 'Smt.', 'Urmila', NULL, 'Devi', 'श्री', 'उर्मिला', NULL, 'देवी', 'Husband', 'Madan Lal Sah', 'Widow', 'Female', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, NULL, NULL, 'yes', 1, 'false', 6, 0, NULL, 1, 'documents/RNC/HRM/Residential/1983/07/Plot/MIG/C-87/UrmilaDevi', '2026-03-20', '117.233.180.137', '127.0.0.1', 4, 2, '2026-03-20 05:34:54', '2026-03-23 04:28:59'),
(5, '1602268136', 5, 1, 1, 1, 3, 4, 'RNCMI1998HRM47681', '$2y$12$LpAK8U4BiFnsRFb5ik9D.u2l9x6PlbuWx1ej2XWzOiCDqniQi/SBq', 'eyJpdiI6ImNqQ0RFeWJsWkZSQzVlQWJBTXZ2THc9PSIsInZhbHVlIjoiQjFISEk0SXYwTjNDYStHamQ1dHdVVFM0RkNVc3JoWVUzWnlyN29MWnNVdz0iLCJtYWMiOiI1ODdlMTU2MzRkM2E5NzZjZmIwZGZkNzU1Yzc1MGE5ZjVlYzgxMDI1YTFlY2Y5OTMxMmQ3ZDIxNTQ0ZmQ3MTFiIiwidGFnIjoiIn0=', NULL, '115652', 29, '10', '1976', '3910/2000', 14, '10', '1998', 'C-86', 'Shri', 'Indu Bhushan', 'Prasad', 'Thakur', 'श्री', 'इंदु भूषण', 'प्रसाद', 'ठाकुर', 'Father', 'Late Sukhdeo Thakur', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '36', '36', 'Thirty Six Years', 'छत्तीस साल', NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":112}]', 112, 'no', NULL, 'false', 6, 1, 'Step 1 : -Registry Deed Not Found\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1998/10/Plot/MIG/C-86/Indu BhushanPrasadThakur', '2026-03-20', '117.233.180.137', NULL, NULL, 4, '2026-03-20 06:17:26', '2026-03-20 06:36:02'),
(6, '1602268136', 4, 1, 1, 1, 3, 4, 'RNCMI1978HRM06842', '$2y$12$AGjxe3LNfut3GyU4oyUeZ.Heo38SFvv1xsu87K0XSAc73q4T7ppQi', 'eyJpdiI6ImNvdk0xSU95NGFZanRZZVl3VFd4Wnc9PSIsInZhbHVlIjoielVPWjkzbitOY0NmOExnaEhwU1JZUmRQUWNlRVZCWE1KY3YwajFvUG43cz0iLCJtYWMiOiIxODYxMDNkYTZmNGQ3NmI4ZTc4ODEyOGIwZTkzNmJkZGMxNjhlY2JjNjNkYWJkYmEyYmM3ZDAyZjdiMmI3NmM1IiwidGFnIjoiIn0=', NULL, '127539', 1, '05', '1975', '1730/1978', 17, '07', '1978', 'C-44', 'Shri', 'Madhusudan', NULL, 'Sharma', 'श्री', 'मधुसुधन', NULL, 'शर्मा', 'Father', 'late Deoki Nandan Sharma', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":45}]', 45, 'yes', NULL, 'false', 6, 1, 'Step 1 : -Application form not found\nStep 2 : -NOC Letter not found\nStep 3 : -Registry deed not found\nStep 4 : -property map not found\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-44/MadhusudanSharma', '2026-03-20', '117.233.180.137', '117.233.180.137', 2, 2, '2026-03-20 06:19:19', '2026-03-20 07:07:34'),
(7, '1602268136', 2, 1, 1, 1, 3, 4, 'RNCMI1978HRM87214', '$2y$12$hRi6PiUW5VGbMVJZ6GVlYuSI9rG3FDKX8YGM7sBK1BHO6Je.P0.ee', 'eyJpdiI6Ilk4YUs3am90VUo4dUxoWkx5ZXozeXc9PSIsInZhbHVlIjoicXNFbGJJTkNlN3JzaEwvNnJvLzhmZW9hSmlIc0hPMlkyWWZlZy9WSVk1az0iLCJtYWMiOiI1NWZmY2ZlYmJhN2IwZDBjYzYxN2U1ZTUyYjg5OWZjNjk1Yzc0NWVkNjgzZWU1NWE2MGJjM2JlODg3NmNmMWY5IiwidGFnIjoiIn0=', NULL, '119374', 4, '04', '1975', '1635/78', 12, '07', '1978', 'C-67', 'Smt.', 'Sabita', NULL, 'Sen', 'श्री', 'सविता', NULL, 'सेन', 'Husband', 'Dr Santosh Kumar Sen', 'Married', 'Female', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, '[{\"file_name\":\"File-1\",\"pages\":20},{\"file_name\":\"File-2\",\"pages\":27},{\"file_name\":\"File-3\",\"pages\":157}]', 204, 'yes', NULL, 'false', 6, 1, 'Step 1 : -Application Form Not found\nStep 2 : -Final Calculation Documents Not Found\nStep 3 : -Registry Deed Not Found\nStep 4 : -\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-67/SabitaSen', '2026-03-20', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 06:42:11', '2026-03-20 08:18:43'),
(8, '1602268136', NULL, 1, 1, 1, 3, 4, 'RNCMI2010HRM24013', '$2y$12$30wLT1xQ/ZX2NHBsTu5W2OQAtnwImJ7J.lePpu6orsTiRMlAU4DV6', 'eyJpdiI6IlR4T0ZZaVpPZUFWd2YwTHpyb0VrbHc9PSIsInZhbHVlIjoicDhZL1hBajQxYXkwY1JBb1QvNk1rdDAyMVdsNlJEd1plQXlpeXdDRlh0cz0iLCJtYWMiOiJlYjFmZDJiMzBlMDdmOTkxMjQ5ZTgxZDQ1MWZhMDQxYjFkYjgxNGJjNjE3ZDZmY2IzOWE2Y2U1ODViOGZkY2NmIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 27, '01', '2010', 'C-44', 'Smt.', 'Sukumari', NULL, 'Sharma', 'श्री', 'शुकुमारी', NULL, 'शर्मा', 'Husband', 'Late Madhusudan Sharma', 'Widow', 'Female', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, NULL, NULL, 'no', 6, 'false', 6, 0, NULL, 0, 'documents/RNC/HRM/Residential/2010/01/Plot/MIG/C-44/SukumariSharma', '2026-03-20', '117.233.180.137', NULL, NULL, 2, '2026-03-20 07:07:34', '2026-03-20 07:23:02'),
(9, '1602268136', 3, 1, 1, 1, 3, 4, 'RNCMI1991HRM32459', '$2y$12$wXqXzJtwflSokN.rzy0U7.b7sG4VTCL7CM441pKlnmBA4Six1L5N6', 'eyJpdiI6Ikt1VzBiMGhMTS9WVDBJOTg4SExpYlE9PSIsInZhbHVlIjoiYU9vdzl0QjlVaUdlK0NzRXJBWUV2ZldwZ09NUDhmMFJrY3hvY21KaDJNND0iLCJtYWMiOiI0NmVhOTQ2YTZmY2Q3YTc3NmYyYTM2ZGY4ZDk0Y2EyNTQ0MTMzMTc3MWNlMmJkMTg2NTc1ZWRjZjQyMGVkOTIxIiwidGFnIjoiIn0=', NULL, '128880', 28, '02', '1977', '2406/', 17, '09', '1991', 'C-35', 'Shri', 'Bhrigu', 'Prasad', 'Singh', 'श्री', 'भृगु', 'प्रसाद', 'सिंह', 'Father', 'late Stya narain singh', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '38', NULL, 'Thirty Eight Years', NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":53}]', 53, 'no', NULL, 'false', 6, 1, 'Step 1 : -Agreement letter not found\nStep 2 : -final calculation not found\nStep 3 : -Registry deed not found\nStep 4 : -property map not found\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh', '2026-03-20', '117.233.180.137', NULL, NULL, 2, '2026-03-20 08:13:15', '2026-03-20 08:54:37'),
(10, '1602268136', NULL, 1, 1, 1, 3, 4, 'RNCMI2004HRM38096', '$2y$12$LvRzE06WjDQYmMBGQ1LzBextoQLD1GEypdi.yBEH861T6S5HoPJUi', 'eyJpdiI6InZ0L01ENms3cTBGWTR6b25hNDl5NFE9PSIsInZhbHVlIjoiVGd6R2k1ZGJJMVNJMlpTY1R6RHNPZndxbkVMb1NyUWFLeUwwTlN6cGR5bz0iLCJtYWMiOiI5M2U3ODI1YTIwMjc0ZDliNGFhNTNiNWJlOGE5NmM4ODE0MjE1OTczNDRlYjZjNTY2ZWQ0NmU1NTYyZTBmM2EzIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 11, '11', '2004', 'C-67', 'Shri', 'Ajay', NULL, 'Kumar', 'श्री', 'अजय', NULL, 'कुमार', 'Father', 'Shri Dukhit Mahto', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, NULL, NULL, 'no', 7, 'false', 6, 0, NULL, 0, 'documents/RNC/HRM/Residential/2004/11/Plot/MIG/C-67/AjayKumar', '2026-03-20', '117.233.180.137', NULL, NULL, 4, '2026-03-20 08:18:43', '2026-03-20 08:34:13'),
(11, '1602268136', 12, 1, 1, 1, 3, 4, 'RNCMI1981HRM15937', '$2y$12$zS8zVM/GfpEavhG3qNutieo2lJ4g3nLg0Rcx70b.9FHtX0PJH3aKS', 'eyJpdiI6IlMrb2FzSnhNZ2JDeW9yVlhDVkFpU1E9PSIsInZhbHVlIjoibFVoZjRIVXRTOTJsQVZ5bUpvL1c2UVZtVi9QTmJiaW44SzAvWUN1S2NPQT0iLCJtYWMiOiIwMTMzMmQ5NjU5ZjNmNGJlZjVlMTlmOGU1YTZhZmU4NTg5MGJkYmRhM2YxNDE2NzUzMDE1YWZhYzdiODU0YzA3IiwidGFnIjoiIn0=', NULL, '110576', 25, '08', '1977', '2282/81', 18, '08', '1981', 'C-52', 'Shri.', 'Subhash', 'Chandra', 'Bhandula', 'श्री', 'सुभाष', 'चन्द्र', 'भन्दुला', 'Wife', 'Smt Prem Bhandula', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, '[{\"file_name\":\"File-1\",\"pages\":18},{\"file_name\":\"File-2\",\"pages\":175}]', 193, 'no', NULL, 'false', 2, 0, NULL, 0, NULL, '2026-03-20', '117.233.180.137', NULL, NULL, 4, '2026-03-20 08:50:03', '2026-03-20 08:50:03'),
(12, '1602268136', 10, 1, 1, 1, 3, 4, 'RNCMI1981HRM39215', '$2y$12$IXTe3sN7v38DZabXLJuX6uErloVNr0eHh56gf.jK9WUhWW4aXRQVi', 'eyJpdiI6IjBHa0cweG9PQnhKWlBpMURZbDRqSWc9PSIsInZhbHVlIjoiMXBkV3J0am1rd0VyVFFrZVpBV1B0aks2ZVlUMFNwTWY3Z3MzbSs2NHFEOD0iLCJtYWMiOiJhMTIxNmJjY2YwOWYxZDhhMzljYjllODE3ZWI1MjUwODEyNzNiOGNiY2NiOWZiMjM5ZmZmYWM1MGE5MDE4YjhkIiwidGFnIjoiIn0=', NULL, '115410', 2, '12', '1978', '8877/81', 2, '12', '1981', 'C-127', 'Shri.', 'Daya', 'Nand', 'Prasad', 'श्री', 'दया', 'नन्द', 'प्रसाद', 'Father', 'Late Rameshwar Lal', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":124}]', 124, 'yes', NULL, 'false', 6, 1, 'Step 1 : -Application Form Not Found\nStep 2 : -NOC Before Registry Not Found\nStep 3 : -Registry Deed Before Name Transfer Not Found\nStep 4 : -\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayaNandPrasad', '2026-03-20', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 08:58:50', '2026-03-20 09:14:20'),
(13, '1602268136', 1, 1, 1, 1, 3, 4, 'RNCMI1980HRM15048', '$2y$12$ijDfqRXDWphVfRYLMq28KO39nUbnWFeZEae0htp5GJqxF3zb29EZe', 'eyJpdiI6ImZTdGxNbElPVDQyL3BRSEtoOGtVWGc9PSIsInZhbHVlIjoiWnpMRmYvMDBWN0gzSVo0R2NJQVlLOXpiRnRaVVhBall2WFdyejZRWDI5TT0iLCJtYWMiOiJhOGNiM2RhMjIwMDk1MmEzNTcyMDMzYzM2OTY1NzQ4YmQxZWVlYzJiOTBiNDU5MWUxNjBhYWQzYzk1ODdlNzA2IiwidGFnIjoiIn0=', NULL, '12682', 26, '04', '1980', '2681/1980', 26, '04', '1980', 'C-102', 'Shri', 'Braj', 'Kishore', 'Prasad', 'श्री', 'ब्रज', 'किशोर', 'प्रसाद', 'Father', 'Nand Kishore Lal', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":46}]', 46, 'no', NULL, 'false', 6, 1, 'Step 1 : -Application form not found\nStep 2 : -Registry deed not found\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-102/BrajKishorePrasad', '2026-03-20', '117.233.180.137', NULL, NULL, 2, '2026-03-20 09:09:02', '2026-03-20 09:41:50'),
(14, '1602268136', NULL, 1, 1, 1, 3, 4, 'RNCMI2004HRM68397', '$2y$12$LcoUYD5SyW2o5.zzlZ/BE.t9MEdZG2HjRzOJmiDvIsXhVZ8Ux9Xc6', 'eyJpdiI6IjlKZzc0SHVIWmE1SU10ZTB2RlRVa1E9PSIsInZhbHVlIjoiZWFheFh1MVR1Zm9SdE1jYWdocEs0YXBZTzBFdGJxS3M1ZE51SlFkZThlWT0iLCJtYWMiOiJhMzZjM2FjNTk3N2E5ZGMwY2U5YTc4Yzg2OWM5ZTMzMGI0ODIxYzI1MTMwOWY4ZDlkNDNkZjUyYmZiYTI5NDgzIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 9, '09', '2004', 'C-127', 'Smt.', 'Sangeeta', NULL, 'Bala', 'श्री', 'संगीता', NULL, 'बाला', 'Father', 'Late Niranjan Prasad', 'Unmarried', 'Female', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', 12, 'false', 6, 0, NULL, 0, 'documents/RNC/HRM/Residential/2004/09/Plot/MIG/C-127/SangeetaBala', '2026-03-20', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 09:14:20', '2026-03-20 09:24:54'),
(15, '1602268136', 7, 1, 1, 1, 3, 4, 'RNCMI1980HRM76843', '$2y$12$D47onzEH19BaE0eBBoBzl.2emjl.qTHws.jG9PBny9cvfX6n6C7my', 'eyJpdiI6IjB6M3RGVVRSbVBQbmVBQXZOUG9SZlE9PSIsInZhbHVlIjoiY1Z3eWYyQ2NRbW9BcDJuZTVuaEdWUEppaTUzZ244RGVOWHFsb3FtOW8xMD0iLCJtYWMiOiI5MzE4NDk4ZWZkYzlmZmVjMGI3ZDM4ZGY3NzdmNGY4ZjNmNzAxMThmOGFlOWQ4NDJmOTM4NGJmNjMwODJiMmE5IiwidGFnIjoiIn0=', NULL, '169671', 26, '05', '1978', '4413/80', 26, '05', '1980', 'C-115', 'Shri', 'Ramesh', 'Chandra', 'Shrivatava', 'श्री', 'रमेश', 'चन्द्र', 'श्रीवास्तव', 'Father', 'Late Sri Adya Prasad Varma', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":75}]', 75, 'no', NULL, 'false', 3, 0, NULL, 0, NULL, '2026-03-20', '117.233.180.137', NULL, NULL, 4, '2026-03-20 09:34:54', '2026-03-20 09:38:33'),
(16, '1802263052', 25, 1, 1, 1, 3, 4, 'RNCMI1989HRM50436', '$2y$12$5t6qWoQTrtT2j8B4I9ZRpOiEZl09V4KNGO3Z.2gPWelEBOgBdqOL6', 'eyJpdiI6InV0WUg0Q25SMDJkVmFSZlVmd2h3M2c9PSIsInZhbHVlIjoid2ZYVVJJRGVFWUdpSDNIY3lEbDFqaUxwc01vbnJGWnJOV2JjWEJrUUEycz0iLCJtYWMiOiJkMGJjN2FjNTg3MDYzNDc1Y2M3ZDBjYzVmMmI1YjJhMTkwMjIyMjA2ZjViZDczYWM3Y2QwYTM0Yjc1YTlmODRhIiwidGFnIjoiIn0=', NULL, '126852', 10, '06', '1975', '6656/1981', 28, '08', '1981', 'C-9', 'Shri', 'Triloki', 'Nath', 'Jaiswal', 'श्री', 'त्रिलोकी', 'नाथ', 'जायसवाल', 'Father', 'Jagdeo Narain', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '41', NULL, 'Forty One Years', NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":86}]', 86, 'yes', NULL, 'false', 6, 1, 'Step 1 : -Registry Deed not found\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1981/08/Plot/MIG/C-9/TrilokiNathJaiswal', '2026-03-20', '117.233.180.137', '117.233.180.137', 2, 2, '2026-03-20 10:44:21', '2026-03-20 11:37:47'),
(17, '1802263052', 35, 1, 1, 1, 3, 4, 'RNCMI1982HRM17463', '$2y$12$dMN9TtYwG2ZsN89jWHZJG.Wuu4CKmikgBf8d6bDOt3Nd7Mr5WyYs.', 'eyJpdiI6ImwxNldhUE5pUWY2YWlQT2xvWm1nWHc9PSIsInZhbHVlIjoiclM2U2Uzd1hjSE4xVWJmZm1TbXpTRW5XOHppUHFWRjVNRXRkQ1lXT1JqZz0iLCJtYWMiOiJlN2YyNTkyZDMwNGMzYzdjN2U4MDM5MDVhNTdhODNiNTM0ZDE2MjRiMzEyYzUzMDBjYmI0ZmQzNmY2ZGJmMWQ2IiwidGFnIjoiIn0=', NULL, '126882', 9, '06', '1975', '4166/82', 28, '08', '1982', 'C-8', 'Shri.', 'Kamala', 'Nand', 'Pradhan', 'श्री', 'कमला', 'नंद', 'प्रधान', 'Father', 'Late Ganesh Pradhan', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":124}]', 124, 'yes', NULL, 'false', 6, 1, 'Step 1 : -Application Form Not Found\nStep 2 : -NOC Before Registry Not Found\nStep 3 : -\nStep 4 : -\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1982/08/Plot/MIG/C-8/KamalaNandPradhan', '2026-03-20', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 10:49:54', '2026-03-20 11:04:51'),
(18, '1802263052', NULL, 1, 1, 1, 3, 4, 'RNCMI2004HRM69723', '$2y$12$SbK4U6swZOfW9H/nddGzW.Q15lcnHnGmDDATt0fCsIdwSaTE/oOOq', 'eyJpdiI6IjlGL2orT3lGY3EvaWpQYkhkRG13ZXc9PSIsInZhbHVlIjoia1hmMThFUmwyanRQM0pvYzRRTjVmN0x3NWFNNUYvT253ZEZ0a2p3emFXST0iLCJtYWMiOiI2YTJiNGJiYzc1MGNhZTBjNDU3NDc0ZmQwNTdlZTE5M2EzMGI2MGM5MDcyNDA3MzY1NzY3ZjcyY2ZiNDdmYzYzIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 11, '08', '2004', 'C-8', 'Shri', 'Umesh', NULL, 'Pradhan', 'श्री', 'उमेश', NULL, 'प्रधान', 'Father', 'Late Kamala Nand Pradhan', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, NULL, NULL, 'yes', 17, 'false', 6, 0, NULL, 1, 'documents/RNC/HRM/Residential/2004/08/Plot/MIG/C-8/UmeshPradhan', '2026-03-20', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 11:04:51', '2026-03-20 11:28:28'),
(19, '1802263052', NULL, 1, 1, 1, 3, 4, 'RNCMI2005HRM82341', '$2y$12$Tnqe62UOyH37rgY1qfKH8O7R8cLpqbnW.VXZWQfOkNaXAEtjEyMfC', 'eyJpdiI6Imp2ZU1YaGdpTHhjd2p2UjJrZ3Q5dFE9PSIsInZhbHVlIjoieDhOMEZwSm1wMDJ2QlFhNDJsQ3RDNUlwakpqQVExb2s3S00zVVlLTFBGVT0iLCJtYWMiOiIyOTE4ZmIxMjU3NTdiOTQwODYwZjE3MjM0ZjIwNTY5M2NkZmQ0ZGIzMmQyMjI5MGRkNTFkZjA4NzZlMDQyMmMwIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 25, '02', '2005', 'C-8', 'Smt.', 'Maya', NULL, 'Sinha', 'श्रीमती', 'माया', NULL, 'सिन्हा', 'Husband', 'Sri Arum Kumar', 'Married', 'Female', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, NULL, NULL, 'no', 18, 'false', 6, 0, NULL, 0, 'documents/RNC/HRM/Residential/2005/02/Plot/MIG/C-8/MayaSinha', '2026-03-20', '117.233.180.137', NULL, NULL, 4, '2026-03-20 11:28:28', '2026-03-20 11:37:33'),
(20, '1802263052', NULL, 1, 1, 1, 3, 4, 'RNCMI2001HRM37984', '$2y$12$chCyQJuVh83BXDVYs8QY7uHcsoCkG4.4bEP3Sgd3bwiulDq6bdLwu', 'eyJpdiI6ImtHbmdIS1lNR2MxSFdSdGxEU1MyZ2c9PSIsInZhbHVlIjoia2ovUDgrdlNMMkJPR1JIOFVaeXBMT3E5YWR2enlyWm1xaU9BOHkxMUdvcz0iLCJtYWMiOiJlNjJiZDllZmRlMDg0MmVlYjFjNzkyN2NkZjc1MjZkM2RmODk4ZmQxMTJmYTRhNjc1NTczYWYzMjcxMWIzNmEyIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 26, '06', '2001', 'C-9', 'Shri', 'Parvinder', 'Jit', 'Singh', 'श्री', 'परविंदर', 'जीत', 'सिंह', 'Father', 'Late Satwant Singh', 'Unmarried', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', 16, 'false', 6, 0, NULL, 0, 'documents/RNC/HRM/Residential/2001/06/Plot/MIG/C-9/ParvinderJitSingh', '2026-03-20', '117.233.180.137', NULL, NULL, 2, '2026-03-20 11:37:47', '2026-03-20 11:47:44'),
(21, '1802263052', 32, 1, 1, 1, 3, 4, 'RNCMI1979HRM32097', '$2y$12$FV9T/tGN8ysbs7cq0Cni0eeYKGC.Moj9KIILgDI8B9FOBWBF.I/VO', 'eyJpdiI6IjgvWUM4WFZFYWhESFZUMGdoS3FHc2c9PSIsInZhbHVlIjoiWkZXdzM5NE84N05NajRRTkdncWxqdmpnUXNyKy96TmlLUUlQbjlXSk9Naz0iLCJtYWMiOiJmN2RkMTY1YmUzMjZiMmVjNzhlZDBlMjZjNTY3YTI5ZTgwZGRkN2ViMGM0NzhlOTRhNmU0NzI3YTVkZDQxNDFiIiwidGFnIjoiIn0=', NULL, '125695', 8, '05', '1975', '734/79', 27, '03', '1979', 'C-97', 'Shri', 'Awadhesh', 'Kumar', 'Roy', 'श्री', 'अवधेश', 'कुमार', 'राय', 'Father', 'Sri Padarath Roy', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '36', '36', 'Thirty Six Years', 'छत्तीस साल', NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":140}]', 140, 'yes', NULL, 'false', 6, 1, 'Step 1 : -\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1979/03/Plot/MIG/C-97/AwadheshKumarRoy', '2026-03-20', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 11:42:07', '2026-03-20 12:01:28'),
(22, '1802263052', 28, 1, 1, 1, 3, 4, 'RNCMI1981HRM96135', '$2y$12$F5n8OgXuPVBJDhxDtIleZ.GNTC4lxBo0HTSTkaMWo1XQTXMp1C/wG', 'eyJpdiI6Im1IcnIrbkRJSFR0UHZZT1pxSWFQTWc9PSIsInZhbHVlIjoiOHFTSGR0S0Rvd1NCNm5Rd28wYWc4YXNSZTc1RlRGaTJ4S1ptTFBoRmI0ND0iLCJtYWMiOiIyN2U0YmVlOWRmOWM2Y2MxZDJmODE1ZWIzOTYzODE1ZWQxMGU2NWI5MTM2MzNhYTA4Y2ZhMDkyNmRjYzFmYmRmIiwidGFnIjoiIn0=', NULL, '115690', 14, '08', '1977', '8878/1981', 2, '12', '1981', 'C-126', 'Shri', 'Nageshwar', NULL, 'Mahto', 'श्री', 'नागेश्वर', NULL, 'महतो', 'Father', 'Shri Kewal Mahto', 'Married', 'Male', NULL, NULL, 'OBC', 'Hindu', 'Indian', '35', NULL, 'Thirty Five Years', NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":49}]', 49, 'no', NULL, 'false', 6, 1, 'Step 1 : -Final calculation not found\nStep 2 : -NOC before registry not found\nStep 3 : -Registry Deed not found\nStep 4 : -Property map map found\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto', '2026-03-20', '117.233.180.137', NULL, NULL, 2, '2026-03-20 11:53:50', '2026-03-20 12:19:40'),
(23, '1802263052', NULL, 1, 1, 1, 3, 4, 'RNCMI1996HRM74639', '$2y$12$x68ryJ.t1JOHEB0zRHQ3LONk62hSkhT6GPv58mLbKatusCMv3R0IC', 'eyJpdiI6Ijk0U2dKRmw0WGVWNEZDVWtiUjVSMUE9PSIsInZhbHVlIjoiL1hMSGk0QkhzR2RnVU5pd3VHdE9zK0hmaUdWdk50OVZGVEYvbGQzMXlBRT0iLCJtYWMiOiI0ZjhjYTA0NTE1MWI3ZTE2NTE1NDVmOWFmZmE1OWYxZmIzM2U3YTNlNTQ5MDhiMTJkMjZhMTY4MjFkNjMzZjVjIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 15, '07', '1996', 'C-97', 'Shri', 'Anil', 'Kumar', 'Sinha', 'श्री', 'अनिल', 'कुमार', 'सिन्हा', 'Father', 'Late Hare Krishna Prasad', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, NULL, NULL, 'no', 21, 'false', 6, 0, NULL, 0, 'documents/RNC/HRM/Residential/1996/07/Plot/MIG/C-97/AnilKumarSinha', '2026-03-20', '117.233.180.137', NULL, NULL, 4, '2026-03-20 12:01:28', '2026-03-20 12:11:36'),
(24, '1802263052', 34, 1, 1, 1, 3, 4, 'RNCMI1996HRM09836', '$2y$12$mqZhG0OyE46yF/q7Pa/7nOU2VEUZan9Dk05L.IgyTBNfweNp.ofCy', 'eyJpdiI6Ik94RDRCSTlrUFdDTFpjbk9OTzZObmc9PSIsInZhbHVlIjoiWFJIZ1pDbnVOVGYycFVhVzF1b3kwaFl3ZnV4c0NPb0poclJMb0FYZEQ0TT0iLCJtYWMiOiJkODY0YTdlMjIxNmNhMTY3YjA3NzhjYTY5ZGY1OGMxMDg0YzU0NGFjZjYzNDFlODBkOWM5OWE4ZTBlYTU3YWU5IiwidGFnIjoiIn0=', NULL, '126327', 5, '11', '1976', '4454/1987', 10, '06', '1996', 'C-91', 'Shri', 'Bhagwati', 'Prasad', 'Sharma', 'श्री', 'भगवती', 'प्रसाद', 'शर्मा', 'Father', 'Kumbha Ramji Sharma', 'Unmarried', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":99}]', 99, 'no', NULL, 'false', 6, 1, 'Step 1 : -Final calculation document not found\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1996/06/Plot/MIG/C-91/BhagwatiPrasadSharma', '2026-03-20', '117.233.180.137', NULL, NULL, 4, '2026-03-20 12:10:17', '2026-03-20 13:03:46'),
(25, '1802263052', 26, 1, 1, 1, 3, 4, 'RNCMI1978HRM53402', '$2y$12$miLy1tzEftsx4S17Tcl7kOvuVoQV5lzvMb.xuc0zWaLEMXDEF.xoK', 'eyJpdiI6Ik1ZYmRsbzFIcGhDeGpENGt5VW5GOUE9PSIsInZhbHVlIjoiQy9OUVpaSUhlWUNMdmpjUzdPcHpER0VJZUtpWmFla2ErZVQ4MzRSL0V3Zz0iLCJtYWMiOiI5NWI3YjU1YWEzYjk0ZTAxMjU0NjEyZjkxMTRkZmRiNmYzMmRhYjM3MzBiNmE5NmRmNDkzYzE0NGI3NWFlNmNmIiwidGFnIjoiIn0=', NULL, '110553', 13, '08', '1977', '1013/78', 6, '03', '1978', 'C-3', 'Shri', 'Chandra', 'Shekhar', 'Sinha', 'श्री', 'चन्द्र', 'शेखर', 'सिन्हा', 'Father', 'Shri Ramanand Singh', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '28', '28', 'Twenty Eight Years', 'अट्ठाईस साल', NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":96}]', 96, 'no', NULL, 'false', 6, 1, 'Step 1 : -Registry Deed Not Found\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1978/03/Plot/MIG/C-3/ChandraShekharSinha', '2026-03-20', '117.233.180.137', NULL, NULL, 4, '2026-03-20 12:15:29', '2026-03-20 12:25:41'),
(26, '1802263052', 29, 1, 1, 1, 3, 4, 'RNCMI1978HRM73294', '$2y$12$RVcDhQR/7b/sEuo67f.5fOfRzRbCjDhz/D9NfD0aYCtu2l8cud93m', 'eyJpdiI6Ikxzb25xLzdOaWZWUFhIancxVW1IOGc9PSIsInZhbHVlIjoiS0taK3BkYVVCLzU4TGk2bTZSQnB0UDRncnV0K3hDOGpaOHhneDJKTVhzMD0iLCJtYWMiOiJlODlmNjI2YjcxNjc2YTE4ZDJiMzk2YzY4MTFkZjcwNWFhMzI4MDA4NWZiYjA5MTAzMDFkMWM2NWRlNzRhZmU5IiwidGFnIjoiIn0=', NULL, '127440', 22, '05', '1975', '1714/1978', 15, '07', '1978', 'C-49', 'Shri', 'Ranjit', 'Singh', 'Jayswal', 'श्री', 'रणजीत', 'सिंह', 'जयसवाल', 'Father', 'Late Satya Bhusan Jayaswal', 'Married', 'Male', NULL, NULL, 'OBC', 'Hindu', 'Indian', '37', NULL, 'Thirty Seven Years', NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":108}]', 108, 'no', NULL, 'false', 6, 1, 'Step 1 : -\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-49/RanjitSinghJayswal', '2026-03-20', '117.233.180.137', NULL, NULL, 2, '2026-03-20 12:26:21', '2026-03-20 12:57:00'),
(27, '1802263052', 27, 1, 1, 1, 3, 4, 'RNCMI1980HRM27984', '$2y$12$7e5h7kUMaaS3V6k2fVuH7uzMjTsFdUrWmXDOqVFAHwdXuOr17iyuK', 'eyJpdiI6ImdTL1Nkci9JODJGUW02dzJKeEJWS1E9PSIsInZhbHVlIjoiOEdjMm9Zc1pESUdpQWMwWHNibStTNnlGek92R1RQMTMvWndJUFpYV1ViST0iLCJtYWMiOiI3ZmRkZTE1Zjc3YWJiNDUwM2UzMzdkNmVlOGU5Yjk0Y2Y3YzU5MzgwNTA0NTlmMGU0MDExM2M1MmRhNjJhMTQyIiwidGFnIjoiIn0=', NULL, '127001', 12, '05', '1975', '1477/80', 11, '03', '1980', 'C-29', 'Shri', 'Ram', 'Krit', 'Singh', 'श्री', 'राम', 'कृत', 'सिंह', 'Father', 'Sri Narsingh Singh', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":81}]', 81, 'no', NULL, 'false', 6, 1, 'Step 1 : -Final Calculation Documents Not Found\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1980/03/Plot/MIG/C-29/RamKritSingh', '2026-03-20', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 12:28:31', '2026-03-20 12:41:34'),
(28, '1802263052', 33, 1, 1, 1, 3, 4, 'RNCMI1983HRM54692', '$2y$12$I58xOXR/YcpezWuI1eWTbeOD83NMQz6tXPpjmOIJ1k0tAaFX.iOdq', 'eyJpdiI6IlZqMFRvRks0MUdzdzhsT2hMamdvZnc9PSIsInZhbHVlIjoiZTIzYlFvQlU1K29WU0VHRUQ2Ny9LcWNxVjZqN2ZNckdSQ1JnSUNSeit1MD0iLCJtYWMiOiI5MGM0YzQ4MTE4ZjlmMzYyOGJiMDNmMGQ4ZWIxNTA4MzY2ZjIwNTEyZmYxMzkwMjBmZjA5MjFkOTdiOTZlNzk4IiwidGFnIjoiIn0=', NULL, '119354', 30, '09', '1977', '2158/83', 6, '06', '1983', 'C-32', 'Shri', 'Nawal', 'Kishore', 'Prasad', 'श्री', 'नवल', 'किशोर', 'प्रसाद', 'Father', 'Shri Bachhu Prasad Singh', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":56}]', 56, 'no', NULL, 'false', 6, 1, 'Step 1 : -Final Calculation Documents Not Found\nStep 2 : -Registry Deed Not Found\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1983/06/Plot/MIG/C-32/NawalKishorePrasad', '2026-03-21', '117.233.189.51', NULL, NULL, 4, '2026-03-21 05:05:06', '2026-03-21 05:37:50'),
(29, '1802263052', 31, 1, 1, 1, 3, 4, 'RNCMI1979HRM06291', '$2y$12$bhkBKacOZCPjUx.7ofdaM.isYeeTicDR5g8OVFatDnVgk/hQSjvBi', 'eyJpdiI6IkcyVkJoRHN6ZytKSEUxWlpkcFMwQWc9PSIsInZhbHVlIjoiRzJXSFJiVGh1c1dTZDhZbWZWemhDOHRsRVgrMGtNcEN6dlkvcERnRmVZZz0iLCJtYWMiOiIxMWZmMmUzYWRiZTJkNTM4NjY1YjRkMDBhODIzNWYzYjhkMWJlYTY3MTY1ZmNhMmI3N2Q1YTc5YzFmODYxMDNkIiwidGFnIjoiIn0=', NULL, '228572', 30, '09', '1976', '1772/1979', 31, '08', '1979', 'C-100', 'Shri', 'Amar', 'Nath', 'Jha', 'श्री', 'अमर', 'नाथ', 'झा', 'Father', 'Sri Radha Krishna Jha', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '35', NULL, 'Thirty Five Years', NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":139}]', 139, 'no', NULL, 'false', 6, 1, 'Step 1 : -Final calculation not found\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1979/08/Plot/MIG/C-100/AmarNathJha', '2026-03-21', '117.233.189.51', NULL, NULL, 2, '2026-03-21 05:38:10', '2026-03-21 06:11:59'),
(30, '1802263052', 30, 1, 1, 1, 3, 4, 'RNCMI1981HRM81207', '$2y$12$IJmydpk0ey3Sx7Ez8DJFZ.xTThDKilCbw209Y4ecQTtXLHKdWYTCy', 'eyJpdiI6IlVncG1xWVZoWFRNREE1QTdobVU3Qnc9PSIsInZhbHVlIjoiNWpRc3ZyTk1WU0YzY2ZhNlJNMGNma3JhRzNwV3JiK1hRdWtuUjlVNkwvMD0iLCJtYWMiOiIxNjQxMjMwOTRmZGNmMDk4NmQ2ODI2MDM2MjFmMGQ4YjA0OGViMzZmZDJkMWU1YTZhNWQ2NGU0YzBlYmMyMTJiIiwidGFnIjoiIn0=', NULL, '110568', 30, '08', '1977', '8855/81', 2, '12', '1981', 'C-131', 'Shri', 'Birendra', 'Kumar', 'Khanna', 'श्री', 'वीरेन्द्र', 'कुमार', 'खन्ना', 'Father', 'Late Dhiraj Kumar Khanna', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":98}]', 98, 'yes', NULL, 'false', 6, 1, 'Step 1 : -Application Form Not Found\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-131/BirendraKumarKhanna', '2026-03-21', '117.233.189.51', '117.233.189.51', 2, 4, '2026-03-21 05:40:41', '2026-03-21 06:17:57'),
(31, '1802263052', NULL, 1, 1, 1, 3, 4, 'RNCMI1999HRM46280', '$2y$12$MAbPkvhi9ddnu9zVwnUZb...jkxhiJoM5GZ6FVXEUGMaePLKi9VBG', 'eyJpdiI6IkpPUVRzb1R3dDJQeExUL00zTjcvU3c9PSIsInZhbHVlIjoiQ2tQUkJUNTVDR01IQ2pCWmpIQUEvWFhITW5vYXd4ZlVMWGQ3UUg0bGl0cz0iLCJtYWMiOiIwNTYzMTMzNDcyZmI0Mzk5YTMwNWUwNWMwMmIzNzE5YjQ3NmFlYzUzMDlkMDdmMmU4NWUwYmZkMTI2ODRmOGQ1IiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 4, '10', '1999', 'C-131', 'Smt.', 'Sheela', NULL, 'Jha', 'श्रीमती', 'शीला', NULL, 'झा', 'Husband', 'Prakash Chandra Jha', 'Married', 'Female', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, NULL, NULL, 'no', 30, 'false', 6, 0, NULL, 0, 'documents/RNC/HRM/Residential/1999/10/Plot/MIG/C-131/SheelaJha', '2026-03-21', '117.233.189.51', NULL, NULL, 2, '2026-03-21 06:17:57', '2026-03-21 06:24:20'),
(32, '1802264319', 45, 1, 1, 1, 3, 4, 'RNCMI1978HRM37024', '$2y$12$bdN1AxDJox04BPsTk36DbuCHFdYW3Aa1JDYeTj/k3LhFk6NX8SnFW', 'eyJpdiI6ImlGbmg5ZGhlOC85M1Z4eUEvOEVYNnc9PSIsInZhbHVlIjoiV25kRWRXUmJGVUhFSGV6WW1UTk12ajVsUlp2dGNtNEJ6a2VOYk5zdjk1Yz0iLCJtYWMiOiIwMWJkZTRjYjdlNzhlMGE4MjA1M2IxMDMwYzdkOTIwODJkN2ZkNjIxOGFlYmEyZTBkZTBiMDkxNWUyMmY2MTcwIiwidGFnIjoiIn0=', NULL, '127559', 21, '05', '1975', '2551/78', 11, '08', '1978', 'C-94', 'Shri', 'Ram Chandra', 'Prasad', 'Gupta', 'श्री', 'राम चन्द्र', 'प्रसाद', 'गुप्ता', 'Father', 'Shri Dashrath Sahu', 'Married', 'Male', NULL, NULL, 'Other Backward Class (OBC)', 'Hindu', 'Indian', '45', '45', 'Forty Five Years', 'पैंतालीस साल', NULL, NULL, NULL, 'NO AVAILABLE', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":96}]', 96, 'no', NULL, 'false', 6, 1, 'Step 1 : -\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1978/08/Plot/MIG/C-94/Ram ChandraPrasadGupta', '2026-03-21', '117.233.189.51', '127.0.0.1', 4, 4, '2026-03-21 06:36:29', '2026-03-23 09:56:25'),
(33, '1802264319', 44, 1, 1, 1, 3, 4, 'RNCMI1982HRM78360', '$2y$12$Nsi.KZapso.pJyxbWjdHhOh4faQD3ngHjB7fmtoEtee8gKPgOkpH2', 'eyJpdiI6IkV1dGxtckhwMWxlNGJ4aFl5c3NZYWc9PSIsInZhbHVlIjoiYmh3QUF4U0VoM1Ewd21uWmtCemhTaXQ0Z0REMXU3Y2M2aTN4Z0w5ZGV4az0iLCJtYWMiOiI5YjlhZTUxZTE2ZjA4ZjJjNzc3YWZlY2NhOGY0NjdlNTE3NjJjOGRkZWM5M2MyNDM1MjdjODA3NGViODliNmIzIiwidGFnIjoiIn0=', NULL, '110564', 25, '08', '1977', '313/1982', 15, '09', '1982', 'C-84', 'Shri', 'Bijoy', 'Nandan', 'Sahay', 'श्री', 'विजय', 'नन्दन', 'सहाय', 'Father', 'Late Srreenata Sahay', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":111}]', 111, 'yes', NULL, 'false', 6, 1, 'Step 1 : -\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 1, 'documents/RNC/HRM/Residential/1982/09/Plot/MIG/C-84/BijoyNandanSahay', '2026-03-21', '117.233.189.51', '117.233.189.51', 2, 2, '2026-03-21 06:41:23', '2026-03-21 07:34:59'),
(34, '1802264319', 37, 1, 1, 1, 3, 4, 'RNCMI1982HRM27013', '$2y$12$zYaAXynoYWfyyYtvnpTJh.qT81seab9WT4McG/pC0GuIcdnIjY5xu', 'eyJpdiI6InVEdU9YRWtHNytkZWFSdE1uSXdDSUE9PSIsInZhbHVlIjoidjgvcmJGY1hUT2h4dUFKT0lSOFdGbWc3b1VFWUlXaGovNVNON2FVUmpmRT0iLCJtYWMiOiI2YjM1NzE3YjhkNDI3NzA5ZjY1MWVmMDJjZjllOGI5MjM5YmUyYTE0MDBmYjI2MjgyMjU1ZTVmNGZmZWJlZDEwIiwidGFnIjoiIn0=', NULL, '180785', 26, '03', '1980', '672/82', 23, '01', '1982', 'C-116', 'Shri', 'Gajendra', NULL, 'Jha', 'श्री', 'गजेन्द्र', NULL, 'झा', 'Father', 'Shri Yogendra Jha', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '29', '29', 'Twenty Nine Years', 'उनतीस साल', NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":54}]', 54, 'no', NULL, 'false', 6, 1, 'Step 1 : -Final Calculation Document Not Found\nStep 2 : -NOC Not Found\nStep 3 : -Registry Deed Not Found\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1982/01/Plot/MIG/C-116/GajendraJha', '2026-03-21', '117.233.189.51', NULL, NULL, 4, '2026-03-21 07:34:54', '2026-03-21 07:49:30'),
(35, '1802264319', NULL, 1, 1, 1, 3, 4, 'RNCMI2000HRM82517', '$2y$12$AYjOQCr5PdI7XZICTIgLz.jDGlIOENJO2LoojCxMGnzbDG69j0Qhy', 'eyJpdiI6IjlEKzg2RWh1dEdyeVlMRmdzNkhheEE9PSIsInZhbHVlIjoieUd4NFN5YklQRnBLWkRMa0Q4SktrSGJzdDEvTkF4bFdtK3NPL2FmbWNnaz0iLCJtYWMiOiJhMzY0ZWZkYmEzNGVkYzY4NDVjODE3MTVmNTcyMmFmZjFkZjM2ZmRmYmFhM2FiZWEwYjNhMGI0Y2ZiYzg3YWRjIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 28, '10', '2000', 'C-84', 'Shri', 'Ashok', 'Kumar', 'Mangal', 'श्री', 'अशोक', 'कुमार', 'मंगल', 'Father', NULL, 'Married', 'Male', NULL, NULL, 'OBC', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, NULL, NULL, 'no', 33, 'false', 6, 0, NULL, 0, 'documents/RNC/HRM/Residential/2000/10/Plot/MIG/C-84/AshokKumarMangal', '2026-03-21', '117.233.189.51', NULL, NULL, 2, '2026-03-21 07:34:59', '2026-03-21 07:53:40'),
(36, '1802264319', 43, 1, 1, 1, 3, 4, 'RNCMI1980HRM94217', '$2y$12$WQMBrAcwVwk/bYbngRq8KuB5R8934CuzGhlysuXFmnMdGNbTfonPW', 'eyJpdiI6IkhYcitMUTQ1RlZ1L1BNNldVWU5sTmc9PSIsInZhbHVlIjoiYkFQQWVVb042SG5na1ZtbGlRNklzWXFkaHRhcWd6NkdTMmdLZ216QjJaWT0iLCJtYWMiOiI3MDQyYjdjMzc4NDhjMjhjNTkxMGYxYmViZWY0MTg3OGY1YjQ5ZjRmMjRmNTQ1ODBhNmE4ZTJkNzI2NmUyNDI1IiwidGFnIjoiIn0=', NULL, '128583', 11, '09', '1976', '2369/1980', 15, '04', '1980', 'C-79', 'Shri', 'Anil', 'Kumar', 'Srivastava', 'श्री', 'अनिल', 'कुमार', 'श्रीवास्तव', 'Father', 'Late Jagdish Prasad Srivastava', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '36', '36', 'Thirty Six Years', 'छत्तीस साल', NULL, NULL, NULL, 'N/A', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":151}]', 151, 'no', NULL, 'false', 6, 1, 'Step 1 : -\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-79/AnilKumarSrivastava', '2026-03-21', '117.233.189.51', '117.233.189.51', 4, 4, '2026-03-21 08:20:09', '2026-03-21 08:43:22'),
(37, '1802264319', 40, 1, 1, 1, 3, 4, 'RNCMI1991HRM38549', '$2y$12$Rkp99DUQoiVnmPQloH1S3eALEn72EVWRs6QNiDj8o5dbQrqiRM6Si', 'eyJpdiI6IjFaVHFHYU5ucW53SHcxdDlLNnJqcHc9PSIsInZhbHVlIjoiMkF2cTNtdVFoRmRrMWhRM0srajRoRG01d3JmVlhSY0ZpL3BsRWhUNi9Ddz0iLCJtYWMiOiJhMmVlODEzYWFiZDNkY2UzYjk3ZWJjMTk5MTk4NDM5MWQzNjcxNmFlY2E4OWNjOTM0ZjMwYzc1NjI4ZTZiNGQ3IiwidGFnIjoiIn0=', NULL, '128880', 17, '09', '1991', '2406/1991', 17, '09', '1991', 'C-35', 'Shri', 'Bhrigu', 'Prasad', 'Singh', 'श्री', 'भृगु', 'प्रसाद', 'सिंह', 'Father', 'Sri Satyanarain Singh', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":50}]', 50, 'no', NULL, 'false', 6, 1, 'Step 1 : -Application form not found\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh', '2026-03-21', '117.233.189.51', NULL, NULL, 2, '2026-03-21 08:27:46', '2026-03-21 08:46:51'),
(38, '1802264319', 41, 1, 1, 1, 3, 4, 'RNCMI1981HRM52378', '$2y$12$lclGlHT8P91v46b6Mz7FhuW4uMfxyrg7QYLCE0SFWLVld8i9tpTM.', 'eyJpdiI6Ilpvb1hSSkZTb1JnUDFOb1Fka3RkUFE9PSIsInZhbHVlIjoiNVYyWFFmNDYyYnd6TVozdWttZEd3WjVKRWRhTHEzaE1BWVFsdEJnT3RaWT0iLCJtYWMiOiIzMTEwODE3Yzk2OWFhZGMyOGFkNTA2MTgwODQyNzFkMWI0OWI1ODhiZGU5ZjMzMDJkZTczODZmMDYxODRkNmYxIiwidGFnIjoiIn0=', NULL, '115690', 2, '07', '1978', '8878/81', 2, '12', '1981', 'C-126', 'Shri', 'Nageshwar', NULL, 'Mahto', 'श्री', 'नागेश्वर', NULL, 'महतो', 'Father', 'Shri Kewal Mahto', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":47}]', 47, 'no', NULL, 'false', 6, 1, 'Step 1 : -\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto', '2026-03-21', '117.233.189.51', NULL, NULL, 4, '2026-03-21 08:46:44', '2026-03-21 08:57:56'),
(39, '1802264319', 38, 1, 1, 1, 3, 4, 'RNCMI1981HRM68043', '$2y$12$S.wVDAnN4dWeFWgwm76nXezQhqIKqVA.ZjVXr2rV8ekTF/BuurzbG', 'eyJpdiI6IjY3SDZQT2ZqK2FNUy9LZFpKUlBzeXc9PSIsInZhbHVlIjoiTGUyYzI3ZVBGV01rRDBQQS9PcUk4cXB2aUUvQ3R6QnlYcXFHQ1BhY0ZxRT0iLCJtYWMiOiI4MDBlMTJiNmU3NWQzNGNmODAxZDUzYWZjZThkN2IxNjg4ZjA4M2FkNzFjYTEwMGI4NTI2ZDAwMzM0YzY2NThhIiwidGFnIjoiIn0=', NULL, '120134', 14, '05', '1981', '2946/1981', 14, '05', '1981', 'C-96', 'Shri', 'Rama', 'Pati', 'Chakhaiyar', 'श्री', 'राम', 'पति', 'चखैयार', 'Father', 'Late PN Chakhaiyar', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":82}]', 82, 'no', NULL, 'false', 6, 1, 'Step 1 : -Application form not found\nStep 2 : -\nStep 3 : -\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1981/05/Plot/MIG/C-96/RamaPatiChakhaiyar', '2026-03-21', '117.233.189.51', NULL, NULL, 2, '2026-03-21 08:52:54', '2026-03-21 09:22:56'),
(40, '1802264319', 39, 1, 1, 1, 3, 4, 'RNCMI1981HRM93451', '$2y$12$QjGPn8jOJl9ePY0PeX.6HuBAGsI68hVliNg9TvThQe/1WXKH8vdqm', 'eyJpdiI6IkZiYlgweDhyaWNVSU5WZ1RtNUJSRlE9PSIsInZhbHVlIjoiQjB0N1c0R1gwaEprRCsxT2cxT005NzZyeHpkcmpzKzcxbXJZbHBjWVU3cz0iLCJtYWMiOiI2NGM5ZTMxNDMwYzZmZjA5MzkzNDU0ZDVlNTJjZWM4NTQwZTVmYmRiZmE2ZjMwZDhiMjU5ZjIwZjI2M2MwNTQ5IiwidGFnIjoiIn0=', NULL, '115410', 21, '03', '1977', '8877/81', 2, '12', '1981', 'C-127', 'Shri', 'Dayanand', NULL, 'Prasad', 'श्री', 'दयानंद', NULL, 'प्रसाद', 'Father', 'Late Shri Rameshwar lall', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '31', '31', 'Thirty One Years', 'इकतीस साल', NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":37}]', 37, 'no', NULL, 'false', 6, 1, 'Step 1 : -Agreement Copy Not Found\nStep 2 : -NOC Letter Not Found\nStep 3 : -Registry Deed Not Found\nStep 4 : -\nStep 5 : -', 0, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayanandPrasad', '2026-03-21', '117.233.189.51', NULL, NULL, 4, '2026-03-21 09:00:27', '2026-03-21 09:11:07'),
(41, '1802264319', 42, 1, 1, 1, 3, 4, 'RNCMI1980HRM03871', '$2y$12$/iTdfBAo81tYQR3cNoJV0upthcod/M.YDSug3lDTOyu8iydvWLQOK', 'eyJpdiI6InRDdkJyWENtdmg0MHV2NmxwUExVZ1E9PSIsInZhbHVlIjoiL0dRelFLdTJaQlE4elMxU0o5bFBPL1M1SlZDR2tCeFRycVF3TVliRkNkND0iLCJtYWMiOiJkODRiNzU0ZTlhNDFmYzExNTBjYWY3MGM3NTY3NjRmYTU4NWM0NjcyMmY5MGRkNDk4NmEwOWUxODM3OWVhNjk0IiwidGFnIjoiIn0=', NULL, '127232', 2, '05', '1975', '4439/1980', 26, '05', '1980', 'C-106', 'Shri', 'Ram', 'Prawesh', 'Singh', 'डॉ.', 'राम', 'प्रवेश', 'सिंह', 'Father', 'Late Shri Ganesh Narain singh', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', '34', NULL, 'Thirty Four Years', NULL, NULL, NULL, NULL, NULL, 1, 0, '[{\"file_name\":\"File-1\",\"pages\":157}]', 157, 'no', NULL, 'false', 2, 0, NULL, 0, NULL, '2026-03-21', '117.233.189.51', NULL, NULL, 2, '2026-03-21 09:16:56', '2026-03-21 09:16:56'),
(46, '1602268136', NULL, 1, 1, 1, 3, 4, 'RNCMI1983HRM30276', '$2y$12$kwGOLGBsZhJbVZMXx2hnr.xIuVS7ideWlUdENjkxIFZH4qT0PYYru', 'eyJpdiI6Ilhua25yMGRIeUgweGU1YkVmNnQzR1E9PSIsInZhbHVlIjoiVDYwT0g4SmhwcWNQcVFPWTk2OFVNNEg5MHpaTzRXNlF3Y0ovTUJ0aHp5bz0iLCJtYWMiOiIyNzc3Y2RjN2M1ZmIzN2ExMWUzYjYyMTc1NWU3NjI0YWFlOTQyYmIxZTVlZTg3YTg0Mzg5Yzc4MzQzYjBhNGRmIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 12, '10', '1983', 'C-87', 'Shri', 'Siwani', 'Kumar', 'Pandey', 'श्री', NULL, NULL, NULL, 'Father', 'Ganesh Dev Murthy', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, 18, '11', '2011', NULL, NULL, NULL, NULL, NULL, 'no', 4, 'false', 2, 0, NULL, 0, NULL, '2026-03-23', '127.0.0.1', NULL, NULL, 4, '2026-03-23 04:27:34', '2026-03-23 04:27:34'),
(47, '1602268136', NULL, 1, 1, 1, 3, 4, 'RNCMI1983HRM24013', '$2y$12$epvKOCudDx6HqibmSyFCCeVZBcAGYyd1U.wzt9Wpw1gY9PgshN7kK', 'eyJpdiI6InVMSmRrWmg3a25aRS9yNmRHM0lNOEE9PSIsInZhbHVlIjoiNnUvd1ZoZGg2RGhvd2RrVU1xc2ttMlltOFhUQUV5Y3ZDeU1PMFZPQXQrcz0iLCJtYWMiOiJjZWM5MzE2ZDM0ZGEwODNiMWI4ZTdjYTBjZjM1YjhiZjUwMzA0YjIyN2U4M2Y4ZGU2YjFlZDVjYTdjYTFhYWQwIiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 12, '10', '1983', 'C-87', 'Shri', 'Siwani', 'Kumar', 'Pandey', 'श्री', NULL, NULL, NULL, 'Father', 'Ganesh Dev Murthy', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, 18, '11', '2011', NULL, NULL, NULL, NULL, NULL, 'no', 4, 'false', 2, 0, NULL, 0, NULL, '2026-03-23', '127.0.0.1', NULL, NULL, 4, '2026-03-23 04:27:50', '2026-03-23 04:27:50'),
(48, '1602268136', NULL, 1, 1, 1, 3, 4, 'RNCMI1983HRM93267', '$2y$12$ywDZZEHgNXCSP6TGdkL3OOb8eQeaPBakbH3P.g2zYq.OxsQfne4uG', 'eyJpdiI6IjV2QXltR2NPbUkxaEZ1eHZwSzdYV1E9PSIsInZhbHVlIjoiOEV6SW4wYnByNVpwdEhyODFISWI1Qy9UU1lQWXRKVWhPakNHNzZHUUJ2Yz0iLCJtYWMiOiI5MDhlNzBhZDU3Nzg5OWNhYzZjNzBhZjBlNmQ2NDc2Njc1YmMyYjkwYjM1NTJiYzE2MWYxZDVkZDZhNGEwNDE0IiwidGFnIjoiIn0=', NULL, NULL, NULL, NULL, NULL, NULL, 12, '10', '1983', 'C-87', 'Shri', 'Siwani', 'Kumar', 'Pandey', 'श्री', NULL, NULL, NULL, 'Father', 'Ganesh Dev Murthy', 'Married', 'Male', NULL, NULL, 'General', 'Hindu', 'Indian', NULL, NULL, NULL, NULL, 18, '11', '2011', NULL, NULL, NULL, NULL, NULL, 'no', 4, 'false', 2, 0, NULL, 0, NULL, '2026-03-23', '127.0.0.1', NULL, NULL, 4, '2026-03-23 04:28:59', '2026-03-23 04:28:59');

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
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Sri Ramdhani Sah', 'श्री', 'रामधनी साह', '(Goldsmith), Bara Bazar, B.Deoghar (S.P)', NULL, 15, 264, NULL, NULL, NULL, NULL, NULL, NULL, 'R.No C-101, Hinoo, Ranchi', NULL, 15, 281, '834002', 'Hinoo', NULL, 'Doranda', NULL, NULL, 'C/O Examiner of local accounts, Bihar, Hinoo, Ranchi', NULL, 15, 281, '834002', 'Hinoo', NULL, 'Doranda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 04:53:30', '2026-03-20 04:53:30'),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Tek Chand Gupta', 'श्री', NULL, 'PatPat Sarai, Moradabad, Uttar pradesh', NULL, 34, 726, '244001', 'Moradabad', NULL, 'Moradabad', NULL, 'on', 'PatPat Sarai, Moradabad, Uttar pradesh', NULL, 34, NULL, '244001', 'Moradabad', NULL, 'Moradabad', NULL, 'on', 'PatPat Sarai, Moradabad, Uttar pradesh', NULL, 34, NULL, '244001', 'Moradabad', NULL, 'Moradabad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 04:56:29', '2026-03-20 05:18:26'),
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Harmu Housing Colony, Ranchi', NULL, 15, 281, '834002', 'Harmu', NULL, 'Argora', NULL, 'on', 'Harmu Housing Colony, Ranchi', NULL, 15, NULL, '834002', 'Harmu', NULL, 'Argora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 05:30:48', '2026-03-20 05:30:48'),
(4, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Q.No. H/130, Hinoo , Ranchi', NULL, 15, 281, '834002', 'Hinoo', NULL, 'Doranda', NULL, 'on', 'Q.No. H/130, Hinoo , Ranchi', NULL, 15, 281, '834002', 'Hinoo', NULL, 'Doranda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 05:37:15', '2026-03-20 05:37:15'),
(5, 5, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late Sukhdeo Thakur', 'श्री', NULL, 'MIG Plot No C-79, Harmu Housing Colony, Ranchi', NULL, 15, 281, '834002', 'Harmu', NULL, 'Harmu', NULL, 'on', 'MIG Plot No C-79, Harmu Housing Colony, Ranchi', NULL, 15, NULL, '834002', 'Harmu', NULL, 'Harmu', NULL, 'on', 'MIG Plot No C-79, Harmu Housing Colony, Ranchi', NULL, 15, NULL, '834002', 'Harmu', NULL, 'Harmu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 06:19:10', '2026-03-20 06:19:10'),
(6, 6, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'late Deoki Nandan Sharma', 'श्री', NULL, 'Belchhi, Bihar', NULL, 5, 110, '803110', 'Bali Belchhi', NULL, 'Chandi', NULL, NULL, 'R/o- Qr. No.-DT 592, T Dhurwa', NULL, 15, 281, '834004', 'Dhurwa', NULL, 'Dhurwa', NULL, 'on', 'R/o- Qr. No.-DT 592, T Dhurwa', NULL, 15, NULL, '834004', 'Dhurwa', NULL, 'Dhurwa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 06:30:00', '2026-03-20 06:30:00'),
(7, 7, NULL, NULL, NULL, NULL, NULL, NULL, 'husband', 'Shri', 'Dr Santosh Kumar Sen', 'श्री', NULL, 'Toruchhaya, Lalpur, Ranchi', NULL, 15, 281, '834001', 'Lalpur', NULL, 'Lalpur', NULL, NULL, '162, Doon Vihar, Awas Vikas Colony, Rajpur Road, Dehradun', NULL, 35, 749, '248001', 'Rajpur Road', NULL, 'Rajpur Road', NULL, 'on', '162, Doon Vihar, Awas Vikas Colony, Rajpur Road, Dehradun', NULL, 35, NULL, '248001', 'Rajpur Road', NULL, 'Rajpur Road', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 06:53:54', '2026-03-20 07:50:27'),
(8, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'R/o-Qr. No.-DT 592, T Dhurwa', NULL, 15, 281, '834004', 'Dhurwa', NULL, 'Dhurwa', NULL, 'on', 'R/o-Qr. No.-DT 592, T Dhurwa', NULL, 15, 281, '834004', 'Dhurwa', NULL, 'Dhurwa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 07:10:29', '2026-03-20 07:10:29'),
(9, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Harmu Housing Colony, Ranchi', NULL, 15, 281, '834002', 'Harmu', NULL, 'Argora', NULL, NULL, 'Haripur Krishna, Siho, Muzaffarpur', NULL, 5, 109, '843119', 'Siho', NULL, 'Sakra', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 08:22:44', '2026-03-20 08:22:44'),
(10, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'late Stya narain singh', 'श्री', NULL, 'Rajhara, Palamu', NULL, 15, 279, '822124', 'Latdag', NULL, 'Bishrampur', NULL, NULL, 'Asst. Electrical Engineer, Electric Supply Sub div, Bakhtiarpur', NULL, 5, 112, '803212', 'Bakhtiyarpur', NULL, 'Bakhtiyarpur', NULL, NULL, 'Rajhara, Palamu', NULL, 15, 279, '822124', 'Latdag', NULL, 'Bishrampur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 08:25:15', '2026-03-20 08:25:15'),
(11, 12, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late Rameshwar Lal', 'श्री', NULL, 'Sector 4D, Bokaro Steel City, Dhanbad', NULL, 15, 262, '827004', 'Bokaro', NULL, 'Bokaro', NULL, 'on', 'Sector 4D, Bokaro Steel City, Dhanbad', NULL, 15, NULL, '827004', 'Bokaro', NULL, 'Bokaro', NULL, 'on', 'Sector 4D, Bokaro Steel City, Dhanbad', NULL, 15, NULL, '827004', 'Bokaro', NULL, 'Bokaro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 09:01:11', '2026-03-20 09:01:11'),
(12, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Nand Kishore Lal', 'श्री', NULL, 'Harmu Road, Ranchi', NULL, 15, 281, '834002', 'Harmu', NULL, 'Kotwali', NULL, NULL, 'C/O Sri J.K.P Sinha, Advocate, 101, Harmu Road, Ranchi', NULL, 15, 281, '834001', 'Harmu', NULL, 'Argora', NULL, NULL, 'C/O Sri J.K.P Sinha, Advocate, 101, Harmu Road, Ranchi', NULL, 15, 281, '834001', 'Harmu', NULL, 'Argora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 09:16:30', '2026-03-20 09:16:30'),
(13, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Deputy Para, Lalpur, Ranchi', NULL, 15, 281, '834001', 'Ranchi', NULL, 'Lalpur', NULL, 'on', 'Deputy Para, Lalpur, Ranchi', NULL, 15, NULL, '834001', 'Ranchi', NULL, 'Lalpur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 09:16:31', '2026-03-20 09:16:31'),
(14, 15, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late Sri Adya Prasad Varma', 'श्री', NULL, 'Jaitpura, Varanasi, Uttar Pradesh', NULL, 34, 744, '221001', 'Jaitpura', NULL, 'Jaitpura', NULL, NULL, 'Mohalla Meurs Road, Ranchi', NULL, 15, 281, '834008', 'Meurs', NULL, 'Ranchi', NULL, 'on', 'Mohalla Meurs Road, Ranchi', NULL, 15, NULL, '834008', 'Meurs', NULL, 'Ranchi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 09:38:33', '2026-03-20 09:38:33'),
(15, 17, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late Ganesh Pradhan', 'श्री', NULL, 'Minor Arrigation Division, Garhwa, Palamu', NULL, 15, 279, '822114', 'Garhwa', NULL, 'Garhwa', NULL, 'on', 'Minor Arrigation Division, Garhwa, Palamu', NULL, 15, NULL, '822114', 'Garhwa', NULL, 'Garhwa', NULL, 'on', 'Minor Arrigation Division, Garhwa, Palamu', NULL, 15, NULL, '822114', 'Garhwa', NULL, 'Garhwa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 10:51:23', '2026-03-20 10:51:23'),
(16, 16, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Jagdeo Narain', 'श्री', NULL, 'Punaichak, Patna-23', NULL, 5, 112, '800023', 'Punaichak', NULL, 'Punaichak', NULL, 'on', 'Punaichak, Patna-23', NULL, 5, NULL, '800023', 'Punaichak', NULL, 'Punaichak', NULL, 'on', 'Punaichak, Patna-23', NULL, 5, NULL, '800023', 'Punaichak', NULL, 'Punaichak', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 10:51:25', '2026-03-20 10:51:25'),
(17, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Patil Nagar, Shastri Nagar, Patna', NULL, 5, 112, '800023', 'Shastri Nagar', NULL, 'Shastri Nagar', NULL, 'on', 'Patil Nagar, Shastri Nagar, Patna', NULL, 5, NULL, '800023', 'Shastri Nagar', NULL, 'Shastri Nagar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 11:09:00', '2026-03-20 11:09:00'),
(18, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A/16, Harmu Housing Colony, Ranchi', NULL, 15, 281, '834002', 'Harmu', NULL, 'Argora', NULL, 'on', 'A/16, Harmu Housing Colony, Ranchi', NULL, 15, NULL, '834002', 'Harmu', NULL, 'Argora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 11:29:21', '2026-03-20 11:29:21'),
(19, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Harmu Housing Colony, Ranchi', NULL, 15, 281, '834002', 'Harmu', NULL, 'Argora', NULL, 'on', 'Harmu Housing Colony, Ranchi', NULL, 15, NULL, '834002', 'Harmu', NULL, 'Argora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 11:39:43', '2026-03-20 11:39:43'),
(20, 21, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Sri Padarath Roy', 'श्री', NULL, 'Bakoli Bhrigunath Prasad, Murar, Bhojpur', NULL, 5, 93, '802127', 'Murar', NULL, 'Murar', NULL, 'on', 'Bakoli Bhrigunath Prasad, Murar, Bhojpur', NULL, 5, NULL, '802127', 'Murar', NULL, 'Murar', NULL, 'on', 'Bakoli Bhrigunath Prasad, Murar, Bhojpur', NULL, 5, NULL, '802127', 'Murar', NULL, 'Murar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 11:45:42', '2026-03-20 11:45:42'),
(21, 22, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Shri Kewal Mahto', 'श्री', NULL, 'Chandragarh, Bihar', NULL, 5, 89, '824301', 'Chandragarh', NULL, 'Nabinagar', NULL, NULL, 'Subernarekha Hydel Project', NULL, 15, 281, '835219', 'Sikidiri', NULL, 'Angara', NULL, NULL, 'Chandragarh, Bihar', NULL, 5, 89, '824301', 'Chandragarh', NULL, 'Nabinagar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 12:01:31', '2026-03-20 12:01:31'),
(22, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ahrav, Rohtas, Bihar', NULL, 5, 114, '821311', 'Natwar', NULL, 'Dinara', NULL, NULL, 'Saristabad, Patna', NULL, 5, 112, '800001', 'Anisabad', NULL, 'Gardanibagh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 12:04:06', '2026-03-20 12:06:26'),
(23, 24, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Kumbha Ramji Sharma', 'श्री', 'भगवती प्रसाद शर्मा', '65 Rajguru Compound , Lake Road, Ranchi', NULL, 15, 281, '834001', 'Ranchi', NULL, 'Kotwali', NULL, NULL, '65, Rajguru Compound , Lake Road, Ranchi', NULL, 15, 281, '834001', 'Ranchi', NULL, 'Ranchi', NULL, 'on', '65, Rajguru Compound , Lake Road, Ranchi', NULL, 15, 281, '834001', 'Ranchi', NULL, 'Ranchi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 12:17:45', '2026-03-20 12:17:45'),
(24, 25, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Shri Ramanand Singh', 'श्री', NULL, 'Lakhna, Punpun, Patna', NULL, 5, 112, '804453', 'Lakhna', NULL, 'Punpun', NULL, 'on', 'Lakhna, Punpun, Patna', NULL, 5, NULL, '804453', 'Lakhna', NULL, 'Punpun', NULL, 'on', 'Lakhna, Punpun, Patna', NULL, 5, 112, '804453', 'Lakhna', NULL, 'Punpun', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 12:17:46', '2026-03-20 12:17:46'),
(25, 27, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Sri Narsingh Singh', 'श्री', NULL, 'Pansa, Hussainabad, Palamu', NULL, 37, 798, '822115', 'Pansa', NULL, 'Hussainabad', NULL, 'on', 'Pansa, Hussainabad, Palamu', NULL, 37, 798, '822115', 'Pansa', NULL, 'Hussainabad', NULL, 'on', 'Pansa, Hussainabad, Palamu', NULL, 37, 798, '822115', 'Pansa', NULL, 'Hussainabad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.180.137', '117.233.180.137', '2026-03-20 12:29:42', '2026-03-20 12:39:51'),
(26, 26, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late Satya Bhusan Jayaswal', 'श्री', NULL, 'Betwan Bazar, Monghyr', NULL, 5, 97, '823001', 'Munger', NULL, 'Munger', NULL, NULL, 'University Engineer, Magadh University, Gaya', NULL, 5, 97, '824234', 'Gaya', NULL, 'Gaya', NULL, NULL, 'Betwan Bazar, Monghyr, Gaya', NULL, 5, 97, '823001', 'Munger', NULL, 'Munger', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.180.137', '117.233.180.137', '2026-03-20 12:33:18', '2026-03-20 12:33:18'),
(27, 28, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Shri Bachhu Prasad Singh', 'श्री', NULL, 'Molkama, Moldiar Tola, Mokama, Patna', NULL, 5, 112, '803302', 'Mokama', NULL, 'Mokama', NULL, 'on', 'Molkama, Moldiar Tola, Mokama, Patna', NULL, 5, NULL, '803302', 'Mokama', NULL, 'Mokama', NULL, 'on', 'Molkama, Moldiar Tola, Mokama, Patna', NULL, 5, NULL, '803302', 'Mokama', NULL, 'Mokama', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.189.51', '117.233.189.51', '2026-03-21 05:14:38', '2026-03-21 05:14:38'),
(28, 30, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late Dhiraj Kumar Khanna', 'श्री', NULL, 'Santosh Gess Agency, Main Road, Ranchi', NULL, 37, 800, '834001', 'Ranchi', NULL, 'Ranchi', NULL, NULL, 'Harmu Housing Colony, Ranchi', NULL, 37, 800, '834002', 'Harmu', NULL, 'Argora', NULL, 'on', 'Harmu Housing Colony, Ranchi', NULL, 37, NULL, '834002', 'Harmu', NULL, 'Argora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.189.51', '117.233.189.51', '2026-03-21 05:42:40', '2026-03-21 05:42:40'),
(29, 29, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Sri Radha Krishna Jha', 'श्री', NULL, 'Sisouma, Bihar', NULL, 5, 107, '847234', 'Dahibhat', NULL, 'Pandaul', NULL, NULL, 'S.D.O(Electricity) Katrasgarh, Dhanbad', NULL, 15, 281, '828113', 'Katrasgarh', NULL, 'Katrasgarh', NULL, NULL, 'Sisouma, Bihar', NULL, 5, 107, '847234', 'Dahibhat', NULL, 'Pandaul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.189.51', '117.233.189.51', '2026-03-21 05:49:22', '2026-03-21 05:49:22'),
(30, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Harmu, Ranchi', NULL, 37, 800, '834002', 'Harmu', NULL, 'Argora', NULL, 'on', 'Harmu, Ranchi', NULL, 37, NULL, '834002', 'Harmu', NULL, 'Argora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.189.51', '117.233.189.51', '2026-03-21 06:18:31', '2026-03-21 06:18:31'),
(31, 32, '0984509385', '0983450938', NULL, NULL, NULL, NULL, 'father', 'Shri', 'Shri Dashrath Sahu', 'श्री', NULL, 'Debi Asthan, Hussainabad, Japla, Palamu, Bihar', NULL, 37, 798, '822116', 'Japla', NULL, 'Hussainabad', NULL, 'on', 'Debi Asthan, Hussainabad, Japla, Palamu, Bihar', NULL, 37, 798, '822116', 'Japla', NULL, 'Hussainabad', NULL, 'on', 'Debi Asthan, Hussainabad, Japla, Palamu, Bihar', NULL, 37, 798, '822116', 'Japla', NULL, 'Hussainabad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '127.0.0.1', '127.0.0.1', '2026-03-21 06:42:59', '2026-03-23 09:59:11'),
(32, 33, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late Srreenata Sahay', 'श्री', NULL, 'Mahabirchabutra, Bhojpur', NULL, 5, 93, '802119', 'Dumraon', NULL, 'Bhojpur', NULL, NULL, 'D/6(Area Board) Electricity Board\'s Colony Kusai Colony, Hinoo, Ranchi', NULL, 37, 800, '834002', 'Hinoo', NULL, 'Hinoo', NULL, NULL, 'Mahabirchabutra, Bhojpur', NULL, 5, 93, '802119', 'Dumraon', NULL, 'Bhojpur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.189.51', '117.233.189.51', '2026-03-21 06:54:01', '2026-03-21 06:54:01'),
(33, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ashok Nagar, Ranchi', NULL, 15, 281, '834002', 'Ashok Nagar', NULL, 'Argora', NULL, 'on', 'Ashok Nagar, Ranchi', NULL, 15, 281, '834002', 'Ashok Nagar', NULL, 'Argora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.189.51', '117.233.189.51', '2026-03-21 07:37:52', '2026-03-21 07:37:52'),
(34, 34, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Shri Yogendra Jha', 'श्री', NULL, 'Maunbehat, Manigachi, Darbhanga', NULL, 5, 95, '847422', 'Manigachi', NULL, 'Manigachi', NULL, NULL, 'Nagratoli, Lalpur, Ranchi', NULL, 37, 800, '834001', 'Ranchi', NULL, 'Lalpur', NULL, 'on', 'Nagratoli, Lalpur, Ranchi', NULL, 37, NULL, '834001', 'Ranchi', NULL, 'Lalpur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.189.51', '117.233.189.51', '2026-03-21 07:39:02', '2026-03-21 07:39:02'),
(35, 36, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late Jagdish Prasad Srivastava', 'श्री', NULL, 'Public Health Division, Nepal House, Doranda, Ranchi', NULL, 37, 800, '834002', 'Doranda', NULL, 'Doranda', NULL, NULL, 'Sheogunj, Arrah, Bhojpur, Bihar', NULL, 5, 93, '802301', 'Arrah', NULL, 'Arrah', NULL, 'on', 'Sheogunj, Arrah, Bhojpur, Bihar', NULL, 5, NULL, '802301', 'Arrah', NULL, 'Arrah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.189.51', '117.233.189.51', '2026-03-21 08:30:11', '2026-03-21 08:30:11'),
(36, 37, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Sri Satyanarain Singh', 'श्री', NULL, 'Electrical Executive Enginner, Chaibasa', NULL, 37, 804, '833201', 'Chaibasa', NULL, 'Sadar', NULL, 'on', 'Electrical Executive Enginner, Chaibasa', NULL, 37, NULL, '833201', 'Chaibasa', NULL, 'Sadar', NULL, 'on', 'Electrical Executive Enginner, Chaibasa', NULL, 37, NULL, '833201', 'Chaibasa', NULL, 'Sadar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.189.51', '117.233.189.51', '2026-03-21 08:32:30', '2026-03-21 08:32:30'),
(37, 38, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Shri Kewal Mahto', 'श्री', NULL, 'Chandragarh, Nabi Nagar, Aurangabad', NULL, 5, 89, '824301', 'Chandragarh', NULL, 'Nabinagar', NULL, 'on', 'Chandragarh, Nabi Nagar, Aurangabad', NULL, 5, 89, '824301', 'Chandragarh', NULL, 'Nabinagar', NULL, 'on', 'Chandragarh, Nabi Nagar, Aurangabad', NULL, 5, 89, '824301', 'Chandragarh', NULL, 'Nabinagar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.189.51', '117.233.189.51', '2026-03-21 08:48:03', '2026-03-21 08:48:16'),
(38, 39, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late PN Chakhaiyar', 'श्री', NULL, 'White house Compound, Gaya', NULL, 5, 97, '823001', 'Gaya', NULL, 'Gaya', NULL, 'on', 'White house Compound, Gaya', NULL, 5, NULL, '823001', 'Gaya', NULL, 'Gaya', NULL, 'on', 'White house Compound, Gaya', NULL, 5, NULL, '823001', 'Gaya', NULL, 'Gaya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '117.233.189.51', '117.233.189.51', '2026-03-21 08:56:11', '2026-03-21 08:56:11'),
(39, 40, NULL, NULL, NULL, NULL, NULL, NULL, 'father', 'Shri', 'Late Shri Rameshwar lall', 'श्री', NULL, 'House Of Goshi Gorai, N.S Road, Asansol, Bardhaman', NULL, 36, 760, '713304', 'Asansol', NULL, 'Asansol', NULL, NULL, 'Bokaro Steel City, Bokaro', NULL, 37, 781, '827001', 'Bokaro', NULL, 'Bokaro', NULL, 'on', 'Bokaro Steel City, Bokaro', NULL, 37, 781, '827001', 'Bokaro', NULL, 'Bokaro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 4, '117.233.189.51', '117.233.189.51', '2026-03-21 09:04:34', '2026-03-21 09:04:34');

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

--
-- Dumping data for table `allottee_documents`
--

INSERT INTO `allottee_documents` (`id`, `allottee_id`, `document_id`, `doc_no`, `doc_day`, `doc_month`, `doc_year`, `additional_info`, `remarks`, `file_path`, `file_name`, `uploaded_by`, `created_at`) VALUES
(1, 2, 1, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 05:07:42'),
(2, 2, 2, '1302', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/06/Plot/MIG/C-37/KamleshKumarGupta/RNCHRMMIG197906-C-37_allotment_letter_9539.pdf', 'RNCHRMMIG197906-C-37_allotment_letter_9539.pdf', 4, '2026-03-20 05:08:33'),
(3, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/06/Plot/MIG/C-37/KamleshKumarGupta/RNCHRMMIG197906-C-37_agreement_copy_4431.pdf', 'RNCHRMMIG197906-C-37_agreement_copy_4431.pdf', 4, '2026-03-20 05:09:04'),
(4, 2, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 05:09:13'),
(5, 2, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 05:09:19'),
(6, 1, 1, '128788', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-87/MadanLalShah/RNCHRMMIG198004-C-87_application_letter_7811.pdf', 'RNCHRMMIG198004-C-87_application_letter_7811.pdf', 2, '2026-03-20 05:10:09'),
(7, 2, 6, '5436', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/06/Plot/MIG/C-37/KamleshKumarGupta/RNCHRMMIG197906-C-37_final_calculation_8209.pdf', 'RNCHRMMIG197906-C-37_final_calculation_8209.pdf', 4, '2026-03-20 05:11:16'),
(8, 1, 2, '2684', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-87/MadanLalShah/RNCHRMMIG198004-C-87_allotment_letter_5427.pdf', 'RNCHRMMIG198004-C-87_allotment_letter_5427.pdf', 2, '2026-03-20 05:11:26'),
(9, 2, 7, '1127', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/06/Plot/MIG/C-37/KamleshKumarGupta/RNCHRMMIG197906-C-37_noc_before_registry_4229.pdf', 'RNCHRMMIG197906-C-37_noc_before_registry_4229.pdf', 4, '2026-03-20 05:12:14'),
(10, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-87/MadanLalShah/RNCHRMMIG198004-C-87_agreement_copy_7160.pdf', 'RNCHRMMIG198004-C-87_agreement_copy_7160.pdf', 2, '2026-03-20 05:14:10'),
(11, 1, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:14:28'),
(12, 2, 8, '3133', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/06/Plot/MIG/C-37/KamleshKumarGupta/RNCHRMMIG197906-C-37_registry_deed_1875.pdf', 'RNCHRMMIG197906-C-37_registry_deed_1875.pdf', 4, '2026-03-20 05:14:37'),
(13, 1, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:14:49'),
(14, 1, 6, '1121', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-87/MadanLalShah/RNCHRMMIG198004-C-87_final_calculation_5751.pdf', 'RNCHRMMIG198004-C-87_final_calculation_5751.pdf', 2, '2026-03-20 05:15:52'),
(15, 2, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/06/Plot/MIG/C-37/KamleshKumarGupta/RNCHRMMIG197906-C-37_property_map_8921.pdf', 'RNCHRMMIG197906-C-37_property_map_8921.pdf', 4, '2026-03-20 05:16:01'),
(16, 1, 7, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:16:15'),
(17, 2, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/06/Plot/MIG/C-37/KamleshKumarGupta/RNCHRMMIG197906-C-37_noting_sheet_5446.pdf', 'RNCHRMMIG197906-C-37_noting_sheet_5446.pdf', 4, '2026-03-20 05:16:23'),
(18, 1, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:16:53'),
(19, 1, 18, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:17:59'),
(20, 1, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-87/MadanLalShah/RNCHRMMIG198004-C-87_noting_sheet_5991.pdf', 'RNCHRMMIG198004-C-87_noting_sheet_5991.pdf', 2, '2026-03-20 05:19:40'),
(21, 3, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2010/09/Plot/MIG/C-37/SubodhKumarSinha/RNCHRMMIG201009-C-37_name_transfer_request_8620.pdf', 'RNCHRMMIG201009-C-37_name_transfer_request_8620.pdf', 4, '2026-03-20 05:35:42'),
(22, 3, 10, '1877', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2010/09/Plot/MIG/C-37/SubodhKumarSinha/RNCHRMMIG201009-C-37_name_transfer_forwarding_4979.pdf', 'RNCHRMMIG201009-C-37_name_transfer_forwarding_4979.pdf', 4, '2026-03-20 05:36:43'),
(23, 3, 11, '1745', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2010/09/Plot/MIG/C-37/SubodhKumarSinha/RNCHRMMIG201009-C-37_dividend_calculation_4288.pdf', 'RNCHRMMIG201009-C-37_dividend_calculation_4288.pdf', 4, '2026-03-20 05:38:15'),
(24, 4, 9, '3042', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1983/07/Plot/MIG/C-87/UrmilaDevi/RNCHRMMIG198307-C-87_name_transfer_request_6119.pdf', 'RNCHRMMIG198307-C-87_name_transfer_request_6119.pdf', 2, '2026-03-20 05:38:52'),
(25, 3, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 05:39:19'),
(26, 4, 10, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:39:36'),
(27, 4, 11, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:39:49'),
(28, 4, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:39:59'),
(29, 3, 13, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 05:40:05'),
(30, 4, 13, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:40:07'),
(31, 3, 14, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 05:40:27'),
(32, 4, 14, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:40:33'),
(33, 4, 15, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 05:40:58'),
(34, 3, 15, '1877', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2010/09/Plot/MIG/C-37/SubodhKumarSinha/RNCHRMMIG201009-C-37_name_transfer_confirmation_5149.pdf', 'RNCHRMMIG201009-C-37_name_transfer_confirmation_5149.pdf', 4, '2026-03-20 05:43:03'),
(35, 3, 16, '99', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2010/09/Plot/MIG/C-37/SubodhKumarSinha/RNCHRMMIG201009-C-37_ground_rent_6943.pdf', 'RNCHRMMIG201009-C-37_ground_rent_6943.pdf', 4, '2026-03-20 05:48:23'),
(36, 3, 17, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2010/09/Plot/MIG/C-37/SubodhKumarSinha/RNCHRMMIG201009-C-37_name_transfer_registry_deed_4440.pdf', 'RNCHRMMIG201009-C-37_name_transfer_registry_deed_4440.pdf', 4, '2026-03-20 05:49:43'),
(37, 5, 1, '115652', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1998/10/Plot/MIG/C-86/Indu BhushanPrasadThakur/RNCHRMMIG199810-C-86_application_letter_8359.pdf', 'RNCHRMMIG199810-C-86_application_letter_8359.pdf', 4, '2026-03-20 06:26:58'),
(38, 5, 2, '3910', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1998/10/Plot/MIG/C-86/Indu BhushanPrasadThakur/RNCHRMMIG199810-C-86_allotment_letter_7402.pdf', 'RNCHRMMIG199810-C-86_allotment_letter_7402.pdf', 4, '2026-03-20 06:29:24'),
(39, 5, 3, '2999', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1998/10/Plot/MIG/C-86/Indu BhushanPrasadThakur/RNCHRMMIG199810-C-86_agreement_copy_5820.pdf', 'RNCHRMMIG199810-C-86_agreement_copy_5820.pdf', 4, '2026-03-20 06:30:45'),
(40, 5, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 06:30:53'),
(41, 5, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 06:31:00'),
(42, 5, 6, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1998/10/Plot/MIG/C-86/Indu BhushanPrasadThakur/RNCHRMMIG199810-C-86_final_calculation_5716.pdf', 'RNCHRMMIG199810-C-86_final_calculation_5716.pdf', 4, '2026-03-20 06:32:20'),
(43, 5, 7, '1020', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1998/10/Plot/MIG/C-86/Indu BhushanPrasadThakur/RNCHRMMIG199810-C-86_noc_before_registry_1907.pdf', 'RNCHRMMIG199810-C-86_noc_before_registry_1907.pdf', 4, '2026-03-20 06:33:02'),
(44, 5, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 06:33:41'),
(45, 5, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1998/10/Plot/MIG/C-86/Indu BhushanPrasadThakur/RNCHRMMIG199810-C-86_property_map_3900.pdf', 'RNCHRMMIG199810-C-86_property_map_3900.pdf', 4, '2026-03-20 06:33:58'),
(46, 5, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1998/10/Plot/MIG/C-86/Indu BhushanPrasadThakur/RNCHRMMIG199810-C-86_noting_sheet_8535.pdf', 'RNCHRMMIG199810-C-86_noting_sheet_8535.pdf', 4, '2026-03-20 06:34:14'),
(47, 6, 1, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 06:36:43'),
(48, 6, 2, '1730', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-44/MadhusudanSharma/RNCHRMMIG197807-C-44_allotment_letter_7582.pdf', 'RNCHRMMIG197807-C-44_allotment_letter_7582.pdf', 2, '2026-03-20 06:37:53'),
(49, 6, 3, '3494', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-44/MadhusudanSharma/RNCHRMMIG197807-C-44_agreement_copy_7382.pdf', 'RNCHRMMIG197807-C-44_agreement_copy_7382.pdf', 2, '2026-03-20 06:39:36'),
(50, 6, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 06:40:11'),
(51, 6, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 06:40:31'),
(52, 6, 6, '266', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-44/MadhusudanSharma/RNCHRMMIG197807-C-44_final_calculation_7440.pdf', 'RNCHRMMIG197807-C-44_final_calculation_7440.pdf', 2, '2026-03-20 06:46:42'),
(53, 6, 7, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 06:47:30'),
(54, 6, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 06:47:47'),
(55, 6, 18, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 06:48:23'),
(56, 6, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-44/MadhusudanSharma/RNCHRMMIG197807-C-44_noting_sheet_1359.pdf', 'RNCHRMMIG197807-C-44_noting_sheet_1359.pdf', 2, '2026-03-20 06:50:26'),
(57, 8, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2010/01/Plot/MIG/C-44/SukumariSharma/RNCHRMMIG201001-C-44_name_transfer_request_5824.pdf', 'RNCHRMMIG201001-C-44_name_transfer_request_5824.pdf', 2, '2026-03-20 07:12:45'),
(58, 8, 10, '312', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2010/01/Plot/MIG/C-44/SukumariSharma/RNCHRMMIG201001-C-44_name_transfer_forwarding_4054.pdf', 'RNCHRMMIG201001-C-44_name_transfer_forwarding_4054.pdf', 2, '2026-03-20 07:14:48'),
(59, 8, 11, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 07:15:16'),
(60, 8, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 07:16:35'),
(61, 8, 13, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 07:17:34'),
(62, 8, 14, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 07:18:52'),
(63, 8, 15, '1437', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2010/01/Plot/MIG/C-44/SukumariSharma/RNCHRMMIG201001-C-44_name_transfer_confirmation_6877.pdf', 'RNCHRMMIG201001-C-44_name_transfer_confirmation_6877.pdf', 2, '2026-03-20 07:20:08'),
(64, 8, 16, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 07:20:27'),
(65, 8, 17, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 07:20:41'),
(66, 7, 1, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 07:30:11'),
(67, 7, 2, '1635', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-67/SabitaSen/RNCHRMMIG197807-C-67_allotment_letter_6227.pdf', 'RNCHRMMIG197807-C-67_allotment_letter_6227.pdf', 4, '2026-03-20 07:40:23'),
(68, 7, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-67/SabitaSen/RNCHRMMIG197807-C-67_agreement_copy_2924.pdf', 'RNCHRMMIG197807-C-67_agreement_copy_2924.pdf', 4, '2026-03-20 07:43:58'),
(69, 7, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 07:44:06'),
(70, 7, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 07:44:14'),
(71, 7, 6, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 07:44:25'),
(72, 7, 7, '757', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-67/SabitaSen/RNCHRMMIG197807-C-67_noc_before_registry_2211.pdf', 'RNCHRMMIG197807-C-67_noc_before_registry_2211.pdf', 4, '2026-03-20 07:45:45'),
(73, 7, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 07:46:06'),
(74, 7, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-67/SabitaSen/RNCHRMMIG197807-C-67_property_map_7023.pdf', 'RNCHRMMIG197807-C-67_property_map_7023.pdf', 4, '2026-03-20 07:46:34'),
(75, 7, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-67/SabitaSen/RNCHRMMIG197807-C-67_noting_sheet_1414.pdf', 'RNCHRMMIG197807-C-67_noting_sheet_1414.pdf', 4, '2026-03-20 07:50:00'),
(76, 10, 9, '1755', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/11/Plot/MIG/C-67/AjayKumar/RNCHRMMIG200411-C-67_name_transfer_request_8953.pdf', 'RNCHRMMIG200411-C-67_name_transfer_request_8953.pdf', 4, '2026-03-20 08:25:29'),
(77, 10, 10, '1428', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/11/Plot/MIG/C-67/AjayKumar/RNCHRMMIG200411-C-67_name_transfer_forwarding_7686.pdf', 'RNCHRMMIG200411-C-67_name_transfer_forwarding_7686.pdf', 4, '2026-03-20 08:27:47'),
(78, 10, 11, '102', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/11/Plot/MIG/C-67/AjayKumar/RNCHRMMIG200411-C-67_dividend_calculation_8823.pdf', 'RNCHRMMIG200411-C-67_dividend_calculation_8823.pdf', 4, '2026-03-20 08:29:08'),
(79, 10, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 08:29:26'),
(80, 10, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/11/Plot/MIG/C-67/AjayKumar/RNCHRMMIG200411-C-67_site_verification_5187.pdf', 'RNCHRMMIG200411-C-67_site_verification_5187.pdf', 4, '2026-03-20 08:29:46'),
(81, 10, 14, '682', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/11/Plot/MIG/C-67/AjayKumar/RNCHRMMIG200411-C-67_noc_letter_1567.pdf', 'RNCHRMMIG200411-C-67_noc_letter_1567.pdf', 4, '2026-03-20 08:30:55'),
(82, 10, 15, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 08:32:47'),
(83, 10, 16, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/11/Plot/MIG/C-67/AjayKumar/RNCHRMMIG200411-C-67_ground_rent_7769.pdf', 'RNCHRMMIG200411-C-67_ground_rent_7769.pdf', 4, '2026-03-20 08:33:11'),
(84, 10, 17, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/11/Plot/MIG/C-67/AjayKumar/RNCHRMMIG200411-C-67_name_transfer_registry_deed_9404.pdf', 'RNCHRMMIG200411-C-67_name_transfer_registry_deed_9404.pdf', 4, '2026-03-20 08:33:58'),
(85, 9, 1, '128880', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_application_letter_7012.pdf', 'RNCHRMMIG199109-C-35_application_letter_7012.pdf', 2, '2026-03-20 08:39:25'),
(86, 9, 2, '2406', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_allotment_letter_9149.pdf', 'RNCHRMMIG199109-C-35_allotment_letter_9149.pdf', 2, '2026-03-20 08:40:08'),
(87, 9, 3, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 08:42:12'),
(88, 9, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 08:42:21'),
(89, 9, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 08:42:32'),
(90, 9, 6, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 08:43:19'),
(91, 9, 7, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_noc_before_registry_4656.pdf', 'RNCHRMMIG199109-C-35_noc_before_registry_4656.pdf', 2, '2026-03-20 08:48:36'),
(92, 9, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 08:48:44'),
(93, 9, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_property_map_9741.pdf', 'RNCHRMMIG199109-C-35_property_map_9741.pdf', 2, '2026-03-20 08:49:34'),
(94, 9, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_noting_sheet_8846.pdf', 'RNCHRMMIG199109-C-35_noting_sheet_8846.pdf', 2, '2026-03-20 08:51:13'),
(95, 12, 1, '115410', NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 09:05:27'),
(96, 12, 2, '8877', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayaNandPrasad/RNCHRMMIG198112-C-127_allotment_letter_8679.pdf', 'RNCHRMMIG198112-C-127_allotment_letter_8679.pdf', 4, '2026-03-20 09:05:56'),
(97, 12, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayaNandPrasad/RNCHRMMIG198112-C-127_agreement_copy_2299.pdf', 'RNCHRMMIG198112-C-127_agreement_copy_2299.pdf', 4, '2026-03-20 09:06:34'),
(98, 12, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 09:06:41'),
(99, 12, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 09:06:48'),
(100, 12, 6, '734', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayaNandPrasad/RNCHRMMIG198112-C-127_final_calculation_9308.pdf', 'RNCHRMMIG198112-C-127_final_calculation_9308.pdf', 4, '2026-03-20 09:07:38'),
(101, 12, 7, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 09:08:49'),
(102, 12, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 09:10:31'),
(103, 12, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayaNandPrasad/RNCHRMMIG198112-C-127_property_map_1549.pdf', 'RNCHRMMIG198112-C-127_property_map_1549.pdf', 4, '2026-03-20 09:10:40'),
(104, 12, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayaNandPrasad/RNCHRMMIG198112-C-127_noting_sheet_7190.pdf', 'RNCHRMMIG198112-C-127_noting_sheet_7190.pdf', 4, '2026-03-20 09:10:48'),
(105, 14, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/09/Plot/MIG/C-127/SangeetaBala/RNCHRMMIG200409-C-127_name_transfer_request_5627.pdf', 'RNCHRMMIG200409-C-127_name_transfer_request_5627.pdf', 4, '2026-03-20 09:18:22'),
(106, 14, 10, '2766', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/09/Plot/MIG/C-127/SangeetaBala/RNCHRMMIG200409-C-127_name_transfer_forwarding_4317.pdf', 'RNCHRMMIG200409-C-127_name_transfer_forwarding_4317.pdf', 4, '2026-03-20 09:19:11'),
(107, 14, 11, '2694', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/09/Plot/MIG/C-127/SangeetaBala/RNCHRMMIG200409-C-127_dividend_calculation_9971.pdf', 'RNCHRMMIG200409-C-127_dividend_calculation_9971.pdf', 4, '2026-03-20 09:19:54'),
(108, 14, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 09:20:36'),
(109, 14, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/09/Plot/MIG/C-127/SangeetaBala/RNCHRMMIG200409-C-127_site_verification_4738.pdf', 'RNCHRMMIG200409-C-127_site_verification_4738.pdf', 4, '2026-03-20 09:20:50'),
(110, 14, 14, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 09:21:14'),
(111, 14, 15, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 09:22:22'),
(112, 14, 16, '63', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/09/Plot/MIG/C-127/SangeetaBala/RNCHRMMIG200409-C-127_ground_rent_3898.pdf', 'RNCHRMMIG200409-C-127_ground_rent_3898.pdf', 4, '2026-03-20 09:22:55'),
(113, 13, 1, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 09:23:16'),
(114, 14, 17, '3028', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/09/Plot/MIG/C-127/SangeetaBala/RNCHRMMIG200409-C-127_name_transfer_registry_deed_3860.pdf', 'RNCHRMMIG200409-C-127_name_transfer_registry_deed_3860.pdf', 4, '2026-03-20 09:23:45'),
(115, 13, 2, '2681', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-102/BrajKishorePrasad/RNCHRMMIG198004-C-102_allotment_letter_5638.pdf', 'RNCHRMMIG198004-C-102_allotment_letter_5638.pdf', 2, '2026-03-20 09:24:36'),
(116, 13, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-102/BrajKishorePrasad/RNCHRMMIG198004-C-102_agreement_copy_4183.pdf', 'RNCHRMMIG198004-C-102_agreement_copy_4183.pdf', 2, '2026-03-20 09:26:46'),
(117, 13, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 09:30:21'),
(118, 13, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 09:30:29'),
(119, 13, 6, '1551', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-102/BrajKishorePrasad/RNCHRMMIG198004-C-102_final_calculation_3835.pdf', 'RNCHRMMIG198004-C-102_final_calculation_3835.pdf', 2, '2026-03-20 09:31:23'),
(120, 13, 7, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 09:32:15'),
(121, 13, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 09:34:58'),
(122, 13, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-102/BrajKishorePrasad/RNCHRMMIG198004-C-102_property_map_9151.pdf', 'RNCHRMMIG198004-C-102_property_map_9151.pdf', 2, '2026-03-20 09:36:00'),
(123, 13, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-102/BrajKishorePrasad/RNCHRMMIG198004-C-102_noting_sheet_2841.pdf', 'RNCHRMMIG198004-C-102_noting_sheet_2841.pdf', 2, '2026-03-20 09:38:07'),
(124, 17, 1, '126882', NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 10:54:58'),
(125, 17, 2, '4166', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/08/Plot/MIG/C-8/KamalaNandPradhan/RNCHRMMIG198208-C-8_allotment_letter_4750.pdf', 'RNCHRMMIG198208-C-8_allotment_letter_4750.pdf', 4, '2026-03-20 10:56:04'),
(126, 17, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/08/Plot/MIG/C-8/KamalaNandPradhan/RNCHRMMIG198208-C-8_agreement_copy_3706.pdf', 'RNCHRMMIG198208-C-8_agreement_copy_3706.pdf', 4, '2026-03-20 10:56:38'),
(127, 17, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 10:56:45'),
(128, 17, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 10:56:53'),
(129, 17, 6, '103', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/08/Plot/MIG/C-8/KamalaNandPradhan/RNCHRMMIG198208-C-8_final_calculation_3116.pdf', 'RNCHRMMIG198208-C-8_final_calculation_3116.pdf', 4, '2026-03-20 10:57:41'),
(130, 17, 7, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 10:57:57'),
(131, 17, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 10:58:10'),
(132, 17, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/08/Plot/MIG/C-8/KamalaNandPradhan/RNCHRMMIG198208-C-8_property_map_2326.pdf', 'RNCHRMMIG198208-C-8_property_map_2326.pdf', 4, '2026-03-20 10:58:27'),
(133, 17, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/08/Plot/MIG/C-8/KamalaNandPradhan/RNCHRMMIG198208-C-8_noting_sheet_2326.pdf', 'RNCHRMMIG198208-C-8_noting_sheet_2326.pdf', 4, '2026-03-20 10:58:48'),
(134, 16, 1, '126852', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/08/Plot/MIG/C-9/TrilokiNathJaiswal/RNCHRMMIG198108-C-9_application_letter_4021.pdf', 'RNCHRMMIG198108-C-9_application_letter_4021.pdf', 2, '2026-03-20 11:04:48'),
(135, 16, 2, '6656', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/08/Plot/MIG/C-9/TrilokiNathJaiswal/RNCHRMMIG198108-C-9_allotment_letter_3722.pdf', 'RNCHRMMIG198108-C-9_allotment_letter_3722.pdf', 2, '2026-03-20 11:06:15'),
(136, 16, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/08/Plot/MIG/C-9/TrilokiNathJaiswal/RNCHRMMIG198108-C-9_agreement_copy_8717.pdf', 'RNCHRMMIG198108-C-9_agreement_copy_8717.pdf', 2, '2026-03-20 11:10:26'),
(137, 18, 9, '178', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/08/Plot/MIG/C-8/UmeshPradhan/RNCHRMMIG200408-C-8_name_transfer_request_4166.pdf', 'RNCHRMMIG200408-C-8_name_transfer_request_4166.pdf', 4, '2026-03-20 11:10:39'),
(138, 16, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:10:42'),
(139, 16, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:10:51'),
(140, 18, 10, '2751', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/08/Plot/MIG/C-8/UmeshPradhan/RNCHRMMIG200408-C-8_name_transfer_forwarding_5159.pdf', 'RNCHRMMIG200408-C-8_name_transfer_forwarding_5159.pdf', 4, '2026-03-20 11:11:39'),
(141, 18, 11, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:12:02'),
(142, 18, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:12:09'),
(143, 18, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/08/Plot/MIG/C-8/UmeshPradhan/RNCHRMMIG200408-C-8_site_verification_5513.pdf', 'RNCHRMMIG200408-C-8_site_verification_5513.pdf', 4, '2026-03-20 11:12:26'),
(144, 18, 14, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:12:50'),
(145, 18, 15, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2004/08/Plot/MIG/C-8/UmeshPradhan/RNCHRMMIG200408-C-8_name_transfer_confirmation_1157.pdf', 'RNCHRMMIG200408-C-8_name_transfer_confirmation_1157.pdf', 4, '2026-03-20 11:13:32'),
(146, 18, 16, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:13:43'),
(147, 16, 6, '2052', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/08/Plot/MIG/C-9/TrilokiNathJaiswal/RNCHRMMIG198108-C-9_final_calculation_4230.pdf', 'RNCHRMMIG198108-C-9_final_calculation_4230.pdf', 2, '2026-03-20 11:13:53'),
(148, 18, 17, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:13:54'),
(149, 16, 7, '2537', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/08/Plot/MIG/C-9/TrilokiNathJaiswal/RNCHRMMIG198108-C-9_noc_before_registry_1889.pdf', 'RNCHRMMIG198108-C-9_noc_before_registry_1889.pdf', 2, '2026-03-20 11:15:54'),
(150, 16, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:25:35'),
(151, 16, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/08/Plot/MIG/C-9/TrilokiNathJaiswal/RNCHRMMIG198108-C-9_property_map_5211.pdf', 'RNCHRMMIG198108-C-9_property_map_5211.pdf', 2, '2026-03-20 11:26:27'),
(152, 16, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/08/Plot/MIG/C-9/TrilokiNathJaiswal/RNCHRMMIG198108-C-9_noting_sheet_7810.pdf', 'RNCHRMMIG198108-C-9_noting_sheet_7810.pdf', 2, '2026-03-20 11:28:50'),
(153, 19, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2005/02/Plot/MIG/C-8/MayaSinha/RNCHRMMIG200502-C-8_name_transfer_request_6791.pdf', 'RNCHRMMIG200502-C-8_name_transfer_request_6791.pdf', 4, '2026-03-20 11:30:11'),
(154, 19, 10, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:33:37'),
(155, 19, 11, '2781', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2005/02/Plot/MIG/C-8/MayaSinha/RNCHRMMIG200502-C-8_dividend_calculation_4445.pdf', 'RNCHRMMIG200502-C-8_dividend_calculation_4445.pdf', 4, '2026-03-20 11:34:31'),
(156, 19, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:34:55'),
(157, 19, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2005/02/Plot/MIG/C-8/MayaSinha/RNCHRMMIG200502-C-8_site_verification_8437.pdf', 'RNCHRMMIG200502-C-8_site_verification_8437.pdf', 4, '2026-03-20 11:35:03'),
(158, 19, 14, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2005/02/Plot/MIG/C-8/MayaSinha/RNCHRMMIG200502-C-8_noc_letter_3834.pdf', 'RNCHRMMIG200502-C-8_noc_letter_3834.pdf', 4, '2026-03-20 11:35:50'),
(159, 19, 15, '747', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2005/02/Plot/MIG/C-8/MayaSinha/RNCHRMMIG200502-C-8_name_transfer_confirmation_5697.pdf', 'RNCHRMMIG200502-C-8_name_transfer_confirmation_5697.pdf', 4, '2026-03-20 11:37:10'),
(160, 19, 16, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2005/02/Plot/MIG/C-8/MayaSinha/RNCHRMMIG200502-C-8_ground_rent_2453.pdf', 'RNCHRMMIG200502-C-8_ground_rent_2453.pdf', 4, '2026-03-20 11:37:19'),
(161, 19, 17, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2005/02/Plot/MIG/C-8/MayaSinha/RNCHRMMIG200502-C-8_name_transfer_registry_deed_7909.pdf', 'RNCHRMMIG200502-C-8_name_transfer_registry_deed_7909.pdf', 4, '2026-03-20 11:37:31'),
(162, 20, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2001/06/Plot/MIG/C-9/ParvinderJitSingh/RNCHRMMIG200106-C-9_name_transfer_request_2362.pdf', 'RNCHRMMIG200106-C-9_name_transfer_request_2362.pdf', 2, '2026-03-20 11:41:00'),
(163, 20, 10, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:41:08'),
(164, 20, 11, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:43:10'),
(165, 20, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:43:22'),
(166, 20, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2001/06/Plot/MIG/C-9/ParvinderJitSingh/RNCHRMMIG200106-C-9_site_verification_9900.pdf', 'RNCHRMMIG200106-C-9_site_verification_9900.pdf', 2, '2026-03-20 11:44:19'),
(167, 20, 14, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:46:56'),
(168, 20, 15, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:47:06'),
(169, 20, 16, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:47:19'),
(170, 20, 17, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 11:47:29'),
(171, 21, 1, '125695', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/03/Plot/MIG/C-97/AwadheshKumarRoy/RNCHRMMIG197903-C-97_application_letter_9009.pdf', 'RNCHRMMIG197903-C-97_application_letter_9009.pdf', 4, '2026-03-20 11:50:52'),
(172, 21, 2, '734', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/03/Plot/MIG/C-97/AwadheshKumarRoy/RNCHRMMIG197903-C-97_allotment_letter_8182.pdf', 'RNCHRMMIG197903-C-97_allotment_letter_8182.pdf', 4, '2026-03-20 11:55:27'),
(173, 21, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/03/Plot/MIG/C-97/AwadheshKumarRoy/RNCHRMMIG197903-C-97_agreement_copy_8971.pdf', 'RNCHRMMIG197903-C-97_agreement_copy_8971.pdf', 4, '2026-03-20 11:56:05'),
(174, 21, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:56:15'),
(175, 21, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:56:21'),
(176, 21, 6, '1802', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/03/Plot/MIG/C-97/AwadheshKumarRoy/RNCHRMMIG197903-C-97_final_calculation_5562.pdf', 'RNCHRMMIG197903-C-97_final_calculation_5562.pdf', 4, '2026-03-20 11:56:57'),
(177, 21, 7, '1701', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/03/Plot/MIG/C-97/AwadheshKumarRoy/RNCHRMMIG197903-C-97_noc_before_registry_9989.pdf', 'RNCHRMMIG197903-C-97_noc_before_registry_9989.pdf', 4, '2026-03-20 11:57:39'),
(178, 21, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 11:57:51'),
(179, 21, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/03/Plot/MIG/C-97/AwadheshKumarRoy/RNCHRMMIG197903-C-97_property_map_5415.pdf', 'RNCHRMMIG197903-C-97_property_map_5415.pdf', 4, '2026-03-20 11:57:57'),
(180, 21, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/03/Plot/MIG/C-97/AwadheshKumarRoy/RNCHRMMIG197903-C-97_noting_sheet_6284.pdf', 'RNCHRMMIG197903-C-97_noting_sheet_6284.pdf', 4, '2026-03-20 11:58:05'),
(181, 22, 1, '115690', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_application_letter_3358.pdf', 'RNCHRMMIG198112-C-126_application_letter_3358.pdf', 2, '2026-03-20 12:07:14'),
(182, 23, 9, '668', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/07/Plot/MIG/C-97/AnilKumarSinha/RNCHRMMIG199607-C-97_name_transfer_request_9877.pdf', 'RNCHRMMIG199607-C-97_name_transfer_request_9877.pdf', 4, '2026-03-20 12:07:49'),
(183, 23, 10, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/07/Plot/MIG/C-97/AnilKumarSinha/RNCHRMMIG199607-C-97_name_transfer_forwarding_8109.pdf', 'RNCHRMMIG199607-C-97_name_transfer_forwarding_8109.pdf', 4, '2026-03-20 12:08:45'),
(184, 23, 11, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:09:02'),
(185, 23, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:09:16'),
(186, 22, 2, '8878', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_allotment_letter_1196.pdf', 'RNCHRMMIG198112-C-126_allotment_letter_1196.pdf', 2, '2026-03-20 12:09:29'),
(187, 23, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/07/Plot/MIG/C-97/AnilKumarSinha/RNCHRMMIG199607-C-97_site_verification_4305.pdf', 'RNCHRMMIG199607-C-97_site_verification_4305.pdf', 4, '2026-03-20 12:09:31'),
(188, 23, 14, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/07/Plot/MIG/C-97/AnilKumarSinha/RNCHRMMIG199607-C-97_noc_letter_8538.pdf', 'RNCHRMMIG199607-C-97_noc_letter_8538.pdf', 4, '2026-03-20 12:09:42'),
(189, 23, 15, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/07/Plot/MIG/C-97/AnilKumarSinha/RNCHRMMIG199607-C-97_name_transfer_confirmation_8372.pdf', 'RNCHRMMIG199607-C-97_name_transfer_confirmation_8372.pdf', 4, '2026-03-20 12:10:25'),
(190, 23, 16, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:10:39'),
(191, 23, 17, '842', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/07/Plot/MIG/C-97/AnilKumarSinha/RNCHRMMIG199607-C-97_name_transfer_registry_deed_5166.pdf', 'RNCHRMMIG199607-C-97_name_transfer_registry_deed_5166.pdf', 4, '2026-03-20 12:11:27'),
(192, 22, 3, '24', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_agreement_copy_9116.pdf', 'RNCHRMMIG198112-C-126_agreement_copy_9116.pdf', 2, '2026-03-20 12:14:31'),
(193, 22, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 12:15:10'),
(194, 22, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 12:15:17'),
(195, 22, 6, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 12:15:37'),
(196, 22, 7, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 12:15:50'),
(197, 22, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 12:16:01'),
(198, 22, 18, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 12:16:41'),
(199, 22, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_noting_sheet_3169.pdf', 'RNCHRMMIG198112-C-126_noting_sheet_3169.pdf', 2, '2026-03-20 12:17:41'),
(200, 25, 1, '110553', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/03/Plot/MIG/C-3/ChandraShekharSinha/RNCHRMMIG197803-C-3_application_letter_1834.pdf', 'RNCHRMMIG197803-C-3_application_letter_1834.pdf', 4, '2026-03-20 12:21:05'),
(201, 25, 2, '1013', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/03/Plot/MIG/C-3/ChandraShekharSinha/RNCHRMMIG197803-C-3_allotment_letter_3785.pdf', 'RNCHRMMIG197803-C-3_allotment_letter_3785.pdf', 4, '2026-03-20 12:21:43'),
(202, 25, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/03/Plot/MIG/C-3/ChandraShekharSinha/RNCHRMMIG197803-C-3_agreement_copy_1081.pdf', 'RNCHRMMIG197803-C-3_agreement_copy_1081.pdf', 4, '2026-03-20 12:22:59'),
(203, 25, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:23:07'),
(204, 25, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:23:24'),
(205, 25, 6, '5406', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/03/Plot/MIG/C-3/ChandraShekharSinha/RNCHRMMIG197803-C-3_final_calculation_3680.pdf', 'RNCHRMMIG197803-C-3_final_calculation_3680.pdf', 4, '2026-03-20 12:24:08'),
(206, 25, 7, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/03/Plot/MIG/C-3/ChandraShekharSinha/RNCHRMMIG197803-C-3_noc_before_registry_1311.pdf', 'RNCHRMMIG197803-C-3_noc_before_registry_1311.pdf', 4, '2026-03-20 12:24:42'),
(207, 25, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:25:01'),
(208, 25, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/03/Plot/MIG/C-3/ChandraShekharSinha/RNCHRMMIG197803-C-3_property_map_3234.pdf', 'RNCHRMMIG197803-C-3_property_map_3234.pdf', 4, '2026-03-20 12:25:09'),
(209, 25, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/03/Plot/MIG/C-3/ChandraShekharSinha/RNCHRMMIG197803-C-3_noting_sheet_4972.pdf', 'RNCHRMMIG197803-C-3_noting_sheet_4972.pdf', 4, '2026-03-20 12:25:15'),
(210, 27, 1, '127001', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/03/Plot/MIG/C-29/RamKritSingh/RNCHRMMIG198003-C-29_application_letter_3999.pdf', 'RNCHRMMIG198003-C-29_application_letter_3999.pdf', 4, '2026-03-20 12:34:17'),
(211, 27, 2, '1477', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/03/Plot/MIG/C-29/RamKritSingh/RNCHRMMIG198003-C-29_allotment_letter_3843.pdf', 'RNCHRMMIG198003-C-29_allotment_letter_3843.pdf', 4, '2026-03-20 12:34:51'),
(212, 27, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/03/Plot/MIG/C-29/RamKritSingh/RNCHRMMIG198003-C-29_agreement_copy_1784.pdf', 'RNCHRMMIG198003-C-29_agreement_copy_1784.pdf', 4, '2026-03-20 12:35:47'),
(213, 27, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:35:57'),
(214, 27, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:36:04'),
(215, 27, 6, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:36:37'),
(216, 27, 7, '2602', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/03/Plot/MIG/C-29/RamKritSingh/RNCHRMMIG198003-C-29_noc_before_registry_2494.pdf', 'RNCHRMMIG198003-C-29_noc_before_registry_2494.pdf', 4, '2026-03-20 12:37:52'),
(217, 27, 8, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/03/Plot/MIG/C-29/RamKritSingh/RNCHRMMIG198003-C-29_registry_deed_4249.pdf', 'RNCHRMMIG198003-C-29_registry_deed_4249.pdf', 4, '2026-03-20 12:38:28'),
(218, 27, 18, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:38:52'),
(219, 27, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/03/Plot/MIG/C-29/RamKritSingh/RNCHRMMIG198003-C-29_noting_sheet_9159.pdf', 'RNCHRMMIG198003-C-29_noting_sheet_9159.pdf', 4, '2026-03-20 12:39:08'),
(220, 26, 1, '127440', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-49/RanjitSinghJayswal/RNCHRMMIG197807-C-49_application_letter_1242.pdf', 'RNCHRMMIG197807-C-49_application_letter_1242.pdf', 2, '2026-03-20 12:46:03'),
(221, 26, 2, '1714', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-49/RanjitSinghJayswal/RNCHRMMIG197807-C-49_allotment_letter_8845.pdf', 'RNCHRMMIG197807-C-49_allotment_letter_8845.pdf', 2, '2026-03-20 12:47:18'),
(222, 26, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-49/RanjitSinghJayswal/RNCHRMMIG197807-C-49_agreement_copy_3430.pdf', 'RNCHRMMIG197807-C-49_agreement_copy_3430.pdf', 2, '2026-03-20 12:48:04'),
(223, 26, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 12:48:25'),
(224, 26, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-20 12:48:38'),
(225, 24, 1, '126327', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/06/Plot/MIG/C-91/BhagwatiPrasadSharma/RNCHRMMIG199606-C-91_application_letter_7187.pdf', 'RNCHRMMIG199606-C-91_application_letter_7187.pdf', 4, '2026-03-20 12:48:54'),
(226, 26, 6, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-49/RanjitSinghJayswal/RNCHRMMIG197807-C-49_final_calculation_2114.pdf', 'RNCHRMMIG197807-C-49_final_calculation_2114.pdf', 2, '2026-03-20 12:49:58'),
(227, 24, 2, '4454', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/06/Plot/MIG/C-91/BhagwatiPrasadSharma/RNCHRMMIG199606-C-91_allotment_letter_5971.pdf', 'RNCHRMMIG199606-C-91_allotment_letter_5971.pdf', 4, '2026-03-20 12:50:35'),
(228, 26, 7, '59', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-49/RanjitSinghJayswal/RNCHRMMIG197807-C-49_noc_before_registry_1067.pdf', 'RNCHRMMIG197807-C-49_noc_before_registry_1067.pdf', 2, '2026-03-20 12:51:14'),
(229, 26, 8, '1607', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-49/RanjitSinghJayswal/RNCHRMMIG197807-C-49_registry_deed_3155.pdf', 'RNCHRMMIG197807-C-49_registry_deed_3155.pdf', 2, '2026-03-20 12:54:24'),
(230, 24, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/06/Plot/MIG/C-91/BhagwatiPrasadSharma/RNCHRMMIG199606-C-91_agreement_copy_7148.pdf', 'RNCHRMMIG199606-C-91_agreement_copy_7148.pdf', 4, '2026-03-20 12:54:54'),
(231, 26, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-49/RanjitSinghJayswal/RNCHRMMIG197807-C-49_property_map_7325.pdf', 'RNCHRMMIG197807-C-49_property_map_7325.pdf', 2, '2026-03-20 12:55:50'),
(232, 26, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/07/Plot/MIG/C-49/RanjitSinghJayswal/RNCHRMMIG197807-C-49_noting_sheet_1220.pdf', 'RNCHRMMIG197807-C-49_noting_sheet_1220.pdf', 2, '2026-03-20 12:56:25'),
(233, 24, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:57:01'),
(234, 24, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:57:16'),
(235, 24, 6, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-20 12:57:29'),
(236, 24, 7, '1531', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/06/Plot/MIG/C-91/BhagwatiPrasadSharma/RNCHRMMIG199606-C-91_noc_before_registry_6850.pdf', 'RNCHRMMIG199606-C-91_noc_before_registry_6850.pdf', 4, '2026-03-20 12:58:23'),
(237, 24, 8, '2884', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/06/Plot/MIG/C-91/BhagwatiPrasadSharma/RNCHRMMIG199606-C-91_registry_deed_7617.pdf', 'RNCHRMMIG199606-C-91_registry_deed_7617.pdf', 4, '2026-03-20 13:00:02'),
(238, 24, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/06/Plot/MIG/C-91/BhagwatiPrasadSharma/RNCHRMMIG199606-C-91_property_map_1000.pdf', 'RNCHRMMIG199606-C-91_property_map_1000.pdf', 4, '2026-03-20 13:01:31'),
(239, 24, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1996/06/Plot/MIG/C-91/BhagwatiPrasadSharma/RNCHRMMIG199606-C-91_noting_sheet_7391.pdf', 'RNCHRMMIG199606-C-91_noting_sheet_7391.pdf', 4, '2026-03-20 13:01:59'),
(240, 28, 1, '119354', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1983/06/Plot/MIG/C-32/NawalKishorePrasad/RNCHRMMIG198306-C-32_application_letter_5915.pdf', 'RNCHRMMIG198306-C-32_application_letter_5915.pdf', 4, '2026-03-21 05:25:09'),
(241, 28, 2, '2158', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1983/06/Plot/MIG/C-32/NawalKishorePrasad/RNCHRMMIG198306-C-32_allotment_letter_1243.pdf', 'RNCHRMMIG198306-C-32_allotment_letter_1243.pdf', 4, '2026-03-21 05:25:58'),
(242, 28, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1983/06/Plot/MIG/C-32/NawalKishorePrasad/RNCHRMMIG198306-C-32_agreement_copy_1699.pdf', 'RNCHRMMIG198306-C-32_agreement_copy_1699.pdf', 4, '2026-03-21 05:29:53'),
(243, 28, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 05:30:21'),
(244, 28, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 05:30:30'),
(245, 28, 6, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 05:34:18'),
(246, 28, 7, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1983/06/Plot/MIG/C-32/NawalKishorePrasad/RNCHRMMIG198306-C-32_noc_before_registry_1266.pdf', 'RNCHRMMIG198306-C-32_noc_before_registry_1266.pdf', 4, '2026-03-21 05:34:51'),
(247, 28, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 05:35:05'),
(248, 28, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1983/06/Plot/MIG/C-32/NawalKishorePrasad/RNCHRMMIG198306-C-32_property_map_7636.pdf', 'RNCHRMMIG198306-C-32_property_map_7636.pdf', 4, '2026-03-21 05:35:52'),
(249, 28, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1983/06/Plot/MIG/C-32/NawalKishorePrasad/RNCHRMMIG198306-C-32_noting_sheet_4600.pdf', 'RNCHRMMIG198306-C-32_noting_sheet_4600.pdf', 4, '2026-03-21 05:36:01'),
(250, 30, 1, '110568', NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 05:47:02'),
(251, 30, 2, '8855', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-131/BirendraKumarKhanna/RNCHRMMIG198112-C-131_allotment_letter_8932.pdf', 'RNCHRMMIG198112-C-131_allotment_letter_8932.pdf', 4, '2026-03-21 05:47:45'),
(252, 30, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-131/BirendraKumarKhanna/RNCHRMMIG198112-C-131_agreement_copy_6504.pdf', 'RNCHRMMIG198112-C-131_agreement_copy_6504.pdf', 4, '2026-03-21 05:48:57'),
(253, 29, 1, '228572', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/08/Plot/MIG/C-100/AmarNathJha/RNCHRMMIG197908-C-100_application_letter_3360.pdf', 'RNCHRMMIG197908-C-100_application_letter_3360.pdf', 2, '2026-03-21 05:59:24'),
(254, 29, 2, '1772', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/08/Plot/MIG/C-100/AmarNathJha/RNCHRMMIG197908-C-100_allotment_letter_6223.pdf', 'RNCHRMMIG197908-C-100_allotment_letter_6223.pdf', 2, '2026-03-21 06:00:27'),
(255, 30, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 06:01:12'),
(256, 30, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 06:01:19'),
(257, 29, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/08/Plot/MIG/C-100/AmarNathJha/RNCHRMMIG197908-C-100_agreement_copy_6784.pdf', 'RNCHRMMIG197908-C-100_agreement_copy_6784.pdf', 2, '2026-03-21 06:01:30'),
(258, 29, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 06:02:21'),
(259, 29, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 06:02:29'),
(260, 29, 6, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 06:03:03'),
(261, 29, 7, '940', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/08/Plot/MIG/C-100/AmarNathJha/RNCHRMMIG197908-C-100_noc_before_registry_7423.pdf', 'RNCHRMMIG197908-C-100_noc_before_registry_7423.pdf', 2, '2026-03-21 06:06:04'),
(262, 29, 8, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/08/Plot/MIG/C-100/AmarNathJha/RNCHRMMIG197908-C-100_registry_deed_3758.pdf', 'RNCHRMMIG197908-C-100_registry_deed_3758.pdf', 2, '2026-03-21 06:09:21'),
(263, 29, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/08/Plot/MIG/C-100/AmarNathJha/RNCHRMMIG197908-C-100_property_map_6192.pdf', 'RNCHRMMIG197908-C-100_property_map_6192.pdf', 2, '2026-03-21 06:09:54'),
(264, 29, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1979/08/Plot/MIG/C-100/AmarNathJha/RNCHRMMIG197908-C-100_noting_sheet_6923.pdf', 'RNCHRMMIG197908-C-100_noting_sheet_6923.pdf', 2, '2026-03-21 06:10:27'),
(265, 30, 6, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-131/BirendraKumarKhanna/RNCHRMMIG198112-C-131_final_calculation_3314.pdf', 'RNCHRMMIG198112-C-131_final_calculation_3314.pdf', 2, '2026-03-21 06:13:52'),
(266, 30, 7, '2877', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-131/BirendraKumarKhanna/RNCHRMMIG198112-C-131_noc_before_registry_9277.pdf', 'RNCHRMMIG198112-C-131_noc_before_registry_9277.pdf', 2, '2026-03-21 06:14:16'),
(267, 30, 8, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-131/BirendraKumarKhanna/RNCHRMMIG198112-C-131_registry_deed_5525.pdf', 'RNCHRMMIG198112-C-131_registry_deed_5525.pdf', 2, '2026-03-21 06:14:27'),
(268, 30, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-131/BirendraKumarKhanna/RNCHRMMIG198112-C-131_property_map_6054.pdf', 'RNCHRMMIG198112-C-131_property_map_6054.pdf', 2, '2026-03-21 06:14:37'),
(269, 30, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-131/BirendraKumarKhanna/RNCHRMMIG198112-C-131_noting_sheet_6222.pdf', 'RNCHRMMIG198112-C-131_noting_sheet_6222.pdf', 2, '2026-03-21 06:14:51'),
(270, 31, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1999/10/Plot/MIG/C-131/SheelaJha/RNCHRMMIG199910-C-131_name_transfer_request_6357.pdf', 'RNCHRMMIG199910-C-131_name_transfer_request_6357.pdf', 2, '2026-03-21 06:18:56'),
(271, 31, 10, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 06:19:31'),
(272, 31, 11, '1448', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1999/10/Plot/MIG/C-131/SheelaJha/RNCHRMMIG199910-C-131_dividend_calculation_7859.pdf', 'RNCHRMMIG199910-C-131_dividend_calculation_7859.pdf', 2, '2026-03-21 06:21:09'),
(273, 31, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 06:21:23'),
(274, 31, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1999/10/Plot/MIG/C-131/SheelaJha/RNCHRMMIG199910-C-131_site_verification_5305.pdf', 'RNCHRMMIG199910-C-131_site_verification_5305.pdf', 2, '2026-03-21 06:22:04'),
(275, 31, 14, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 06:22:21'),
(276, 31, 15, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 06:22:58'),
(277, 31, 16, '53', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1999/10/Plot/MIG/C-131/SheelaJha/RNCHRMMIG199910-C-131_ground_rent_6969.pdf', 'RNCHRMMIG199910-C-131_ground_rent_6969.pdf', 2, '2026-03-21 06:23:45'),
(278, 31, 17, '2044', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1999/10/Plot/MIG/C-131/SheelaJha/RNCHRMMIG199910-C-131_name_transfer_registry_deed_5678.pdf', 'RNCHRMMIG199910-C-131_name_transfer_registry_deed_5678.pdf', 2, '2026-03-21 06:24:18'),
(279, 32, 1, '127559', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/08/Plot/MIG/C-94/Ram ChandraPrasadGupta/RNCHRMMIG197808-C-94_application_letter_8001.pdf', 'RNCHRMMIG197808-C-94_application_letter_8001.pdf', 4, '2026-03-21 06:50:49');
INSERT INTO `allottee_documents` (`id`, `allottee_id`, `document_id`, `doc_no`, `doc_day`, `doc_month`, `doc_year`, `additional_info`, `remarks`, `file_path`, `file_name`, `uploaded_by`, `created_at`) VALUES
(280, 32, 2, '2551', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/08/Plot/MIG/C-94/Ram ChandraPrasadGupta/RNCHRMMIG197808-C-94_allotment_letter_4076.pdf', 'RNCHRMMIG197808-C-94_allotment_letter_4076.pdf', 4, '2026-03-21 06:54:46'),
(281, 32, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/08/Plot/MIG/C-94/Ram ChandraPrasadGupta/RNCHRMMIG197808-C-94_agreement_copy_6343.pdf', 'RNCHRMMIG197808-C-94_agreement_copy_6343.pdf', 4, '2026-03-21 06:56:12'),
(282, 32, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 06:56:22'),
(283, 32, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 06:56:28'),
(284, 32, 6, '275', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/08/Plot/MIG/C-94/Ram ChandraPrasadGupta/RNCHRMMIG197808-C-94_final_calculation_2020.pdf', 'RNCHRMMIG197808-C-94_final_calculation_2020.pdf', 4, '2026-03-21 06:57:26'),
(285, 32, 7, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 06:58:05'),
(286, 32, 8, '2012', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/08/Plot/MIG/C-94/Ram ChandraPrasadGupta/RNCHRMMIG197808-C-94_registry_deed_6369.pdf', 'RNCHRMMIG197808-C-94_registry_deed_6369.pdf', 4, '2026-03-21 07:01:21'),
(287, 32, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/08/Plot/MIG/C-94/Ram ChandraPrasadGupta/RNCHRMMIG197808-C-94_property_map_3459.pdf', 'RNCHRMMIG197808-C-94_property_map_3459.pdf', 4, '2026-03-21 07:01:32'),
(288, 32, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1978/08/Plot/MIG/C-94/Ram ChandraPrasadGupta/RNCHRMMIG197808-C-94_noting_sheet_8296.pdf', 'RNCHRMMIG197808-C-94_noting_sheet_8296.pdf', 4, '2026-03-21 07:01:39'),
(289, 33, 1, '110564', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/09/Plot/MIG/C-84/BijoyNandanSahay/RNCHRMMIG198209-C-84_application_letter_2653.pdf', 'RNCHRMMIG198209-C-84_application_letter_2653.pdf', 2, '2026-03-21 07:04:46'),
(290, 33, 2, '313', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/09/Plot/MIG/C-84/BijoyNandanSahay/RNCHRMMIG198209-C-84_allotment_letter_1853.pdf', 'RNCHRMMIG198209-C-84_allotment_letter_1853.pdf', 2, '2026-03-21 07:07:01'),
(291, 33, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/09/Plot/MIG/C-84/BijoyNandanSahay/RNCHRMMIG198209-C-84_agreement_copy_4646.pdf', 'RNCHRMMIG198209-C-84_agreement_copy_4646.pdf', 2, '2026-03-21 07:08:08'),
(292, 33, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 07:08:30'),
(293, 33, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 07:08:38'),
(294, 33, 6, '982', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/09/Plot/MIG/C-84/BijoyNandanSahay/RNCHRMMIG198209-C-84_final_calculation_4331.pdf', 'RNCHRMMIG198209-C-84_final_calculation_4331.pdf', 2, '2026-03-21 07:10:23'),
(295, 33, 7, '2268', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/09/Plot/MIG/C-84/BijoyNandanSahay/RNCHRMMIG198209-C-84_noc_before_registry_9857.pdf', 'RNCHRMMIG198209-C-84_noc_before_registry_9857.pdf', 2, '2026-03-21 07:11:37'),
(296, 33, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 07:12:06'),
(297, 33, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/09/Plot/MIG/C-84/BijoyNandanSahay/RNCHRMMIG198209-C-84_property_map_5966.pdf', 'RNCHRMMIG198209-C-84_property_map_5966.pdf', 2, '2026-03-21 07:12:39'),
(298, 33, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/09/Plot/MIG/C-84/BijoyNandanSahay/RNCHRMMIG198209-C-84_noting_sheet_4218.pdf', 'RNCHRMMIG198209-C-84_noting_sheet_4218.pdf', 2, '2026-03-21 07:13:25'),
(299, 35, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2000/10/Plot/MIG/C-84/AshokKumarMangal/RNCHRMMIG200010-C-84_name_transfer_request_2500.pdf', 'RNCHRMMIG200010-C-84_name_transfer_request_2500.pdf', 2, '2026-03-21 07:38:44'),
(300, 35, 10, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 07:39:43'),
(301, 35, 11, '5738', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2000/10/Plot/MIG/C-84/AshokKumarMangal/RNCHRMMIG200010-C-84_dividend_calculation_3719.pdf', 'RNCHRMMIG200010-C-84_dividend_calculation_3719.pdf', 2, '2026-03-21 07:40:52'),
(302, 35, 12, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 07:41:04'),
(303, 35, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2000/10/Plot/MIG/C-84/AshokKumarMangal/RNCHRMMIG200010-C-84_site_verification_8884.pdf', 'RNCHRMMIG200010-C-84_site_verification_8884.pdf', 2, '2026-03-21 07:42:00'),
(304, 34, 1, '180785', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/01/Plot/MIG/C-116/GajendraJha/RNCHRMMIG198201-C-116_application_letter_2517.pdf', 'RNCHRMMIG198201-C-116_application_letter_2517.pdf', 4, '2026-03-21 07:45:49'),
(305, 35, 14, '2134', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2000/10/Plot/MIG/C-84/AshokKumarMangal/RNCHRMMIG200010-C-84_noc_letter_5455.pdf', 'RNCHRMMIG200010-C-84_noc_letter_5455.pdf', 2, '2026-03-21 07:46:03'),
(306, 35, 15, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 07:46:18'),
(307, 34, 2, '672', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/01/Plot/MIG/C-116/GajendraJha/RNCHRMMIG198201-C-116_allotment_letter_6200.pdf', 'RNCHRMMIG198201-C-116_allotment_letter_6200.pdf', 4, '2026-03-21 07:46:33'),
(308, 35, 16, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 07:46:37'),
(309, 34, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/01/Plot/MIG/C-116/GajendraJha/RNCHRMMIG198201-C-116_agreement_copy_1405.pdf', 'RNCHRMMIG198201-C-116_agreement_copy_1405.pdf', 4, '2026-03-21 07:47:13'),
(310, 34, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 07:47:24'),
(311, 34, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 07:47:30'),
(312, 34, 6, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 07:47:40'),
(313, 34, 7, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 07:47:47'),
(314, 34, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 07:47:58'),
(315, 34, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/01/Plot/MIG/C-116/GajendraJha/RNCHRMMIG198201-C-116_property_map_9049.pdf', 'RNCHRMMIG198201-C-116_property_map_9049.pdf', 4, '2026-03-21 07:48:10'),
(316, 34, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1982/01/Plot/MIG/C-116/GajendraJha/RNCHRMMIG198201-C-116_noting_sheet_4691.pdf', 'RNCHRMMIG198201-C-116_noting_sheet_4691.pdf', 4, '2026-03-21 07:48:16'),
(317, 35, 17, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/2000/10/Plot/MIG/C-84/AshokKumarMangal/RNCHRMMIG200010-C-84_name_transfer_registry_deed_9258.pdf', 'RNCHRMMIG200010-C-84_name_transfer_registry_deed_9258.pdf', 2, '2026-03-21 07:53:33'),
(318, 36, 1, '128583', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-79/AnilKumarSrivastava/RNCHRMMIG198004-C-79_application_letter_7679.pdf', 'RNCHRMMIG198004-C-79_application_letter_7679.pdf', 4, '2026-03-21 08:37:33'),
(319, 36, 2, '2369', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-79/AnilKumarSrivastava/RNCHRMMIG198004-C-79_allotment_letter_1098.pdf', 'RNCHRMMIG198004-C-79_allotment_letter_1098.pdf', 4, '2026-03-21 08:38:16'),
(320, 37, 1, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 08:38:28'),
(321, 36, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-79/AnilKumarSrivastava/RNCHRMMIG198004-C-79_agreement_copy_7066.pdf', 'RNCHRMMIG198004-C-79_agreement_copy_7066.pdf', 4, '2026-03-21 08:39:00'),
(322, 36, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 08:39:10'),
(323, 36, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 08:39:17'),
(324, 36, 6, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-79/AnilKumarSrivastava/RNCHRMMIG198004-C-79_final_calculation_2029.pdf', 'RNCHRMMIG198004-C-79_final_calculation_2029.pdf', 4, '2026-03-21 08:39:31'),
(325, 37, 2, '2406', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_allotment_letter_9648.pdf', 'RNCHRMMIG199109-C-35_allotment_letter_9648.pdf', 2, '2026-03-21 08:40:06'),
(326, 36, 7, '1532', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-79/AnilKumarSrivastava/RNCHRMMIG198004-C-79_noc_before_registry_7752.pdf', 'RNCHRMMIG198004-C-79_noc_before_registry_7752.pdf', 4, '2026-03-21 08:40:38'),
(327, 37, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_agreement_copy_1537.pdf', 'RNCHRMMIG199109-C-35_agreement_copy_1537.pdf', 2, '2026-03-21 08:41:32'),
(328, 37, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 08:41:45'),
(329, 36, 8, '4101', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-79/AnilKumarSrivastava/RNCHRMMIG198004-C-79_registry_deed_8198.pdf', 'RNCHRMMIG198004-C-79_registry_deed_8198.pdf', 4, '2026-03-21 08:41:48'),
(330, 37, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 08:41:55'),
(331, 36, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-79/AnilKumarSrivastava/RNCHRMMIG198004-C-79_property_map_2299.pdf', 'RNCHRMMIG198004-C-79_property_map_2299.pdf', 4, '2026-03-21 08:42:19'),
(332, 36, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1980/04/Plot/MIG/C-79/AnilKumarSrivastava/RNCHRMMIG198004-C-79_noting_sheet_6651.pdf', 'RNCHRMMIG198004-C-79_noting_sheet_6651.pdf', 4, '2026-03-21 08:42:26'),
(333, 37, 6, '1684', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_final_calculation_6789.pdf', 'RNCHRMMIG199109-C-35_final_calculation_6789.pdf', 2, '2026-03-21 08:42:47'),
(334, 37, 7, '1272', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_noc_before_registry_2645.pdf', 'RNCHRMMIG199109-C-35_noc_before_registry_2645.pdf', 2, '2026-03-21 08:43:30'),
(335, 37, 8, '2483', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_registry_deed_3075.pdf', 'RNCHRMMIG199109-C-35_registry_deed_3075.pdf', 2, '2026-03-21 08:45:05'),
(336, 37, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_property_map_2547.pdf', 'RNCHRMMIG199109-C-35_property_map_2547.pdf', 2, '2026-03-21 08:45:44'),
(337, 37, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1991/09/Plot/MIG/C-35/BhriguPrasadSingh/RNCHRMMIG199109-C-35_noting_sheet_4525.pdf', 'RNCHRMMIG199109-C-35_noting_sheet_4525.pdf', 2, '2026-03-21 08:45:59'),
(338, 38, 1, '115690', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_application_letter_8670.pdf', 'RNCHRMMIG198112-C-126_application_letter_8670.pdf', 4, '2026-03-21 08:51:46'),
(339, 38, 2, '8878', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_allotment_letter_4350.pdf', 'RNCHRMMIG198112-C-126_allotment_letter_4350.pdf', 4, '2026-03-21 08:52:55'),
(340, 38, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_agreement_copy_9360.pdf', 'RNCHRMMIG198112-C-126_agreement_copy_9360.pdf', 4, '2026-03-21 08:53:28'),
(341, 38, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 08:53:36'),
(342, 38, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 08:53:42'),
(343, 38, 6, '1170', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_final_calculation_1918.pdf', 'RNCHRMMIG198112-C-126_final_calculation_1918.pdf', 4, '2026-03-21 08:54:49'),
(344, 38, 7, '862', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_noc_before_registry_1765.pdf', 'RNCHRMMIG198112-C-126_noc_before_registry_1765.pdf', 4, '2026-03-21 08:55:32'),
(345, 38, 8, '1059', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_registry_deed_2392.pdf', 'RNCHRMMIG198112-C-126_registry_deed_2392.pdf', 4, '2026-03-21 08:57:07'),
(346, 38, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_property_map_4371.pdf', 'RNCHRMMIG198112-C-126_property_map_4371.pdf', 4, '2026-03-21 08:57:21'),
(347, 38, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-126/NageshwarMahto/RNCHRMMIG198112-C-126_noting_sheet_6227.pdf', 'RNCHRMMIG198112-C-126_noting_sheet_6227.pdf', 4, '2026-03-21 08:57:28'),
(348, 39, 1, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 09:00:18'),
(349, 40, 1, '115410', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayanandPrasad/RNCHRMMIG198112-C-127_application_letter_9320.pdf', 'RNCHRMMIG198112-C-127_application_letter_9320.pdf', 4, '2026-03-21 09:07:45'),
(350, 40, 2, '8877', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayanandPrasad/RNCHRMMIG198112-C-127_allotment_letter_4638.pdf', 'RNCHRMMIG198112-C-127_allotment_letter_4638.pdf', 4, '2026-03-21 09:08:18'),
(351, 40, 3, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 09:08:31'),
(352, 40, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 09:08:43'),
(353, 40, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 09:08:50'),
(354, 40, 6, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayanandPrasad/RNCHRMMIG198112-C-127_final_calculation_8839.pdf', 'RNCHRMMIG198112-C-127_final_calculation_8839.pdf', 4, '2026-03-21 09:09:26'),
(355, 40, 7, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 09:09:34'),
(356, 40, 8, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 4, '2026-03-21 09:09:42'),
(357, 40, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayanandPrasad/RNCHRMMIG198112-C-127_property_map_8605.pdf', 'RNCHRMMIG198112-C-127_property_map_8605.pdf', 4, '2026-03-21 09:10:13'),
(358, 40, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/12/Plot/MIG/C-127/DayanandPrasad/RNCHRMMIG198112-C-127_noting_sheet_8864.pdf', 'RNCHRMMIG198112-C-127_noting_sheet_8864.pdf', 4, '2026-03-21 09:10:22'),
(359, 39, 2, '2946', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/05/Plot/MIG/C-96/RamaPatiChakhaiyar/RNCHRMMIG198105-C-96_allotment_letter_4744.pdf', 'RNCHRMMIG198105-C-96_allotment_letter_4744.pdf', 2, '2026-03-21 09:15:40'),
(360, 39, 3, '6105', NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/05/Plot/MIG/C-96/RamaPatiChakhaiyar/RNCHRMMIG198105-C-96_agreement_copy_1865.pdf', 'RNCHRMMIG198105-C-96_agreement_copy_1865.pdf', 2, '2026-03-21 09:16:58'),
(361, 39, 4, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 09:17:40'),
(362, 39, 5, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, NULL, 2, '2026-03-21 09:17:55'),
(363, 39, 6, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/05/Plot/MIG/C-96/RamaPatiChakhaiyar/RNCHRMMIG198105-C-96_final_calculation_1395.pdf', 'RNCHRMMIG198105-C-96_final_calculation_1395.pdf', 2, '2026-03-21 09:18:54'),
(364, 39, 7, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/05/Plot/MIG/C-96/RamaPatiChakhaiyar/RNCHRMMIG198105-C-96_noc_before_registry_6549.pdf', 'RNCHRMMIG198105-C-96_noc_before_registry_6549.pdf', 2, '2026-03-21 09:20:10'),
(365, 39, 8, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/05/Plot/MIG/C-96/RamaPatiChakhaiyar/RNCHRMMIG198105-C-96_registry_deed_2332.pdf', 'RNCHRMMIG198105-C-96_registry_deed_2332.pdf', 2, '2026-03-21 09:21:06'),
(366, 39, 18, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/05/Plot/MIG/C-96/RamaPatiChakhaiyar/RNCHRMMIG198105-C-96_property_map_3672.pdf', 'RNCHRMMIG198105-C-96_property_map_3672.pdf', 2, '2026-03-21 09:21:36'),
(367, 39, 19, NULL, NULL, NULL, NULL, NULL, NULL, 'documents/RNC/HRM/Residential/1981/05/Plot/MIG/C-96/RamaPatiChakhaiyar/RNCHRMMIG198105-C-96_noting_sheet_2056.pdf', 'RNCHRMMIG198105-C-96_noting_sheet_2056.pdf', 2, '2026-03-21 09:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `allottee_emi_ledger`
--

CREATE TABLE `allottee_emi_ledger` (
  `id` bigint(20) NOT NULL,
  `allottee_id` bigint(20) DEFAULT NULL,
  `calculation_type` varchar(100) DEFAULT NULL,
  `total_amount` varchar(20) DEFAULT NULL,
  `total_emi_count` varchar(10) DEFAULT NULL,
  `start_month` varchar(10) DEFAULT NULL,
  `start_year` varchar(10) DEFAULT NULL,
  `last_emi_month` varchar(20) DEFAULT NULL,
  `last_emi_year` varchar(10) DEFAULT NULL,
  `amount_without_penalty` varchar(20) DEFAULT NULL,
  `amount_with_penalty` varchar(20) DEFAULT NULL,
  `without_penalty_count` varchar(10) DEFAULT NULL,
  `with_penalty_count` varchar(10) DEFAULT NULL,
  `completed_emi` varchar(10) DEFAULT NULL,
  `late_emi` varchar(10) DEFAULT NULL,
  `remaining_emi` varchar(10) DEFAULT NULL,
  `total_paid` varchar(20) DEFAULT NULL,
  `total_remaining` varchar(20) DEFAULT NULL,
  `current_balance` varchar(20) DEFAULT NULL,
  `emi_status` varchar(50) DEFAULT NULL,
  `expected_emi` varchar(10) DEFAULT NULL,
  `payment_gap` varchar(10) DEFAULT NULL,
  `emi_active` varchar(5) DEFAULT NULL,
  `emi_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`emi_config`)),
  `emi_inputs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`emi_inputs`)),
  `emi_timeline` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`emi_timeline`)),
  `emi_calculated` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`emi_calculated`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allottee_emi_ledger`
--

INSERT INTO `allottee_emi_ledger` (`id`, `allottee_id`, `calculation_type`, `total_amount`, `total_emi_count`, `start_month`, `start_year`, `last_emi_month`, `last_emi_year`, `amount_without_penalty`, `amount_with_penalty`, `without_penalty_count`, `with_penalty_count`, `completed_emi`, `late_emi`, `remaining_emi`, `total_paid`, `total_remaining`, `current_balance`, `emi_status`, `expected_emi`, `payment_gap`, `emi_active`, `emi_config`, `emi_inputs`, `emi_timeline`, `emi_calculated`, `created_at`, `updated_at`) VALUES
(1, 2, 'manual', '9007', '60', '8', '1979', 'July', '1984', '185', '196', '0', '0', '60', '0', '0', '11100', '0', '11100', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":9007,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"8\\\",\\\"startYear\\\":\\\"1979\\\",\\\"amountWithoutPenalty\\\":185,\\\"amountWithPenalty\\\":196,\\\"lastEmiMonth\\\":\\\"July\\\",\\\"lastEmiYear\\\":\\\"1984\\\",\\\"endDate\\\":\\\"July 1984\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 05:08:39', '2026-03-20 05:08:39'),
(2, 1, 'manual', '8850', '60', '5', '1980', 'April', '1985', '182', '193', '0', '0', '60', '0', '0', '10920', '0', '10920', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":8850,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"5\\\",\\\"startYear\\\":\\\"1980\\\",\\\"amountWithoutPenalty\\\":182,\\\"amountWithPenalty\\\":193,\\\"lastEmiMonth\\\":\\\"April\\\",\\\"lastEmiYear\\\":\\\"1985\\\",\\\"endDate\\\":\\\"April 1985\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 05:20:19', '2026-03-20 05:20:19'),
(3, 5, 'manual', '116466', '60', '1', '2001', 'December', '2005', '2390', '2533', '0', '0', '60', '0', '0', '143400', '0', '143400', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":116466,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"1\\\",\\\"startYear\\\":\\\"2001\\\",\\\"amountWithoutPenalty\\\":2390,\\\"amountWithPenalty\\\":2533,\\\"lastEmiMonth\\\":\\\"December\\\",\\\"lastEmiYear\\\":\\\"2005\\\",\\\"endDate\\\":\\\"December 2005\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 06:34:19', '2026-03-20 06:34:19'),
(4, 6, 'manual', '8576', '60', '6', '1978', 'May', '1983', '176', '187', '0', '0', '60', '0', '0', '10560', '0', '10560', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":8576,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"6\\\",\\\"startYear\\\":\\\"1978\\\",\\\"amountWithoutPenalty\\\":176,\\\"amountWithPenalty\\\":187,\\\"lastEmiMonth\\\":\\\"May\\\",\\\"lastEmiYear\\\":\\\"1983\\\",\\\"endDate\\\":\\\"May 1983\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 06:50:33', '2026-03-20 06:50:33'),
(5, 7, 'manual', '9862', '60', '9', '1978', 'August', '1983', '203', '215', '0', '0', '60', '0', '0', '12180', '0', '12180', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":9862,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"9\\\",\\\"startYear\\\":\\\"1978\\\",\\\"amountWithoutPenalty\\\":203,\\\"amountWithPenalty\\\":215,\\\"lastEmiMonth\\\":\\\"August\\\",\\\"lastEmiYear\\\":\\\"1983\\\",\\\"endDate\\\":\\\"August 1983\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 07:46:11', '2026-03-20 07:46:11'),
(6, 9, 'manual', '35970', '60', '10', '1991', 'September', '1996', '738', '783', '0', '0', '60', '0', '0', '44280', '0', '44280', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":35970,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"10\\\",\\\"startYear\\\":\\\"1991\\\",\\\"amountWithoutPenalty\\\":738,\\\"amountWithPenalty\\\":783,\\\"lastEmiMonth\\\":\\\"September\\\",\\\"lastEmiYear\\\":\\\"1996\\\",\\\"endDate\\\":\\\"September 1996\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 08:51:27', '2026-03-20 08:51:27'),
(7, 12, 'manual', '11040', '36', '11', '1990', 'October', '1993', '349', '362', '0', '0', '36', '0', '0', '12564', '0', '12564', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":11040,\\\"totalCount\\\":36,\\\"startMonth\\\":\\\"11\\\",\\\"startYear\\\":\\\"1990\\\",\\\"amountWithoutPenalty\\\":349,\\\"amountWithPenalty\\\":362,\\\"lastEmiMonth\\\":\\\"October\\\",\\\"lastEmiYear\\\":\\\"1993\\\",\\\"endDate\\\":\\\"October 1993\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 09:05:59', '2026-03-20 09:05:59'),
(8, 13, 'manual', '8850', '60', '4', '1980', 'March', '1985', '182', '193', '0', '0', '60', '0', '0', '10920', '0', '10920', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":8850,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"4\\\",\\\"startYear\\\":\\\"1980\\\",\\\"amountWithoutPenalty\\\":182,\\\"amountWithPenalty\\\":193,\\\"lastEmiMonth\\\":\\\"March\\\",\\\"lastEmiYear\\\":\\\"1985\\\",\\\"endDate\\\":\\\"March 1985\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 09:38:11', '2026-03-20 09:38:11'),
(9, 17, 'manual', '7206', '60', '1', '1999', 'December', '2003', '148', '157', '0', '0', '60', '0', '0', '8880', '0', '8880', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":7206,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"1\\\",\\\"startYear\\\":\\\"1999\\\",\\\"amountWithoutPenalty\\\":148,\\\"amountWithPenalty\\\":157,\\\"lastEmiMonth\\\":\\\"December\\\",\\\"lastEmiYear\\\":\\\"2003\\\",\\\"endDate\\\":\\\"December 2003\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 10:56:11', '2026-03-20 10:56:11'),
(10, 16, 'manual', '10560', '36', '6', '1983', 'May', '1986', '334', '346', '0', '0', '36', '0', '0', '12024', '0', '12024', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":10560,\\\"totalCount\\\":36,\\\"startMonth\\\":\\\"6\\\",\\\"startYear\\\":\\\"1983\\\",\\\"amountWithoutPenalty\\\":334,\\\"amountWithPenalty\\\":346,\\\"lastEmiMonth\\\":\\\"May\\\",\\\"lastEmiYear\\\":\\\"1986\\\",\\\"endDate\\\":\\\"May 1986\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 11:28:54', '2026-03-20 11:28:54'),
(11, 21, 'manual', '7206', '36', '7', '1979', 'June', '1982', '228', '236', '0', '0', '36', '0', '0', '8208', '0', '8208', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":7206,\\\"totalCount\\\":36,\\\"startMonth\\\":\\\"7\\\",\\\"startYear\\\":\\\"1979\\\",\\\"amountWithoutPenalty\\\":228,\\\"amountWithPenalty\\\":236,\\\"lastEmiMonth\\\":\\\"June\\\",\\\"lastEmiYear\\\":\\\"1982\\\",\\\"endDate\\\":\\\"June 1982\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 11:56:59', '2026-03-20 11:56:59'),
(12, 22, 'manual', '12600', '60', '1', '1982', 'December', '1986', '259', '274', '0', '0', '60', '0', '0', '15540', '0', '15540', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":12600,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"1\\\",\\\"startYear\\\":\\\"1982\\\",\\\"amountWithoutPenalty\\\":259,\\\"amountWithPenalty\\\":274,\\\"lastEmiMonth\\\":\\\"December\\\",\\\"lastEmiYear\\\":\\\"1986\\\",\\\"endDate\\\":\\\"December 1986\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 12:17:48', '2026-03-20 12:17:48'),
(13, 25, 'manual', '7890', '36', '5', '1978', 'April', '1981', '250', '259', '0', '0', '36', '0', '0', '9000', '0', '9000', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":7890,\\\"totalCount\\\":36,\\\"startMonth\\\":\\\"5\\\",\\\"startYear\\\":\\\"1978\\\",\\\"amountWithoutPenalty\\\":250,\\\"amountWithPenalty\\\":259,\\\"lastEmiMonth\\\":\\\"April\\\",\\\"lastEmiYear\\\":\\\"1981\\\",\\\"endDate\\\":\\\"April 1981\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 12:21:53', '2026-03-20 12:21:53'),
(14, 27, 'manual', '9450', '60', '5', '1980', 'April', '1985', '194', '206', '0', '0', '60', '0', '0', '11640', '0', '11640', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":9450,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"5\\\",\\\"startYear\\\":\\\"1980\\\",\\\"amountWithoutPenalty\\\":194,\\\"amountWithPenalty\\\":206,\\\"lastEmiMonth\\\":\\\"April\\\",\\\"lastEmiYear\\\":\\\"1985\\\",\\\"endDate\\\":\\\"April 1985\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 12:34:55', '2026-03-20 12:34:55'),
(15, 26, 'manual', '9002', '60', '8', '1978', 'July', '1983', '185', '196', '0', '0', '60', '0', '0', '11100', '0', '11100', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":9002,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"8\\\",\\\"startYear\\\":\\\"1978\\\",\\\"amountWithoutPenalty\\\":185,\\\"amountWithPenalty\\\":196,\\\"lastEmiMonth\\\":\\\"July\\\",\\\"lastEmiYear\\\":\\\"1983\\\",\\\"endDate\\\":\\\"July 1983\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 12:55:52', '2026-03-20 12:55:52'),
(16, 24, 'manual', '12450', '60', '7', '1996', 'June', '2001', '256', '271', '0', '0', '60', '0', '0', '15360', '0', '15360', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":12450,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"7\\\",\\\"startYear\\\":\\\"1996\\\",\\\"amountWithoutPenalty\\\":256,\\\"amountWithPenalty\\\":271,\\\"lastEmiMonth\\\":\\\"June\\\",\\\"lastEmiYear\\\":\\\"2001\\\",\\\"endDate\\\":\\\"June 2001\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-20 13:02:13', '2026-03-20 13:02:13'),
(17, 28, 'manual', '14850', '60', '8', '1983', 'July', '1988', '305', '323', '0', '0', '60', '0', '0', '18300', '0', '18300', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":14850,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"8\\\",\\\"startYear\\\":\\\"1983\\\",\\\"amountWithoutPenalty\\\":305,\\\"amountWithPenalty\\\":323,\\\"lastEmiMonth\\\":\\\"July\\\",\\\"lastEmiYear\\\":\\\"1988\\\",\\\"endDate\\\":\\\"July 1988\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 05:29:38', '2026-03-21 05:29:38'),
(18, 30, 'manual', '14475', '60', '1', '1997', 'December', '2001', '297', '315', '0', '0', '60', '0', '0', '17820', '0', '17820', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":14475,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"1\\\",\\\"startYear\\\":\\\"1997\\\",\\\"amountWithoutPenalty\\\":297,\\\"amountWithPenalty\\\":315,\\\"lastEmiMonth\\\":\\\"December\\\",\\\"lastEmiYear\\\":\\\"2001\\\",\\\"endDate\\\":\\\"December 2001\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 05:47:53', '2026-03-21 05:47:53'),
(19, 29, 'manual', '9862', '60', '10', '1979', 'September', '1984', '203', '215', '0', '0', '60', '0', '0', '12180', '0', '12180', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":9862,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"10\\\",\\\"startYear\\\":\\\"1979\\\",\\\"amountWithoutPenalty\\\":203,\\\"amountWithPenalty\\\":215,\\\"lastEmiMonth\\\":\\\"September\\\",\\\"lastEmiYear\\\":\\\"1984\\\",\\\"endDate\\\":\\\"September 1984\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 06:10:57', '2026-03-21 06:10:57'),
(20, 32, 'manual', '8576', '60', '8', '1979', 'July', '1984', '176', '187', '0', '0', '60', '0', '0', '10560', '0', '10560', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":8576,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"8\\\",\\\"startYear\\\":\\\"1979\\\",\\\"amountWithoutPenalty\\\":176,\\\"amountWithPenalty\\\":187,\\\"lastEmiMonth\\\":\\\"July\\\",\\\"lastEmiYear\\\":\\\"1984\\\",\\\"endDate\\\":\\\"July 1984\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 06:54:52', '2026-03-21 06:54:52'),
(21, 33, 'manual', '13200', '60', '2', '1991', 'January', '1996', '271', '287', '0', '0', '60', '0', '0', '16260', '0', '16260', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":13200,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"2\\\",\\\"startYear\\\":\\\"1991\\\",\\\"amountWithoutPenalty\\\":271,\\\"amountWithPenalty\\\":287,\\\"lastEmiMonth\\\":\\\"January\\\",\\\"lastEmiYear\\\":\\\"1996\\\",\\\"endDate\\\":\\\"January 1996\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 07:13:31', '2026-03-21 07:13:31'),
(22, 34, 'manual', '13500', '60', '3', '1982', 'February', '1987', '277', '294', '0', '0', '60', '0', '0', '16620', '0', '16620', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":13500,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"3\\\",\\\"startYear\\\":\\\"1982\\\",\\\"amountWithoutPenalty\\\":277,\\\"amountWithPenalty\\\":294,\\\"lastEmiMonth\\\":\\\"February\\\",\\\"lastEmiYear\\\":\\\"1987\\\",\\\"endDate\\\":\\\"February 1987\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 07:46:36', '2026-03-21 07:46:36'),
(23, 36, 'manual', '8850', '60', '8', '1981', 'July', '1986', '182', '193', '0', '0', '60', '0', '0', '10920', '0', '10920', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":8850,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"8\\\",\\\"startYear\\\":\\\"1981\\\",\\\"amountWithoutPenalty\\\":182,\\\"amountWithPenalty\\\":193,\\\"lastEmiMonth\\\":\\\"July\\\",\\\"lastEmiYear\\\":\\\"1986\\\",\\\"endDate\\\":\\\"July 1986\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 08:38:21', '2026-03-21 08:38:21'),
(24, 37, 'manual', '35970', '60', '10', '1991', 'September', '1996', '738', '783', '0', '0', '60', '0', '0', '44280', '0', '44280', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":35970,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"10\\\",\\\"startYear\\\":\\\"1991\\\",\\\"amountWithoutPenalty\\\":738,\\\"amountWithPenalty\\\":783,\\\"lastEmiMonth\\\":\\\"September\\\",\\\"lastEmiYear\\\":\\\"1996\\\",\\\"endDate\\\":\\\"September 1996\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 08:46:12', '2026-03-21 08:46:12'),
(25, 38, 'manual', '12600', '60', '4', '1983', 'March', '1988', '259', '274', '0', '0', '60', '0', '0', '15540', '0', '15540', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":12600,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"4\\\",\\\"startYear\\\":\\\"1983\\\",\\\"amountWithoutPenalty\\\":259,\\\"amountWithPenalty\\\":274,\\\"lastEmiMonth\\\":\\\"March\\\",\\\"lastEmiYear\\\":\\\"1988\\\",\\\"endDate\\\":\\\"March 1988\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 08:52:58', '2026-03-21 08:52:58'),
(26, 40, 'manual', '11040', '36', '1', '1982', 'December', '1984', '349', '362', '0', '0', '36', '0', '0', '12564', '0', '12564', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":11040,\\\"totalCount\\\":36,\\\"startMonth\\\":\\\"1\\\",\\\"startYear\\\":\\\"1982\\\",\\\"amountWithoutPenalty\\\":349,\\\"amountWithPenalty\\\":362,\\\"lastEmiMonth\\\":\\\"December\\\",\\\"lastEmiYear\\\":\\\"1984\\\",\\\"endDate\\\":\\\"December 1984\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 09:08:33', '2026-03-21 09:08:33'),
(27, 39, 'manual', '13200', '60', '9', '1981', 'August', '1986', '271', '287', '0', '0', '60', '0', '0', '16260', '0', '16260', 'Close', '0', '0', 'no', '\"{\\\"totalAmount\\\":13200,\\\"totalCount\\\":60,\\\"startMonth\\\":\\\"9\\\",\\\"startYear\\\":\\\"1981\\\",\\\"amountWithoutPenalty\\\":271,\\\"amountWithPenalty\\\":287,\\\"lastEmiMonth\\\":\\\"August\\\",\\\"lastEmiYear\\\":\\\"1986\\\",\\\"endDate\\\":\\\"August 1986\\\"}\"', '\"{\\\"manual\\\":{\\\"totalCount\\\":0,\\\"expectedCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"penaltyAmount\\\":0,\\\"withoutPenaltyAmount\\\":0,\\\"totalPaid\\\":0,\\\"totalBalance\\\":0,\\\"status\\\":\\\"Pending\\\"},\\\"auto\\\":{\\\"withoutPenaltyCount\\\":0,\\\"withPenaltyCount\\\":0,\\\"completedCount\\\":0,\\\"lateCount\\\":0,\\\"remainingCount\\\":0,\\\"totalPaid\\\":0,\\\"totalRemaining\\\":0,\\\"currentBalance\\\":0,\\\"status\\\":\\\"Pending\\\",\\\"expectedCount\\\":0,\\\"paymentGap\\\":0,\\\"penaltyApplied\\\":false}}\"', NULL, NULL, '2026-03-21 09:22:19', '2026-03-21 09:22:19');

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
(1, 27, 'Shri', NULL, NULL, NULL, NULL, 'Shri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, '117.233.180.137', NULL, '2026-03-20 12:39:57', '2026-03-20 12:39:57'),
(2, 40, 'Shri', NULL, NULL, NULL, NULL, 'Shri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, '117.233.180.137', NULL, '2026-03-20 12:40:33', '2026-03-23 06:42:35');

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
  `deposit_type` varchar(100) DEFAULT 'amount',
  `high_income_percent` decimal(5,2) DEFAULT NULL,
  `low_income_percent` decimal(5,2) DEFAULT NULL,
  `deposited_amount` decimal(12,2) DEFAULT NULL,
  `legal_fee` decimal(10,2) DEFAULT NULL COMMENT 'As EMD Amount',
  `legal_document_fee` decimal(10,2) DEFAULT NULL COMMENT 'As Administration Fee',
  `total_payment` decimal(12,2) DEFAULT NULL,
  `interim_price` decimal(12,2) DEFAULT NULL,
  `remaining_amount` decimal(12,2) DEFAULT NULL,
  `payment_months` int(11) DEFAULT NULL,
  `payment_start_month` tinyint(4) DEFAULT NULL,
  `payment_start_year` year(4) DEFAULT NULL,
  `last_payment_due_date` varchar(50) DEFAULT NULL,
  `interest_calculation_mode` varchar(100) DEFAULT NULL,
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

INSERT INTO `allottee_property_fin_details` (`id`, `allottee_id`, `tentative_price`, `amount_words`, `maav_day`, `maav_month`, `maav_year`, `deposit_type`, `high_income_percent`, `low_income_percent`, `deposited_amount`, `legal_fee`, `legal_document_fee`, `total_payment`, `interim_price`, `remaining_amount`, `payment_months`, `payment_start_month`, `payment_start_year`, `last_payment_due_date`, `interest_calculation_mode`, `interest_type`, `pre_interest`, `late_interest`, `pre_interest_amount`, `late_interest_amount`, `allot_day`, `allot_month`, `allot_year`, `lottery_details`, `colony_name`, `plot_number`, `area_sqft`, `mohalla`, `post_office`, `city`, `police_station`, `state`, `district`, `north_boundary`, `south_boundary`, `east_boundary`, `west_boundary`, `ew_north`, `ew_south`, `ns_east`, `ns_west`, `specified_days`, `last_day`, `last_month`, `last_year`, `created_ip`, `updated_ip`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 12010.00, 'Twelve Thousand Ten Only', NULL, NULL, NULL, 'amount', NULL, NULL, 3003.00, 1500.00, 150.00, NULL, NULL, 9007.00, 60, 8, '1979', NULL, NULL, 'compound', 8.50, 11.00, 185.00, 196.00, 3, 6, '1979', NULL, 'Harmu Housing Colony', 'C-37', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, 'C-36', 'C-38', 'C-58', '40 ft Wide Road', '75', '75', '41', '41', '30 days', 30, 8, '1979', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 05:03:52', '2026-03-20 05:18:41'),
(2, 1, 11800.00, 'Eleven Thousand Eight Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 2950.00, 3100.00, 150.00, NULL, NULL, 8850.00, 60, 5, '1980', NULL, NULL, 'compound', 8.50, 11.00, 182.00, 193.00, 26, 4, '1980', NULL, 'Harmu Housing Colony', 'C-87', 278.81, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, 'C-88', 'C-86', 'Road', 'C-76', '75', '75', '40', '40', '30 days', 30, 5, '1980', '117.233.180.137', NULL, 2, NULL, '2026-03-20 05:04:51', '2026-03-20 05:04:51'),
(3, 5, 166381.00, 'One Lakh Sixty Six Thousand Three Hundred Eighty One Only', NULL, NULL, NULL, 'amount', NULL, NULL, 49915.00, 1500.00, 200.00, NULL, NULL, 116466.00, 60, 1, '2001', NULL, NULL, 'compound', 8.50, 11.00, 2390.00, 2533.00, 14, 10, '1998', NULL, 'Harmu Housing Colony', 'C-86', 3075.00, 'Harmu', 'Harmu', 'Ranchi', 'Argora', 15, 281, 'C-87', 'C-85', '40 ft Wide Road', 'C-79', '75', '75', '41', '41', '30 days', 30, 1, '2001', '117.233.180.137', NULL, 4, NULL, '2026-03-20 06:25:17', '2026-03-20 06:25:17'),
(4, 6, 11435.00, 'Eleven Thousand Four Hundred Thirty Five Only', NULL, NULL, NULL, 'amount', NULL, NULL, 2859.00, 150.00, 3009.00, NULL, NULL, 8576.00, 60, 6, '1978', NULL, NULL, 'compound', 8.50, 11.00, 176.00, 187.00, 17, 7, '1978', NULL, 'Harmu Housing Colony', 'C-44', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, 'C-43', 'C-45', 'C-51', 'Road', '75', '75', '41', '41', '30 days', 30, 6, '1978', '117.233.180.137', NULL, 2, NULL, '2026-03-20 06:34:18', '2026-03-20 06:34:18'),
(5, 7, 13150.00, 'Thirteen Thousand One Hundred Fifty Only', NULL, NULL, NULL, 'amount', NULL, NULL, 3288.00, 3000.00, 150.00, NULL, NULL, 9862.00, 60, 9, '1978', NULL, NULL, 'compound', 8.50, 11.00, 203.00, 215.00, 12, 7, '1978', NULL, 'Harmu Housing Colony', 'C-67', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Harmu', 15, 281, 'Vaccant Land', 'C-68', 'C-98', '60 ft Wide Road', '75', '75', '41', '41', '30 days', 30, 9, '1978', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 07:26:55', '2026-03-20 07:50:31'),
(6, 9, 51386.00, 'Fifty One Thousand Three Hundred Eighty Six Only', NULL, NULL, NULL, 'amount', NULL, NULL, 15416.00, 0.00, 200.00, NULL, NULL, 35970.00, 60, 10, '1991', NULL, NULL, 'compound', 8.50, 11.00, 738.00, 783.00, 17, 9, '1991', NULL, 'Harmu Housing Colony', 'C-35', 3075.00, 'Harmu', 'Harmu', 'Ranchi', 'Argora', 15, 281, NULL, NULL, NULL, NULL, '41', '41', '75', '75', '30 days', 30, 10, '1991', '117.233.180.137', NULL, 2, NULL, '2026-03-20 08:37:34', '2026-03-20 08:37:34'),
(7, 12, 18400.00, 'Eighteen Thousand Four Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 7360.00, 1500.00, 150.00, NULL, NULL, 11040.00, 36, 11, '1990', NULL, NULL, 'compound', 8.50, 11.00, 349.00, 362.00, 2, 12, '1981', NULL, 'Harmu Housing Colony', 'C-127', 278.81, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, 'Vacant Plot', '60 ft Wide Road', 'C-128', 'C-126', '75', '75', '40', '40', '30 days', 30, 11, '1990', '117.233.180.137', NULL, 4, NULL, '2026-03-20 09:04:33', '2026-03-20 09:04:33'),
(8, 13, 11800.00, 'Eleven Thousand Eight Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 2950.00, 3100.00, 150.00, NULL, NULL, 8850.00, 60, 4, '1980', NULL, NULL, 'compound', 8.50, 11.00, 182.00, 193.00, 26, 4, '1980', NULL, 'Harmu Housing Colony', 'C-102', 278.81, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, 'Road', 'C-121', 'C-103', 'C-101', '40', '40', '75', '75', '30 days', 30, 4, '1980', '117.233.180.137', NULL, 2, NULL, '2026-03-20 09:22:29', '2026-03-20 09:22:29'),
(9, 17, 12010.00, 'Twelve Thousand Ten Only', NULL, NULL, NULL, 'amount', NULL, NULL, 4804.00, 1500.00, 150.00, NULL, NULL, 7206.00, 60, 1, '1999', NULL, NULL, 'compound', 8.50, 11.00, 148.00, 157.00, 28, 8, '1982', NULL, 'Harmu Housing Colony', 'C-8', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, '60 ft Wide Road', 'C-23', 'C-9', 'C-7', '41', '41', '75', '75', '30 days', 30, 1, '1999', '117.233.180.137', NULL, 4, NULL, '2026-03-20 10:54:17', '2026-03-20 10:54:17'),
(10, 16, 17600.00, 'Seventeen Thousand Six Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 7040.00, 1500.00, 150.00, NULL, NULL, 10560.00, 36, 6, '1983', NULL, NULL, 'compound', 8.50, 11.00, 334.00, 346.00, 28, 8, '1981', NULL, 'Harmu Housing Colony', 'C-9', 3075.00, 'Harmu', 'Harmu', 'Ranchi', 'Harmu', 15, 281, '60 ft wide road', 'C-22', 'C-10', 'C-8', '75', '75', '41', '41', '30 days', 30, 6, '1983', '117.233.180.137', NULL, 2, NULL, '2026-03-20 11:00:50', '2026-03-20 11:00:50'),
(11, 21, 12010.00, 'Twelve Thousand Ten Only', NULL, NULL, NULL, 'amount', NULL, NULL, 4804.00, 1500.00, 150.00, NULL, NULL, 7206.00, 36, 7, '1979', NULL, NULL, 'compound', 8.50, 11.00, 228.00, 236.00, 27, 3, '1979', NULL, 'Harmu Housing Colony', 'C-97', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, 'C-98', 'C-96', '40 ft Wide Road', 'C-68', '75', '75', '41', '41', '30 days', 30, 7, '1979', '117.233.180.137', NULL, 4, NULL, '2026-03-20 11:48:23', '2026-03-20 11:48:23'),
(12, 22, 16800.00, 'Sixteen Thousand Eight Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 4200.00, 1500.00, 150.00, NULL, NULL, 12600.00, 60, 1, '1982', NULL, NULL, 'compound', 8.50, 11.00, 259.00, 274.00, 2, 12, '1981', NULL, 'Harmu Housing Colony', 'C-126', 278.81, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, 'Empty Land', 'Road', 'C-125', 'C-128', '40', '40', '75', '75', '30 days', 30, 1, '1982', '117.233.180.137', NULL, 2, NULL, '2026-03-20 12:05:51', '2026-03-20 12:05:51'),
(13, 25, 13150.00, 'Thirteen Thousand One Hundred Fifty Only', NULL, NULL, NULL, 'amount', NULL, NULL, 5260.00, 1500.00, 150.00, NULL, NULL, 7890.00, 36, 5, '1978', NULL, NULL, 'compound', 8.50, 11.00, 250.00, 259.00, 6, 3, '1978', NULL, 'Harmu Housing Colony', 'C-3', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, '60 ft Wide Road', 'C-28', 'C-4', '40 ft Wide Road', '41', '41', '75', '75', '30 days', 30, 5, '1978', '117.233.180.137', NULL, 4, NULL, '2026-03-20 12:20:23', '2026-03-20 12:20:23'),
(14, 27, 12600.00, 'Twelve Thousand Six Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 3150.00, 1500.00, 150.00, NULL, NULL, 9450.00, 60, 5, '1980', NULL, NULL, 'compound', 8.50, 11.00, 194.00, 206.00, 11, 3, '1980', NULL, 'Harmu Housing Colony', 'C-29', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 15, 281, '60 ft Wide Road', 'C-30', 'C-66', '40 ft Wide Road', '75', '75', '41', '41', '30 days', 30, 5, '1980', '117.233.180.137', '117.233.180.137', 4, 4, '2026-03-20 12:33:17', '2026-03-20 12:39:54'),
(15, 24, 16600.00, 'Sixteen Thousand Six Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 2788.25, 1500.00, 150.00, NULL, NULL, 12450.00, 60, 7, '1996', NULL, NULL, 'compound', 8.50, 11.00, 256.00, 271.00, 10, 6, '1996', NULL, 'Harmu Housing Colony', 'C-91', 3000.00, 'Harmu', 'Harmu', 'Ranchi', 'Ranchi', 15, 281, 'C-92', 'C-90', 'Road', 'C-74', '40', '40', '75', '75', '60 days', 29, 8, '1996', '117.233.180.137', NULL, 4, NULL, '2026-03-20 12:40:19', '2026-03-20 12:40:19'),
(16, 26, 12010.00, 'Twelve Thousand Ten Only', NULL, NULL, NULL, 'amount', NULL, NULL, 3008.00, 1500.00, 150.00, NULL, NULL, 9002.00, 60, 8, '1978', NULL, NULL, 'compound', 8.50, 11.00, 185.00, 196.00, 15, 7, '1978', NULL, 'Harmu Housing Colony', 'C-49', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 37, 800, 'C-50', 'C-48', 'Road', 'C-46', '75', '75', '41', '41', '30 days', 30, 8, '1978', '117.233.180.137', NULL, 2, NULL, '2026-03-20 12:43:51', '2026-03-20 12:43:51'),
(17, 28, 19800.00, 'Nineteen Thousand Eight Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 4950.00, 1500.00, 150.00, NULL, NULL, 14850.00, 60, 8, '1983', NULL, NULL, 'compound', 8.50, 11.00, 305.00, 323.00, 6, 6, '1983', NULL, 'Harmu Housing Colony', 'C-32', 3075.00, 'Harmu', 'Harmu', 'Ranchi', 'Ranchi', 37, 800, 'C-31', 'C-33', 'C-63', 'Road', '41', '41', '75', '75', '30 days', 30, 8, '1983', '117.233.189.51', NULL, 4, NULL, '2026-03-21 05:20:18', '2026-03-21 05:20:18'),
(18, 30, 19300.00, 'Nineteen Thousand Three Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 4825.00, 1500.00, 150.00, NULL, NULL, 14475.00, 60, 1, '1997', NULL, NULL, 'compound', 8.50, 11.00, 297.00, 315.00, 2, 12, '1981', NULL, 'Harmu Housing Colony', 'C-131', 3430.00, 'Harmu', 'Harmu', 'Ranchi', 'Harmu', 37, 800, 'C-130', 'C-132', '60 ft Wide Road', 'C-133', '75', '75', '41', '41', '30 days', 30, 1, '1997', '117.233.189.51', NULL, 4, NULL, '2026-03-21 05:45:50', '2026-03-21 05:45:50'),
(19, 29, 13150.00, 'Thirteen Thousand One Hundred Fifty Only', NULL, NULL, NULL, 'amount', NULL, NULL, 3288.00, 1500.00, 150.00, NULL, NULL, 9862.00, 60, 10, '1979', NULL, NULL, 'compound', 8.50, 11.00, 203.00, 215.00, 31, 8, '1979', NULL, 'Harmu Housing Colony', 'C-100', 3075.00, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 37, 800, '40 ft wide Road', 'C-123', 'C-101', '60 ft wide Road', '41', '41', '75', '75', '30 days', 30, 10, '1979', '117.233.189.51', NULL, 2, NULL, '2026-03-21 05:57:49', '2026-03-21 05:57:49'),
(20, 32, 11435.00, 'Eleven Thousand Four Hundred Thirty Five Only', NULL, NULL, NULL, 'amount', NULL, NULL, 2859.00, 1500.00, 150.00, NULL, NULL, 8576.00, 60, 8, '1979', NULL, 'manual', 'compound', 8.50, 11.00, 176.00, 187.00, 11, 8, '1978', NULL, 'Harmu Housing Colony', 'C-94', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 37, 800, 'C-95', 'C-93', '40 ft Wide Road', 'C-71', '75', '75', '41', '41', '30 days', 30, 8, '1979', '117.233.189.51', '127.0.0.1', 4, 4, '2026-03-21 06:46:29', '2026-03-23 10:22:56'),
(21, 33, 17600.00, 'Seventeen Thousand Six Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 4400.00, 1500.00, 150.00, NULL, NULL, 13200.00, 60, 2, '1991', NULL, 'auto', 'compound', 8.50, 11.00, 271.00, 287.00, 15, 9, '1982', NULL, 'Harmu Housing Colony', 'C-84', 278.81, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 37, 800, 'C-85', 'C-83', 'C-81', 'Road', '75', '75', '40', '40', '30 days', 2, 3, '1991', '117.233.189.51', NULL, 2, NULL, '2026-03-21 06:58:33', '2026-03-21 06:58:33'),
(22, 34, 18000.00, 'Eighteen Thousand Only', NULL, NULL, NULL, 'amount', NULL, NULL, 4500.00, 1500.00, 150.00, NULL, NULL, 13500.00, 60, 3, '1982', NULL, 'auto', 'compound', 8.50, 11.00, 277.00, 294.00, 23, 1, '1982', NULL, 'Harmu Housing Colony', 'C-116', 285.78, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 37, 800, 'C-107', '60 ft Wide Road', 'C-115', 'C-117', '75', '75', '41', '41', '30 days', 30, 3, '1982', '117.233.189.51', NULL, 4, NULL, '2026-03-21 07:44:17', '2026-03-21 07:44:17'),
(23, 36, 11800.00, 'Eleven Thousand Eight Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 2950.00, 1500.00, 150.00, NULL, NULL, 8850.00, 60, 8, '1981', NULL, 'auto', 'compound', 8.50, 11.00, 182.00, 193.00, 15, 4, '1980', NULL, 'Harmu Housing Colony', 'C-79', 278.81, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 37, 800, 'C-78', 'C-80', 'C-86', '60 ft Wide Road', '75', '75', '41', '41', '30 days', 30, 8, '1981', '117.233.189.51', NULL, 4, NULL, '2026-03-21 08:32:51', '2026-03-21 08:32:51'),
(24, 37, 51386.00, 'Fifty One Thousand Three Hundred Eighty Six Only', NULL, NULL, NULL, 'amount', NULL, NULL, 15416.00, 0.00, 200.00, NULL, NULL, 35970.00, 60, 10, '1991', NULL, 'manual', 'compound', 8.50, 11.00, 738.00, 783.00, 17, 9, '1991', NULL, 'Harmu Housing Colony', 'C-35', 3075.00, 'Harmu', 'Harmu', 'Ranchi', 'Argora', 37, 800, 'C-36', 'C-34', 'C-60', '40 ft Wide Road', '41', '41', '75', '75', '30 days', 30, 10, '1991', '117.233.189.51', NULL, 2, NULL, '2026-03-21 08:37:39', '2026-03-21 08:37:39'),
(25, 38, 16800.00, 'Sixteen Thousand Eight Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 4200.00, 1500.00, 150.00, NULL, NULL, 12600.00, 60, 4, '1983', NULL, 'auto', 'compound', 8.50, 11.00, 259.00, 274.00, 2, 12, '1981', NULL, 'Harmu Housing Colony', 'C-126', 278.81, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 37, 800, 'Vacant Plot', '60 ft Wide Road', 'C-125', 'C-127', '40', '40', '75', '75', '30 days', 30, 4, '1983', '117.233.189.51', NULL, 4, NULL, '2026-03-21 08:50:52', '2026-03-21 08:50:52'),
(26, 39, 17600.00, 'Seventeen Thousand Six Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 4400.00, 1500.00, 150.00, NULL, NULL, 13200.00, 60, 9, '1981', NULL, 'auto', 'compound', 8.50, 11.00, 271.00, 287.00, 14, 5, '1981', NULL, 'Harmu Housing Colony', 'C-96', 278.81, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 37, 800, 'C-97', 'C-95', '40 ft wide road', 'C-65', '75', '75', '40', '40', '30 days', 30, 9, '1981', '117.233.189.51', NULL, 2, NULL, '2026-03-21 08:59:41', '2026-03-21 08:59:41'),
(27, 40, 18400.00, 'Eighteen Thousand Four Hundred Only', NULL, NULL, NULL, 'amount', NULL, NULL, 7360.00, 1500.00, 150.00, NULL, NULL, 11040.00, 36, 1, '1982', NULL, 'auto', 'compound', 8.50, 11.00, 349.00, 362.00, 2, 12, '1981', NULL, 'Harmu Housing Colony', 'C-127', 278.81, 'Harmu', 'Ranchi', 'Ranchi', 'Ranchi', 37, 800, 'Vacant Plot', '60 ft Wide Road', 'C-126', 'C-128', '75', '75', '40', '40', '30 days', 30, 1, '1982', '117.233.189.51', NULL, 4, NULL, '2026-03-21 09:06:28', '2026-03-21 09:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `allottee_step_durations`
--

CREATE TABLE `allottee_step_durations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allottee_id` bigint(20) UNSIGNED NOT NULL,
  `step_no` tinyint(4) NOT NULL,
  `started_at` varchar(100) DEFAULT NULL,
  `completed_at` varchar(100) DEFAULT NULL,
  `duration_min` int(11) DEFAULT 0,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allottee_step_durations`
--

INSERT INTO `allottee_step_durations` (`id`, `allottee_id`, `step_no`, `started_at`, `completed_at`, `duration_min`, `ip_address`, `user_agent`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 11, 1, '2026-03-20 14:09:48', '2026-03-20 14:20:03', 10, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-19 12:13:43', '2026-03-20 08:50:03'),
(2, 8, 1, '2026-03-20 14:07:24', '2026-03-20 12:37:34', 13, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-19 12:18:41', '2026-03-20 08:37:24'),
(3, 9, 1, '2026-03-20 13:34:32', '2026-03-20 13:43:15', 9, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-19 12:22:32', '2026-03-20 08:13:15'),
(4, 1, 2, '2026-03-20 10:15:09', '2026-03-20 10:23:30', 8, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-19 12:25:31', '2026-03-20 04:53:30'),
(5, 14, 1, '2026-03-20 14:46:37', '2026-03-20 14:44:20', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-19 12:25:38', '2026-03-20 09:16:37'),
(6, 2, 2, '2026-03-20 10:19:51', '2026-03-20 10:48:35', 29, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 04:49:51', '2026-03-20 05:18:35'),
(7, 1, 3, '2026-03-20 10:23:30', '2026-03-20 10:34:51', 11, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 04:53:30', '2026-03-20 05:04:51'),
(8, 2, 3, '2026-03-20 10:26:29', '2026-03-20 10:33:52', 7, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 04:56:29', '2026-03-20 05:03:52'),
(9, 2, 4, '2026-03-20 10:48:41', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 05:03:52', '2026-03-20 05:18:41'),
(10, 2, 5, '2026-03-20 10:48:59', '2026-03-20 10:49:14', 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 05:04:11', '2026-03-20 05:19:14'),
(11, 1, 4, '2026-03-20 10:34:51', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 05:04:51', '2026-03-20 05:04:51'),
(12, 1, 5, '2026-03-20 10:35:23', '2026-03-20 10:50:33', 15, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 05:05:23', '2026-03-20 05:20:33'),
(13, 2, 6, '2026-03-20 10:49:14', '2026-03-20 10:50:28', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 05:16:31', '2026-03-20 05:20:28'),
(14, 1, 6, '2026-03-20 10:50:33', '2026-03-20 10:57:42', 7, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 05:20:33', '2026-03-20 05:27:42'),
(15, 3, 2, '2026-03-20 10:58:13', '2026-03-20 11:05:23', 7, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 05:28:13', '2026-03-20 05:35:23'),
(16, 3, 3, '2026-03-20 11:05:23', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 05:30:49', '2026-03-20 05:35:23'),
(17, 3, 4, '2026-03-20 11:19:49', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 05:31:37', '2026-03-20 05:49:49'),
(18, 4, 2, '2026-03-20 11:04:54', '2026-03-20 11:07:15', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 05:34:54', '2026-03-20 05:37:15'),
(19, 4, 3, '2026-03-20 11:37:11', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 05:37:15', '2026-03-20 06:07:11'),
(20, 4, 4, '2026-03-20 11:37:16', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 06:06:57', '2026-03-20 06:07:16'),
(21, 5, 1, '2026-03-20 11:38:44', '2026-03-20 11:47:26', 9, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:08:44', '2026-03-20 06:17:26'),
(22, 5, 2, '2026-03-20 11:47:26', '2026-03-20 11:49:10', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:17:26', '2026-03-20 06:19:10'),
(23, 5, 3, '2026-03-20 11:49:10', '2026-03-20 11:55:17', 6, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:19:10', '2026-03-20 06:25:17'),
(24, 6, 2, '2026-03-20 11:49:19', '2026-03-20 12:00:00', 11, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 06:19:19', '2026-03-20 06:30:00'),
(25, 5, 4, '2026-03-20 11:55:17', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:25:17', '2026-03-20 06:25:17'),
(26, 5, 5, '2026-03-20 12:05:00', '2026-03-20 12:05:09', 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:25:40', '2026-03-20 06:35:09'),
(27, 6, 3, '2026-03-20 12:00:00', '2026-03-20 12:04:18', 4, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 06:30:00', '2026-03-20 06:34:18'),
(28, 6, 4, '2026-03-20 12:04:18', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 06:34:18', '2026-03-20 06:34:18'),
(29, 5, 6, '2026-03-20 12:05:09', '2026-03-20 12:06:02', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:34:28', '2026-03-20 06:36:02'),
(30, 6, 5, '2026-03-20 12:04:42', '2026-03-20 12:20:59', 16, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 06:34:42', '2026-03-20 06:50:59'),
(31, 15, 1, '2026-03-20 15:01:41', '2026-03-20 15:04:54', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:37:25', '2026-03-20 09:34:54'),
(32, 7, 2, '2026-03-20 12:20:13', '2026-03-20 13:20:27', 60, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:42:11', '2026-03-20 07:50:27'),
(33, 6, 6, '2026-03-20 12:21:00', '2026-03-20 12:23:59', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 06:51:00', '2026-03-20 06:53:59'),
(34, 7, 3, '2026-03-20 12:23:54', '2026-03-20 12:56:55', 33, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:53:54', '2026-03-20 07:26:55'),
(35, 8, 2, '2026-03-20 12:37:34', '2026-03-20 12:40:29', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 07:07:34', '2026-03-20 07:10:29'),
(36, 8, 3, '2026-03-20 12:51:44', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 07:10:30', '2026-03-20 07:21:44'),
(37, 8, 4, '2026-03-20 12:53:02', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 07:21:04', '2026-03-20 07:23:02'),
(38, 7, 4, '2026-03-20 13:20:31', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 07:26:55', '2026-03-20 07:50:31'),
(39, 7, 5, '2026-03-20 13:20:42', '2026-03-20 13:20:56', 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 07:27:10', '2026-03-20 07:50:56'),
(40, 7, 6, '2026-03-20 13:20:56', '2026-03-20 13:22:06', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 07:50:06', '2026-03-20 07:52:06'),
(41, 9, 2, '2026-03-20 13:43:15', '2026-03-20 13:55:15', 12, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 08:13:15', '2026-03-20 08:25:15'),
(42, 10, 2, '2026-03-20 13:48:43', '2026-03-20 13:52:44', 4, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 08:18:43', '2026-03-20 08:22:44'),
(43, 10, 3, '2026-03-20 13:52:49', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 08:22:44', '2026-03-20 08:22:49'),
(44, 9, 3, '2026-03-20 13:55:15', '2026-03-20 14:07:34', 12, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 08:25:15', '2026-03-20 08:37:34'),
(45, 10, 4, '2026-03-20 14:04:13', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 08:34:13', '2026-03-20 08:34:13'),
(46, 9, 4, '2026-03-20 14:07:34', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 08:37:34', '2026-03-20 08:37:34'),
(47, 9, 5, '2026-03-20 14:07:57', '2026-03-20 14:22:10', 14, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 08:37:57', '2026-03-20 08:52:10'),
(48, 11, 2, '2026-03-20 14:20:03', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 08:50:03', '2026-03-20 08:50:03'),
(49, 9, 6, '2026-03-20 14:22:10', '2026-03-20 14:24:37', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 08:52:10', '2026-03-20 08:54:37'),
(50, 13, 1, '2026-03-20 14:34:07', '2026-03-20 14:39:02', 5, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 08:55:02', '2026-03-20 09:09:02'),
(51, 12, 2, '2026-03-20 14:28:50', '2026-03-20 14:31:11', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 08:58:50', '2026-03-20 09:01:11'),
(52, 12, 3, '2026-03-20 14:31:11', '2026-03-20 14:34:33', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:01:11', '2026-03-20 09:04:33'),
(53, 12, 4, '2026-03-20 14:34:33', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:04:33', '2026-03-20 09:04:33'),
(54, 12, 5, '2026-03-20 14:34:46', '2026-03-20 14:40:52', 6, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:04:46', '2026-03-20 09:10:52'),
(55, 13, 2, '2026-03-20 14:39:02', '2026-03-20 14:46:30', 7, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 09:09:02', '2026-03-20 09:16:30'),
(56, 12, 6, '2026-03-20 14:40:52', '2026-03-20 14:41:59', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:10:52', '2026-03-20 09:11:59'),
(57, 14, 2, '2026-03-20 14:44:20', '2026-03-20 14:54:30', 10, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:14:20', '2026-03-20 09:24:30'),
(58, 13, 3, '2026-03-20 14:46:30', '2026-03-20 14:52:29', 6, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 09:16:30', '2026-03-20 09:22:29'),
(59, 14, 3, '2026-03-20 14:54:31', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:16:31', '2026-03-20 09:24:31'),
(60, 13, 4, '2026-03-20 14:52:29', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 09:22:29', '2026-03-20 09:22:29'),
(61, 13, 5, '2026-03-20 14:52:54', '2026-03-20 15:08:24', 16, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 09:22:48', '2026-03-20 09:38:24'),
(62, 14, 4, '2026-03-20 14:54:54', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:24:54', '2026-03-20 09:24:54'),
(63, 15, 2, '2026-03-20 15:04:54', '2026-03-20 15:08:33', 4, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:34:54', '2026-03-20 09:38:33'),
(64, 13, 6, '2026-03-20 15:08:24', '2026-03-20 15:11:50', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 09:38:24', '2026-03-20 09:41:50'),
(65, 15, 3, '2026-03-20 15:42:42', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:38:34', '2026-03-20 10:12:42'),
(66, 44, 1, '2026-03-21 16:40:10', '2026-03-21 16:59:44', 20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:47:20', '2026-03-21 11:29:44'),
(67, 20, 1, '2026-03-20 17:09:50', '2026-03-20 17:07:47', 6, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 10:37:22', '2026-03-20 11:39:50'),
(68, 16, 2, '2026-03-20 16:14:21', '2026-03-20 16:26:09', 12, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 10:44:21', '2026-03-20 10:56:09'),
(69, 19, 1, '2026-03-20 16:59:27', '2026-03-20 16:58:28', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 10:47:21', '2026-03-20 11:29:27'),
(70, 17, 2, '2026-03-20 16:19:54', '2026-03-20 16:21:23', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 10:49:54', '2026-03-20 10:51:23'),
(71, 17, 3, '2026-03-20 16:21:23', '2026-03-20 16:24:17', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 10:51:23', '2026-03-20 10:54:17'),
(72, 16, 3, '2026-03-20 16:26:10', '2026-03-20 16:30:50', 5, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 10:51:25', '2026-03-20 11:00:50'),
(73, 17, 4, '2026-03-20 16:24:17', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 10:54:17', '2026-03-20 10:54:17'),
(74, 17, 5, '2026-03-20 16:24:28', '2026-03-20 16:28:53', 4, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 10:54:28', '2026-03-20 10:58:53'),
(75, 17, 6, '2026-03-20 16:28:54', '2026-03-20 16:29:43', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 10:58:54', '2026-03-20 10:59:43'),
(76, 16, 4, '2026-03-20 16:30:50', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 11:00:50', '2026-03-20 11:00:50'),
(77, 16, 5, '2026-03-20 16:31:09', '2026-03-20 17:00:53', 30, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 11:01:09', '2026-03-20 11:30:53'),
(78, 18, 2, '2026-03-20 16:34:51', '2026-03-20 16:39:00', 4, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:04:51', '2026-03-20 11:09:00'),
(79, 18, 3, '2026-03-20 16:39:06', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:09:00', '2026-03-20 11:09:06'),
(80, 18, 4, '2026-03-20 16:44:05', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:14:05', '2026-03-20 11:14:05'),
(81, 19, 2, '2026-03-20 16:58:28', '2026-03-20 16:59:21', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:28:28', '2026-03-20 11:29:21'),
(82, 19, 3, '2026-03-20 16:59:29', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:29:21', '2026-03-20 11:29:29'),
(83, 16, 6, '2026-03-20 17:00:53', '2026-03-20 17:01:36', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 11:30:53', '2026-03-20 11:31:36'),
(84, 19, 4, '2026-03-20 17:07:34', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:37:34', '2026-03-20 11:37:34'),
(85, 20, 2, '2026-03-20 17:07:47', '2026-03-20 17:09:43', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 11:37:47', '2026-03-20 11:39:43'),
(86, 23, 1, '2026-03-20 17:34:10', '2026-03-20 17:31:28', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:39:23', '2026-03-20 12:04:10'),
(87, 20, 3, '2026-03-20 17:09:50', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 11:39:43', '2026-03-20 11:39:50'),
(88, 21, 2, '2026-03-20 17:12:07', '2026-03-20 17:15:42', 4, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:42:07', '2026-03-20 11:45:42'),
(89, 21, 3, '2026-03-20 17:15:42', '2026-03-20 17:18:23', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:45:42', '2026-03-20 11:48:23'),
(90, 20, 4, '2026-03-20 17:17:44', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 11:47:44', '2026-03-20 11:47:44'),
(91, 21, 4, '2026-03-20 17:18:23', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:48:23', '2026-03-20 11:48:23'),
(92, 21, 5, '2026-03-20 17:18:59', '2026-03-20 17:28:24', 9, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:48:59', '2026-03-20 11:58:24'),
(93, 22, 1, '2026-03-20 17:20:36', '2026-03-20 17:23:50', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 11:50:36', '2026-03-20 11:53:50'),
(94, 24, 1, '2026-03-20 17:22:43', '2026-03-20 17:40:17', 18, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:52:43', '2026-03-20 12:10:17'),
(95, 22, 2, '2026-03-20 17:23:50', '2026-03-20 17:31:31', 8, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 11:53:50', '2026-03-20 12:01:31'),
(96, 21, 6, '2026-03-20 17:28:24', '2026-03-20 17:28:36', 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:58:24', '2026-03-20 11:58:36'),
(97, 23, 2, '2026-03-20 17:31:28', '2026-03-20 17:36:26', 5, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:01:28', '2026-03-20 12:06:26'),
(98, 22, 3, '2026-03-20 17:31:31', '2026-03-20 17:35:51', 4, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:01:31', '2026-03-20 12:05:51'),
(99, 23, 3, '2026-03-20 17:36:27', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:04:06', '2026-03-20 12:06:27'),
(100, 22, 4, '2026-03-20 17:35:51', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:05:51', '2026-03-20 12:05:51'),
(101, 22, 5, '2026-03-20 17:36:08', '2026-03-20 17:47:56', 12, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:06:08', '2026-03-20 12:17:56'),
(102, 24, 2, '2026-03-20 17:40:17', '2026-03-20 17:47:45', 7, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:10:17', '2026-03-20 12:17:45'),
(103, 23, 4, '2026-03-20 17:41:37', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:11:37', '2026-03-20 12:11:37'),
(104, 25, 1, '2026-03-20 17:43:14', '2026-03-20 17:45:29', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:13:14', '2026-03-20 12:15:29'),
(105, 25, 2, '2026-03-20 17:45:29', '2026-03-20 17:47:46', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:15:29', '2026-03-20 12:17:46'),
(106, 24, 3, '2026-03-20 17:47:45', '2026-03-20 18:10:19', 23, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:17:45', '2026-03-20 12:40:19'),
(107, 25, 3, '2026-03-20 17:47:46', '2026-03-20 17:50:23', 3, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:17:46', '2026-03-20 12:20:23'),
(108, 22, 6, '2026-03-20 17:47:56', '2026-03-20 17:49:40', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:17:56', '2026-03-20 12:19:40'),
(109, 25, 4, '2026-03-20 17:50:23', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:20:23', '2026-03-20 12:20:23'),
(110, 25, 5, '2026-03-20 17:50:35', '2026-03-20 17:55:22', 5, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:20:35', '2026-03-20 12:25:22'),
(111, 26, 1, '2026-03-20 17:51:20', '2026-03-20 17:56:21', 5, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:21:20', '2026-03-20 12:26:21'),
(112, 25, 6, '2026-03-20 17:55:22', '2026-03-20 17:55:41', 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:25:22', '2026-03-20 12:25:41'),
(113, 27, 1, '2026-03-20 17:56:03', '2026-03-20 17:58:31', 2, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:26:03', '2026-03-20 12:28:31'),
(114, 26, 2, '2026-03-20 17:56:21', '2026-03-20 18:03:18', 7, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:26:21', '2026-03-20 12:33:18'),
(115, 27, 2, '2026-03-20 17:58:31', '2026-03-20 18:09:51', 11, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:28:31', '2026-03-20 12:39:51'),
(116, 27, 3, '2026-03-20 17:59:42', '2026-03-20 18:03:17', 4, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:29:42', '2026-03-20 12:33:17'),
(117, 27, 4, '2026-03-20 18:09:54', '2026-03-20 18:09:57', 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:33:17', '2026-03-20 12:39:57'),
(118, 26, 3, '2026-03-20 18:03:18', '2026-03-20 18:13:51', 11, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:33:18', '2026-03-20 12:43:51'),
(119, 27, 5, '2026-03-20 18:10:48', '2026-03-20 18:10:52', 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:33:33', '2026-03-20 12:40:52'),
(120, 27, 6, '2026-03-20 18:10:52', '2026-03-20 18:11:34', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:39:14', '2026-03-20 12:41:34'),
(121, 24, 4, '2026-03-20 18:10:19', '2026-03-20 18:10:33', 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:40:19', '2026-03-20 12:40:33'),
(122, 24, 5, '2026-03-20 18:10:33', '2026-03-20 18:32:20', 22, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:40:33', '2026-03-20 13:02:20'),
(123, 26, 4, '2026-03-20 18:13:51', NULL, 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:43:51', '2026-03-20 12:43:51'),
(124, 26, 5, '2026-03-20 18:14:21', '2026-03-20 18:26:34', 12, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:44:21', '2026-03-20 12:56:34'),
(125, 26, 6, '2026-03-20 18:26:34', '2026-03-20 18:27:00', 0, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:56:34', '2026-03-20 12:57:00'),
(126, 24, 6, '2026-03-20 18:32:20', '2026-03-20 18:33:46', 1, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 13:02:20', '2026-03-20 13:03:46'),
(127, 28, 1, '2026-03-21 10:27:01', '2026-03-21 10:35:06', 8, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 04:57:01', '2026-03-21 05:05:06'),
(128, 28, 2, '2026-03-21 10:35:06', '2026-03-21 10:44:38', 10, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:05:06', '2026-03-21 05:14:38'),
(129, 28, 3, '2026-03-21 10:44:38', '2026-03-21 10:50:18', 6, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:14:38', '2026-03-21 05:20:18'),
(130, 28, 4, '2026-03-21 10:50:18', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:20:18', '2026-03-21 05:20:18'),
(131, 28, 5, '2026-03-21 10:50:36', '2026-03-21 11:06:06', 16, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:20:36', '2026-03-21 05:36:06'),
(132, 29, 1, '2026-03-21 10:59:06', '2026-03-21 11:08:10', 9, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 05:29:06', '2026-03-21 05:38:10'),
(133, 28, 6, '2026-03-21 11:06:06', '2026-03-21 11:07:50', 2, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:36:06', '2026-03-21 05:37:50'),
(134, 29, 2, '2026-03-21 11:08:10', '2026-03-21 11:19:22', 11, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 05:38:10', '2026-03-21 05:49:22'),
(135, 31, 1, '2026-03-21 11:48:34', '2026-03-21 11:47:57', 2, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 05:38:25', '2026-03-21 06:18:34'),
(136, 30, 2, '2026-03-21 11:10:41', '2026-03-21 11:12:40', 2, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:40:41', '2026-03-21 05:42:40'),
(137, 30, 3, '2026-03-21 11:12:41', '2026-03-21 11:15:50', 3, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:42:41', '2026-03-21 05:45:50'),
(138, 30, 4, '2026-03-21 11:15:50', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:45:50', '2026-03-21 05:45:50'),
(139, 30, 5, '2026-03-21 11:44:58', '2026-03-21 11:45:06', 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 05:46:04', '2026-03-21 06:15:06'),
(140, 29, 3, '2026-03-21 11:19:22', '2026-03-21 11:27:49', 8, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 05:49:22', '2026-03-21 05:57:49'),
(141, 29, 4, '2026-03-21 11:27:49', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 05:57:49', '2026-03-21 05:57:49'),
(142, 29, 5, '2026-03-21 11:28:24', '2026-03-21 11:41:06', 13, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 05:58:24', '2026-03-21 06:11:06'),
(143, 29, 6, '2026-03-21 11:41:06', '2026-03-21 11:41:59', 1, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:11:06', '2026-03-21 06:11:59'),
(144, 30, 6, '2026-03-21 11:45:06', '2026-03-21 11:45:33', 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:15:06', '2026-03-21 06:15:33'),
(145, 31, 2, '2026-03-21 11:47:57', '2026-03-21 11:50:35', 3, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:17:57', '2026-03-21 06:20:35'),
(146, 31, 3, '2026-03-21 11:50:35', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:18:31', '2026-03-21 06:20:35'),
(147, 31, 4, '2026-03-21 11:54:20', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:24:20', '2026-03-21 06:24:20'),
(148, 32, 1, '2026-03-21 12:02:14', '2026-03-21 12:06:29', 4, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 06:32:14', '2026-03-21 06:36:29'),
(149, 35, 1, '2026-03-21 13:07:59', '2026-03-21 13:04:59', 5, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:33:38', '2026-03-21 07:37:59'),
(150, 32, 2, '2026-03-21 12:06:29', '2026-03-21 12:12:59', 7, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 06:36:29', '2026-03-21 06:42:59'),
(151, 33, 2, '2026-03-21 12:11:23', '2026-03-21 12:24:01', 13, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:41:23', '2026-03-21 06:54:01'),
(152, 32, 3, '2026-03-21 12:12:59', '2026-03-21 12:16:29', 4, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 06:42:59', '2026-03-21 06:46:29'),
(153, 32, 4, '2026-03-21 12:16:29', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 06:46:29', '2026-03-21 06:46:29'),
(154, 32, 5, '2026-03-21 12:39:03', '2026-03-21 12:40:07', 1, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 06:46:39', '2026-03-21 07:10:07'),
(155, 33, 3, '2026-03-21 12:24:02', '2026-03-21 12:28:33', 5, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:54:02', '2026-03-21 06:58:33'),
(156, 33, 4, '2026-03-21 12:28:33', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:58:33', '2026-03-21 06:58:33'),
(157, 33, 5, '2026-03-21 12:28:59', '2026-03-21 12:43:46', 15, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:58:59', '2026-03-21 07:13:46'),
(158, 32, 6, '2026-03-21 12:57:19', '2026-03-21 12:57:29', 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 07:01:46', '2026-03-21 07:27:29'),
(159, 33, 6, '2026-03-21 12:59:08', '2026-03-21 12:59:45', 1, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 07:13:46', '2026-03-21 07:29:45'),
(160, 34, 1, '2026-03-21 13:00:33', '2026-03-21 13:04:54', 4, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 07:30:33', '2026-03-21 07:34:54'),
(161, 34, 2, '2026-03-21 13:04:54', '2026-03-21 13:09:02', 4, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 07:34:54', '2026-03-21 07:39:02'),
(162, 35, 2, '2026-03-21 13:04:59', '2026-03-21 13:07:52', 3, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 07:34:59', '2026-03-21 07:37:52'),
(163, 35, 3, '2026-03-21 13:08:00', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 07:37:52', '2026-03-21 07:38:00'),
(164, 34, 3, '2026-03-21 13:09:02', '2026-03-21 13:14:17', 5, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 07:39:02', '2026-03-21 07:44:17'),
(165, 34, 4, '2026-03-21 13:14:17', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 07:44:17', '2026-03-21 07:44:17'),
(166, 34, 5, '2026-03-21 13:14:28', '2026-03-21 13:18:23', 4, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 07:44:28', '2026-03-21 07:48:23'),
(167, 34, 6, '2026-03-21 13:18:23', '2026-03-21 13:19:30', 1, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 07:48:23', '2026-03-21 07:49:30'),
(168, 35, 4, '2026-03-21 13:23:40', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 07:53:40', '2026-03-21 07:53:40'),
(169, 37, 1, '2026-03-21 13:26:01', '2026-03-21 13:57:46', 32, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 07:56:01', '2026-03-21 08:27:46'),
(170, 36, 1, '2026-03-21 13:38:54', '2026-03-21 13:50:09', 11, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:08:54', '2026-03-21 08:20:09'),
(171, 36, 2, '2026-03-21 13:57:01', '2026-03-21 14:00:11', 3, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:20:09', '2026-03-21 08:30:11'),
(172, 37, 2, '2026-03-21 13:57:46', '2026-03-21 14:02:30', 5, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:27:46', '2026-03-21 08:32:30'),
(173, 36, 3, '2026-03-21 14:00:11', '2026-03-21 14:02:51', 3, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:30:11', '2026-03-21 08:32:51'),
(174, 37, 3, '2026-03-21 14:02:30', '2026-03-21 14:07:39', 5, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:32:30', '2026-03-21 08:37:39'),
(175, 36, 4, '2026-03-21 14:02:51', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:32:51', '2026-03-21 08:32:51'),
(176, 36, 5, '2026-03-21 14:03:03', '2026-03-21 14:13:06', 10, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:33:03', '2026-03-21 08:43:06'),
(177, 37, 4, '2026-03-21 14:07:39', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:37:39', '2026-03-21 08:37:39'),
(178, 37, 5, '2026-03-21 14:08:07', '2026-03-21 14:16:18', 8, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:38:07', '2026-03-21 08:46:18'),
(179, 36, 6, '2026-03-21 14:13:06', '2026-03-21 14:13:22', 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:43:06', '2026-03-21 08:43:22'),
(180, 40, 1, '2026-03-21 14:28:12', '2026-03-21 14:30:27', 2, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:43:46', '2026-03-21 09:00:27'),
(181, 37, 6, '2026-03-21 14:16:18', '2026-03-21 14:16:51', 1, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:46:18', '2026-03-21 08:46:51'),
(182, 38, 2, '2026-03-21 14:16:44', '2026-03-21 14:18:16', 2, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:46:44', '2026-03-21 08:48:16'),
(183, 38, 3, '2026-03-21 14:18:16', '2026-03-21 14:20:52', 3, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:48:03', '2026-03-21 08:50:52'),
(184, 38, 4, '2026-03-21 14:20:52', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:50:52', '2026-03-21 08:50:52'),
(185, 38, 5, '2026-03-21 14:21:03', '2026-03-21 14:27:39', 7, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:51:03', '2026-03-21 08:57:39'),
(186, 39, 2, '2026-03-21 14:22:54', '2026-03-21 14:26:11', 3, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:52:54', '2026-03-21 08:56:11'),
(187, 39, 3, '2026-03-21 14:26:11', '2026-03-21 14:29:41', 4, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:56:11', '2026-03-21 08:59:41'),
(188, 38, 6, '2026-03-21 14:27:39', '2026-03-21 14:27:56', 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:57:39', '2026-03-21 08:57:56'),
(189, 39, 4, '2026-03-21 14:29:42', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:59:42', '2026-03-21 08:59:42'),
(190, 39, 5, '2026-03-21 14:29:59', '2026-03-21 14:52:30', 23, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:59:59', '2026-03-21 09:22:30'),
(191, 40, 2, '2026-03-21 14:30:27', '2026-03-21 14:34:34', 4, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 09:00:27', '2026-03-21 09:04:34'),
(192, 40, 3, '2026-03-21 14:34:34', '2026-03-21 14:36:28', 2, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 09:04:34', '2026-03-21 09:06:28'),
(193, 41, 1, '2026-03-21 14:35:02', '2026-03-21 14:46:56', 12, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 09:05:02', '2026-03-21 09:16:56'),
(194, 40, 4, '2026-03-21 14:36:28', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 09:06:28', '2026-03-21 09:06:28'),
(195, 40, 5, '2026-03-21 14:36:40', '2026-03-21 14:40:24', 4, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 09:06:40', '2026-03-21 09:10:24'),
(196, 40, 6, '2026-03-21 14:40:24', '2026-03-21 14:41:07', 1, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 09:10:24', '2026-03-21 09:11:07'),
(197, 41, 2, '2026-03-21 14:46:56', NULL, 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 09:16:56', '2026-03-21 09:16:56'),
(198, 39, 6, '2026-03-21 14:52:30', '2026-03-21 14:52:56', 0, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 09:22:30', '2026-03-21 09:22:56'),
(199, 45, 1, '2026-03-23 09:44:23', NULL, 0, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-23 04:14:23', '2026-03-23 04:14:23'),
(200, 45, 2, '2026-03-23 09:44:25', NULL, 0, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-23 04:14:25', '2026-03-23 04:14:25'),
(201, 48, 1, '2026-03-23 09:48:20', '2026-03-23 09:58:59', 11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-23 04:18:20', '2026-03-23 04:28:59'),
(202, 48, 2, '2026-03-23 09:58:59', NULL, 0, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-23 04:28:59', '2026-03-23 04:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `approved_applicants`
--

CREATE TABLE `approved_applicants` (
  `id` int(11) NOT NULL,
  `student_application_id` int(11) NOT NULL DEFAULT 0,
  `allotted_certificate_no` varchar(16) NOT NULL,
  `alloted_regn_no` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `certificate_path` varchar(250) DEFAULT NULL,
  `signed_certificate_path` varchar(250) DEFAULT NULL,
  `signed_uploaded_by` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `signed_uploaded_at` datetime DEFAULT NULL,
  `certficate_valid_from_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `approved_applicants`
--

INSERT INTO `approved_applicants` (`id`, `student_application_id`, `allotted_certificate_no`, `alloted_regn_no`, `certificate_path`, `signed_certificate_path`, `signed_uploaded_by`, `signed_uploaded_at`, `certficate_valid_from_date`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, '8564351134519622', '4880', 'admin_uploads/2601/sys_certificate_generated/Certificate_8564351134519622.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_8564351134519622.pdf', '6', '2026-01-15 16:51:27', '2024-12-31', '2026-01-08 17:33:50', '5', '2026-01-15 16:51:27', NULL),
(2, 5, '2784983011228173', '005175', 'admin_uploads/2601/sys_certificate_generated/Certificate_2784983011228173.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_2784983011228173.pdf', '6', '2026-01-15 16:52:18', '2025-10-16', '2026-01-08 17:34:15', '5', '2026-01-15 16:52:18', NULL),
(3, 6, '3443137457654115', '005176', 'admin_uploads/2601/sys_certificate_generated/Certificate_3443137457654115.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_3443137457654115.pdf', '6', '2026-01-15 16:52:49', '2025-10-16', '2026-01-08 17:34:34', '5', '2026-01-15 16:52:49', NULL),
(4, 8, '6827519329742816', '005174', 'admin_uploads/2601/sys_certificate_generated/Certificate_6827519329742816.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6827519329742816.pdf', '6', '2026-01-15 16:53:15', '2025-10-16', '2026-01-08 17:35:21', '5', '2026-01-15 16:53:15', NULL),
(5, 25, '7010608587129121', '005241', 'admin_uploads/2601/sys_certificate_generated/Certificate_7010608587129121.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_7010608587129121.pdf', '6', '2026-01-15 16:53:47', '2025-10-19', '2026-01-08 17:37:24', '5', '2026-01-15 16:53:47', NULL),
(6, 24, '9595891284590656', '005385', 'admin_uploads/2601/sys_certificate_generated/Certificate_9595891284590656.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_9595891284590656.pdf', '6', '2026-01-15 16:54:05', '2025-11-05', '2026-01-08 17:38:10', '5', '2026-01-15 16:54:05', NULL),
(7, 26, '6652931242739973', '005393', 'admin_uploads/2601/sys_certificate_generated/Certificate_6652931242739973.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6652931242739973.pdf', '6', '2026-01-15 16:54:34', '2025-11-05', '2026-01-08 17:38:34', '5', '2026-01-15 16:54:34', NULL),
(8, 14, '5091863638836162', '2253', 'admin_uploads/2601/sys_certificate_generated/Certificate_5091863638836162.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_5091863638836162.pdf', '6', '2026-01-15 16:54:57', '2025-11-05', '2026-01-08 17:39:08', '5', '2026-01-15 16:54:57', NULL),
(9, 27, '8030481400027714', '005307', 'admin_uploads/2601/sys_certificate_generated/Certificate_8030481400027714.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_8030481400027714.pdf', '6', '2026-01-15 16:55:23', '2025-10-28', '2026-01-08 17:39:34', '5', '2026-01-15 16:55:23', NULL),
(10, 33, '6869535039775675', '005499', 'admin_uploads/2601/sys_certificate_generated/Certificate_6869535039775675.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6869535039775675.pdf', '6', '2026-01-15 16:55:44', '2025-11-18', '2026-01-08 17:40:04', '5', '2026-01-15 16:55:44', NULL),
(11, 34, '2793696594880184', '005390', 'admin_uploads/2601/sys_certificate_generated/Certificate_2793696594880184.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_2793696594880184.pdf', '6', '2026-01-15 16:56:06', '2025-11-05', '2026-01-08 17:40:35', '5', '2026-01-15 16:56:06', NULL),
(12, 45, '1550990277788300', '005389', 'admin_uploads/2601/sys_certificate_generated/Certificate_1550990277788300.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_1550990277788300.pdf', '6', '2026-01-15 16:56:25', '2025-11-05', '2026-01-08 17:41:03', '5', '2026-01-15 16:56:25', NULL),
(13, 48, '6259114762664249', '4965', 'admin_uploads/2601/sys_certificate_generated/Certificate_6259114762664249.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6259114762664249.pdf', '6', '2026-01-15 16:56:41', '2025-02-13', '2026-01-08 17:41:36', '5', '2026-01-15 16:56:42', NULL),
(14, 50, '9619489333131987', '005606', 'admin_uploads/2601/sys_certificate_generated/Certificate_9619489333131987.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_9619489333131987.pdf', '6', '2026-01-15 16:57:04', '2025-12-04', '2026-01-08 17:42:11', '5', '2026-01-15 16:57:04', NULL),
(15, 12, '4751561630642961', '005388', 'admin_uploads/2601/sys_certificate_generated/Certificate_4751561630642961.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_4751561630642961.pdf', '6', '2026-01-15 16:57:31', '2025-11-05', '2026-01-08 17:42:43', '5', '2026-01-15 16:57:31', NULL),
(17, 55, '6756493577706866', '4875', 'admin_uploads/2601/sys_certificate_generated/Certificate_6756493577706866.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6756493577706866.pdf', '6', '2026-01-29 11:26:15', '2024-12-31', '2026-01-08 17:46:23', '5', '2026-01-29 11:26:15', NULL),
(18, 17, '7213839805748527', '5093', 'admin_uploads/2601/sys_certificate_generated/Certificate_7213839805748527.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_7213839805748527.pdf', '6', '2026-01-29 11:26:38', '2025-08-07', '2026-01-08 17:49:01', '5', '2026-01-29 11:26:38', NULL),
(19, 18, '7062552675804063', '005459', 'admin_uploads/2601/sys_certificate_generated/Certificate_7062552675804063.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_7062552675804063.pdf', '6', '2026-01-29 11:26:51', '2025-11-12', '2026-01-08 17:50:03', '5', '2026-01-29 11:26:51', NULL),
(20, 20, '6857395120139325', '005495', 'admin_uploads/2601/sys_certificate_generated/Certificate_6857395120139325.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6857395120139325.pdf', '6', '2026-01-29 11:27:07', '2025-11-18', '2026-01-08 17:50:37', '5', '2026-01-29 11:27:07', NULL),
(21, 56, '9444538563265211', '005636', 'admin_uploads/2601/sys_certificate_generated/Certificate_9444538563265211.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_9444538563265211.pdf', '6', '2026-01-29 11:27:30', '2025-12-08', '2026-01-08 17:51:07', '5', '2026-01-29 11:27:30', NULL),
(22, 7, '5736806128716686', '005189', 'admin_uploads/2601/sys_certificate_generated/Certificate_5736806128716686.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_5736806128716686.pdf', '6', '2026-01-29 11:27:44', '2025-10-16', '2026-01-08 17:52:19', '5', '2026-01-29 11:27:44', NULL),
(23, 1, '1234567890', '123456', 'admin_uploads/2601/sys_certificate_generated/Certificate_5736806128716686.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_1234567890.pdf', '3', '2026-01-15 17:34:07', '2025-10-16', '2026-01-08 17:52:19', '5', '2026-01-15 17:34:07', NULL),
(24, 99916, '3222836123384092', '3382', 'admin_uploads/2601/sys_certificate_generated/Certificate_3222836123384092.pdf', NULL, NULL, NULL, '2022-03-24', '2026-01-16 16:58:47', '5', '2026-01-22 16:40:40', NULL),
(25, 99921, '9339785064237468', '005660', 'admin_uploads/2601/sys_certificate_generated/Certificate_9339785064237468.pdf', NULL, NULL, NULL, '2025-08-27', '2026-01-16 16:59:00', '5', '2026-01-22 16:41:22', NULL),
(26, 99915, '9713277182874718', '005267', 'admin_uploads/2601/sys_certificate_generated/Certificate_9713277182874718.pdf', NULL, NULL, NULL, '2025-10-20', '2026-01-16 16:59:15', '5', '2026-01-22 16:42:33', NULL),
(27, 99922, '3008808217409370', '005220', 'admin_uploads/2601/sys_certificate_generated/Certificate_3008808217409370.pdf', NULL, NULL, NULL, '2025-10-19', '2026-01-16 16:59:31', '5', '2026-01-22 16:43:24', NULL),
(28, 29, '6705671117924301', '005384', 'admin_uploads/2601/sys_certificate_generated/Certificate_6705671117924301.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6705671117924301.pdf', '6', '2026-01-29 11:28:16', '2025-11-05', '2026-01-16 16:59:45', '5', '2026-01-29 11:28:16', NULL),
(29, 99930, '1640487483121484', '26128', 'admin_uploads/2601/sys_certificate_generated/Certificate_1640487483121484.pdf', NULL, NULL, NULL, '2025-08-28', '2026-01-16 17:00:03', '5', '2026-01-22 16:45:11', NULL),
(30, 99931, '2467830365769201', '26146', 'admin_uploads/2601/sys_certificate_generated/Certificate_2467830365769201.pdf', NULL, NULL, NULL, '2025-08-28', '2026-01-16 17:00:19', '5', '2026-01-22 16:44:22', NULL),
(31, 99938, '7441338264979946', '3354', 'admin_uploads/2601/sys_certificate_generated/Certificate_7441338264979946.pdf', NULL, NULL, NULL, '2021-10-26', '2026-01-16 17:00:48', '5', '2026-01-22 16:46:09', NULL),
(32, 99939, '4579490177875553', '4910', 'admin_uploads/2601/sys_certificate_generated/Certificate_4579490177875553.pdf', NULL, NULL, NULL, '2024-12-14', '2026-01-16 17:01:01', '5', '2026-01-22 16:46:34', NULL),
(33, 99947, '6744203709509765', '5096', 'admin_uploads/2601/sys_certificate_generated/Certificate_6744203709509765.pdf', NULL, NULL, NULL, '2025-08-07', '2026-01-16 17:01:11', '5', '2026-01-22 16:46:58', NULL),
(34, 99953, '5946854417553291', '1362', 'admin_uploads/2601/sys_certificate_generated/Certificate_5946854417553291.pdf', NULL, NULL, NULL, '2024-05-20', '2026-01-16 17:01:48', '5', '2026-01-22 16:47:21', NULL),
(35, 9, '2844469804246729', '1361', 'admin_uploads/2601/sys_certificate_generated/Certificate_2844469804246729.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_2844469804246729.pdf', '6', '2026-01-29 11:28:43', '2024-05-20', '2026-01-16 17:02:17', '5', '2026-01-29 11:28:43', NULL),
(36, 52, '3609122403259571', '005305', 'admin_uploads/2601/sys_certificate_generated/Certificate_3609122403259571.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_3609122403259571.pdf', '6', '2026-01-29 11:29:14', '2025-10-28', '2026-01-16 17:02:28', '5', '2026-01-29 11:29:14', NULL),
(37, 9994, '6161149876389518', '4179', 'admin_uploads/2601/sys_certificate_generated/Certificate_6161149876389518.pdf', NULL, NULL, NULL, '2024-03-14', '2026-01-16 17:02:39', '5', '2026-01-22 16:47:53', NULL),
(38, 10, '1550269497046365', '005547', 'admin_uploads/2601/sys_certificate_generated/Certificate_1550269497046365.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_1550269497046365.pdf', '6', '2026-01-29 11:29:35', '2025-11-25', '2026-01-16 17:02:50', '5', '2026-01-29 11:29:35', NULL),
(39, 99911, '6291380480290090', '005392', 'admin_uploads/2601/sys_certificate_generated/Certificate_6291380480290090.pdf', NULL, NULL, NULL, '2025-11-05', '2026-01-16 17:03:02', '5', '2026-01-22 16:48:22', NULL),
(40, 15, '9380863752252606', '005267', 'admin_uploads/2601/sys_certificate_generated/Certificate_9380863752252606.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_9380863752252606.pdf', '6', '2026-01-29 11:30:00', '2025-10-20', '2026-01-22 16:49:17', '5', '2026-01-29 11:30:00', NULL),
(41, 16, '3650475128396527', '3382', 'admin_uploads/2601/sys_certificate_generated/Certificate_3650475128396527.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_3650475128396527.pdf', '6', '2026-01-29 11:30:27', '2022-02-24', '2026-01-22 16:49:31', '5', '2026-01-29 11:30:27', NULL),
(42, 21, '4965614596005066', '005660', 'admin_uploads/2601/sys_certificate_generated/Certificate_4965614596005066.pdf', NULL, NULL, NULL, '2025-12-09', '2026-01-22 16:50:27', '5', '2026-01-22 16:50:27', NULL),
(43, 22, '9109718506072513', '005220', 'admin_uploads/2601/sys_certificate_generated/Certificate_9109718506072513.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_9109718506072513.pdf', '6', '2026-01-29 11:31:09', '2025-10-19', '2026-01-22 16:50:50', '5', '2026-01-29 11:31:09', NULL),
(44, 99930, '3312803631193212', '005616', 'admin_uploads/2601/sys_certificate_generated/Certificate_3312803631193212.pdf', NULL, NULL, NULL, '2025-04-12', '2026-01-22 16:51:15', '5', '2026-01-28 07:10:03', NULL),
(45, 99931, '6328256213498081', '26146', 'admin_uploads/2601/sys_certificate_generated/Certificate_6328256213498081.pdf', NULL, NULL, NULL, '2025-12-04', '2026-01-22 16:51:27', '5', '2026-01-28 07:17:03', NULL),
(46, 39, '1129615391342405', '4910', 'admin_uploads/2601/sys_certificate_generated/Certificate_1129615391342405.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_1129615391342405.pdf', '6', '2026-01-29 11:31:31', '2025-02-01', '2026-01-22 16:51:41', '5', '2026-01-29 11:31:31', NULL),
(47, 99938, '7690575387372496', '3354', 'admin_uploads/2601/sys_certificate_generated/Certificate_7690575387372496.pdf', NULL, NULL, NULL, '2022-11-02', '2026-01-22 16:51:56', '5', '2026-01-28 07:07:16', NULL),
(48, 53, '4058574259569081', '1362', 'admin_uploads/2601/sys_certificate_generated/Certificate_4058574259569081.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_4058574259569081.pdf', '6', '2026-01-29 11:31:48', '2024-05-20', '2026-01-22 16:52:50', '5', '2026-01-29 11:31:48', NULL),
(49, 47, '2336734939937789', '5096', 'admin_uploads/2601/sys_certificate_generated/Certificate_2336734939937789.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_2336734939937789.pdf', '6', '2026-01-29 11:32:10', '2025-08-07', '2026-01-22 16:53:03', '5', '2026-01-29 11:32:10', NULL),
(50, 4, '4324156422011880', '4179', 'admin_uploads/2601/sys_certificate_generated/Certificate_4324156422011880.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_4324156422011880.pdf', '6', '2026-01-29 11:32:22', '2024-03-14', '2026-01-22 16:53:16', '5', '2026-01-29 11:32:22', NULL),
(51, 11, '5809232527861224', '005392', 'admin_uploads/2601/sys_certificate_generated/Certificate_5809232527861224.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_5809232527861224.pdf', '6', '2026-01-29 11:32:41', '2025-11-05', '2026-01-22 16:53:30', '5', '2026-01-29 11:32:41', NULL),
(52, 30, '7204682255159056', '005616', 'admin_uploads/2601/sys_certificate_generated/Certificate_7204682255159056.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_7204682255159056.pdf', '6', '2026-01-29 11:33:22', '2025-12-04', '2026-01-28 07:17:35', '4', '2026-01-29 11:33:22', NULL),
(53, 31, '8513501343313470', '005609', 'admin_uploads/2601/sys_certificate_generated/Certificate_8513501343313470.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_8513501343313470.pdf', '6', '2026-01-29 11:33:34', '2025-12-04', '2026-01-28 07:17:51', '4', '2026-01-29 11:33:34', NULL),
(54, 38, '6362595236614231', '3354', 'admin_uploads/2601/sys_certificate_generated/Certificate_6362595236614231.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6362595236614231.pdf', '6', '2026-01-29 11:33:53', '2022-02-11', '2026-01-28 07:18:06', '4', '2026-01-29 11:33:53', NULL),
(55, 59, '8235651240438725', '005497', 'admin_uploads/2601/sys_certificate_generated/Certificate_8235651240438725.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_8235651240438725.pdf', '6', '2026-01-31 17:08:27', '2025-11-18', '2026-01-29 17:03:31', '5', '2026-01-31 17:08:27', NULL),
(56, 36, '6809433187702567', '2618', 'admin_uploads/2601/sys_certificate_generated/Certificate_6809433187702567.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6809433187702567.pdf', '6', '2026-01-31 17:08:51', '2020-11-30', '2026-01-29 17:06:27', '5', '2026-01-31 17:08:51', NULL),
(57, 36, '7062056009054760', '2618', 'admin_uploads/2601/sys_certificate_generated/Certificate_7062056009054760.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_7062056009054760.pdf', '6', '2026-01-31 17:09:12', '2025-11-30', '2026-01-29 17:06:27', '5', '2026-01-31 17:09:12', NULL),
(58, 13, '6333620082077652', '2222', 'admin_uploads/2601/sys_certificate_generated/Certificate_6333620082077652.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_6333620082077652.pdf', '6', '2026-01-31 17:09:37', '2025-11-05', '2026-01-29 17:06:41', '5', '2026-01-31 17:09:37', NULL),
(59, 83, '3751253113766207', '3468', 'admin_uploads/2601/sys_certificate_generated/Certificate_3751253113766207.pdf', 'admin_uploads/2601/sys_certificate_generated/signed_Certificate_3751253113766207.pdf', '6', '2026-01-31 17:09:51', '2022-06-25', '2026-01-29 17:06:55', '5', '2026-01-31 17:09:51', NULL);

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
('captcha_0074ae9a05424a9c7e5aeade3208c584', 'a:5:{i:0;s:1:\"h\";i:1;s:1:\"z\";i:2;s:1:\"0\";i:3;s:1:\"i\";i:4;s:1:\"v\";}', 1773057369),
('captcha_014e4b31982ffb59b10e5c7705ea0c7f', 'a:5:{i:0;s:1:\"q\";i:1;s:1:\"r\";i:2;s:1:\"h\";i:3;s:1:\"7\";i:4;s:1:\"n\";}', 1772267522),
('captcha_0237c04031b047ba9670ca1fa7e9990e', 'a:5:{i:0;s:1:\"d\";i:1;s:1:\"c\";i:2;s:1:\"w\";i:3;s:1:\"t\";i:4;s:1:\"r\";}', 1770708230),
('captcha_03670bd5b4130a18f9b91a9e4dbe6a0b', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"9\";i:2;s:1:\"h\";i:3;s:1:\"j\";i:4;s:1:\"j\";}', 1770986789),
('captcha_0448f59201558e0f6f2ac8c99071d771', 'a:5:{i:0;s:1:\"8\";i:1;s:1:\"q\";i:2;s:1:\"t\";i:3;s:1:\"7\";i:4;s:1:\"h\";}', 1771579890),
('captcha_05931bcb3d4c5263f54b27f4460a36d8', 'a:5:{i:0;s:1:\"4\";i:1;s:1:\"o\";i:2;s:1:\"5\";i:3;s:1:\"q\";i:4;s:1:\"4\";}', 1771063785),
('captcha_07ea61782a97f2972593fe9846d88e15', 'a:5:{i:0;s:1:\"e\";i:1;s:1:\"q\";i:2;s:1:\"x\";i:3;s:1:\"e\";i:4;s:1:\"9\";}', 1771050465),
('captcha_0886795ce1e315d84a279f111af14ea9', 'a:5:{i:0;s:1:\"g\";i:1;s:1:\"r\";i:2;s:1:\"6\";i:3;s:1:\"t\";i:4;s:1:\"y\";}', 1773293450),
('captcha_098e178c23b4434559db286c3511dfee', 'a:5:{i:0;s:1:\"w\";i:1;s:1:\"q\";i:2;s:1:\"w\";i:3;s:1:\"9\";i:4;s:1:\"p\";}', 1770962190),
('captcha_0cdf579a67930b07f2165d74cf2edd64', 'a:5:{i:0;s:1:\"b\";i:1;s:1:\"t\";i:2;s:1:\"y\";i:3;s:1:\"n\";i:4;s:1:\"k\";}', 1771653721),
('captcha_0e9a6f31d6c7fadd26faf08b90e93463', 'a:5:{i:0;s:1:\"d\";i:1;s:1:\"8\";i:2;s:1:\"i\";i:3;s:1:\"k\";i:4;s:1:\"w\";}', 1773407419),
('captcha_0eb765df57731837a8e3f69667472b49', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"i\";i:2;s:1:\"h\";i:3;s:1:\"p\";i:4;s:1:\"n\";}', 1773307420),
('captcha_0efb8e55b6170ad7ac726a8129288b18', 'a:5:{i:0;s:1:\"n\";i:1;s:1:\"m\";i:2;s:1:\"b\";i:3;s:1:\"i\";i:4;s:1:\"s\";}', 1773381930),
('captcha_108c0dc02ba9d4ac05cc0d6d72453f1a', 'a:5:{i:0;s:1:\"h\";i:1;s:1:\"l\";i:2;s:1:\"r\";i:3;s:1:\"m\";i:4;s:1:\"s\";}', 1771591921),
('captcha_10a454b380ecc5be50676c56c52cf442', 'a:5:{i:0;s:1:\"f\";i:1;s:1:\"e\";i:2;s:1:\"i\";i:3;s:1:\"c\";i:4;s:1:\"e\";}', 1773403419),
('captcha_16069302fd58addd6eca4643a9bf9b81', 'a:5:{i:0;s:1:\"u\";i:1;s:1:\"j\";i:2;s:1:\"b\";i:3;s:1:\"i\";i:4;s:1:\"i\";}', 1771931942),
('captcha_16d33fd777db1aa66a0151771b3b3835', 'a:5:{i:0;s:1:\"t\";i:1;s:1:\"r\";i:2;s:1:\"m\";i:3;s:1:\"f\";i:4;s:1:\"f\";}', 1771416212),
('captcha_16f617d26df9e943f6d9dbbf29d0e4f3', 'a:5:{i:0;s:1:\"j\";i:1;s:1:\"e\";i:2;s:1:\"t\";i:3;s:1:\"q\";i:4;s:1:\"o\";}', 1770725424),
('captcha_1aff7bdb166c0c13a31e52e1ac1a1785', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"c\";i:2;s:1:\"4\";i:3;s:1:\"q\";i:4;s:1:\"j\";}', 1771918020),
('captcha_1cce781c1601d88def2f8fbdca8980a3', 'a:5:{i:0;s:1:\"i\";i:1;s:1:\"0\";i:2;s:1:\"s\";i:3;s:1:\"j\";i:4;s:1:\"i\";}', 1771935668),
('captcha_1d24740fad8e299011338a9be0e38efc', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"m\";i:2;s:1:\"q\";i:3;s:1:\"6\";i:4;s:1:\"1\";}', 1770799913),
('captcha_1d7368d810c299035146f12947f11a3a', 'a:5:{i:0;s:1:\"h\";i:1;s:1:\"e\";i:2;s:1:\"8\";i:3;s:1:\"i\";i:4;s:1:\"l\";}', 1773393408),
('captcha_1f15e6901ee9b4907ce077720bfbf0ea', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"b\";i:2;s:1:\"q\";i:3;s:1:\"o\";i:4;s:1:\"s\";}', 1771246130),
('captcha_1f6122895646cac2cf88df5e915983f2', 'a:5:{i:0;s:1:\"j\";i:1;s:1:\"u\";i:2;s:1:\"3\";i:3;s:1:\"z\";i:4;s:1:\"s\";}', 1770714963),
('captcha_2091bb4d129671ad7a3176f477d0e958', 'a:5:{i:0;s:1:\"o\";i:1;s:1:\"z\";i:2;s:1:\"8\";i:3;s:1:\"g\";i:4;s:1:\"g\";}', 1770977909),
('captcha_2633a57c0ff549077305d506f8db6cf1', 'a:5:{i:0;s:1:\"5\";i:1;s:1:\"l\";i:2;s:1:\"u\";i:3;s:1:\"u\";i:4;s:1:\"i\";}', 1771389824),
('captcha_26ccd0be5f862e75c0117dfbd9101ad8', 'a:5:{i:0;s:1:\"3\";i:1;s:1:\"j\";i:2;s:1:\"5\";i:3;s:1:\"q\";i:4;s:1:\"a\";}', 1773137290),
('captcha_27f5f3e3db108983fceb075239489e69', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"1\";i:2;s:1:\"e\";i:3;s:1:\"w\";i:4;s:1:\"u\";}', 1770792048),
('captcha_2808465445d2752b15cf3f66628c21df', 'a:5:{i:0;s:1:\"z\";i:1;s:1:\"r\";i:2;s:1:\"s\";i:3;s:1:\"1\";i:4;s:1:\"e\";}', 1772020994),
('captcha_289827f22caa6313934c067778530503', 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"s\";i:2;s:1:\"w\";i:3;s:1:\"b\";i:4;s:1:\"x\";}', 1773637549),
('captcha_2a36fc4be7dc6b909f5cb2d02a335e53', 'a:5:{i:0;s:1:\"t\";i:1;s:1:\"m\";i:2;s:1:\"h\";i:3;s:1:\"w\";i:4;s:1:\"q\";}', 1770720350),
('captcha_2a9e095bff466d59ad98381d3efdd124', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"b\";i:2;s:1:\"a\";i:3;s:1:\"r\";i:4;s:1:\"l\";}', 1770986784),
('captcha_2ab9ec8c063ea0b9364e56ea406669e0', 'a:5:{i:0;s:1:\"p\";i:1;s:1:\"8\";i:2;s:1:\"t\";i:3;s:1:\"9\";i:4;s:1:\"o\";}', 1773308043),
('captcha_2b3aae40c1f2d6b121077199e55b8e3d', 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"l\";i:2;s:1:\"j\";i:3;s:1:\"2\";i:4;s:1:\"r\";}', 1771933062),
('captcha_2c08732557d75a465ee153da245a15ac', 'a:5:{i:0;s:1:\"z\";i:1;s:1:\"l\";i:2;s:1:\"a\";i:3;s:1:\"q\";i:4;s:1:\"y\";}', 1770723888),
('captcha_2cef4bf4424d5141d20238ac392c9229', 'a:5:{i:0;s:1:\"o\";i:1;s:1:\"e\";i:2;s:1:\"3\";i:3;s:1:\"r\";i:4;s:1:\"n\";}', 1771236537),
('captcha_2d671e1bfe68ac1961f75bc7636fca28', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"8\";i:2;s:1:\"s\";i:3;s:1:\"i\";i:4;s:1:\"u\";}', 1770989614),
('captcha_2f89eb2e8efb78829fe785374e810b5c', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"t\";i:2;s:1:\"m\";i:3;s:1:\"5\";i:4;s:1:\"g\";}', 1773296750),
('captcha_2ffacef99440c040e4ed5b5ac4b2d2f5', 'a:5:{i:0;s:1:\"j\";i:1;s:1:\"9\";i:2;s:1:\"y\";i:3;s:1:\"p\";i:4;s:1:\"f\";}', 1773136272),
('captcha_303fd6d5a0d53620d635e8ad7c6d567f', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"1\";i:2;s:1:\"m\";i:3;s:1:\"8\";i:4;s:1:\"q\";}', 1771416345),
('captcha_321d681d44e7cf75e3ee4aae7d838c03', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"l\";i:2;s:1:\"p\";i:3;s:1:\"x\";i:4;s:1:\"e\";}', 1773206453),
('captcha_32bfdf6d8cca0e7826152c4062762fd7', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"k\";i:2;s:1:\"m\";i:3;s:1:\"h\";i:4;s:1:\"a\";}', 1773813590),
('captcha_33d1fb39d49011ec9089854c6d6b2ee5', 'a:5:{i:0;s:1:\"u\";i:1;s:1:\"c\";i:2;s:1:\"w\";i:3;s:1:\"q\";i:4;s:1:\"i\";}', 1770709845),
('captcha_3769c232ba668e4f2b721a59745ee997', 'a:5:{i:0;s:1:\"p\";i:1;s:1:\"g\";i:2;s:1:\"6\";i:3;s:1:\"b\";i:4;s:1:\"l\";}', 1770740580),
('captcha_37cbc8211f2b2ca4994a86d1a3c2a298', 'a:5:{i:0;s:1:\"8\";i:1;s:1:\"c\";i:2;s:1:\"u\";i:3;s:1:\"c\";i:4;s:1:\"6\";}', 1770739654),
('captcha_38a682a821910d14b2d2b26eb12ab2d2', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"f\";i:2;s:1:\"9\";i:3;s:1:\"x\";i:4;s:1:\"l\";}', 1772107626),
('captcha_38bca03a59e32cec80eab6748d68ad7f', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"l\";i:2;s:1:\"u\";i:3;s:1:\"w\";i:4;s:1:\"m\";}', 1771245039),
('captcha_39630c7fdc6be4776bd38a9f1f07b5f6', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"q\";i:2;s:1:\"r\";i:3;s:1:\"f\";i:4;s:1:\"r\";}', 1771061436),
('captcha_39c9a38fdf194bc84ecd36da51a81f29', 'a:5:{i:0;s:1:\"7\";i:1;s:1:\"c\";i:2;s:1:\"i\";i:3;s:1:\"j\";i:4;s:1:\"y\";}', 1770715073),
('captcha_39f3ea872f8b0057ed6269606f11ea6f', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"b\";i:2;s:1:\"p\";i:3;s:1:\"p\";i:4;s:1:\"i\";}', 1772189920),
('captcha_39f70349aeae6f416a9629c2d3d1ffbf', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"u\";i:2;s:1:\"k\";i:3;s:1:\"u\";i:4;s:1:\"j\";}', 1771843353),
('captcha_39ff7b4bb4eea5f28a45760288d537c4', 'a:5:{i:0;s:1:\"n\";i:1;s:1:\"e\";i:2;s:1:\"c\";i:3;s:1:\"l\";i:4;s:1:\"a\";}', 1770792056),
('captcha_3b4ce0bcaffeb2130d3100db315a6606', 'a:5:{i:0;s:1:\"c\";i:1;s:1:\"t\";i:2;s:1:\"q\";i:3;s:1:\"v\";i:4;s:1:\"d\";}', 1774074076),
('captcha_3cc0b3df29120141861298c23a10e4ff', 'a:5:{i:0;s:1:\"t\";i:1;s:1:\"a\";i:2;s:1:\"p\";i:3;s:1:\"u\";i:4;s:1:\"3\";}', 1772024352),
('captcha_3eaaf67039a733c6e1e4bd0c48dfef33', 'a:5:{i:0;s:1:\"j\";i:1;s:1:\"u\";i:2;s:1:\"s\";i:3;s:1:\"5\";i:4;s:1:\"v\";}', 1770739424),
('captcha_407db9d73be8087f1679ef5d7ced8d20', 'a:5:{i:0;s:1:\"9\";i:1;s:1:\"r\";i:2;s:1:\"d\";i:3;s:1:\"2\";i:4;s:1:\"c\";}', 1771225743),
('captcha_420efd0f514730b442c1cd7e673b3254', 'a:5:{i:0;s:1:\"d\";i:1;s:1:\"s\";i:2;s:1:\"i\";i:3;s:1:\"j\";i:4;s:1:\"v\";}', 1772093433),
('captcha_42c2e701a7baf242f5d12c014121a4ca', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"y\";i:2;s:1:\"h\";i:3;s:1:\"l\";i:4;s:1:\"k\";}', 1770986788),
('captcha_431c206defce1a988187f5d6a22585bb', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"5\";i:2;s:1:\"d\";i:3;s:1:\"6\";i:4;s:1:\"m\";}', 1773062491),
('captcha_4344096b8cc54079f364207f2a13eb1c', 'a:5:{i:0;s:1:\"e\";i:1;s:1:\"w\";i:2;s:1:\"r\";i:3;s:1:\"f\";i:4;s:1:\"i\";}', 1770709287),
('captcha_472c0d7e4858f75d45a8ece7e63c7615', 'a:5:{i:0;s:1:\"b\";i:1;s:1:\"k\";i:2;s:1:\"e\";i:3;s:1:\"e\";i:4;s:1:\"s\";}', 1772190818),
('captcha_4c316496be11a4c559bbe912b8099d55', 'a:5:{i:0;s:1:\"z\";i:1;s:1:\"u\";i:2;s:1:\"h\";i:3;s:1:\"j\";i:4;s:1:\"x\";}', 1770796017),
('captcha_4d4bcbca871aa427c39d4d2b698a25e0', 'a:5:{i:0;s:1:\"n\";i:1;s:1:\"c\";i:2;s:1:\"q\";i:3;s:1:\"h\";i:4;s:1:\"g\";}', 1773308520),
('captcha_4d75cafdaf0900ab9cc30c928c45a24a', 'a:5:{i:0;s:1:\"h\";i:1;s:1:\"7\";i:2;s:1:\"r\";i:3;s:1:\"n\";i:4;s:1:\"v\";}', 1770960397),
('captcha_4e262eff0ad10fee4711dde9da41cf93', 'a:5:{i:0;s:1:\"n\";i:1;s:1:\"7\";i:2;s:1:\"f\";i:3;s:1:\"o\";i:4;s:1:\"t\";}', 1773407165),
('captcha_4f6387de5bf07a97de85d2602661f05c', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"b\";i:2;s:1:\"s\";i:3;s:1:\"q\";i:4;s:1:\"q\";}', 1770984139),
('captcha_5036426c74671a9f469deaf83dce12bb', 'a:5:{i:0;s:1:\"7\";i:1;s:1:\"4\";i:2;s:1:\"5\";i:3;s:1:\"z\";i:4;s:1:\"g\";}', 1772172406),
('captcha_50c35e244be731d9ed5ba9e47f72928f', 'a:5:{i:0;s:1:\"q\";i:1;s:1:\"j\";i:2;s:1:\"w\";i:3;s:1:\"r\";i:4;s:1:\"y\";}', 1773143118),
('captcha_51890c2931bc90e9346710eb850c87b6', 'a:5:{i:0;s:1:\"x\";i:1;s:1:\"a\";i:2;s:1:\"h\";i:3;s:1:\"c\";i:4;s:1:\"y\";}', 1773393409),
('captcha_528d8e11d2411ca34611b9583ffe60a1', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"3\";i:2;s:1:\"m\";i:3;s:1:\"a\";i:4;s:1:\"t\";}', 1770983890),
('captcha_5395fb73d6402c89239f4375b9d29ce2', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"y\";i:2;s:1:\"l\";i:3;s:1:\"d\";i:4;s:1:\"h\";}', 1770739458),
('captcha_54f4fa432b66c972f6b88ab416ed6eac', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"z\";i:2;s:1:\"4\";i:3;s:1:\"l\";i:4;s:1:\"3\";}', 1773147548),
('captcha_56173f325421cd06dea63ff019037bc1', 'a:5:{i:0;s:1:\"w\";i:1;s:1:\"4\";i:2;s:1:\"r\";i:3;s:1:\"m\";i:4;s:1:\"w\";}', 1771918661),
('captcha_5663df75a20e5656dcbbc7fbd03894d9', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"t\";i:2;s:1:\"8\";i:3;s:1:\"m\";i:4;s:1:\"g\";}', 1773138465),
('captcha_5668ab2e234315bb5e082f600e26d971', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"q\";i:2;s:1:\"w\";i:3;s:1:\"a\";i:4;s:1:\"r\";}', 1771418506),
('captcha_56ee247a451a6294c70a6c3572453a04', 'a:5:{i:0;s:1:\"d\";i:1;s:1:\"t\";i:2;s:1:\"k\";i:3;s:1:\"u\";i:4;s:1:\"8\";}', 1773651988),
('captcha_571bae2a542dfae9bcda5279d075c9fc', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"1\";i:2;s:1:\"z\";i:3;s:1:\"f\";i:4;s:1:\"q\";}', 1771937385),
('captcha_571deb8db494700af5d780ca08289dce', 'a:5:{i:0;s:1:\"z\";i:1;s:1:\"i\";i:2;s:1:\"v\";i:3;s:1:\"i\";i:4;s:1:\"e\";}', 1770962646),
('captcha_5bdb29ccdfd72fd6f373acb7c09f2a6a', 'a:5:{i:0;s:1:\"o\";i:1;s:1:\"h\";i:2;s:1:\"m\";i:3;s:1:\"t\";i:4;s:1:\"m\";}', 1773463864),
('captcha_5d41d5438b7c10728b8a2afbbccbd12e', 'a:5:{i:0;s:1:\"i\";i:1;s:1:\"y\";i:2;s:1:\"6\";i:3;s:1:\"e\";i:4;s:1:\"y\";}', 1770983757),
('captcha_5d525006b1425157cad98eb623d9d0a2', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"l\";i:2;s:1:\"d\";i:3;s:1:\"t\";i:4;s:1:\"m\";}', 1771045569),
('captcha_5e27edf34194fee11de286cd79591085', 'a:5:{i:0;s:1:\"a\";i:1;s:1:\"h\";i:2;s:1:\"j\";i:3;s:1:\"k\";i:4;s:1:\"8\";}', 1773649231),
('captcha_5e5941b6b31cf49104dfb5a2e4be8b22', 'a:5:{i:0;s:1:\"o\";i:1;s:1:\"o\";i:2;s:1:\"a\";i:3;s:1:\"o\";i:4;s:1:\"8\";}', 1772775289),
('captcha_5e680ea430727a2daf283004bc5dc03b', 'a:5:{i:0;s:1:\"y\";i:1;s:1:\"n\";i:2;s:1:\"i\";i:3;s:1:\"y\";i:4;s:1:\"e\";}', 1772184558),
('captcha_5e6d053f6e6676c6c9b99a0068260775', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"k\";i:2;s:1:\"g\";i:3;s:1:\"t\";i:4;s:1:\"p\";}', 1770808721),
('captcha_5e8626fcc36c0e3cdabba0d303efa0b4', 'a:5:{i:0;s:1:\"z\";i:1;s:1:\"r\";i:2;s:1:\"h\";i:3;s:1:\"g\";i:4;s:1:\"z\";}', 1771245561),
('captcha_5fc06682e6af63c59e3505c632664115', 'a:5:{i:0;s:1:\"w\";i:1;s:1:\"e\";i:2;s:1:\"w\";i:3;s:1:\"o\";i:4;s:1:\"f\";}', 1772104213),
('captcha_6097addd8098515382f84ee18a50ba7e', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"8\";i:2;s:1:\"c\";i:3;s:1:\"k\";i:4;s:1:\"b\";}', 1770709388),
('captcha_60bc57b59514fba99ca0189fb5ab0d73', 'a:5:{i:0;s:1:\"o\";i:1;s:1:\"z\";i:2;s:1:\"n\";i:3;s:1:\"x\";i:4;s:1:\"n\";}', 1771229096),
('captcha_62badfe3e34e64a335a06be19a7bc59a', 'a:5:{i:0;s:1:\"n\";i:1;s:1:\"x\";i:2;s:1:\"0\";i:3;s:1:\"d\";i:4;s:1:\"c\";}', 1770733721),
('captcha_6343cd7278b65d16d5c273d22678cde2', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"k\";i:2;s:1:\"i\";i:3;s:1:\"o\";i:4;s:1:\"3\";}', 1773210104),
('captcha_642c1c8734a2ad25319a1982b6880a87', 'a:5:{i:0;s:1:\"d\";i:1;s:1:\"h\";i:2;s:1:\"j\";i:3;s:1:\"l\";i:4;s:1:\"e\";}', 1770708299),
('captcha_64c18e6863d4008ffe8e9ad69ebe1ea7', 'a:5:{i:0;s:1:\"o\";i:1;s:1:\"g\";i:2;s:1:\"k\";i:3;s:1:\"k\";i:4;s:1:\"m\";}', 1771302610),
('captcha_68532dd438bd7d87869052c2781aff8f', 'a:5:{i:0;s:1:\"n\";i:1;s:1:\"j\";i:2;s:1:\"s\";i:3;s:1:\"x\";i:4;s:1:\"v\";}', 1770730208),
('captcha_68dd33461f976892e53f89cc5650bce0', 'a:5:{i:0;s:1:\"g\";i:1;s:1:\"j\";i:2;s:1:\"u\";i:3;s:1:\"6\";i:4;s:1:\"7\";}', 1771390841),
('captcha_69fc0d32309810037d9b795a23744c17', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"s\";i:2;s:1:\"t\";i:3;s:1:\"d\";i:4;s:1:\"8\";}', 1771589969),
('captcha_6b254f7d55d6b29c0e471d4d4262088f', 'a:5:{i:0;s:1:\"j\";i:1;s:1:\"z\";i:2;s:1:\"o\";i:3;s:1:\"z\";i:4;s:1:\"y\";}', 1773139534),
('captcha_6cb9b35ee78199d1309498a2ce5a4735', 'a:5:{i:0;s:1:\"8\";i:1;s:1:\"l\";i:2;s:1:\"r\";i:3;s:1:\"9\";i:4;s:1:\"v\";}', 1771590674),
('captcha_6e1d6502c8d92fd4c3f9c35c096f9ec1', 'a:5:{i:0;s:1:\"i\";i:1;s:1:\"3\";i:2;s:1:\"u\";i:3;s:1:\"m\";i:4;s:1:\"u\";}', 1773399415),
('captcha_6ea690b18bac3b91604085d137c68a2d', 'a:5:{i:0;s:1:\"4\";i:1;s:1:\"7\";i:2;s:1:\"s\";i:3;s:1:\"k\";i:4;s:1:\"z\";}', 1773306682),
('captcha_6f979f00c6b4ee3c4d2767a78598ef66', 'a:5:{i:0;s:1:\"d\";i:1;s:1:\"f\";i:2;s:1:\"y\";i:3;s:1:\"y\";i:4;s:1:\"4\";}', 1770983334),
('captcha_7074a6f2a8bc378f502a20cf4fd3de7e', 'a:5:{i:0;s:1:\"q\";i:1;s:1:\"d\";i:2;s:1:\"n\";i:3;s:1:\"o\";i:4;s:1:\"n\";}', 1770984077),
('captcha_713fb72b7048609614ecb20d38b80f4e', 'a:5:{i:0;s:1:\"q\";i:1;s:1:\"z\";i:2;s:1:\"y\";i:3;s:1:\"l\";i:4;s:1:\"v\";}', 1770730094),
('captcha_72a68ce7046fac9269ba426c75eb52c7', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"m\";i:2;s:1:\"p\";i:3;s:1:\"j\";i:4;s:1:\"9\";}', 1773637512),
('captcha_756b36c8aaa71cd5ce8de4efd1b0e2ea', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"t\";i:2;s:1:\"v\";i:3;s:1:\"8\";i:4;s:1:\"7\";}', 1770983356),
('captcha_7a35d79e9daf42026abaa129c4999fea', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"k\";i:2;s:1:\"2\";i:3;s:1:\"m\";i:4;s:1:\"p\";}', 1773307477),
('captcha_7b3cb161a9b16ec27dd0e2643b43e1d1', 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"g\";i:2;s:1:\"g\";i:3;s:1:\"i\";i:4;s:1:\"m\";}', 1770967465),
('captcha_7b45d66a978057cc39e48993ce6621c9', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"v\";i:2;s:1:\"t\";i:3;s:1:\"q\";i:4;s:1:\"e\";}', 1771242828),
('captcha_7bea25e1902807fe98652a86704ff2ad', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"l\";i:2;s:1:\"t\";i:3;s:1:\"b\";i:4;s:1:\"q\";}', 1771245566),
('captcha_7c35e7bdcad2aa403f7f98634f8ed1da', 'a:5:{i:0;s:1:\"e\";i:1;s:1:\"e\";i:2;s:1:\"d\";i:3;s:1:\"v\";i:4;s:1:\"z\";}', 1772199597),
('captcha_7cb0d90af35fa7630b2660c070ddedc3', 'a:5:{i:0;s:1:\"o\";i:1;s:1:\"w\";i:2;s:1:\"m\";i:3;s:1:\"t\";i:4;s:1:\"w\";}', 1770805804),
('captcha_7fa819eaa9ea68b76877ea11b9f0d1dc', 'a:5:{i:0;s:1:\"e\";i:1;s:1:\"x\";i:2;s:1:\"9\";i:3;s:1:\"j\";i:4;s:1:\"l\";}', 1771414810),
('captcha_7fcf778e1dca4dfda6ace77983e3f639', 'a:5:{i:0;s:1:\"j\";i:1;s:1:\"4\";i:2;s:1:\"g\";i:3;s:1:\"o\";i:4;s:1:\"h\";}', 1770717332),
('captcha_7fd0b67d58e3766b0769d71764cd9bf9', 'a:5:{i:0;s:1:\"z\";i:1;s:1:\"x\";i:2;s:1:\"q\";i:3;s:1:\"y\";i:4;s:1:\"j\";}', 1772175355),
('captcha_80a992e858d72f9058ccd5bcfcd404f9', 'a:5:{i:0;s:1:\"w\";i:1;s:1:\"h\";i:2;s:1:\"r\";i:3;s:1:\"t\";i:4;s:1:\"a\";}', 1773922047),
('captcha_85a25de5f3ef91d2cee1de4da97bac64', 'a:5:{i:0;s:1:\"y\";i:1;s:1:\"l\";i:2;s:1:\"x\";i:3;s:1:\"w\";i:4;s:1:\"v\";}', 1770728976),
('captcha_85ed1469deaeef4deb53473e0bd87068', 'a:5:{i:0;s:1:\"d\";i:1;s:1:\"m\";i:2;s:1:\"f\";i:3;s:1:\"w\";i:4;s:1:\"b\";}', 1773143012),
('captcha_884195381b12214a9c899cde4bbc3f61', 'a:5:{i:0;s:1:\"f\";i:1;s:1:\"q\";i:2;s:1:\"o\";i:3;s:1:\"0\";i:4;s:1:\"g\";}', 1772020982),
('captcha_89e8a28d88a1c75589ec24ab754e1a39', 'a:5:{i:0;s:1:\"g\";i:1;s:1:\"d\";i:2;s:1:\"w\";i:3;s:1:\"x\";i:4;s:1:\"p\";}', 1770740414),
('captcha_8a01d3dae4bee87d8b2d74323f257188', 'a:5:{i:0;s:1:\"t\";i:1;s:1:\"r\";i:2;s:1:\"1\";i:3;s:1:\"8\";i:4;s:1:\"9\";}', 1770783583),
('captcha_8a354469e79559aae7a07cea853de8ef', 'a:5:{i:0;s:1:\"a\";i:1;s:1:\"0\";i:2;s:1:\"b\";i:3;s:1:\"w\";i:4;s:1:\"q\";}', 1772106460),
('captcha_8ab731e45d52c51bad41efe8e47569cd', 'a:5:{i:0;s:1:\"5\";i:1;s:1:\"d\";i:2;s:1:\"u\";i:3;s:1:\"1\";i:4;s:1:\"i\";}', 1773141024),
('captcha_8b8a0a31b42cf74dd9502872bc4afb1e', 'a:5:{i:0;s:1:\"p\";i:1;s:1:\"k\";i:2;s:1:\"j\";i:3;s:1:\"8\";i:4;s:1:\"j\";}', 1771409646),
('captcha_8babe0366723fc836b6ed0351cd0f632', 'a:5:{i:0;s:1:\"7\";i:1;s:1:\"b\";i:2;s:1:\"6\";i:3;s:1:\"x\";i:4;s:1:\"h\";}', 1773474916),
('captcha_8c34c34196944e6b6a523bd578118dd8', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"4\";i:2;s:1:\"g\";i:3;s:1:\"t\";i:4;s:1:\"w\";}', 1771653602),
('captcha_8c9a3dc8889876084262a29e8a7fccd6', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"n\";i:2;s:1:\"k\";i:3;s:1:\"6\";i:4;s:1:\"7\";}', 1771936620),
('captcha_8ce53f4ddb47caef40c00a3df5c22442', 'a:5:{i:0;s:1:\"u\";i:1;s:1:\"5\";i:2;s:1:\"8\";i:3;s:1:\"f\";i:4;s:1:\"d\";}', 1770739684),
('captcha_8e64b5b8473b09845dd519352746394b', 'a:5:{i:0;s:1:\"g\";i:1;s:1:\"y\";i:2;s:1:\"x\";i:3;s:1:\"l\";i:4;s:1:\"f\";}', 1773232810),
('captcha_8e7481edf6096572b10d17f77d0b7b71', 'a:5:{i:0;s:1:\"y\";i:1;s:1:\"2\";i:2;s:1:\"m\";i:3;s:1:\"9\";i:4;s:1:\"n\";}', 1771564424),
('captcha_8f53a4828b89c17ae355a912d2d78e73', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"m\";i:2;s:1:\"n\";i:3;s:1:\"1\";i:4;s:1:\"r\";}', 1771223629),
('captcha_91eb7ce3a04adfd1c5331abe0517c210', 'a:5:{i:0;s:1:\"6\";i:1;s:1:\"q\";i:2;s:1:\"s\";i:3;s:1:\"j\";i:4;s:1:\"8\";}', 1773634658),
('captcha_92471157dc27162c0674c67537ab4088', 'a:5:{i:0;s:1:\"c\";i:1;s:1:\"7\";i:2;s:1:\"v\";i:3;s:1:\"n\";i:4;s:1:\"q\";}', 1771331116),
('captcha_92758b87c57bc248a12c2251ae21d504', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"j\";i:2;s:1:\"g\";i:3;s:1:\"v\";i:4;s:1:\"b\";}', 1770708237),
('captcha_935bdadbb63bf5761d7a6c497971d1d0', 'a:5:{i:0;s:1:\"q\";i:1;s:1:\"6\";i:2;s:1:\"m\";i:3;s:1:\"w\";i:4;s:1:\"v\";}', 1772019755),
('captcha_950e0f683cdd1b4b357fe55499032274', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"6\";i:2;s:1:\"x\";i:3;s:1:\"c\";i:4;s:1:\"6\";}', 1772104954),
('captcha_956bb3c5a482bf5ae31ce79a9544cf9f', 'a:5:{i:0;s:1:\"3\";i:1;s:1:\"t\";i:2;s:1:\"i\";i:3;s:1:\"9\";i:4;s:1:\"r\";}', 1773634764),
('captcha_969c9f6847021a12e1c3a32b9fd9d9e5', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"a\";i:2;s:1:\"6\";i:3;s:1:\"x\";i:4;s:1:\"a\";}', 1772169003),
('captcha_983b6d9ab6a90b4987a1d79109030a83', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"k\";i:2;s:1:\"u\";i:3;s:1:\"k\";i:4;s:1:\"l\";}', 1771246224),
('captcha_98bc27c7569f9dc6548af79989aaf91e', 'a:5:{i:0;s:1:\"g\";i:1;s:1:\"m\";i:2;s:1:\"m\";i:3;s:1:\"9\";i:4;s:1:\"f\";}', 1772882190),
('captcha_9b5eefa89a2210fe5ae8ac3e1cb00369', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"o\";i:2;s:1:\"m\";i:3;s:1:\"n\";i:4;s:1:\"c\";}', 1771917742),
('captcha_9c8de11b65e0b0def2b9cdd67b68c9f4', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"r\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"g\";}', 1771994383),
('captcha_9d53b6c98056a47493b740cc410cfc47', 'a:5:{i:0;s:1:\"i\";i:1;s:1:\"i\";i:2;s:1:\"h\";i:3;s:1:\"d\";i:4;s:1:\"c\";}', 1773059375),
('captcha_a05e5cd69c68f28ff600907b11c4612e', 'a:5:{i:0;s:1:\"d\";i:1;s:1:\"v\";i:2;s:1:\"v\";i:3;s:1:\"y\";i:4;s:1:\"v\";}', 1773652996),
('captcha_a1e83608cde91c81767a78060a8747be', 'a:5:{i:0;s:1:\"c\";i:1;s:1:\"l\";i:2;s:1:\"9\";i:3;s:1:\"q\";i:4;s:1:\"9\";}', 1770715144),
('captcha_a310b8a0683fded053c4aec36d195238', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"v\";i:2;s:1:\"m\";i:3;s:1:\"d\";i:4;s:1:\"i\";}', 1770729851),
('captcha_a4567050b685de513d5759b74946b262', 'a:5:{i:0;s:1:\"y\";i:1;s:1:\"v\";i:2;s:1:\"k\";i:3;s:1:\"b\";i:4;s:1:\"q\";}', 1773463588),
('captcha_a6526d46782e0caf6347a7c5a22f47a7', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"f\";i:2;s:1:\"t\";i:3;s:1:\"p\";i:4;s:1:\"a\";}', 1771917901),
('captcha_a6823e59dfbbbd51160fce18372ca1a6', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"a\";i:2;s:1:\"x\";i:3;s:1:\"s\";i:4;s:1:\"f\";}', 1772277322),
('captcha_a7d14a2962d28dd814c8bc7e11c3f5c7', 'a:5:{i:0;s:1:\"j\";i:1;s:1:\"k\";i:2;s:1:\"w\";i:3;s:1:\"c\";i:4;s:1:\"a\";}', 1770718138),
('captcha_a7e9b1b540abbea0d65126bcbcde57e6', 'a:5:{i:0;s:1:\"q\";i:1;s:1:\"t\";i:2;s:1:\"f\";i:3;s:1:\"r\";i:4;s:1:\"t\";}', 1770740240),
('captcha_a840c061a875f0cce3857119ab18751f', 'a:5:{i:0;s:1:\"t\";i:1;s:1:\"f\";i:2;s:1:\"v\";i:3;s:1:\"j\";i:4;s:1:\"g\";}', 1770740546),
('captcha_a9c54cc87f8fc971476ce11fe015654d', 'a:5:{i:0;s:1:\"0\";i:1;s:1:\"8\";i:2;s:1:\"q\";i:3;s:1:\"s\";i:4;s:1:\"g\";}', 1770714999),
('captcha_aa4ae268d63bcbe4a81c169f8c67ad8e', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"s\";i:2;s:1:\"e\";i:3;s:1:\"8\";i:4;s:1:\"q\";}', 1774002549),
('captcha_abc58ac796ac0f3ce0502b93a85fc6e3', 'a:5:{i:0;s:1:\"x\";i:1;s:1:\"t\";i:2;s:1:\"1\";i:3;s:1:\"b\";i:4;s:1:\"q\";}', 1772272606),
('captcha_abe66d2d716c324a4d860a7ee3db0ca7', 'a:5:{i:0;s:1:\"o\";i:1;s:1:\"l\";i:2;s:1:\"z\";i:3;s:1:\"o\";i:4;s:1:\"5\";}', 1770740145),
('captcha_ac6a6ec4ff53a24b3ae035757fe85a13', 'a:5:{i:0;s:1:\"y\";i:1;s:1:\"g\";i:2;s:1:\"k\";i:3;s:1:\"l\";i:4;s:1:\"a\";}', 1770709288),
('captcha_acd1f1d82fa65971c15491c67a7489dd', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"p\";i:2;s:1:\"b\";i:3;s:1:\"b\";i:4;s:1:\"u\";}', 1771388421),
('captcha_ad0debc408239a3995b4e1c5febc5fe2', 'a:5:{i:0;s:1:\"z\";i:1;s:1:\"b\";i:2;s:1:\"w\";i:3;s:1:\"v\";i:4;s:1:\"d\";}', 1773465365),
('captcha_adafb0604fb0101e7db51e59c58d753f', 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"f\";i:2;s:1:\"v\";i:3;s:1:\"q\";i:4;s:1:\"u\";}', 1770739375),
('captcha_af6fe27c0475aacbfc137393e7af3b92', 'a:5:{i:0;s:1:\"m\";i:1;s:1:\"0\";i:2;s:1:\"n\";i:3;s:1:\"a\";i:4;s:1:\"v\";}', 1773137433),
('captcha_af90c835626861bfc04269d9b3cd190d', 'a:5:{i:0;s:1:\"0\";i:1;s:1:\"z\";i:2;s:1:\"e\";i:3;s:1:\"a\";i:4;s:1:\"n\";}', 1771331534),
('captcha_b12a4eced4b6fcbc0a0b230284349c6a', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"o\";i:2;s:1:\"w\";i:3;s:1:\"g\";i:4;s:1:\"j\";}', 1773217647),
('captcha_b59411afdc25fe3e1a79811fd3fcd5dc', 'a:5:{i:0;s:1:\"w\";i:1;s:1:\"t\";i:2;s:1:\"c\";i:3;s:1:\"n\";i:4;s:1:\"s\";}', 1771047032),
('captcha_b5b121a8e303568ad37ad5994e8ad62c', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"r\";i:2;s:1:\"x\";i:3;s:1:\"x\";i:4;s:1:\"m\";}', 1772264291),
('captcha_b5b62ae0183671d1e84cbd55d165158d', 'a:5:{i:0;s:1:\"j\";i:1;s:1:\"i\";i:2;s:1:\"t\";i:3;s:1:\"g\";i:4;s:1:\"6\";}', 1770715113),
('captcha_b5faa8eccd7d872be1a80dc101c554b0', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"u\";i:2;s:1:\"g\";i:3;s:1:\"y\";i:4;s:1:\"3\";}', 1772014075),
('captcha_b684b33a9ce5fac50cc098c537fca45d', 'a:5:{i:0;s:1:\"9\";i:1;s:1:\"b\";i:2;s:1:\"i\";i:3;s:1:\"a\";i:4;s:1:\"0\";}', 1773468031),
('captcha_b7ca425607548f72b55cdf07543d1e14', 'a:5:{i:0;s:1:\"x\";i:1;s:1:\"4\";i:2;s:1:\"k\";i:3;s:1:\"3\";i:4;s:1:\"k\";}', 1773137760),
('captcha_b80114e89367c013baf5d519332fe5a5', 'a:5:{i:0;s:1:\"i\";i:1;s:1:\"k\";i:2;s:1:\"f\";i:3;s:1:\"s\";i:4;s:1:\"i\";}', 1772016550),
('captcha_b859aa1c5ef5f343407b39156fa8a035', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"o\";i:2;s:1:\"b\";i:3;s:1:\"v\";i:4;s:1:\"3\";}', 1770740550),
('captcha_b8f7d60f2cb90018274a94b6770cec29', 'a:5:{i:0;s:1:\"l\";i:1;s:1:\"r\";i:2;s:1:\"b\";i:3;s:1:\"r\";i:4;s:1:\"v\";}', 1770729995),
('captcha_bb32ae23f64af1dd36ed82a489ab12cf', 'a:5:{i:0;s:1:\"4\";i:1;s:1:\"o\";i:2;s:1:\"m\";i:3;s:1:\"a\";i:4;s:1:\"o\";}', 1771412747),
('captcha_bc298382fecca5b6b607747e6e772a73', 'a:5:{i:0;s:1:\"6\";i:1;s:1:\"w\";i:2;s:1:\"g\";i:3;s:1:\"u\";i:4;s:1:\"c\";}', 1770984065),
('captcha_bd3c0b1d75e69516ea2d8c5b26d7ff9a', 'a:5:{i:0;s:1:\"c\";i:1;s:1:\"r\";i:2;s:1:\"u\";i:3;s:1:\"d\";i:4;s:1:\"c\";}', 1771933500),
('captcha_be6f18ec9a6fb6dcf024629270393b8d', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"f\";i:2;s:1:\"h\";i:3;s:1:\"f\";i:4;s:1:\"x\";}', 1773307571),
('captcha_becf83a442283427763881824e4812e9', 'a:5:{i:0;s:1:\"x\";i:1;s:1:\"h\";i:2;s:1:\"b\";i:3;s:1:\"5\";i:4;s:1:\"d\";}', 1771489607),
('captcha_c0e1b09eacc3d3456013653b047cde86', 'a:5:{i:0;s:1:\"p\";i:1;s:1:\"l\";i:2;s:1:\"t\";i:3;s:1:\"m\";i:4;s:1:\"r\";}', 1774072022),
('captcha_c20d3e8c443d8f0bb9cc9e9b88a3e101', 'a:5:{i:0;s:1:\"3\";i:1;s:1:\"0\";i:2;s:1:\"a\";i:3;s:1:\"t\";i:4;s:1:\"y\";}', 1770715006),
('captcha_c58476bf5ed120f37e3f4b15ddcb3153', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"e\";i:2;s:1:\"l\";i:3;s:1:\"n\";i:4;s:1:\"e\";}', 1771676410),
('captcha_c5b8948015a8f4bc0432e33c77fd8ce8', 'a:5:{i:0;s:1:\"8\";i:1;s:1:\"u\";i:2;s:1:\"c\";i:3;s:1:\"x\";i:4;s:1:\"w\";}', 1771493517),
('captcha_c6629262348f6ea24fbaf4cc0ba85bd9', 'a:5:{i:0;s:1:\"y\";i:1;s:1:\"d\";i:2;s:1:\"q\";i:3;s:1:\"g\";i:4;s:1:\"c\";}', 1770984576),
('captcha_c6b855184a3b2a433b7d5c90765906aa', 'a:5:{i:0;s:1:\"h\";i:1;s:1:\"e\";i:2;s:1:\"h\";i:3;s:1:\"i\";i:4;s:1:\"n\";}', 1773309405),
('captcha_c6ead31fd658b199cbae1f54dba2185f', 'a:5:{i:0;s:1:\"q\";i:1;s:1:\"z\";i:2;s:1:\"o\";i:3;s:1:\"t\";i:4;s:1:\"8\";}', 1770739434),
('captcha_c93388fddd7fb49bb757fe8f6ff61785', 'a:5:{i:0;s:1:\"0\";i:1;s:1:\"y\";i:2;s:1:\"h\";i:3;s:1:\"0\";i:4;s:1:\"m\";}', 1773314585),
('captcha_ca405dae221b0a2cdc0974f79931f6ab', 'a:5:{i:0;s:1:\"n\";i:1;s:1:\"n\";i:2;s:1:\"t\";i:3;s:1:\"k\";i:4;s:1:\"i\";}', 1772092248),
('captcha_cc8a81ecca63991a1fd64c0d2c44a49d', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"v\";i:2;s:1:\"9\";i:3;s:1:\"e\";i:4;s:1:\"f\";}', 1773136134),
('captcha_cd0c2addcf6f8d2feb892ebc6a533954', 'a:5:{i:0;s:1:\"v\";i:1;s:1:\"c\";i:2;s:1:\"l\";i:3;s:1:\"r\";i:4;s:1:\"v\";}', 1773394693),
('captcha_d0f447e97a13e71306dc1687defee92a', 'a:5:{i:0;s:1:\"9\";i:1;s:1:\"v\";i:2;s:1:\"i\";i:3;s:1:\"5\";i:4;s:1:\"r\";}', 1771411412),
('captcha_d2c1b71abc4be72aff535328a909143c', 'a:5:{i:0;s:1:\"6\";i:1;s:1:\"q\";i:2;s:1:\"b\";i:3;s:1:\"n\";i:4;s:1:\"3\";}', 1770708050),
('captcha_d32eae4d4239a08075d34483d1770573', 'a:5:{i:0;s:1:\"u\";i:1;s:1:\"f\";i:2;s:1:\"x\";i:3;s:1:\"a\";i:4;s:1:\"o\";}', 1771572244),
('captcha_d4353b6f3e76038c6c261ff5fcdd607a', 'a:5:{i:0;s:1:\"y\";i:1;s:1:\"f\";i:2;s:1:\"e\";i:3;s:1:\"j\";i:4;s:1:\"o\";}', 1771418293),
('captcha_d4d9beac44f1e3745a3965833d6bec5d', 'a:5:{i:0;s:1:\"c\";i:1;s:1:\"f\";i:2;s:1:\"l\";i:3;s:1:\"s\";i:4;s:1:\"d\";}', 1773637979),
('captcha_d52552c271a50601ad1f19180e5c3bde', 'a:5:{i:0;s:1:\"z\";i:1;s:1:\"m\";i:2;s:1:\"y\";i:3;s:1:\"u\";i:4;s:1:\"u\";}', 1771415577),
('captcha_da2c07afe76fd52b7f48054d65636305', 'a:5:{i:0;s:1:\"t\";i:1;s:1:\"j\";i:2;s:1:\"r\";i:3;s:1:\"5\";i:4;s:1:\"f\";}', 1772791589),
('captcha_db6e612710633fe732861f60792f8151', 'a:5:{i:0;s:1:\"c\";i:1;s:1:\"y\";i:2;s:1:\"b\";i:3;s:1:\"u\";i:4;s:1:\"1\";}', 1771258175),
('captcha_dce3bbe22f0855f337b7c7f59d2ac990', 'a:5:{i:0;s:1:\"h\";i:1;s:1:\"v\";i:2;s:1:\"u\";i:3;s:1:\"s\";i:4;s:1:\"y\";}', 1773137314),
('captcha_dd51946f5b3e5f965de6bf428b2858a9', 'a:5:{i:0;s:1:\"k\";i:1;s:1:\"v\";i:2;s:1:\"n\";i:3;s:1:\"j\";i:4;s:1:\"5\";}', 1773395633),
('captcha_dd533461fe43c66ff559a96375b06dcc', 'a:5:{i:0;s:1:\"g\";i:1;s:1:\"4\";i:2;s:1:\"z\";i:3;s:1:\"7\";i:4;s:1:\"9\";}', 1772510550),
('captcha_def39978bc0a7908e4977d13200fea45', 'a:5:{i:0;s:1:\"0\";i:1;s:1:\"p\";i:2;s:1:\"j\";i:3;s:1:\"x\";i:4;s:1:\"7\";}', 1770792128),
('captcha_e176046ecf7eb04c92db22d265ae95e2', 'a:5:{i:0;s:1:\"h\";i:1;s:1:\"q\";i:2;s:1:\"i\";i:3;s:1:\"c\";i:4;s:1:\"u\";}', 1773492783),
('captcha_e1f592ae63ee225ccce07dc0dd7ef8d3', 'a:5:{i:0;s:1:\"w\";i:1;s:1:\"h\";i:2;s:1:\"h\";i:3;s:1:\"b\";i:4;s:1:\"x\";}', 1771388382),
('captcha_e2db92dc3043f7a15a0f29afae63435f', 'a:5:{i:0;s:1:\"c\";i:1;s:1:\"q\";i:2;s:1:\"a\";i:3;s:1:\"s\";i:4;s:1:\"e\";}', 1773721787),
('captcha_e2ec726e0ed64e2d550c1451758cb9a0', 'a:5:{i:0;s:1:\"y\";i:1;s:1:\"t\";i:2;s:1:\"m\";i:3;s:1:\"r\";i:4;s:1:\"f\";}', 1772197676),
('captcha_e41cd17260bef30acb24e1fa1d07867d', 'a:5:{i:0;s:1:\"f\";i:1;s:1:\"v\";i:2;s:1:\"x\";i:3;s:1:\"h\";i:4;s:1:\"y\";}', 1773482730),
('captcha_e428594279a3c750d2997c85539f2a89', 'a:5:{i:0;s:1:\"p\";i:1;s:1:\"v\";i:2;s:1:\"g\";i:3;s:1:\"g\";i:4;s:1:\"v\";}', 1771044745),
('captcha_e5ec2bc22abba14238180e65a06b5b8a', 'a:5:{i:0;s:1:\"w\";i:1;s:1:\"5\";i:2;s:1:\"f\";i:3;s:1:\"r\";i:4;s:1:\"f\";}', 1773215288),
('captcha_e62db63b05df1747e6275b640f81c089', 'a:5:{i:0;s:1:\"w\";i:1;s:1:\"9\";i:2;s:1:\"z\";i:3;s:1:\"i\";i:4;s:1:\"n\";}', 1770739464),
('captcha_e6b12aadad892f57498dd10df0e27a9f', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"c\";i:2;s:1:\"c\";i:3;s:1:\"f\";i:4;s:1:\"t\";}', 1771933264),
('captcha_e6d5ec2bdccd9b1fc67565bd8a256798', 'a:5:{i:0;s:1:\"b\";i:1;s:1:\"t\";i:2;s:1:\"t\";i:3;s:1:\"2\";i:4;s:1:\"l\";}', 1773386297),
('captcha_ea5c4465850f1b8efd276759dbdb7dd1', 'a:5:{i:0;s:1:\"a\";i:1;s:1:\"s\";i:2;s:1:\"f\";i:3;s:1:\"d\";i:4;s:1:\"v\";}', 1773636456),
('captcha_ec018b8ca34bcf45e81e4a266cdb11e0', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"t\";i:2;s:1:\"c\";i:3;s:1:\"l\";i:4;s:1:\"f\";}', 1770983796),
('captcha_f10df9918c321ba6a40a38d4c31e5920', 'a:5:{i:0;s:1:\"s\";i:1;s:1:\"5\";i:2;s:1:\"3\";i:3;s:1:\"l\";i:4;s:1:\"a\";}', 1773307521),
('captcha_f1fda701400b8ac37ca4993cea575f0d', 'a:5:{i:0;s:1:\"d\";i:1;s:1:\"d\";i:2;s:1:\"y\";i:3;s:1:\"a\";i:4;s:1:\"o\";}', 1773296798),
('captcha_f28b1d07b324f2de3607cd807cd1e57e', 'a:5:{i:0;s:1:\"r\";i:1;s:1:\"p\";i:2;s:1:\"c\";i:3;s:1:\"r\";i:4;s:1:\"s\";}', 1773812689),
('captcha_f3697414b1dc918f1356925631d15244', 'a:5:{i:0;s:1:\"x\";i:1;s:1:\"v\";i:2;s:1:\"4\";i:3;s:1:\"7\";i:4;s:1:\"z\";}', 1771936332),
('captcha_f385579e545952066a65a993548c37a8', 'a:5:{i:0;s:1:\"t\";i:1;s:1:\"f\";i:2;s:1:\"e\";i:3;s:1:\"1\";i:4;s:1:\"x\";}', 1773403401),
('captcha_f3d223bb311b84391f1233896cc491c9', 'a:5:{i:0;s:1:\"y\";i:1;s:1:\"f\";i:2;s:1:\"8\";i:3;s:1:\"k\";i:4;s:1:\"n\";}', 1771493780),
('captcha_f84d921d2310bec9cad9a4ca99d08776', 'a:5:{i:0;s:1:\"z\";i:1;s:1:\"g\";i:2;s:1:\"m\";i:3;s:1:\"g\";i:4;s:1:\"9\";}', 1770962043),
('captcha_f9cb5b0068a421c3f835753d127f00f3', 'a:5:{i:0;s:1:\"b\";i:1;s:1:\"0\";i:2;s:1:\"u\";i:3;s:1:\"c\";i:4;s:1:\"y\";}', 1773406858),
('captcha_fb7ef64e6a3b04dd2526a7fd31fd7417', 'a:5:{i:0;s:1:\"0\";i:1;s:1:\"y\";i:2;s:1:\"x\";i:3;s:1:\"x\";i:4;s:1:\"n\";}', 1771916422),
('captcha_fbcf7cf6e1ddb016feda2df646075dbc', 'a:5:{i:0;s:1:\"5\";i:1;s:1:\"p\";i:2;s:1:\"n\";i:3;s:1:\"2\";i:4;s:1:\"l\";}', 1771242821),
('captcha_ff4667b2d23be0af2a091abb1644e781', 'a:5:{i:0;s:1:\"f\";i:1;s:1:\"3\";i:2;s:1:\"5\";i:3;s:1:\"m\";i:4;s:1:\"g\";}', 1773136354),
('divisions-list', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:19:\"App\\Models\\Division\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"divisions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:16:\"Dhanbad Division\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:16:\"Dhanbad Division\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:13:\"division_code\";i:2;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Division\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"divisions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:14:\"Dumka Division\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:14:\"Dumka Division\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:13:\"division_code\";i:2;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Division\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"divisions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:18:\"Hazaribag Division\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:18:\"Hazaribag Division\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:13:\"division_code\";i:2;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Division\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"divisions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:2;s:4:\"name\";s:19:\"Jamshedpur Division\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:2;s:4:\"name\";s:19:\"Jamshedpur Division\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:13:\"division_code\";i:2;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Division\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"divisions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:15:\"Ranchi Division\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:15:\"Ranchi Division\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:13:\"division_code\";i:2;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1774242829);

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
(780, 36, 'Uttar Dinajpur', 'उत्तर दिनाजपुर', '2026-02-28 11:03:31', '2026-02-28 11:03:31'),
(781, 37, 'Bokaro', 'बोकारो', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(782, 37, 'Chatra', 'चतरा', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(783, 37, 'Deoghar', 'देवघर', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(784, 37, 'Dhanbad', 'धनबाद', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(785, 37, 'Dumka', 'दुमका', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(786, 37, 'East Singhbhum', 'पूर्वी सिंहभूम', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(787, 37, 'Garhwa', 'गढ़वा', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(788, 37, 'Giridih', 'गिरिडीह', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(789, 37, 'Godda', 'गोड्डा', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(790, 37, 'Gumla', 'गुमला', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(791, 37, 'Hazaribagh', 'हजारीबाग', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(792, 37, 'Jamtara', 'जामताड़ा', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(793, 37, 'Khunti', 'खूंटी', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(794, 37, 'Koderma', 'कोडरमा', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(795, 37, 'Latehar', 'लातेहार', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(796, 37, 'Lohardaga', 'लोहरदगा', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(797, 37, 'Pakur', 'पाकुड़', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(798, 37, 'Palamu', 'पलामू', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(799, 37, 'Ramgarh', 'रामगढ़', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(800, 37, 'Ranchi', 'रांची', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(801, 37, 'Sahibganj', 'साहिबगंज', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(802, 37, 'Seraikela Kharsawan', 'सरायकेला खरसावां', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(803, 37, 'Simdega', 'सिमडेगा', '2026-02-28 05:33:30', '2026-02-28 05:33:30'),
(804, 37, 'West Singhbhum', 'पश्चिमी सिंहभूम', '2026-02-28 05:33:30', '2026-02-28 05:33:30');

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
(17, 'Registry Deed', 'name_transfer_registry_deed', 'nameTransfer', 9, 1, '2026-03-09 09:26:18', '2026-03-09 09:26:18'),
(18, 'Property Map', 'property_map', 'basic', 9, 1, '2026-03-14 10:05:28', NULL),
(19, 'Noting Sheet', 'noting_sheet', 'basic', 10, 1, '2026-03-14 10:05:28', NULL);

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
(1, '1602268136', 'Files-Receiving-1602268136-1771245002.pdf', 'uploads/1602268136/files/Files-Receiving-1602268136-1771245002.pdf', 159852, '2026-02-16 12:30:03', NULL),
(2, '1602268136', 'Files-Receiving-1602268136-1771304396.pdf', 'uploads/1602268136/files/Files-Receiving-1602268136-1771304396.pdf', 159861, '2026-02-17 04:59:57', NULL),
(3, '1602268136', 'Files-Receiving-1602268136-1771304861.pdf', 'uploads/1602268136/files/Files-Receiving-1602268136-1771304861.pdf', 159895, '2026-02-17 05:07:42', NULL),
(4, '1602268136', 'Files-Receiving-1602268136-1771305262.pdf', 'uploads/1602268136/files/Files-Receiving-1602268136-1771305262.pdf', 159958, '2026-02-17 05:14:23', NULL),
(5, '1602268136', 'Files-Receiving-1602268136-1771305336.pdf', 'uploads/1602268136/files/Files-Receiving-1602268136-1771305336.pdf', 159754, '2026-02-17 05:15:36', NULL),
(6, '1602268136', 'Files-Receiving-1602268136-1771305379.pdf', 'uploads/1602268136/files/Files-Receiving-1602268136-1771305379.pdf', 159755, '2026-02-17 05:16:19', NULL),
(7, '1602268136', 'Files-Receiving-1602268136-1771305459.pdf', 'uploads/1602268136/files/Files-Receiving-1602268136-1771305459.pdf', 159763, '2026-02-17 05:17:40', NULL),
(8, '1602268136', '1702267279-ced-jshb-receiving.pdf', 'uploads/1602268136/files/1702267279-ced-jshb-receiving.pdf', 159863, '2026-02-17 06:30:20', NULL),
(9, '1602268136', '1702262046-ced-jshb-receiving.pdf', 'uploads/1602268136/files/1702262046-ced-jshb-receiving.pdf', 159892, '2026-02-17 06:33:32', NULL),
(10, '1702265322', '1702269760-ced-jshb-receiving.pdf', 'uploads/1702265322/files/1702269760-ced-jshb-receiving.pdf', 152014, '2026-02-17 12:56:35', NULL),
(11, '1602268136', '1702261948-ced-jshb-receiving.pdf', 'uploads/1602268136/files/1702261948-ced-jshb-receiving.pdf', 159891, '2026-02-17 12:58:19', NULL),
(12, '1802264319', '1802266697-ced-jshb-receiving.pdf', 'uploads/1802264319/files/1802266697-ced-jshb-receiving.pdf', 158347, '2026-02-18 11:02:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file_registrations`
--

CREATE TABLE `file_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `register_no` varchar(20) NOT NULL,
  `lot_no` varchar(100) DEFAULT NULL,
  `total_files` int(11) DEFAULT 0,
  `allowed_files` varchar(50) NOT NULL DEFAULT '15',
  `remarks` varchar(255) DEFAULT NULL,
  `status` enum('handover','received','scanned','dataentry') DEFAULT 'received',
  `scanned_by` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_registrations`
--

INSERT INTO `file_registrations` (`id`, `register_no`, `lot_no`, `total_files`, `allowed_files`, `remarks`, `status`, `scanned_by`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '1602268136', 'Lot-1', 12, '15', NULL, 'scanned', 2, 2, '2026-02-16 06:36:59', '2026-02-24 11:17:54'),
(2, '1802263052', 'Lot-2', 12, '12', NULL, 'scanned', 2, 2, '2026-02-17 23:45:48', '2026-02-24 11:41:46'),
(3, '1802264319', 'Lot-3', 10, '10', NULL, 'scanned', 3, 3, '2026-02-18 03:49:32', '2026-02-24 11:46:55'),
(4, '1802263693', 'Lot-4', 12, '12', NULL, 'scanned', 2, 2, '2026-02-18 07:09:24', '2026-02-24 11:50:44'),
(5, '2102262879', 'Lot-5', 20, '20', NULL, 'scanned', 3, 3, '2026-02-20 23:54:33', '2026-02-27 06:37:57'),
(6, '2702263432', 'Lot-6', 12, '12', NULL, 'scanned', 3, 3, '2026-02-27 09:31:08', '2026-03-09 11:38:04'),
(7, '2702263032', 'Lot-7', 11, '11', NULL, 'scanned', 3, 3, '2026-02-27 13:06:48', '2026-03-09 11:35:05'),
(8, '0903268389', 'Lot-8', 20, '20', NULL, 'scanned', 3, 3, '2026-03-09 12:11:08', '2026-03-11 07:46:32'),
(9, '1103265912', 'Lot-9', 22, '22', NULL, 'received', NULL, 3, '2026-03-11 12:08:56', '2026-03-14 07:25:54'),
(10, '1303264283', 'Lot-10', 11, '11', NULL, 'scanned', 6, 6, '2026-03-14 07:48:59', '2026-03-17 05:38:15'),
(11, '1403264329', 'Lot-11', 9, '9', NULL, 'received', NULL, 5, '2026-03-14 06:56:53', '2026-03-14 07:26:06'),
(12, '1703266901', 'Lot-12', 11, '12', NULL, 'received', NULL, 4, '2026-03-17 07:40:34', '2026-03-17 07:40:34'),
(13, '1703267993', 'Lot-13', 11, '11', NULL, 'received', NULL, 3, '2026-03-17 09:43:38', '2026-03-17 10:12:40'),
(14, '1703264455', 'Lot-14', 11, '11', NULL, 'received', NULL, 3, '2026-03-17 10:26:32', '2026-03-17 10:26:32'),
(15, '1703263462', 'Lot-15', 11, '11', NULL, 'received', NULL, 6, '2026-03-17 10:54:27', '2026-03-17 10:54:27'),
(16, '1803264686', 'Lot-16', 12, '13', NULL, 'received', NULL, 4, '2026-03-19 05:25:02', '2026-03-19 05:25:02'),
(17, '1803268798', 'Lot-17', 13, '13', NULL, 'received', NULL, 4, '2026-03-18 12:27:26', '2026-03-18 12:27:26');

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
-- Table structure for table `joint_allottees`
--

CREATE TABLE `joint_allottees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allottee_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Reference to main allottee (applicant)',
  `prefix` varchar(20) DEFAULT 'Shri' COMMENT 'Title/Prefix (Shri, Smt., Dr., etc.)',
  `first_name` varchar(100) NOT NULL COMMENT 'First name in English',
  `middle_name` varchar(100) DEFAULT NULL COMMENT 'Middle name in English',
  `last_name` varchar(100) DEFAULT NULL COMMENT 'Last name/Surname in English',
  `prefix_hindi` varchar(50) DEFAULT 'श्री' COMMENT 'Title/Prefix in Hindi',
  `first_name_hindi` varchar(200) DEFAULT NULL COMMENT 'First name in Hindi',
  `middle_name_hindi` varchar(200) DEFAULT NULL COMMENT 'Middle name in Hindi',
  `last_name_hindi` varchar(200) DEFAULT NULL COMMENT 'Last name/Surname in Hindi',
  `gender` enum('Male','Female','Transgender') DEFAULT NULL COMMENT 'Gender of joint allottee',
  `aadhar_number` varchar(12) DEFAULT NULL COMMENT '12-digit Aadhar number',
  `pan_number` varchar(10) DEFAULT NULL COMMENT '10-digit PAN number',
  `other_doc_type` enum('driving_license','passport','voter_id') DEFAULT NULL COMMENT 'Type of other document',
  `other_doc_number` varchar(100) DEFAULT NULL COMMENT 'Other document number',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `joint_allottees`
--

INSERT INTO `joint_allottees` (`id`, `allottee_id`, `prefix`, `first_name`, `middle_name`, `last_name`, `prefix_hindi`, `first_name_hindi`, `middle_name_hindi`, `last_name_hindi`, `gender`, `aadhar_number`, `pan_number`, `other_doc_type`, `other_doc_number`, `created_at`, `updated_at`) VALUES
(1, 48, 'Shri', 'Kritika', NULL, 'Kumari', 'श्री', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, '2026-03-23 04:28:59', '2026-03-23 04:28:59'),
(2, 48, 'Shri', 'Shivam', NULL, 'Kumar', 'श्री', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, '2026-03-23 04:28:59', '2026-03-23 04:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `lot_assignments`
--

CREATE TABLE `lot_assignments` (
  `id` bigint(20) NOT NULL,
  `lot_id` bigint(20) NOT NULL,
  `allottee_id` bigint(20) DEFAULT NULL,
  `assigned_to` bigint(20) NOT NULL,
  `assigned_by` bigint(20) NOT NULL,
  `assignment_type` enum('full_lot','partial') NOT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `assigned_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lot_assignments`
--

INSERT INTO `lot_assignments` (`id`, `lot_id`, `allottee_id`, `assigned_to`, `assigned_by`, `assignment_type`, `status`, `assigned_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 3, 45, 4, 11, 'partial', 'completed', '2026-03-21 06:22:51', '2026-03-21 07:27:29', NULL, '2026-03-21 06:36:29'),
(2, 3, 43, 4, 11, 'partial', 'completed', '2026-03-21 06:22:51', '2026-03-21 08:43:22', NULL, '2026-03-21 08:20:09'),
(3, 3, 41, 4, 11, 'partial', 'completed', '2026-03-21 06:22:51', '2026-03-21 08:57:56', NULL, '2026-03-21 08:46:44'),
(4, 3, 39, 4, 11, 'partial', 'completed', '2026-03-21 06:22:51', '2026-03-21 09:11:07', NULL, '2026-03-21 09:00:27'),
(5, 3, 37, 4, 11, 'partial', 'completed', '2026-03-21 06:22:51', '2026-03-21 07:49:30', NULL, '2026-03-21 07:34:54'),
(6, 3, 46, 2, 11, 'partial', 'pending', '2026-03-21 06:23:47', NULL, NULL, NULL),
(7, 3, 44, 2, 11, 'partial', 'completed', '2026-03-21 06:23:47', '2026-03-21 07:29:45', NULL, '2026-03-21 06:41:23'),
(8, 3, 42, 2, 11, 'partial', 'in_progress', '2026-03-21 06:23:47', NULL, NULL, '2026-03-21 09:16:56'),
(9, 3, 40, 2, 11, 'partial', 'completed', '2026-03-21 06:23:47', '2026-03-21 08:46:51', NULL, '2026-03-21 08:27:46'),
(10, 3, 38, 2, 11, 'partial', 'completed', '2026-03-21 06:23:47', '2026-03-21 09:22:56', NULL, '2026-03-21 08:52:54');

-- --------------------------------------------------------

--
-- Table structure for table `lot_assignment_logs`
--

CREATE TABLE `lot_assignment_logs` (
  `id` bigint(20) NOT NULL,
  `assignment_id` bigint(20) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lot_assignment_logs`
--

INSERT INTO `lot_assignment_logs` (`id`, `assignment_id`, `action`, `user_id`, `created_at`) VALUES
(1, 1, 'assigned', 11, '2026-03-21 06:22:51'),
(2, 2, 'assigned', 11, '2026-03-21 06:22:51'),
(3, 3, 'assigned', 11, '2026-03-21 06:22:51'),
(4, 4, 'assigned', 11, '2026-03-21 06:22:51'),
(5, 5, 'assigned', 11, '2026-03-21 06:22:51'),
(6, 6, 'assigned', 11, '2026-03-21 06:23:47'),
(7, 7, 'assigned', 11, '2026-03-21 06:23:47'),
(8, 8, 'assigned', 11, '2026-03-21 06:23:47'),
(9, 9, 'assigned', 11, '2026-03-21 06:23:47'),
(10, 10, 'assigned', 11, '2026-03-21 06:23:47');

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
(40, 'computered3896@gmail.com', '$2y$12$HqSie2YMhOoVPx3hqzKiEOnrH/u66wp4yMEuK.jNW4KzdnBW1.6cm', 'verified', '2026-02-10 04:20:11', 'd8299c1c688c431a81beb63339f80af66cd7e0923d024da4c2d6001705c72ec1', 0, 'Reset Password', '127.0.0.1', NULL, '2026-02-10 04:05:11', '2026-02-10 04:05:29'),
(41, 'computered3896@gmail.com', '$2y$12$EaCJxtZqxswoEMwBgr8saeu7gC5pAqDTrnTQEArR8aBb5g8ULj7TO', 'verified', '2026-02-10 04:55:43', '50c32eb28a2a6d67faf5279fb81f94c5f6127035a0a33429d45dcb63bde0e69d', 0, 'Reset Password', '49.37.72.81', NULL, '2026-02-10 04:40:43', '2026-02-10 04:41:20'),
(42, 'computered3896@gmail.com', '$2y$12$wA3r0BGaStyk/gWciT3LmOuwAvxv2Wc56FutO0LZownFgIWJiwxKy', 'verified', '2026-02-10 05:16:18', 'fb31a15ce86d7e9fdb8b8a7b8022c7c1e62d1adf2c46e325d2f1629926792e39', 0, 'Reset Password', '49.37.72.81', NULL, '2026-02-10 05:01:18', '2026-02-10 05:02:46'),
(43, 'computered3896@gmail.com', '$2y$12$0yS.FZ0JhlZZ1NgCP8p6x.gdSmoKB6GQ5/v2U8UXB9n7xxsFu.LP2', 'pending', '2026-02-10 07:32:05', '3d30627b30293faac67f6158702be86bcb7dc34c638002ceea7975e526aa80aa', 0, 'Reset Password', '117.233.164.15', NULL, '2026-02-10 07:17:05', '2026-02-10 07:17:05');

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
(4, 'Shop', 5, 1, '2026-02-07 04:40:58', '2026-02-10 13:50:45'),
(5, '1 BHK', 2, 1, '2026-02-10 14:11:24', '2026-02-10 14:11:24'),
(6, '2 BHK', 2, 1, '2026-02-10 14:11:35', '2026-02-10 14:11:35'),
(7, '3 BHK', 2, 1, '2026-02-10 14:12:05', '2026-02-10 14:12:05');

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
(3, 'LIG', 'Low Income Group', 'Low Income Group Quarters', 3.00, 6.00, 3, 1, NULL, '2026-02-07 05:58:56', '2026-02-13 05:53:52'),
(4, 'MIG', 'Middle Income Group', 'Middle Income Group Quarters', 6.00, 12.00, 2, 1, NULL, '2026-02-10 13:54:45', '2026-02-16 07:51:40'),
(5, 'EWS', 'Economically Weaker Section', 'Economically Weaker Section Quarters', 1.00, 3.00, 4, 1, NULL, '2026-02-10 13:55:34', '2026-02-16 07:51:56');

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
  `confirm_received` varchar(50) NOT NULL DEFAULT 'No',
  `confirm_same_allottee_name` varchar(50) NOT NULL DEFAULT 'No',
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
  `json_pages` longtext DEFAULT NULL,
  `total_pages` int(11) DEFAULT NULL,
  `allottee_status` enum('received','scanned','handover','dataentry') NOT NULL DEFAULT 'received',
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
(1, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-102', '4', 'Shri', 'Braj', 'Kishore', 'Prasad', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":46}]', 46, 'dataentry', NULL, 1, 2, 2, 298, '2026-02-16 12:06:59', '2026-03-20 09:41:50', '117.233.178.253'),
(2, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-67', '4', 'Smt.', 'Sabita', NULL, 'Sen', 'Partial Fresh and Old Pages', 3, 0, '[{\"file_name\":\"File-1\",\"pages\":20},{\"file_name\":\"File-2\",\"pages\":27},{\"file_name\":\"File-3\",\"pages\":157}]', 204, 'dataentry', NULL, 1, 2, 2, 298, '2026-02-16 12:09:28', '2026-03-20 07:52:06', '49.37.72.94'),
(3, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-35', '4', 'Shri', 'Bhrigu', 'Prasad', 'Singh', 'All Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":53}]', 53, 'dataentry', NULL, 1, 2, 2, 298, '2026-02-16 12:11:35', '2026-03-20 08:54:37', '117.233.178.253'),
(4, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-44', '4', 'Shri', 'Madhusudan', NULL, 'Sharma', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":45}]', 45, 'dataentry', NULL, 1, 2, 2, 298, '2026-02-16 12:13:59', '2026-03-20 06:53:59', '117.233.178.253'),
(5, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-86', '4', 'Shri', 'Indu Bhushan', 'Prasad', 'Thakur', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":112}]', 112, 'dataentry', NULL, 1, 2, 2, 298, '2026-02-16 12:15:39', '2026-03-20 06:36:02', '117.233.178.253'),
(6, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-87', '4', 'Shri', 'Madan', 'Lal', 'Shah', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":43}]', 43, 'dataentry', NULL, 1, 2, 2, 298, '2026-02-16 12:16:49', '2026-03-20 05:27:42', '117.233.178.253'),
(7, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-115', '4', 'Shri', 'Ramesh', 'Chandra', 'Shrivatava', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":75}]', 75, 'scanned', NULL, 1, 2, 2, 298, '2026-02-16 12:18:00', '2026-03-19 10:36:09', '117.233.178.253'),
(8, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-13', '4', 'Shri.', 'Satya', 'Narain', 'Sharma', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":100}]', 100, 'scanned', NULL, 1, 2, 2, 298, '2026-02-16 12:20:05', '2026-03-19 10:05:34', '49.37.72.94'),
(9, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-37', '4', 'Shri', 'Kamlesh', 'Kumar', 'Gupta', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":249}]', 249, 'dataentry', NULL, 1, 2, 2, 298, '2026-02-16 12:21:23', '2026-03-20 05:20:28', '117.233.178.253'),
(10, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-127', '4', 'Shri.', 'Daya', 'Nand', 'Prasad', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":124}]', 124, 'dataentry', NULL, 1, 2, 2, 298, '2026-02-16 12:22:35', '2026-03-20 09:11:59', '49.37.72.94'),
(11, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-112', '4', 'Shri', 'Birendra', 'Prasad', 'Verma', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":40}]', 40, 'scanned', NULL, 1, 2, 2, 298, '2026-02-16 12:23:40', '2026-02-27 10:20:46', '117.233.178.253'),
(12, '1602268136', 'No', 'No', 1, 1, NULL, 1, 3, 'C-52', '4', 'Shri.', 'Subhash', 'Chandra', 'Bhandula', 'Partial Fresh and Old Pages', 2, 0, '[{\"file_name\":\"File-1\",\"pages\":18},{\"file_name\":\"File-2\",\"pages\":175}]', 193, 'scanned', NULL, 1, 2, 2, 298, '2026-02-16 12:25:24', '2026-03-19 10:05:22', '49.37.72.94'),
(25, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-9', '4', 'Shri', 'Triloki', 'Nath', 'Jaiswal', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":86}]', 86, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 04:45:20', '2026-03-20 11:31:36', '117.233.174.97'),
(26, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-3', '4', 'Shri', 'Chandra', 'Shekhar', 'Sinha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":96}]', 96, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 04:46:04', '2026-03-20 12:25:41', '117.233.174.97'),
(27, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-29', '4', 'Shri', 'Ram', 'Krit', 'Singh', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":81}]', 81, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 04:46:49', '2026-03-20 12:41:34', '117.233.174.97'),
(28, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-126', '4', 'Shri', 'Nageshwar', NULL, 'Mahto', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":49}]', 49, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 04:47:41', '2026-03-20 12:19:40', '117.233.174.97'),
(29, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-49', '4', 'Shri', 'Ranjit', 'Singh', 'Jayswal', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":108}]', 108, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 04:48:27', '2026-03-20 12:57:00', '117.233.174.97'),
(30, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-131', '4', 'Shri', 'Birendra', 'Kumar', 'Khanna', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":98}]', 98, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 04:49:23', '2026-03-21 06:15:33', '117.233.174.97'),
(31, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-100', '4', 'Shri', 'Amar', 'Nath', 'Jha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":139}]', 139, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 04:57:44', '2026-03-21 06:11:59', '117.233.174.97'),
(32, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-97', '4', 'Shri', 'Awadhesh', 'Kumar', 'Roy', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":140}]', 140, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 04:59:59', '2026-03-20 11:58:36', '117.233.174.97'),
(33, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-32', '4', 'Shri', 'Nawal', 'Kishore', 'Prasad', 'All Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":56}]', 56, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 05:01:03', '2026-03-21 05:37:50', '117.233.174.97'),
(34, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-91', '4', 'Shri', 'Bhagwati', 'Prasad', 'Sharma', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":99}]', 99, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 05:01:56', '2026-03-20 13:03:46', '117.233.174.97'),
(35, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-8', '4', 'Shri.', 'Kamala', 'Nand', 'Pradhan', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":124}]', 124, 'dataentry', NULL, 1, 2, 2, NULL, '2026-02-18 05:04:49', '2026-03-20 10:59:43', '117.233.174.97'),
(36, '1802263052', 'No', 'No', 1, 1, NULL, 1, 3, 'C-115', '4', 'Shri', 'Ramesh', 'Chandra', 'Srivastva', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":9}]', 9, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 05:11:11', '2026-03-19 10:06:28', '117.233.174.97'),
(37, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-116', '4', 'Shri', 'Gajendra', NULL, 'Jha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":54}]', 54, 'dataentry', NULL, 1, 3, 3, NULL, '2026-02-18 09:04:08', '2026-03-21 07:49:30', '117.233.174.97'),
(38, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-96', '4', 'Shri', 'Rama', 'Pati', 'Chakhaiyar', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":82}]', 82, 'dataentry', NULL, 1, 3, 3, NULL, '2026-02-18 09:05:37', '2026-03-21 09:22:56', '117.233.174.97'),
(39, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-127', '4', 'Shri', 'Dayanand', NULL, 'Prasad', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":37}]', 37, 'dataentry', NULL, 1, 3, 3, NULL, '2026-02-18 09:06:54', '2026-03-21 09:11:07', '117.233.174.97'),
(40, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-35', '4', 'Shri', 'Bhrigu', 'Prasad', 'Singh', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":50}]', 50, 'dataentry', NULL, 1, 3, 3, NULL, '2026-02-18 09:08:23', '2026-03-21 08:46:51', '117.233.174.97'),
(41, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-126', '4', 'Shri', 'Nageshwar', NULL, 'Mahto', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":47}]', 47, 'dataentry', NULL, 1, 3, 3, NULL, '2026-02-18 09:09:34', '2026-03-21 08:57:56', '117.233.174.97'),
(42, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-106', '4', 'Shri', 'Ram', 'Prawesh', 'Singh', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":157}]', 157, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-18 09:10:36', '2026-02-27 10:25:16', '117.233.174.97'),
(43, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-79', '4', 'Shri', 'Anil', 'Kumar', 'Srivastava', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":151}]', 151, 'dataentry', NULL, 1, 3, 3, NULL, '2026-02-18 09:11:55', '2026-03-21 08:43:22', '117.233.174.97'),
(44, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-84', '4', 'Shri', 'Bijoy', 'Nandan', 'Sahay', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":111}]', 111, 'dataentry', NULL, 1, 3, 3, NULL, '2026-02-18 09:13:35', '2026-03-21 07:29:45', '117.233.174.97'),
(45, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-94', '4', 'Shri', 'Ram Chandra', 'Prasad', 'Gupta', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":96}]', 96, 'dataentry', NULL, 1, 3, 3, 299, '2026-02-18 09:15:08', '2026-03-21 07:27:29', '117.233.174.97'),
(46, '1802264319', 'No', 'No', 1, 1, NULL, 1, 3, 'C-129', '4', 'Smt.', 'Jaya', NULL, 'Kumari', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":17}]', 17, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-18 09:18:12', '2026-02-27 10:26:04', '117.233.174.97'),
(47, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-87', '4', 'Shri.', 'Madan', 'Lal', 'Shah', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":31}]', 31, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:25:48', '2026-03-19 10:14:03', '117.233.174.97'),
(48, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-115', '4', 'Shri', 'Ramesh', 'Chandra', 'Srivastava', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":11}]', 11, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:26:59', '2026-02-27 10:26:23', '117.233.174.97'),
(49, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-63', '4', 'Shri', 'Rai', 'Upendra', 'Prasad', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":64}]', 64, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:28:18', '2026-02-27 10:26:36', '117.233.174.97'),
(50, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-129', '4', 'Smt.', 'Kanti', NULL, 'Devi', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":17}]', 17, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:29:09', '2026-03-19 10:04:28', '117.233.174.97'),
(51, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-114', '4', 'Smt.', 'Shital', 'Prasad', 'Jaiswal', 'All Old Pages', 2, 0, '[{\"file_name\":\"File-1\",\"pages\":108},{\"file_name\":\"File-2\",\"pages\":38}]', 146, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:31:14', '2026-03-19 10:03:57', '117.233.174.97'),
(52, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-46', '4', 'Shri', 'Ram', 'Sakal', 'Ray', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":97}]', 97, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:32:24', '2026-02-27 10:27:37', '117.233.174.97'),
(53, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-80', '4', 'Dr.', 'Surendra', 'Kumar', 'Sinha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":215}]', 215, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:34:01', '2026-02-27 10:27:49', '117.233.174.97'),
(54, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-119', '4', 'Shri', 'Prabhat', 'Kumar', 'Gupta', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":69}]', 69, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:34:48', '2026-02-27 10:28:07', '117.233.174.97'),
(55, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-19', '4', 'Major', 'Sushil', 'Kumar', 'Sinha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":99}]', 99, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:35:36', '2026-03-19 10:02:28', '117.233.174.97'),
(56, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-95', '4', 'Shri', 'Krishna', 'Bihari', 'Singh', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":46}]', 46, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:36:27', '2026-02-27 10:28:50', '117.233.174.97'),
(57, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-41', '4', 'Shri', 'Jadunath', NULL, 'Singh', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":187}]', 187, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:37:09', '2026-02-27 10:29:03', '117.233.174.97'),
(58, '1802263693', 'No', 'No', 1, 1, NULL, 1, 3, 'C-40', '4', 'Shri', 'Brahma', 'Nand', 'Sahai', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":133}]', 133, 'scanned', NULL, 1, 2, 2, NULL, '2026-02-18 12:37:58', '2026-03-19 10:36:09', '117.233.174.97'),
(59, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/214', '2', 'Smt.', 'Maya', NULL, 'Kumari', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":64}]', 64, 'scanned', NULL, 1, 3, 3, 299, '2026-02-21 05:24:33', '2026-02-27 10:35:28', '117.233.189.216'),
(60, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/228', '2', 'Shri', 'Kulanand', NULL, 'Jha', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":63}]', 63, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:25:57', '2026-02-27 10:35:34', '117.233.189.216'),
(61, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/157', '2', 'Shri', 'Ramesh', 'Chandra', 'Kaityal', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":64}]', 64, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:27:19', '2026-02-27 10:35:45', '117.233.189.216'),
(62, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/159', '2', 'Shri', 'Prem', 'Kumar', 'Sinha', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":68}]', 68, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:28:56', '2026-02-27 10:35:56', '117.233.189.216'),
(63, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/197', '2', 'Shri', 'Sasanka', 'Sekhar', 'Tripathi', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":56}]', 56, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:30:21', '2026-02-27 10:36:10', '117.233.189.216'),
(64, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/278', '2', 'Smt.', 'Indira', NULL, 'Mittal', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":94}]', 94, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:31:45', '2026-02-27 10:36:17', '117.233.189.216'),
(65, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/279', '2', 'Shri', 'Durga', NULL, 'Das', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":82}]', 82, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:32:53', '2026-02-27 10:36:24', '117.233.189.216'),
(66, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/158', '2', 'Shri', 'Manindra', 'Narayan', 'Singh', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":45}]', 45, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:34:12', '2026-02-27 10:17:27', '117.233.189.216'),
(67, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/288', '2', 'Shri', 'Joljus', NULL, 'Lakra', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":40}]', 40, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:35:45', '2026-02-27 10:17:15', '117.233.189.216'),
(68, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/160', '2', 'Major', 'Ashish', 'Ranjan', 'Prasad', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":190}]', 190, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:37:36', '2026-03-19 10:02:46', '117.233.189.216'),
(69, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/242', '2', 'Shri', 'Sushil', 'Kumar', 'Verma', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":42}]', 42, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:38:51', '2026-02-27 10:16:46', '117.233.189.216'),
(70, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/186', '2', 'Shri', 'M. V. Subba', NULL, 'Rao', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":40}]', 40, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:40:13', '2026-02-27 10:16:32', '117.233.189.216'),
(71, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/287', '2', 'Shri', 'Kawaljit', NULL, 'Singh', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":45}]', 45, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:41:45', '2026-02-27 10:16:21', '117.233.189.216'),
(72, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/267', '2', 'Shri', 'Dip', 'Narain', 'Prasad', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":116}]', 116, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:43:23', '2026-02-27 10:16:13', '117.233.189.216'),
(73, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/275', '2', 'Smt.', 'Indu', NULL, 'Kumari', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":110}]', 110, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:44:34', '2026-02-27 10:15:59', '117.233.189.216'),
(74, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/190', '2', 'Smt.', 'Sadhana', NULL, 'Devi', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":128}]', 128, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:45:37', '2026-02-27 10:15:53', '117.233.189.216'),
(75, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/168', '2', 'Shri', 'Ram', NULL, 'Komal', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":127}]', 127, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:46:36', '2026-02-27 10:15:46', '117.233.189.216'),
(76, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/237', '2', 'Shri', 'Shyam', 'Sundar', 'Jha', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":66}]', 66, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:47:41', '2026-02-27 10:15:39', '117.233.189.216'),
(77, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/251', '2', 'Dr.', 'Mukund', NULL, 'Pradhan', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":54}]', 54, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:49:04', '2026-02-27 10:15:22', '117.233.189.216'),
(78, '2102262879', 'No', 'No', 2, 5, NULL, 1, 3, 'H/170', '2', 'Shri', 'Dindayal', NULL, 'Singh', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":72}]', 72, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-21 05:50:21', '2026-02-27 10:15:07', '117.233.189.216'),
(80, '2702263432', 'No', 'No', 1, 1, NULL, 1, 3, 'C-12', '4', 'Shri', 'Ajay', 'Chandra', 'Srivastava', 'All Poor Quality Pages', 2, 1, '[{\"file_name\":\"File-1\",\"pages\":111},{\"file_name\":\"File-2\",\"pages\":6}]', 117, 'scanned', NULL, 1, 3, 3, 3, '2026-02-27 09:31:08', '2026-03-19 10:36:09', '117.233.173.183'),
(81, '2702263432', 'No', 'No', 1, 1, NULL, 1, 3, 'C-65', '4', 'Shri', 'Raj', 'Kumar', 'Mehrotra', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":211}]', 211, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:32:03', '2026-03-09 11:42:10', '117.233.161.152'),
(82, '2702263432', 'No', 'No', 1, 1, NULL, 1, 3, 'C-105', '4', 'Shri', 'Bhagwan', NULL, 'Prasad', 'All Poor Quality Pages', 2, 1, '[{\"file_name\":\"File-1\",\"pages\":6},{\"file_name\":\"File-2\",\"pages\":34},{\"file_name\":\"File-3\",\"pages\":121}]', 161, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:33:13', '2026-03-09 11:41:34', '117.233.161.152'),
(83, '2702263432', 'No', 'No', 1, 1, NULL, 1, 3, 'C-59', '4', 'Late', 'Deepak', 'Kumar', 'Ghosh', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":68}]', 68, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:34:26', '2026-03-09 11:39:50', '117.233.161.152'),
(84, '2702263432', 'No', 'No', 1, 1, NULL, 1, 3, 'C-72', '4', 'Smt.', 'Koushalya', NULL, 'Devi', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":70}]', 70, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:36:08', '2026-03-09 11:39:34', '117.233.161.152'),
(85, '2702263432', 'No', 'No', 1, 1, NULL, 1, 3, 'C-83', '4', 'Shri', 'Shashi', 'Ranjan', 'Prasad', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":98}]', 98, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:36:46', '2026-03-09 11:39:25', '117.233.161.152'),
(86, '2702263432', 'Yes', 'Yes', 1, 1, NULL, 1, 3, 'C-3', '4', 'Shri', 'Chandra', 'Shekhar', 'Sinha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":95}]', 95, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:38:20', '2026-03-09 11:39:14', '117.233.161.152'),
(87, '2702263432', 'Yes', 'Yes', 1, 1, NULL, 1, 3, 'C-116', '4', 'Shri', 'Gajendra', NULL, 'Jha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":58}]', 58, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:39:29', '2026-03-09 11:39:04', '117.233.161.152'),
(88, '2702263432', 'No', 'No', 1, 1, NULL, 1, 3, 'C-22', '4', 'Shri', 'Nakul', NULL, 'Singh', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":51}]', 51, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:40:52', '2026-03-09 11:38:48', '117.233.161.152'),
(89, '2702263432', 'No', 'No', 1, 1, NULL, 1, 3, 'C-84', '4', 'Shri', 'Ashok', 'Kumar', 'Mangal', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":75}]', 75, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:41:34', '2026-03-09 11:38:36', '117.233.161.152'),
(90, '2702263432', 'No', 'No', 1, 1, NULL, 1, 3, 'C-56', '4', 'Shri', 'Brahma', 'Shanker', 'Sahay', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":134}]', 134, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 09:42:33', '2026-03-09 11:38:16', '117.233.161.152'),
(91, '2702263432', 'Yes', 'Yes', 1, 1, NULL, 1, 3, 'C-86', '4', 'Shri', 'Indu Bhushan', 'Prasad', 'Thakur', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":109}]', 109, 'scanned', 5, 1, 3, 3, 3, '2026-02-27 09:51:54', '2026-03-09 11:38:04', '49.37.73.157'),
(95, '2702263032', 'No', 'No', 1, 1, NULL, 1, 3, 'C-103', '4', 'Dr.', 'Amar', 'Jyoti', 'Bihari', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":71}]', 71, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 12:49:45', '2026-03-09 11:37:33', '117.233.161.152'),
(96, '2702263032', 'No', 'No', 1, 1, NULL, 1, 3, 'C-14', '4', 'Smt.', 'Usha', NULL, 'Sinha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":80}]', 80, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 12:51:03', '2026-03-09 11:37:24', '117.233.161.152'),
(97, '2702263032', 'No', 'No', 1, 1, NULL, 1, 3, 'C-125', '4', 'Shri', 'Kamleshwari', NULL, 'Ballabh', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":130}]', 130, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 12:54:14', '2026-03-09 11:37:10', '117.233.161.152'),
(98, '2702263032', 'Yes', 'Yes', 1, 1, NULL, 1, 3, 'C-126', '4', 'Shri', 'Nageshwar', NULL, 'Mahto', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":10}]', 10, 'scanned', 28, 1, 3, 3, NULL, '2026-02-27 12:55:25', '2026-03-09 11:36:56', '117.233.161.152'),
(99, '2702263032', 'No', 'No', 1, 1, NULL, 1, 3, 'C-47', '4', 'Shri', 'Ram', 'Pratap', 'Singh', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":104}]', 104, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 12:56:54', '2026-03-09 11:36:44', '117.233.161.152'),
(100, '2702263032', 'No', 'No', 1, 1, NULL, 1, 3, 'C-36', '4', 'Shri', 'Nand', 'Kishore', 'Sahu', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":49}]', 49, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 12:58:37', '2026-03-09 11:36:28', '117.233.161.152'),
(101, '2702263032', 'Yes', 'Yes', 1, 1, NULL, 1, 3, 'C-44', '4', 'Shri', 'Madhusudan', NULL, 'Sharma', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":62}]', 62, 'scanned', 4, 1, 3, 3, NULL, '2026-02-27 12:59:43', '2026-03-09 11:36:11', '117.233.161.152'),
(102, '2702263032', 'No', 'No', 1, 1, NULL, 1, 3, 'C-64', '4', 'Shri', 'Triloki', 'Nath', 'Mehra', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":177}]', 177, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 13:01:41', '2026-03-09 11:35:59', '117.233.161.152'),
(103, '2702263032', 'No', 'No', 1, 1, NULL, 1, 3, 'C-55', '4', 'Shri', 'Gurdip', 'Singh', 'Chaddah', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":127}]', 127, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 13:03:09', '2026-03-09 11:35:37', '117.233.161.152'),
(104, '2702263032', 'Yes', 'Yes', 1, 1, NULL, 1, 3, 'C-115', '4', 'Shri', 'Ramesh', 'Chandra', 'Shrivatava', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":285}]', 285, 'scanned', 7, 1, 3, 3, NULL, '2026-02-27 13:03:56', '2026-03-09 11:35:24', '117.233.161.152'),
(105, '2702263032', 'No', 'No', 1, 1, NULL, 1, 3, 'C-118', '4', 'Shri', 'Suryadeo', NULL, 'Pandey', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":78}]', 78, 'scanned', NULL, 1, 3, 3, NULL, '2026-02-27 13:05:28', '2026-03-09 11:35:05', '117.233.161.152'),
(106, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-1', '4', 'Shri', 'Mansukh', NULL, 'Lal', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":71}]', 71, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:11:08', '2026-03-11 07:41:02', '117.233.173.183'),
(107, '0903268389', 'No', 'No', 4, 7, NULL, 1, 2, 'R-3', '4', 'Shri', 'Manoj', 'Kumar', 'Singh', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":60}]', 60, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:24:08', '2026-03-11 07:17:26', '117.233.173.183'),
(108, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-5', '4', 'Smt.', 'Meena', NULL, 'Srivastava', 'All Fresh Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":31}]', 31, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:27:58', '2026-03-11 07:17:12', '117.233.173.183'),
(109, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-6', '4', 'Shri', 'Arbind', 'Kumar', 'Bage', 'All Fresh Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":25}]', 25, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:30:41', '2026-03-11 07:16:50', '117.233.173.183'),
(110, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-7', '4', 'Shri', 'Faguni', NULL, 'Ram', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":57}]', 57, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:33:46', '2026-03-11 07:16:33', '117.233.173.183'),
(111, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-7', '4', 'Shri', 'Faguni', NULL, 'Ram', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":82}]', 82, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:37:48', '2026-03-11 07:16:20', '117.233.173.183'),
(112, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-10', '4', 'Shri', 'Amod', NULL, 'Kumar', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":46}]', 46, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:48:19', '2026-03-11 07:14:44', '117.233.173.183'),
(113, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-11', '4', 'Shri', 'Chandroday', 'Prasad', 'Singh', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":54}]', 54, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:50:05', '2026-03-11 07:14:34', '117.233.173.183'),
(114, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-13', '4', 'Shri', 'Madan', 'Prasad', 'Verma', 'All Fresh Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":82}]', 82, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:56:12', '2026-03-11 07:14:17', '117.233.173.183'),
(115, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-15', '4', 'Shri', 'Lakshman', NULL, 'Singh', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":83}]', 83, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:58:00', '2026-03-11 07:14:05', '117.233.173.183'),
(116, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-16', '4', 'Shri', 'Thakur', NULL, 'Singh', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":94}]', 94, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 12:58:50', '2026-03-11 07:13:50', '117.233.173.183'),
(117, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-19', '4', 'Smt.', 'Rekha', NULL, 'Kakkar', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":55}]', 55, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 13:00:12', '2026-03-11 07:13:35', '117.233.173.183'),
(118, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-20', '4', 'Smt.', 'Sumitra', NULL, 'Devi', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":24}]', 24, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 13:03:42', '2026-03-11 07:13:22', '117.233.173.183'),
(119, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-22', '4', 'Shri', 'Radheshyam', NULL, 'Modi', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":47}]', 47, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 13:04:48', '2026-03-11 07:13:07', '117.233.173.183'),
(120, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-26', '4', 'Shri', 'Kickey', NULL, 'Arya', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":60}]', 60, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 13:07:47', '2026-03-11 07:12:52', '117.233.173.183'),
(121, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-28', '4', 'Shri', 'Nagendra', 'Prasad', 'Munshi', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":98}]', 98, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 13:10:17', '2026-03-11 07:12:38', '117.233.173.183'),
(122, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-30', '4', 'Shri', 'Iqbal', NULL, 'Singh', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":29}]', 29, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 13:11:47', '2026-03-11 07:12:14', '117.233.173.183'),
(123, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-31', '4', 'Smt.', 'Gayatri', NULL, 'Devi', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":87}]', 87, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 13:13:43', '2026-03-11 07:11:51', '117.233.173.183'),
(124, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R-32', '4', 'Shri', 'Harbans', 'Narayan', 'Sinha', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":73}]', 73, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-09 13:16:22', '2026-03-11 07:11:33', '117.233.173.183'),
(125, '1003267333', 'No', 'No', 4, 13, NULL, 1, 2, 'c_9', '2', 'Shri', 'ram', 'naresh', 'singh', 'All Old Pages', 2, 1, NULL, NULL, 'received', NULL, 1, NULL, 7, NULL, '2026-03-10 10:28:38', '2026-03-10 10:28:38', '117.233.181.168'),
(126, '0903268389', 'No', 'No', 4, 13, NULL, 1, 2, 'R_9', '4', 'Shri', 'Ram', 'Nath', 'Choudhry', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":23}]', 23, 'scanned', NULL, 1, 3, 3, NULL, '2026-03-11 07:46:32', '2026-03-11 07:47:03', '117.233.174.70'),
(127, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-36', '4', 'Smt.', 'Sukumari', NULL, 'Devi', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, 3, '2026-03-11 11:19:40', '2026-03-11 11:22:08', '117.233.190.210'),
(128, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-37', '4', 'Shri', 'Theodor', NULL, 'Dungdung', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:20:51', '2026-03-11 11:20:51', '117.233.190.210'),
(129, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-41', '4', 'Smt.', 'Kusum', NULL, 'Khandelwal', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:22:48', '2026-03-11 11:22:48', '117.233.190.210'),
(130, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-42', '4', 'Smt.', 'Marcel', NULL, 'Kumari', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:24:05', '2026-03-11 11:24:05', '117.233.190.210'),
(131, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-43', '4', 'Shri', 'Ram', 'Kripal', 'Singh', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:25:09', '2026-03-11 11:25:09', '117.233.190.210'),
(132, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-44', '4', 'Shri', 'Niranjan', 'Prasad', 'Keshari', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:26:19', '2026-03-11 11:26:19', '117.233.190.210'),
(133, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-45', '4', 'Shri', 'Sudhansu', 'Shekhar', 'Rai', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:27:09', '2026-03-11 11:27:09', '117.233.190.210'),
(134, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-46', '4', 'Shri', 'Sardar', 'Baldeb', 'Singh', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:28:21', '2026-03-11 11:28:21', '117.233.190.210'),
(135, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-47', '4', 'Smt.', 'Nirmala', NULL, 'Singh', 'Partial Fresh and Old Pages', 2, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:29:58', '2026-03-11 11:29:58', '117.233.190.210'),
(136, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-48', '4', 'Shri', 'Santosh', 'Kumar', 'Chhapolika', 'Partial Fresh and Old Pages', 2, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, 3, '2026-03-11 11:31:06', '2026-03-11 12:02:28', '117.233.190.210'),
(137, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-49', '4', 'Smt.', 'Saroj', NULL, 'Prasad', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:31:52', '2026-03-11 11:31:52', '117.233.190.210'),
(138, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-50', '4', 'Shri', 'Ram', 'Swarath', 'Mandal', 'Partial Fresh and Old Pages', 2, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:33:41', '2026-03-11 11:33:41', '117.233.190.210'),
(139, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-51', '4', 'Shri', 'Shiv', 'Shankar', 'Prasad Verma', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:34:29', '2026-03-11 11:34:29', '117.233.190.210'),
(140, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-52', '4', 'Shri', 'Harish', NULL, 'Narain', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:35:22', '2026-03-11 11:35:22', '117.233.190.210'),
(141, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-53', '4', 'Smt.', 'Sabita', NULL, 'Singh', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:36:03', '2026-03-11 11:36:03', '117.233.190.210'),
(142, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-54', '4', 'Shri', 'Shailendra', NULL, 'Kumar', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:37:07', '2026-03-11 11:37:07', '117.233.190.210'),
(143, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-56', '4', 'Smt.', 'Sneh', NULL, 'Lata', 'Partial Fresh and Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:46:21', '2026-03-11 11:46:21', '117.233.190.210'),
(144, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-57', '4', 'Smt.', 'Lalita', NULL, 'Devi', 'Partial Fresh and Old Pages', 2, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:47:53', '2026-03-11 11:47:53', '117.233.190.210'),
(145, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-58', '4', 'Dr.', 'Raj', 'Kishore', 'Prasad', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:48:48', '2026-03-11 11:48:48', '117.233.190.210'),
(146, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-61', '4', 'Md.', 'Abdul', NULL, 'Hamid', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, 3, '2026-03-11 11:49:36', '2026-03-11 12:06:44', '117.233.190.210'),
(147, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-63', '4', 'Smt.', 'Birjmani', NULL, 'Sharma', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:54:42', '2026-03-11 11:54:42', '117.233.190.210'),
(148, '1103265912', 'No', 'No', 4, 13, NULL, 1, 2, 'R-64', '4', 'Smt.', 'Dupatia', NULL, 'Devi', 'Partial Fresh and Old Pages', 2, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-11 11:56:03', '2026-03-11 11:56:03', '117.233.190.210'),
(149, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-25', '4', 'Shri', 'Madan', 'Mohan', 'Sharma', 'Partial Fresh and Old Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":90}]', 90, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-13 13:06:20', '2026-03-17 05:40:13', '117.233.169.104'),
(150, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-70', '4', 'Shri', 'Lakhendra', 'Narain', 'Verma', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":88}]', 88, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-13 13:09:08', '2026-03-17 05:40:05', '117.233.169.104'),
(151, '1403264329', 'No', 'No', 1, 1, NULL, 1, 3, 'C-101', '4', 'Shri', 'Suresh', 'Prasad', 'Singh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 5, NULL, '2026-03-14 06:04:49', '2026-03-14 06:04:49', '117.233.162.194'),
(152, '1403264329', 'No', 'No', 1, 1, NULL, 1, 3, 'C-58', '4', 'Shri', 'Anant', NULL, 'Prasad', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 5, NULL, '2026-03-14 06:07:29', '2026-03-14 06:07:29', '117.233.162.194'),
(153, '1403264329', 'No', 'No', 1, 1, NULL, 1, 3, 'C-60', '4', 'Shri', 'Suraj', 'Kumar', 'Lal', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 5, NULL, '2026-03-14 06:11:35', '2026-03-14 06:11:35', '117.233.162.194'),
(154, '1403264329', 'No', 'No', 1, 1, NULL, 1, 3, 'C-4', '4', 'Shri', 'Braj', 'Kumar', 'Mishra', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 5, NULL, '2026-03-14 06:13:56', '2026-03-14 06:13:56', '117.233.162.194'),
(155, '1403264329', 'No', 'No', 1, 1, NULL, 1, 3, 'C-26', '4', 'Shri', 'Man', 'Mohan', 'Sharan', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 5, NULL, '2026-03-14 06:15:35', '2026-03-14 06:15:35', '117.233.162.194'),
(156, '1403264329', 'No', 'No', 1, 1, NULL, 1, 3, 'C-85', '4', 'Miss', 'Shilpee', NULL, 'Samaiyar', 'All Poor Quality Pages', 2, 1, NULL, NULL, 'received', NULL, 1, NULL, 5, NULL, '2026-03-14 06:19:32', '2026-03-14 06:19:32', '117.233.162.194'),
(157, '1403264329', 'No', 'No', 1, 1, NULL, 1, 3, 'C-57', '4', 'Md.', 'Saba', NULL, 'Uddin', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 5, NULL, '2026-03-14 06:22:08', '2026-03-14 06:22:08', '117.233.162.194'),
(158, '1403264329', 'No', 'No', 1, 1, NULL, 1, 3, 'C-11', '4', 'Smt.', 'Anasuiya', NULL, 'Devi', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 5, NULL, '2026-03-14 06:24:11', '2026-03-14 06:24:11', '117.233.162.194'),
(159, '1403264329', 'No', 'No', 1, 1, NULL, 1, 3, 'C-52', '4', 'Shri', 'Subhash', 'Chander', 'Bhandula', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 5, NULL, '2026-03-14 06:55:06', '2026-03-14 06:55:06', '117.233.162.194'),
(160, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-34', '4', 'Shri', 'Somnath', NULL, 'Pandey', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":117}]', 117, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-14 07:22:42', '2026-03-17 05:39:57', '117.233.162.194'),
(161, '1303264283', 'Yes', 'Yes', 1, 1, NULL, 1, 3, 'C-9', '4', 'Shri', 'Triloki', 'Nath', 'Jaiswal', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":61}]', 61, 'scanned', 25, 1, 6, 6, NULL, '2026-03-14 07:26:04', '2026-03-17 05:39:45', '117.233.162.194'),
(162, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-81', '4', 'Shri', 'Sachchidanand', NULL, 'Prasad', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":160}]', 160, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-14 07:29:29', '2026-03-17 05:39:34', '117.233.162.194'),
(163, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-6', '4', 'Shri', 'Chandra', 'Mohan', 'Prasad', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":49}]', 49, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-14 07:32:23', '2026-03-17 05:39:25', '117.233.162.194'),
(164, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-54', '4', 'Shri', 'Arun', 'Kumar', 'Verma', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":154}]', 154, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-14 07:35:23', '2026-03-17 05:39:14', '117.233.162.194'),
(165, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-33', '4', 'Shri', 'Ram', 'Suresh', 'Ojha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":196}]', 196, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-14 07:38:27', '2026-03-17 05:39:02', '117.233.162.194'),
(166, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-131', '4', 'Smt.', 'Sheela', NULL, 'Jha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":36}]', 36, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-14 07:44:33', '2026-03-17 05:38:52', '117.233.162.194'),
(167, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-33', '4', 'Shri', 'Ram', 'Suresh', 'Ojha', 'All Poor Quality Pages', 1, 0, '[{\"file_name\":\"File-1\",\"pages\":28}]', 28, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-14 07:47:06', '2026-03-17 05:38:34', '117.233.162.194'),
(168, '1303264283', 'No', 'No', 1, 1, NULL, 1, 3, 'C-17', '4', 'Shri', 'Anil', 'Kumar', 'Delta', 'All Poor Quality Pages', 2, 1, '[{\"file_name\":\"File-1\",\"pages\":120},{\"file_name\":\"File-2\",\"pages\":26}]', 146, 'scanned', NULL, 1, 6, 6, NULL, '2026-03-14 07:47:59', '2026-03-17 05:38:15', '117.233.162.194'),
(169, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-138', '4', 'Late', 'Umeshwar', 'Prasad', 'Singh', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-17 06:32:22', '2026-03-17 06:32:22', '117.233.181.2'),
(170, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-1', '4', 'Shri', 'Kashi', NULL, 'Lal', 'All Fresh Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-17 06:34:15', '2026-03-17 06:34:15', '117.233.181.2'),
(171, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-42', '4', 'Shri', 'Raj', 'Kishore', 'Ram', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-17 06:35:15', '2026-03-17 06:35:15', '117.233.181.2'),
(172, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-40', '4', 'Shri', 'Ramanand', NULL, 'Vishwkarma', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-17 06:36:23', '2026-03-17 06:36:23', '117.233.181.2'),
(173, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-156', '4', 'Smt.', 'Durga', NULL, 'Pandey', 'All Fresh Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-17 06:37:31', '2026-03-17 06:37:31', '117.233.181.2'),
(174, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-161', '4', 'Shri', 'Tara', 'Nand', 'Khan', 'Partial Fresh and Old Pages', 2, 1, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-17 06:39:02', '2026-03-17 06:39:02', '117.233.181.2'),
(175, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-162', '4', 'Shri', 'Braj', 'Kishor', 'Munda', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-17 06:40:21', '2026-03-17 06:40:21', '117.233.181.2'),
(176, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-25', '4', 'Shri', 'Chandeshwar', 'Prasad', 'Singh', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-17 06:41:19', '2026-03-17 06:41:19', '117.233.181.2'),
(177, '1703266901', 'Yes', 'Yes', 1, 1, NULL, 1, 2, 'B-40', '4', 'Shri', 'Ramanand', NULL, 'Vishwakarma', 'All Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 4, 4, '2026-03-17 06:46:07', '2026-03-17 07:27:29', '117.233.181.2'),
(178, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-131', '4', 'Shri', 'Tara', 'Nand', 'Khan', 'All Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 4, 4, '2026-03-17 06:48:03', '2026-03-17 07:26:39', '117.233.181.2'),
(179, '1703266901', 'No', 'No', 1, 1, NULL, 1, 2, 'B-5', '4', 'Smt.', 'Farida', NULL, 'Alam', 'All Poor Quality Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-17 07:40:12', '2026-03-19 10:14:41', '117.233.188.135'),
(180, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_138', '4', 'Shri', 'Nishikant', NULL, 'Pandey', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 09:43:38', '2026-03-17 09:43:38', '117.233.188.135'),
(181, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_1', '4', 'Shri', 'Kashi', NULL, 'Lal', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:00:14', '2026-03-17 10:00:14', '117.233.188.135'),
(182, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_42', '4', 'Shri', 'Raj', 'Kishore', 'Ram', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:01:54', '2026-03-17 10:01:54', '117.233.188.135'),
(183, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_40', '4', 'Shri', 'Ramanand', NULL, 'Vishwakarma', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:03:23', '2026-03-17 10:03:23', '117.233.188.135'),
(184, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_156', '4', 'Shri', 'Durga', NULL, 'Pandey', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:05:06', '2026-03-17 10:05:06', '117.233.188.135'),
(185, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_161', '4', 'Shri', 'Kiran', NULL, 'Toppo', 'All Poor Quality Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, 3, '2026-03-17 10:05:57', '2026-03-17 10:06:55', '117.233.188.135'),
(186, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_162', '4', 'Shri', 'Braj', 'Kishore', 'Munda', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:07:43', '2026-03-17 10:07:43', '117.233.188.135'),
(187, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_25', '4', 'Shri', 'Chandeshwar', 'Prasad', 'Singh', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:09:00', '2026-03-17 10:09:00', '117.233.188.135'),
(188, '1703267993', 'Yes', 'Yes', 1, 1, NULL, 1, 2, 'B_40', '4', 'Shri', 'Ramanand', NULL, 'Vishwakarma', 'All Old Pages', 1, 2, NULL, NULL, 'received', 183, 1, NULL, 3, NULL, '2026-03-17 10:10:10', '2026-03-17 10:10:10', '117.233.188.135'),
(189, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_131', '4', 'Shri', 'Tara', 'Nand', 'Khan', 'All Poor Quality Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:11:42', '2026-03-17 10:11:42', '117.233.188.135'),
(190, '1703267993', 'No', 'No', 1, 1, NULL, 1, 2, 'B_05', '4', 'Smt.', 'Farida', NULL, 'Alam', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:12:40', '2026-03-17 10:12:40', '117.233.188.135'),
(191, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_68', '4', 'Shri', 'Sunil', 'Kumar', 'Ganguli', 'All Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:15:58', '2026-03-17 10:15:58', '117.233.188.135'),
(192, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_130', '4', 'Shri', 'Shiva', 'Shankhar', 'Khan', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:17:17', '2026-03-17 10:17:17', '117.233.188.135'),
(193, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_49', '4', 'Shri', 'Indradweep', 'Narayan', 'Verma', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:18:37', '2026-03-19 10:01:16', '117.233.188.135'),
(194, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_33', '4', 'Shri', 'Santosh', 'Kumar', 'Sinha', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:19:32', '2026-03-17 10:19:32', '117.233.188.135'),
(195, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_9', '4', 'Shri', 'Santosh', 'Kumar', 'Karan', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:20:33', '2026-03-17 10:20:33', '117.233.188.135'),
(196, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_100', '4', 'Shri', 'Madhu', 'Sudan', 'Ram', 'All Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:21:44', '2026-03-17 10:21:44', '117.233.188.135'),
(197, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_72', '4', 'Shri', 'Shyam', 'Kishor', 'Prasad', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:22:35', '2026-03-17 10:22:35', '117.233.188.135'),
(198, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_39', '4', 'Shri', 'Subodh', 'Kumar', 'Sinha', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:23:26', '2026-03-17 10:23:26', '117.233.188.135'),
(199, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_144', '4', 'Shri', 'Ravi', 'Nand', 'Keolyar', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:24:15', '2026-03-17 10:24:15', '117.233.188.135'),
(200, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_43', '4', 'Shri', 'Shiv', 'Nandan', 'Giri', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:25:12', '2026-03-17 10:25:12', '117.233.188.135'),
(201, '1703264455', 'No', 'No', 1, 1, NULL, 1, 2, 'B_37', '4', 'Shri', 'Shri', NULL, 'Gopal', 'All Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 3, NULL, '2026-03-17 10:26:15', '2026-03-17 10:26:15', '117.233.188.135');
INSERT INTO `register_allottees` (`id`, `register_id`, `confirm_received`, `confirm_same_allottee_name`, `division_id`, `sub_division_id`, `area`, `pcategory_id`, `p_type_id`, `property_number`, `quarter_type`, `prefix`, `allottee_name`, `allottee_middle_name`, `allottee_surname`, `remarks`, `no_of_files`, `no_of_supplement`, `json_pages`, `total_pages`, `allottee_status`, `parent_id`, `is_active`, `scanned_by`, `created_by`, `updated_by`, `created_at`, `updated_at`, `ip_address`) VALUES
(202, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_16', '4', 'Shri', 'Baleshwar', 'Prasad', 'Singh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:33:50', '2026-03-17 10:33:50', '117.233.188.135'),
(203, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_30', '4', 'Shri', 'Chnadra', 'Mauleshwar', 'Jaruhar', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:36:18', '2026-03-17 10:36:18', '117.233.188.135'),
(204, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_123', '4', 'Shri', 'Jai', 'Prakash', 'Gupta', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:37:18', '2026-03-17 10:37:18', '117.233.188.135'),
(205, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_102', '4', 'Shri', 'Braj Kishore', 'Prasad', 'Sinha', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:39:22', '2026-03-17 10:39:22', '117.233.188.135'),
(206, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_67', '4', 'Shri', 'Rohit', NULL, 'Mahto', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:40:23', '2026-03-17 10:40:23', '117.233.188.135'),
(207, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_59', '4', 'Shri', 'Deepak', 'Kumar', 'Ghosh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:42:55', '2026-03-17 10:42:55', '117.233.188.135'),
(208, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_92', '4', 'Shri', 'Chandra Bhushan', 'Prasad', 'Singh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:47:40', '2026-03-17 10:47:40', '117.233.188.135'),
(209, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_10', '4', 'Shri', 'Krishna', 'Prasad', 'Jayswal', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:49:28', '2026-03-17 10:49:28', '117.233.188.135'),
(210, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_58', '4', 'Shri', 'Anant', NULL, 'Prasad', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:50:42', '2026-03-17 10:50:42', '117.233.188.135'),
(211, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_76', '4', 'Shri', 'Sachidanand', NULL, 'Sahay', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:52:22', '2026-03-17 10:52:22', '117.233.188.135'),
(212, '1703263462', 'No', 'No', 1, 1, NULL, 1, 2, 'C_95', '4', 'Shri', 'Krishna', 'Bihari', 'Singh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 6, NULL, '2026-03-17 10:53:56', '2026-03-17 10:53:56', '117.233.188.135'),
(213, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_19', '4', 'Smt.', 'Manju', NULL, 'Sinha', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, 4, '2026-03-18 11:37:05', '2026-03-19 04:40:40', '117.233.170.156'),
(214, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_45', '4', 'Shri', 'Birendra', 'Pd.', 'Sinha', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, 4, '2026-03-18 11:38:28', '2026-03-19 04:39:37', '117.233.170.156'),
(215, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B-53', '4', 'Shri', 'Hari', 'Kishun', 'Singh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, 4, '2026-03-18 11:40:51', '2026-03-19 04:38:11', '117.233.170.156'),
(216, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_15', '4', 'Shri', 'Jitendra', 'Kumar', 'Singh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 11:51:53', '2026-03-18 11:51:53', '117.233.167.253'),
(217, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_52', '4', 'Shri', 'Iqbal', NULL, 'Mustafa', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:08:35', '2026-03-18 12:08:35', '117.233.167.253'),
(218, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_93', '4', 'Shri', 'CPT Ajay', NULL, 'Kumar', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:09:19', '2026-03-18 12:09:19', '117.233.167.253'),
(219, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_157', '4', 'Shri', 'Ray', 'Kishor', 'Singh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:10:15', '2026-03-18 12:10:15', '117.233.167.253'),
(220, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_23', '4', 'Smt.', 'Indu', 'Bala', 'Narain', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:11:37', '2026-03-18 12:11:37', '117.233.167.253'),
(221, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_79', '4', 'Shri', 'Deobansh', 'Narayan', 'Lal', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:14:24', '2026-03-18 12:14:24', '117.233.167.253'),
(222, '1803268798', 'Yes', 'Yes', 1, 1, NULL, 1, 2, 'B_25', '4', 'Shri', 'Chandeshwar', 'Prasad', 'Singh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', 187, 1, NULL, 4, NULL, '2026-03-18 12:15:40', '2026-03-18 12:15:40', '117.233.167.253'),
(223, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_116', '4', 'Shri', 'Haldhar', 'Prasad', 'Singh', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:17:08', '2026-03-18 12:17:08', '117.233.167.253'),
(224, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_61', '4', 'Shri', 'Mathura', 'Prasad', 'Shaw', 'All Fresh Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:19:10', '2026-03-18 12:19:10', '117.233.167.253'),
(225, '1803268798', 'Yes', 'No', 1, 1, NULL, 1, 2, 'B_138', '4', 'Shri', 'Umeshwar', 'Prasad', 'Singh', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:22:29', '2026-03-18 12:22:29', '117.233.167.253'),
(226, '1803268798', 'Yes', 'Yes', 1, 1, NULL, 1, 2, 'B_72', '4', 'Shri', 'Shyam', 'Kishor', 'Prasad', 'All Old Pages', 1, 0, NULL, NULL, 'received', 197, 1, NULL, 4, NULL, '2026-03-18 12:23:16', '2026-03-18 12:23:16', '117.233.167.253'),
(227, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_13', '4', 'Shri', 'Ravi', NULL, 'Prakash', 'All Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:25:17', '2026-03-18 12:25:17', '117.233.167.253'),
(228, '1803268798', 'No', 'No', 1, 1, NULL, 1, 2, 'B_148', '4', 'Shri', 'Raghu Nandan', 'Ram', 'Turi', 'All Fresh Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-18 12:26:57', '2026-03-18 12:26:57', '117.233.167.253'),
(229, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_89', '4', 'Shri', 'Sudhanshu', NULL, 'Chandra', 'All Poor Quality Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-19 04:45:44', '2026-03-19 04:45:44', '117.233.170.156'),
(230, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_139', '4', 'Shri', 'Sudhir', 'Kumar', 'Singh', 'All Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-19 04:49:20', '2026-03-19 04:49:20', '117.233.170.156'),
(231, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_31', '4', 'Shri', 'Bhukhla', NULL, 'Bhagat', 'Partial Fresh and Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-19 04:50:46', '2026-03-19 04:50:46', '117.233.170.156'),
(232, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_29', '4', 'Shri', 'Deweshwar', NULL, 'Sarkar', 'Partial Fresh and Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-19 04:52:18', '2026-03-19 04:52:18', '117.233.170.156'),
(233, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_110', '4', 'Shri', 'Awadhesh', 'Narayan', 'Sinha', 'All Fresh Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-19 04:58:41', '2026-03-19 04:58:41', '117.233.170.156'),
(234, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_10', '4', 'Shri', 'Mahesh', 'Narayan', 'Dube', 'Partial Fresh and Old Pages', 1, 1, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-19 04:59:56', '2026-03-19 04:59:56', '117.233.170.156'),
(235, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_109', '4', 'Shri', 'Braj Mohan', 'Prasad', 'Sinha', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-19 05:20:57', '2026-03-19 05:20:57', '117.233.170.156'),
(236, '1803264686', 'No', 'No', 1, 1, NULL, 1, 2, 'B_111', '4', 'Shri', 'Dulu', 'Francis', 'Bhengra', 'All Old Pages', 1, 0, NULL, NULL, 'received', NULL, 1, NULL, 4, NULL, '2026-03-19 05:22:23', '2026-03-19 05:22:23', '117.233.170.156'),
(237, '1803264686', 'Yes', 'Yes', 1, 1, NULL, 1, 2, 'B_130', '4', 'Shri', 'Shiva', 'Shankhar', 'Khan', 'All Old Pages', 1, 0, NULL, NULL, 'received', 192, 1, NULL, 4, NULL, '2026-03-19 05:23:43', '2026-03-19 05:23:43', '117.233.170.156');

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
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(10) UNSIGNED NOT NULL,
  `display_name` varchar(100) DEFAULT NULL,
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

INSERT INTO `states` (`id`, `display_name`, `name_en`, `name_hi`, `code`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Andaman and Nicobar Islands', 'Andaman and Nicobar Islands', 'अंडमान और निकोबार द्वीप समूह', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(2, 'Andhra Pradesh', 'Andhra Pradesh', 'आंध्र प्रदेश', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(3, 'Arunachal Pradesh', 'Arunachal Pradesh', 'अरुणाचल प्रदेश', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(4, 'Assam', 'Assam', 'असम', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(5, 'Bihar', 'Bihar', 'बिहार', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(6, 'Chandigarh', 'Chandigarh', 'चंडीगढ़', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(7, 'Chhattisgarh', 'Chhattisgarh', 'छत्तीसगढ़', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(8, 'Dadra and Nagar Haveli and Daman and Diu', 'Dadra and Nagar Haveli and Daman and Diu', 'दादरा और नगर हवेली और दमन और दीव', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(9, 'Delhi', 'Delhi', 'दिल्ली', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(10, 'Goa', 'Goa', 'गोवा', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(11, 'Gujarat', 'Gujarat', 'गुजरात', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(12, 'Haryana', 'Haryana', 'हरियाणा', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(13, 'Himachal Pradesh', 'Himachal Pradesh', 'हिमाचल प्रदेश', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(14, 'Jammu and Kashmir', 'Jammu and Kashmir', 'जम्मू और कश्मीर', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(15, 'Jharkhand', 'Jharkhand', 'झारखंड', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(16, 'Karnataka', 'Karnataka', 'कर्नाटक', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(17, 'Kerala', 'Kerala', 'केरल', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(18, 'Ladakh', 'Ladakh', 'लद्दाख', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(19, 'Lakshadweep', 'Lakshadweep', 'लक्षद्वीप', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(20, 'Madhya Pradesh', 'Madhya Pradesh', 'मध्य प्रदेश', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(21, 'Maharashtra', 'Maharashtra', 'महाराष्ट्र', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(22, 'Manipur', 'Manipur', 'मणिपुर', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(23, 'Meghalaya', 'Meghalaya', 'मेघालय', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(24, 'Mizoram', 'Mizoram', 'मिजोरम', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(25, 'Nagaland', 'Nagaland', 'नागालैंड', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(26, 'Odisha', 'Odisha', 'ओडिशा', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(27, 'Puducherry', 'Puducherry', 'पुडुचेरी', NULL, 'Union Territory', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(28, 'Punjab', 'Punjab', 'पंजाब', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(29, 'Rajasthan', 'Rajasthan', 'राजस्थान', NULL, 'State', '2026-02-28 11:03:30', '2026-03-14 07:41:31'),
(30, 'Sikkim', 'Sikkim', 'सिक्किम', NULL, 'State', '2026-02-28 11:03:31', '2026-03-14 07:41:31'),
(31, 'Tamil Nadu', 'Tamil Nadu', 'तमिलनाडु', NULL, 'State', '2026-02-28 11:03:31', '2026-03-14 07:41:31'),
(32, 'Telangana', 'Telangana', 'तेलंगाना', NULL, 'State', '2026-02-28 11:03:31', '2026-03-14 07:41:31'),
(33, 'Tripura', 'Tripura', 'त्रिपुरा', NULL, 'State', '2026-02-28 11:03:31', '2026-03-14 07:41:31'),
(34, 'Uttar Pradesh', 'Uttar Pradesh', 'उत्तर प्रदेश', NULL, 'State', '2026-02-28 11:03:31', '2026-03-14 07:41:31'),
(35, 'Uttarakhand', 'Uttarakhand', 'उत्तराखंड', NULL, 'State', '2026-02-28 11:03:31', '2026-03-14 07:41:31'),
(36, 'West Bengal', 'West Bengal', 'पश्चिम बंगाल', NULL, 'State', '2026-02-28 11:03:31', '2026-03-14 07:41:31'),
(37, 'Bihar', 'Bihar (Now Jharkhand)', 'बिहार (अब झारखंड)', NULL, 'State', '2026-03-14 06:59:59', '2026-03-14 07:41:40');

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

--
-- Dumping data for table `step_skips`
--

INSERT INTO `step_skips` (`id`, `applicant_id`, `step_number`, `step_name`, `remark`, `reason_category`, `ip_address`, `user_agent`, `skiped_by`, `skipped_at`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'Nominee & Banking', 'No Found', 'will_upload_later', '117.233.169.104', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 3, '2026-03-13 10:15:04', '2026-03-13 10:15:04', '2026-03-13 10:15:04'),
(2, 6, 4, 'Nominee & Banking', 'Not Found', 'documents_not_ready', '49.37.72.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 3, '2026-03-18 05:19:31', '2026-03-18 05:19:31', '2026-03-18 05:19:31'),
(3, 17, 4, 'Nominee & Banking', 'Not Found', 'documents_not_ready', '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-18 06:54:14', '2026-03-18 06:54:14', '2026-03-18 06:54:14'),
(4, 15, 4, 'Nominee & Banking', 'Documents Not Found', 'documents_not_ready', '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-18 07:29:01', '2026-03-18 07:29:01', '2026-03-18 07:29:01'),
(5, 20, 4, 'Nominee & Banking', 'Documents Not Found', 'documents_not_ready', '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-18 08:39:19', '2026-03-18 08:39:19', '2026-03-18 08:39:19'),
(7, 23, 4, 'Nominee & Banking', 'Document Not Found', NULL, '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-18 09:26:07', '2026-03-18 09:26:07', '2026-03-18 09:26:07'),
(9, 25, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-18 10:02:40', '2026-03-18 10:02:40', '2026-03-18 10:02:40'),
(10, 3, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 2, '2026-03-18 10:29:43', '2026-03-18 10:29:43', '2026-03-18 10:29:43'),
(11, 3, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 2, '2026-03-18 10:31:07', '2026-03-18 10:31:07', '2026-03-18 10:31:07'),
(12, 11, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 2, '2026-03-18 11:06:29', '2026-03-18 11:06:29', '2026-03-18 11:06:29'),
(13, 26, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 2, '2026-03-18 11:56:00', '2026-03-18 11:56:00', '2026-03-18 11:56:00'),
(14, 28, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.167.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 2, '2026-03-18 13:04:36', '2026-03-18 13:04:36', '2026-03-18 13:04:36'),
(15, 29, 4, 'Nominee & Banking', 'Documents not found.', 'documents_not_ready', '117.233.170.156', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-19 07:06:53', '2026-03-19 07:06:53', '2026-03-19 07:06:53'),
(16, 2, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 05:04:11', '2026-03-20 05:04:11', '2026-03-20 05:04:11'),
(17, 1, 4, 'Nominee & Banking', 'Documents not found.', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 05:05:23', '2026-03-20 05:05:23', '2026-03-20 05:05:23'),
(18, 2, 4, 'Nominee & Banking', 'Document Not Found', NULL, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 05:18:59', '2026-03-20 05:18:59', '2026-03-20 05:18:59'),
(19, 5, 4, 'Nominee & Banking', 'Documuent Not Found', NULL, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 06:25:40', '2026-03-20 06:25:40', '2026-03-20 06:25:40'),
(20, 6, 4, 'Nominee & Banking', 'Documents not found.', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 06:34:42', '2026-03-20 06:34:42', '2026-03-20 06:34:42'),
(21, 7, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 07:27:10', '2026-03-20 07:27:10', '2026-03-20 07:27:10'),
(22, 7, 4, 'Nominee & Banking', 'Document Not Found', NULL, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 07:31:27', '2026-03-20 07:31:27', '2026-03-20 07:31:27'),
(23, 7, 4, 'Nominee & Banking', 'Document Not Found', NULL, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 07:50:42', '2026-03-20 07:50:42', '2026-03-20 07:50:42'),
(24, 9, 4, 'Nominee & Banking', 'Documents not found.', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 08:37:57', '2026-03-20 08:37:57', '2026-03-20 08:37:57'),
(25, 12, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 09:04:46', '2026-03-20 09:04:46', '2026-03-20 09:04:46'),
(26, 13, 4, 'Nominee & Banking', 'Documents not found.', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 09:22:48', '2026-03-20 09:22:48', '2026-03-20 09:22:48'),
(27, 17, 4, 'Nominee & Banking', 'Document Not found', NULL, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 10:54:28', '2026-03-20 10:54:28', '2026-03-20 10:54:28'),
(28, 16, 4, 'Nominee & Banking', 'Documents not found.', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 11:01:09', '2026-03-20 11:01:09', '2026-03-20 11:01:09'),
(29, 21, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 11:48:59', '2026-03-20 11:48:59', '2026-03-20 11:48:59'),
(30, 22, 4, 'Nominee & Banking', 'Documents not found', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:06:08', '2026-03-20 12:06:08', '2026-03-20 12:06:08'),
(31, 25, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:20:34', '2026-03-20 12:20:34', '2026-03-20 12:20:34'),
(33, 27, 4, 'Nominee & Banking', 'Document Not Found', NULL, '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-20 12:40:48', '2026-03-20 12:40:48', '2026-03-20 12:40:48'),
(34, 26, 4, 'Nominee & Banking', 'Documents not found.', 'documents_not_ready', '117.233.180.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-20 12:44:21', '2026-03-20 12:44:21', '2026-03-20 12:44:21'),
(35, 28, 4, 'Nominee & Banking', 'Documents Not Found', 'documents_not_ready', '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:20:36', '2026-03-21 05:20:36', '2026-03-21 05:20:36'),
(36, 30, 4, 'Nominee & Banking', 'Documents Not Ready', 'documents_not_ready', '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 05:46:04', '2026-03-21 05:46:04', '2026-03-21 05:46:04'),
(37, 29, 4, 'Nominee & Banking', 'DOCUMENTS NOT FOUND', 'documents_not_ready', '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 05:58:24', '2026-03-21 05:58:24', '2026-03-21 05:58:24'),
(39, 33, 4, 'Nominee & Banking', 'Documents not found', 'documents_not_ready', '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 06:58:59', '2026-03-21 06:58:59', '2026-03-21 06:58:59'),
(40, 34, 4, 'Nominee & Banking', 'Document Not Found', NULL, '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 07:44:28', '2026-03-21 07:44:28', '2026-03-21 07:44:28'),
(41, 36, 4, 'Nominee & Banking', 'Documents Not Found', 'documents_not_ready', '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:33:02', '2026-03-21 08:33:02', '2026-03-21 08:33:02'),
(42, 37, 4, 'Nominee & Banking', 'DOCUMENTS NOT FOUND', 'documents_not_ready', '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:38:07', '2026-03-21 08:38:07', '2026-03-21 08:38:07'),
(43, 38, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 08:51:03', '2026-03-21 08:51:03', '2026-03-21 08:51:03'),
(44, 39, 4, 'Nominee & Banking', 'Documents not found.', 'documents_not_ready', '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 2, '2026-03-21 08:59:59', '2026-03-21 08:59:59', '2026-03-21 08:59:59'),
(45, 40, 4, 'Nominee & Banking', 'Document Not Found', 'documents_not_ready', '117.233.189.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 4, '2026-03-21 09:06:40', '2026-03-21 09:06:40', '2026-03-21 09:06:40');

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
(1, 1, 'Harmu-Ranchi', 'HRM', 'Harmu Housing Colony', 'Harmu', 1, '2026-02-05 17:19:24'),
(2, 1, 'Argora-Ranchi', 'ARG', 'Argora Colony', 'Argora', 1, '2026-02-05 17:19:24'),
(3, 1, 'Bariatu-Ranchi', 'BTU', 'Bariatu Colony', 'Bariatu', 1, '2026-02-05 17:19:24'),
(4, 1, 'Kadru-Ranchi', 'KDR', 'Kadru Colony', 'Kadru', 1, '2026-02-05 17:19:24'),
(5, 2, 'Dindli-Adityapur', 'DND', 'Dindli Colony', 'Dindli', 1, '2026-02-05 17:23:25'),
(6, 3, 'Sahibganj', 'SBG', 'Sahibganj Colony', 'Sahibganj', 1, '2026-02-05 17:23:25'),
(7, 4, 'Kumardhubi-Dhanbad', 'KMD', 'Kumardhubi Colony', 'Kumardhubi', 1, '2026-02-05 17:23:25'),
(8, 4, 'Balidih-Bokaro', 'BLH', 'Balidih Colony', 'Balidih', 1, '2026-02-05 17:23:25'),
(9, 4, 'Gomia-Bokaro', 'GOM', 'Gomia Colony', 'Gomia', 1, '2026-02-05 17:23:25'),
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
  `allowed_files` varchar(50) NOT NULL DEFAULT '15',
  `remarks` varchar(255) DEFAULT NULL,
  `status` enum('draft','submitted') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_registers`
--

INSERT INTO `temp_registers` (`id`, `register_no`, `total_files`, `allowed_files`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, '1402264315', 0, '15', NULL, 'draft', '2026-02-14 08:51:26', '2026-02-14 08:51:26'),
(2, '1402269210', 0, '15', NULL, 'draft', '2026-02-14 08:52:48', '2026-02-14 08:52:48'),
(3, '1602263937', 0, '15', NULL, 'draft', '2026-02-16 04:31:44', '2026-02-16 04:31:44'),
(4, '1602265342', 0, '15', NULL, 'draft', '2026-02-16 06:29:09', '2026-02-16 06:29:09'),
(5, '1602262636', 0, '15', NULL, 'draft', '2026-02-16 08:04:13', '2026-02-16 08:04:13'),
(6, '1602261726', 0, '15', NULL, 'draft', '2026-02-16 10:07:06', '2026-02-16 10:07:06'),
(7, '1602268136', 12, '15', NULL, 'draft', '2026-02-16 11:54:33', '2026-02-16 12:25:24'),
(8, '1702261136', 0, '15', NULL, 'draft', '2026-02-17 04:50:36', '2026-02-17 04:50:36'),
(9, '1702265520', 0, '15', NULL, 'draft', '2026-02-17 06:30:38', '2026-02-17 06:30:38'),
(10, '1702261113', 0, '15', NULL, 'draft', '2026-02-17 08:12:15', '2026-02-17 08:12:15'),
(11, '1702267120', 10, '15', NULL, 'draft', '2026-02-17 11:13:45', '2026-02-17 12:22:05'),
(13, '1802262205', 0, '15', NULL, 'draft', '2026-02-18 04:18:59', '2026-02-18 04:18:59'),
(14, '1802261231', 0, '15', NULL, 'draft', '2026-02-18 04:43:37', '2026-02-18 04:43:37'),
(15, '1802264130', 0, '15', NULL, 'draft', '2026-02-18 04:43:45', '2026-02-18 04:43:45'),
(16, '1802263052', 12, '12', NULL, 'draft', '2026-02-18 04:44:01', '2026-02-18 05:11:11'),
(17, '1802265519', 0, '15', NULL, 'draft', '2026-02-18 06:47:18', '2026-02-18 06:47:18'),
(18, '1802264319', 10, '10', NULL, 'draft', '2026-02-18 09:02:53', '2026-02-18 09:18:12'),
(19, '1802263693', 12, '12', NULL, 'draft', '2026-02-18 12:12:54', '2026-02-18 12:37:58'),
(20, '1902268234', 0, '15', NULL, 'draft', '2026-02-19 09:34:34', '2026-02-19 09:34:34'),
(21, '2002269059', 0, '15', NULL, 'draft', '2026-02-20 12:13:03', '2026-02-20 12:13:03'),
(22, '2002267600', 0, '15', NULL, 'draft', '2026-02-20 12:18:47', '2026-02-20 12:18:47'),
(23, '2102262879', 20, '20', NULL, 'draft', '2026-02-21 05:22:41', '2026-02-21 05:50:21'),
(24, '2102263817', 0, '10', NULL, 'draft', '2026-02-21 12:25:37', '2026-02-21 12:25:42'),
(25, '2302266899', 0, '15', NULL, 'draft', '2026-02-23 10:20:40', '2026-02-23 10:20:40'),
(26, '2302263677', 0, '15', NULL, 'draft', '2026-02-23 10:20:44', '2026-02-23 10:20:44'),
(27, '2302269066', 0, '5', NULL, 'draft', '2026-02-23 10:37:48', '2026-02-23 10:38:21'),
(28, '2402268304', 0, '15', NULL, 'draft', '2026-02-24 05:08:39', '2026-02-24 05:08:39'),
(29, '2402268653', 0, '5', NULL, 'draft', '2026-02-24 05:09:28', '2026-02-24 05:09:33'),
(30, '2402269981', 0, '5', NULL, 'draft', '2026-02-24 06:53:33', '2026-02-24 06:53:48'),
(31, '2402262176', 0, '15', NULL, 'draft', '2026-02-24 07:22:41', '2026-02-24 07:22:41'),
(32, '2402262911', 0, '15', NULL, 'draft', '2026-02-24 07:23:53', '2026-02-24 07:23:53'),
(33, '2402262974', 0, '15', NULL, 'draft', '2026-02-24 12:10:48', '2026-02-24 12:10:48'),
(34, '2402262087', 0, '15', NULL, 'draft', '2026-02-24 12:20:48', '2026-02-24 12:20:48'),
(35, '2502269000', 0, '15', NULL, 'draft', '2026-02-25 04:39:24', '2026-02-25 04:39:24'),
(36, '2502266058', 0, '15', NULL, 'draft', '2026-02-25 04:40:32', '2026-02-25 04:40:32'),
(37, '2502265739', 0, '15', NULL, 'draft', '2026-02-25 04:40:37', '2026-02-25 04:40:37'),
(38, '2502263654', 0, '15', NULL, 'draft', '2026-02-25 07:54:51', '2026-02-25 07:54:51'),
(39, '2502264198', 0, '15', NULL, 'draft', '2026-02-25 07:55:31', '2026-02-25 07:55:31'),
(40, '2502269877', 0, '20', NULL, 'draft', '2026-02-25 08:12:23', '2026-02-25 08:21:11'),
(41, '2502266459', 0, '15', NULL, 'draft', '2026-02-25 12:54:15', '2026-02-25 12:54:15'),
(42, '2702261039', 0, '10', NULL, 'draft', '2026-02-27 05:07:12', '2026-02-27 05:07:35'),
(43, '2702268188', 0, '12', NULL, 'draft', '2026-02-27 08:42:57', '2026-02-27 08:44:08'),
(44, '2702267522', 1, '12', NULL, 'draft', '2026-02-27 09:25:05', '2026-02-27 09:26:53'),
(45, '2702263432', 12, '12', NULL, 'draft', '2026-02-27 09:28:22', '2026-02-27 09:51:54'),
(46, '2702268678', 0, '15', NULL, 'draft', '2026-02-27 09:54:41', '2026-02-27 09:54:41'),
(47, '2702268368', 3, '11', NULL, 'draft', '2026-02-27 10:09:03', '2026-02-27 10:16:41'),
(48, '2702263550', 0, '20', NULL, 'draft', '2026-02-27 10:33:34', '2026-02-27 10:33:46'),
(49, '2702261221', 0, '2', NULL, 'draft', '2026-02-27 10:38:22', '2026-02-27 10:38:27'),
(50, '2702263032', 11, '11', NULL, 'draft', '2026-02-27 12:36:41', '2026-02-27 13:05:28'),
(51, '2802266800', 0, '15', NULL, 'draft', '2026-02-28 11:12:43', '2026-02-28 11:12:43'),
(52, '0603265237', 0, '12', NULL, 'draft', '2026-03-06 10:08:44', '2026-03-06 10:08:55'),
(53, '0903269837', 0, '15', NULL, 'draft', '2026-03-09 11:50:10', '2026-03-09 11:50:10'),
(54, '0903268389', 20, '20', NULL, 'draft', '2026-03-09 12:07:12', '2026-03-11 07:46:32'),
(55, '1003268038', 0, '15', NULL, 'draft', '2026-03-10 10:25:39', '2026-03-10 10:25:39'),
(56, '1003267333', 1, '12', NULL, 'draft', '2026-03-10 10:26:07', '2026-03-10 10:28:38'),
(57, '1003264996', 0, '15', NULL, 'draft', '2026-03-10 10:27:04', '2026-03-10 10:27:04'),
(58, '1003265123', 0, '20', NULL, 'draft', '2026-03-10 10:28:22', '2026-03-10 10:29:01'),
(59, '1003266713', 0, '15', NULL, 'draft', '2026-03-10 10:35:15', '2026-03-10 10:35:15'),
(60, '1103268950', 0, '15', NULL, 'draft', '2026-03-11 07:35:36', '2026-03-11 07:35:36'),
(61, '1103268072', 0, '15', NULL, 'draft', '2026-03-11 07:41:29', '2026-03-11 07:41:29'),
(62, '1103266679', 0, '15', NULL, 'draft', '2026-03-11 08:23:38', '2026-03-11 08:23:38'),
(63, '1103267867', 0, '15', NULL, 'draft', '2026-03-11 08:26:20', '2026-03-11 08:26:20'),
(64, '1103266769', 0, '15', NULL, 'draft', '2026-03-11 09:39:46', '2026-03-11 09:39:46'),
(65, '1103266594', 0, '15', NULL, 'draft', '2026-03-11 09:46:01', '2026-03-11 09:46:01'),
(66, '1103266754', 0, '15', NULL, 'draft', '2026-03-11 10:07:27', '2026-03-11 10:07:27'),
(67, '1103264620', 0, '15', NULL, 'draft', '2026-03-11 10:12:20', '2026-03-11 10:12:20'),
(68, '1103266230', 0, '15', NULL, 'draft', '2026-03-11 10:38:51', '2026-03-11 10:38:51'),
(69, '1103264887', 0, '15', NULL, 'draft', '2026-03-11 10:43:52', '2026-03-11 10:43:52'),
(70, '1103263312', 0, '15', NULL, 'draft', '2026-03-11 10:50:17', '2026-03-11 10:50:17'),
(71, '1103265290', 0, '15', NULL, 'draft', '2026-03-11 10:58:40', '2026-03-11 10:58:40'),
(72, '1103265912', 22, '22', NULL, 'draft', '2026-03-11 11:16:34', '2026-03-11 11:56:03'),
(73, '1303269865', 0, '15', NULL, 'draft', '2026-03-13 09:51:20', '2026-03-13 09:51:20'),
(74, '1303261450', 0, '15', NULL, 'draft', '2026-03-13 09:52:29', '2026-03-13 09:52:29'),
(75, '1303264283', 11, '11', NULL, 'draft', '2026-03-13 13:02:50', '2026-03-14 07:47:59'),
(76, '1403265718', 0, '15', NULL, 'draft', '2026-03-14 04:47:42', '2026-03-14 04:47:42'),
(77, '1403265537', 0, '15', NULL, 'draft', '2026-03-14 05:03:50', '2026-03-14 05:03:50'),
(78, '1403266615', 0, '15', NULL, 'draft', '2026-03-14 05:03:55', '2026-03-14 05:03:55'),
(79, '1403268291', 0, '15', NULL, 'draft', '2026-03-14 05:03:59', '2026-03-14 05:03:59'),
(80, '1403263512', 0, '15', NULL, 'draft', '2026-03-14 05:04:39', '2026-03-14 05:04:39'),
(81, '1403264329', 9, '9', NULL, 'draft', '2026-03-14 06:01:18', '2026-03-14 06:55:06'),
(82, '1403261218', 0, '15', NULL, 'draft', '2026-03-14 07:14:36', '2026-03-14 07:14:36'),
(83, '1403261789', 0, '15', NULL, 'draft', '2026-03-14 11:27:42', '2026-03-14 11:27:42'),
(84, '1403261108', 0, '15', NULL, 'draft', '2026-03-14 11:54:12', '2026-03-14 11:54:12'),
(85, '1603269279', 0, '15', NULL, 'draft', '2026-03-16 04:51:34', '2026-03-16 04:51:34'),
(86, '1703261254', 0, '15', NULL, 'draft', '2026-03-17 04:49:52', '2026-03-17 04:49:52'),
(87, '1703266901', 11, '10', NULL, 'draft', '2026-03-17 06:22:32', '2026-03-17 07:40:12'),
(88, '1703262854', 0, '15', NULL, 'draft', '2026-03-17 07:01:36', '2026-03-17 07:01:36'),
(89, '1703267382', 0, '15', NULL, 'draft', '2026-03-17 07:21:39', '2026-03-17 07:21:39'),
(90, '1703267993', 11, '11', NULL, 'draft', '2026-03-17 09:38:15', '2026-03-17 10:12:40'),
(91, '1703264455', 11, '11', NULL, 'draft', '2026-03-17 10:14:14', '2026-03-17 10:26:15'),
(92, '1703263462', 11, '11', NULL, 'draft', '2026-03-17 10:28:10', '2026-03-17 10:53:56'),
(93, '1703262719', 0, '15', NULL, 'draft', '2026-03-17 10:56:02', '2026-03-17 10:56:02'),
(94, '1803263392', 0, '15', NULL, 'draft', '2026-03-18 10:55:42', '2026-03-18 10:55:42'),
(95, '1803266613', 0, '15', NULL, 'draft', '2026-03-18 11:18:27', '2026-03-18 11:18:27'),
(96, '1803264686', 12, '13', NULL, 'draft', '2026-03-18 11:28:24', '2026-03-19 05:23:43'),
(97, '1803268798', 13, '13', NULL, 'draft', '2026-03-18 11:48:19', '2026-03-18 12:26:57'),
(98, '1903265129', 0, '15', NULL, 'draft', '2026-03-19 05:40:24', '2026-03-19 05:40:24'),
(99, '1903261682', 0, '15', NULL, 'draft', '2026-03-19 05:50:51', '2026-03-19 05:50:51'),
(100, '2103263984', 0, '3', NULL, 'draft', '2026-03-21 09:32:39', '2026-03-21 09:32:48');

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
(1, 'COMPUTER Ed.', 'Other', 'General', '012222222222', '1996-07-12', '7979040859', 'computered3896@gmail.com', NULL, '$2y$12$IikRB4bOKuUAeT4un2GPC.2vr/eHOtAtUsfYbUk24YEsfbeEQTs26', 'scanner', '2026-02-07 15:58:55', '2026-02-13 06:02:54', '2025-11-24 17:22:13', '2026-02-13 06:02:54', '117.233.191.91', '2026-02-13 06:02:54'),
(2, 'Namita Kumari', 'Female', 'General', '984777777773', '2000-07-12', '7979040859', 'namita.jshb@computered.co.in', NULL, '$2y$10$py9iso27e0SxzaqrDWMTg.J18i/F0X5HcbQ9rjfYHH3UBkjwz0VJ6', 'scanner', '2026-02-07 15:58:55', '2026-03-21 09:04:38', '2026-02-09 17:22:13', '2026-03-21 09:04:38', '117.233.189.51', '2026-03-21 09:04:38'),
(3, 'Sonali Kumari', 'Female', 'General', '567854675756', '2000-04-05', '7979040859', 'sonali.jshb@computered.co.in', NULL, '$2y$10$AMSzL/ajRkHah9ZZRsAItO9GN48BmX5i1M3kB5QoEIO3rFAo5BsKq', 'scanner', '2026-02-07 15:58:55', '2026-03-21 05:47:02', '2026-02-09 17:22:13', '2026-03-21 05:47:02', '49.37.74.97', '2026-03-21 05:47:02'),
(4, 'Prerna Kumari', 'Female', 'General', '654654654645', '2002-07-12', '5673846345', 'prerna.jshb@computered.co.in', NULL, '$2y$12$kydyORdyxUaaPqx6E.3wxe5Tpx8R9kWuqbTG9BXiGM4FGEz0yHxAK', 'scanner', '2026-02-07 15:58:55', '2026-03-23 04:13:38', '2026-02-09 17:22:13', '2026-03-23 04:13:38', '127.0.0.1', '2026-03-23 04:13:38'),
(5, 'Nibha Kumari', 'Female', 'General', '843574835949', '2004-07-12', '9873478234', 'nibha.jshb@computered.co.in', NULL, '$2y$12$kydyORdyxUaaPqx6E.3wxe5Tpx8R9kWuqbTG9BXiGM4FGEz0yHxAK', 'scanner', '2026-02-07 15:58:55', '2026-03-16 04:56:03', '2026-02-09 17:22:13', '2026-03-16 04:56:03', '117.233.163.148', '2026-03-16 04:56:03'),
(6, 'Tannu Kumari', 'Female', 'General', '874239874928', '1999-06-12', '9827349283', 'tannu.jshb@computered.co.in', NULL, '$2y$12$kydyORdyxUaaPqx6E.3wxe5Tpx8R9kWuqbTG9BXiGM4FGEz0yHxAK', 'scanner', '2026-02-07 15:58:55', '2026-03-19 05:39:41', '2026-02-09 17:22:13', '2026-03-19 05:39:41', '117.233.170.156', '2026-03-19 05:39:41'),
(7, 'Rajesh Kumar', 'Male', 'General', '985734578345', '1979-06-10', '9875453555', 'rajesh.jshb@computered.co.in', NULL, '$2y$12$kydyORdyxUaaPqx6E.3wxe5Tpx8R9kWuqbTG9BXiGM4FGEz0yHxAK', 'scanner', '2026-02-07 15:58:55', '2026-03-21 08:55:39', '2026-02-09 17:22:13', '2026-03-21 08:55:39', '117.233.189.51', '2026-03-21 08:55:39');

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
-- Indexes for table `allottee_emi_ledger`
--
ALTER TABLE `allottee_emi_ledger`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `allottee_step_durations`
--
ALTER TABLE `allottee_step_durations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_allottee` (`allottee_id`),
  ADD KEY `idx_step` (`step_no`);

--
-- Indexes for table `approved_applicants`
--
ALTER TABLE `approved_applicants`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `student_application_id` (`student_application_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

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
-- Indexes for table `joint_allottees`
--
ALTER TABLE `joint_allottees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lot_assignments`
--
ALTER TABLE `lot_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lot_assignment_logs`
--
ALTER TABLE `lot_assignment_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_logs`
--
ALTER TABLE `otp_logs`
  ADD PRIMARY KEY (`id`) USING BTREE;

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `admin_details`
--
ALTER TABLE `admin_details`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_otp_logs`
--
ALTER TABLE `admin_otp_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `allottees`
--
ALTER TABLE `allottees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `allottees_contact_details`
--
ALTER TABLE `allottees_contact_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `allottee_documents`
--
ALTER TABLE `allottee_documents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;

--
-- AUTO_INCREMENT for table `allottee_emi_ledger`
--
ALTER TABLE `allottee_emi_ledger`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `allottee_file_details`
--
ALTER TABLE `allottee_file_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allottee_nominee_bank_details`
--
ALTER TABLE `allottee_nominee_bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `allottee_property_fin_details`
--
ALTER TABLE `allottee_property_fin_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `allottee_step_durations`
--
ALTER TABLE `allottee_step_durations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `approved_applicants`
--
ALTER TABLE `approved_applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=805;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exported_files`
--
ALTER TABLE `exported_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `file_registrations`
--
ALTER TABLE `file_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- AUTO_INCREMENT for table `joint_allottees`
--
ALTER TABLE `joint_allottees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lot_assignments`
--
ALTER TABLE `lot_assignments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lot_assignment_logs`
--
ALTER TABLE `lot_assignment_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `otp_logs`
--
ALTER TABLE `otp_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

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
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `step_skips`
--
ALTER TABLE `step_skips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `sub_divisions`
--
ALTER TABLE `sub_divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `temp_registers`
--
ALTER TABLE `temp_registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
