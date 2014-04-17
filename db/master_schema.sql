-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Apr 16, 2014 at 01:15 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `smcloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '0: pending, 1: confirmed/activated, -1: deactivated, -2: banned',
  `credits` bigint(20) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `subdomain` varchar(50) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `activation_code` varchar(40) NOT NULL,
  `activated_on` datetime NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `username` (`subdomain`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`price_id`, `min`, `max`, `unit_price`) VALUES
(1, 0, 250, 1.50),
(2, 251, 500, 1.25),
(3, 501, 1000, 1.00),
(4, 1001, 2500, 0.85),
(5, 2501, 5000, 0.75);
