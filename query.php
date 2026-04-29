ALTER TABLE `sub_divisions` ADD `colony_name` VARCHAR(255) NULL DEFAULT NULL AFTER `subdivision_code`, ADD `locality_address` VARCHAR(255) NULL DEFAULT NULL AFTER `colony_name`;


ALTER TABLE `allottee_emi_ledger` ADD `calculation_type` VARCHAR(100) NULL DEFAULT NULL AFTER `allottee_id`;

ALTER TABLE `file_registrations` ADD `division_id` INT NULL DEFAULT NULL AFTER `allowed_files`;
ALTER TABLE `temp_registers` ADD `division_id` INT NULL DEFAULT NULL AFTER `allowed_files`;

INSERT INTO `document_master` (`id`, `document_name`, `document_key`, `document_category`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'Applicant\'s Application with Affidavit', 'applicant_application_with_affidavit', 'freehold', '1', '1', '2026-03-30 11:44:14', '2026-03-30 11:44:14'), (NULL, 'Affidavit of Applicant', 'affidavit_of_applicant', 'freehold', '2', '1', '2026-03-30 11:44:14', '2026-03-30 11:44:14'), (NULL, 'Board Forwarding Letter, Site Verification Checklist, Map and Photo of Property', 'board_forwarding_letter_site_verification_checklist_map_photo', 'freehold', '3', '1', '2026-03-30 11:44:14', '2026-03-30 11:44:14'), (NULL, 'NOC from Board', 'noc_from_board', 'freehold', '4', '1', '2026-03-30 11:44:14', '2026-03-30 11:44:14'), (NULL, 'Dividend Calculation Letter and Payment Receipt', 'dividend_calculation_letter_payment_receipt', 'freehold', '5', '1', '2026-03-30 11:44:14', '2026-03-30 11:44:14'), (NULL, 'Payment Confirmation Letter from Board', 'payment_confirmation_letter_from_board', 'freehold', '6', '1', '2026-03-30 11:44:14', '2026-03-30 11:44:14'), (NULL, 'Registry Deed and Property Map', 'registry_deed_and_property_map', 'freehold', '7', '1', '2026-03-30 11:44:14', '2026-03-30 11:44:14')

ALTER TABLE `allottees` ADD `allottee_verify` INT NOT NULL DEFAULT '0' AFTER `allottee_document_path`;
ALTER TABLE `file_registrations` ADD `lots_subadmin_approved` INT NOT NULL DEFAULT '0' AFTER `status`;
ALTER TABLE `file_registrations` ADD `divisional_approval` INT NOT NULL DEFAULT '0' AFTER `lots_subadmin_approved`;


ALTER TABLE `allottees` ADD `sub_admin_remarks` VARCHAR(255) NULL DEFAULT NULL AFTER `sub_admin_allottee_verify`;
ALTER TABLE `allottees` ADD `divisional_approval` INT NOT NULL DEFAULT '0' AFTER `sub_admin_remarks`, ADD `divisional_remaks` VARCHAR(255) NULL DEFAULT NULL AFTER `divisional_approval`;
ALTER TABLE `allottees` CHANGE `allottee_verify` `sub_admin_allottee_verify` INT(11) NOT NULL DEFAULT '0';

ALTER TABLE `allottee_documents` ADD `is_sadmin_read` INT NOT NULL DEFAULT '0' AFTER `file_name`, ADD `is_divisional_read` INT NOT NULL DEFAULT '0' AFTER `is_sadmin_read`;

ALTER TABLE `admins` CHANGE `role` `role` ENUM('council_office','registar','superadmin','approver') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `admins` ADD `division_id` INT NOT NULL DEFAULT '0' AFTER `gender`, ADD `designation` VARCHAR(255) NULL DEFAULT NULL AFTER `division_id`;

ALTER TABLE `allottees` ADD `file_remarks` VARCHAR(255) NULL DEFAULT NULL AFTER `total_pages`;
ALTER TABLE `allottees` ADD `divisional_approved_date` VARCHAR(100) NULL DEFAULT NULL AFTER `divisional_remaks`;
ALTER TABLE `allottees` ADD `sub_admin_checked_date` VARCHAR(100) NULL DEFAULT NULL AFTER `sub_admin_remarks`;

ALTER TABLE `allottee_documents` ADD `divisional_read_date` VARCHAR(100) NULL DEFAULT NULL AFTER `is_divisional_read`;
ALTER TABLE `allottee_documents` ADD `sadmin_read_date` VARCHAR(100) NULL DEFAULT NULL AFTER `is_sadmin_read`;

ALTER TABLE `file_registrations` ADD `divisional_approval_at` VARCHAR(100) NULL DEFAULT NULL AFTER `divisional_approval`, ADD `handover_by` INT(11) NULL DEFAULT NULL AFTER `divisional_approval_at`, ADD `handover_at` VARCHAR(100) NULL DEFAULT NULL AFTER `handover_by`;

INSERT INTO `admins` (`id`, `admin_details_id`, `mobile_no`, `admin_name`, `profile_path`, `alt_mobile_no`, `email_id`, `password`, `prev_password`, `role`, `gender`, `division_id`, `designation`, `otp_verified_at`, `last_login`, `last_ip`, `password_created_at`, `created_at`, `updated_at`) VALUES (NULL, '4', '9834579834', 'Ajit Kumar', NULL, NULL, 'ajit.jshb@computered.co.in', '$2y$12$kydyORdyxUaaPqx6E.3wxe5Tpx8R9kWuqbTG9BXiGM4FGEz0yHxAK', NULL, 'registar', 'Male', '4', 'HEAD OF OFFICE', '2026-04-10 17:55:53', '2026-04-10 17:55:53', '49.37.75.101', '2026-04-12 12:30:54', '2026-02-04 14:56:19', '2026-04-13 12:31:29');
ALTER TABLE `allottees` ADD `divisional_approved_by` INT NULL DEFAULT NULL AFTER `divisional_remaks`;


// new allottee
ALTER TABLE `allottees` ADD `is_first_time_register` INT NOT NULL DEFAULT '0' AFTER `is_emi_active`, ADD `is_earlier_cancelled` INT NOT NULL DEFAULT '0' AFTER `is_first_time_register`;

CREATE TABLE `allottee_master_documents` ( `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, `allottee_id` BIGINT UNSIGNED NOT NULL, `register_allottee_id` BIGINT UNSIGNED NOT NULL, `property_number` VARCHAR(50) NOT NULL, `file_label` VARCHAR(50) NOT NULL, -- File 1, File 2... `confirm_received` ENUM('Yes','No') DEFAULT 'No', `confirm_same_allottee_name` ENUM('Yes','No') DEFAULT 'No', `read_file` TINYINT(1) DEFAULT 0, `is_checked` TINYINT(1) DEFAULT 0, `checked_at` TIMESTAMP NULL DEFAULT NULL, `is_read_divisional` TINYINT(1) DEFAULT 0, `is_approved_divisional` TINYINT(1) DEFAULT 0, `approved_at` TIMESTAMP NULL DEFAULT NULL, `uploaded_at` TIMESTAMP NULL DEFAULT NULL, `reuploaded_at` TIMESTAMP NULL DEFAULT NULL, `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP, `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP );
ALTER TABLE `allottee_master_documents` ADD `file_path` VARCHAR(255) NULL DEFAULT NULL AFTER `confirm_same_allottee_name`, ADD `file_name` VARCHAR(255) NULL DEFAULT NULL AFTER `file_path`;

ALTER TABLE `register_allottees` ADD `grand_parent_id` INT NULL DEFAULT NULL AFTER `parent_id`;
ALTER TABLE `allottee_master_documents` CHANGE `register_allottee_id` `register_allottee_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL;
