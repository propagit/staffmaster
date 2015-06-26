--
-- Table structure for table `inductions`
--

CREATE TABLE IF NOT EXISTS `inductions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0: draft, 1: actived',
  `target_all` tinyint(4) NOT NULL COMMENT '0: false, 1: true',
  `state` text,
  `group` text,
  `role` text,
  `age` text,
  `gender` text,
  `work_from` date DEFAULT NULL,
  `work_to` date DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Table structure for table `inductions_users`
--

CREATE TABLE IF NOT EXISTS `inductions_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `induction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `finished_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `induction_contents`
--

CREATE TABLE IF NOT EXISTS `induction_contents` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `induction_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `content_order` int(11) NOT NULL,
  `type` enum('video','image','text','compliance','file','field') NOT NULL,
  `value` text,
  `html` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;


--
-- Table structure for table `induction_steps`
--

CREATE TABLE IF NOT EXISTS `induction_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `induction_id` int(11) NOT NULL,
  `step_order` int(11) NOT NULL,
  `type` enum('content','personal','financial','super','picture','role','availability','location','group','custom') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `fields` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
