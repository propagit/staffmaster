CREATE TABLE `user_notes` (
`user_note_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `added_by` bigint(20) NOT NULL COMMENT 'user id of the admin who added the note',
  `note` text NOT NULL,
  `created_date` date NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;