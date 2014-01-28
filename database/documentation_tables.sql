

-- --------------------------------------------------------

--
-- Table structure for table `modules_functions`
--

CREATE TABLE IF NOT EXISTS `modules_functions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modules_mvc_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text NOT NULL,
  `params` text NOT NULL,
  `attributes` text NOT NULL,
  `code` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules_mvc`
--

CREATE TABLE IF NOT EXISTS `modules_mvc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_modules_id` int(11) NOT NULL,
  `mvc_type` enum('controllers','models','views') NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_documentation`
--

CREATE TABLE IF NOT EXISTS `project_documentation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_modules`
--

CREATE TABLE IF NOT EXISTS `project_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
