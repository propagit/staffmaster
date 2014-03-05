-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 04, 2014 at 11:42 PM
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
-- Table structure for table `attribute_locations`
--

CREATE TABLE IF NOT EXISTS `attribute_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `attribute_locations`
--

INSERT INTO `attribute_locations` (`location_id`, `parent_id`, `name`, `state`) VALUES
(1, 0, 'Major Cities', ''),
(2, 0, 'Regional', ''),
(3, 1, 'Sydney', 'NSW'),
(4, 1, 'Melbourne', 'VIC'),
(5, 1, 'Brisbane', 'QLD'),
(6, 1, 'Gold Coast', 'QLD'),
(7, 1, 'Perth', 'WA'),
(8, 1, 'Adelaide', 'SA'),
(9, 1, 'Hobart', 'TAS'),
(10, 1, 'Darwin', 'NT'),
(11, 1, 'Canberra', 'ACT'),
(12, 2, 'NSW', 'NSW'),
(13, 2, 'VIC', 'VIC'),
(14, 2, 'QLD', 'QLD'),
(15, 2, 'WA', 'WA'),
(16, 2, 'SA', 'SA'),
(17, 2, 'TAS', 'TAS'),
(18, 2, 'ACT', 'ACT'),
(19, 2, 'NT', 'NT'),
(20, 3, 'CBD, Inner West & Eastern Suburbs', 'NSW'),
(21, 3, 'North Shore & Northen Beaches', 'NSW'),
(22, 3, 'North West & Hills District', 'NSW'),
(23, 3, 'Parramatta & Western Suburbs', 'NSW'),
(24, 3, 'Ryde & Macquarie Park', 'NSW'),
(25, 3, 'Southern Suburbs & Sutherland Shire', 'NSW'),
(26, 3, 'South West & M5 Corridor', 'NSW'),
(27, 4, 'CBD & Inner Suburbs', 'VIC'),
(28, 4, 'Bayside & South Eastern Suburbs', 'VIC'),
(29, 4, 'Eastern Suburbs', 'VIC'),
(30, 4, 'Northern Suburbs', 'VIC'),
(31, 4, 'Western Suburbs', 'VIC'),
(32, 5, 'CBD & Inner Suburbs', 'QLD'),
(33, 5, 'Bayside & Eastern Suburbs', 'QLD'),
(34, 5, 'Northern Suburbs', 'QLD'),
(35, 5, 'Southern Suburbs & Logan', 'QLD'),
(36, 5, 'Western Suburbs & Ipswich', 'QLD'),
(37, 7, 'CBD, Inner & Western Suburbs', 'WA'),
(38, 7, 'Eastern Suburbs', 'WA'),
(39, 7, 'Fremantle & Southern Suburbs', 'WA'),
(40, 7, 'Northern Suburbs & Joondalup', 'WA'),
(41, 7, 'Rockingham & Kwinana', 'WA'),
(42, 12, 'Albury Wodonga & Murray', 'NSW'),
(43, 12, 'Blue Mountains & Central West', 'NSW'),
(44, 12, 'Coffs Harbour & North Coast', 'NSW'),
(45, 12, 'Dubbo & Central NSW', 'NSW'),
(46, 12, 'Far West & North Central NSW', 'NSW'),
(47, 12, 'Gosford & Central Coast', 'NSW'),
(48, 12, 'Goulburn & Southern Tablelands', 'NSW'),
(49, 12, 'Lismore & Far North Coast', 'NSW'),
(50, 12, 'Newcastle, Maitland & Hunter', 'NSW'),
(51, 12, 'Port Macquarie & Mid North Coast', 'NSW'),
(52, 12, 'Richmond & Hawkesbury', 'NSW'),
(53, 12, 'Tamworth & North West NSW', 'NSW'),
(54, 12, 'Tumut, Southern Highlands & Snowy', 'NSW'),
(55, 12, 'Wagga Wagga & Riverina', 'NSW'),
(56, 12, 'Wollongong, Illawarra & South Coast', 'NSW'),
(57, 13, 'Bairnsdale & Gippsland', 'VIC'),
(58, 13, 'Ballarat & Central Highlands', 'VIC'),
(59, 13, 'Bendigo, Goldfields & Macedon Ranges', 'VIC'),
(60, 13, 'Geelong & Great Ocean Road', 'VIC'),
(61, 13, 'Horsham & Grampians', 'VIC'),
(62, 13, 'Mildura & Murray', 'VIC'),
(63, 13, 'Mornington Peninsula & Bass Coast', 'VIC'),
(64, 13, 'Shepparton & Goulburn Valley', 'VIC'),
(65, 13, 'Traralgon & La Trobe Valley', 'VIC'),
(66, 13, 'Yarra Valley & High Country', 'VIC'),
(67, 14, 'Bundaberg & Wide Bay Burnett', 'QLD'),
(68, 14, 'Cairns & Far North', 'QLD'),
(69, 14, 'Gladstone & Central QLD', 'QLD'),
(70, 14, 'Hervey Bay & Fraser Coast', 'QLD'),
(71, 14, 'Mackay & Coalfields', 'QLD'),
(72, 14, 'Mt lsa & Western QLD', 'QLD'),
(73, 14, 'Rockhampton & Capricorn Coast', 'QLD'),
(74, 14, 'Somerset & Lockery', 'QLD'),
(75, 14, 'Sunshine Coast', 'QLD'),
(76, 14, 'Toowoomba & Darling Downs', 'QLD'),
(77, 14, 'Townsville & Northern QLD', 'QLD'),
(78, 15, 'Albany & Great Southern', 'WA'),
(79, 15, 'Broome & Kimberley', 'WA'),
(80, 15, 'Bunbury & South West', 'WA'),
(81, 15, 'Geraldton, Gascoyne & Midwest', 'WA'),
(82, 15, 'Kalgoorlie, Goldfields & Esperance', 'WA'),
(83, 15, 'Mandurah & Peel', 'WA'),
(84, 15, 'Northam & Wheatbelt', 'WA'),
(85, 15, 'Port Hedland, Karratha & Pilbara', 'WA'),
(86, 16, 'Adelaide Hills & Barossa', 'SA'),
(87, 16, 'Coober Pedy & Outback SA', 'SA'),
(88, 16, 'Fleurieu Peninsula & Kangaroo Island', 'SA'),
(89, 16, 'Mt Gambier & Limestone Coast', 'SA'),
(90, 16, 'Riverland & Murray Mallee', 'SA'),
(91, 16, 'Whyalla & Eyre Peninsula', 'SA'),
(92, 16, 'Yorke Peninsula & Clare Valley', 'SA'),
(93, 17, 'Central & South East', 'TAS'),
(94, 17, 'Davonport & North West', 'TAS'),
(95, 17, 'Launceston & North East', 'TAS'),
(96, 19, 'Alice Springs & Central Australia', 'NT'),
(97, 19, 'Katherine & Northern Australia', 'NT');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
