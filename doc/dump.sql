-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2011 at 03:12 PM
-- Server version: 5.1.45
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `carrier_detect`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE IF NOT EXISTS `campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign` varchar(64) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `campaign` (`campaign`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `campaign`, `description`) VALUES
(1, 'campaign', 'My first campaign');

-- --------------------------------------------------------

--
-- Table structure for table `carriers`
--

DROP TABLE IF EXISTS `carriers`;
CREATE TABLE IF NOT EXISTS `carriers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carrier` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `redirect_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carrier` (`carrier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `carriers`
--

INSERT INTO `carriers` (`id`, `carrier`, `description`, `redirect_url`) VALUES
(1, 'default', 'fallback', 'http://google.com?ref=default'),
(2, 'test', 'test carrier', 'http://google.com?ref=test');

-- --------------------------------------------------------

--
-- Table structure for table `carrier_campaign`
--

DROP TABLE IF EXISTS `carrier_campaign`;
CREATE TABLE IF NOT EXISTS `carrier_campaign` (
  `carrier_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `redirect_url` varchar(255) NOT NULL,
  UNIQUE KEY `carrier_id` (`carrier_id`,`campaign_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carrier_campaign`
--

INSERT INTO `carrier_campaign` (`carrier_id`, `campaign_id`, `redirect_url`) VALUES
(2, 1, 'http://google.com?ref=localhost_my_campaign');

-- --------------------------------------------------------

--
-- Table structure for table `ip_ranges`
--

DROP TABLE IF EXISTS `ip_ranges`;
CREATE TABLE IF NOT EXISTS `ip_ranges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `min_ip` int(10) unsigned NOT NULL,
  `max_ip` int(10) unsigned NOT NULL,
  `carrier_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `carrier_id` (`carrier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ip_ranges`
--

INSERT INTO `ip_ranges` (`id`, `min_ip`, `max_ip`, `carrier_id`, `priority`) VALUES
(1, 0, 4294967295, 1, -999),
(2, 2130706432, 2147483647, 2, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carrier_campaign`
--
ALTER TABLE `carrier_campaign`
  ADD CONSTRAINT `carrier_campaign_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carrier_campaign_ibfk_1` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ip_ranges`
--
ALTER TABLE `ip_ranges`
  ADD CONSTRAINT `ip_ranges_ibfk_1` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
