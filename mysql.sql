-- phpMyAdmin SQL Dump
-- version 2.9.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Dec 26, 2009 at 05:03 AM
-- Server version: 5.0.51
-- PHP Version: 5.3.0-0.dotdeb.8
-- 
-- Database: `shine`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `applications`
-- 

DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `link` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `bundle_name` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `fspath` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
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
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `downloads`
-- 

DROP TABLE IF EXISTS `downloads`;
CREATE TABLE `downloads` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `feedback`
-- 

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `options`
-- 

DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `key` varchar(255) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `orders`
-- 

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `pirates`
-- 

DROP TABLE IF EXISTS `pirates`;
CREATE TABLE `pirates` (
  `id` int(11) NOT NULL auto_increment,
  `app_id` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `guid` varchar(128) NOT NULL,
  `dt` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `sessions`
-- 

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` int(255) NOT NULL auto_increment,
  `data` text collate utf8_unicode_ci NOT NULL,
  `updated_on` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `sparkle_data`
-- 

DROP TABLE IF EXISTS `sparkle_data`;
CREATE TABLE `sparkle_data` (
  `sparkle_id` int(11) NOT NULL,
  `key` varchar(128) NOT NULL,
  `data` varchar(128) NOT NULL,
  KEY `sparkle_id` (`sparkle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `sparkle_reports`
-- 

DROP TABLE IF EXISTS `sparkle_reports`;
CREATE TABLE `sparkle_reports` (
  `id` int(11) NOT NULL auto_increment,
  `dt` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(65) collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(65) collate utf8_unicode_ci NOT NULL default '',
  `level` enum('user','admin') collate utf8_unicode_ci NOT NULL default 'user',
  `email` varchar(65) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `versions`
-- 

DROP TABLE IF EXISTS `versions`;
CREATE TABLE `versions` (
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
  `pirate_count` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
