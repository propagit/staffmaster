ALTER TABLE  `email_templates` ADD  `default_template` TEXT NOT NULL COMMENT 'this is the default template which will be used to restore to default template' AFTER  `email_subject` ,
ADD  `auto_send` ENUM(  'yes',  'no' ) NOT NULL DEFAULT  'yes' COMMENT  'defines weather or not the email is automatically send' AFTER `default_template` ;
