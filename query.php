ALTER TABLE `sub_divisions` ADD `colony_name` VARCHAR(255) NULL DEFAULT NULL AFTER `subdivision_code`, ADD `locality_address` VARCHAR(255) NULL DEFAULT NULL AFTER `colony_name`;


ALTER TABLE `allottee_emi_ledger` ADD `calculation_type` VARCHAR(100) NULL DEFAULT NULL AFTER `allottee_id`;
