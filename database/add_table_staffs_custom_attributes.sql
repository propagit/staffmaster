-- --------------------------------------------------------

--
-- Table structure for table `staffs_custom_attributes`
--

CREATE TABLE IF NOT EXISTS `staffs_custom_attributes` (
  `staffs_custom_attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_staff_id` int(11) NOT NULL,
  `attribute_name` varchar(255) NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY (`staffs_custom_attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;