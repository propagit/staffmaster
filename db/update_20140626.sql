<<<<<<< HEAD
-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jun 26, 2014 at 05:45 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `user_db_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `export_fields`
--

DROP TABLE IF EXISTS `export_fields`;
CREATE TABLE IF NOT EXISTS `export_fields` (
  `order` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `value` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `export_fields`
--

INSERT INTO `export_fields` (`order`, `object`, `format`, `value`, `label`) VALUES
(1, 'invoice', 'single', 'job_id', 'Job ID'),
(2, 'invoice', 'single', 'company_name', 'Client Name'),
(3, 'invoice', 'single', 'job_date', 'Date'),
(4, 'invoice', 'single', 'staff_name', 'Staff name'),
(5, 'invoice', 'single', 'start_time', 'Start Time'),
(6, 'invoice', 'single', 'finish_time', 'Finish Time'),
(7, 'payrun_tfn', 'single', 'job_date', 'Job Date'),
(8, 'payrun_tfn', 'single', 'start_time', 'Start Time'),
(9, 'payrun_tfn', 'single', 'finish_time', 'Finish Time'),
(10, 'payrun_tfn', 'single', 'staff_name', 'Staff Name'),
(11, 'payrun_tfn', 'single', 'break', 'Break'),
(12, 'payrun_tfn', 'single', 'hours', 'Hours'),
(13, 'payrun_tfn', 'single', 'pay_rate', 'Pay Rate'),
(14, 'payrun_tfn', 'single', 'venue', 'Venue'),
(15, 'payrun_tfn', 'single', 'internal_staff_id', 'Internal Staff Id'),
(16, 'payrun_tfn', 'single', 'external_staff_id', 'External Staff Id'),
(17, 'payrun_tfn', 'single', 'job_name', 'Job Name'),
(18, 'payrun_abn', 'single', 'job_date', 'Job Date'),
(19, 'payrun_abn', 'single', 'start_time', 'Start Time'),
(20, 'payrun_abn', 'single', 'finish_time', 'Finish Time'),
(21, 'payrun_abn', 'single', 'staff_name', 'Staff Name'),
(22, 'payrun_abn', 'single', 'break', 'Break'),
(23, 'payrun_abn', 'single', 'hours', 'Hours'),
(24, 'payrun_abn', 'single', 'pay_rate', 'Pay Rate'),
(25, 'payrun_abn', 'single', 'venue', 'Venue'),
(26, 'payrun_abn', 'single', 'internal_staff_id', 'Internal Staff Id'),
(27, 'payrun_abn', 'single', 'external_staff_id', 'External Staff Id'),
(28, 'payrun_abn', 'single', 'job_name', 'Job Name'),
(29, 'payrun_tfn', 'batched', 'staff_name', 'Staff Name'),
(30, 'payrun_tfn', 'batched', 'hours', 'Hours'),
(31, 'payrun_tfn', 'batched', 'internal_staff_id', 'Internal Staff Id'),
(32, 'payrun_tfn', 'batched', 'external_staff_id', 'External Staff Id'),
(33, 'expense', 'single', 'job_date', 'Job Date'),
(34, 'expense', 'single', 'staff_first_name', 'Staff First Name'),
(35, 'expense', 'single', 'staff_last_name', 'Staff Last Name'),
(36, 'expense', 'single', 'job_name', 'Job Name'),
(37, 'expense', 'single', 'tax_amount', 'Tax Amount'),
(38, 'expense', 'single', 'inc_tax_amount', 'Inc Tax Amount'),
(39, 'expense', 'single', 'paid_on', 'Paid Date/Time'),
(40, 'expense', 'single', 'ex_tax_amount', 'Ex Tax Amount'),
(41, 'invoice', 'single', 'invoice_number', 'Invoice Number'),
(42, 'invoice', 'single', 'tax_amount', 'Tax Amount'),
(43, 'invoice', 'single', 'inc_tax_amount', 'Inc Tax Amount'),
(44, 'invoice', 'single', 'ex_tax_amount', 'Ex Tax Amount'),
(45, 'invoice', 'single', 'hours', 'Hours'),
(46, 'invoice', 'single', 'break', 'Break'),
(47, 'invoice', 'single', 'description', 'Description'),
(48, 'invoice', 'single', 'type', 'Type'),
(49, 'staff', 'single', 'title', 'Title'),
(50, 'staff', 'single', 'rating', 'Rating'),
(51, 'staff', 'single', 'first_name', 'First Name'),
(52, 'staff', 'single', 'gender', 'Gender'),
(53, 'staff', 'single', 'dob', 'Date of birth'),
(54, 'staff', 'single', 'address', 'Address'),
(55, 'staff', 'single', 'suburb', 'Suburb'),
(56, 'staff', 'single', 'city', 'City'),
(57, 'staff', 'single', 'postcode', 'Postcode'),
(58, 'staff', 'single', 'state', 'State'),
(59, 'staff', 'single', 'country', 'Country'),
(60, 'staff', 'single', 'email', 'Email'),
(61, 'staff', 'single', 'phone', 'Phone'),
(62, 'staff', 'single', 'external_id', 'External Staff ID'),
(63, 'staff', 'single', 'emergency_contact', 'Emergency Contact Person'),
(64, 'staff', 'single', 'emergency_phone', 'Emergency Phone'),
(65, 'staff', 'single', 'account_name', 'Bank Account Name'),
(66, 'staff', 'single', 'bsb', 'BSB'),
(67, 'staff', 'single', 'account_number', 'Bank Account Number'),
(68, 'staff', 'single', 'employed_as', 'Employed As'),
(69, 'staff', 'single', 'tfn_number', 'TFN Number'),
(70, 'staff', 'single', 'abn_number', 'ABN Number'),
(71, 'staff', 'single', 'super_choice', 'Choice of superannuation'),
(72, 'staff', 'single', 'super_employee_id', 'Super Employee ID Number'),
(73, 'staff', 'single', 'super_fund_name', 'Super Fund Name'),
(74, 'staff', 'single', 'super_membership_number', 'Super Membership Number'),
(75, 'staff', 'single', 'last_name', 'Last Name'),
(76, 'staff', 'single', 'mobile', 'Mobile'),
(77, 'staff', 'single', 'internal_id', 'Internal Staff ID'),
(78, 'staff', 'single', 'joined_date', 'Joined Date'),
(79, 'payrun_tfn', 'single', 'job_jd', 'Job ID'),
(80, 'payrun_abn', 'single', 'job_id', 'Job ID'),
(81, 'staff', 'single', 'status', 'Status');

-- --------------------------------------------------------

--
-- Table structure for table `export_templates`
--

DROP TABLE IF EXISTS `export_templates`;
CREATE TABLE IF NOT EXISTS `export_templates` (
  `export_id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`export_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `export_templates`
--

INSERT INTO `export_templates` (`export_id`, `object`, `format`, `name`, `status`) VALUES
(1, 'invoice', 'single', 'Invoice Export', 0),
(2, 'invoice', 'batched', 'Invoice Export', 0),
(3, 'payrun_tfn', 'single', 'Default - TFN Export', 0),
(4, 'payrun_tfn', 'batched', 'TFN Export', 0),
(5, 'payrun_abn', 'single', 'ABN Supplier Export', 0),
(6, 'payrun_abn', 'batched', 'ABN Supplier Export', 0),
(7, 'staff', 'single', 'Default - Staff Export', 0),
(8, 'invoice', 'batched', 'Custom batched invoice', 0),
(9, 'expense', 'single', 'Staff Expense Export ', 0),
(10, 'staff', 'single', 'Shoebooks - Staff Export', 0),
(11, 'payrun_tfn', 'single', 'Shoebooks - TFN Export', 0),
(12, 'payrun_abn', 'single', 'Shoebooks - ABN Export', 0),
(13, 'invoice', 'single', 'Shoebooks - Client Invoice Export', 0);

-- --------------------------------------------------------

--
-- Table structure for table `export_template_data`
--

DROP TABLE IF EXISTS `export_template_data`;
CREATE TABLE IF NOT EXISTS `export_template_data` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `export_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=170 ;

--
-- Dumping data for table `export_template_data`
--

INSERT INTO `export_template_data` (`field_id`, `export_id`, `order`, `title`, `value`) VALUES
(11, 1, 0, 'Client Name', '{company_name}'),
(12, 1, 7, 'Work Date', '{job_date}'),
(13, 1, 5, 'Employee', '{staff_name}'),
(18, 3, 0, 'Group', '{internal_staff_id}'),
(19, 3, 1, 'Employee', '{external_staff_id}'),
(20, 3, 3, 'Date', '{job_date}'),
(21, 3, 4, 'Hours', '{hours}'),
(22, 3, 5, 'EarningID', '{pay_rate}'),
(25, 3, 6, 'Description', '{job_name}     {start_time} - {finish_time}'),
(26, 3, 2, 'Staff name', '{staff_name}'),
(27, 5, 27, 'Group', '{internal_staff_id}'),
(28, 5, 28, 'Employee', '{external_staff_id}'),
(29, 5, 29, 'Staff Name', '{staff_name}'),
(30, 5, 30, 'Date', '{job_date}'),
(31, 5, 31, 'Hours', '{hours}'),
(32, 5, 32, 'EarningID', '{pay_rate}'),
(33, 5, 33, 'Description', '{job_name}     {start_time} - {finish_time}'),
(34, 9, 34, 'Job Date', '{job_date}'),
(35, 9, 35, 'First Name', '{staff_first_name}'),
(36, 9, 36, 'Last Name', '{staff_last_name}'),
(39, 9, 39, 'Tax Amount', '{tax_amount}'),
(40, 9, 40, 'Ex Tax Amount', '{ex_tax_amount}'),
(41, 9, 41, 'Inc Tax Amount', '{inc_tax_amount}'),
(42, 9, 42, 'Job Name', '{job_name}'),
(43, 9, 43, 'Paid Date/Time', '{paid_on}'),
(44, 1, 1, 'Invoice Number', '{invoice_number}'),
(45, 1, 2, 'Tax Amount', '{tax_amount}'),
(46, 1, 3, 'Ex Tax Amount', '{ex_tax_amount}'),
(47, 1, 4, 'Inc Tax Amount', '{inc_tax_amount}'),
(48, 1, 8, 'Start Time', '{start_time}'),
(49, 1, 9, 'Finish Time', '{finish_time}'),
(50, 1, 10, 'Break', '{break}'),
(51, 1, 11, 'Hours', '{hours}'),
(52, 1, 6, 'Description', '{description}'),
(81, 7, 0, 'Title', '{title}'),
(82, 7, 1, 'First Name', '{first_name}'),
(83, 7, 2, 'Last Name', '{last_name}'),
(84, 7, 3, 'Email', '{email}'),
(85, 7, 4, 'Address', '{address}'),
(86, 7, 5, 'Suburb', '{suburb}'),
(87, 7, 6, 'City', '{city}'),
(88, 7, 7, 'State', '{state}'),
(89, 7, 8, 'Postcode', '{postcode}'),
(90, 7, 9, 'Country', '{country}'),
(91, 7, 10, 'Phone', '{phone}'),
(92, 7, 11, 'Rating', '{rating}'),
(94, 7, 12, 'External Staff ID', '{external_id}'),
(95, 7, 13, 'Gender', '{gender}'),
(96, 7, 14, 'Date of birth', '{dob}'),
(99, 7, 15, 'Emergency Contact Person', '{emergency_contact}'),
(100, 7, 16, 'Emergency Phone', '{emergency_phone}'),
(101, 7, 18, 'BSB', '{bsb}'),
(104, 7, 17, 'Bank Account Name', '{account_name}'),
(105, 7, 19, 'Bank Account Number', '{account_number}'),
(106, 7, 20, 'Employed As', '{employed_as}'),
(107, 7, 21, 'ABN Number', '{abn_number}'),
(108, 7, 22, 'TFN Number', '{tfn_number}'),
(109, 7, 25, 'Super Fund Name', '{super_fund_name}'),
(110, 7, 23, 'Choice of superannuation', '{super_choice}'),
(111, 7, 24, 'Super Employee ID Number', '{super_employee_id}'),
(112, 7, 26, 'Super Membership Number', '{super_membership_number}'),
(117, 10, 0, 'EmployeeID', '{internal_id}'),
(118, 10, 1, 'FirstName', '{first_name}'),
(119, 10, 2, 'Surname', '{last_name}'),
(120, 10, 3, 'dtmBirthDate', '{dob}'),
(121, 10, 4, 'TFN', '{tfn_number}'),
(122, 10, 5, 'Address1', '{address}'),
(123, 10, 6, 'Address2', ''),
(124, 10, 7, 'City', '{city}'),
(125, 10, 8, 'State', '{state}'),
(126, 10, 9, 'PostCode', '{postcode}'),
(127, 10, 10, 'Country', '{country}'),
(128, 10, 11, 'Notes', ''),
(129, 10, 12, 'Phone1', '{phone}'),
(130, 10, 13, 'Phone2', ''),
(131, 10, 14, 'PhoneW', ''),
(132, 10, 15, 'PhoneH', ''),
(133, 10, 16, 'Fax', ''),
(134, 10, 17, 'Mobile', '{mobile}'),
(135, 10, 18, 'Email', '{email}'),
(136, 10, 19, 'Web', ''),
(140, 10, 25, 'strBankNumber', '{bsb}'),
(141, 10, 26, 'strBankAccount', '{account_number}'),
(142, 10, 27, 'strExtraVendorID', '{super_employee_id}'),
(143, 10, 28, 'strExtraFundName', '{super_fund_name}'),
(144, 10, 29, 'strExtraFundNumber', '{super_membership_number}'),
(145, 10, 23, 'strEmploymentType', ''),
(146, 10, 24, 'strBankName', ''),
(147, 10, 20, 'Title', ''),
(148, 10, 21, 'strDepartment', ''),
(149, 10, 22, 'dtmDateHired', '{joined_date}'),
(150, 11, 0, 'Group', '{external_staff_id}'),
(151, 11, 1, 'EmployeeID', '{internal_staff_id}'),
(152, 11, 2, 'DateFrom', ''),
(153, 11, 3, 'DateTo', ''),
(154, 11, 4, 'Date', '{job_date}'),
(155, 11, 7, 'Units', '{hours}'),
(156, 11, 8, 'strEarningID', '{pay_rate}'),
(157, 11, 9, 'Notes', '{job_name}:  {start_time} -  {finish_time}'),
(158, 11, 5, 'DivID', '{job_jd}'),
(159, 11, 6, 'JobID', 'DIV{job_jd}'),
(160, 12, 160, 'Group', '{external_staff_id}'),
(161, 12, 161, 'EmployeeID', '{internal_staff_id}'),
(162, 12, 162, 'DateFrom', ''),
(163, 12, 163, 'DateTo', ''),
(164, 12, 164, 'Date', '{job_date}'),
(165, 12, 165, 'DivID', '{job_id}'),
(166, 12, 166, 'JobID', 'Div{job_id}'),
(167, 12, 167, 'Units', '{hours}'),
(168, 12, 168, 'strEarningID', '{pay_rate}'),
(169, 12, 169, 'Notes', '{job_name}:  {start_time} -  {finish_time}');
=======
INSERT INTO `email_templates` (`email_template_id`, `template_name`, `template_content`, `email_from`, `email_subject`, `default_template`, `auto_send`, `created`, `modified`) VALUES
(1, 'Welcome Staff', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Welcome to the&nbsp{CompanyName}&nbspteam</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We are thrilled to have you joint our team. Before completing your first shift with us we need you to logon to your staff account and complete your online induction.&nbsp</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Completing your induction ensures that your details in the system are accurate, you get paid on time and can apply for shifts as they become available.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To log on to your staff account click this link {SystemURL}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">and login with the following details</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">User Name &nbsp &nbsp {UserName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Password &nbsp &nbsp &nbsp {Password}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We look forward to working with you.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n', 'team@staffbooks.com', 'Welcome To Our Team', '', 'no', '2014-03-19 06:42:01', '2014-03-19 06:42:01'),
(2, 'Roster Update', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has recently been updated, please login to your staff account to confirm all shifts we have you working on.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your current roster is as follow:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n', 'team@staffbooks.com', 'Roster Update', '', 'no', '2014-03-14 06:08:44', '2014-03-14 06:08:44'),
(3, 'Apply For Shifts', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We have just updated our system with a series of jobs. Please login to your staff account {SystemURL}&nbspand apply for jobs you would like to work on.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Some of the new shifts that have become available include:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{SelectedShifts}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind Regards</span></span></p>\r\n', 'team@staffbooks.com', 'Apply For Shifts', '', 'no', '2014-03-14 06:09:06', '2014-03-14 06:09:06'),
(4, 'Shift Reminder', '<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">Dear&nbsp{FirstName}</span></span></p>\r\n\r\n<p><span style="font-family:arial,sans-serif&#59 font-size:9.0pt">This is a work reminder that you are working for the following shifts:</span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">{ShiftInfo}</span></span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">Please contact us immeadiatly if you have any questions regarding your shift.&nbsp</span></span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">Kind regards</span></span></p>', 'team@staffbooks.com', 'Shift Reminder', '', 'no', '2014-03-20 06:32:37', '2014-03-20 06:32:37'),
(5, 'Work Confirmation', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">You have been confirmed to work on the below job. If for any reason you can&#39t work this shift please contact us immediately.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{ShiftInfo}</span></span></p>', 'team@staffbooks.com', 'Work Confirmation', '', 'no', '2014-03-14 06:09:20', '2014-03-14 06:09:20'),
(6, 'Forgot Password', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp{FirstName}</span></span></p>\r\n\r\n<p>We received a forgotten password request from you.</p>\r\n\r\n<p>Your new login details are as follows:</p>\r\n\r\n<p>Username:&nbsp{UserName}</p>\r\n\r\n<p>Password:&nbsp{Password}</p>\r\n\r\n<p>&nbsp</p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif&#59 font-size:12px">Please contact us immeadiatly if you did not request this password request.&nbsp</span></p>\r\n\r\n<p>&nbsp</p>\r\n', 'team@staffbooks.com', 'Password Reset', '', 'no', '2014-03-20 04:47:51', '2014-03-20 04:47:51'),
(7, 'Client Invoice', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp{ClientContactName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please find attached an invoice from&nbsp{CompanyName} for recent services for {ClientCompanyName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">The invoice details are as follows:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Invoice Number: &nbsp {InvoiceNumber}<br />\r\nAmount Due: &nbsp &nbsp &nbsp &nbsp ${AmountDue}<br />\r\nDue Date: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp{DueDate} &nbsp&nbsp</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">A downloadable invoice is attached or you can login to your member account to retrieve a copy of this invoice at any time.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{CompanyName}</span></span></p>\r\n', 'team@staffbooks.com', '{CompanyName} Invoice Issued - {IssueDate}', '', 'no', '2014-03-21 06:12:06', '2014-03-21 06:12:06'),
(8, 'Client Quote', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has been updated and requires your attention.&nbsp</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please login to your account to confirm your shifts. Your Current Roster is as follows:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please contact us immeadiatly if you have any questions regarding your roster.&nbsp</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To Login to your account click here</span></span></p>\r\n', 'team@staffbooks.com', 'Client Quote', '', 'no', '2014-03-14 06:09:40', '2014-03-14 06:09:40'),
(9, 'Brief', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">You can view the brief from this url.&nbsp{BriefURL}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Regards</span></span></p>\r\n\r\n<p>&nbsp</p>', 'team@staffbooks.com', 'Job Brief', '', 'no', '2014-04-07 06:27:00', '2014-04-07 06:27:00');
>>>>>>> 3883fb7e5db21dac18749b033ffc6135ad854696
