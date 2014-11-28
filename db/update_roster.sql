ALTER TABLE `jobs` ADD `type` TINYINT NOT NULL DEFAULT '0' COMMENT '0: scheduling, 1: standard roster' AFTER `job_id`;

ALTER TABLE `jobs` ADD `start_date` DATE NOT NULL AFTER `type`;
