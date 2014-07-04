ALTER TABLE `user_staffs` CHANGE `f_bsb` `f_bsb` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

--ALTER TABLE `custom_fields` ADD `admin_only` TINYINT NOT NULL DEFAULT '0' AFTER `type`;