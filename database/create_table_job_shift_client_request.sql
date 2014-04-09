CREATE TABLE `job_shift_client_request` (
  `shift_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `requested_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
