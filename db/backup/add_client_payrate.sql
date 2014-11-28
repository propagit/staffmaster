ALTER TABLE `job_shifts` CHANGE `payrate_type` `client_payrate_id` INT NOT NULL;
ALTER TABLE `job_shift_timesheets` CHANGE `payrate_type` `client_payrate_id` INT NOT NULL;