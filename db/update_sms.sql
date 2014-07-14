--ALTER TABLE `account` CHANGE `credits` `system_credits` BIGINT(20) NOT NULL;
--ALTER TABLE `account` ADD `sms_credits` int(11) NOT NULL AFTER `system_credits`;
--ALTER TABLE `job_shifts` ADD `sms_sent` TINYINT NOT NULL DEFAULT '0' AFTER `is_alert`;
--ALTER TABLE `job_shifts` ADD `sms_sent_on` datetime NOT NULL AFTER `sms_sent`;
--ALTER TABLE `orders` ADD `credit_type` VARCHAR(100) NOT NULL AFTER `order_time`;


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
