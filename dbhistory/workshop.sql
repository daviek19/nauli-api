-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2017 at 05:16 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_master`
--

CREATE TABLE `group_master` (
  `group_id` int(11) NOT NULL,
  `sub_classification_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `group_name` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_master`
--

INSERT INTO `group_master` (`group_id`, `sub_classification_id`, `company_id`, `group_name`, `date_created`) VALUES
(1, 6, 2, 'STEEL', '2017-03-12 00:00:00'),
(2, 6, 2, 'CONSUMABLES', '2017-03-12 00:00:00'),
(3, 6, 2, 'PAINT', '2017-03-15 21:37:42'),
(4, 6, 2, 'ALUMINIUMS', '2017-03-15 21:43:42');

--
-- Triggers `group_master`
--
DELIMITER $$
CREATE TRIGGER `group_master_date_time` BEFORE INSERT ON `group_master` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `parameter_description`
--

CREATE TABLE `parameter_description` (
  `description_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `description_name` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parameter_description`
--

INSERT INTO `parameter_description` (`description_id`, `company_id`, `item_id`, `description_name`, `date_created`) VALUES
(1, 2, 1, 'Kgs', '2017-03-16 00:00:00'),
(2, 2, 1, 'Pcs', '2017-03-16 00:00:00'),
(3, 2, 1, 'Rolls', '2017-03-16 00:00:00'),
(4, 2, 2, 'Isuzu', '2017-03-16 00:00:00'),
(5, 2, 1, 'testing123EDITED', '2017-03-18 00:00:00'),
(6, 2, 7, 'CLASSIF1', '2017-03-19 13:44:23'),
(7, 2, 7, 'CLASSIF1.2', '2017-03-19 13:46:06'),
(8, 2, 7, 'CLASSIF1.1', '2017-03-19 13:52:44'),
(9, 2, 2, 'OPEL', '2017-03-19 13:58:58');

--
-- Triggers `parameter_description`
--
DELIMITER $$
CREATE TRIGGER `parameter_description_date_time` BEFORE INSERT ON `parameter_description` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `parameter_item`
--

CREATE TABLE `parameter_item` (
  `company_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parameter_item`
--

INSERT INTO `parameter_item` (`company_id`, `item_id`, `item_name`, `date_created`) VALUES
(2, 1, 'UNITS', '2017-03-16 00:00:00'),
(2, 2, 'VEHICLE MAKES', '2017-03-16 00:00:00'),
(2, 3, 'CHASIS', '2017-03-16 09:12:08'),
(2, 4, 'PARAM1', '2017-03-16 20:01:10'),
(2, 5, 'GROUP', '2017-03-16 20:03:40'),
(2, 6, 'PARAM1.1', '2017-03-16 20:13:20'),
(2, 7, 'CLASSIFICATIONS', '2017-03-16 20:28:05'),
(2, 8, 'PARAM1.2', '2017-03-18 20:24:31');

--
-- Triggers `parameter_item`
--
DELIMITER $$
CREATE TRIGGER `parameter_item_date_time` BEFORE INSERT ON `parameter_item` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_groups`
--

CREATE TABLE `sub_groups` (
  `subgroup_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `subgroup_name` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
DELIMITER $$
CREATE TRIGGER `sub_groups_date_time` BEFORE INSERT ON `sub_groups` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `wh_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `wh_name` varchar(256) NOT NULL,
  `wh_loc` varchar(256) NOT NULL,
  `active` char(1) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`wh_id`, `company_id`, `wh_name`, `wh_loc`, `active`, `date_created`) VALUES
(1, 1, 'MAIN WAREHOUSE', 'HO', 'Y', '2017-03-16 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_master`
--
ALTER TABLE `group_master`
  ADD PRIMARY KEY (`group_id`),
  ADD UNIQUE KEY `group_name` (`group_name`),
  ADD UNIQUE KEY `group_id` (`group_id`);

--
-- Indexes for table `parameter_description`
--
ALTER TABLE `parameter_description`
  ADD PRIMARY KEY (`description_id`),
  ADD UNIQUE KEY `description_name` (`description_name`);

--
-- Indexes for table `parameter_item`
--
ALTER TABLE `parameter_item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_name` (`item_name`);

--
-- Indexes for table `sub_groups`
--
ALTER TABLE `sub_groups`
  ADD PRIMARY KEY (`subgroup_id`),
  ADD UNIQUE KEY `company_id` (`company_id`,`group_id`,`subgroup_name`),
  ADD KEY `group_id_fk` (`group_id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`wh_id`),
  ADD UNIQUE KEY `wh_name` (`wh_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_master`
--
ALTER TABLE `group_master`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `parameter_description`
--
ALTER TABLE `parameter_description`
  MODIFY `description_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `parameter_item`
--
ALTER TABLE `parameter_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `sub_groups`
--
ALTER TABLE `sub_groups`
  MODIFY `subgroup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `wh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
