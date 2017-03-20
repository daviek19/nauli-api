-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2017 at 09:55 PM
-- Server version: 5.5.54-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `workshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_master`
--

CREATE TABLE IF NOT EXISTS `group_master` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `group_name` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_name` (`group_name`),
  UNIQUE KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `group_master`
--

INSERT INTO `group_master` (`group_id`, `company_id`, `group_name`, `date_created`) VALUES
(1, 2, 'STEEL', '2017-03-12 00:00:00'),
(2, 2, 'CONSUMABLES', '2017-03-12 00:00:00'),
(3, 2, 'PAINT', '2017-03-15 21:37:42'),
(4, 2, 'ALUMINIUM', '2017-03-15 21:43:42'),
(5, 2, 'ABC', '2017-03-18 10:24:39');

--
-- Triggers `group_master`
--
DROP TRIGGER IF EXISTS `group_master_date_time`;
DELIMITER //
CREATE TRIGGER `group_master_date_time` BEFORE INSERT ON `group_master`
 FOR EACH ROW SET NEW.date_created = NOW()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `parameter_description`
--

CREATE TABLE IF NOT EXISTS `parameter_description` (
  `company_id` int(11) NOT NULL,
  `description_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `description_name` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`description_id`),
  UNIQUE KEY `description_name` (`description_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `parameter_description`
--

INSERT INTO `parameter_description` (`company_id`, `description_id`, `item_id`, `description_name`, `date_created`) VALUES
(2, 1, 1, 'Kgs', '2017-03-16 00:00:00'),
(2, 2, 1, 'Pcs', '2017-03-16 00:00:00'),
(2, 3, 1, 'Rolls', '2017-03-16 00:00:00'),
(2, 4, 2, 'Isuzu', '2017-03-16 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `parameter_item`
--

CREATE TABLE IF NOT EXISTS `parameter_item` (
  `company_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_name` (`item_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `parameter_item`
--

INSERT INTO `parameter_item` (`company_id`, `item_id`, `item_name`, `date_created`) VALUES
(2, 1, 'Unit', '2017-03-16 00:00:00'),
(2, 2, 'Vehicle Make', '2017-03-16 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE IF NOT EXISTS `process` (
  `company_id` int(11) NOT NULL,
  `process_id` int(11) NOT NULL AUTO_INCREMENT,
  `process_name` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`process_id`),
  UNIQUE KEY `process_name` (`process_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_groups`
--

CREATE TABLE IF NOT EXISTS `sub_groups` (
  `subgroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `subgroup_name` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`subgroup_id`),
  UNIQUE KEY `company_id` (`company_id`,`group_id`,`subgroup_name`),
  KEY `group_id_fk` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sub_groups`
--

INSERT INTO `sub_groups` (`subgroup_id`, `company_id`, `group_id`, `subgroup_name`, `date_created`) VALUES
(1, 2, 1, 'STEEL 1', '2017-03-12 00:00:00'),
(2, 2, 3, 'RED BASCO PAINT', '2017-03-15 21:38:45'),
(3, 2, 4, 'YANA 17 IN', '2017-03-15 21:44:36'),
(4, 2, 4, 'YANA 21 IN', '2017-03-15 21:44:57'),
(5, 2, 3, 'BLACK BASCO PAINT', '2017-03-15 21:45:36');

--
-- Triggers `sub_groups`
--
DROP TRIGGER IF EXISTS `sub_groups_date_time`;
DELIMITER //
CREATE TRIGGER `sub_groups_date_time` BEFORE INSERT ON `sub_groups`
 FOR EACH ROW SET NEW.date_created = NOW()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE IF NOT EXISTS `warehouse` (
  `wh_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `wh_name` varchar(256) NOT NULL,
  `wh_loc` varchar(256) NOT NULL,
  `active` char(1) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`wh_id`),
  UNIQUE KEY `wh_name` (`wh_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`wh_id`, `company_id`, `wh_name`, `wh_loc`, `active`, `date_created`) VALUES
(1, 2, 'MAIN WAREHOUSE', 'HO', 'Y', '2017-03-16 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_groups`
--
ALTER TABLE `sub_groups`
  ADD CONSTRAINT `group_id_fk` FOREIGN KEY (`group_id`) REFERENCES `group_master` (`group_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
