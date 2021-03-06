INSERT INTO `export_templates` (`export_id`, `target`, `object`, `level`, `name`, `status`) VALUES (NULL, 'shoebooks', 'invoice', 'shift', 'Shoebooks - Client Invoice Export By Shift', '1');

INSERT INTO `export_template_fields` (`object`, `level`, `value`, `label`) VALUES
('invoice', 'shift', 'internal_client_id', 'Internal Client ID'),
('invoice', 'shift', 'external_client_id', 'External Client ID'),
('invoice', 'shift', 'client_company_name', 'Client Company Name'),
('invoice', 'shift', 'client_address', 'Client Address'),
('invoice', 'shift', 'client_suburb', 'Client Suburb'),
('invoice', 'shift', 'client_city', 'Client City'),
('invoice', 'shift', 'client_postcode', 'Client Postcode'),
('invoice', 'shift', 'client_state', 'Client State'),
('invoice', 'shift', 'client_country', 'Client Country'),
('invoice', 'shift', 'client_contact_name', 'Client Contact Name'),
('invoice', 'shift', 'client_email', 'Client Email'),
('invoice', 'shift', 'issued_date', 'Issued Date'),
('invoice', 'shift', 'due_date', 'Due Date'),
('invoice', 'shift', 'item_description', 'Item Description'),
('invoice', 'shift', 'tax_type', 'Tax Type'),
('invoice', 'shift', 'tax_amount', 'Tax Amount'),
('invoice', 'shift', 'ex_tax_amount', 'Ex Tax Amount'),
('invoice', 'shift', 'inc_tax_amount', 'Inc Tax Amount'),
('invoice', 'shift', 'invoice_id', 'Invoice ID'),
('invoice', 'shift', 'po_number', 'PO Number'),
('invoice', 'shift', 'job_date', 'Job Date'),
('invoice', 'shift', 'hours', 'Hours'),
('invoice', 'shift', 'staff_name', 'Staff Name'),
('invoice', 'shift', 'break', 'Break'),
('invoice', 'shift', 'start_time', 'Start Time'),
('invoice', 'shift', 'finish_time', 'Finish Time');