CREATE TABLE IF NOT EXISTS `custom_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `placeholder` varchar(255) NOT NULL,
  `inline_element` enum('yes','no','not applicable') NOT NULL DEFAULT 'not applicable',
  `multi_select` enum('yes','no','not applicable') NOT NULL DEFAULT 'not applicable',
  `attributes` text NOT NULL,
  `order` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'order of the form',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;