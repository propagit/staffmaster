INSERT INTO `export_templates` (`export_id`, `target`, `object`, `level`, `name`, `status`) VALUES (NULL, 'xero', 'payrun_abn', 'shift', 'XERO - ABN Export', '1');
INSERT INTO `export_templates` (`export_id`, `target`, `object`, `level`, `name`, `status`) VALUES (NULL, 'xero', 'staff', '', 'XERO ABN - Suppliers', '1');


INSERT INTO `export_template_data` (`export_id`, `order`, `title`, `value`) VALUES
(25, 1, 'EmailAddress', '{email}'),
(25, 2, 'First Name', '{first_name}'),
(25, 3, 'Last Name', '{last_name}'),
(25, 14, 'SAAddressLine1', '{address}'),
(25, 18, 'SACity', '{suburb}'),
(25, 19, 'SARegion', '{state}'),
(25, 20, 'SAPostalCode', '{postcode}'),
(25, 21, 'SACountry', '{country}'),
(25, 22, 'PhoneNumber', '{phone}'),
(25, 24, 'MobileNumber', '{mobile}'),
(25, 27, 'BankAccountName', '{account_name}'),
(25, 28, 'Bank Account Number', ' {bsb}-{account_number}'),
(25, 30, 'TaxNumber', '{abn_number}'),
(25, 0, '*Name', '{first_name}- {email}'),
(25, 4, 'POAttentionTo', ''),
(25, 5, 'POAddressLine1', ''),
(25, 7, 'POAddressLine2', ''),
(25, 6, 'POAddressLine3', ''),
(25, 8, 'POAddressLine4', ''),
(25, 9, 'POCity', ''),
(25, 10, 'PORegion', ''),
(25, 11, 'POPostalCode', ''),
(25, 12, 'POCountry', ''),
(25, 13, 'SAAttentionTo', ''),
(25, 15, 'SAAddressLine2', ''),
(25, 16, 'SAAddressLine3', ''),
(25, 17, 'SAAddressLine4', ''),
(25, 23, 'FaxNumber', ''),
(25, 25, 'DDINumber', ''),
(25, 26, 'SkypeName', ''),
(25, 29, 'BankAccountParticulars', ''),
(25, 31, 'AccountsReceivableTaxCodeName', ''),
(25, 32, 'AccountsPayableTaxCodeName', ''),
(25, 33, 'Website', ''),
(25, 34, 'Discount', ''),
(25, 35, 'DueDateBillDay', ''),
(25, 36, 'DueDateBillTerm', ''),
(25, 37, 'DueDateSalesDay', ''),
(25, 38, 'DueDateSalesTerm', ''),
(25, 39, 'SalesAccount', ''),
(25, 40, 'PurchasesAccount', ''),
(25, 41, 'TrackingName1', ''),
(25, 42, 'SalesTrackingOption1', ''),
(25, 43, 'PurchasesTrackingOption1', ''),
(25, 44, 'TrackingName2', ''),
(25, 45, 'SalesTrackingOption2', ''),
(25, 46, 'PurchasesTrackingOption2', ''),
(25, 47, 'BrandingTheme', ''),
(24, 0, '*ContactName', '{staff_name} -{internal_staff_id}'),
(24, 1, 'EmailAddress', ''),
(24, 2, 'POAddressLine1', ''),
(24, 3, 'POAddressLine2', ''),
(24, 4, 'POAddressLine3', ''),
(24, 5, 'POAddressLine4', ''),
(24, 6, 'POCity', ''),
(24, 7, 'PORegion', ''),
(24, 8, 'POPostalCode', ''),
(24, 9, 'POCountry', ''),
(24, 10, '*InvoiceNumber', '{internal_staff_id}- {start_time}'),
(24, 11, '*InvoiceDate', '{pay_run_date}'),
(24, 12, '*DueDate', '{pay_run_date}'),
(24, 13, 'InventoryItemCode', ''),
(24, 19, 'TrackingName1', ''),
(24, 20, 'TrackingOption1', ''),
(24, 21, 'TrackingName2', ''),
(24, 22, 'TrackingOption2', ''),
(24, 23, 'Currency', ''),
(24, 14, '*Description', '{job_name} {start_time}- {finish_time} {break}'),
(24, 15, '*Quantity', '1'),
(24, 16, '*UnitAmount', '{ex_tax_amount}'),
(24, 17, '*TaxType', '{taxable}'),
(24, 18, '*AccountCode', '477');