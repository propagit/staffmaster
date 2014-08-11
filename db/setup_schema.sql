-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2014 at 08:03 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

--
-- Database: `staff_master`
--


--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `system_credits` bigint(20) NOT NULL,
  `sms_credits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`system_credits`) VALUES
(100);


-- --------------------------------------------------------

--
-- Table structure for table `attribute_availability`
--

CREATE TABLE IF NOT EXISTS `attribute_availability` (
  `availability_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`availability_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_groups`
--

CREATE TABLE IF NOT EXISTS `attribute_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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


-- --------------------------------------------------------

--
-- Table structure for table `attribute_payrates`
--

CREATE TABLE IF NOT EXISTS `attribute_payrates` (
  `payrate_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '-1: deleted',
  PRIMARY KEY (`payrate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_payrate_data`
--

CREATE TABLE IF NOT EXISTS `attribute_payrate_data` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `payrate_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0: staff, 1: client',
  `day` int(11) NOT NULL COMMENT '1: moday, 7: sunday',
  `hour` int(11) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `group` VARCHAR(100) NOT NULL ,
  `color` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_roles`
--

CREATE TABLE IF NOT EXISTS `attribute_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_uniforms`
--

CREATE TABLE IF NOT EXISTS `attribute_uniforms` (
  `uniform_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`uniform_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_venues`
--

CREATE TABLE IF NOT EXISTS `attribute_venues` (
  `venue_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(100) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`venue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `brief`
--

CREATE TABLE IF NOT EXISTS `brief` (
  `brief_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 inactive, 1 active',
  `encoded_url` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`brief_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE IF NOT EXISTS `company_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_logo` varchar(200) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `suburb` varchar(200) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `website` varchar(200) NOT NULL,
  `telephone` varchar(200) NOT NULL,
  `fax` varchar(200) NOT NULL,
  `website_account` varchar(200) NOT NULL,
  `abn_acn` varchar(20) NOT NULL,
  `bank_account_name` varchar(200) NOT NULL,
  `bank_account_no` varchar(200) NOT NULL,
  `bank_bsb` varchar(20) NOT NULL,
  `accept_cc` INT NOT NULL DEFAULT '0',
  `accept_cc_msg` VARCHAR(255) NOT NULL DEFAULT '',
  `super_fund_name` varchar(200) NOT NULL,
  `super_product_id` varchar(200) NOT NULL,
  `super_fund_phone` varchar(200) NOT NULL,
  `super_fund_website` varchar(200) NOT NULL,
  `term_and_conditions` text NOT NULL,
  `email_c_name` varchar(200) NOT NULL,
  `email_c_address` varchar(200) NOT NULL,
  `email_c_suburb` varchar(200) NOT NULL,
  `email_c_state` varchar(200) NOT NULL,
  `email_c_postcode` varchar(200) NOT NULL,
  `email_c_country` varchar(200) NOT NULL,
  `email_c_telephone` varchar(200) NOT NULL,
  `email_c_fax` varchar(200) NOT NULL,
  `email_c_email` varchar(200) NOT NULL,
  `email_c_website` varchar(200) NOT NULL,
  `email_s_facebook` varchar(200) NOT NULL,
  `email_s_twitter` varchar(200) NOT NULL,
  `email_s_linkedin` varchar(200) NOT NULL,
  `email_s_google` varchar(200) NOT NULL,
  `email_s_youtube` varchar(200) NOT NULL,
  `email_s_instagram` varchar(200) NOT NULL,
  `email_common_text` text NOT NULL,
  `email_background_colour` varchar(200) NOT NULL,
  `email_font_colour` varchar(200) NOT NULL,
  `email_font` varchar(300) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


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
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `admin_only` TINYINT NOT NULL DEFAULT '0',
  `label` varchar(255) DEFAULT NULL,
  `placeholder` varchar(255) DEFAULT '',
  `inline` enum('true','false') NOT NULL DEFAULT 'false',
  `multiple` enum('true','false') NOT NULL DEFAULT 'false',
  `attributes` text NOT NULL,
  `field_order` tinyint(4) NOT NULL COMMENT 'order of the form',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `email_merge_fields`
--

CREATE TABLE IF NOT EXISTS `email_merge_fields` (
  `merge_field_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email_template_id` bigint(20) NOT NULL,
  `merge_label` varchar(255) NOT NULL,
  `merge_field` varchar(255) NOT NULL,
  `merge_order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`merge_field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Dumping data for table `email_merge_fields`
--

INSERT INTO `email_merge_fields` (`merge_field_id`, `email_template_id`, `merge_label`, `merge_field`, `merge_order`) VALUES
(1, 1, 'Staff First Name', '{FirstName}', 1),
(2, 1, 'Staff Family Name', '{FamilyName}', 2),
(3, 1, 'Company Name', '{CompanyName}', 3),
(4, 1, 'System URL', '{SystemURL}', 7),
(5, 1, 'Username', '{UserName}', 5),
(6, 1, 'Password', '{Password}', 6),
(7, 2, 'Staff First Name', '{FirstName}', 1),
(8, 2, 'Staff Family Name', 'FamilyName}', 2),
(9, 2, 'Roster', '{Roster}', 3),
(10, 3, 'Staff First Name', '{FirstName}', 1),
(11, 3, 'Staff Family Name', '{FamilyName}', 2),
(12, 3, 'System URL', '{SystemURL}', 5),
(13, 3, 'Selected Shifts', '{SelectedShifts}', 4),
(14, 6, 'Staff First Name', '{FirstName}', 1),
(15, 6, 'Staff Family Name', '{FamilyName}', 2),
(16, 6, 'Company Name', '{CompanyName}', 3),
(17, 6, 'System URL', '{SystemURL}', 7),
(18, 6, 'Username', '{UserName}', 5),
(19, 6, 'Password', '{Password}', 6),
(20, 4, 'Staff First Name', '{FirstName}', 1),
(21, 4, 'Staff Family Name', '{FamilyName}', 2),
(22, 4, 'Company Name', '{CompanyName}', 3),
(23, 4, 'System URL', '{SystemURL}', 6),
(24, 4, 'Shift Info', '{ShiftInfo}', 5),
(25, 7, 'Client Contact Name', '{ClientContactName}', 1),
(26, 7, 'Client Company Name', '{ClientCompanyName}', 2),
(27, 7, 'Invoice Number', '{InvoiceNumber}', 3),
(28, 7, 'Amount Due', '{AmountDue}', 4),
(29, 7, 'Due Date', '{DueDate}', 5),
(30, 7, 'Company Name', '{CompanyName}', 6),
(31, 7, 'Issue Date', '{IssueDate}', 7),
(32, 7, 'System URL', '{SystemURL}', 8),
(33, 2, 'System URL', '{SystemURL}', 4),
(34, 9, 'Staff First Name', '{FirstName}', 1),
(35, 9, 'Staff Family Name', '{FamilyName}', 2),
(36, 9, 'Company Name', '{CompanyName}', 3),
(37, 9, 'System URL', '{SystemURL}', 4),
(38, 9, 'Brief URL', '{BriefURL}', 5),
(39, 5, 'Staff First Name', '{FirstName}', 1),
(40, 5, 'Staff Family Name', '{FamilyName}', 2),
(41, 5, 'Company Name', '{CompanyName}', 3),
(42, 5, 'System URL', '{SystemURL}', 4),
(43, 5, 'Shift Info', '{ShiftInfo}', 5),
(44, 2, 'Company Name', '{CompanyName}', 5),
(45, 3, 'Company Name', '{CompanyName}', 5);


-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `template_content` text NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `default_template` text NOT NULL COMMENT 'this is the default template which will be used to restore to default template',
  `auto_send` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'defines weather or not the email is automatically send',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`email_template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`email_template_id`, `template_name`, `template_content`, `email_from`, `email_subject`, `default_template`, `auto_send`, `created`, `modified`) VALUES
(1, 'Welcome Staff', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Welcome to the&nbsp{CompanyName}&nbspteam</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We are thrilled to have you joint our team. Before completing your first shift with us we need you to logon to your staff account and complete your online induction.&nbsp</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Completing your induction ensures that your details in the system are accurate, you get paid on time and can apply for shifts as they become available.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To log on to your staff account click this link {SystemURL}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">and login with the following details</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">User Name &nbsp &nbsp {UserName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Password &nbsp &nbsp &nbsp {Password}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We look forward to working with you.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n', 'team@staffbooks.com', 'Welcome To Our Team', '', 'no', '2014-03-19 06:42:01', '2014-03-19 06:42:01'),
(2, 'Roster Update', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has recently been updated, please login to your staff account to confirm all shifts we have you working on.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your current roster is as follow:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n', 'team@staffbooks.com', 'Roster Update', '', 'no', '2014-03-14 06:08:44', '2014-03-14 06:08:44'),
(3, 'Apply For Shifts', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We have just updated our system with a series of jobs. Please login to your staff account {SystemURL}&nbspand apply for jobs you would like to work on.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Some of the new shifts that have become available include:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{SelectedShifts}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind Regards</span></span></p>\r\n', 'team@staffbooks.com', 'Apply For Shifts', '', 'no', '2014-03-14 06:09:06', '2014-03-14 06:09:06'),
(4, 'Shift Reminder', '<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">Dear&nbsp{FirstName}</span></span></p>\r\n\r\n<p><span style="font-family:arial,sans-serif&#59 font-size:9.0pt">This is a work reminder that you are working for the following shifts:</span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">{ShiftInfo}</span></span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">Please contact us immeadiatly if you have any questions regarding your shift.&nbsp</span></span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">Kind regards</span></span></p>', 'team@staffbooks.com', 'Shift Reminder', '', 'no', '2014-03-20 06:32:37', '2014-03-20 06:32:37'),
(5, 'Work Confirmation', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">You have been confirmed to work on the below job. If for any reason you can&#39t work this shift please contact us immediately.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{ShiftInfo}</span></span></p>', 'team@staffbooks.com', 'Work Confirmation', '', 'no', '2014-03-14 06:09:20', '2014-03-14 06:09:20'),
(6, 'Forgot Password', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp{FirstName}</span></span></p>\r\n\r\n<p>We received a forgotten password request from you.</p>\r\n\r\n<p>Your new login details are as follows:</p>\r\n\r\n<p>Username:&nbsp{UserName}</p>\r\n\r\n<p>Password:&nbsp{Password}</p>\r\n\r\n<p>&nbsp</p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif&#59 font-size:12px">Please contact us immeadiatly if you did not request this password request.&nbsp</span></p>\r\n\r\n<p>&nbsp</p>\r\n', 'team@staffbooks.com', 'Password Reset', '', 'no', '2014-03-20 04:47:51', '2014-03-20 04:47:51'),
(7, 'Client Invoice', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp{ClientContactName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please find attached an invoice from&nbsp{CompanyName} for recent services for {ClientCompanyName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">The invoice details are as follows:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Invoice Number: &nbsp {InvoiceNumber}<br />\r\nAmount Due: &nbsp &nbsp &nbsp &nbsp ${AmountDue}<br />\r\nDue Date: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp{DueDate} &nbsp&nbsp</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">A downloadable invoice is attached or you can login to your member account to retrieve a copy of this invoice at any time.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{CompanyName}</span></span></p>\r\n', 'team@staffbooks.com', '{CompanyName} Invoice Issued - {IssueDate}', '', 'no', '2014-03-21 06:12:06', '2014-03-21 06:12:06'),
(8, 'Client Quote', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has been updated and requires your attention.&nbsp</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please login to your account to confirm your shifts. Your Current Roster is as follows:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please contact us immeadiatly if you have any questions regarding your roster.&nbsp</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To Login to your account click here</span></span></p>\r\n', 'team@staffbooks.com', 'Client Quote', '', 'no', '2014-03-14 06:09:40', '2014-03-14 06:09:40'),
(9, 'Brief', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">You can view the brief from this url.&nbsp{BriefURL}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Regards</span></span></p>\r\n\r\n<p>&nbsp</p>', 'team@staffbooks.com', 'Job Brief', '', 'no', '2014-04-07 06:27:00', '2014-04-07 06:27:00');


-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `expense_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `paid_on` datetime DEFAULT NULL,
  `job_id` bigint(20) NOT NULL,
  `timesheet_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `staff_cost` decimal(10,2) NOT NULL,
  `client_cost` decimal(10,2) NOT NULL,
  `tax` tinyint(4) NOT NULL,
  PRIMARY KEY (`expense_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Table structure for table `export_templates`
--

DROP TABLE IF EXISTS `export_templates`;
CREATE TABLE IF NOT EXISTS `export_templates` (
  `export_id` int(11) NOT NULL AUTO_INCREMENT,
  `target` varchar(100) NOT NULL,
  `object` varchar(20) NOT NULL,
  `level` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`export_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `export_templates`
--

INSERT INTO `export_templates` (`export_id`, `target`, `object`, `level`, `name`, `status`) VALUES
(1, 'xero', 'invoice', 'item', 'Xero (Item Per Line)', 0),
(3, '', 'payrun_tfn', 'shift', 'Default (Shift Per Line)', 2),
(4, '', 'payrun_tfn', 'staff', 'Default (Staff Per Line)', 3),
(5, '', 'payrun_abn', 'shift', 'ABN Supplier Export', 0),
(7, '', 'staff', '', 'Default', 0),
(8, '', 'invoice', 'invoice', 'Default (Invoice Per Line)', 0),
(9, '', 'expense', '', 'Staff Expense Export ', 0),
(10, 'shoebooks', 'staff', '', 'Shoebooks', 0),
(11, 'shoebooks', 'payrun_tfn', 'pay_rate', 'Shoebooks (Pay Rate Per Line)', 1),
(13, 'shoebooks', 'invoice', 'item', 'Shoebooks (Item Per Line)', 1),
(14, 'shoebooks', 'payrun_abn', 'shift', 'Shoebooks - ABN Export', 1),
(15, 'shoebooks', 'expense', '', 'Shoebooks - Staff Expense Export ', 1),
(16, 'shoebooks', 'invoice', 'shift', 'Shoebooks (Shift Per Line)', 1),
(17, 'myob', 'payrun_tfn', 'shift', 'MYOB (Shift Per Line)', 3),
(18, 'myob', 'invoice', 'shift', 'MYOB (Shift Per Line)', 1),
(19, 'myob', 'staff', '', 'MYOB', 0),
(20, 'xero', 'invoice', 'shift', 'Xero (Shift Per Line)', 0),
(21, '', 'client', '', 'Default', 0),
(22, 'myob', 'client', '', 'MYOB', 0),
(23, 'shoebooks', 'invoice', 'pay_rate', 'Shoebooks (Pay Rate Per Line)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `export_template_data`
--

DROP TABLE IF EXISTS `export_template_data`;
CREATE TABLE IF NOT EXISTS `export_template_data` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `export_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=470 ;

--
-- Dumping data for table `export_template_data`
--

INSERT INTO `export_template_data` (`field_id`, `export_id`, `order`, `title`, `value`) VALUES
(81, 7, 0, 'Title', '{title}'),
(82, 7, 1, 'First Name', '{first_name}'),
(83, 7, 2, 'Last Name', '{last_name}'),
(84, 7, 3, 'Email', '{email}'),
(85, 7, 4, 'Address', '{address}'),
(86, 7, 5, 'Suburb', '{suburb}'),
(87, 7, 6, 'City', '{city}'),
(88, 7, 7, 'State', '{state}'),
(89, 7, 8, 'Postcode', '{postcode}'),
(90, 7, 9, 'Country', '{country}'),
(91, 7, 10, 'Phone', '{phone}'),
(92, 7, 11, 'Rating', '{rating}'),
(94, 7, 12, 'External Staff ID', '{external_id}'),
(95, 7, 13, 'Gender', '{gender}'),
(96, 7, 14, 'Date of birth', '{dob}'),
(99, 7, 15, 'Emergency Contact Person', '{emergency_contact}'),
(100, 7, 16, 'Emergency Phone', '{emergency_phone}'),
(101, 7, 18, 'BSB', '{bsb}'),
(104, 7, 17, 'Bank Account Name', '{account_name}'),
(105, 7, 19, 'Bank Account Number', '{account_number}'),
(106, 7, 20, 'Employed As', '{employed_as}'),
(107, 7, 21, 'ABN Number', '{abn_number}'),
(108, 7, 22, 'TFN Number', '{tfn_number}'),
(109, 7, 25, 'Super Fund Name', '{super_fund_name}'),
(110, 7, 23, 'Choice of superannuation', '{super_choice}'),
(111, 7, 24, 'Super Employee ID Number', '{super_employee_id}'),
(112, 7, 26, 'Super Membership Number', '{super_membership_number}'),
(117, 10, 0, 'EmployeeID', '{internal_id}'),
(118, 10, 1, 'FirstName', '{first_name}'),
(119, 10, 2, 'Surname', '{last_name}'),
(120, 10, 3, 'dtmBirthDate', '{dob}'),
(121, 10, 4, 'TFN', '{tfn_number}'),
(122, 10, 5, 'Address1', '{address}'),
(123, 10, 6, 'Address2', ''),
(124, 10, 7, 'City', '{city}'),
(125, 10, 8, 'State', '{state}'),
(126, 10, 9, 'PostCode', '{postcode}'),
(127, 10, 10, 'Country', '{country}'),
(128, 10, 11, 'Notes', ''),
(129, 10, 12, 'Phone1', '{phone}'),
(130, 10, 13, 'Phone2', ''),
(131, 10, 14, 'PhoneW', ''),
(132, 10, 15, 'PhoneH', ''),
(133, 10, 16, 'Fax', ''),
(134, 10, 17, 'Mobile', '{mobile}'),
(135, 10, 18, 'Email', '{email}'),
(136, 10, 19, 'Web', ''),
(140, 10, 25, 'strBankNumber', '{bsb}'),
(141, 10, 26, 'strBankAccount', '{account_number}'),
(142, 10, 27, 'strExtraVendorID', '{super_employee_id}'),
(143, 10, 28, 'strExtraFundName', '{super_fund_name}'),
(144, 10, 29, 'strExtraFundNumber', '{super_membership_number}'),
(145, 10, 23, 'strEmploymentType', ''),
(146, 10, 24, 'strBankName', ''),
(147, 10, 20, 'Title', ''),
(148, 10, 21, 'strDepartment', ''),
(149, 10, 22, 'dtmDateHired', '{joined_date}'),
(187, 11, 0, 'Group', '{external_staff_id}'),
(191, 11, 1, 'EmployeeID', '{external_staff_id}'),
(192, 11, 2, 'PeriodStart', '{pay_run_date_from}'),
(193, 11, 3, 'PeriodFinish', '{pay_run_date_to}'),
(195, 11, 5, 'Date', '{job_date}'),
(196, 11, 6, 'DivID', ''),
(197, 11, 7, 'JobID', ''),
(202, 11, 10, 'strEarningID', '{pay_rate}'),
(203, 11, 11, 'Rate', '{pay_rate_amount}'),
(204, 11, 12, 'Description', '{job_name}    {start_time} -  {finish_time}    {break}'),
(205, 3, 205, 'Group', '{external_staff_id}'),
(206, 3, 206, 'EmployeeID', '{external_staff_id}'),
(207, 3, 207, 'PeriodStart', '{pay_run_date_from}'),
(208, 3, 208, 'PeriodFinish', '{pay_run_date_to}'),
(209, 3, 209, 'DatePayable', '{payable_date}'),
(210, 3, 210, 'Date', '{job_date}'),
(211, 3, 211, 'DivID', ''),
(212, 3, 212, 'JobID', ''),
(213, 3, 213, 'Units', '{hours}'),
(214, 3, 214, 'strEarningID', '{pay_rate}'),
(215, 3, 215, 'Description', '{job_name}    {start_time} -  {finish_time}   {break}'),
(216, 4, 0, 'Internal Staff ID', '{internal_staff_id}'),
(217, 4, 1, 'External Staff ID', '{external_staff_id}'),
(218, 4, 2, 'Pay Run Date From', '{pay_run_date_from}'),
(219, 4, 3, 'Pay Run Date To', '{pay_run_date_to}'),
(221, 4, 6, 'Hours', '{hours}'),
(222, 4, 7, 'Total Amount', '{total_amount}'),
(223, 4, 5, 'Pay Rate', '{pay_rate}'),
(224, 13, 0, 'Group', '{invoice_id}'),
(225, 13, 1, 'CustomerID', '{external_client_id}'),
(226, 13, 2, 'Date', '{issued_date}'),
(227, 13, 3, 'Description', '{item_description}'),
(228, 13, 4, 'AccountID', ''),
(229, 13, 5, 'QtyShipped', '1'),
(231, 13, 8, 'Amount', '{ex_tax_amount}'),
(232, 13, 9, 'JobID', ''),
(233, 13, 10, 'DivID', ''),
(234, 13, 11, 'CustomerPO', '{po_number}'),
(236, 1, 1, 'EmailAddress', '{client_email}'),
(237, 1, 2, 'POAddressLine1', '{client_address}'),
(238, 1, 3, 'POAddressLine2', '{client_suburb}'),
(239, 1, 4, 'POAddressLine3', ''),
(240, 1, 5, 'POAddressLine4', ''),
(241, 1, 6, 'POCity', '{client_city}'),
(242, 1, 7, 'PORegion', '{client_state}'),
(243, 1, 8, 'POPostalCode', '{client_postcode}'),
(244, 1, 9, 'POCountry', '{client_country}'),
(245, 1, 10, 'InvoiceNumber', '{invoice_id}'),
(246, 1, 11, 'Reference', '{po_number}'),
(247, 1, 12, 'InvoiceDate', '{issued_date}'),
(248, 1, 13, 'DueDate', '{due_date}'),
(249, 1, 14, 'Total', '{inc_tax_amount}'),
(250, 1, 15, 'InventoryItemCode', ''),
(251, 1, 16, 'Description', '{item_description}'),
(252, 1, 17, 'Quantity', '1'),
(253, 1, 18, 'UnitAmount', '{ex_tax_amount}'),
(257, 1, 24, 'TaxAmount', '{tax_amount}'),
(258, 1, 25, 'TrackingName1', ''),
(259, 1, 27, 'TrackingName2', ''),
(260, 1, 26, 'TrackingOption1', ''),
(261, 1, 28, 'TrackingOption2', ''),
(262, 1, 29, 'Currency', 'AUD'),
(264, 11, 4, 'DateTo', '{payable_date}'),
(265, 11, 9, 'Hours', '{hours}'),
(266, 4, 266, 'DatePayable', '{payable_date}'),
(268, 13, 7, 'Taxable', '{tax_type}'),
(269, 8, 0, 'Internal Client ID', '{internal_client_id}'),
(270, 8, 1, 'External Client ID', '{external_client_id}'),
(271, 8, 4, 'Issued Date', '{issued_date}'),
(272, 8, 5, 'Due Date', '{due_date}'),
(273, 8, 6, 'Invoice Description', '{invoice_description}'),
(274, 8, 7, 'Tax Amount', '{tax_amount}'),
(275, 8, 8, 'Ex Tax Amount', '{ex_tax_amount}'),
(276, 8, 9, 'Inc Tax Amount', '{inc_tax_amount}'),
(277, 8, 10, 'PO Number', '{po_number}'),
(278, 8, 3, 'Client Contact Name', '{client_contact_name}'),
(279, 8, 2, 'Client Company Name', '{client_company_name}'),
(280, 9, 280, 'Job Date', '{job_date}'),
(281, 9, 281, 'Job Name', '{job_name}'),
(282, 9, 282, 'First Name', '{staff_first_name}'),
(283, 9, 283, 'Last Name', '{staff_last_name}'),
(284, 9, 284, 'Tax Amount', '{tax_amount}'),
(285, 9, 285, 'Ex Tax Amount', '{ex_tax_amount}'),
(286, 9, 286, 'Inc Tax Amount', '{inc_tax_amount}'),
(287, 9, 287, 'Paid Date/Time', '{paid_on}'),
(288, 5, 0, 'Internal Staff Id', '{internal_staff_id}'),
(289, 5, 1, 'External Staff Id', '{external_staff_id}'),
(290, 5, 2, 'Staff Name', '{staff_name}'),
(292, 5, 7, 'Hours', '{hours}'),
(293, 5, 8, 'Pay Rate', '{pay_rate}'),
(295, 5, 5, 'Start Time', '{start_time}'),
(296, 5, 6, 'Finish Time', '{finish_time}'),
(297, 14, 0, 'Group', '{internal_staff_id}'),
(298, 14, 1, 'VendorID', '{external_staff_id}'),
(299, 14, 2, 'Date', '{pay_run_date}'),
(300, 14, 4, 'Description', '{job_name}    {start_time} -  {finish_time}   {break}'),
(301, 14, 6, 'QtyReceived', '1'),
(303, 14, 8, 'Amount', '{ex_tax_amount}'),
(304, 14, 5, 'AccountID', ''),
(305, 14, 7, 'Taxable', ''),
(306, 14, 3, 'strVendorOrderNumber', ''),
(307, 14, 307, 'JobID', ''),
(308, 14, 308, 'PONumber', ''),
(309, 14, 309, 'ProductID', ''),
(310, 14, 310, 'DivID', ''),
(311, 14, 311, 'CustomerPO', ''),
(312, 15, 312, 'Group', '{internal_staff_id}'),
(313, 15, 313, 'VendorID', '{external_staff_id}'),
(314, 15, 314, 'Date', '{job_date}'),
(315, 15, 315, 'strVendorOrderNumber', ''),
(316, 15, 316, 'Description', '{description}'),
(317, 15, 317, 'AccountID', ''),
(318, 15, 318, 'QtyReceived', '1'),
(319, 15, 319, 'Taxable', '{taxable}'),
(320, 15, 320, 'Amount', '{ex_tax_amount}'),
(321, 15, 321, 'JobID', ''),
(322, 15, 322, 'PONumber', ''),
(323, 15, 323, 'ProductID', ''),
(324, 15, 324, 'DivID', ''),
(325, 15, 325, 'CustomerPO', ''),
(326, 16, 0, 'Group', '{invoice_id}'),
(327, 16, 1, 'CustomerID', '{external_client_id}'),
(328, 16, 2, 'Date', '{job_date}'),
(330, 16, 6, 'AccountID', ''),
(331, 16, 7, 'QtyShipped', '{hours}'),
(332, 16, 8, 'Taxable', '{tax_type}'),
(333, 16, 9, 'Amount', '{ex_tax_amount}'),
(334, 16, 10, 'JobID', ''),
(335, 16, 11, 'DivID', ''),
(336, 16, 12, 'CustomerPO', '{po_number}'),
(338, 16, 4, 'Description', '{item_description}  {staff_name}  {start_time}  {finish_time}  {break}'),
(339, 17, 0, 'Employee Co./Last Name', '{staff_last_name}'),
(340, 17, 1, 'Employee First Name', '{staff_first_name}'),
(341, 17, 2, 'Payroll Category', '{pay_rate}'),
(342, 17, 3, 'Job', '{job_name}'),
(343, 17, 4, 'Customer Co./Last Name', '{client_company_name}'),
(344, 17, 5, 'Customer First Name', ''),
(345, 17, 6, 'Notes', ''),
(347, 17, 9, 'Units', '{hours}'),
(349, 17, 11, 'Employee Record ID', '{external_staff_id}'),
(350, 17, 12, 'Start/Stop Time', '{start_time}  {finish_time}'),
(352, 17, 14, 'Customer Record ID', '{external_client_id}'),
(353, 17, 8, 'Date', '{job_date}'),
(354, 18, 354, 'Co./Last Name', '{client_company_name}'),
(355, 18, 355, 'First Name', ''),
(356, 18, 356, 'Addr 1 - Line 1', '{client_address}'),
(357, 18, 357, '           - Line 2', '{client_suburb}'),
(358, 18, 358, '           - Line 3', '{client_city}'),
(359, 18, 359, '           - Line 4', '{client_state}'),
(360, 18, 360, 'Inclusive', ''),
(361, 18, 361, 'Invoice #', '{invoice_id}'),
(362, 18, 362, 'Date', '{issued_date}'),
(363, 18, 363, 'Customer PO', '{po_number}'),
(364, 18, 364, 'Ship Via', ''),
(365, 18, 365, 'Delivery Status', 'P'),
(366, 18, 366, 'Amount', '{ex_tax_amount}'),
(367, 18, 367, 'Inc-Tax Amount', '{inc_tax_amount}'),
(368, 18, 368, 'Job', ''),
(369, 18, 369, 'Comment', ''),
(370, 18, 370, 'Journal Memo', ''),
(371, 18, 371, 'Salesperson Last Name', ''),
(372, 18, 372, 'Salesperson First Name', ''),
(373, 18, 373, 'Shipping Date', ''),
(374, 18, 374, 'Referral Source', ''),
(375, 18, 375, 'Tax Code', '{tax_type}'),
(377, 18, 377, 'GST Amount', '{tax_amount}'),
(378, 18, 378, 'Description', '{item_description}'),
(379, 19, 0, 'Co./Last Name', '{last_name}'),
(380, 19, 1, 'First Name', '{first_name}'),
(381, 19, 2, 'Card ID', '{external_id}'),
(382, 19, 3, 'Addr 1 - Line 1', '{address}'),
(383, 19, 4, '- Line 2', ''),
(384, 19, 5, '- City', '{city}'),
(385, 19, 6, '- State', '{state}'),
(386, 19, 7, '- Postcode', '{postcode}'),
(387, 19, 8, '- Country', '{country}'),
(388, 19, 9, '- Phone # 1', '{phone}'),
(389, 19, 10, '- Phone # 2', '{mobile}'),
(390, 19, 11, '- Email', '{email}'),
(391, 19, 12, '- Salutation', '{title}'),
(392, 19, 13, 'BSB', '{bsb}'),
(393, 19, 14, 'Account Number', '{account_number}'),
(394, 19, 15, 'Account Name', '{account_name}'),
(395, 19, 16, 'Date of Birth', '{dob}'),
(396, 19, 18, 'Superannuation Fund', '{super_fund_name}'),
(397, 19, 19, 'Employee Membership #', '{super_membership_number}'),
(399, 19, 20, 'Tax File Number', '{tfn_number}'),
(400, 19, 17, 'Gender', '{gender}'),
(401, 1, 0, 'ContactName', '{client_company_name}'),
(402, 1, 20, 'AccountCode', '200'),
(403, 1, 21, 'Discount', ''),
(404, 1, 23, 'TaxType', 'GST on Income'),
(405, 20, 1, 'EmailAddress', '{client_email}'),
(406, 20, 2, 'POAddressLine1', '{client_address}'),
(407, 20, 3, 'POAddressLine2', '{client_suburb}'),
(408, 20, 4, 'POAddressLine3', ''),
(409, 20, 5, 'POAddressLine4', ''),
(410, 20, 6, 'POCity', '{client_city}'),
(411, 20, 7, 'PORegion', '{client_state}'),
(412, 20, 8, 'POPostalCode', '{client_postcode}'),
(413, 20, 9, 'POCountry', '{client_country}'),
(414, 20, 10, 'InvoiceNumber', '{invoice_id}'),
(415, 20, 11, 'Reference', '{po_number}'),
(416, 20, 12, 'InvoiceDate', '{issued_date}'),
(417, 20, 13, 'DueDate', '{due_date}'),
(419, 20, 14, 'InventoryItemCode', ''),
(421, 20, 16, 'Quantity', '1'),
(423, 20, 20, 'Discount', ''),
(424, 20, 22, 'TaxAmount', '{tax_amount}'),
(425, 20, 23, 'TrackingName1', ''),
(426, 20, 25, 'TrackingName2', ''),
(427, 20, 24, 'TrackingOption1', ''),
(428, 20, 26, 'TrackingOption2', ''),
(429, 20, 27, 'Currency', 'AUD'),
(430, 20, 0, 'ContactName', '{client_company_name}'),
(431, 20, 19, 'AccountCode', '200'),
(433, 20, 21, 'TaxType', 'GST on Income'),
(434, 20, 15, 'Description', '{venue}   {start_time}   {finish_time}'),
(436, 20, 17, 'UnitAmount', '{ex_tax_amount}'),
(437, 21, 0, 'Company Name', '{company_name}'),
(438, 21, 1, 'Contact Name', '{contact_name}'),
(439, 21, 2, 'Address', '{address}'),
(440, 21, 4, 'City', '{city}'),
(441, 21, 3, 'Suburb', '{suburb}'),
(442, 21, 442, 'Postcode', '{postcode}'),
(443, 21, 443, 'State', '{state}'),
(444, 21, 444, 'Country', '{country}'),
(445, 21, 445, 'Email Address', '{email}'),
(446, 21, 446, 'Internal ID', '{internal_id}'),
(447, 21, 447, 'External ID', '{external_id}'),
(449, 22, 449, 'Co./Last Name', '{company_name}'),
(450, 22, 450, 'First Name', '{contact_name}'),
(451, 22, 451, 'Card ID', '{external_id}'),
(452, 22, 452, 'Addr 1 - Line 1', '{address}'),
(453, 22, 453, '           - Line 2', '{suburb}'),
(454, 22, 454, '           - City', '{city}'),
(455, 22, 455, '           - State', '{state}'),
(456, 22, 456, '           - Postcode', '{postcode}'),
(457, 22, 457, '           - Country', '{country}'),
(458, 22, 458, 'A.B.N.', '{abn}'),
(459, 23, 0, 'Group', '{invoice_id}'),
(460, 23, 1, 'CustomerID', '{external_client_id}'),
(461, 23, 2, 'Date', '{job_date}'),
(462, 23, 3, 'Description', '{item_description}   {staff_name}   {start_time}   {finish_time}   {break}'),
(463, 23, 4, 'AccountID', ''),
(464, 23, 5, 'QtyShipped', '{hours}'),
(465, 23, 6, 'Taxable', '{tax_type}'),
(466, 23, 8, 'JobID', ''),
(467, 23, 9, 'DivID', ''),
(468, 23, 10, 'CustomerPO', '{po_number}'),
(469, 23, 7, 'Amount', '{pay_rate_amount}');

-- --------------------------------------------------------

--
-- Table structure for table `export_template_fields`
--

DROP TABLE IF EXISTS `export_template_fields`;
CREATE TABLE IF NOT EXISTS `export_template_fields` (
  `field_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `field_order` bigint(20) NOT NULL DEFAULT '0',
  `object` varchar(20) NOT NULL,
  `level` varchar(20) NOT NULL,
  `value` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=215 ;

--
-- Dumping data for table `export_template_fields`
--

INSERT INTO `export_template_fields` (`field_id`, `field_order`, `object`, `level`, `value`, `label`) VALUES
(1, 0, 'payrun_tfn', 'pay_rate', 'job_date', 'Job Date'),
(4, 0, 'payrun_tfn', 'pay_rate', 'hours', 'Hours'),
(5, 0, 'payrun_tfn', 'pay_rate', 'pay_rate', 'Pay Rate Name'),
(6, 0, 'payrun_tfn', 'pay_rate', 'pay_rate_amount', 'Pay Rate Amount'),
(7, 0, 'payrun_tfn', 'pay_rate', 'internal_staff_id', 'Internal Staff ID'),
(8, 0, 'payrun_tfn', 'pay_rate', 'external_staff_id', 'External Staff ID'),
(9, 0, 'payrun_tfn', 'pay_rate', 'job_name', 'Job Name'),
(10, 0, 'payrun_tfn', 'pay_rate', 'staff_name', 'Staff Name'),
(11, 0, 'payrun_tfn', 'pay_rate', 'job_id', 'Job ID'),
(12, 0, 'payrun_tfn', 'pay_rate', 'pay_run_date_from', 'Pay Run Date From'),
(13, 0, 'payrun_tfn', 'pay_rate', 'pay_run_date_to', 'Pay Run Date To'),
(14, 0, 'payrun_tfn', 'pay_rate', 'payable_date', 'Payable Date'),
(15, 0, 'payrun_tfn', 'pay_rate', 'job_day_name', 'Job Day Name'),
(19, 0, 'payrun_tfn', 'pay_rate', 'break', 'Break'),
(20, 0, 'payrun_tfn', 'pay_rate', 'start_time', 'Start Time'),
(21, 0, 'payrun_tfn', 'pay_rate', 'finish_time', 'Finish Time'),
(22, 0, 'payrun_tfn', 'shift', 'job_date', 'Job Date'),
(23, 0, 'payrun_tfn', 'shift', 'hours', 'Hours'),
(24, 0, 'payrun_tfn', 'shift', 'pay_rate', 'Pay Rate'),
(25, 0, 'payrun_tfn', 'shift', 'internal_staff_id', 'Internal Staff ID'),
(26, 0, 'payrun_tfn', 'shift', 'external_staff_id', 'External Staff ID'),
(27, 0, 'payrun_tfn', 'shift', 'job_name', 'Job Name'),
(28, 0, 'payrun_tfn', 'shift', 'staff_name', 'Staff Name'),
(29, 0, 'payrun_tfn', 'shift', 'job_id', 'Job ID'),
(30, 0, 'payrun_tfn', 'shift', 'pay_run_date_from', 'Pay Run Date From'),
(31, 0, 'payrun_tfn', 'shift', 'pay_run_date_to', 'Pay Run Date To'),
(32, 0, 'payrun_tfn', 'shift', 'payable_date', 'Payable Date'),
(33, 0, 'payrun_tfn', 'shift', 'break', 'Break'),
(34, 0, 'payrun_tfn', 'shift', 'start_time', 'Start Time'),
(35, 0, 'payrun_tfn', 'shift', 'finish_time', 'Finish Time'),
(36, 0, 'payrun_tfn', 'staff', 'hours', 'Hours'),
(37, 0, 'payrun_tfn', 'staff', 'internal_staff_id', 'Internal Staff ID'),
(38, 0, 'payrun_tfn', 'staff', 'external_staff_id', 'External Staff ID'),
(39, 0, 'payrun_tfn', 'staff', 'pay_run_date_from', 'Pay Run Date From'),
(40, 0, 'payrun_tfn', 'staff', 'pay_run_date_to', 'Pay Run Date To'),
(41, 0, 'payrun_tfn', 'staff', 'payable_date', 'Payable Date'),
(42, 0, 'payrun_tfn', 'staff', 'total_amount', 'Total Amount'),
(43, 0, 'payrun_tfn', 'staff', 'pay_rate', 'Pay Rate'),
(44, 0, 'invoice', 'item', 'internal_client_id', 'Internal Client ID'),
(45, 0, 'invoice', 'item', 'external_client_id', 'External Client ID'),
(46, 0, 'invoice', 'item', 'client_company_name', 'Client Company Name'),
(47, 0, 'invoice', 'item', 'client_address', 'Client Address'),
(48, 0, 'invoice', 'item', 'client_suburb', 'Client Suburb'),
(49, 0, 'invoice', 'item', 'client_city', 'Client City'),
(50, 0, 'invoice', 'item', 'client_postcode', 'Client Postcode'),
(51, 0, 'invoice', 'item', 'client_state', 'Client State'),
(52, 0, 'invoice', 'item', 'client_country', 'Client Country'),
(53, 0, 'invoice', 'item', 'client_contact_name', 'Client Contact Name'),
(54, 0, 'invoice', 'item', 'client_email', 'Client Email'),
(55, 0, 'invoice', 'item', 'issued_date', 'Issued Date'),
(56, 0, 'invoice', 'item', 'due_date', 'Due Date'),
(57, 0, 'invoice', 'item', 'item_description', 'Item Description'),
(58, 0, 'invoice', 'item', 'tax_type', 'Tax Type'),
(59, 0, 'invoice', 'item', 'tax_amount', 'Tax Amount'),
(60, 0, 'invoice', 'item', 'ex_tax_amount', 'Ex Tax Amount'),
(61, 0, 'invoice', 'item', 'inc_tax_amount', 'Inc Tax Amount'),
(62, 0, 'invoice', 'item', 'invoice_id', 'Invoice ID'),
(63, 0, 'invoice', 'item', 'po_number', 'PO Number'),
(64, 0, 'staff', '', 'title', 'Title'),
(65, 0, 'staff', '', 'rating', 'Rating'),
(66, 0, 'staff', '', 'first_name', 'First Name'),
(67, 0, 'staff', '', 'gender', 'Gender'),
(68, 0, 'staff', '', 'dob', 'Date of birth'),
(69, 0, 'staff', '', 'address', 'Address'),
(70, 0, 'staff', '', 'suburb', 'Suburb'),
(71, 0, 'staff', '', 'city', 'City'),
(72, 0, 'staff', '', 'postcode', 'Postcode'),
(73, 0, 'staff', '', 'state', 'State'),
(74, 0, 'staff', '', 'country', 'Country'),
(75, 0, 'staff', '', 'email', 'Email'),
(76, 0, 'staff', '', 'phone', 'Phone'),
(77, 0, 'staff', '', 'external_id', 'External Staff ID'),
(78, 0, 'staff', '', 'emergency_contact', 'Emergency Contact Person'),
(79, 0, 'staff', '', 'emergency_phone', 'Emergency Phone'),
(80, 0, 'staff', '', 'account_name', 'Bank Account Name'),
(81, 0, 'staff', '', 'bsb', 'BSB'),
(82, 0, 'staff', '', 'account_number', 'Bank Account Number'),
(83, 0, 'staff', '', 'employed_as', 'Employed As'),
(84, 0, 'staff', '', 'tfn_number', 'TFN Number'),
(85, 0, 'staff', '', 'abn_number', 'ABN Number'),
(86, 0, 'staff', '', 'super_choice', 'Choice of superannuation'),
(87, 0, 'staff', '', 'super_employee_id', 'Super Employee ID Number'),
(88, 0, 'staff', '', 'super_fund_name', 'Super Fund Name'),
(89, 0, 'staff', '', 'super_membership_number', 'Super Membership Number'),
(90, 0, 'staff', '', 'last_name', 'Last Name'),
(91, 0, 'staff', '', 'mobile', 'Mobile'),
(92, 0, 'staff', '', 'internal_id', 'Internal Staff ID'),
(93, 0, 'staff', '', 'joined_date', 'Joined Date'),
(94, 0, 'staff', '', 'status', 'Status'),
(95, 0, 'invoice', 'invoice', 'client_address', 'Client Address'),
(96, 0, 'invoice', 'invoice', 'client_city', 'Client City'),
(97, 0, 'invoice', 'invoice', 'client_company_name', 'Client Company Name'),
(98, 0, 'invoice', 'invoice', 'client_contact_name', 'Client Contact Name'),
(99, 0, 'invoice', 'invoice', 'client_country', 'Client Country'),
(100, 0, 'invoice', 'invoice', 'client_email', 'Client Email'),
(101, 0, 'invoice', 'invoice', 'client_postcode', 'Client Postcode'),
(102, 0, 'invoice', 'invoice', 'client_state', 'Client State'),
(103, 0, 'invoice', 'invoice', 'client_suburb', 'Client Suburb'),
(104, 0, 'invoice', 'invoice', 'due_date', 'Due Date'),
(105, 0, 'invoice', 'invoice', 'ex_tax_amount', 'Ex Tax Amount'),
(106, 0, 'invoice', 'invoice', 'external_client_id', 'External Client ID'),
(107, 0, 'invoice', 'invoice', 'inc_tax_amount', 'Inc Tax Amount'),
(108, 0, 'invoice', 'invoice', 'invoice_id', 'Invoice ID'),
(109, 0, 'invoice', 'invoice', 'issued_date', 'Issued Date'),
(110, 0, 'invoice', 'invoice', 'invoice_description', 'Invoice Description'),
(111, 0, 'invoice', 'invoice', 'po_number', 'PO Number'),
(112, 0, 'invoice', 'invoice', 'tax_amount', 'Tax Amount'),
(113, 0, 'invoice', 'invoice', 'internal_client_id', 'Internal Client ID'),
(114, 0, 'expense', '', 'job_date', 'Job Date'),
(115, 0, 'expense', '', 'staff_first_name', 'Staff First Name'),
(116, 0, 'expense', '', 'staff_last_name', 'Staff Last Name'),
(117, 0, 'expense', '', 'job_name', 'Job Name'),
(118, 0, 'expense', '', 'tax_amount', 'Tax Amount'),
(119, 0, 'expense', '', 'inc_tax_amount', 'Inc Tax Amount'),
(120, 0, 'expense', '', 'paid_on', 'Paid Date/Time'),
(121, 0, 'expense', '', 'ex_tax_amount', 'Ex Tax Amount'),
(122, 0, 'payrun_abn', 'shift', 'pay_run_date', 'Pay Run Date'),
(123, 0, 'payrun_abn', 'shift', 'start_time', 'Start Time'),
(124, 0, 'payrun_abn', 'shift', 'finish_time', 'Finish Time'),
(125, 0, 'payrun_abn', 'shift', 'staff_name', 'Staff Name'),
(126, 0, 'payrun_abn', 'shift', 'break', 'Break'),
(127, 0, 'payrun_abn', 'shift', 'hours', 'Hours'),
(128, 0, 'payrun_abn', 'shift', 'pay_rate', 'Pay Rate'),
(129, 0, 'payrun_abn', 'shift', 'venue', 'Venue'),
(130, 0, 'payrun_abn', 'shift', 'internal_staff_id', 'Internal Staff Id'),
(131, 0, 'payrun_abn', 'shift', 'external_staff_id', 'External Staff Id'),
(132, 0, 'payrun_abn', 'shift', 'job_name', 'Job Name'),
(133, 0, 'payrun_abn', 'shift', 'job_id', 'Job ID'),
(134, 0, 'payrun_abn', 'shift', 'taxable', 'Taxable'),
(135, 0, 'payrun_abn', 'shift', 'ex_tax_amount', 'Ex Tax Amount'),
(136, 0, 'payrun_abn', 'shift', 'inc_tax_amount', 'Inc Tax Amount'),
(137, 0, 'expense', '', 'internal_staff_id', 'Internal Staff ID'),
(138, 0, 'expense', '', 'external_staff_id', 'External Staff ID'),
(139, 0, 'expense', '', 'description', 'Description'),
(140, 0, 'expense', '', 'taxable', 'Taxable'),
(141, 0, 'invoice', 'shift', 'internal_client_id', 'Internal Client ID'),
(142, 0, 'invoice', 'shift', 'external_client_id', 'External Client ID'),
(143, 0, 'invoice', 'shift', 'client_company_name', 'Client Company Name'),
(144, 0, 'invoice', 'shift', 'client_address', 'Client Address'),
(145, 0, 'invoice', 'shift', 'client_suburb', 'Client Suburb'),
(146, 0, 'invoice', 'shift', 'client_city', 'Client City'),
(147, 0, 'invoice', 'shift', 'client_postcode', 'Client Postcode'),
(148, 0, 'invoice', 'shift', 'client_state', 'Client State'),
(149, 0, 'invoice', 'shift', 'client_country', 'Client Country'),
(150, 0, 'invoice', 'shift', 'client_contact_name', 'Client Contact Name'),
(151, 0, 'invoice', 'shift', 'client_email', 'Client Email'),
(152, 0, 'invoice', 'shift', 'issued_date', 'Issued Date'),
(153, 0, 'invoice', 'shift', 'due_date', 'Due Date'),
(154, 0, 'invoice', 'shift', 'item_description', 'Item Description'),
(155, 0, 'invoice', 'shift', 'tax_type', 'Tax Type'),
(156, 0, 'invoice', 'shift', 'tax_amount', 'Tax Amount'),
(157, 0, 'invoice', 'shift', 'ex_tax_amount', 'Ex Tax Amount'),
(158, 0, 'invoice', 'shift', 'inc_tax_amount', 'Inc Tax Amount'),
(159, 0, 'invoice', 'shift', 'invoice_id', 'Invoice ID'),
(160, 0, 'invoice', 'shift', 'po_number', 'PO Number'),
(161, 0, 'invoice', 'shift', 'job_date', 'Job Date'),
(162, 0, 'invoice', 'shift', 'hours', 'Hours'),
(163, 0, 'invoice', 'shift', 'staff_name', 'Staff Name'),
(164, 0, 'invoice', 'shift', 'break', 'Break'),
(165, 0, 'invoice', 'shift', 'start_time', 'Start Time'),
(166, 0, 'invoice', 'shift', 'finish_time', 'Finish Time'),
(167, 0, 'payrun_tfn', 'shift', 'staff_first_name', 'Staff First Name'),
(168, 0, 'payrun_tfn', 'shift', 'staff_last_name', 'Staff Last Name'),
(169, 0, 'payrun_tfn', 'shift', 'client_company_name', 'Client Company Name'),
(170, 0, 'payrun_tfn', 'shift', 'shift_date', 'Shift Date'),
(171, 0, 'payrun_tfn', 'shift', 'internal_client_id', 'Internal Client ID'),
(172, 0, 'payrun_tfn', 'shift', 'external_client_id', 'External Client ID'),
(173, 0, 'invoice', 'shift', 'venue', 'Venue'),
(174, 0, 'client', '', 'company_name', 'Company Name'),
(175, 0, 'client', '', 'contact_name', 'Contact Name'),
(176, 0, 'client', '', 'address', 'Address'),
(177, 0, 'client', '', 'city', 'City'),
(178, 0, 'client', '', 'state', 'State'),
(179, 0, 'client', '', 'email', 'Email Address'),
(180, 0, 'client', '', 'abn', 'ABN'),
(181, 0, 'client', '', 'phone', 'Phone Number'),
(182, 0, 'client', '', 'suburb', 'Suburb'),
(183, 0, 'client', '', 'postcode', 'Postcode'),
(184, 0, 'client', '', 'country', 'Country'),
(185, 0, 'client', '', 'external_id', 'External ID'),
(186, 0, 'client', '', 'internal_id', 'Internal ID'),
(187, 0, 'invoice', 'pay_rate', 'internal_client_id', 'Internal Client ID'),
(188, 0, 'invoice', 'pay_rate', 'external_client_id', 'External Client ID'),
(189, 0, 'invoice', 'pay_rate', 'client_company_name', 'Client Company Name'),
(190, 0, 'invoice', 'pay_rate', 'client_address', 'Client Address'),
(191, 0, 'invoice', 'pay_rate', 'client_suburb', 'Client Suburb'),
(192, 0, 'invoice', 'pay_rate', 'client_city', 'Client City'),
(193, 0, 'invoice', 'pay_rate', 'client_postcode', 'Client Postcode'),
(194, 0, 'invoice', 'pay_rate', 'client_state', 'Client State'),
(195, 0, 'invoice', 'pay_rate', 'client_country', 'Client Country'),
(196, 0, 'invoice', 'pay_rate', 'client_contact_name', 'Client Contact Name'),
(197, 0, 'invoice', 'pay_rate', 'client_email', 'Client Email'),
(198, 0, 'invoice', 'pay_rate', 'issued_date', 'Issued Date'),
(199, 0, 'invoice', 'pay_rate', 'due_date', 'Due Date'),
(200, 0, 'invoice', 'pay_rate', 'item_description', 'Item Description'),
(201, 0, 'invoice', 'pay_rate', 'tax_type', 'Tax Type'),
(202, 0, 'invoice', 'pay_rate', 'tax_amount', 'Tax Amount'),
(203, 0, 'invoice', 'pay_rate', 'ex_tax_amount', 'Ex Tax Amount'),
(204, 0, 'invoice', 'pay_rate', 'inc_tax_amount', 'Inc Tax Amount'),
(205, 0, 'invoice', 'pay_rate', 'invoice_id', 'Invoice ID'),
(206, 0, 'invoice', 'pay_rate', 'po_number', 'PO Number'),
(207, 0, 'invoice', 'pay_rate', 'job_date', 'Job Date'),
(208, 0, 'invoice', 'pay_rate', 'hours', 'Hours'),
(209, 0, 'invoice', 'pay_rate', 'staff_name', 'Staff Name'),
(210, 0, 'invoice', 'pay_rate', 'break', 'Break'),
(211, 0, 'invoice', 'pay_rate', 'start_time', 'Start Time'),
(212, 0, 'invoice', 'pay_rate', 'finish_time', 'Finish Time'),
(213, 0, 'invoice', 'pay_rate', 'venue', 'Venue'),
(214, 0, 'invoice', 'pay_rate', 'pay_rate_amount', 'Pay Rate Amount');



--
-- Table structure for table `forecast`
--

CREATE TABLE IF NOT EXISTS `forecast` (
  `forecast_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `job_id` bigint(20) NOT NULL,
  `shift_id` bigint(20) NOT NULL,
  `job_date` date NOT NULL,
  `expenses_staff_cost` decimal(10,0) NOT NULL,
  `expenses_client_cost` decimal(10,0) NOT NULL,
  `total_amount_staff` decimal(10,0) NOT NULL,
  `total_amount_client` decimal(10,0) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`forecast_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `receive_email` varchar(255) NOT NULL,
  `status` TINYINT NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `form_applicants`
--

CREATE TABLE `form_applicants` (
  `applicant_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) NOT NULL,
  `status` TINYINT NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accepted_on` DATETIME NOT NULL, 
  `rejected_on` DATETIME NOT NULL,
  PRIMARY KEY (`applicant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `form_applicant_data`
--

CREATE TABLE `form_applicant_data` (
  `applicant_id` bigint(20) NOT NULL,
  `form_field_id` bigint(20) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `form_field_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) NOT NULL,
  `label` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `required` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`form_field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `forum_messages`
--

CREATE TABLE IF NOT EXISTS `forum_messages` (
  `message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `posted_by` bigint(20) NOT NULL,
  `posted_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_poll_answers`
--

CREATE TABLE IF NOT EXISTS `forum_poll_answers` (
  `poll_answer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(20) NOT NULL,
  `answer` text NOT NULL,
  `answer_count` int(11) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`poll_answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE IF NOT EXISTS `forum_topics` (
  `topic_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `group_id` int(11) NOT NULL,
  `document_type` enum('image','file','null') NOT NULL DEFAULT 'null',
  `document_name` varchar(255) NOT NULL,
  `type` enum('poll','conversation') NOT NULL DEFAULT 'conversation',
  `created_by` bigint(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_replied_by` bigint(20) NOT NULL,
  `last_replied_on` datetime NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_user_poll_answers`
--

CREATE TABLE IF NOT EXISTS `forum_user_poll_answers` (
  `user_poll_answer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(20) NOT NULL,
  `poll_answer_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `answered_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_poll_answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Table structure for table `information_sheet_config`
--

CREATE TABLE IF NOT EXISTS `information_sheet_config` (
  `information_sheet_config_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `element_label` varchar(255) NOT NULL,
  `element_name` varchar(255) NOT NULL,
  `element_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`information_sheet_config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `information_sheet_config`
--

INSERT INTO `information_sheet_config` (`information_sheet_config_id`, `element_label`, `element_name`, `element_active`, `modified`) VALUES
(1, 'Campaign Name', 'campaign_name', 'yes', '2014-04-17 06:42:46'),
(2, 'Client Name', 'client_name', 'yes', '0000-00-00 00:00:00'),
(3, 'Shift Date', 'shift_date', 'yes', '0000-00-00 00:00:00'),
(4, 'Start - Finish Time', 'start_finish_time', 'yes', '0000-00-00 00:00:00'),
(5, 'Break Length', 'break_length', 'yes', '0000-00-00 00:00:00'),
(6, 'Break Start', 'break_start', 'yes', '0000-00-00 00:00:00'),
(7, 'Venue Address', 'venue_address', 'yes', '0000-00-00 00:00:00'),
(8, 'Role', 'role', 'yes', '2014-04-17 06:40:30'),
(9, 'Pay Rate', 'pay_rate', 'yes', '0000-00-00 00:00:00'),
(10, 'Time Sheet Supervisor', 'time_sheet_supervisor', 'yes', '0000-00-00 00:00:00'),
(11, 'Uniform', 'uniform', 'yes', '0000-00-00 00:00:00'),
(12, 'Notes', 'notes', 'yes', '0000-00-00 00:00:00'),
(13, 'Expenses', 'expenses', 'yes', '0000-00-00 00:00:00'),
(14, 'Other Staff Working', 'other_staff_working', 'yes', '0000-00-00 00:00:00');

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(100) NOT NULL,
  `po_number` varchar(100) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `jobs` text NOT NULL,
  `title` varchar(250) NOT NULL,
  `gst` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0: created, 2: generated, 3: paid',
  `breakdown` tinyint(4) NOT NULL,
  `issued_by` bigint(20) NOT NULL,
  `issued_date` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paid_on` datetime NOT NULL,
  `client_company_name` varchar(100) NOT NULL,
  `client_address` varchar(100) NOT NULL,
  `client_suburb` varchar(100) NOT NULL,
  `client_state` varchar(100) NOT NULL,
  `client_postcode` varchar(100) NOT NULL,
  `client_phone` varchar(100) NOT NULL,
  `client_email_address` varchar(100) NOT NULL,
  `profile_company_name` varchar(100) NOT NULL,
  `profile_abn` varchar(100) NOT NULL,
  `profile_company_email` varchar(255) NOT NULL,
  `profile_company_phone` varchar(255) NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE IF NOT EXISTS `invoice_items` (
  `item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) NOT NULL,
  `job_id` bigint(20) DEFAULT NULL,
  `expense_id` bigint(20) NOT NULL,
  `include_timesheets` tinyint(4) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `tax` int(11) NOT NULL COMMENT '0: no, 1: yes, 2: tax free',
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `job_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '0: temporary, 1: created',
  `client_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_shifts`
--

CREATE TABLE IF NOT EXISTS `job_shifts` (
  `shift_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '-2: deleted, -1: rejected, 0: not assigned, 1: unconfirmed, 2: confirmed, 3: finished',
  `is_alert` TINYINT NOT NULL COMMENT '0: no, 1: yes',
  `sms_sent` TINYINT NOT NULL DEFAULT '0',
  `sms_sent_on` datetime NOT NULL,
  `job_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL DEFAULT '0',
  `supervisor_id` bigint(20) NOT NULL,
  `job_date` date NOT NULL,
  `start_time` bigint(20) NOT NULL,
  `finish_time` bigint(20) NOT NULL,
  `break_time` text NOT NULL,
  `venue_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `uniform_id` int(11) NOT NULL,
  `payrate_id` int(11) NOT NULL,
  `payrate_type` varchar(10) NOT NULL,
  `expenses` text NOT NULL,
  `information_sheet` TINYINT( 4 ) NOT NULL DEFAULT  '1' COMMENT  '1: information sheet visible, 0  not visible',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_shift_client_request`
--

CREATE TABLE IF NOT EXISTS `job_shift_client_request` (
  `shift_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `requested_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `job_shift_notes` (
  `job_shift_note_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) NOT NULL,
  `note` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `added_by_user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`job_shift_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `job_shift_staff_apply`
--

CREATE TABLE IF NOT EXISTS `job_shift_staff_apply` (
  `shift_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1: accept, -1: reject',
  `responsed_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_shift_timesheets`
--

CREATE TABLE IF NOT EXISTS `job_shift_timesheets` (
  `timesheet_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '0: pending, 1: submitted, 2: approved, 3: batched, 4: processing, 5: paid',
  `status_payrun_staff` tinyint(4) NOT NULL COMMENT '0: processing, 1: ready, 3: paid',
  `payrun_id` bigint(20) NOT NULL,
  `status_invoice_client` tinyint(4) NOT NULL COMMENT '0: processing, 1: ready, 2: generated, 3: paid',
  `invoice_id` bigint(20) NOT NULL,
  `job_id` bigint(20) NOT NULL,
  `shift_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `supervisor_id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `job_date` date NOT NULL,
  `start_time` bigint(20) NOT NULL,
  `finish_time` bigint(20) NOT NULL,
  `break_time` text NOT NULL,
  `venue_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `uniform_id` int(11) NOT NULL,
  `payrate_id` int(11) NOT NULL,
  `payrate_type` varchar(10) NOT NULL,
  `expenses` text NOT NULL,
  `expenses_staff_cost` decimal(10,2) NOT NULL,
  `expenses_client_cost` decimal(10,2) NOT NULL,
  `staff_payrates` text NOT NULL,
  `total_minutes` decimal(10,2) NOT NULL,
  `total_amount_staff` decimal(10,2) NOT NULL,
  `total_amount_client` decimal(10,2) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL,
  `batched_on` datetime NOT NULL,
  `staff_paid_on` datetime NOT NULL,
  `client_paid_on` datetime NOT NULL,
  PRIMARY KEY (`timesheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `module` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules_functions`
--

CREATE TABLE IF NOT EXISTS `modules_functions` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules_mvc`
--

CREATE TABLE IF NOT EXISTS `modules_mvc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_modules_id` int(11) NOT NULL,
  `mvc_type` enum('controllers','models','views') NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `credit_type` VARCHAR(100) NOT NULL,
  `credits` bigint(20) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `result` varchar(200) NOT NULL,
  `msg` text NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country` varchar(100) NOT NULL,
  `ccname` varchar(255) NOT NULL,
  `ccnumber` varchar(40) NOT NULL,
  `expmonth` varchar(10) NOT NULL,
  `expyear` varchar(10) NOT NULL,
  `ccv` varchar(4) NOT NULL,
  `coupon` varchar(100) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `payruns`
--

CREATE TABLE IF NOT EXISTS `payruns` (
  `payrun_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date_from` DATE NOT NULL,
  `date_to` DATE NOT NULL,
  `payable_date` DATE NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1: tfn, 2: abn',
  `amount` decimal(10,2) NOT NULL,
  `total_staffs` int(11) NOT NULL,
  `total_timesheets` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payrun_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_documentation`
--

CREATE TABLE IF NOT EXISTS `project_documentation` (
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

CREATE TABLE IF NOT EXISTS `project_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shift_brief`
--

CREATE TABLE IF NOT EXISTS `shift_brief` (
  `shift_brief_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) NOT NULL,
  `brief_id` bigint(20) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`shift_brief_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


CREATE TABLE `sms_templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `msg` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sms_templates`
--

INSERT INTO `sms_templates` (`template_id`, `title`, `msg`, `status`) VALUES
(1, 'Work Request', 'Dear {FirstName}. Can you work as a {Role} from {StartTime} to {FinishTime}, on {Date} at {Venue}. Reply Y{Code} for yes or N{Code} for no. {CompanyName}', 1),
(2, 'Work Confirmation', 'You have been confirmed to work on {Date} at {StartTime} please login to your account for full details.', 1),
(3, 'Invalid Code', 'The code {Code} is no longer valid. The position may have been filled or cancelled. Please contact us for more information', 1);


--
-- Table structure for table `staff_custom_fields`
--

CREATE TABLE `staff_custom_fields` (
  `staff_custom_field_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `field_id` bigint(20) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`staff_custom_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `staff_groups`
--

CREATE TABLE IF NOT EXISTS `staff_groups` (
  `staff_groups_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `attribute_group_id` int(11) NOT NULL,
  PRIMARY KEY (`staff_groups_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `staff_roles`
--

CREATE TABLE IF NOT EXISTS `staff_roles` (
  `staff_roles_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `attribute_role_id` int(11) NOT NULL,
  PRIMARY KEY (`staff_roles_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

CREATE TABLE IF NOT EXISTS `supers` (
  `super_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`super_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
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
  `data` LONGTEXT NOT NULL,
  PRIMARY KEY (`upload_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '1 = active, 0 = pending, -1 = inactive, 2 = deleted',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_client_venue_restrict`
--

CREATE TABLE `user_client_venue_restrict` (
  `user_id` bigint(20) NOT NULL,
  `venue_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `user_clients`
--

CREATE TABLE IF NOT EXISTS `user_clients` (
  `client_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `external_client_id` varchar(20) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `abn` varchar(20) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `total_jobs_current_year` int(11) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_client_departments`
--

CREATE TABLE IF NOT EXISTS `user_client_departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `user_staffs`
--

CREATE TABLE IF NOT EXISTS `user_staffs` (
  `staff_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `external_staff_id` varchar(20) NOT NULL,
  `rating` decimal(10,2) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date NOT NULL,
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
  `f_bsb` varchar(10) NOT NULL,
  `f_employed` int(11) NOT NULL DEFAULT '1',
  `f_abn` varchar(20) NOT NULL,
  `f_require_gst` tinyint(4) NOT NULL,
  `f_tfn` varchar(20) NOT NULL,
  `s_choice` varchar(100) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_employee_id` varchar(100) DEFAULT NULL,
  `s_tfn` varchar(20) NOT NULL,
  `s_fund_name` varchar(100) NOT NULL,
  `s_fund_website` varchar(100) NOT NULL,
  `s_product_id` varchar(100) NOT NULL,
  `s_fund_phone` varchar(100) NOT NULL,
  `s_membership` varchar(100) DEFAULT NULL,
  `s_fund_address` varchar(100) NOT NULL,
  `s_fund_suburb` varchar(100) NOT NULL,
  `s_fund_postcode` varchar(10) NOT NULL,
  `s_fund_state` varchar(10) NOT NULL,
  `s_agree` tinyint(4) NOT NULL,
  `availability` text NOT NULL,
  `payrates` varchar(100) NOT NULL,
  `roles` varchar(100) NOT NULL,
  `locations` text NOT NULL,
  `last_worked_date` datetime NOT NULL COMMENT 'the last date the staff worked on a job',
  `time_sheets_in_payrun` int(11) NOT NULL COMMENT 'number of unpaid time sheet in the payrun',
  `welcome_email_sent` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_staff_availability`
--

CREATE TABLE IF NOT EXISTS `user_staff_availability` (
  `user_id` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `hour` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `user_staff_payrate_restrict` (
  `user_id` bigint(20) NOT NULL,
  `payrate_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_staff_picture`
--

CREATE TABLE IF NOT EXISTS `user_staff_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `hero` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `system_styles`
--

INSERT INTO `system_styles` (`style_id`, `primary_colour`, `rollover_colour`, `secondary_colour`, `text_colour`, `modified`) VALUES
(1, '#00b1eb', '#2a6496', '#ffffff', '#3d3d3d', '2014-04-11 07:46:58');

-- --------------------------------------------------------

--
-- Table structure for table `information_sheet_config`
--

CREATE TABLE IF NOT EXISTS `information_sheet_config` (
  `information_sheet_config_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `element_label` varchar(255) NOT NULL,
  `element_name` varchar(255) NOT NULL,
  `element_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`information_sheet_config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `information_sheet_config`
--

INSERT INTO `information_sheet_config` (`information_sheet_config_id`, `element_label`, `element_name`, `element_active`, `modified`) VALUES
(1, 'Campaign Name', 'campaign_name', 'yes', '2014-04-17 06:42:46'),
(2, 'Client Name', 'client_name', 'yes', '0000-00-00 00:00:00'),
(3, 'Shift Date', 'shift_date', 'yes', '0000-00-00 00:00:00'),
(4, 'Start - Finish Time', 'start_finish_time', 'yes', '0000-00-00 00:00:00'),
(5, 'Break Length', 'break_length', 'yes', '0000-00-00 00:00:00'),
(6, 'Break Start', 'break_start', 'yes', '0000-00-00 00:00:00'),
(7, 'Venue Address', 'venue_address', 'yes', '0000-00-00 00:00:00'),
(8, 'Role', 'role', 'yes', '2014-04-17 06:40:30'),
(9, 'Pay Rate', 'pay_rate', 'yes', '0000-00-00 00:00:00'),
(10, 'Time Sheet Supervisor', 'time_sheet_supervisor', 'yes', '0000-00-00 00:00:00'),
(11, 'Uniform', 'uniform', 'yes', '0000-00-00 00:00:00'),
(12, 'Notes', 'notes', 'yes', '0000-00-00 00:00:00'),
(13, 'Expenses', 'expenses', 'yes', '0000-00-00 00:00:00'),
(14, 'Other Staff Working', 'other_staff_working', 'yes', '0000-00-00 00:00:00');
