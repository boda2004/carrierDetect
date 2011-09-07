-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 07, 2011 at 04:06 PM
-- Server version: 5.1.45
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `carrier_detect`
--

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
-- Constraints for table `ip_ranges`
--
ALTER TABLE `ip_ranges`
  ADD CONSTRAINT `ip_ranges_ibfk_1` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
