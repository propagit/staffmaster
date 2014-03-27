-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2014 at 05:24 AM
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
