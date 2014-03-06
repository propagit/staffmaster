RENAME TABLE  `staff_master`.`staffs_custom_attributes` TO  `staff_master`.`staff_custom_attributes` ;
RENAME TABLE  `staff_master`.`staffs_roles` TO  `staff_master`.`staff_roles` ;
RENAME TABLE  `staff_master`.`staffs_groups` TO  `staff_master`.`staff_groups` ;

ALTER TABLE  `staff_custom_attributes` CHANGE  `staffs_custom_attribute_id`  `staff_custom_attribute_id` INT( 11 ) NOT NULL AUTO_INCREMENT ;
ALTER TABLE  `staff_groups` CHANGE  `staffs_groups_id`  `staff_groups_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ;
ALTER TABLE  `staff_roles` CHANGE  `staffs_roles_id`  `staff_roles_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ;

ALTER TABLE  `staff_custom_attributes` ADD  `file_upload` ENUM(  'yes',  'no' ) NOT NULL DEFAULT  'no';