ALTER TABLE  `forum_topics` CHANGE  `type`  `type` ENUM(  'poll',  'conversation',  'support' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT  'conversation';
