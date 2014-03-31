-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2014 at 12:32 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `staff_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `export_fields`
--

CREATE TABLE `export_fields` (
  `order` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `value` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

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
(61, 'staff', 'single', 'phone', 'Mobile Phone'),
(62, 'staff', 'single', 'external_id', 'External ID'),
(63, 'staff', 'single', 'emergency_contact', 'Emergency Contact'),
(64, 'staff', 'single', 'emergency_phone', 'Emergency Phone'),
(65, 'staff', 'single', 'account_name', 'Account Name'),
(66, 'staff', 'single', 'bsb', 'BSB'),
(67, 'staff', 'single', 'account_number', 'Account Number'),
(68, 'staff', 'single', 'employed_as', 'Employed As'),
(69, 'staff', 'single', 'tfn_number', 'TFN Number'),
(70, 'staff', 'single', 'abn_number', 'ABN Number'),
(71, 'staff', 'single', 'super_choice', 'Choice of superannuation'),
(72, 'staff', 'single', 'super_employee_id', 'Employee ID Number'),
(73, 'staff', 'single', 'super_fund_name', 'Super Fund Name'),
(74, 'staff', 'single', 'super_membership_number', 'Membership Number'),
(75, 'staff', 'single', 'last_name', 'Last Name');
