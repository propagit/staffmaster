-- --------------------------------------------------------

--
-- Table structure for table `user_staff_payrate_restrict`
--

CREATE TABLE `user_staff_payrate_restrict` (
  `user_id` bigint(20) NOT NULL,
  `payrate_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
