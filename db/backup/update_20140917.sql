ALTER TABLE `company_profile` ADD `super_fund_external_id` VARCHAR(255) NOT NULL AFTER `accept_cc_msg`;
ALTER TABLE `user_staffs` ADD `s_external_id` VARCHAR(255) NOT NULL AFTER `s_name`;