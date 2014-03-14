-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2014 at 06:10 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `staff_master`
--
CREATE DATABASE IF NOT EXISTS `staff_master` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `staff_master`;

-- --------------------------------------------------------

--
-- Table structure for table `email_merge_fields`
--

CREATE TABLE IF NOT EXISTS `email_merge_fields` (
  `merge_field_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email_template_id` bigint(20) NOT NULL,
  `merge_label` varchar(255) NOT NULL,
  `merge_field` varchar(255) NOT NULL,
  `merge_order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`merge_field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `email_merge_fields`
--

INSERT INTO `email_merge_fields` (`merge_field_id`, `email_template_id`, `merge_label`, `merge_field`, `merge_order`) VALUES
(1, 1, 'Staff First Name', '{FirstName}', 1),
(2, 1, 'Staff Family Name', '{FamilyName}', 2),
(3, 1, 'Company Name', '{CompanyName}', 3),
(4, 1, 'System URL', '{SystemURL}', 4),
(5, 1, 'Username', '{UserName}', 5),
(6, 1, 'Password', '{Password}', 6),
(7, 2, 'Staff First Name', '{FirstName}', 1),
(8, 2, 'Staff Family Name', 'FamilyName}', 2),
(9, 2, 'Roster', '{Roster}', 3),
(10, 3, 'Staff First Name', '{FirstName}', 1),
(11, 3, 'Staff Family Name', '{FamilyName}', 2),
(12, 3, 'System URL', '{SystemURL}', 3),
(13, 3, 'Selected Shifts', '{SelectedShifts}', 4);

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `template_content` text NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `default_template` text NOT NULL COMMENT 'this is the default template which will be used to restore to default template',
  `auto_send` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'defines weather or not the email is automatically send',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`email_template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`email_template_id`, `template_name`, `template_content`, `email_from`, `email_subject`, `default_template`, `auto_send`, `created`, `modified`) VALUES
(1, 'Welcome Staff', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp;{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Welcome to the&nbsp;{CompanyName}&nbsp;team</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We are thrilled to have you joint our team. Before completing your first shift with us we need you to logon to your staff account and complete your online induction.&nbsp;</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Completing your induction ensures that your details in the system are accurate, you get paid on time and can apply for shifts as they become availble.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To log on to your staff account click this link {SystemURL}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">and login with the following details</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">User Name &nbsp; &nbsp; {UserName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Password &nbsp; &nbsp; &nbsp; {Password}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We look forward to working with you.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n', 'admin@smcloud.com.au', 'Welcome To Our Team', '', 'yes', '2014-03-14 06:08:11', '2014-03-14 06:08:11'),
(2, 'Roster Update', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has recently been updated, please login to your staff account to confirm all shifts we have you working on.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your current roster is as follow:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n', 'admin@smcloud.com.au', 'Roster Update', '', 'no', '2014-03-14 06:08:44', '2014-03-14 06:08:44'),
(3, 'Apply For Shifts', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We have just updated our system with a series of jobs. Please login to your staff account {SystemURL}&nbsp;and apply for jobs you would like to work on.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Some of the new shifts that have become available include:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{SelectedShifts}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind Regards</span></span></p>\r\n', 'admin@smcloud.com.au', 'Apply For Shifts', '', 'no', '2014-03-14 06:09:06', '2014-03-14 06:09:06'),
(4, 'Shift Reminder', '<p><span style="font-size:12px">Dear&nbsp;{FirstName}</span></p>\r\n\r\n<p><span style="font-size:12px">Your roster has been updated and requires your attention.&nbsp;</span></p>\r\n\r\n<p><span style="font-size:12px">Please login to your account to confirm your shifts. Your Current Roster is as follows:</span></p>\r\n\r\n<p><span style="font-size:12px">{Roster}</span></p>\r\n\r\n<p><span style="font-size:12px">Please contact us immeadiatly if you have any questions regarding your roster.&nbsp;</span></p>\r\n\r\n<p><span style="font-size:12px">To Login to your account click here</span></p>\r\n', 'admin@smcloud.com.au', 'Shift Reminder', '', 'no', '2014-03-14 06:09:13', '2014-03-14 06:09:13'),
(5, 'Work Confirmation', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp;{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has been updated and requires your attention.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please login to your account to confirm your shifts. Your Current Roster is as follows:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please contact us immeadiatly if you have any questions regarding your roster.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To Login to your account click here</span></span></p>\r\n', 'admin@smcloud.com.au', 'Work Confirmation', '', 'no', '2014-03-14 06:09:20', '2014-03-14 06:09:20'),
(6, 'Forgot Password', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp;{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has been updated and requires your attention.&nbsp;</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please login to your account to confirm your shifts. Your Current Roster is as follows:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please contact us immeadiatly if you have any questions regarding your roster.&nbsp;</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To Login to your account click here</span></span></p>\r\n', 'admin@smcloud.com.au', 'Forgot Password', '', 'no', '2014-03-14 06:09:26', '2014-03-14 06:09:26'),
(7, 'Client Invoice', '<p><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp;{FirstName}</span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif">Your roster has been updated and requires your attention.&nbsp;</span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif">Please login to your account to confirm your shifts. Your Current Roster is as follows:</span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif">Please contact us immeadiatly if you have any questions regarding your roster.&nbsp;</span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif">To Login to your account click here</span></p>\r\n', 'admin@smcloud.com.au', 'Client Invoice', '', 'no', '2014-03-14 06:09:35', '2014-03-14 06:09:35'),
(8, 'Client Quote', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp;{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has been updated and requires your attention.&nbsp;</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please login to your account to confirm your shifts. Your Current Roster is as follows:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please contact us immeadiatly if you have any questions regarding your roster.&nbsp;</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To Login to your account click here</span></span></p>\r\n', 'admin@smcloud.com.au', 'Client Quote', '', 'no', '2014-03-14 06:09:40', '2014-03-14 06:09:40');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
