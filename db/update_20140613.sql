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

