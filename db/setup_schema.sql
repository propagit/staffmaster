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
  `credits` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`credits`) VALUES
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
  `payrate_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0: staff, 1: client',
  `day` int(11) NOT NULL COMMENT '1: moday, 7: sunday',
  `hour` int(11) NOT NULL,
  `value` decimal(10,2) NOT NULL
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
(1, 'Welcome Staff', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp&#59{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Welcome to the&nbsp&#59{CompanyName}&nbsp&#59team</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We are thrilled to have you joint our team. Before completing your first shift with us we need you to logon to your staff account and complete your online induction.&nbsp&#59</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Completing your induction ensures that your details in the system are accurate, you get paid on time and can apply for shifts as they become available.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To log on to your staff account click this link {SystemURL}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">and login with the following details</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">User Name &nbsp&#59 &nbsp&#59 {UserName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Password &nbsp&#59 &nbsp&#59 &nbsp&#59 {Password}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We look forward to working with you.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n', 'team@staffbooks.com', 'Welcome To Our Team', '', 'no', '2014-03-19 06:42:01', '2014-03-19 06:42:01'),
(2, 'Roster Update', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has recently been updated, please login to your staff account to confirm all shifts we have you working on.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your current roster is as follow:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n', 'team@staffbooks.com', 'Roster Update', '', 'no', '2014-03-14 06:08:44', '2014-03-14 06:08:44'),
(3, 'Apply For Shifts', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear {FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">We have just updated our system with a series of jobs. Please login to your staff account {SystemURL}&nbsp&#59and apply for jobs you would like to work on.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Some of the new shifts that have become available include:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{SelectedShifts}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind Regards</span></span></p>\r\n', 'team@staffbooks.com', 'Apply For Shifts', '', 'no', '2014-03-14 06:09:06', '2014-03-14 06:09:06'),
(4, 'Shift Reminder', '<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">Dear&nbsp&#59{FirstName}</span></span></p>\r\n\r\n<p><span style="font-family:arial,sans-serif&#59 font-size:9.0pt">This is a work reminder that you are working for the following shifts:</span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">{ShiftInfo}</span></span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">Please contact us immeadiatly if you have any questions regarding your shift.&nbsp&#59</span></span></p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:12px">Kind regards</span></span></p>', 'team@staffbooks.com', 'Shift Reminder', '', 'no', '2014-03-20 06:32:37', '2014-03-20 06:32:37'),
(5, 'Work Confirmation', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp&#59{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">You have been confirmed to work on the below job. If for any reason you can&#39&#59t work this shift please contact us immediately.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{ShiftInfo}</span></span></p>', 'team@staffbooks.com', 'Work Confirmation', '', 'no', '2014-03-14 06:09:20', '2014-03-14 06:09:20'),
(6, 'Forgot Password', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp&#59{FirstName}</span></span></p>\r\n\r\n<p>We received a forgotten password request from you.</p>\r\n\r\n<p>Your new login details are as follows:</p>\r\n\r\n<p>Username:&nbsp&#59{UserName}</p>\r\n\r\n<p>Password:&nbsp&#59{Password}</p>\r\n\r\n<p>&nbsp&#59</p>\r\n\r\n<p><span style="font-family:arial,helvetica,sans-serif&#59 font-size:12px">Please contact us immeadiatly if you did not request this password request.&nbsp&#59</span></p>\r\n\r\n<p>&nbsp&#59</p>\r\n', 'team@staffbooks.com', 'Password Reset', '', 'no', '2014-03-20 04:47:51', '2014-03-20 04:47:51'),
(7, 'Client Invoice', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp&#59{ClientContactName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please find attached an invoice from&nbsp&#59{CompanyName} for recent services for {ClientCompanyName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">The invoice details are as follows:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Invoice Number: &nbsp&#59 {InvoiceNumber}<br />\r\nAmount Due: &nbsp&#59 &nbsp&#59 &nbsp&#59 &nbsp&#59 ${AmountDue}<br />\r\nDue Date: &nbsp&#59 &nbsp&#59 &nbsp&#59 &nbsp&#59 &nbsp&#59 &nbsp&#59 &nbsp&#59{DueDate} &nbsp&#59&nbsp&#59</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">A downloadable invoice is attached or you can login to your member account to retrieve a copy of this invoice at any time.</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Kind regards</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{CompanyName}</span></span></p>\r\n', 'team@staffbooks.com', '{CompanyName} Invoice Issued - {IssueDate}', '', 'no', '2014-03-21 06:12:06', '2014-03-21 06:12:06'),
(8, 'Client Quote', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Dear&nbsp&#59{FirstName}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Your roster has been updated and requires your attention.&nbsp&#59</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please login to your account to confirm your shifts. Your Current Roster is as follows:</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">{Roster}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Please contact us immeadiatly if you have any questions regarding your roster.&nbsp&#59</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">To Login to your account click here</span></span></p>\r\n', 'team@staffbooks.com', 'Client Quote', '', 'no', '2014-03-14 06:09:40', '2014-03-14 06:09:40'),
(9, 'Brief', '<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">You can view the brief from this url.&nbsp&#59{BriefURL}</span></span></p>\r\n\r\n<p><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif">Regards</span></span></p>\r\n\r\n<p>&nbsp&#59</p>', 'team@staffbooks.com', 'Job Brief', '', 'no', '2014-04-07 06:27:00', '2014-04-07 06:27:00');


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
-- Table structure for table `export_fields`
--

DROP TABLE IF EXISTS `export_fields`;
CREATE TABLE IF NOT EXISTS `export_fields` (
  `order` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `value` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `export_fields`
--

INSERT INTO `export_fields` (`order`, `object`, `format`, `value`, `label`) VALUES
(1, 'invoice', 'single', 'job_id', 'Job ID'),
(2, 'invoice', 'single', 'company_name', 'Client Name'),
(3, 'invoice', 'single', 'job_date', 'Date'),
(4, 'invoice', 'single', 'staff_name', 'Staff name'),
(5, 'invoice', 'single', 'start_time', 'Start Time'),
(6, 'invoice', 'single', 'finish_time', 'Finish Time'),
(7, 'payrun_tfn', 'single', 'job_date', 'Job Date'),
(8, 'payrun_tfn', 'single', 'start_time', 'Start Time'),
(9, 'payrun_tfn', 'single', 'finish_time', 'Finish Time'),
(10, 'payrun_tfn', 'single', 'staff_name', 'Staff Name'),
(11, 'payrun_tfn', 'single', 'break', 'Break'),
(12, 'payrun_tfn', 'single', 'hours', 'Hours'),
(13, 'payrun_tfn', 'single', 'pay_rate', 'Pay Rate'),
(14, 'payrun_tfn', 'single', 'venue', 'Venue'),
(15, 'payrun_tfn', 'single', 'internal_staff_id', 'Internal Staff Id'),
(16, 'payrun_tfn', 'single', 'external_staff_id', 'External Staff Id'),
(17, 'payrun_tfn', 'single', 'job_name', 'Job Name'),
(18, 'payrun_abn', 'single', 'job_date', 'Job Date'),
(19, 'payrun_abn', 'single', 'start_time', 'Start Time'),
(20, 'payrun_abn', 'single', 'finish_time', 'Finish Time'),
(21, 'payrun_abn', 'single', 'staff_name', 'Staff Name'),
(22, 'payrun_abn', 'single', 'break', 'Break'),
(23, 'payrun_abn', 'single', 'hours', 'Hours'),
(24, 'payrun_abn', 'single', 'pay_rate', 'Pay Rate'),
(25, 'payrun_abn', 'single', 'venue', 'Venue'),
(26, 'payrun_abn', 'single', 'internal_staff_id', 'Internal Staff Id'),
(27, 'payrun_abn', 'single', 'external_staff_id', 'External Staff Id'),
(28, 'payrun_abn', 'single', 'job_name', 'Job Name'),
(29, 'payrun_tfn', 'batched', 'staff_name', 'Staff Name'),
(30, 'payrun_tfn', 'batched', 'hours', 'Hours'),
(31, 'payrun_tfn', 'batched', 'internal_staff_id', 'Internal Staff Id'),
(32, 'payrun_tfn', 'batched', 'external_staff_id', 'External Staff Id'),
(33, 'expense', 'single', 'job_date', 'Job Date'),
(34, 'expense', 'single', 'staff_first_name', 'Staff First Name'),
(35, 'expense', 'single', 'staff_last_name', 'Staff Last Name'),
(36, 'expense', 'single', 'job_name', 'Job Name'),
(37, 'expense', 'single', 'tax_amount', 'Tax Amount'),
(38, 'expense', 'single', 'inc_tax_amount', 'Inc Tax Amount'),
(39, 'expense', 'single', 'paid_on', 'Paid Date/Time'),
(40, 'expense', 'single', 'ex_tax_amount', 'Ex Tax Amount'),
(41, 'invoice', 'single', 'invoice_number', 'Invoice Number'),
(42, 'invoice', 'single', 'tax_amount', 'Tax Amount'),
(43, 'invoice', 'single', 'inc_tax_amount', 'Inc Tax Amount'),
(44, 'invoice', 'single', 'ex_tax_amount', 'Ex Tax Amount'),
(45, 'invoice', 'single', 'hours', 'Hours'),
(46, 'invoice', 'single', 'break', 'Break'),
(47, 'invoice', 'single', 'description', 'Description'),
(48, 'invoice', 'single', 'type', 'Type'),
(49, 'staff', 'single', 'title', 'Title'),
(50, 'staff', 'single', 'rating', 'Rating'),
(51, 'staff', 'single', 'first_name', 'First Name'),
(52, 'staff', 'single', 'gender', 'Gender'),
(53, 'staff', 'single', 'dob', 'Date of birth'),
(54, 'staff', 'single', 'address', 'Address'),
(55, 'staff', 'single', 'suburb', 'Suburb'),
(56, 'staff', 'single', 'city', 'City'),
(57, 'staff', 'single', 'postcode', 'Postcode'),
(58, 'staff', 'single', 'state', 'State'),
(59, 'staff', 'single', 'country', 'Country'),
(60, 'staff', 'single', 'email', 'Email'),
(61, 'staff', 'single', 'phone', 'Phone'),
(62, 'staff', 'single', 'external_id', 'External Staff ID'),
(63, 'staff', 'single', 'emergency_contact', 'Emergency Contact Person'),
(64, 'staff', 'single', 'emergency_phone', 'Emergency Phone'),
(65, 'staff', 'single', 'account_name', 'Bank Account Name'),
(66, 'staff', 'single', 'bsb', 'BSB'),
(67, 'staff', 'single', 'account_number', 'Bank Account Number'),
(68, 'staff', 'single', 'employed_as', 'Employed As'),
(69, 'staff', 'single', 'tfn_number', 'TFN Number'),
(70, 'staff', 'single', 'abn_number', 'ABN Number'),
(71, 'staff', 'single', 'super_choice', 'Choice of superannuation'),
(72, 'staff', 'single', 'super_employee_id', 'Super Employee ID Number'),
(73, 'staff', 'single', 'super_fund_name', 'Super Fund Name'),
(74, 'staff', 'single', 'super_membership_number', 'Super Membership Number'),
(75, 'staff', 'single', 'last_name', 'Last Name'),
(76, 'staff', 'single', 'mobile', 'Mobile'),
(77, 'staff', 'single', 'internal_id', 'Internal Staff ID'),
(78, 'staff', 'single', 'joined_date', 'Joined Date'),
(79, 'payrun_tfn', 'single', 'job_jd', 'Job ID'),
(80, 'payrun_abn', 'single', 'job_id', 'Job ID'),
(81, 'staff', 'single', 'status', 'Status');

-- --------------------------------------------------------

--
-- Table structure for table `export_templates`
--

DROP TABLE IF EXISTS `export_templates`;
CREATE TABLE IF NOT EXISTS `export_templates` (
  `export_id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`export_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `export_templates`
--

INSERT INTO `export_templates` (`export_id`, `object`, `format`, `name`, `status`) VALUES
(1, 'invoice', 'single', 'Invoice Export', 0),
(2, 'invoice', 'batched', 'Invoice Export', 0),
(3, 'payrun_tfn', 'single', 'Default - TFN Export', 0),
(4, 'payrun_tfn', 'batched', 'TFN Export', 0),
(5, 'payrun_abn', 'single', 'ABN Supplier Export', 0),
(6, 'payrun_abn', 'batched', 'ABN Supplier Export', 0),
(7, 'staff', 'single', 'Default - Staff Export', 0),
(8, 'invoice', 'batched', 'Custom batched invoice', 0),
(9, 'expense', 'single', 'Staff Expense Export ', 0),
(10, 'staff', 'single', 'Shoebooks - Staff Export', 0),
(11, 'payrun_tfn', 'single', 'Shoebooks - TFN Export', 0),
(12, 'payrun_abn', 'single', 'Shoebooks - ABN Export', 0),
(13, 'invoice', 'single', 'Shoebooks - Client Invoice Export', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=170 ;

--
-- Dumping data for table `export_template_data`
--

INSERT INTO `export_template_data` (`field_id`, `export_id`, `order`, `title`, `value`) VALUES
(11, 1, 0, 'Client Name', '{company_name}'),
(12, 1, 7, 'Work Date', '{job_date}'),
(13, 1, 5, 'Employee', '{staff_name}'),
(18, 3, 0, 'Group', '{internal_staff_id}'),
(19, 3, 1, 'Employee', '{external_staff_id}'),
(20, 3, 3, 'Date', '{job_date}'),
(21, 3, 4, 'Hours', '{hours}'),
(22, 3, 5, 'EarningID', '{pay_rate}'),
(25, 3, 6, 'Description', '{job_name}     {start_time} - {finish_time}'),
(26, 3, 2, 'Staff name', '{staff_name}'),
(27, 5, 27, 'Group', '{internal_staff_id}'),
(28, 5, 28, 'Employee', '{external_staff_id}'),
(29, 5, 29, 'Staff Name', '{staff_name}'),
(30, 5, 30, 'Date', '{job_date}'),
(31, 5, 31, 'Hours', '{hours}'),
(32, 5, 32, 'EarningID', '{pay_rate}'),
(33, 5, 33, 'Description', '{job_name}     {start_time} - {finish_time}'),
(34, 9, 34, 'Job Date', '{job_date}'),
(35, 9, 35, 'First Name', '{staff_first_name}'),
(36, 9, 36, 'Last Name', '{staff_last_name}'),
(39, 9, 39, 'Tax Amount', '{tax_amount}'),
(40, 9, 40, 'Ex Tax Amount', '{ex_tax_amount}'),
(41, 9, 41, 'Inc Tax Amount', '{inc_tax_amount}'),
(42, 9, 42, 'Job Name', '{job_name}'),
(43, 9, 43, 'Paid Date/Time', '{paid_on}'),
(44, 1, 1, 'Invoice Number', '{invoice_number}'),
(45, 1, 2, 'Tax Amount', '{tax_amount}'),
(46, 1, 3, 'Ex Tax Amount', '{ex_tax_amount}'),
(47, 1, 4, 'Inc Tax Amount', '{inc_tax_amount}'),
(48, 1, 8, 'Start Time', '{start_time}'),
(49, 1, 9, 'Finish Time', '{finish_time}'),
(50, 1, 10, 'Break', '{break}'),
(51, 1, 11, 'Hours', '{hours}'),
(52, 1, 6, 'Description', '{description}'),
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
(150, 11, 0, 'Group', '{external_staff_id}'),
(151, 11, 1, 'EmployeeID', '{internal_staff_id}'),
(152, 11, 2, 'DateFrom', ''),
(153, 11, 3, 'DateTo', ''),
(154, 11, 4, 'Date', '{job_date}'),
(155, 11, 7, 'Units', '{hours}'),
(156, 11, 8, 'strEarningID', '{pay_rate}'),
(157, 11, 9, 'Notes', '{job_name}:  {start_time} -  {finish_time}'),
(158, 11, 5, 'DivID', '{job_jd}'),
(159, 11, 6, 'JobID', 'DIV{job_jd}'),
(160, 12, 160, 'Group', '{external_staff_id}'),
(161, 12, 161, 'EmployeeID', '{internal_staff_id}'),
(162, 12, 162, 'DateFrom', ''),
(163, 12, 163, 'DateTo', ''),
(164, 12, 164, 'Date', '{job_date}'),
(165, 12, 165, 'DivID', '{job_id}'),
(166, 12, 166, 'JobID', 'Div{job_id}'),
(167, 12, 167, 'Units', '{hours}'),
(168, 12, 168, 'strEarningID', '{pay_rate}'),
(169, 12, 169, 'Notes', '{job_name}:  {start_time} -  {finish_time}');

-- --------------------------------------------------------

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
  `f_bsb` varchar(5) NOT NULL,
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
