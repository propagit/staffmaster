-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `blog_date` date NOT NULL,
  `preview` text NOT NULL,
  `content` longtext NOT NULL,
  `testimonial` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `doc` varchar(255) NOT NULL,
  `gallery` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `status` enum('active','inactive') CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL DEFAULT 'inactive',
  `modified` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`blog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories_relation`
--

CREATE TABLE IF NOT EXISTS `blog_categories_relation` (
  `blog_categories_relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `blog_category_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_categories_relation_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `blog_category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`blog_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `records_per_page_config`
--

CREATE TABLE IF NOT EXISTS `records_per_page_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL COMMENT 'this has to be unique',
  `backend` int(11) NOT NULL DEFAULT '25',
  `frontend` int(11) unsigned NOT NULL DEFAULT '25',
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_name` (`module`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `records_per_page_config`
--

INSERT INTO `records_per_page_config` (`id`, `module`, `backend`, `frontend`) VALUES
(1, 'blog', 20, 20;
