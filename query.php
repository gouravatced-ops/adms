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
