-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2014 at 12:17 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

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
-- Table structure for table `company_profile_email_template`
--

CREATE TABLE IF NOT EXISTS `company_profile_email_template` (
  `company_profile_id` int(11) NOT NULL,
  `email_company_name` varchar(200) NOT NULL,
  `email_company_address` varchar(200) NOT NULL,
  `email_company_suburb` varchar(200) NOT NULL,
  `email_company_state` varchar(200) NOT NULL,
  `email_company_postcode` varchar(200) NOT NULL,
  `email_company_country` varchar(200) NOT NULL,
  `email_company_phone` varchar(200) NOT NULL,
  `email_company_fax` varchar(200) NOT NULL,
  `email_company_email` varchar(200) NOT NULL,
  `email_company_website` varchar(200) NOT NULL,
  `email_company_facebook` varchar(200) NOT NULL,
  `email_company_twitter` varchar(200) NOT NULL,
  `email_company_linkedin` varchar(200) NOT NULL,
  `email_company_googleplus` varchar(200) NOT NULL,
  `email_company_youtube` varchar(200) NOT NULL,
  `email_company_instagram` varchar(200) NOT NULL,
  `email_company_text` text NOT NULL,
  `email_company_login_button` int(11) NOT NULL,
  `email_company_background_colour` varchar(20) NOT NULL,
  `email_company_font_colour` varchar(20) NOT NULL,
  `email_company_font_type` varchar(100) NOT NULL,
  UNIQUE KEY `company_profile_id` (`company_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_profile_email_template`
--

INSERT INTO `company_profile_email_template` (`company_profile_id`, `email_company_name`, `email_company_address`, `email_company_suburb`, `email_company_state`, `email_company_postcode`, `email_company_country`, `email_company_phone`, `email_company_fax`, `email_company_email`, `email_company_website`, `email_company_facebook`, `email_company_twitter`, `email_company_linkedin`, `email_company_googleplus`, `email_company_youtube`, `email_company_instagram`, `email_company_text`, `email_company_login_button`, `email_company_background_colour`, `email_company_font_colour`, `email_company_font_type`) VALUES
(1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'The information contained in this e-mail message and any accompanying files are or may be confidential. It is for the sole use of the intended recipient. If you are not the intended recipient, any use, dissemination,  reliance, forwarding, printing or copying of this e-mail or any attached files is unauthorised. If you have received this e-mail in error, please advise our office by return e-mail, or telephone and delete all copies. ', 0, '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
