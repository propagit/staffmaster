-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 28, 2014 at 04:02 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `staff_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `upload_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uploaded_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `full_path` varchar(255) NOT NULL,
  `raw_name` varchar(255) NOT NULL,
  `orig_name` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `file_ext` varchar(10) NOT NULL,
  `file_size` decimal(10,2) NOT NULL,
  `is_image` tinyint(4) NOT NULL,
  `image_width` int(11) NOT NULL,
  `image_height` int(11) NOT NULL,
  `image_type` varchar(10) NOT NULL,
  `image_size_str` varchar(255) NOT NULL,
  PRIMARY KEY (`upload_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`upload_id`, `uploaded_on`, `status`, `file_name`, `file_type`, `file_path`, `full_path`, `raw_name`, `orig_name`, `client_name`, `file_ext`, `file_size`, `is_image`, `image_width`, `image_height`, `image_type`, `image_size_str`) VALUES
(1, '2014-03-28 00:41:59', 0, 'Screen_Shot_2014-03-28_at_11.41_.50_am_.png', 'image/png', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/Screen_Shot_2014-03-28_at_11.41_.50_am_.png', 'Screen_Shot_2014-03-28_at_11.41_.50_am_', 'Screen_Shot_2014-03-28_at_11.41_.50_am_.png', 'Screen Shot 2014-03-28 at 11.41_.50 am_.png', '.png', 195.02, 1, 1094, 562, 'png', 'width="1094" height="562"'),
(2, '2014-03-28 00:48:21', 0, 'staff_1395818951.csv', 'text/plain', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/staff_1395818951.csv', 'staff_1395818951', 'staff_1395818951.csv', 'staff_1395818951.csv', '.csv', 4.97, 0, 0, 0, '', ''),
(3, '2014-03-28 01:56:48', 0, 'staff_1395963069.csv', 'text/plain', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/staff_1395963069.csv', 'staff_1395963069', 'staff_1395963069.csv', 'staff_1395963069.csv', '.csv', 4.97, 0, 0, 0, '', ''),
(4, '2014-03-28 02:05:00', 0, 'staff_1395972284.csv', 'text/plain', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/staff_1395972284.csv', 'staff_1395972284', 'staff_1395972284.csv', 'staff_1395972284.csv', '.csv', 4.73, 0, 0, 0, '', ''),
(5, '2014-03-28 03:42:47', 0, 'staff_1395973300.csv', 'text/plain', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/staff_1395973300.csv', 'staff_1395973300', 'staff_1395973300.csv', 'staff_1395973300.csv', '.csv', 4.74, 0, 0, 0, '', ''),
(6, '2014-03-28 03:43:47', 0, 'staff_13959733001.csv', 'text/plain', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/staff_13959733001.csv', 'staff_13959733001', 'staff_1395973300.csv', 'staff_1395973300.csv', '.csv', 3.51, 0, 0, 0, '', ''),
(7, '2014-03-28 04:33:24', 0, 'staff_13959733002.csv', 'text/plain', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/staff_13959733002.csv', 'staff_13959733002', 'staff_1395973300.csv', 'staff_1395973300.csv', '.csv', 3.51, 0, 0, 0, '', ''),
(8, '2014-03-28 04:37:42', 0, 'staff_1395981398.csv', 'text/plain', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/staff_1395981398.csv', 'staff_1395981398', 'staff_1395981398.csv', 'staff_1395981398.csv', '.csv', 3.54, 0, 0, 0, '', ''),
(9, '2014-03-28 04:54:58', 0, 'staff_13959813981.csv', 'text/plain', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/staff_13959813981.csv', 'staff_13959813981', 'staff_1395981398.csv', 'staff_1395981398.csv', '.csv', 3.54, 0, 0, 0, '', ''),
(10, '2014-03-28 04:56:40', 0, 'staff_1395982587.csv', 'text/plain', '/Users/namnguyen/Sites/vsm/uploads/import/', '/Users/namnguyen/Sites/vsm/uploads/import/staff_1395982587.csv', 'staff_1395982587', 'staff_1395982587.csv', 'staff_1395982587.csv', '.csv', 4.79, 0, 0, 0, '', '');
