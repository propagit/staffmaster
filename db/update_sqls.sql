INSERT INTO `export_templates` (`target`, `object`, `level`, `name`, `status`) VALUES ('xero', 'invoice', 'pay_rate', 'Xero (Pay Rate Per Line)', '0');


INSERT INTO `export_template_data` (`export_id`, `order`, `title`, `value`) VALUES
(26, 1, 'EmailAddress', '{client_email}'),
(26, 2, 'POAddressLine1', '{client_address}'),
(26, 3, 'POAddressLine2', '{client_suburb}'),
(26, 4, 'POAddressLine3', ''),
(26, 5, 'POAddressLine4', ''),
(26, 6, 'POCity', '{client_city}'),
(26, 7, 'PORegion', '{client_state}'),
(26, 8, 'POPostalCode', '{client_postcode}'),
(26, 9, 'POCountry', '{client_country}'),
(26, 10, 'InvoiceNumber', '{invoice_id}'),
(26, 11, 'Reference', '{po_number}'),
(26, 12, 'InvoiceDate', '{issued_date}'),
(26, 13, 'DueDate', '{due_date}'),
(26, 14, 'InventoryItemCode', ''),
(26, 16, 'Quantity', '{hours}'),
(26, 19, 'Discount', ''),
(26, 21, 'TaxAmount', '{tax_amount}'),
(26, 22, 'TrackingName1', ''),
(26, 24, 'TrackingName2', ''),
(26, 23, 'TrackingOption1', ''),
(26, 25, 'TrackingOption2', ''),
(26, 26, 'Currency', 'AUD'),
(26, 0, 'ContactName', '{client_company_name}'),
(26, 18, 'AccountCode', '200'),
(26, 20, 'TaxType', 'GST on Income'),
(26, 15, 'Description', '{venue}   {start_time}   {finish_time}'),
(26, 17, 'UnitAmount', '{pay_rate_amount}');
