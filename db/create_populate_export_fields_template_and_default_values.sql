-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2014 at 05:06 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `user_db_user`
--
CREATE DATABASE IF NOT EXISTS `user_db_user` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `user_db_user`;

-- --------------------------------------------------------

--
-- Table structure for table `export_fields`
--

CREATE TABLE IF NOT EXISTS `export_fields` (
  `order` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `value` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

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
(28, 'payrun_abn', 'single', 'job_name', 'Job Nam'),
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
(75, 'staff', 'single', 'last_name', 'Last Name');

-- --------------------------------------------------------

--
-- Table structure for table `export_templates`
--

CREATE TABLE IF NOT EXISTS `export_templates` (
  `export_id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`export_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `export_templates`
--

INSERT INTO `export_templates` (`export_id`, `object`, `format`, `name`, `status`) VALUES
(1, 'invoice', 'single', 'Invoice Export', 0),
(2, 'invoice', 'batched', 'Invoice Export', 0),
(3, 'payrun_tfn', 'single', 'TFN Export', 0),
(4, 'payrun_tfn', 'batched', 'TFN Export', 0),
(5, 'payrun_abn', 'single', 'ABN Supplier Export', 0),
(6, 'payrun_abn', 'batched', 'ABN Supplier Export', 0),
(7, 'staff', 'single', 'Staff Export', 0),
(8, 'invoice', 'batched', 'Custom batched invoice', 0),
(9, 'expense', 'single', 'Staff Expense Export ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `export_template_data`
--

CREATE TABLE IF NOT EXISTS `export_template_data` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `export_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

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
(112, 7, 26, 'Super Membership Number', '{super_membership_number}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
