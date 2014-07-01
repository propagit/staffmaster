INSERT INTO `export_fields` (`order`, `object`, `format`, `value`, `label`) VALUES (NULL, 'invoice', 'single', 'external_client_id', 'External Client ID');

INSERT INTO `export_fields` (`order`, `object`, `format`, `value`, `label`) VALUES (NULL, 'payrun_tfn', 'single', 'payable_date', 'Payable Date');



ALTER TABLE `payruns` ADD `payable_date` DATE NOT NULL AFTER `date_to`;