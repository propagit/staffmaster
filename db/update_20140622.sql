ALTER TABLE `forms` ADD `status` TINYINT NOT NULL AFTER `receive_email`;
ALTER TABLE `form_applicants` ADD `accepted_on` DATETIME NOT NULL , ADD `rejected_on` DATETIME NOT NULL ;
ALTER TABLE `form_applicants` ADD `status` TINYINT NOT NULL AFTER `form_id`;