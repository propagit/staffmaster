-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2014 at 05:29 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
-- Table structure for table `attribute_departments`
--

CREATE TABLE `attribute_departments` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_uniforms`
--

CREATE TABLE `attribute_uniforms` (
  `uniform_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`uniform_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `status`, `is_admin`, `is_staff`, `is_client`, `access_level`, `email_address`, `username`, `password`, `title`, `first_name`, `last_name`, `full_name`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `country`, `mobile`, `last_signed_in_on`, `created_on`, `modified_on`) VALUES
(1, 0, 1, 0, 0, 0, 'propagate.au@gmail.com', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Mr', 'Pro', 'Gate', 'Pro Pa Gate', '20A Macquaire St', 'Prahran', 'Melbourne', 'VIC', '3181', '', '', '', '2014-02-06 17:23:21', '2014-02-06 06:22:44', '0000-00-00 00:00:00');




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
  `department_id` int(11) NOT NULL,
  `external_staff_id` varchar(20) NOT NULL,
  `rating` decimal(10,2) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `role` varchar(100) NOT NULL,
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
  `f_abn_1` varchar(11) NOT NULL,
  `f_abn_2` varchar(11) NOT NULL,
  `f_abn_3` varchar(11) NOT NULL,
  `f_tfn_1` varchar(5) NOT NULL,
  `f_tfn_2` varchar(5) NOT NULL,
  `f_tfn_3` varchar(5) NOT NULL,
  `s_choice` varchar(100) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_employee_id` varchar(100) NOT NULL,
  `s_tfn_1` varchar(10) NOT NULL,
  `s_tfn_2` varchar(10) NOT NULL,
  `s_tfn_3` varchar(10) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
