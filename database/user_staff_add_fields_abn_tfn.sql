ALTER TABLE `user_staffs` ADD `f_employed` INT NOT NULL AFTER `f_bsb` ,
ADD `f_abn_1` INT NOT NULL AFTER `f_employed` ,
ADD `f_abn_2` INT NOT NULL AFTER `f_abn_1` ,
ADD `f_abn_3` INT NOT NULL AFTER `f_abn_2` ;
ALTER TABLE `user_staffs` CHANGE `f_abn_1` `f_abn_1` VARCHAR( 11 ) NOT NULL ,
CHANGE `f_abn_2` `f_abn_2` VARCHAR( 11 ) NOT NULL ,
CHANGE `f_abn_3` `f_abn_3` VARCHAR( 11 ) NOT NULL ;