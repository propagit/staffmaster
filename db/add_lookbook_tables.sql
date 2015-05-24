
-- --------------------------------------------------------

--
-- Table structure for table `lookbook_config`
--

CREATE TABLE `lookbook_config` (
`id` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `fields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lookbook_config`
--

INSERT INTO `lookbook_config` (`id`, `type`, `fields`) VALUES
(1, 'personal', '["first_name","last_name","dob","gender","state"]'),
(2, 'custom', ''),
(3, 'message', 'We have a chosen aa range of staff we think may suit your requirments');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lookbook_config`
--
ALTER TABLE `lookbook_config`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lookbook_config`
--
ALTER TABLE `lookbook_config`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;



-- --------------------------------------------------------

--
-- Table structure for table `lookbook`
--

CREATE TABLE `lookbook` (
`lookbook_id` bigint(20) NOT NULL,
  `key` varchar(255) NOT NULL COMMENT 'public key to view the lookbook without logging into the system',
  `included_user_ids` text NOT NULL COMMENT 'staff user id in json format',
  `receiver_user_id` bigint(20) NOT NULL COMMENT 'client user id',
  `receiver_email` varchar(255) NOT NULL COMMENT 'client email',
  `personal_fields` text NOT NULL COMMENT 'staff personal details',
  `custom_fields` text NOT NULL COMMENT 'staff custom attributes ',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lookbook`
--
ALTER TABLE `lookbook`
 ADD PRIMARY KEY (`lookbook_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lookbook`
--
ALTER TABLE `lookbook`
MODIFY `lookbook_id` bigint(20) NOT NULL AUTO_INCREMENT;



-- --------------------------------------------------------

--
-- Table structure for table `client_favourite_staff`
--

CREATE TABLE `client_favourite_staff` (
`id` bigint(20) NOT NULL,
  `client_user_id` bigint(20) NOT NULL,
  `staff_user_id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 not set, 1 Liked',
  `updated` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_favourite_staff`
--
ALTER TABLE `client_favourite_staff`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_favourite_staff`
--
ALTER TABLE `client_favourite_staff`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;