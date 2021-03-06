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



ALTER TABLE  `job_shifts` ADD  `information_sheet` TINYINT( 4 ) NOT NULL DEFAULT  '1' COMMENT  '1: information sheet visible, 0  not visible' AFTER  `expenses` ;