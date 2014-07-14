ALTER TABLE `account` CHANGE `credits` `system_credits` BIGINT(20) NOT NULL;
ALTER TABLE `account` ADD `sms_credits` int(11) NOT NULL AFTER `system_credits`;
ALTER TABLE `job_shifts` ADD `sms_sent` TINYINT NOT NULL DEFAULT '0' AFTER `is_alert`;
ALTER TABLE `job_shifts` ADD `sms_sent_on` datetime NOT NULL AFTER `sms_sent`;
ALTER TABLE `orders` ADD `credit_type` VARCHAR(100) NOT NULL AFTER `order_time`;