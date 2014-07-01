INSERT INTO `email_merge_fields` (`merge_field_id`, `email_template_id`, `merge_label`, `merge_field`, `merge_order`) VALUES
(34, 9, 'Staff First Name', '{FirstName}', 1),
(35, 9, 'Staff Family Name', '{FamilyName}', 2),
(36, 9, 'Company Name', '{CompanyName}', 3),
(37, 9, 'System URL', '{SystemURL}', 4),
(38, 9, 'Brief URL', '{BriefURL}', 5);

UPDATE  `user_db_user`.`email_templates` SET  `template_content` =  '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Hi&nbsp;{FirstName}</span></span></p>

<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">You can view the brief from this url.&nbsp;{BriefURL}</span></span></p>

<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Regards</span></span></p> 

<p>&nbsp;</p>
' WHERE  `email_templates`.`email_template_id` =9;

