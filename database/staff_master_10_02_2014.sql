-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 10, 2014 at 07:04 PM
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
-- Table structure for table `attribute_availability`
--

CREATE TABLE `attribute_availability` (
  `availability_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`availability_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_groups`
--

CREATE TABLE `attribute_groups` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_locations`
--

CREATE TABLE `attribute_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `attribute_locations`
--

INSERT INTO `attribute_locations` (`location_id`, `parent_id`, `name`) VALUES
(1, 0, 'Major Cities'),
(2, 0, 'Regional'),
(3, 1, 'Sydney'),
(4, 1, 'Melbourne'),
(5, 1, 'Brisbane'),
(6, 1, 'Gold Coast'),
(7, 1, 'Perth'),
(8, 1, 'Adelaide'),
(9, 1, 'Hobart'),
(10, 1, 'Darwin'),
(11, 1, 'Canberra'),
(12, 2, 'NSW'),
(13, 2, 'VIC'),
(14, 2, 'QLD'),
(15, 2, 'WA'),
(16, 2, 'SA'),
(17, 2, 'TAS'),
(18, 2, 'ACT'),
(19, 2, 'NT'),
(20, 3, 'CBD, Inner West & Eastern Suburbs'),
(21, 3, 'North Shore & Northen Beaches'),
(22, 3, 'North West & Hills District'),
(23, 3, 'Parramatta & Western Suburbs'),
(24, 3, 'Ryde & Macquarie Park'),
(25, 3, 'Southern Suburbs & Sutherland Shire'),
(26, 3, 'South West & M5 Corridor'),
(27, 4, 'CBD & Inner Suburbs'),
(28, 4, 'Bayside & South Eastern Suburbs'),
(29, 4, 'Eastern Suburbs'),
(30, 4, 'Northern Suburbs'),
(31, 4, 'Western Suburbs'),
(32, 5, 'CBD & Inner Suburbs'),
(33, 5, 'Bayside & Eastern Suburbs'),
(34, 5, 'Northern Suburbs'),
(35, 5, 'Southern Suburbs & Logan'),
(36, 5, 'Western Suburbs & Ipswich'),
(37, 7, 'CBD, Inner & Western Suburbs'),
(38, 7, 'Eastern Suburbs'),
(39, 7, 'Fremantle & Southern Suburbs'),
(40, 7, 'Northern Suburbs & Joondalup'),
(41, 7, 'Rockingham & Kwinana'),
(42, 12, 'Albury Wodonga & Murray'),
(43, 12, 'Blue Mountains & Central West'),
(44, 12, 'Coffs Harbour & North Coast'),
(45, 12, 'Dubbo & Central NSW'),
(46, 12, 'Far West & North Central NSW'),
(47, 12, 'Gosford & Central Coast'),
(48, 12, 'Goulburn & Southern Tablelands'),
(49, 12, 'Lismore & Far North Coast'),
(50, 12, 'Newcastle, Maitland & Hunter'),
(51, 12, 'Port Macquarie & Mid North Coast'),
(52, 12, 'Richmond & Hawkesbury'),
(53, 12, 'Tamworth & North West NSW'),
(54, 12, 'Tumut, Southern Highlands & Snowy'),
(55, 12, 'Wagga Wagga & Riverina'),
(56, 12, 'Wollongong, Illawarra & South Coast'),
(57, 13, 'Bairnsdale & Gippsland'),
(58, 13, 'Ballarat & Central Highlands'),
(59, 13, 'Bendigo, Goldfields & Macedon Ranges'),
(60, 13, 'Geelong & Great Ocean Road'),
(61, 13, 'Horsham & Grampians'),
(62, 13, 'Mildura & Murray'),
(63, 13, 'Mornington Peninsula & Bass Coast'),
(64, 13, 'Shepparton & Goulburn Valley'),
(65, 13, 'Traralgon & La Trobe Valley'),
(66, 13, 'Yarra Valley & High Country'),
(67, 14, 'Bundaberg & Wide Bay Burnett'),
(68, 14, 'Cairns & Far North'),
(69, 14, 'Gladstone & Central QLD'),
(70, 14, 'Hervey Bay & Fraser Coast'),
(71, 14, 'Mackay & Coalfields'),
(72, 14, 'Mt lsa & Western QLD'),
(73, 14, 'Rockhampton & Capricorn Coast'),
(74, 14, 'Somerset & Lockery'),
(75, 14, 'Sunshine Coast'),
(76, 14, 'Toowoomba & Darling Downs'),
(77, 14, 'Townsville & Northern QLD'),
(78, 15, 'Albany & Great Southern'),
(79, 15, 'Broome & Kimberley'),
(80, 15, 'Bunbury & South West'),
(81, 15, 'Geraldton, Gascoyne & Midwest'),
(82, 15, 'Kalgoorlie, Goldfields & Esperance'),
(83, 15, 'Mandurah & Peel'),
(84, 15, 'Northam & Wheatbelt'),
(85, 15, 'Port Hedland, Karratha & Pilbara'),
(86, 16, 'Adelaide Hills & Barossa'),
(87, 16, 'Coober Pedy & Outback SA'),
(88, 16, 'Fleurieu Peninsula & Kangaroo Island'),
(89, 16, 'Mt Gambier & Limestone Coast'),
(90, 16, 'Riverland & Murray Mallee'),
(91, 16, 'Whyalla & Eyre Peninsula'),
(92, 16, 'Yorke Peninsula & Clare Valley'),
(93, 17, 'Central & South East'),
(94, 17, 'Davonport & North West'),
(95, 17, 'Launceston & North East'),
(96, 19, 'Alice Springs & Central Australia'),
(97, 19, 'Katherine & Northern Australia');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_payrates`
--

CREATE TABLE `attribute_payrates` (
  `payrate_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `staff_rate` decimal(10,2) NOT NULL,
  `client_rate` decimal(10,2) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `hour_payrate` longtext NOT NULL,
  PRIMARY KEY (`payrate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_roles`
--

CREATE TABLE `attribute_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `attribute_roles`
--

INSERT INTO `attribute_roles` (`role_id`, `name`) VALUES
(1, 'RACA Level A Training'),
(4, 'RACA Level B Training'),
(5, 'Armed Guard'),
(6, 'Junior Guard'),
(7, 'Intermediate Guard'),
(8, 'Advanced Guard'),
(9, 'RACA Level C Training'),
(10, 'Close Personal Protection'),
(11, 'Communication Specialist'),
(12, 'Patrol Driver'),
(13, 'Certificate III Security Operations'),
(14, 'Task Manager');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_uniforms`
--

CREATE TABLE `attribute_uniforms` (
  `uniform_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`uniform_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `attribute_uniforms`
--

INSERT INTO `attribute_uniforms` (`uniform_id`, `name`) VALUES
(1, 'Stand Issue Uniform'),
(2, 'Standard Black Uniform'),
(3, 'Uniform NOT Required'),
(4, 'Formal Suite'),
(5, 'Stand Issue & Hand Gun '),
(6, 'Stand Issue & Pistol Belt'),
(7, 'Casual Attire');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_venues`
--

CREATE TABLE `attribute_venues` (
  `venue_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(100) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  PRIMARY KEY (`venue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=238 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `code`, `name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'AS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua And Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia And Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'BN', 'Brunei Darussalam'),
(32, 'BG', 'Bulgaria'),
(33, 'BF', 'Burkina Faso'),
(34, 'BI', 'Burundi'),
(35, 'KH', 'Cambodia'),
(36, 'CM', 'Cameroon'),
(37, 'CA', 'Canada'),
(38, 'CV', 'Cape Verde'),
(39, 'KY', 'Cayman Islands'),
(40, 'CF', 'Central African Republic'),
(41, 'TD', 'Chad'),
(42, 'CL', 'Chile'),
(43, 'CN', 'China'),
(44, 'CX', 'Christmas Island'),
(45, 'CC', 'Cocos (Keeling) Islands'),
(46, 'CO', 'Colombia'),
(47, 'KM', 'Comoros'),
(48, 'CG', 'Congo'),
(49, 'CD', 'Congo, The Dem. Rep. Of'),
(50, 'CK', 'Cook Islands'),
(51, 'CR', 'Costa Rica'),
(52, 'CI', 'Cote D''Ivoire'),
(53, 'HR', 'Croatia'),
(54, 'CU', 'Cuba'),
(55, 'CY', 'Cyprus'),
(56, 'CZ', 'Czech Republic'),
(57, 'DK', 'Denmark'),
(58, 'DJ', 'Djibouti'),
(59, 'DM', 'Dominica'),
(60, 'DO', 'Dominican Republic'),
(61, 'EC', 'Ecuador'),
(62, 'EG', 'Egypt'),
(63, 'SV', 'El Salvador'),
(64, 'GQ', 'Equatorial Guinea'),
(65, 'ER', 'Eritrea'),
(66, 'EE', 'Estonia'),
(67, 'ET', 'Ethiopia'),
(68, 'FK', 'Falkland Islands'),
(69, 'FO', 'Faroe Islands'),
(70, 'FJ', 'Fiji'),
(71, 'FI', 'Finland'),
(72, 'FR', 'France'),
(73, 'GF', 'French Guiana'),
(74, 'PF', 'French Polynesia'),
(75, 'TF', 'French Southern Territories'),
(76, 'GA', 'Gabon'),
(77, 'GM', 'Gambia'),
(78, 'GE', 'Georgia'),
(79, 'DE', 'Germany'),
(80, 'GH', 'Ghana'),
(81, 'GI', 'Gibraltar'),
(82, 'GR', 'Greece'),
(83, 'GL', 'Greenland'),
(84, 'GD', 'Grenada'),
(85, 'GP', 'Guadeloupe'),
(86, 'GU', 'Guam'),
(87, 'GT', 'Guatemala'),
(88, 'Gg', 'Guernsey'),
(89, 'GN', 'Guinea'),
(90, 'GW', 'Guinea-Bissau'),
(91, 'GY', 'Guyana'),
(92, 'HT', 'Haiti'),
(93, 'HN', 'Honduras'),
(94, 'HK', 'Hong Kong'),
(95, 'HU', 'Hungary'),
(96, 'IS', 'Iceland'),
(97, 'IN', 'India'),
(98, 'ID', 'Indonesia'),
(99, 'IR', 'Iran'),
(100, 'IQ', 'Iraq'),
(101, 'IE', 'Ireland'),
(102, 'IM', 'Isle Of Man'),
(103, 'IL', 'Israel'),
(104, 'IT', 'Italy'),
(105, 'JM', 'Jamaica'),
(106, 'JP', 'Japan'),
(107, 'JE', 'Jersey'),
(108, 'JO', 'Jordan'),
(109, 'KZ', 'Kazakhstan'),
(110, 'KE', 'Kenya'),
(111, 'KI', 'Kiribati'),
(112, 'KP', 'North Korea'),
(113, 'KR', 'South Korea'),
(114, 'KW', 'Kuwait'),
(115, 'KG', 'Kyrgyzstan'),
(116, 'LA', 'Laos'),
(117, 'LV', 'Latvia'),
(118, 'LB', 'Lebanon'),
(119, 'LS', 'Lesotho'),
(120, 'LR', 'Liberia'),
(121, 'LY', 'Libya'),
(122, 'LI', 'Liechtenstein'),
(123, 'LT', 'Lithuania'),
(124, 'LU', 'Luxembourg'),
(125, 'MO', 'Macao'),
(126, 'MK', 'Macedonia'),
(127, 'MG', 'Madagascar'),
(128, 'MW', 'Malawi'),
(129, 'MY', 'Malaysia'),
(130, 'MV', 'Maldives'),
(131, 'ML', 'Mali'),
(132, 'MT', 'Malta'),
(133, 'MH', 'Marshall Islands'),
(134, 'MQ', 'Martinique'),
(135, 'MR', 'Mauritania'),
(136, 'MU', 'Mauritius'),
(137, 'YT', 'Mayotte'),
(138, 'MX', 'Mexico'),
(139, 'FM', 'Micronesia'),
(140, 'MD', 'Moldova, Republic Of'),
(141, 'MC', 'Monaco'),
(142, 'MN', 'Mongolia'),
(143, 'MS', 'Montserrat'),
(144, 'MA', 'Morocco'),
(145, 'MZ', 'Mozambique'),
(146, 'MM', 'Myanmar'),
(147, 'NA', 'Namibia'),
(148, 'NR', 'Nauru'),
(149, 'NP', 'Nepal'),
(150, 'NL', 'Netherlands'),
(151, 'AN', 'Netherlands Antilles'),
(152, 'NC', 'New Caledonia'),
(153, 'NZ', 'New Zealand'),
(154, 'NI', 'Nicaragua'),
(155, 'NE', 'Niger'),
(156, 'NG', 'Nigeria'),
(157, 'NU', 'Niue'),
(158, 'NF', 'Norfolk Island'),
(159, 'MP', 'Northern Mariana Islands'),
(160, 'NO', 'Norway'),
(161, 'OM', 'Oman'),
(162, 'PK', 'Pakistan'),
(163, 'PW', 'Palau'),
(164, 'PS', 'Palestinian'),
(165, 'PA', 'Panama'),
(166, 'PG', 'Papua New Guinea'),
(167, 'PY', 'Paraguay'),
(168, 'PE', 'Peru'),
(169, 'PH', 'Philippines'),
(170, 'PN', 'Pitcairn'),
(171, 'PL', 'Poland'),
(172, 'PT', 'Portugal'),
(173, 'PR', 'Puerto Rico'),
(174, 'QA', 'Qatar'),
(175, 'RE', 'Reunion'),
(176, 'RO', 'Romania'),
(177, 'RU', 'Russian Federation'),
(178, 'RW', 'Rwanda'),
(179, 'SH', 'St. Helena'),
(180, 'KN', 'St. Kitts And Nevis'),
(181, 'LC', 'St. Lucia'),
(182, 'PM', 'St. Pierre And Miquelon'),
(183, 'VC', 'St. Vincent And Grenadines'),
(184, 'WS', 'Samoa'),
(185, 'SM', 'San Marino'),
(186, 'ST', 'Sao Tome And Principe'),
(187, 'SA', 'Saudi Arabia'),
(188, 'SN', 'Senegal'),
(189, 'CS', 'Serbia And Montenegro'),
(190, 'SC', 'Seychelles'),
(191, 'SL', 'Sierra Leone'),
(192, 'SG', 'Singapore'),
(193, 'SK', 'Slovakia'),
(194, 'SI', 'Slovenia'),
(195, 'SB', 'Solomon Islands'),
(196, 'SO', 'Somalia'),
(197, 'ZA', 'South Africa'),
(198, 'ES', 'Spain'),
(199, 'LK', 'Sri Lanka'),
(200, 'SD', 'Sudan'),
(201, 'SR', 'Suriname'),
(202, 'SJ', 'Svalbard And Jan Mayen'),
(203, 'SZ', 'Swaziland'),
(204, 'SE', 'Sweden'),
(205, 'CH', 'Switzerland'),
(206, 'SY', 'Syrian Arab Republic'),
(207, 'TW', 'Taiwan, Province Of China'),
(208, 'TJ', 'Tajikistan'),
(209, 'TZ', 'Tanzania'),
(210, 'TH', 'Thailand'),
(211, 'TL', 'Timor-Leste'),
(212, 'TG', 'Togo'),
(213, 'TK', 'Tokelau'),
(214, 'TO', 'Tonga'),
(215, 'TT', 'Trinidad And Tobago'),
(216, 'TN', 'Tunisia'),
(217, 'TR', 'Turkey'),
(218, 'TM', 'Turkmenistan'),
(219, 'TC', 'Turks And Caicos Islands'),
(220, 'TV', 'Tuvalu'),
(221, 'UG', 'Uganda'),
(222, 'UA', 'Ukraine'),
(223, 'AE', 'United Arab Emirates'),
(224, 'GB', 'United Kingdom'),
(225, 'US', 'United States'),
(226, 'UY', 'Uruguay'),
(227, 'UZ', 'Uzbekistan'),
(228, 'VU', 'Vanuatu'),
(229, 'VE', 'Venezuela'),
(230, 'VN', 'Viet Nam'),
(231, 'VG', 'Virgin Islands, British'),
(232, 'VI', 'Virgin Islands, U.S.'),
(233, 'WF', 'Wallis And Futuna'),
(234, 'EH', 'Western Sahara'),
(235, 'YE', 'Yemen'),
(236, 'ZM', 'Zambia'),
(237, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `custom_forms`
--

CREATE TABLE `custom_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `placeholder` varchar(255) NOT NULL,
  `inline_element` enum('yes','no','not applicable') NOT NULL DEFAULT 'not applicable',
  `multi_select` enum('yes','no','not applicable') NOT NULL DEFAULT 'not applicable',
  `attributes` text NOT NULL,
  `order` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'order of the form',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` bigint(20) NOT NULL,
  `finish_date` bigint(20) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_shifts`
--

CREATE TABLE `job_shifts` (
  `shift_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '-2: deleted, -1: rejected, 0: not assigned, 1: unconfirmed, 2: confirmed',
  `job_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL DEFAULT '0',
  `job_date` date NOT NULL,
  `start_time` bigint(20) NOT NULL,
  `finish_time` bigint(20) NOT NULL,
  `break_time` text NOT NULL,
  `venue_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `uniform_id` int(11) NOT NULL,
  `payrate_id` int(11) NOT NULL,
  `payrate_type` varchar(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_shift_staff_apply`
--

CREATE TABLE `job_shift_staff_apply` (
  `shift_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1: accept, -1: reject',
  `responsed_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `modules_functions`
--

CREATE TABLE `modules_functions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modules_mvc_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text NOT NULL,
  `params` text NOT NULL,
  `attributes` text NOT NULL,
  `code` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `modules_functions`
--

INSERT INTO `modules_functions` (`id`, `modules_mvc_id`, `name`, `access`, `description`, `comment`, `params`, `attributes`, `code`, `created`, `modified`) VALUES
(1, 1, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Account\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(2, 2, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Common\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(3, 3, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Common\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(4, 4, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Common\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(5, 5, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Common\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(6, 6, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Common\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(7, 6, 'build_payrate', 'public', 'This is a function to build the payrate table, to tune the speed of page loading', '', 'id', '[{"attr_name":"return","attr_desc":"     built table\\n\\t"}]', 'function build_payrate()\n	{\n		$id = $_POST[''id''];\n		$tbody = '''';\n		$payrate = $this->payrate_model->identify($id);\n		$def_staff = number_format($payrate[''staff_rate''],2,''.'','','');\n		$def_client = number_format($payrate[''client_rate''],2,''.'','','');\n		$hour_payrate = $payrate[''hour_payrate''];\n		$hp = json_decode($hour_payrate,TRUE);\n					$j = 0;\n					for($i=0;$i<24;$i++)\n					{\n						$ttl = '''';\n						if($i == 0)\n						{\n							$ttl = ''Midnight'';\n						}\n						else \n						{\n							if($i<12)\n							{\n								$ttl = $i.'':00 AM<br/>(''.$i.'':00)'';\n							}\n							else \n							{\n								if($i>12) {$j = $i-12;}\n								$ttl = $j.'':00 PM<br/>(''.$i.'':00)'';\n							}\n						}\n						\n						$mon_staff = $def_staff;\n						$tue_staff = $def_staff;\n						$wed_staff = $def_staff;\n						$thu_staff = $def_staff;\n						$fri_staff = $def_staff;\n						$sat_staff = $def_staff;\n						$sun_staff = $def_staff;\n						\n						$mon_client = $def_client;\n						$tue_client = $def_client;\n						$wed_client = $def_client;\n						$thu_client = $def_client;\n						$fri_client = $def_client;\n						$sat_client = $def_client;\n						$sun_client = $def_client;\n						\n						if($hour_payrate)\n						{\n							$mon_staff = $hp[''monday-''.$i.''-staff''];\n							$tue_staff = $hp[''tuesday-''.$i.''-staff''];\n							$wed_staff = $hp[''wednesday-''.$i.''-staff''];\n							$thu_staff = $hp[''thursday-''.$i.''-staff''];\n							$fri_staff = $hp[''friday-''.$i.''-staff''];\n							$sat_staff = $hp[''saturday-''.$i.''-staff''];\n							$sun_staff = $hp[''sunday-''.$i.''-staff''];\n							\n							$mon_client = $hp[''monday-''.$i.''-client''];\n							$tue_client = $hp[''tuesday-''.$i.''-client''];\n							$wed_client = $hp[''wednesday-''.$i.''-client''];\n							$thu_client = $hp[''thursday-''.$i.''-client''];\n							$fri_client = $hp[''friday-''.$i.''-client''];\n							$sat_client = $hp[''saturday-''.$i.''-client''];\n							$sun_client = $hp[''sunday-''.$i.''-client''];\n						}\n											\n						$tbody.=''\n						<tr >\n							<th>''.$ttl.''</th>\n							<td >\n								<div class="label-rate">Staff Rate</div>\n								<input type="text" class="input-rate staff" id="monday-''.$i.''-staff" name="monday-''.$i.''-staff" value="''.$mon_staff.''">\n								<div style="clear: both"></div>\n								<div class="label-rate">Client Rate</div>\n								<input type="text" class="input-rate client" id="monday-''.$i.''-client" name="monday-''.$i.''-client" value="''.$mon_client.''">\n								<div style="clear: both"></div>\n							</td>\n							<td >\n								<div class="label-rate">Staff Rate</div>\n								<input type="text" class="input-rate staff" id="tuesday-''.$i.''-staff" name="tuesday-''.$i.''-staff" value="''.$tue_staff.''">\n								<div style="clear: both"></div>\n								<div class="label-rate">Client Rate</div>\n								<input type="text" class="input-rate client" id="tuesday-''.$i.''-client" name="tuesday-''.$i.''-client" value="''.$tue_client.''">\n								<div style="clear: both"></div>\n							</td>\n							<td >\n								<div class="label-rate">Staff Rate</div>\n								<input type="text" class="input-rate staff" id="wednesday-''.$i.''-staff" name="wednesday-''.$i.''-staff" value="''.$wed_staff.''">\n								<div style="clear: both"></div>\n								<div class="label-rate">Client Rate</div>\n								<input type="text" class="input-rate client" id="wednesday-''.$i.''-client" name="wednesday-''.$i.''-client" value="''.$wed_client.''">\n								<div style="clear: both"></div>\n							</td>\n							<td >\n								<div class="label-rate">Staff Rate</div>\n								<input type="text" class="input-rate staff" id="thursday-''.$i.''-staff" name="thursday-''.$i.''-staff" value="''.$thu_staff.''">\n								<div style="clear: both"></div>\n								<div class="label-rate">Client Rate</div>\n								<input type="text" class="input-rate client" id="thursday-''.$i.''-client" name="thursday-''.$i.''-client" value="''.$thu_client.''">\n								<div style="clear: both"></div>\n							</td>\n							<td >\n								<div class="label-rate">Staff Rate</div>\n								<input type="text" class="input-rate staff" id="friday-''.$i.''-staff" name="friday-''.$i.''-staff" value="''.$fri_staff.''">\n								<div style="clear: both"></div>\n								<div class="label-rate">Client Rate</div>\n								<input type="text" class="input-rate client" id="friday-''.$i.''-client" name="friday-''.$i.''-client" value="''.$fri_client.''">\n								<div style="clear: both"></div>\n							</td>\n							<td >\n								<div class="label-rate">Staff Rate</div>\n								<input type="text" class="input-rate staff" id="saturday-''.$i.''-staff" name="saturday-''.$i.''-staff" value="''.$sat_staff.''">\n								<div style="clear: both"></div>\n								<div class="label-rate">Client Rate</div>\n								<input type="text" class="input-rate client" id="saturday-''.$i.''-client" name="saturday-''.$i.''-client" value="''.$sat_client.''">\n								<div style="clear: both"></div>\n							</td>\n							<td >\n								<div class="label-rate">Staff Rate</div>\n								<input type="text" class="input-rate staff" id="sunday-''.$i.''-staff" name="sunday-''.$i.''-staff" value="''.$sun_staff.''">\n								<div style="clear: both"></div>\n								<div class="label-rate">Client Rate</div>\n								<input type="text" class="input-rate client" id="sunday-''.$i.''-client" name="sunday-''.$i.''-client" value="''.$sun_client.''">\n								<div style="clear: both"></div>\n							</td>\n						</tr>'';\n					}\n		\n					\n		\n		\n		$text = ''\n		\n		<form method="post" action="''.base_url().''attribute/payrate/update_payrate" id="form-payrate-''.$payrate[''payrate_id''].''">\n  		<input type="hidden" name="id" value="''.$payrate[''payrate_id''].''">\n  		<div class="table-responsive selectable"  id="wrapper-table">\n			<table class="table">\n				<thead>\n					<tr>\n						<th style="width:12.5%">&nbsp;</th>\n						<th style="width:12.5%">Monday</th>\n						<th style="width:12.5%">Tuesday</th>\n						<th style="width:12.5%">Wednesday</th>\n						<th style="width:12.5%">Thursday</th>\n						<th style="width:12.5%">Friday</th>\n						<th style="width:12.5%">Saturday</th>\n						<th style="width:12.5%">Sunday</th>\n					</tr>\n				</thead>\n				<tbody >\n					''.$tbody.''\n				</tbody>\n			</table>\n		</div>\n		\n		</form>\n		\n		\n		\n		<script>', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(8, 6, 'update_payrate', 'public', 'This is a function to update a specific payrate based on the payrate ID', '', 'null', '[{"attr_name":"return","attr_desc":"     none\\n\\t"}]', 'function update_payrate()\n	{\n		//print_r($_POST);\n		$id = $_POST[''id''];\n		$hp = array();\n		for($i=0;$i<24;$i++)\n		{\n			$hp[''monday-''.$i.''-staff''] = $_POST[''monday-''.$i.''-staff''];\n			$hp[''tuesday-''.$i.''-staff''] = $_POST[''tuesday-''.$i.''-staff''];\n			$hp[''wednesday-''.$i.''-staff''] = $_POST[''wednesday-''.$i.''-staff''];\n			$hp[''thursday-''.$i.''-staff''] = $_POST[''thursday-''.$i.''-staff''];\n			$hp[''friday-''.$i.''-staff''] = $_POST[''friday-''.$i.''-staff''];\n			$hp[''saturday-''.$i.''-staff''] = $_POST[''saturday-''.$i.''-staff''];\n			$hp[''sunday-''.$i.''-staff''] = $_POST[''sunday-''.$i.''-staff''];\n			\n			$hp[''monday-''.$i.''-client''] = $_POST[''monday-''.$i.''-client''];\n			$hp[''tuesday-''.$i.''-client''] = $_POST[''tuesday-''.$i.''-client''];\n			$hp[''wednesday-''.$i.''-client''] = $_POST[''wednesday-''.$i.''-client''];\n			$hp[''thursday-''.$i.''-client''] = $_POST[''thursday-''.$i.''-client''];\n			$hp[''friday-''.$i.''-client''] = $_POST[''friday-''.$i.''-client''];\n			$hp[''saturday-''.$i.''-client''] = $_POST[''saturday-''.$i.''-client''];\n			$hp[''sunday-''.$i.''-client''] = $_POST[''sunday-''.$i.''-client''];\n		}\n		$data[''hour_payrate''] = json_encode($hp);\n		$this->payrate_model->update_payrate($id, $data);\n		$this->session->set_flashdata(''payrate_just_updated'',$id);\n		redirect(''attribute/payrate'');\n	}', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(9, 7, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Common\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(10, 8, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Common\\n "},{"attr_name":"author:","attr_desc":"  kaushtuv\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(11, 9, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Common\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(12, 10, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Common\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(13, 19, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Auth\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(14, 21, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Job\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(15, 23, 'rating', 'public', 'Show the rating input element', '', '$field_name, $field_value=null;', '[{"attr_name":"return","attr_desc":"     loads the rating select element\\t\\n\\t"}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(16, 23, 'dropdown_location', 'public', 'Show the location that only can be used in staff profile as we have multiselect element', '', '$field_name, $field_value=null; $field_name: name of that element such as location_id or id_location; $field_value: value if the location that need to show', '[{"attr_name":"return","attr_desc":"     loads the location select element\\t\\n\\t"}]', 'function dropdown_location($field_name, $field_value=null)\n	{\n\n		$data[''locations''] = $this->common_model->get_locations();\n		$data[''field_name''] = $field_name;\n		$data[''field_value''] = $field_value;\n		$this->load->view(''dropdown_location'', isset($data) ? $data : NULL);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(17, 23, 'dropdown_location_form', 'public', 'Show the location that can used in any forms that required location input. such as search staff form or add staff or add venue', '', '$field_name, $field_value=null; $field_name: name of that element such as location_id or id_location; $field_value: value if the location that need to show', '[{"attr_name":"return","attr_desc":"     loads the location select element\\t\\n\\t"}]', 'function dropdown_location_form($field_name, $field_value=null)\n	{\n		$data[''locations''] = $this->common_model->get_locations();\n		$data[''field_name''] = $field_name;\n		$data[''field_value''] = $field_value;\n		$this->load->view(''dropdown_location_form'', isset($data) ? $data : NULL);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(18, 25, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(19, 27, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(20, 28, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(21, 29, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(22, 30, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Dashboard_staff\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(23, 32, 'home', 'public', 'This is the landing page of the formbuiler module. This page provides the necessary UI to build custom forms for the user.', 'Build by taking reference from http://minikomi.github.io/Bootstrap-Form-Builder. However it should be noted that the similarity is only limited to the UI and the actual functions are custom build.', 'null', '[{"attr_name":"return","attr_desc":"\\t loads the view file home. which contains the UI elements to generate custom form elements.\\n\\t"},{"attr_name":"author","attr_desc":"\\t kaushtuv\\n\\t"}]', 'function home()\n	{\n		$this->load->view(''home'');	\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(24, 32, 'home', 'public', 'Add Form', '', 'null', '[{"attr_name":"return","attr_desc":"\\t null\\n\\t"}]', 'function home()\n	{\n		$this->load->view(''home'');	\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(25, 32, '_insert_data', 'private', 'This function is used to parse the data posted form formbuilder interface and prepare the data for insertion. Once the data has been prepared it is then inserted into the database.', '', 'object(form_elements),string(type of element),string(state if the form element is inline, default = no)', '[{"attr_name":"return","attr_desc":"\\t does not return anything, simply adds the data to the database\\n\\t"}]', 'function _insert_data($decoded_obj,$type,$decoded_sort_order,$inline_multi = ''no'')\n	{\n		$decoded_array = (array)$decoded_obj;\n		//echo ''<pre>''.print_r($decoded_array,true).''</pre>'';exit(0);\n		\n		if($decoded_array && $type){\n			switch($type){\n				case ''textinput'':\n					foreach($decoded_array as $arr){\n						$data = array(\n							''type'' => $type,\n							''label'' => $arr->label,\n							''name'' => $arr->name,\n							''placeholder'' => $arr->placeholder,\n							''order'' => $this->_get_element_order($decoded_sort_order,$arr->name)\n							);	\n						$this->formbuilder_model->insert_form($data);\n					}\n				break;	\n				\n				case ''textarea'':\n					foreach($decoded_array as $arr){\n						$data = array(\n							''type'' => $type,\n							''label'' => $arr->label,\n							''name'' => $arr->name,\n							''order'' => $this->_get_element_order($decoded_sort_order,$arr->name)\n							);	\n						$this->formbuilder_model->insert_form($data);\n					}\n				break;\n				\n				case ''radio'':\n				case ''checkbox'':\n					foreach($decoded_array as $arr){\n						$data = array(\n							''type'' => $type,\n							''label'' => $arr[''attr'']->label,\n							''name'' => $arr[''attr'']->name,\n							''inline_element'' => $inline_multi,\n							''attributes'' => json_encode($arr[''values'']),\n							''order'' => $this->_get_element_order($decoded_sort_order,$arr[''attr'']->name)\n							);	\n						$this->formbuilder_model->insert_form($data);\n					}\n				break;\n				\n				case ''select'':\n					foreach($decoded_array as $arr){\n						$data = array(\n							''type'' => $type,\n							''label'' => $arr[''attr'']->label,\n							''name'' => $arr[''attr'']->name,\n							''multi_select'' => $inline_multi,\n							''attributes'' => json_encode($arr[''values'']),\n							''order'' => $this->_get_element_order($decoded_sort_order,$arr[''attr'']->name)\n							);	\n						$this->formbuilder_model->insert_form($data);\n					}\n				break;\n				\n				case ''filebutton'':\n					foreach($decoded_array as $arr){\n						$data = array(\n							''type'' => $type,\n							''label'' => $arr->label,\n							''name'' => $arr->name,\n							''order'' => $this->_get_element_order($decoded_sort_order,$arr->name)\n							);	\n						$this->formbuilder_model->insert_form($data);\n					}\n				break;\n			}\n		}\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(26, 32, '_get_element_order', 'private', 'This returns the order of the element', '', 'array(array of elements and their order),string(element name)', '[{"attr_name":"return","attr_desc":"\\t returns json decoded array that contains objects in inner levels\\n\\t"}]', 'function _get_element_order($order_array,$element_name)\n	{\n		if($order_array && $element_name){\n			foreach($order_array as $key => $val){\n					if($key == $element_name){\n						return $val;	\n					}\n			}\n		}\n		return 0;	\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(27, 32, '_manual_jason_decode', 'private', 'This function is used to manually decode the json data. This was done as the php build in json_decode failed to decode the multi level json string.', '', 'json(form elements),enum(status if the data has multi dimension)', '[{"attr_name":"return","attr_desc":"\\t returns json decoded array that contains objects in inner levels\\n\\t"}]', 'function _manual_jason_decode($data,$multi = false)\n	{\n		$temp_arr = array();\n		$final_arr = array();\n		$count = 0;\n		$separator = $multi ? ''],'' : ''},'';\n		$post_fix = $multi ? '']'' : ''}'';\n		if($data){\n			if(!$multi){\n				$temp_arr = explode($separator,$data);\n				if(count($temp_arr) > 1){	\n					$temp_arr[0] = $temp_arr[0].$post_fix;\n				}\n				foreach($temp_arr as $arr){\n					$final_arr[$count] = json_decode($arr);	\n					$count++;	\n				}\n			}else{\n				$temp_arr = explode($separator,$data);\n				if(count($temp_arr) > 1){		\n					$temp_arr[0] = $temp_arr[0].$post_fix;	\n				}\n				$multi_arr = array();\n				foreach($temp_arr as $arr){\n					$multi_arr = json_decode($arr);\n					$inner_counter = 0;\n					$temp_multi_arr = array();\n					if($multi_arr){\n						foreach($multi_arr as $ma){\n							if($inner_counter == 0){\n								$temp_multi_arr[''attr''] = json_decode($ma); 	\n							}else{\n								$temp_multi_arr[''values''][$inner_counter] = json_decode($ma); 	\n							}\n							$inner_counter++;\n						}\n					}\n					$final_arr[$count] = $temp_multi_arr;\n					$count++;	\n				}\n			}\n		}\n		return $final_arr;\n		\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(28, 32, '_manual_jason_decode', 'private', 'This function is used to manually decode the json data for sort order. This was done as the php build in json_decode failed to decode the multi level json string.', '', 'json(form elements)', '[{"attr_name":"return","attr_desc":"\\t returns json decoded array \\n\\t"}]', 'function _manual_jason_decode($data,$multi = false)\n	{\n		$temp_arr = array();\n		$final_arr = array();\n		$count = 0;\n		$separator = $multi ? ''],'' : ''},'';\n		$post_fix = $multi ? '']'' : ''}'';\n		if($data){\n			if(!$multi){\n				$temp_arr = explode($separator,$data);\n				if(count($temp_arr) > 1){	\n					$temp_arr[0] = $temp_arr[0].$post_fix;\n				}\n				foreach($temp_arr as $arr){\n					$final_arr[$count] = json_decode($arr);	\n					$count++;	\n				}\n			}else{\n				$temp_arr = explode($separator,$data);\n				if(count($temp_arr) > 1){		\n					$temp_arr[0] = $temp_arr[0].$post_fix;	\n				}\n				$multi_arr = array();\n				foreach($temp_arr as $arr){\n					$multi_arr = json_decode($arr);\n					$inner_counter = 0;\n					$temp_multi_arr = array();\n					if($multi_arr){\n						foreach($multi_arr as $ma){\n							if($inner_counter == 0){\n								$temp_multi_arr[''attr''] = json_decode($ma); 	\n							}else{\n								$temp_multi_arr[''values''][$inner_counter] = json_decode($ma); 	\n							}\n							$inner_counter++;\n						}\n					}\n					$final_arr[$count] = $temp_multi_arr;\n					$count++;	\n				}\n			}\n		}\n		return $final_arr;\n		\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(29, 34, '', '', 'ajax controller, provides ajax functions for Job module', '', '', '[{"attr_name":"author:","attr_desc":"\\t namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(30, 34, 'search_jobs', 'public', 'ajax function to search job(s)', '', 'an array of search parameters (POST)', '[{"attr_name":"return:","attr_desc":"\\t view of list of jobs\\n\\t"}]', 'function search_jobs()\n	{\n		$data = $this->input->post();\n		$data[''jobs''] = $this->job_model->search_jobs($data);\n		$this->load->view(''jobs_search_results_view'', isset($data) ? $data : NULL);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(31, 34, 'create_shifts', 'public', 'ajax function to create shift(s) for a job', '', 'an array of shift parameters (POST)', '[{"attr_name":"return:","attr_desc":"\\t json encode of result\\n\\t"},{"attr_name":"-","attr_desc":"\\t\\t\\t failed: {ok: false, error_id: (string)}\\n\\t"},{"attr_name":"-","attr_desc":"\\t\\t\\t success: {ok: true, job_date: (string) YYYYDDMM\\n\\t"}]', 'function create_shifts()\n	{\n		$data = $this->input->post();\n		$filter_data = array();\n		$filter_data[''job_id''] = $data[''job_id''];\n		$filter_data[''job_date''] = date(''Y-m-d'', strtotime($data[''job_date'']));\n		\n		if (strtotime($data[''job_date'']) <= now())\n		{\n			# Job start date can not be in the past\n			echo json_encode(array(''ok'' => false, ''error_id'' => ''start_date''));\n			return;\n		}	\n		\n		$filter_data[''start_time''] = strtotime($data[''job_date'']);		\n		$filter_data[''finish_time''] = strtotime($data[''finish_time'']);\n				\n		\n		if ($filter_data[''finish_time''] <= $filter_data[''start_time''])\n		{\n			# Finish time can not be less than start time\n			echo json_encode(array(''ok'' => false, ''error_id'' => ''finish_time''));\n			return;\n		}\n		\n		if ($data[''break_length''] > 0)\n		{\n			$break_time = array(\n				''length'' => $data[''break_length''] * 60, # seconds\n				''start_at'' => strtotime($data[''break_start_at''])\n			);\n			\n			if ($break_time[''start_at''] <= $filter_data[''start_time''] || $break_time[''start_at''] >= $filter_data[''finish_time''])\n			{\n				echo json_encode(array(''ok'' => false, ''error_id'' => ''break_start_at''));\n				return;\n			}\n			$breaks = array();\n			$breaks[] = $break_time;\n			$filter_data[''break_time''] = json_encode($breaks);\n		}\n		if ($data[''venue''])\n		{\n			$venue = modules::run(''attribute/venue/get_venue_by_name'', $data[''venue'']);\n			if (!$venue)\n			{\n				echo json_encode(array(''ok'' => false, ''error_id'' => ''venue''));\n				return;\n			}\n			else\n			{\n				$filter_data[''venue_id''] = $venue[''venue_id''];\n			}\n		}\n		else\n		{\n			$filter_data[''venue_id''] = $data[''venue''];\n		}\n		\n		$filter_data[''role_id''] = $data[''role_id''];\n		$filter_data[''uniform_id''] = $data[''uniform_id''];\n		$filter_data[''payrate_id''] = $data[''payrate_id''];\n		$filter_data[''payrate_type''] = $data[''payrate_type''];\n		\n		$count = $data[''count''];\n		if ($count < 1)\n		{\n			echo json_encode(array(''ok'' => false, ''error_id'' => ''count''));\n			return;\n		}\n		\n		for($i=0; $i < $count; $i++)\n		{\n			$this->job_shift_model->insert_job_shift($filter_data);\n		}\n		echo json_encode(array(''ok'' => true, ''job_date'' => $filter_data[''job_date'']));\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(32, 34, 'sort_shifts', 'public', 'ajax function to set sort key & value when getting shifts', '', '(POST) ''key''', '[{"attr_name":"return:","attr_desc":"\\t (void)\\n\\t"}]', 'function sort_shifts()\n	{\n		$key = $this->input->post(''key'');\n		$shifts_sort_value = ''asc'';\n		$shifts_sort_key = $this->session->userdata(''shifts_sort_key'');\n		if ($shifts_sort_key == $key)\n		{\n			# Change sort value\n			$shifts_sort_value = $this->session->userdata(''shifts_sort_value'');\n			if ($shifts_sort_value == ''asc'')\n			{\n				$shifts_sort_value = ''desc'';\n			} else\n			{\n				$shifts_sort_value = ''asc'';\n			}\n		}\n		else\n		{\n			# Init sort key & value\n			$shifts_sort_key = $key;\n		}\n		$this->session->set_userdata(''shifts_sort_key'', $shifts_sort_key);\n		$this->session->set_userdata(''shifts_sort_value'', $shifts_sort_value);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(33, 34, 'load_day_shifts', 'public', 'ajax function to load list view of shifts by day', '', '(POST) (int) job_id, (string: YYYY-MM-DD) job_date', '[{"attr_name":"return:","attr_desc":"\\t list view (table) of shifts\\n\\t"}]', 'function load_day_shifts()\n	{\n		$job_id = $this->input->post(''job_id'');\n		# Get all dates of the job\n		$job_dates = $this->job_shift_model->get_job_dates($job_id);\n		\n		# Get selected date from POST request first\n		$date = $this->input->post(''date'');\n		\n		# Then check the session\n		if (!$date)\n		{\n			$date = $this->session->userdata(''job_date'');\n		}\n		\n		# Otherwise, get the very next day\n		if (!$date) {\n			foreach($job_dates as $job_date)\n			{\n				if (strtotime($job_date[''job_date'']) >= strtotime(date(''Y-m-d'', now())))\n				{\n					$date = $job_date[''job_date''];\n					break;\n				}\n			}\n		}\n		\n		$this->session->set_userdata(''job_date'', $date);\n		\n		$data[''total_date''] = count($job_dates);\n		\n		# Get previous and next days\n		$key = 0;\n		foreach($job_dates as $index => $value)\n		{\n			if ($value[''job_date''] == $date)\n			{\n				$key = $index;\n			}\n		}		\n		if ($key == 0) {\n			$right_index = 2;\n			$left_index = 0;\n		} else if ($key == count($job_dates) - 1) {\n			$right_index = $key;\n			$left_index = $key - 2;\n		} else {\n			$right_index = $key + 1;\n			$left_index = $key - 1;\n		}\n		\n		# Optimized job dates array\n		$op_job_dates = array();\n		foreach($job_dates as $index => $value)\n		{\n			if ($index >= $left_index && $index <= $right_index)\n			{\n				$op_job_dates[] = $value;\n			}\n		}\n		\n		$data[''job_id''] = $job_id;\n		$data[''job_dates''] = $op_job_dates;\n		$data[''job_shifts''] = $this->job_shift_model->get_job_shifts($job_id, $date,\n						$this->session->userdata(''shifts_sort_key''),\n						$this->session->userdata(''shifts_sort_value''));\n		$this->load->view(''shifts_day_view'', isset($data) ? $data : NULL);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(34, 34, 'load_month_view', 'public', 'ajax function to set calendar_view to month', '', '(POST) (int) ''date'' timestamp', '[{"attr_name":"return:","attr_desc":"\\t (string) YYYY-MM-DD\\n\\t"}]', 'function load_month_view()\n	{\n		$this->session->set_userdata(''calendar_view'', ''month'');\n		echo date(''Y-m-d'', $this->input->post(''date''));\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(35, 34, 'load_week_view', 'public', 'ajax function to set calendar_view to week', '', '(POST) (int) ''date'' timestamp', '[{"attr_name":"return:","attr_desc":"\\t (string) YYYY-MM-DD\\n\\t"}]', 'function load_week_view()\n	{\n		$this->session->set_userdata(''calendar_view'', ''week'');\n		echo date(''Y-m-d'', $this->input->post(''date''));\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(36, 34, 'load_job_calendar', 'public', 'ajax function to load calendar view (month/week) of shifts', '', '(POST) (int) ''job_id''', '[{"attr_name":"return:","attr_desc":"\\t (view) calendar view\\n\\t"}]', 'function load_job_calendar()\n	{\n		$job_id = $this->input->post(''job_id'');\n		$job_dates = $this->job_shift_model->get_job_dates($job_id);\n		$data[''custom_date''] = now();\n		if ($job_dates)\n		{\n			$data[''custom_date''] = strtotime($job_dates[0][''job_date'']);\n		}\n		if ($this->input->post(''date''))\n		{\n			$data[''custom_date''] = strtotime($this->input->post(''date''));\n		}\n		if ($data[''custom_date''] < now())\n		{\n			$data[''custom_date''] = now();\n		}\n		$data[''job_id''] = $job_id;\n		\n		if (!$this->session->userdata(''calendar_view'') || $this->session->userdata(''calendar_view'') == ''week'') {\n			$this->load->view(''shifts_week_view'', isset($data) ? $data : NULL);	\n		} \n		else if ($this->session->userdata(''calendar_view'') == ''month'') {\n			$out = array();\n			foreach($job_dates as $date)\n			{\n				$out[] = array(\n					''id'' => $this->job_shift_model->count_job_shifts($job_id, $date[''job_date'']),\n					''title'' => $job_id,\n					''url'' => $date[''job_date''],\n					''start'' => strtotime($date[''job_date'']) . ''000'',\n					''end'' => strtotime($date[''job_date'']) . ''000'',\n				);\n			}\n			$data[''events_source''] = json_encode($out);\n			$this->load->view(''shifts_month_view'', isset($data) ? $data : NULL);\n		}\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(37, 34, 'load_shift_staff', 'public', 'ajax function to load view of assign staff to a shift', '', '(via POST) pk: (int) id of the shift', '[{"attr_name":"return:","attr_desc":"\\t (view) form to assign staff to the shift\\n\\t"}]', 'function load_shift_staff()\n	{\n		$shift_id = $this->input->post(''pk'');\n		$shift = $this->job_shift_model->get_job_shift($shift_id);\n		$data[''staff''] = modules::run(''staff/get_staff'', $shift[''staff_id'']);\n		$data[''shift''] = $shift;\n		$this->load->view(''shift_staff'', isset($data) ? $data : NULL);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(38, 34, 'search_staff_for_shift', 'public', 'ajax function to search staffs for a shift', '', '(via POST) query: (string) keyword for staff name', '[{"attr_name":"return:","attr_desc":"\\t (view) of list of searched staffs\\n\\t"}]', 'function search_staff_for_shift()\n	{\n		$query = $this->input->post(''query'');\n		$this->load->model(''staff/staff_model'');\n		$data[''staffs''] = $this->staff_model->search_staffs(array(''keyword'' => $query, ''limit'' => 5));\n		$this->load->view(''staffs_for_shift'', isset($data) ? $data : NULL);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(39, 34, 'update_shift_staff', 'public', 'ajax function to update staff assign / status to the shift', '', '(via POST)', '[{"attr_name":"-","attr_desc":"\\t\\t\\t shift_staff_id: (int) id of staff\\n\\t"},{"attr_name":"-","attr_desc":"\\t\\t\\t status: (int) 1 assigned \\/ 2 confirmed \\/ 3 rejected\\n\\t"},{"attr_name":"-","attr_desc":"\\t\\t\\t shift_staff: (string) staff first name and last name\\n\\t"},{"attr_name":"return:","attr_desc":"\\t json encode\\n\\t"}]', 'function update_shift_staff()\n	{\n		$data = $this->input->post();\n		$update_shift_data = array();\n		if ($data[''shift_staff''])\n		{\n			$staff = modules::run(''staff/get_staff'', $data[''shift_staff_id'']);\n			\n			if ($staff)\n			{\n				$update_shift_data = array(\n					''staff_id'' => $data[''shift_staff_id''],\n					''status'' => $data[''status'']\n				);\n			}\n			else {\n				echo json_encode(array(''ok'' => false, ''msg'' => ''Staff not found''));\n				return;\n			}\n		}\n		else {\n			$update_shift_data = array(\n				''staff_id'' => 0,\n				''status'' => 0\n			);\n		}\n		\n		$this->job_shift_model->update_job_shift($data[''shift_id''], $update_shift_data);\n		echo json_encode(array(\n			''ok'' => true, \n			''shift_id'' => $data[''shift_id''], \n			''value'' => ($data[''shift_staff'']) ? $data[''shift_staff''] : ''No Staff Assigned'',\n			''class_name'' => modules::run(''job/status_to_class'', $update_shift_data[''status''])\n		));\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(40, 34, 'load_shift_breaks', 'public', 'ajax function to load all breaks of the shift', '', '(int) shift_id, via POST', '[{"attr_name":"return:","attr_desc":"\\t (view) form with shift break information filled in\\n\\t"}]', 'function load_shift_breaks()\n	{\n		$shift_id = $this->input->post(''pk'');\n		$shift = $this->job_shift_model->get_job_shift($shift_id);\n		$data[''breaks''] = json_decode($shift[''break_time'']);\n		$data[''shift_id''] = $shift_id;\n		$data[''shift''] = $shift;\n		$this->load->view(''shift_breaks'', isset($data) ? $data : NULL);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(41, 34, 'add_shift_break', 'public', 'ajax function to load form view to add new break to the shift', '', '(int) shift_id, via POST', '[{"attr_name":"return:","attr_desc":"\\t (view) form to enter new break for the shift\\n\\t"}]', 'function add_shift_break()\n	{\n		$shift_id = $this->input->post(''pk'');\n		$shift = $this->job_shift_model->get_job_shift($shift_id);\n		$data[''shift''] = $shift;\n		$this->load->view(''shift_add_break'', isset($data) ? $data : NULL);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(42, 34, 'update_job_shift_breaks', 'public', 'ajax function to update breaks of the shift', '', 'two arrays of breaks length and start time (via POST)', '[{"attr_name":"return:","attr_desc":"\\t json encode - if successful {ok: true, shift_id: (int), minutes: int}\\n\\t"},{"attr_name":"","attr_desc":"\\t\\t\\t\\t\\t\\t - if failed\\t{ok: false, number: error_number}\\n\\t"}]', 'function update_job_shift_breaks()\n	{\n		$length = $this->input->post(''break_length'');\n		$start_at = $this->input->post(''break_start_at'');\n		$job_shift = $this->job_shift_model->get_job_shift($this->input->post(''shift_id''));\n		\n		$breaks = array();\n		$total = 0;\n		foreach($length as $index => $value)\n		{\n			if ($value > 0)\n			{\n				$break_time = array(\n					''length'' => $value * 60,\n					''start_at'' => strtotime($start_at[$index])\n				);\n				\n				if ($break_time[''start_at''] <= $job_shift[''start_time''] || $break_time[''start_at''] >=$job_shift[''finish_time''])\n				{\n					echo json_encode(array(''ok'' => false, ''number'' => $index));\n					return;\n				}\n				$total += $value;\n				$breaks[] = $break_time;\n			}\n		}\n		\n		if ($this->job_shift_model->update_job_shift($job_shift[''shift_id''], array(''break_time'' => json_encode($breaks))))\n		{\n			if ($total > 0) {				\n				$minutes = $total . '' mins'';\n				echo json_encode(array(''ok'' => true, ''shift_id'' => $job_shift[''shift_id''],''minutes'' => $minutes));\n			}\n			else\n			{\n				echo json_encode(array(''ok'' => true, ''shift_id'' => $job_shift[''shift_id''],''minutes'' => 0));\n			}\n		}\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(43, 34, 'delete_shifts', 'public', 'ajax function to delete shift(s)', '', 'an array of integers (via POST), which are primary keys of shifts', '[{"attr_name":"return:","attr_desc":"\\t json encode {job_id: (int) $job_id, job_date: (YYYY-MM-DD) $job_date}  \\n\\t"}]', 'function delete_shifts()\n	{\n		$shifts = $this->input->post(''shifts'');\n		$shift = null;\n		$result = array();\n		foreach($shifts as $shift_id)\n		{\n			$shift = $this->job_shift_model->get_job_shift($shift_id);\n			$this->job_shift_model->delete_job_shift($shift_id);\n		}\n		if ($shift)\n		{\n			$result[''job_id''] = $shift[''job_id''];\n			if (modules::run(''job/count_job_shifts'', $shift[''job_id''], strtotime($shift[''job_date''])) > 0)\n			{\n				$result[''job_date''] = $shift[''job_date''];\n			}\n		}		\n		echo json_encode($result);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(44, 34, 'load_shifts_copy', 'public', 'ajax function to load the calendar popup for copying shifts across', '', 'string of shift id 1~2~3~4 (via GET)', '[{"attr_name":"return:","attr_desc":"\\t calendar view\\n\\t"}]', 'function load_shifts_copy($s = '''')\n	{\n		$shifts = explode(''~'', $s);\n		\n		$data[''shift''] = $this->job_shift_model->get_job_shift($shifts[0]);\n		$data[''shifts''] = $shifts;		\n		$this->load->view(''shifts_copy'', isset($data) ? $data : NULL);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(45, 34, 'update_selected_day', 'public', 'ajax function to update selected day (to the sessions of array of all selected days) for copying shift function', '', 'null', '[{"attr_name":"return:","attr_desc":"\\t json encode {success: true\\/false, msg: ''''}\\n\\t"}]', 'function update_selected_day()\n	{\n		$ts = $this->input->post(''ts'');\n		$all_ts = $this->session->userdata(''all_ts'');\n		if (!$all_ts) {\n			$all_ts = array();\n		}\n		$key = array_search($ts, $all_ts);\n		if ($key !== false) {\n			unset($all_ts[$key]);\n		}\n		else\n		{\n			if ($ts > now())\n			{\n				$all_ts[] = $ts;\n			}\n			else\n			{				\n				echo json_encode(array(''success'' => false, ''msg'' => ''Cannot copy to date in the past''));\n				return;\n			}\n		}\n		\n		$this->session->set_userdata(''all_ts'', $all_ts);\n		echo json_encode(array(''success'' => true));	\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(46, 34, 'clear_selected_days', 'public', 'ajax function to clear session of selected days for copy', '', '(none)', '[{"attr_name":"return:","attr_desc":"\\t (void)\\n\\t"}]', 'function clear_selected_days()\n	{\n		$this->session->unset_userdata(''all_ts'');\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(47, 34, 'copy_selected_days', 'public', 'ajax function to copy selected shifts to selected days', '', 'array of shift id', '[{"attr_name":"return:","attr_desc":"\\t json encode {success: (boolean), msg: (string)}\\n\\t"}]', 'function copy_selected_days()\n	{\n		$all_ts = $this->session->userdata(''all_ts'');\n		if ($all_ts)\n		{\n			$shifts = $this->input->post(''shifts'');\n			foreach($all_ts as $ts)\n			{\n				foreach($shifts as $shift_id)\n				{\n					$shift = $this->job_shift_model->get_job_shift($shift_id);\n					$new_shift = $shift;\n					unset($new_shift[''shift_id'']);\n					unset($new_shift[''created_on'']);\n					unset($new_shift[''modified_on'']);\n					$new_shift[''job_date''] = date(''Y-m-d'', $ts);\n					$start_time = strtotime(date(''Y-m-d'', $ts) . '' '' . date(''H:i'', $shift[''start_time'']));\n					$finish_time = $start_time + $shift[''finish_time''] - $shift[''start_time''];\n					$new_shift[''start_time''] = $start_time;\n					$new_shift[''finish_time''] = $finish_time;\n					\n					$breaks = json_decode($shift[''break_time'']);\n					$new_breaks = array();\n					foreach($breaks as $break)\n					{\n						$new_breaks[] = array(\n							''length'' => $break->length,\n							''start_at'' => $start_time + $break->start_at - $shift[''start_time'']\n						);\n					}\n					$new_shift[''break_time''] = json_encode($new_breaks);\n					$this->job_shift_model->insert_job_shift($new_shift);\n				}				\n			}\n			$this->session->unset_userdata(''all_ts'');\n			echo json_encode(array(''success'' => true));\n		}\n		else\n		{\n			echo json_encode(array(''success'' => false, ''msg'' => ''No day selected''));\n		}		\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(48, 35, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Job\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(49, 35, 'count_job_shifts', 'public', 'function to count number of shifts in a job, optionally in a specified date', '', '(int) $job_id, (int - timestamp) $job_date', '[{"attr_name":"return:","attr_desc":"\\t (int)\\n\\t"}]', 'function count_job_shifts($job_id, $job_date = null, $status = null)\n	{\n		if ($job_date)\n		{\n			$job_date = date(''Y-m-d'', $job_date);\n		}\n		echo $this->job_shift_model->count_job_shifts($job_id, $job_date, $status);\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(50, 35, 'get_day_shifts', 'public', 'function to get list of shifts in a day', '', '(int) $job_id, (int - timestamp) $job_date', '[{"attr_name":"return:","attr_desc":"\\t (array)\\n\\t"}]', 'function get_day_shifts($job_id, $job_date)\n	{\n		$job_date = date(''Y-m-d'', $job_date);\n		$shifts = $this->job_shift_model->get_job_shifts($job_id, $job_date);\n		$ids = array();\n		foreach($shifts as $shift)\n		{\n			$ids[] = $shift[''shift_id''];\n		}\n		return $ids;\n	}', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(51, 36, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Job\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(52, 39, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(53, 40, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(54, 42, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(55, 44, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(56, 45, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(57, 46, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(58, 49, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(59, 50, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Profile\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(60, 52, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(61, 54, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Resource\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(62, 56, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Dashboard_staff\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(63, 59, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Ajax\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(64, 60, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Job\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(65, 62, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(66, 63, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(67, 64, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(68, 66, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Product\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(69, 68, '', '', '', '', '', '[{"attr_name":"Controller:","attr_desc":"  Work\\/Ajax\\n "},{"attr_name":"author:","attr_desc":"  namnd86@gmail.com\\n "}]', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `modules_mvc`
--

CREATE TABLE `modules_mvc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_modules_id` int(11) NOT NULL,
  `mvc_type` enum('controllers','models','views') NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `modules_mvc`
--

INSERT INTO `modules_mvc` (`id`, `project_modules_id`, `mvc_type`, `name`, `description`, `comment`, `created`, `modified`) VALUES
(1, 1, 'controllers', 'Account', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(2, 2, 'controllers', 'Attribute', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(3, 2, 'controllers', 'Availability', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(4, 2, 'controllers', 'Department', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(5, 2, 'controllers', 'Location', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(6, 2, 'controllers', 'Payrate', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(7, 2, 'controllers', 'Role', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(8, 2, 'controllers', 'Staff_attribute', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(9, 2, 'controllers', 'Uniform', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(10, 2, 'controllers', 'Venue', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(11, 2, 'models', 'Availability_model', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(12, 2, 'models', 'Department_model', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(13, 2, 'models', 'Location_model', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(14, 2, 'models', 'Payrate_model', 'Description has not been added to this class', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(15, 2, 'models', 'Role_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(16, 2, 'models', 'Staff_attribute_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(17, 2, 'models', 'Uniform_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(18, 2, 'models', 'Venue_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(19, 3, 'controllers', 'Auth', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(20, 3, 'models', 'Auth_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(21, 4, 'controllers', 'Client', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(22, 4, 'models', 'Client_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(23, 5, 'controllers', 'Common', 'This is common controller to handle common module such as state or country drop down. It will only called the function and can be used in any views/modules', 'Dependent on Common_model. List of common module is: action, status,supers, states, countries, titles, genders, dob, location', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(24, 5, 'models', 'Common_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(25, 6, 'controllers', 'Config', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(26, 6, 'models', 'Config_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(27, 7, 'controllers', 'Admin', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(28, 8, 'controllers', 'Admin', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(29, 8, 'controllers', 'Dashboard', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(30, 8, 'controllers', 'Dashboard_staff', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(31, 8, 'models', 'Dashboard_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(32, 9, 'controllers', 'Formbuilder', 'This module is used for building custom form. On staffmaster this will be used for adding custom attributes for staff. These attributes will then be searchable for any given staff.', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(33, 9, 'models', 'Formbuilder_model', 'This module is used for building custom form. On staffmaster this will be used for adding custom attributes for staff. These attributes will then be searchable for any given staff.', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(34, 10, 'controllers', 'Ajax', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(35, 10, 'controllers', 'Job', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(36, 10, 'controllers', 'Shift', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(37, 10, 'models', 'Job_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(38, 10, 'models', 'Job_shift_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(39, 11, 'controllers', 'Admin', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(40, 11, 'controllers', 'Ajax', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(41, 11, 'models', 'Order_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(42, 12, 'controllers', 'Admin', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(43, 12, 'models', 'Page_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(44, 13, 'controllers', 'Admin', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(45, 13, 'controllers', 'Ajax', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(46, 13, 'controllers', 'Product', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(47, 13, 'models', 'Customer_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(48, 13, 'models', 'Product_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(49, 14, 'controllers', 'Ajax', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(50, 14, 'controllers', 'Profile', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(51, 14, 'models', 'Profile_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(52, 15, 'controllers', 'Admin', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(53, 15, 'controllers', 'Ajax', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(54, 15, 'controllers', 'Resource', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(55, 15, 'models', 'Resource_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(56, 16, 'controllers', 'Ajax', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(57, 16, 'controllers', 'Roster_staff', 'roster controller for staff', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(58, 16, 'models', 'Roster_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(59, 17, 'controllers', 'Ajax', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(60, 17, 'controllers', 'Staff', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(61, 17, 'models', 'Staff_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(62, 18, 'controllers', 'Admin', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(63, 18, 'controllers', 'Ajax', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(64, 18, 'controllers', 'Css', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(65, 18, 'models', 'User_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(66, 19, 'controllers', 'Warranty', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(67, 19, 'models', 'Warranty_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(68, 20, 'controllers', 'Ajax', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(69, 20, 'controllers', 'Work_staff', 'apply controller for staff', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00'),
(70, 20, 'models', 'Work_model', 'Description has not been added to this class', '', '2014-02-06 23:21:45', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_documentation`
--

CREATE TABLE `project_documentation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_modules`
--

CREATE TABLE `project_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `project_modules`
--

INSERT INTO `project_modules` (`id`, `name`, `description`, `created`, `modified`) VALUES
(1, 'account', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(2, 'attribute', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(3, 'auth', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(4, 'client', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(5, 'common', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(6, 'config', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(7, 'customer', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(8, 'dashboard', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(9, 'formbuilder', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(10, 'job', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(11, 'order', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(12, 'page', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(13, 'product', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(14, 'profile', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(15, 'resource', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(16, 'roster', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(17, 'staff', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(18, 'user', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(19, 'warranty', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00'),
(20, 'work', '', '2014-02-06 23:21:44', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `code`, `name`) VALUES
(1, 'ACT', 'Australian Capital Territory'),
(2, 'NSW', 'New South Wales'),
(3, 'NT', 'Northern Territory'),
(4, 'QLD', 'Queensland'),
(5, 'SA', 'South Australia'),
(6, 'TAS', 'Tasmania'),
(7, 'VIC', 'Victoria'),
(8, 'WA', 'Western Australia');

-- --------------------------------------------------------

--
-- Table structure for table `supers`
--

CREATE TABLE `supers` (
  `super_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`super_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122 ;

--
-- Dumping data for table `supers`
--

INSERT INTO `supers` (`super_id`, `name`) VALUES
(1, 'AMP'),
(2, 'Asset Super'),
(3, 'Asteron Life'),
(4, 'Aus Super'),
(5, 'Australian Super'),
(6, 'BT Super'),
(7, 'Care Super'),
(8, 'Catholic Super Fund'),
(9, 'First State Super'),
(10, 'Guild Super'),
(11, 'Health super'),
(12, 'HESTA'),
(13, 'HOST Plus'),
(14, 'Intrust Super'),
(15, 'IOOF'),
(16, 'KARLIE K WRING'),
(17, 'Local Government Super'),
(18, 'LUCRF Super'),
(19, 'Media super'),
(20, 'MLC'),
(21, 'MLC Universal Super Scheme'),
(22, 'NGS Super'),
(23, 'One Path'),
(24, 'Pacific Custodians Pty Ltd'),
(25, 'Recruitment Super'),
(26, 'Rei Super'),
(27, 'REST Superannuation'),
(28, 'Sunsuper'),
(29, 'Telstra Super'),
(30, 'Unisuper'),
(31, 'Vic Super'),
(32, 'Virgin Superfund'),
(33, 'Westscheme'),
(34, 'Agest Super'),
(35, 'AMP Corporate Super'),
(36, 'AMP Custom'),
(37, 'AMP Flexible Super'),
(38, 'AMP Life Limited'),
(39, 'AMP RETIREMENT SAVINGS'),
(40, 'ANZ Australian Staff Super'),
(41, 'ANZ Super Advantage'),
(42, 'ARF Super Fund'),
(43, 'ARIA'),
(44, 'Ashton Superfund'),
(46, 'Australian Enterprise Super'),
(47, 'Australian Super Member'),
(48, 'Australian YMCA Super'),
(49, 'AXA'),
(50, 'B Price & G Price Super'),
(51, 'BENDIGO'),
(52, 'BT Life'),
(54, 'Calstores Super'),
(56, 'Catholic Superannuation'),
(57, 'CBUS'),
(58, 'Clearview Super & Rollover Fun'),
(59, 'Club Super'),
(60, 'Co-invest'),
(61, 'Colonial First State'),
(62, 'Colonial Select Personal Super'),
(63, 'Commonwealth officers super co'),
(64, 'Commonwealth Super fund & Roll'),
(65, 'Easy Choice'),
(66, 'Equisuper'),
(67, 'First Choice Employer Super'),
(69, 'GESB'),
(71, 'Harding super Fund'),
(74, 'Holcim Super'),
(75, 'Ing Masterfund'),
(76, 'ING ONE Answer'),
(77, 'ING One Answer Personal Super'),
(78, 'Instruct Super'),
(79, 'Integra Super One Path'),
(81, 'Klose Family SMSF'),
(82, 'Legal Super'),
(83, 'LG Super'),
(84, 'Lifetrack Personal Super'),
(85, 'Local super'),
(86, 'LUCRF'),
(87, 'Macquarie Super Manager'),
(89, 'Members Equity'),
(90, 'MERCER'),
(91, 'MLC Navigator'),
(92, 'MTAA Super Fund'),
(94, 'North Personal Wealth'),
(96, 'OSF'),
(97, 'Perpetual Wealth Focus'),
(98, 'Plum Super'),
(99, 'Police and Nurses'),
(101, 'QSuper'),
(104, 'Retail Employees Super Trust'),
(105, 'Russell Super Solution'),
(106, 'SERF'),
(107, 'Southerland Credit U'),
(108, 'Spectrum Super'),
(109, 'Statewide Super'),
(110, 'Sun Super'),
(111, 'Suncorp Easy Super'),
(112, 'Suncorp Metway'),
(113, 'Super Trust'),
(114, 'Superannuation Savings Account'),
(115, 'TASPLAN'),
(116, 'Tower Investing In Life'),
(117, 'Virgin Super'),
(118, 'Vision Super Fund'),
(119, 'Visions Super Fund'),
(120, 'Wesfarmers Group Super Fund');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `is_staff` tinyint(4) NOT NULL,
  `is_client` tinyint(4) NOT NULL,
  `access_level` tinyint(4) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `title` varchar(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `last_signed_in_on` datetime NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `status`, `is_admin`, `is_staff`, `is_client`, `access_level`, `email_address`, `username`, `password`, `title`, `first_name`, `last_name`, `full_name`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `country`, `mobile`, `last_signed_in_on`, `created_on`, `modified_on`) VALUES
(1, 1, 1, 1, 0, 0, 'propagate.au@gmail.com', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Mr', 'Pro', 'Gate', 'Pro Pa Gate', '20A Macquaire St', 'Prahran', 'Melbourne', 'VIC', '3181', '', 'AU', '', '2014-02-10 10:02:39', '2014-02-05 19:22:44', '2014-02-10 18:34:03'),
(10, 1, 0, 1, 0, 0, 'andrew.hyatt@smmail.com', 'andrew.hyatt@smmail.com', '47fab60bdcd2ffce91447d19fe9ce7f1', 'Mr', 'Andrew', 'Hyatt', '', '24 Park St', 'Hawthorn', 'Melbourne', 'VIC', '3122', '04334578965', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:12:17', '0000-00-00 00:00:00'),
(11, 1, 0, 1, 0, 0, 'brian.hudson@smmail.com', 'brian.hudson@smmail.com', '929064f2a141f812f1c2efb3ff8194ca', 'Mr', 'Brian', 'Hudson', '', '23 Liddiard St', 'Hawthorn', 'Melbourne', 'VIC', '3122', '04334578964', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:13:35', '0000-00-00 00:00:00'),
(12, 1, 0, 1, 0, 0, 'thomas.edison@smmail.com', 'thomas.edison@smmail.com', '8766814f87d4790bd6c5f52d12b98da6', 'Mr', 'Thomas', 'Edison', '', '34 Stanley St', 'Melbourne', 'Melbourne', 'VIC', '3000', '04334578962', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:14:52', '0000-00-00 00:00:00'),
(13, 1, 0, 1, 0, 0, 'richard.gerald@smmail.com', 'richard.gerald@smmail.com', 'f9e1d2c7f00aae3f2a241982dc770f72', 'Mr', 'Richard', 'Gerald', '', '26 Monash FWY', 'Dandenong', 'Melbourne', 'VIC', '3076', '04334578968', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:16:31', '0000-00-00 00:00:00'),
(14, 1, 0, 1, 0, 0, 'edward.chaplin@smmail.com', 'edward.chaplin@smmail.com', '6676e7d0995ebd8dbd136869a9358d14', 'Mr', 'Edward', 'Chaplin', '', '7 Rose St', 'Sandringham', 'Melbourne', 'VIC', '3058', '04334578969', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:18:16', '0000-00-00 00:00:00'),
(15, 1, 0, 1, 0, 0, 'gary.burke@smmail.com', 'gary.burke@smmail.com', '66159c88637fad4014ee2e0547b7fd22', 'Mr', 'Gary', 'Burke', '', '90 Smith St', 'KEW', 'Melbourne', 'VIC', '3121', '04334578967', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:19:47', '0000-00-00 00:00:00'),
(16, 1, 0, 1, 0, 0, 'howard.leigh@smmail.com', 'howard.leigh@smmail.com', '09ab16a5273d209653935ad2d5c145ad', 'Mr', 'Howard', 'Leigh', '', '8 Bell St', 'Camberwell', 'Mel', 'VIC', '3123', '04334578961', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:21:45', '0000-00-00 00:00:00'),
(17, 1, 0, 1, 0, 0, 'william.tent@smmail.com', 'william.tent@smmail.com', '8a31fc89653c9f20d371bec97430d477', 'Mr', 'William', 'Tent', '', '20 Riverbank St', 'Melbourne', 'Mel', 'VIC', '3000', '04334578963', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:23:19', '0000-00-00 00:00:00'),
(18, 1, 0, 1, 0, 0, 'luke.smith@smmail.com', 'luke.smith@smmail.com', '85242bd9419eb073a907d7f756b5f8dd', 'Mr', 'Luke', 'Smith', '', '3 Collins St', 'East Camberwell', 'Melbourne', 'VIC', '3123', '04334578977', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:24:40', '0000-00-00 00:00:00'),
(19, 1, 0, 1, 0, 0, 'rio.chris@smmail.com', 'rio.chris@smmail.com', 'f237aef579ff90dcd9b528115cb25c32', 'Mr', 'Rio', 'Chris', '', '40 Hull St', 'Hawthorn', 'Melbourne', 'VIC', '3122', '04334578978', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:25:49', '0000-00-00 00:00:00'),
(20, 1, 0, 1, 0, 0, 'paul.gilbert@smmail.com', 'paul.gilbert@smmail.com', '2e69f107d4be5f743461cb66d55d5e6e', 'Mr', 'Paul', 'Gilbert', '', '50 Town St', 'Glen Huntly', 'Melbourne', 'VIC', '3151', '04334578976', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:27:12', '0000-00-00 00:00:00'),
(21, 1, 0, 1, 0, 0, 'susie.howie@smmail.com', 'susie.howie@smmail.com', 'd9db25b58eb5dd9c1b200629a0cd25f8', 'Miss', 'Susie', 'Howie', '', '9 Hull St', 'Hawthorn', 'Mel', 'VIC', '3121', '04334578974', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:28:30', '0000-00-00 00:00:00'),
(22, 1, 0, 1, 0, 0, 'fiona.harris@smmail.com', 'fiona.harris@smmail.com', '3308b3a95bb633da5c0c578a607dfaff', 'Miss', 'Fiona', 'Harris', '', '2 Lidiard St', 'Camberwell', 'Melbourne', 'VIC', '3123', '', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:29:33', '0000-00-00 00:00:00'),
(23, 1, 0, 1, 0, 0, 'rachel.gibson@smmail.com', 'rachel.gibson@smmail.com', '4e2fe6dc5c296a7a548a7fd4eaf3ad07', 'Miss', 'Rachel', 'Gibson', '', '12 Square st', 'Melbourne', 'Melbourne', 'VIC', '3000', '04334578448', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:31:01', '0000-00-00 00:00:00'),
(24, 1, 0, 1, 0, 0, 'judith.palse@smmail.com', 'judith.palse@smmail.com', 'f481aa3206ba8cb86cd50fe9d005a9b6', 'Miss', 'Judith', 'Palse', '', '99 Bank St', 'Cranbourne', 'Melbourne', 'VIC', '3400', '043345744448', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:32:24', '0000-00-00 00:00:00'),
(25, 1, 0, 1, 0, 0, 'lucy.dale@smmail.com', 'lucy.dale@smmail.com', '861a628f450def33619f6232540441cc', 'Mrs', 'Lucy', 'Dale', '', '9 Iron st', 'Brighton', 'Melbourne', 'VIC', '3300', '', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:33:21', '0000-00-00 00:00:00'),
(26, 1, 0, 1, 0, 0, 'sheila.hondie@smmail.com', 'sheila.hondie@smmail.com', 'd10d53f2f76add5b8561541f981c60d4', 'Miss', 'Sheila', 'Hondie', '', '45 Team st', 'Glen Roy', 'Melbourne', 'VIC', '3145', '', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:34:21', '0000-00-00 00:00:00'),
(27, 1, 0, 1, 0, 0, 'jess.killer@smmail.com', 'jess.killer@smmail.com', 'ff6ae2cda9741c0f0c03bce2b6d93af9', 'Miss', 'Jess', 'Killer', '', '7 Whiteman St', 'Melbourne', 'Melbourne', 'VIC', '3000', '', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:35:22', '0000-00-00 00:00:00'),
(28, 1, 0, 1, 0, 0, 'kelly.chen@smmail.com', 'kelly.chen@smmail.com', '872059ee9abf7170f74f41b33e41830d', 'Miss', 'Kelly', 'Chen', '', '8 Flinders St', 'Melbourne', 'Melbourne', 'VIC', '3000', '', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:36:17', '0000-00-00 00:00:00'),
(29, 1, 0, 1, 0, 0, 'angela.lindsay@smmail.com', 'angela.lindsay@smmail.com', 'f495b400db54e6dec5bf2a7f6d40fd56', 'Miss', 'Angela', 'Lindsay', '', '80 Bourke St', 'Melbourne', 'Melbourne', 'VIC', '3000', '', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:37:27', '0000-00-00 00:00:00'),
(30, 1, 0, 1, 0, 0, 'lily.clipton@smmail.com', 'lily.clipton@smmail.com', 'b42669c97237ef087cc18c67afaac878', 'Miss', 'Lily', 'Clipton', '', '7 Flower st', 'Dandenong', 'Melbourne', 'VIC', '3600', '', 'AU', '', '0000-00-00 00:00:00', '2014-02-03 19:38:19', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_clients`
--

CREATE TABLE `user_clients` (
  `client_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `external_client_id` varchar(20) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `invoice_auto_send` tinyint(4) NOT NULL,
  `abn` varchar(20) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_staffs`
--

CREATE TABLE `user_staffs` (
  `staff_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `external_staff_id` varchar(20) NOT NULL,
  `rating` decimal(10,2) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `emergency_contact` varchar(100) NOT NULL,
  `emergency_phone` varchar(20) NOT NULL,
  `f_aus_resident` tinyint(4) NOT NULL,
  `f_tax_free_threshold` tinyint(4) NOT NULL,
  `f_tax_offset` tinyint(4) NOT NULL,
  `f_senior_status` varchar(100) NOT NULL,
  `f_help_debt` tinyint(4) NOT NULL,
  `f_help_variation` varchar(100) NOT NULL,
  `f_acc_name` varchar(100) NOT NULL,
  `f_acc_number` varchar(100) NOT NULL,
  `f_bsb` varchar(5) NOT NULL,
  `f_employed` int(11) NOT NULL,
  `f_abn` varchar(20) NOT NULL,
  `f_require_gst` tinyint(4) NOT NULL,
  `f_tfn` varchar(20) NOT NULL,
  `s_choice` varchar(100) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_employee_id` varchar(100) NOT NULL,
  `s_tfn` varchar(20) NOT NULL,
  `s_fund_name` varchar(100) NOT NULL,
  `s_fund_website` varchar(100) NOT NULL,
  `s_product_id` varchar(100) NOT NULL,
  `s_fund_phone` varchar(100) NOT NULL,
  `s_membership` varchar(100) NOT NULL,
  `s_fund_address` varchar(100) NOT NULL,
  `s_fund_suburb` varchar(100) NOT NULL,
  `s_fund_postcode` varchar(10) NOT NULL,
  `s_fund_state` varchar(10) NOT NULL,
  `s_agree` tinyint(4) NOT NULL,
  `availability` text NOT NULL,
  `payrates` varchar(100) NOT NULL,
  `roles` varchar(100) NOT NULL,
  `locations` varchar(100) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `user_staffs`
--

INSERT INTO `user_staffs` (`staff_id`, `user_id`, `group_id`, `external_staff_id`, `rating`, `gender`, `dob`, `emergency_contact`, `emergency_phone`, `f_aus_resident`, `f_tax_free_threshold`, `f_tax_offset`, `f_senior_status`, `f_help_debt`, `f_help_variation`, `f_acc_name`, `f_acc_number`, `f_bsb`, `f_employed`, `f_abn`, `f_require_gst`, `f_tfn`, `s_choice`, `s_name`, `s_employee_id`, `s_tfn`, `s_fund_name`, `s_fund_website`, `s_product_id`, `s_fund_phone`, `s_membership`, `s_fund_address`, `s_fund_suburb`, `s_fund_postcode`, `s_fund_state`, `s_agree`, `availability`, `payrates`, `roles`, `locations`) VALUES
(5, 10, 1, '', 0.00, 'm', '01-07-1976', 'Cherry', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Andrew Hyatt', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["2","3"]', '["8","13","6","14"]', ''),
(6, 11, 0, '', 0.00, 'm', '01-03-1969', 'Berry', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Brian Hudson', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["2","3"]', '["8","13","6","14"]', ''),
(7, 12, 0, '', 0.00, 'm', '01-08-1965', 'Teddy', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Thomas Edison', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(8, 13, 0, '', 0.00, 'm', '01-06-1984', 'Rain', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Richard Gerald', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(9, 14, 1, '', 0.00, 'm', '01-05-1991', 'Edith', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Edward Chaplin', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(10, 15, 0, '', 0.00, 'm', '02-07-1987', 'Glenn', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Gary Burke', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(11, 16, 1, '', 0.00, 'm', '01-06-1987', 'Henny', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Howard Leigh', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(12, 17, 0, '', 0.00, 'm', '01-06-1991', 'Wendy', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'William Tent', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(13, 18, 3, '', 0.00, 'm', '01-05-1993', 'Lucy', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Luke Smith', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(14, 19, 0, '', 0.00, 'm', '01-01-1991', 'Rena', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Rio Chris', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(15, 20, 0, '', 0.00, 'm', '01-01-1984', 'Pillip', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Paul Gilbert', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(16, 21, 0, '', 0.00, 'f', '01-01-1984', 'Sean', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Susie Howie', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(17, 22, 0, '', 0.00, 'f', '01-01-1989', 'Fendy', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Fiona Harris', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(18, 23, 1, '', 0.00, 'f', '01-04-1977', 'Randy', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Rachel Gibson', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(19, 24, 0, '', 0.00, 'f', '01-07-1984', 'Jade', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Judith Palse', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(20, 25, 0, '', 0.00, 'f', '01-04-1994', 'Lina', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Lucy Dale', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(21, 26, 1, '', 0.00, 'f', '01-08-1969', 'Jes', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Sheila Hondie', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(22, 27, 0, '', 0.00, 'f', '01-01-1979', 'Sam', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Jess Killer', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(23, 28, 0, '', 0.00, 'f', '01-08-1983', 'Ken', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Kelly Chen', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(24, 29, 0, '', 0.00, 'f', '01-07-1970', 'Lily', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Angela Lindsay', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(25, 30, 0, '', 0.00, 'f', '01-01-1980', 'Lusi', '', 0, 0, 0, '', 0, '', '', '', '', 0, '', 0, '', 'employer', 'Lily Clipton', '', '', 'HOST Plus', '', '', '', '', '', '', '', '', 0, '', '["1","2"]', '["8","13","6","14"]', ''),
(26, 1, 0, '', 1.40, 'm', '', '', '', 0, 0, 1, 'Single', 1, 'HELP + SFSS', '', '', '', 1, '12 345 567 789', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '["8","10","11","1","4"]', '{"4":["27","28","29","30","31"]}');

-- --------------------------------------------------------

--
-- Table structure for table `user_staff_availability`
--

CREATE TABLE `user_staff_availability` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `monday` text NOT NULL,
  `tuesday` text NOT NULL,
  `wednesday` text NOT NULL,
  `thursday` text NOT NULL,
  `friday` text NOT NULL,
  `saturday` text NOT NULL,
  `sunday` text NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_staff_picture`
--

CREATE TABLE `user_staff_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `hero` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
