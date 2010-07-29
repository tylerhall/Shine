-- 
-- Table structure for table `shine_applications`
-- 

DROP TABLE IF EXISTS `shine_applications`;
CREATE TABLE IF NOT EXISTS `shine_applications` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `link` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `bundle_name` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `s3key` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `s3pkey` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `s3bucket` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `s3path` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `sparkle_key` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `sparkle_pkey` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `ap_key` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `ap_pkey` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `from_email` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL,
  `email_subject` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL,
  `email_body` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `license_filename` varchar(64) character set utf8 collate utf8_unicode_ci NOT NULL,
  `custom_salt` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `license_type` enum('ap','custom') character set utf8 collate utf8_unicode_ci NOT NULL,
  `return_url` varchar(255) NOT NULL,
  `fs_security_key` varchar(45) NOT NULL,
  `i_use_this_key` varchar(45) NOT NULL,
  `tweet_terms` text NOT NULL,
  `hidden` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_downloads`
-- 

DROP TABLE IF EXISTS `shine_downloads`;
CREATE TABLE IF NOT EXISTS `shine_downloads` (
  `id` int(11) NOT NULL auto_increment,
  `dt` datetime NOT NULL default '0000-00-00 00:00:00',
  `referer` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `referer_is_local` tinyint(4) NOT NULL default '0',
  `url` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `page_title` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `search_terms` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `img_search` tinyint(4) NOT NULL default '0',
  `browser_family` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `browser_version` varchar(15) collate utf8_unicode_ci NOT NULL default '',
  `os` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `os_version` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `ip` varchar(15) collate utf8_unicode_ci NOT NULL default '',
  `user_agent` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `exec_time` float NOT NULL default '0',
  `num_queries` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=47931 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_feedback`
-- 

DROP TABLE IF EXISTS `shine_feedback`;
CREATE TABLE IF NOT EXISTS `shine_feedback` (
  `id` int(11) NOT NULL auto_increment,
  `appname` varchar(255) NOT NULL,
  `appversion` varchar(255) NOT NULL,
  `systemversion` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reply` tinyint(4) NOT NULL,
  `type` enum('support','feature','bug') NOT NULL,
  `message` text NOT NULL,
  `importance` varchar(255) NOT NULL,
  `critical` tinyint(4) NOT NULL,
  `dt` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `new` tinyint(4) NOT NULL,
  `starred` tinyint(4) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `reguser` varchar(255) NOT NULL,
  `regmail` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_milestones`
-- 

DROP TABLE IF EXISTS `shine_milestones`;
CREATE TABLE IF NOT EXISTS `shine_milestones` (
  `id` int(11) NOT NULL auto_increment,
  `app_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `dt_due` datetime NOT NULL,
  `description` text NOT NULL,
  `status_to` enum('open','resolved') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_options`
-- 

DROP TABLE IF EXISTS `shine_options`;
CREATE TABLE IF NOT EXISTS `shine_options` (
  `key` varchar(255) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_orders`
-- 

DROP TABLE IF EXISTS `shine_orders`;
CREATE TABLE IF NOT EXISTS `shine_orders` (
  `id` int(11) NOT NULL auto_increment,
  `app_id` int(11) NOT NULL,
  `dt` datetime NOT NULL,
  `txn_type` varchar(25) character set latin1 NOT NULL,
  `first_name` varchar(128) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(128) collate utf8_unicode_ci NOT NULL,
  `residence_country` varchar(25) character set latin1 NOT NULL,
  `item_name` varchar(25) character set latin1 NOT NULL,
  `payment_gross` float NOT NULL,
  `mc_currency` varchar(25) character set latin1 NOT NULL,
  `business` varchar(128) character set latin1 NOT NULL,
  `payment_type` varchar(25) character set latin1 NOT NULL,
  `verify_sign` varchar(128) character set latin1 NOT NULL,
  `payer_status` varchar(25) character set latin1 NOT NULL,
  `tax` float NOT NULL,
  `payer_email` varchar(128) collate utf8_unicode_ci NOT NULL,
  `txn_id` varchar(128) character set latin1 NOT NULL,
  `quantity` int(11) NOT NULL,
  `receiver_email` varchar(128) character set latin1 NOT NULL,
  `payer_id` varchar(128) character set latin1 NOT NULL,
  `receiver_id` varchar(128) character set latin1 NOT NULL,
  `item_number` varchar(25) character set latin1 NOT NULL,
  `payment_status` varchar(25) character set latin1 NOT NULL,
  `payment_fee` float NOT NULL,
  `mc_fee` float NOT NULL,
  `shipping` float NOT NULL,
  `mc_gross` float NOT NULL,
  `custom` varchar(255) character set latin1 NOT NULL,
  `license` text character set latin1 NOT NULL,
  `type` enum('PayPal','Manual','Student','MUPromo','FastSpring') character set latin1 NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `hash` varchar(5) character set latin1 NOT NULL,
  `claimed` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2388 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_sessions`
-- 

DROP TABLE IF EXISTS `shine_sessions`;
CREATE TABLE IF NOT EXISTS `shine_sessions` (
  `id` int(255) NOT NULL auto_increment,
  `data` text collate utf8_unicode_ci NOT NULL,
  `updated_on` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2147483648 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_sparkle_data`
-- 

DROP TABLE IF EXISTS `shine_sparkle_data`;
CREATE TABLE IF NOT EXISTS `shine_sparkle_data` (
  `sparkle_id` int(11) NOT NULL,
  `key` varchar(128) NOT NULL,
  `data` varchar(128) NOT NULL,
  KEY `sparkle_id` (`sparkle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_sparkle_reports`
-- 

DROP TABLE IF EXISTS `shine_sparkle_reports`;
CREATE TABLE IF NOT EXISTS `shine_sparkle_reports` (
  `id` int(11) NOT NULL auto_increment,
  `dt` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122777 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_ticket_history`
-- 

DROP TABLE IF EXISTS `shine_ticket_history`;
CREATE TABLE IF NOT EXISTS `shine_ticket_history` (
  `id` int(11) NOT NULL auto_increment,
  `dt` datetime NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_from` enum('new','open','resolved','hold','invalid') NOT NULL,
  `status_to` enum('new','open','resolved','hold','invalid') NOT NULL,
  `milestone_from_id` int(11) NOT NULL,
  `milestone_to_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_tickets`
-- 

DROP TABLE IF EXISTS `shine_tickets`;
CREATE TABLE IF NOT EXISTS `shine_tickets` (
  `id` int(11) NOT NULL auto_increment,
  `app_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL,
  `status` enum('new','open','resolved','hold','invalid') NOT NULL,
  `dt_created` datetime NOT NULL,
  `dt_last_state` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_tweets`
-- 

DROP TABLE IF EXISTS `shine_tweets`;
CREATE TABLE IF NOT EXISTS `shine_tweets` (
  `id` int(11) NOT NULL auto_increment,
  `tweet_id` bigint(20) NOT NULL,
  `username` varchar(55) NOT NULL,
  `app_id` int(11) NOT NULL,
  `dt` datetime NOT NULL,
  `body` text NOT NULL,
  `profile_img` varchar(255) NOT NULL,
  `new` tinyint(4) NOT NULL,
  `replied_to` tinyint(4) NOT NULL,
  `reply_date` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`tweet_id`,`app_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=788 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_users`
-- 

DROP TABLE IF EXISTS `shine_users`;
CREATE TABLE IF NOT EXISTS `shine_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(65) collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(65) collate utf8_unicode_ci NOT NULL default '',
  `level` enum('user','admin') collate utf8_unicode_ci NOT NULL default 'user',
  `email` varchar(65) collate utf8_unicode_ci default NULL,
  `twitter` varchar(128) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_versions`
-- 

DROP TABLE IF EXISTS `shine_versions`;
CREATE TABLE IF NOT EXISTS `shine_versions` (
  `id` int(11) NOT NULL auto_increment,
  `app_id` int(11) NOT NULL default '0',
  `human_version` varchar(128) collate utf8_unicode_ci NOT NULL,
  `version_number` varchar(10) collate utf8_unicode_ci NOT NULL default '',
  `dt` datetime NOT NULL default '0000-00-00 00:00:00',
  `release_notes` text collate utf8_unicode_ci NOT NULL,
  `filesize` bigint(20) NOT NULL default '0',
  `url` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `downloads` int(11) NOT NULL default '0',
  `updates` int(11) NOT NULL,
  `signature` varchar(65) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=124 ;
