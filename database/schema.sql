-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2014 at 08:03 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `staff_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `attribute_availability`
--

CREATE TABLE IF NOT EXISTS `attribute_availability` (
  `availability_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`availability_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_groups`
--

CREATE TABLE IF NOT EXISTS `attribute_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_locations`
--

CREATE TABLE IF NOT EXISTS `attribute_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_payrates`
--

CREATE TABLE IF NOT EXISTS `attribute_payrates` (
  `payrate_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '-1: deleted',
  PRIMARY KEY (`payrate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_payrate_data`
--

CREATE TABLE IF NOT EXISTS `attribute_payrate_data` (
  `payrate_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0: staff, 1: client',
  `day` int(11) NOT NULL COMMENT '1: moday, 7: sunday',
  `hour` int(11) NOT NULL,
  `value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_roles`
--

CREATE TABLE IF NOT EXISTS `attribute_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_uniforms`
--

CREATE TABLE IF NOT EXISTS `attribute_uniforms` (
  `uniform_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`uniform_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_venues`
--

CREATE TABLE IF NOT EXISTS `attribute_venues` (
  `venue_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(100) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`venue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `brief`
--

CREATE TABLE IF NOT EXISTS `brief` (
  `brief_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 inactive, 1 active',
  `encoded_url` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`brief_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `brief_elements`
--

CREATE TABLE IF NOT EXISTS `brief_elements` (
  `brief_element_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brief_id` bigint(20) NOT NULL,
  `element_type` varchar(255) NOT NULL COMMENT 'html element type such as text for header, textarea for description, radio etc',
  `element_content` text NOT NULL COMMENT 'if the element is a radio or checkbox then store the data in json format similar to attributes in custom_forms table ',
  `document_name` varchar(255) NOT NULL COMMENT 'name of the document entered by user and not the file name',
  `element_order` int(11) NOT NULL DEFAULT '0' COMMENT 'order of the elements',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`brief_element_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE IF NOT EXISTS `company_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_logo` varchar(200) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `suburb` varchar(200) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `website` varchar(200) NOT NULL,
  `telephone` varchar(200) NOT NULL,
  `fax` varchar(200) NOT NULL,
  `website_account` varchar(200) NOT NULL,
  `abn_acn` varchar(20) NOT NULL,
  `bank_account_name` varchar(200) NOT NULL,
  `bank_account_no` varchar(200) NOT NULL,
  `bank_bsb` varchar(20) NOT NULL,
  `super_fund_name` varchar(200) NOT NULL,
  `super_product_id` varchar(200) NOT NULL,
  `super_fund_phone` varchar(200) NOT NULL,
  `super_fund_website` varchar(200) NOT NULL,
  `term_and_conditions` text NOT NULL,
  `email_c_name` varchar(200) NOT NULL,
  `email_c_address` varchar(200) NOT NULL,
  `email_c_suburb` varchar(200) NOT NULL,
  `email_c_state` varchar(200) NOT NULL,
  `email_c_postcode` varchar(200) NOT NULL,
  `email_c_country` varchar(200) NOT NULL,
  `email_c_telephone` varchar(200) NOT NULL,
  `email_c_fax` varchar(200) NOT NULL,
  `email_c_email` varchar(200) NOT NULL,
  `email_c_website` varchar(200) NOT NULL,
  `email_s_facebook` varchar(200) NOT NULL,
  `email_s_twitter` varchar(200) NOT NULL,
  `email_s_linkedin` varchar(200) NOT NULL,
  `email_s_google` varchar(200) NOT NULL,
  `email_s_youtube` varchar(200) NOT NULL,
  `email_s_instagram` varchar(200) NOT NULL,
  `email_common_text` text NOT NULL,
  `email_background_colour` varchar(200) NOT NULL,
  `email_font_colour` varchar(200) NOT NULL,
  `email_font` varchar(300) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=238 ;

-- --------------------------------------------------------

--
-- Table structure for table `custom_forms`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_merge_fields`
--

CREATE TABLE IF NOT EXISTS `email_merge_fields` (
  `merge_field_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email_template_id` bigint(20) NOT NULL,
  `merge_label` varchar(255) NOT NULL,
  `merge_field` varchar(255) NOT NULL,
  `merge_order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`merge_field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `template_content` text NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `default_template` text NOT NULL COMMENT 'this is the default template which will be used to restore to default template',
  `auto_send` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'defines weather or not the email is automatically send',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`email_template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `expense_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `paid_on` datetime DEFAULT NULL,
  `job_id` bigint(20) NOT NULL,
  `timesheet_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `staff_cost` decimal(10,2) NOT NULL,
  `client_cost` decimal(10,2) NOT NULL,
  `tax` tinyint(4) NOT NULL,
  PRIMARY KEY (`expense_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `export_fields`
--

CREATE TABLE IF NOT EXISTS `export_fields` (
  `order` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `value` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Table structure for table `export_templates`
--

CREATE TABLE IF NOT EXISTS `export_templates` (
  `export_id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`export_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `export_template_data`
--

CREATE TABLE IF NOT EXISTS `export_template_data` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `export_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `forecast`
--

CREATE TABLE IF NOT EXISTS `forecast` (
  `forecast_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `job_id` bigint(20) NOT NULL,
  `shift_id` bigint(20) NOT NULL,
  `job_date` date NOT NULL,
  `expenses_staff_cost` decimal(10,0) NOT NULL,
  `expenses_client_cost` decimal(10,0) NOT NULL,
  `total_amount_staff` decimal(10,0) NOT NULL,
  `total_amount_client` decimal(10,0) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`forecast_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_messages`
--

CREATE TABLE IF NOT EXISTS `forum_messages` (
  `message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `posted_by` bigint(20) NOT NULL,
  `posted_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_poll_answers`
--

CREATE TABLE IF NOT EXISTS `forum_poll_answers` (
  `poll_answer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(20) NOT NULL,
  `answer` text NOT NULL,
  `answer_count` int(11) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`poll_answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE IF NOT EXISTS `forum_topics` (
  `topic_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `group_id` int(11) NOT NULL,
  `document_type` enum('image','file','null') NOT NULL DEFAULT 'null',
  `document_name` varchar(255) NOT NULL,
  `type` enum('poll','conversation') NOT NULL DEFAULT 'conversation',
  `created_by` bigint(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_replied_by` bigint(20) NOT NULL,
  `last_replied_on` datetime NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_user_poll_answers`
--

CREATE TABLE IF NOT EXISTS `forum_user_poll_answers` (
  `user_poll_answer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(20) NOT NULL,
  `poll_answer_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `answered_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_poll_answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(100) NOT NULL,
  `po_number` varchar(100) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `jobs` text NOT NULL,
  `title` varchar(250) NOT NULL,
  `gst` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0: created, 2: generated, 3: paid',
  `breakdown` tinyint(4) NOT NULL,
  `issued_by` bigint(20) NOT NULL,
  `issued_date` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paid_on` datetime NOT NULL,
  `client_company_name` varchar(100) NOT NULL,
  `client_address` varchar(100) NOT NULL,
  `client_suburb` varchar(100) NOT NULL,
  `client_state` varchar(100) NOT NULL,
  `client_postcode` varchar(100) NOT NULL,
  `client_phone` varchar(100) NOT NULL,
  `client_email_address` varchar(100) NOT NULL,
  `profile_company_name` varchar(100) NOT NULL,
  `profile_abn` varchar(100) NOT NULL,
  `profile_company_email` varchar(255) NOT NULL,
  `profile_company_phone` varchar(255) NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE IF NOT EXISTS `invoice_items` (
  `item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) NOT NULL,
  `job_id` bigint(20) NOT NULL,
  `expense_id` bigint(20) NOT NULL,
  `include_timesheets` tinyint(4) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `tax` int(11) NOT NULL COMMENT '0: no, 1: yes, 2: tax free',
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `job_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '0: temporary, 1: created',
  `client_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_shifts`
--

CREATE TABLE IF NOT EXISTS `job_shifts` (
  `shift_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '-2: deleted, -1: rejected, 0: not assigned, 1: unconfirmed, 2: confirmed, 3: finished',
  `job_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL DEFAULT '0',
  `supervisor_id` bigint(20) NOT NULL,
  `job_date` date NOT NULL,
  `start_time` bigint(20) NOT NULL,
  `finish_time` bigint(20) NOT NULL,
  `break_time` text NOT NULL,
  `venue_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `uniform_id` int(11) NOT NULL,
  `payrate_id` int(11) NOT NULL,
  `payrate_type` varchar(10) NOT NULL,
  `expenses` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=339 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_shift_client_request`
--

CREATE TABLE IF NOT EXISTS `job_shift_client_request` (
  `shift_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `requested_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_shift_staff_apply`
--

CREATE TABLE IF NOT EXISTS `job_shift_staff_apply` (
  `shift_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1: accept, -1: reject',
  `responsed_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_shift_timesheets`
--

CREATE TABLE IF NOT EXISTS `job_shift_timesheets` (
  `timesheet_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '0: pending, 1: submitted, 2: approved, 3: batched, 4: processing, 5: paid',
  `status_payrun_staff` tinyint(4) NOT NULL COMMENT '0: processing, 1: ready, 3: paid',
  `payrun_id` bigint(20) NOT NULL,
  `status_invoice_client` tinyint(4) NOT NULL COMMENT '0: processing, 1: ready, 2: generated, 3: paid',
  `invoice_id` bigint(20) NOT NULL,
  `job_id` bigint(20) NOT NULL,
  `shift_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `supervisor_id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `job_date` date NOT NULL,
  `start_time` bigint(20) NOT NULL,
  `finish_time` bigint(20) NOT NULL,
  `break_time` text NOT NULL,
  `venue_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `uniform_id` int(11) NOT NULL,
  `payrate_id` int(11) NOT NULL,
  `payrate_type` varchar(10) NOT NULL,
  `expenses` text NOT NULL,
  `expenses_staff_cost` decimal(10,2) NOT NULL,
  `expenses_client_cost` decimal(10,2) NOT NULL,
  `staff_payrates` text NOT NULL,
  `total_minutes` decimal(10,2) NOT NULL,
  `total_amount_staff` decimal(10,2) NOT NULL,
  `total_amount_client` decimal(10,2) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL,
  `batched_on` datetime NOT NULL,
  `staff_paid_on` datetime NOT NULL,
  `client_paid_on` datetime NOT NULL,
  PRIMARY KEY (`timesheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `module` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=322 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=386 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

--
-- Table structure for table `payruns`
--

CREATE TABLE IF NOT EXISTS `payruns` (
  `payrun_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '1: tfn, 2: abn',
  `amount` decimal(10,2) NOT NULL,
  `total_staffs` int(11) NOT NULL,
  `total_timesheets` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payrun_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `shift_brief`
--

CREATE TABLE IF NOT EXISTS `shift_brief` (
  `shift_brief_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_id` bigint(20) NOT NULL,
  `brief_id` bigint(20) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`shift_brief_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `staff_custom_attributes`
--

CREATE TABLE IF NOT EXISTS `staff_custom_attributes` (
  `staff_custom_attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `attribute_name` varchar(255) NOT NULL,
  `attributes` text NOT NULL,
  `file_upload` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`staff_custom_attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `staff_groups`
--

CREATE TABLE IF NOT EXISTS `staff_groups` (
  `staff_groups_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `attribute_group_id` int(11) NOT NULL,
  PRIMARY KEY (`staff_groups_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `staff_roles`
--

CREATE TABLE IF NOT EXISTS `staff_roles` (
  `staff_roles_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `attribute_role_id` int(11) NOT NULL,
  PRIMARY KEY (`staff_roles_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `supers`
--

CREATE TABLE IF NOT EXISTS `supers` (
  `super_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`super_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122 ;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `upload_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uploaded_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `full_path` varchar(255) NOT NULL,
  `raw_name` varchar(255) NOT NULL,
  `orig_name` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `file_ext` varchar(10) NOT NULL,
  `file_size` decimal(10,2) NOT NULL,
  `is_image` tinyint(4) NOT NULL,
  `image_width` int(11) NOT NULL,
  `image_height` int(11) NOT NULL,
  `image_type` varchar(10) NOT NULL,
  `image_size_str` varchar(255) NOT NULL,
  PRIMARY KEY (`upload_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL COMMENT '1 = active, 0 = pending, -1 = inactive, 2 = deleted',
  `is_admin` tinyint(4) NOT NULL,
  `is_staff` tinyint(4) NOT NULL,
  `is_client` tinyint(4) NOT NULL,
  `access_level` tinyint(4) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `title` varchar(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `last_signed_in_on` datetime NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_clients`
--

CREATE TABLE IF NOT EXISTS `user_clients` (
  `client_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `external_client_id` varchar(20) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `abn` varchar(20) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `total_jobs_current_year` int(11) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_client_departments`
--

CREATE TABLE IF NOT EXISTS `user_client_departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_staffs`
--

CREATE TABLE IF NOT EXISTS `user_staffs` (
  `staff_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `external_staff_id` varchar(20) NOT NULL,
  `rating` decimal(10,2) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date NOT NULL,
  `emergency_contact` varchar(100) NOT NULL,
  `emergency_phone` varchar(20) NOT NULL,
  `f_aus_resident` tinyint(4) NOT NULL,
  `f_tax_free_threshold` tinyint(4) NOT NULL,
  `f_tax_offset` tinyint(4) NOT NULL,
  `f_senior_status` varchar(100) NOT NULL,
  `f_help_debt` tinyint(4) NOT NULL,
  `f_help_variation` varchar(100) NOT NULL,
  `f_acc_name` varchar(100) NOT NULL,
  `f_acc_number` varchar(100) NOT NULL,
  `f_bsb` varchar(5) NOT NULL,
  `f_employed` int(11) NOT NULL DEFAULT '1',
  `f_abn` varchar(20) NOT NULL,
  `f_require_gst` tinyint(4) NOT NULL,
  `f_tfn` varchar(20) NOT NULL,
  `s_choice` varchar(100) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_employee_id` varchar(100) NOT NULL,
  `s_tfn` varchar(20) NOT NULL,
  `s_fund_name` varchar(100) NOT NULL,
  `s_fund_website` varchar(100) NOT NULL,
  `s_product_id` varchar(100) NOT NULL,
  `s_fund_phone` varchar(100) NOT NULL,
  `s_membership` varchar(100) NOT NULL,
  `s_fund_address` varchar(100) NOT NULL,
  `s_fund_suburb` varchar(100) NOT NULL,
  `s_fund_postcode` varchar(10) NOT NULL,
  `s_fund_state` varchar(10) NOT NULL,
  `s_agree` tinyint(4) NOT NULL,
  `availability` text NOT NULL,
  `payrates` varchar(100) NOT NULL,
  `roles` varchar(100) NOT NULL,
  `locations` text NOT NULL,
  `last_worked_date` datetime NOT NULL COMMENT 'the last date the staff worked on a job',
  `time_sheets_in_payrun` int(11) NOT NULL COMMENT 'number of unpaid time sheet in the payrun',
  `welcome_email_sent` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_staff_availability`
--

CREATE TABLE IF NOT EXISTS `user_staff_availability` (
  `user_id` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `hour` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_staff_picture`
--

CREATE TABLE IF NOT EXISTS `user_staff_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `hero` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;