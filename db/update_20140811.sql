--ALTER TABLE `attribute_payrate_data` ADD `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
ALTER TABLE `job_shift_timesheets` ADD `external_id` VARCHAR(20) NOT NULL AFTER `timesheet_id`;
ALTER TABLE `job_shift_timesheets` ADD `external_msg` VARCHAR(1000) NOT NULL AFTER `external_id`;