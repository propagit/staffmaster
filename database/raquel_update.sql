-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2014 at 07:55 AM
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
-- Table structure for table `company_profile`
--

CREATE TABLE IF NOT EXISTS `company_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(250) NOT NULL,
  `company_address` varchar(200) NOT NULL,
  `company_suburb` varchar(100) NOT NULL,
  `company_postcode` varchar(20) NOT NULL,
  `company_state` varchar(100) NOT NULL,
  `company_country` varchar(100) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `company_website` varchar(100) NOT NULL,
  `company_phone` varchar(100) NOT NULL,
  `company_fax` varchar(50) NOT NULL,
  `company_abn` varchar(20) NOT NULL,
  `company_account_name` varchar(100) NOT NULL,
  `company_account_no` varchar(20) NOT NULL,
  `company_bsb` varchar(20) NOT NULL,
  `super_name` varchar(250) NOT NULL,
  `super_product_id` varchar(100) NOT NULL,
  `super_fund_phone` varchar(100) NOT NULL,
  `super_fund_website` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id`, `company_name`, `company_address`, `company_suburb`, `company_postcode`, `company_state`, `company_country`, `company_email`, `company_website`, `company_phone`, `company_fax`, `company_abn`, `company_account_name`, `company_account_no`, `company_bsb`, `super_name`, `super_product_id`, `super_fund_phone`, `super_fund_website`) VALUES
(1, 'Staff Master', '', '', '', '', '', '', '', '', '', '', '', '', '', 'HOST Plus', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
