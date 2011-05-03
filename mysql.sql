# Dump of table shine_activations
# ------------------------------------------------------------

CREATE TABLE `shine_activations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `serial_number` varchar(128) DEFAULT NULL,
  `guid` varchar(255) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Table structure for table `shine_applications`
-- 

CREATE TABLE IF NOT EXISTS `shine_applications` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `link` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `bundle_name` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `upgrade_app_id` int(11) NOT NULL,
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
  `engine_class_name` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_downloads`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_feedback`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_options`
-- 

CREATE TABLE IF NOT EXISTS `shine_options` (
  `key` varchar(255) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_orders`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_sessions`
-- 

CREATE TABLE IF NOT EXISTS `shine_sessions` (
  `id` int(255) NOT NULL auto_increment,
  `data` text collate utf8_unicode_ci NOT NULL,
  `updated_on` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_sparkle_data`
-- 

CREATE TABLE IF NOT EXISTS `shine_sparkle_data` (
  `sparkle_id` int(11) NOT NULL,
  `key` varchar(128) NOT NULL,
  `data` varchar(128) NOT NULL,
  KEY `sparkle_id` (`sparkle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_sparkle_reports`
-- 

CREATE TABLE IF NOT EXISTS `shine_sparkle_reports` (
  `id` int(11) NOT NULL auto_increment,
  `dt` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_tweets`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_users`
-- 

CREATE TABLE IF NOT EXISTS `shine_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(65) collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(65) collate utf8_unicode_ci NOT NULL default '',
  `level` enum('user','admin') collate utf8_unicode_ci NOT NULL default 'user',
  `email` varchar(65) collate utf8_unicode_ci default NULL,
  `twitter` varchar(128) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `shine_versions`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
