ALTER TABLE  `job_shifts` ADD  `information_sheet` TINYINT( 4 ) NOT NULL DEFAULT  '1' COMMENT  '1: information sheet visible, 0  not visible' AFTER  `expenses` ;