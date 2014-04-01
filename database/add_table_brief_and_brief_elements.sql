-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2014 at 06:43 AM
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
-- Table structure for table `brief`
--

CREATE TABLE IF NOT EXISTS `brief` (
  `brief_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`brief_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `brief`
--

INSERT INTO `brief` (`brief_id`, `name`, `created`) VALUES
(1, 'NA', '2014-04-01 06:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `brief_elements`
--

CREATE TABLE IF NOT EXISTS `brief_elements` (
  `brief_element_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brief_id` bigint(20) NOT NULL,
  `element_type` varchar(255) NOT NULL COMMENT 'html element type such as text for header, textarea for description, radio etc',
  `element_content` text NOT NULL COMMENT 'if the element is a radio or checkbox then store the data in json format similar to attributes in custom_forms table ',
  `element_order` int(11) NOT NULL DEFAULT '0' COMMENT 'order of the elements',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`brief_element_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `brief_elements`
--

INSERT INTO `brief_elements` (`brief_element_id`, `brief_id`, `element_type`, `element_content`, `element_order`, `created`, `modified`) VALUES
(1, 1, 'header', 'This is a header example, just text with no tracking', 0, '2014-04-01 06:32:42', '0000-00-00 00:00:00'),
(2, 1, 'desc-text', '<p>This is descriptive text and like the header is just text. The descriptive text is used to explain some plain text comments on the brief. It has no tracking parameters and is simply for adding text to the brief. The below is a download and we should track who has downloaded it.</p>\r\n', 1, '2014-04-01 06:34:19', '0000-00-00 00:00:00'),
(3, 1, 'document', 'sm-to-do-list.docx', 2, '2014-04-01 06:35:03', '0000-00-00 00:00:00'),
(4, 1, 'desc-text', '<p>Below is an example of a request file upload on a brief. It is desgined to ask staff to upload a file such as a picture from a shift. Should be able to track which staff have uploaded a file. Ideally they can review all the images/files uploaded so they can download and send to client or else where.</p>\r\n', 3, '2014-04-01 06:36:29', '0000-00-00 00:00:00'),
(5, 1, 'image', 'women-people-faces-27507.jpg', 4, '2014-04-01 06:37:06', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
