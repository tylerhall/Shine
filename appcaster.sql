-- phpMyAdmin SQL Dump
-- version 2.9.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 15, 2009 at 11:51 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.6
-- 
-- Database: `appcaster`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `applications`
-- 

CREATE TABLE `applications` (
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
  `ap_key` text NOT NULL,
  `ap_pkey` text NOT NULL,
  `from_email` varchar(128) NOT NULL default '',
  `email_subject` varchar(128) NOT NULL default '',
  `email_body` text NOT NULL,
  `license_filename` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `orders`
-- 

CREATE TABLE `orders` (
  `id` int(11) NOT NULL auto_increment,
  `app_id` int(11) NOT NULL,
  `dt` datetime NOT NULL,
  `txn_type` varchar(25) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `residence_country` varchar(25) NOT NULL,
  `item_name` varchar(25) NOT NULL,
  `payment_gross` float NOT NULL,
  `mc_currency` varchar(25) NOT NULL,
  `business` varchar(128) NOT NULL,
  `payment_type` varchar(25) NOT NULL,
  `verify_sign` varchar(128) NOT NULL,
  `payer_status` varchar(25) NOT NULL,
  `tax` float NOT NULL,
  `payer_email` varchar(128) NOT NULL,
  `txn_id` varchar(128) NOT NULL,
  `quantity` int(11) NOT NULL,
  `receiver_email` varchar(128) NOT NULL,
  `payer_id` varchar(128) NOT NULL,
  `receiver_id` varchar(128) NOT NULL,
  `item_number` varchar(25) NOT NULL,
  `payment_status` varchar(25) NOT NULL,
  `payment_fee` float NOT NULL,
  `mc_fee` float NOT NULL,
  `shipping` float NOT NULL,
  `mc_gross` float NOT NULL,
  `custom` varchar(255) NOT NULL,
  `license` text NOT NULL,
  `type` enum('PayPal','Manual','Student') NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `hash` varchar(5) NOT NULL,
  `claimed` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `sessions`
-- 

CREATE TABLE `sessions` (
  `id` int(255) NOT NULL auto_increment,
  `data` text collate utf8_unicode_ci NOT NULL,
  `updated_on` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `sparkle_data`
-- 

CREATE TABLE `sparkle_data` (
  `sparkle_id` int(11) NOT NULL,
  `key` varchar(128) NOT NULL,
  `data` varchar(128) NOT NULL,
  KEY `sparkle_id` (`sparkle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `sparkle_reports`
-- 

CREATE TABLE `sparkle_reports` (
  `id` int(11) NOT NULL auto_increment,
  `dt` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(65) collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(65) collate utf8_unicode_ci NOT NULL default '',
  `level` enum('user','admin') collate utf8_unicode_ci NOT NULL default 'user',
  `email` varchar(65) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `versions`
-- 

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
  `signature` varchar(65) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
