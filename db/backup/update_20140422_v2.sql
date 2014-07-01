ALTER TABLE `job_shifts` ADD `is_alert` TINYINT NOT NULL COMMENT '0: no, 1: yes' AFTER `status`;


-- --------------------------------------------------------

--
-- Table structure for table `job_shift_notes`
--

CREATE TABLE IF NOT EXISTS `job_shift_notes` (
  `job_shift_note_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) NOT NULL,
  `note` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `added_by_user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`job_shift_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
