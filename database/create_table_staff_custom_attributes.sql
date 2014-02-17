
--
-- Table structure for table `staffs_custom_attributes`
--

CREATE TABLE IF NOT EXISTS `staffs_custom_attributes` (
  `staffs_custom_attributes_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `attribute_name` varchar(255) NOT NULL,
  `attributes` text NOT NULL,
  `file_upload` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`staffs_custom_attributes_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;