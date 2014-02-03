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
