-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2014 at 01:59 AM
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
  UNIQUE KEY `company_profile_id` (`company_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
