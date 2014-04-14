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

CREATE TABLE IF NOT EXISTS `custom_forms` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

CREATE TABLE IF NOT EXISTS `export_fields` (
  `order` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `value` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `export_templates`
--

CREATE TABLE IF NOT EXISTS `export_templates` (
  `export_id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`export_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `export_template_data`
--

CREATE TABLE IF NOT EXISTS `export_template_data` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `export_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `job_id` bigint(20) NOT NULL,
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
-- Table structure for table `staff_custom_attributes`
--

CREATE TABLE IF NOT EXISTS `staff_custom_attributes` (
  `staff_custom_attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `attribute_name` varchar(255) NOT NULL,
  `attributes` text NOT NULL,
  `file_upload` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`staff_custom_attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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