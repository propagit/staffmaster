-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 06, 2014 at 06:37 AM
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
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`email_template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`email_template_id`, `template_name`, `template_content`, `email_from`, `email_subject`, `created`, `modified`) VALUES
(1, 'Welcome Staff', '<p>Dear&nbsp;{FirstName}</p>\r\n\r\n<p>Welcome to our Team</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Please contact us immeadiatly if you have any questions regarding your roster.</p>\r\n\r\n<p>To Login to your account click here</p>\r\n', 'admin@smcloud.com.au', 'Welcome To Our Team', '2014-03-06 06:32:33', '2014-03-06 06:32:33'),
(2, 'Roster Update', '<p>Dear&nbsp;{FirstName}</p>\r\n\r\n<p>Your roster has been updated and requires your attention.</p>\r\n\r\n<p>Please login to your account to confirm your shifts. Your Current Roster is as follows:</p>\r\n\r\n<p>{Roster}</p>\r\n\r\n<p>Please contact us immeadiatly if you have any questions regarding your roster.</p>\r\n\r\n<p>To Login to your account click here</p>\r\n', 'admin@smcloud.com.au', 'Roster Update', '2014-03-06 06:32:42', '2014-03-06 06:32:42'),
(3, 'Apply For Shifts', '<p>Dear&nbsp;{FirstName}</p>\r\n\r\n<p>Your roster has been updated and requires your attention.</p>\r\n\r\n<p>Please login to your account to confirm your shifts. Your Current Roster is as follows:</p>\r\n\r\n<p>{Roster}</p>\r\n\r\n<p>Please contact us immeadiatly if you have any questions regarding your roster.</p>\r\n\r\n<p>To Login to your account click here</p>\r\n', 'admin@smcloud.com.au', 'Apply For Shifts', '2014-03-06 06:32:50', '2014-03-06 06:32:50'),
(4, 'Shift Reminder', '<p>Dear&nbsp;{FirstName}</p>\r\n\r\n<p>Your roster has been updated and requires your attention.&nbsp;</p>\r\n\r\n<p>Please login to your account to confirm your shifts. Your Current Roster is as follows:</p>\r\n\r\n<p>{Roster}</p>\r\n\r\n<p>Please contact us immeadiatly if you have any questions regarding your roster.&nbsp;</p>\r\n\r\n<p>To Login to your account click here</p>\r\n', 'admin@smcloud.com.au', 'Shift Reminder', '2014-03-06 06:32:57', '2014-03-06 06:32:57'),
(5, 'Work Confirmation', '<p>Dear&nbsp;{FirstName}</p>\r\n\r\n<p>Your roster has been updated and requires your attention.</p>\r\n\r\n<p>Please login to your account to confirm your shifts. Your Current Roster is as follows:</p>\r\n\r\n<p>{Roster}</p>\r\n\r\n<p>Please contact us immeadiatly if you have any questions regarding your roster.</p>\r\n\r\n<p>To Login to your account click here</p>\r\n', 'admin@smcloud.com.au', 'Work Confirmation', '2014-03-06 06:33:07', '2014-03-06 06:33:07'),
(6, 'Forgot Password', '<p>Dear&nbsp;{FirstName}</p>\r\n\r\n<p>Your roster has been updated and requires your attention.&nbsp;</p>\r\n\r\n<p>Please login to your account to confirm your shifts. Your Current Roster is as follows:</p>\r\n\r\n<p>{Roster}</p>\r\n\r\n<p>Please contact us immeadiatly if you have any questions regarding your roster.&nbsp;</p>\r\n\r\n<p>To Login to your account click here</p>\r\n', 'admin@smcloud.com.au', 'Forgot Password', '2014-03-06 06:33:14', '2014-03-06 06:33:14'),
(7, 'Client Invoice', '<p>Dear&nbsp;{FirstName}</p>\r\n\r\n<p>Your roster has been updated and requires your attention.&nbsp;</p>\r\n\r\n<p>Please login to your account to confirm your shifts. Your Current Roster is as follows:</p>\r\n\r\n<p>{Roster}</p>\r\n\r\n<p>Please contact us immeadiatly if you have any questions regarding your roster.&nbsp;</p>\r\n\r\n<p>To Login to your account click here</p>\r\n', 'admin@smcloud.com.au', 'Client Invoice', '2014-03-06 06:33:21', '2014-03-06 06:33:21'),
(8, 'Client Quote', '<p>Dear&nbsp;{FirstName}</p>\r\n\r\n<p>Your roster has been updated and requires your attention.&nbsp;</p>\r\n\r\n<p>Please login to your account to confirm your shifts. Your Current Roster is as follows:</p>\r\n\r\n<p>{Roster}</p>\r\n\r\n<p>Please contact us immeadiatly if you have any questions regarding your roster.&nbsp;</p>\r\n\r\n<p>To Login to your account click here</p>\r\n', 'admin@smcloud.com.au', 'Client Quote', '2014-03-06 06:33:28', '2014-03-06 06:33:28');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
