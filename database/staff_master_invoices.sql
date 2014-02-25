-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2014 at 06:17 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(100) NOT NULL,
  `po_number` varchar(100) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `jobs` text NOT NULL,
  `title` varchar(250) NOT NULL,
  `gst` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0: created, 1: paid',
  `breakdown` tinyint(4) NOT NULL,
  `issued_date` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `invoice_number`, `po_number`, `client_id`, `jobs`, `title`, `gst`, `total_amount`, `status`, `breakdown`, `issued_date`, `due_date`, `created_on`) VALUES
(7, '', '', 33, 'a:1:{i:0;a:2:{s:5:"value";s:1:"8";s:5:"label";s:11:"new awesome";}}', 'Services Rended', 90.91, 1000.00, 0, 0, '2014-02-25 00:00:00', '0000-00-00 00:00:00', '2014-02-25 06:05:28'),
(10, '', '', 31, 'a:2:{i:0;a:2:{s:5:"value";s:1:"6";s:5:"label";s:14:"First test job";}i:1;a:2:{s:5:"value";s:1:"7";s:5:"label";s:11:"Awesoem job";}}', 'Services Rended', 602.27, 6625.00, 0, 0, '2014-02-25 00:00:00', '0000-00-00 00:00:00', '2014-02-25 06:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) NOT NULL,
  `job_id` bigint(20) NOT NULL,
  `include_timesheets` tinyint(4) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `tax` int(11) NOT NULL COMMENT '0: no, 1: yes, 2: tax free',
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`item_id`, `invoice_id`, `job_id`, `include_timesheets`, `title`, `tax`, `amount`) VALUES
(12, 7, 8, 1, 'new awesome', 1, 1000.00),
(16, 10, 6, 1, 'First test job', 1, 1550.00),
(17, 10, 7, 1, 'Awesoem job', 1, 5075.00);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
