-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2017 at 03:28 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rest_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `company_type_id` int(11) DEFAULT NULL,
  `company_size_id` int(11) DEFAULT NULL,
  `company_phone` varchar(15) DEFAULT NULL,
  `company_email` varchar(60) DEFAULT NULL,
  `company_kra_pin` varchar(15) DEFAULT NULL,
  `company_taxrate_id` int(11) DEFAULT NULL,
  `company_currency_id` int(11) DEFAULT NULL,
  `company_logo_location` varchar(256) DEFAULT NULL,
  `company_print_recepit` tinyint(1) DEFAULT NULL,
  `company_currency_right` tinyint(1) DEFAULT NULL,
  `company_created_by` int(11) DEFAULT NULL,
  `current_payroll_month` datetime NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `company_type_id`, `company_size_id`, `company_phone`, `company_email`, `company_kra_pin`, `company_taxrate_id`, `company_currency_id`, `company_logo_location`, `company_print_recepit`, `company_currency_right`, `company_created_by`, `current_payroll_month`, `date_created`) VALUES
(1, 'Enterprise data solutions lt', 3, 2, '254729003109', 'daviek19@gmail.com', NULL, NULL, 1, NULL, 1, NULL, 6, '2016-12-01 00:00:00', '2016-11-29 22:40:15'),
(2, 'Venture data labs', 2, 2, '0729003109', 'info@ed.com', NULL, NULL, 1, NULL, 1, NULL, 8, '2016-12-01 00:00:00', '2016-12-12 14:56:00');

--
-- Triggers `company`
--
DELIMITER $$
CREATE TRIGGER `date_time` BEFORE INSERT ON `company` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(256) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `company_id`, `date_created`) VALUES
(1, 'Accounts', 0, '2017-01-15 12:13:27'),
(18, 'workshop', 2, '2017-01-17 21:21:19'),
(19, 'casual', 2, '2017-01-18 16:23:24'),
(20, 'sales', 2, '2017-01-28 15:22:32'),
(21, 'testing123', 2, '2017-01-28 16:23:51'),
(22, 'testing 2', 2, '2017-03-06 17:30:23'),
(23, 'testing 23 new', 2, '2017-03-16 13:16:46');

--
-- Triggers `departments`
--
DELIMITER $$
CREATE TRIGGER `department_date_time` BEFORE INSERT ON `departments` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `earning_deduction_codes`
--

CREATE TABLE `earning_deduction_codes` (
  `code_id` int(11) NOT NULL,
  `code_name` varchar(30) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `earning_deduction_codes`
--

INSERT INTO `earning_deduction_codes` (`code_id`, `code_name`, `is_active`, `date_created`) VALUES
(1, 'Basic Salary', 1, '2016-12-31 19:48:15'),
(2, 'NSSF', 1, '2016-12-31 19:48:15'),
(3, 'NHIF', 1, '2016-12-31 19:48:47'),
(4, 'PAYEE', 1, '2016-12-31 19:48:47'),
(5, 'House Allowances ', 1, '2016-12-31 19:54:09');

--
-- Triggers `earning_deduction_codes`
--
DELIMITER $$
CREATE TRIGGER `earning_deduction_created` BEFORE INSERT ON `earning_deduction_codes` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 1, '1234', 0, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(5813, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620810, 0.776224, '1', 200),
(5814, 'person/person/12.xml', 'get', 'a:5:{s:2:"id";s:2:"12";s:6:"format";s:3:"xml";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620811, 0.339248, '1', 200),
(5815, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620822, 0.417802, '1', 200),
(5816, 'person/person/12.xml', 'get', 'a:5:{s:2:"id";s:2:"12";s:6:"format";s:3:"xml";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620823, 0.291399, '1', 200),
(5817, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620835, 0.468108, '1', 200),
(5818, 'workshop/items/2', 'get', 'a:4:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620836, 0.667724, '1', 0),
(5819, 'workshop/subparameters/find_by_item_id/9', 'get', 'a:4:{s:7:"item_id";s:1:"9";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620838, 0.55726, '1', 0),
(5820, 'workshop/warehouses/2', 'get', 'a:4:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620838, 0.515268, '1', 0),
(5821, 'workshop/subparameters/find_by_item_id/1', 'get', 'a:4:{s:7:"item_id";s:1:"1";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620839, 0.236009, '1', 0),
(5822, 'workshop/subparameters/find_by_item_id/7', 'get', 'a:4:{s:7:"item_id";s:1:"7";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620840, 0.288047, '1', 0),
(5823, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620996, 0.329723, '1', 200),
(5824, 'workshop/items/2', 'get', 'a:4:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620997, 0.52029, '1', 200),
(5825, 'workshop/subparameters/find_by_item_id/9', 'get', 'a:4:{s:7:"item_id";s:1:"9";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620998, 0.291875, '1', 200),
(5826, 'workshop/warehouses/2', 'get', 'a:4:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620998, 0.292768, '1', 200),
(5827, 'workshop/subparameters/find_by_item_id/1', 'get', 'a:4:{s:7:"item_id";s:1:"1";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490620999, 0.326717, '1', 200),
(5828, 'workshop/subparameters/find_by_item_id/7', 'get', 'a:4:{s:7:"item_id";s:1:"7";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621000, 0.336674, '1', 200),
(5829, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621024, 0.255379, '1', 200),
(5830, 'workshop/items/2', 'get', 'a:4:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621024, 0.301455, '1', 200),
(5831, 'workshop/subparameters/find_by_item_id/9', 'get', 'a:4:{s:7:"item_id";s:1:"9";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621025, 0.244996, '1', 200),
(5832, 'workshop/warehouses/2', 'get', 'a:4:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621025, 0.296467, '1', 200),
(5833, 'workshop/subparameters/find_by_item_id/1', 'get', 'a:4:{s:7:"item_id";s:1:"1";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621026, 0.325978, '1', 200),
(5834, 'workshop/subparameters/find_by_item_id/7', 'get', 'a:4:{s:7:"item_id";s:1:"7";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621026, 0.289077, '1', 200),
(5835, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621067, 0.239933, '1', 200),
(5836, 'workshop/groups/find_by_classification/6', 'get', 'a:4:{s:17:"classification_id";s:1:"6";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621067, 0.331846, '1', 200),
(5837, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621071, 0.209286, '1', 200),
(5838, 'workshop/subgroups/find_subgroup_by_group_id/1', 'get', 'a:4:{s:8:"group_id";s:1:"1";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621071, 0.252886, '1', 200),
(5839, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621097, 0.289292, '1', 200),
(5840, 'workshop/groups/find_by_classification/7', 'get', 'a:4:{s:17:"classification_id";s:1:"7";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621097, 0.218903, '1', 200),
(5841, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621100, 0.271898, '1', 200),
(5842, 'workshop/subgroups/find_subgroup_by_group_id/4', 'get', 'a:4:{s:8:"group_id";s:1:"4";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621101, 0.237442, '1', 200),
(5843, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621106, 0.275155, '1', 200),
(5844, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621125, 0.216765, '1', 200),
(5845, 'workshop/items', 'put', 'a:17:{s:4:"Host";s:9:"localhost";s:6:"Accept";s:16:"application/json";s:9:"X-API-KEY";s:4:"1234";s:12:"Content-type";s:16:"application/json";s:14:"Content-Length";s:3:"206";s:10:"company_id";s:1:"2";s:7:"item_no";s:5:"SHOO1";s:9:"item_name";s:10:"SH 10 * 30";s:14:"description_id";s:1:"7";s:8:"group_id";s:1:"4";s:11:"subgroup_id";s:1:"3";s:5:"wh_id";s:1:"4";s:4:"cost";s:4:"2500";s:11:"reorder_qty";s:2:"10";s:12:"item_unit_id";s:1:"3";s:7:"min_qty";s:1:"1";s:6:"active";s:1:"1";}', '1234', '::1', 1490621126, 0.472563, '1', 201),
(5846, 'workshop/items/2', 'get', 'a:5:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:16:"application/json";s:9:"X-API-KEY";s:4:"1234";s:12:"Content-type";s:16:"application/json";}', '1234', '::1', 1490621126, 0.221878, '1', 200),
(5847, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621132, 0.313239, '1', 200),
(5848, 'workshop/items/find/5', 'get', 'a:4:{s:7:"item_id";s:1:"5";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621132, 0.216299, '1', 200),
(5849, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621133, 0.231139, '1', 200),
(5850, 'workshop/subgroups/find_subgroup_by_group_id/4', 'get', 'a:4:{s:8:"group_id";s:1:"4";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621134, 0.265075, '1', 200),
(5851, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621134, 0.201838, '1', 200),
(5852, 'workshop/groups/find_by_classification/7', 'get', 'a:4:{s:17:"classification_id";s:1:"7";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621135, 0.245317, '1', 200),
(5853, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621140, 0.263372, '1', 200),
(5854, 'workshop/items', 'post', 'a:17:{s:4:"Host";s:9:"localhost";s:6:"Accept";s:16:"application/json";s:9:"X-API-KEY";s:4:"1234";s:12:"Content-type";s:16:"application/json";s:14:"Content-Length";s:3:"203";s:7:"item_id";s:1:"5";s:7:"item_no";s:5:"SHOO1";s:9:"item_name";s:10:"SH 10 * 45";s:14:"description_id";s:1:"7";s:8:"group_id";s:1:"4";s:11:"subgroup_id";s:1:"3";s:5:"wh_id";s:1:"4";s:4:"cost";s:4:"2500";s:11:"reorder_qty";s:2:"10";s:12:"item_unit_id";s:1:"3";s:7:"min_qty";s:1:"1";s:6:"active";s:1:"1";}', '1234', '::1', 1490621140, 0.491406, '1', 200),
(5855, 'workshop/items/2', 'get', 'a:5:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:16:"application/json";s:9:"X-API-KEY";s:4:"1234";s:12:"Content-type";s:16:"application/json";}', '1234', '::1', 1490621141, 0.306039, '1', 200),
(5856, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621172, 0.252939, '1', 200),
(5857, 'workshop/warehouses/2', 'get', 'a:4:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621173, 0.202569, '1', 200),
(5858, 'workshop/subparameters/find_by_item_id/9', 'get', 'a:4:{s:7:"item_id";s:1:"9";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621173, 0.237632, '1', 200),
(5859, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621178, 0.303881, '1', 200),
(5860, 'workshop/items/2', 'get', 'a:4:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621179, 0.242224, '1', 200),
(5861, 'workshop/subparameters/find_by_item_id/9', 'get', 'a:4:{s:7:"item_id";s:1:"9";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621179, 0.233452, '1', 200),
(5862, 'workshop/warehouses/2', 'get', 'a:4:{s:10:"company_id";s:1:"2";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621180, 0.204752, '1', 200),
(5863, 'workshop/subparameters/find_by_item_id/1', 'get', 'a:4:{s:7:"item_id";s:1:"1";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621180, 0.192743, '1', 200),
(5864, 'workshop/subparameters/find_by_item_id/7', 'get', 'a:4:{s:7:"item_id";s:1:"7";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621180, 0.19943, '1', 200),
(5865, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621195, 0.244649, '1', 200),
(5866, 'workshop/items/find/5', 'get', 'a:4:{s:7:"item_id";s:1:"5";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621196, 0.309767, '1', 200),
(5867, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621197, 0.239773, '1', 200),
(5868, 'workshop/groups/find_by_classification/7', 'get', 'a:4:{s:17:"classification_id";s:1:"7";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621197, 0.234559, '1', 200),
(5869, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621198, 0.336021, '1', 200),
(5870, 'workshop/subgroups/find_subgroup_by_group_id/4', 'get', 'a:4:{s:8:"group_id";s:1:"4";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621198, 0.267538, '1', 200),
(5871, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621203, 0.35297, '1', 200),
(5872, 'workshop/groups/find_by_classification/13', 'get', 'a:4:{s:17:"classification_id";s:2:"13";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621204, 0.267517, '1', 200),
(5873, 'person/user/8', 'get', 'a:4:{s:2:"id";s:1:"8";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621207, 0.221402, '1', 200),
(5874, 'workshop/subgroups/find_subgroup_by_group_id/6', 'get', 'a:4:{s:8:"group_id";s:1:"6";s:4:"Host";s:9:"localhost";s:6:"Accept";s:3:"*/*";s:9:"X-API-KEY";s:4:"1234";}', '1234', '::1', 1490621207, 0.329083, '1', 200);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_earning_deduction_codes`
--

CREATE TABLE `payroll_earning_deduction_codes` (
  `earning_deduction_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `posting_type_id` int(11) NOT NULL,
  `earning_deduction_name` varchar(256) NOT NULL,
  `recurrent` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_earning_deduction_codes`
--

INSERT INTO `payroll_earning_deduction_codes` (`earning_deduction_id`, `company_id`, `posting_type_id`, `earning_deduction_name`, `recurrent`, `date_created`) VALUES
(1, 0, 1, 'Basic Pay', 1, '2017-01-13 15:20:40'),
(2, 0, 2, 'Advance ', 1, '2017-01-13 15:21:05'),
(3, 0, 1, 'House Allowance', 1, '2017-01-13 15:21:58'),
(4, 2, 2, 'Union Dues', 0, '2017-01-13 15:31:38'),
(5, 2, 1, 'Gift Vouchers', 0, '2017-01-16 16:47:02');

--
-- Triggers `payroll_earning_deduction_codes`
--
DELIMITER $$
CREATE TRIGGER `earning_duductions_date_time` BEFORE INSERT ON `payroll_earning_deduction_codes` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_employee_types`
--

CREATE TABLE `payroll_employee_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_employee_types`
--

INSERT INTO `payroll_employee_types` (`id`, `type_name`, `date_created`) VALUES
(1, 'Permanent', '2017-02-13 00:00:00'),
(2, 'Casual', '2017-02-13 00:00:00');

--
-- Triggers `payroll_employee_types`
--
DELIMITER $$
CREATE TRIGGER `employee_types_date_time` BEFORE INSERT ON `payroll_employee_types` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_nhif`
--

CREATE TABLE `payroll_nhif` (
  `id` int(11) NOT NULL,
  `from_amount` decimal(10,2) NOT NULL,
  `to_amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_nhif`
--

INSERT INTO `payroll_nhif` (`id`, `from_amount`, `to_amount`, `total_amount`) VALUES
(1, '0.00', '5999.99', '150.00'),
(2, '6000.00', '7999.99', '300.00'),
(3, '8000.00', '11999.99', '400.00'),
(4, '12000.00', '14999.99', '500.00'),
(5, '15000.00', '19999.99', '600.00'),
(6, '20000.00', '24999.99', '750.00'),
(7, '25000.00', '29999.99', '850.00'),
(8, '30000.00', '34999.99', '900.00'),
(9, '35000.00', '39999.99', '950.00'),
(10, '40000.00', '44999.99', '1000.00'),
(11, '45000.00', '49999.99', '1100.00'),
(12, '50000.00', '59999.99', '1200.00'),
(13, '60000.00', '69999.99', '1300.00'),
(14, '70000.00', '79999.99', '1400.00'),
(15, '80000.00', '89999.99', '1500.00'),
(16, '90000.00', '99999.99', '1600.00'),
(17, '100000.00', '99999999.99', '1700.00');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_number_tracker`
--

CREATE TABLE `payroll_number_tracker` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_number_tracker`
--

INSERT INTO `payroll_number_tracker` (`id`, `company_id`, `date_created`) VALUES
(1, 2, '0000-00-00 00:00:00'),
(2, 2, '0000-00-00 00:00:00'),
(3, 2, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_paye`
--

CREATE TABLE `payroll_paye` (
  `id` int(11) NOT NULL,
  `range1` decimal(10,2) NOT NULL,
  `range2` decimal(10,2) NOT NULL,
  `factor` decimal(10,2) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `relief` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_paye`
--

INSERT INTO `payroll_paye` (`id`, `range1`, `range2`, `factor`, `rate`, `relief`) VALUES
(1, '0.00', '11180.00', '1118.00', '10.00', '1280.00'),
(2, '11181.00', '21714.00', '1580.00', '15.00', '1280.00'),
(3, '42781.99', '99999999.99', '0.00', '30.00', '1280.00'),
(4, '21715.00', '32248.00', '2106.60', '20.00', '1280.00'),
(5, '32249.00', '42781.00', '2633.00', '25.00', '1280.00');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_postings`
--

CREATE TABLE `payroll_postings` (
  `posting_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `posting_type` int(2) NOT NULL,
  `posting_description` varchar(50) NOT NULL,
  `posting_amount` decimal(10,2) DEFAULT NULL,
  `payroll_month` datetime NOT NULL,
  `posting_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_postings`
--

INSERT INTO `payroll_postings` (`posting_id`, `employee_id`, `posting_type`, `posting_description`, `posting_amount`, `payroll_month`, `posting_date`) VALUES
(77, 13, 2, 'PAYEE', '1000.00', '2016-12-01 00:00:00', '2016-12-29 13:17:07'),
(78, 13, 2, 'NSSF', '2000.00', '2016-12-01 00:00:00', '2016-12-29 13:17:07'),
(79, 13, 2, 'NHIF', '3000.00', '2016-12-01 00:00:00', '2016-12-29 13:17:07'),
(80, 14, 2, 'PAYEE', '1000.00', '2016-12-01 00:00:00', '2016-12-29 13:17:44'),
(81, 14, 2, 'NSSF', '2000.00', '2016-12-01 00:00:00', '2016-12-29 13:17:44'),
(82, 18, 1, 'Basic Salary', '50000.00', '2016-12-01 00:00:00', '2016-12-30 19:36:54'),
(96, 18, 2, 'PAYEE', '1000.00', '2016-12-01 00:00:00', '2017-01-03 20:17:38'),
(97, 18, 2, 'NHIF', '3000.00', '2016-12-01 00:00:00', '2017-01-03 20:17:39'),
(98, 19, 1, 'Basic Salary', '50000.00', '2016-12-01 00:00:00', '2017-01-03 20:29:27'),
(111, 19, 2, 'PAYEE', '1000.00', '2016-12-01 00:00:00', '2017-01-03 20:31:11'),
(112, 19, 2, 'NSSF', '2000.00', '2016-12-01 00:00:00', '2017-01-03 20:31:11'),
(113, 19, 2, 'NHIF', '3000.00', '2016-12-01 00:00:00', '2017-01-03 20:31:11'),
(114, 13, 1, 'Basic Salary', '50000.00', '2016-12-01 00:00:00', '2017-01-15 12:14:00'),
(115, 13, 2, 'PAYEE', '1000.00', '2016-12-01 00:00:00', '2017-01-15 12:14:01'),
(116, 17, 2, 'PAYEE', '1000.00', '2016-12-01 00:00:00', '2017-02-08 09:48:40'),
(117, 17, 2, 'NSSF', '2000.00', '2016-12-01 00:00:00', '2017-02-08 09:48:40'),
(118, 17, 2, 'NHIF', '3000.00', '2016-12-01 00:00:00', '2017-02-08 09:48:40'),
(119, 12, 2, 'PAYEE', '1000.00', '2016-12-01 00:00:00', '2017-02-10 19:26:37'),
(120, 12, 2, 'NSSF', '2000.00', '2016-12-01 00:00:00', '2017-02-10 19:26:37'),
(121, 12, 2, 'NHIF', '3000.00', '2016-12-01 00:00:00', '2017-02-10 19:26:37');

--
-- Triggers `payroll_postings`
--
DELIMITER $$
CREATE TRIGGER `posting_date_time` BEFORE INSERT ON `payroll_postings` FOR EACH ROW SET NEW.posting_date = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_postings_legacy`
--

CREATE TABLE `payroll_postings_legacy` (
  `posting_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `gross_salary` decimal(10,2) DEFAULT NULL,
  `payee` decimal(10,2) DEFAULT NULL,
  `nhif` decimal(10,2) DEFAULT NULL,
  `payroll_month` datetime NOT NULL,
  `posting_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_postings_legacy`
--

INSERT INTO `payroll_postings_legacy` (`posting_id`, `employee_id`, `gross_salary`, `payee`, `nhif`, `payroll_month`, `posting_date`) VALUES
(3, 12, '500.00', '100000.00', '100000.00', '2016-12-01 00:00:00', '2016-12-15 22:12:31'),
(4, 13, '50.00', '100000.00', '100000.00', '2016-12-01 00:00:00', '2016-12-23 19:40:51');

--
-- Triggers `payroll_postings_legacy`
--
DELIMITER $$
CREATE TRIGGER `payroll_posting_date_time` BEFORE INSERT ON `payroll_postings_legacy` FOR EACH ROW SET NEW.posting_date = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_posting_types`
--

CREATE TABLE `payroll_posting_types` (
  `posting_type_id` int(11) NOT NULL,
  `posting_type_name` varchar(256) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_posting_types`
--

INSERT INTO `payroll_posting_types` (`posting_type_id`, `posting_type_name`, `company_id`, `date_created`) VALUES
(1, 'Earnings', 0, '2016-12-28 12:29:29'),
(2, 'Deductions', 0, '2016-12-28 12:29:29'),
(3, 'Savings', 2, '2017-01-03 22:55:04'),
(4, 'Loans', 2, '2017-01-04 19:23:18');

--
-- Triggers `payroll_posting_types`
--
DELIMITER $$
CREATE TRIGGER `payroll_posting_type_date_time` BEFORE INSERT ON `payroll_posting_types` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pay_grades`
--

CREATE TABLE `pay_grades` (
  `pay_grade_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `pay_grade_name` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pay_grades`
--

INSERT INTO `pay_grades` (`pay_grade_id`, `company_id`, `pay_grade_name`, `date_created`) VALUES
(1, 0, 'Grade 1', '2017-01-19 18:59:13'),
(2, 0, 'Grade 2', '2017-01-19 18:59:13'),
(3, 2, 'grade 33', '2017-01-28 16:27:29'),
(4, 2, 'grade 4', '2017-01-28 16:41:32'),
(5, 2, 'Grade 5', '2017-01-28 16:42:21'),
(6, 2, 'Casuals', '2017-01-28 16:42:29'),
(7, 2, 'Accountant', '2017-01-28 17:38:56'),
(8, 2, 'Sales Managers', '2017-01-28 17:43:02'),
(9, 2, 'Pay grade Fhtt', '2017-02-10 19:18:42');

--
-- Triggers `pay_grades`
--
DELIMITER $$
CREATE TRIGGER `pay_grades_date_time` BEFORE INSERT ON `pay_grades` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pay_grade_earning_deductions`
--

CREATE TABLE `pay_grade_earning_deductions` (
  `id` int(11) NOT NULL,
  `pay_grade_id` int(11) DEFAULT NULL,
  `earning_deduction_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pay_grade_earning_deductions`
--

INSERT INTO `pay_grade_earning_deductions` (`id`, `pay_grade_id`, `earning_deduction_id`, `amount`, `date_created`) VALUES
(2, 1, 2, '500.00', '2017-02-08 09:39:51'),
(3, 1, 3, '500.00', '2017-02-08 09:43:06'),
(4, 1, 4, '5007.00', '2017-02-08 09:43:07'),
(5, 1, 5, '5004.00', '2017-02-08 09:43:08'),
(20, 4, 5, '5004.00', '2017-02-08 09:43:21'),
(27, 4, 1, '2000.00', '2017-02-09 17:48:55'),
(28, 8, 1, '50000.00', '2017-02-09 17:50:46'),
(30, 8, 4, '200.00', '2017-02-09 17:58:54'),
(31, 3, 1, '90000.00', '2017-02-09 18:00:04'),
(32, 9, 1, '50000.00', '2017-02-10 19:21:01'),
(33, 4, 3, '19000.00', '2017-03-16 13:16:04');

--
-- Triggers `pay_grade_earning_deductions`
--
DELIMITER $$
CREATE TRIGGER `pay_grade_ed_date_time` BEFORE INSERT ON `pay_grade_earning_deductions` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `middle_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `pin_no` varchar(15) DEFAULT NULL,
  `id_no` varchar(15) DEFAULT NULL,
  `nssf_no` varchar(15) DEFAULT NULL,
  `nhif_no` varchar(15) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `pays_kra` tinyint(1) NOT NULL,
  `pays_nssf` tinyint(1) NOT NULL,
  `pays_nhif` tinyint(1) NOT NULL,
  `basic_pay` decimal(10,2) NOT NULL,
  `is_employee` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `company_id`, `user_id`, `gender`, `first_name`, `middle_name`, `last_name`, `phone`, `pin_no`, `id_no`, `nssf_no`, `nhif_no`, `email`, `pays_kra`, `pays_nssf`, `pays_nhif`, `basic_pay`, `is_employee`, `is_active`, `date_created`) VALUES
(1, 2, 8, NULL, 'David', NULL, 'Mwangi', '+254729003109', NULL, NULL, NULL, NULL, 'daviek19@gmail.com', 0, 0, 0, '0.00', NULL, NULL, '2016-12-12 14:05:44'),
(12, 2, NULL, 1, 'Stephen ', 'Omondi', 'Lamba', '0729003109', 'A9890', '28452155', '12345', 'xcvfr', 'daviek19@gmail.com', 1, 1, 1, '50000.00', 1, NULL, '2016-12-15 22:12:31'),
(13, 2, NULL, 1, 'Caro ', 'Nungari', 'Muchiri', '254729003110', 'A908976', '28452190', '', '', 'caro@gmail.com', 1, 1, 1, '50.00', 1, NULL, '2016-12-23 19:40:51'),
(14, 2, NULL, 1, 'john ', 'doe ', 'doest', '072900487', '', '', '', '', 'john@yahoo.com', 1, 1, 0, '5000.00', 1, NULL, '2016-12-28 14:58:04'),
(17, 2, NULL, 1, 'New', 'Test', 'Admin', '0729003109', '', '28452166', '', '', 'Daviek19@sokonline.co.ke', 1, 1, 1, '20000.00', 1, NULL, '2016-12-29 12:48:39'),
(18, 2, NULL, 1, 'new', 'test', 'guy', '729003109', '1234567', '284590', '', '', 'Daviek19@sokonline.co.ke', 1, 0, 1, '50000.00', 1, NULL, '2016-12-30 19:36:54');

--
-- Triggers `people`
--
DELIMITER $$
CREATE TRIGGER `peoples_date_time` BEFORE INSERT ON `people` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `earning_deduction_codes`
--
ALTER TABLE `earning_deduction_codes`
  ADD PRIMARY KEY (`code_id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_earning_deduction_codes`
--
ALTER TABLE `payroll_earning_deduction_codes`
  ADD PRIMARY KEY (`earning_deduction_id`);

--
-- Indexes for table `payroll_employee_types`
--
ALTER TABLE `payroll_employee_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_nhif`
--
ALTER TABLE `payroll_nhif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_number_tracker`
--
ALTER TABLE `payroll_number_tracker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_paye`
--
ALTER TABLE `payroll_paye`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_postings`
--
ALTER TABLE `payroll_postings`
  ADD PRIMARY KEY (`posting_id`);

--
-- Indexes for table `payroll_postings_legacy`
--
ALTER TABLE `payroll_postings_legacy`
  ADD PRIMARY KEY (`posting_id`);

--
-- Indexes for table `payroll_posting_types`
--
ALTER TABLE `payroll_posting_types`
  ADD PRIMARY KEY (`posting_type_id`);

--
-- Indexes for table `pay_grades`
--
ALTER TABLE `pay_grades`
  ADD PRIMARY KEY (`pay_grade_id`);

--
-- Indexes for table `pay_grade_earning_deductions`
--
ALTER TABLE `pay_grade_earning_deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `earning_deduction_codes`
--
ALTER TABLE `earning_deduction_codes`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5875;
--
-- AUTO_INCREMENT for table `payroll_earning_deduction_codes`
--
ALTER TABLE `payroll_earning_deduction_codes`
  MODIFY `earning_deduction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `payroll_employee_types`
--
ALTER TABLE `payroll_employee_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `payroll_nhif`
--
ALTER TABLE `payroll_nhif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `payroll_number_tracker`
--
ALTER TABLE `payroll_number_tracker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payroll_paye`
--
ALTER TABLE `payroll_paye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `payroll_postings`
--
ALTER TABLE `payroll_postings`
  MODIFY `posting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
--
-- AUTO_INCREMENT for table `payroll_postings_legacy`
--
ALTER TABLE `payroll_postings_legacy`
  MODIFY `posting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `payroll_posting_types`
--
ALTER TABLE `payroll_posting_types`
  MODIFY `posting_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pay_grades`
--
ALTER TABLE `pay_grades`
  MODIFY `pay_grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `pay_grade_earning_deductions`
--
ALTER TABLE `pay_grade_earning_deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
