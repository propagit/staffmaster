INSERT INTO `email_merge_fields` (`merge_field_id`, `email_template_id`, `merge_label`, `merge_field`, `merge_order`) VALUES
(39, 5, 'Staff First Name', '{FirstName}', 1),
(40, 5, 'Staff Family Name', '{FamilyName}', 2),
(41, 5, 'Company Name', '{CompanyName}', 3),
(42, 5, 'System URL', '{SystemURL}', 4),
(43, 5, 'Shift Info', '{ShiftInfo}', 5),
(44, 2, 'Company Name', '{CompanyName}', 5),
(45, 3, 'Company Name', '{CompanyName}', 5);

UPDATE  `email_templates` SET  `template_content` =  '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp;{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">You have been confirmed to work on the below job. If for any reason you can&#39;t work this shift please contact us immediately.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{ShiftInfo}</span></span></p>