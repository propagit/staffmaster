-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2014 at 11:56 PM
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
-- Table structure for table `system_styles`
--

CREATE TABLE IF NOT EXISTS `system_styles` (
  `style_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `primary_colour` varchar(16) NOT NULL,
  `rollover_colour` varchar(16) NOT NULL,
  `secondary_colour` varchar(16) NOT NULL,
  `text_colour` varchar(16) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`style_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `system_styles`
--

INSERT INTO `system_styles` (`style_id`, `primary_colour`, `rollover_colour`, `secondary_colour`, `text_colour`, `modified`) VALUES
(1, '#00b1eb', '#2a6496', '#ffffff', '#3d3d3d', '2014-04-11 07:46:58');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
