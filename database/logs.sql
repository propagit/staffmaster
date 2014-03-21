-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2014 at 06:04 PM
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
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `module` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `user_id`, `module`, `object`, `object_id`, `action`, `description`, `created_on`) VALUES
(2, 1, 'job', 'shift', 178, 'update', 'a:1:{s:7:"role_id";s:2:"14";}', '2014-03-21 00:45:08'),
(3, 1, 'job', 'shift', 178, 'update', 'a:1:{s:11:"finish_time";i:1395403200;}', '2014-03-21 00:45:16'),
(4, 1, 'job', 'shift', 186, 'create', '', '2014-03-21 01:35:27'),
(5, 1, 'job', 'shift', 89, 'delete', '', '2014-03-21 02:04:51'),
(6, 1, 'job', 'shift', 180, 'update', 'a:1:{s:8:"venue_id";s:1:"7";}', '2014-03-21 03:06:18'),
(7, 1, 'job', 'shift', 180, 'update', 'a:2:{s:8:"staff_id";s:2:"11";s:6:"status";s:1:"1";}', '2014-03-21 03:30:55'),
(9, 1, 'job', 'shift', 173, 'update', 'a:1:{s:10:"break_time";s:77:"[{"length":1800,"start_at":1395300600},{"length":1200,"start_at":1395306000}]";}', '2014-03-21 03:34:32'),
(10, 1, 'job', 'shift', 178, 'update', 'a:1:{s:10:"payrate_id";s:1:"2";}', '2014-03-21 03:40:25'),
(11, 1, 'job', 'shift', 178, 'update', 'a:1:{s:10:"uniform_id";s:1:"4";}', '2014-03-21 03:41:40'),
(12, 1, 'job', 'shift', 180, 'update', 'a:1:{s:13:"supervisor_id";s:2:"22";}', '2014-03-21 03:42:58'),
(13, 1, 'job', 'shift', 178, 'update', 'a:1:{s:8:"expenses";s:127:"a:1:{i:0;a:4:{s:11:"description";s:11:"Travel Cost";s:10:"staff_cost";s:2:"40";s:11:"client_cost";s:2:"70";s:3:"tax";s:1:"0";}}";}', '2014-03-21 03:44:22'),
(18, 1, 'staff', 'staff', 10, 'update', 'personal details', '2014-03-21 04:18:06'),
(19, 1, 'staff', 'staff', 10, 'update', 'super details', '2014-03-21 04:21:43'),
(20, 1, 'staff', 'staff', 38, 'create', '', '2014-03-21 04:22:48'),
(21, 1, 'staff', 'staff', 38, 'update', 'financial details', '2014-03-21 04:25:16'),
(22, 1, 'staff', 'staff', 38, 'delete', '', '2014-03-21 04:38:45'),
(23, 1, 'client', 'client', 39, 'create', '', '2014-03-21 04:59:40'),
(24, 1, 'client', 'client', 39, 'update', 'details', '2014-03-21 05:04:16'),
(25, 1, 'client', 'client', 39, 'update', 'departments', '2014-03-21 05:09:33'),
(26, 1, 'client', 'client', 39, 'delete', '', '2014-03-21 05:12:47'),
(27, 1, 'job', 'shift', 187, 'create', '', '2014-03-21 05:13:58'),
(28, 1, 'job', 'shift', 188, 'create', '', '2014-03-21 05:29:11'),
(29, 1, 'job', 'shift', 189, 'create', '', '2014-03-21 05:29:11'),
(30, 1, 'job', 'shift', 190, 'create', '', '2014-03-21 05:29:11'),
(31, 1, 'job', 'shift', 191, 'create', '', '2014-03-21 05:29:11'),
(32, 1, 'job', 'shift', 192, 'create', '', '2014-03-21 05:29:11'),
(33, 1, 'job', 'shift', 193, 'create', '', '2014-03-21 05:29:11'),
(34, 1, 'job', 'shift', 194, 'create', '', '2014-03-21 05:29:11'),
(35, 1, 'job', 'shift', 195, 'create', '', '2014-03-21 05:29:11'),
(36, 1, 'job', 'shift', 196, 'create', '', '2014-03-21 05:29:11'),
(37, 1, 'job', 'shift', 197, 'create', '', '2014-03-21 05:29:11'),
(38, 1, 'job', 'shift', 198, 'create', '', '2014-03-21 05:29:11'),
(39, 1, 'job', 'shift', 199, 'create', '', '2014-03-21 05:29:11'),
(40, 1, 'job', 'shift', 200, 'create', '', '2014-03-21 05:29:11'),
(41, 1, 'job', 'shift', 201, 'create', '', '2014-03-21 05:29:11'),
(42, 1, 'job', 'shift', 202, 'create', '', '2014-03-21 05:29:11'),
(43, 1, 'job', 'shift', 203, 'create', '', '2014-03-21 05:29:11'),
(44, 1, 'job', 'shift', 204, 'create', '', '2014-03-21 05:29:11'),
(45, 1, 'job', 'shift', 205, 'create', '', '2014-03-21 05:29:11'),
(46, 1, 'job', 'shift', 206, 'create', '', '2014-03-21 05:29:11'),
(47, 1, 'job', 'shift', 207, 'create', '', '2014-03-21 05:29:11'),
(48, 1, 'job', 'shift', 188, 'delete', '', '2014-03-21 05:36:09'),
(49, 1, 'job', 'shift', 189, 'delete', '', '2014-03-21 05:36:09'),
(50, 1, 'job', 'shift', 190, 'update', 'a:1:{s:8:"venue_id";s:1:"3";}', '2014-03-21 06:44:16'),
(51, 1, 'job', 'shift', 191, 'update', 'a:1:{s:8:"venue_id";s:1:"3";}', '2014-03-21 06:44:16'),
(52, 1, 'job', 'shift', 192, 'update', 'a:1:{s:8:"venue_id";s:1:"9";}', '2014-03-21 06:44:45'),
(53, 1, 'job', 'shift', 193, 'update', 'a:1:{s:8:"venue_id";s:1:"9";}', '2014-03-21 06:44:45'),
(54, 1, 'job', 'shift', 194, 'update', 'a:1:{s:8:"venue_id";s:1:"9";}', '2014-03-21 06:44:45'),
(55, 1, 'job', 'shift', 195, 'update', 'a:1:{s:8:"venue_id";s:1:"9";}', '2014-03-21 06:44:45'),
(56, 1, 'job', 'shift', 187, 'update', 'a:1:{s:8:"venue_id";s:2:"10";}', '2014-03-21 06:45:47'),
(57, 1, 'job', 'shift', 190, 'update', 'a:1:{s:8:"venue_id";s:2:"10";}', '2014-03-21 06:45:47'),
(58, 1, 'job', 'shift', 191, 'update', 'a:1:{s:8:"venue_id";s:2:"10";}', '2014-03-21 06:45:47'),
(59, 1, 'job', 'shift', 190, 'update', 'a:1:{s:8:"venue_id";s:1:"7";}', '2014-03-21 06:49:52'),
(60, 1, 'job', 'shift', 191, 'update', 'a:1:{s:8:"venue_id";s:1:"7";}', '2014-03-21 06:49:52'),
(61, 1, 'job', 'shift', 190, 'update', 'a:1:{s:8:"venue_id";s:1:"5";}', '2014-03-21 06:52:45'),
(62, 1, 'job', 'shift', 191, 'update', 'a:1:{s:8:"venue_id";s:1:"5";}', '2014-03-21 06:52:45'),
(63, 1, 'job', 'shift', 190, 'update', 'a:1:{s:8:"venue_id";s:1:"6";}', '2014-03-21 06:55:32'),
(64, 1, 'job', 'shift', 191, 'update', 'a:1:{s:8:"venue_id";s:1:"6";}', '2014-03-21 06:55:32'),
(65, 1, 'job', 'shift', 192, 'update', 'a:1:{s:8:"venue_id";s:1:"6";}', '2014-03-21 06:55:32'),
(66, 1, 'job', 'shift', 193, 'update', 'a:1:{s:8:"venue_id";s:1:"6";}', '2014-03-21 06:55:32'),
(67, 1, 'job', 'shift', 194, 'update', 'a:1:{s:8:"venue_id";s:1:"6";}', '2014-03-21 06:55:32'),
(68, 1, 'job', 'shift', 190, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 06:58:10'),
(69, 1, 'job', 'shift', 191, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 06:58:10'),
(70, 1, 'job', 'shift', 192, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 06:58:10'),
(71, 1, 'job', 'shift', 193, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 06:58:10'),
(72, 1, 'job', 'shift', 194, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 06:58:10'),
(73, 1, 'job', 'shift', 190, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 07:01:54'),
(74, 1, 'job', 'shift', 191, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 07:01:54'),
(75, 1, 'job', 'shift', 192, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 07:01:54'),
(76, 1, 'job', 'shift', 193, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 07:01:54'),
(77, 1, 'job', 'shift', 194, 'update', 'a:1:{s:7:"role_id";N;}', '2014-03-21 07:01:54'),
(78, 1, 'job', 'shift', 190, 'update', 'a:1:{s:7:"role_id";s:2:"12";}', '2014-03-21 07:03:08'),
(79, 1, 'job', 'shift', 191, 'update', 'a:1:{s:7:"role_id";s:2:"12";}', '2014-03-21 07:03:08'),
(80, 1, 'job', 'shift', 192, 'update', 'a:1:{s:7:"role_id";s:2:"12";}', '2014-03-21 07:03:08'),
(81, 1, 'job', 'shift', 193, 'update', 'a:1:{s:7:"role_id";s:2:"12";}', '2014-03-21 07:03:08'),
(82, 1, 'job', 'shift', 194, 'update', 'a:1:{s:7:"role_id";s:2:"12";}', '2014-03-21 07:03:08');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
