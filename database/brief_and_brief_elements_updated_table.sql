-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2014 at 06:47 AM
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
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 inactive, 1 active',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`brief_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `brief`
--

INSERT INTO `brief` (`brief_id`, `name`, `status`, `created`, `modified`) VALUES
(1, 'Example Brief', 0, '2014-04-02 06:44:23', '2014-04-02 05:24:54'),
(4, 'Melbourne Cup Shift Brief', 1, '2014-04-02 06:44:56', '2014-04-02 05:33:31');

-- --------------------------------------------------------

--
-- Table structure for table `brief_elements`
--

CREATE TABLE IF NOT EXISTS `brief_elements` (
  `brief_element_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brief_id` bigint(20) NOT NULL,
  `element_type` varchar(255) NOT NULL COMMENT 'html element type such as text for header, textarea for description, radio etc',
  `element_content` text NOT NULL COMMENT 'if the element is a radio or checkbox then store the data in json format similar to attributes in custom_forms table ',
  `document_name` varchar(255) NOT NULL COMMENT 'name of the document entered by user and not the file name',
  `element_order` int(11) NOT NULL DEFAULT '0' COMMENT 'order of the elements',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`brief_element_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `brief_elements`
--

INSERT INTO `brief_elements` (`brief_element_id`, `brief_id`, `element_type`, `element_content`, `document_name`, `element_order`, `created`, `modified`) VALUES
(1, 1, 'header', 'This is a header example, just text with no tracking', '', 0, '2014-04-01 06:32:42', '0000-00-00 00:00:00'),
(2, 1, 'desc-text', '<p>This is descriptive text and like the header is just text. The descriptive text is used to explain some plain text comments on the brief. It has no tracking parameters and is simply for adding text to the brief. The below is a download and we should track who has downloaded it.</p>\r\n', '', 1, '2014-04-01 06:34:19', '0000-00-00 00:00:00'),
(3, 1, 'document', 'sm-to-do-list.docx', 'Staff Master to do list', 2, '2014-04-02 03:57:02', '0000-00-00 00:00:00'),
(4, 1, 'desc-text', '<p>Below is an example of a request file upload on a brief. It is desgined to ask staff to upload a file such as a picture from a shift. Should be able to track which staff have uploaded a file. Ideally they can review all the images/files uploaded so they can download and send to client or else where.</p>\r\n', '', 3, '2014-04-01 06:36:29', '0000-00-00 00:00:00'),
(5, 1, 'image', 'women-people-faces-27507.jpg', 'Supervisor', 4, '2014-04-02 03:57:31', '0000-00-00 00:00:00'),
(6, 1, 'document', 'invoice_5.pdf', 'Invoice Format', 5, '2014-04-02 03:59:00', '0000-00-00 00:00:00'),
(7, 4, 'header', 'This is a header example, just text with no tracking', '', 6, '2014-04-02 05:22:26', '0000-00-00 00:00:00'),
(8, 4, 'desc-text', '<p><span style="font-family:lato,sans-serif; font-size:15px">This is descriptive text and like the header is just text. The descriptive text is used to explain some plain text comments on the brief. It has no tracking parameters and is simply for adding text to the brief. The below is a download and we should track who has downloaded it.</span></p>\r\n', '', 7, '2014-04-02 05:22:53', '0000-00-00 00:00:00'),
(9, 4, 'document', 'invoice_34.pdf', 'Uniform Requirements', 8, '2014-04-02 05:23:29', '0000-00-00 00:00:00'),
(10, 4, 'desc-text', '<p>Below is an example of a request file upload on a brief. It is desgined to ask staff to upload a file such as a picture from a shift. Should be able to track which staff have uploaded a file. Ideally they can review all the images/files uploaded so they can download and send to client or else where.</p>\r\n', '', 9, '2014-04-02 05:24:03', '0000-00-00 00:00:00'),
(11, 4, 'image', 'girl02.jpg', 'Supervisor', 10, '2014-04-02 05:24:32', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
