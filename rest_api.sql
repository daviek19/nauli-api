-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2017 at 06:40 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

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
(21, 'testing123', 2, '2017-01-28 16:23:51');

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
-- Table structure for table `employee_earnings_deductions`
--

CREATE TABLE `employee_earnings_deductions` (
  `id` int(11) NOT NULL,
  `payroll_number` int(11) NOT NULL,
  `earning_deduction_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `employee_earnings_deductions`
--
DELIMITER $$
CREATE TRIGGER `employee_earnings_deductions_date_time` BEFORE INSERT ON `employee_earnings_deductions` FOR EACH ROW SET NEW.date_created = NOW()
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
(1, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488475890, 0.125007, '1', 200),
(2, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488475890, 0.117007, '1', 200),
(3, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488476001, 0.0960059, '1', 200),
(4, 'person/person/12', 'get', 'a:4:{s:2:\"id\";s:2:\"12\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488476001, 0.101005, '1', 200),
(5, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488816951, 0.943054, '1', 200),
(6, 'person/person/12.xml', 'get', 'a:5:{s:2:\"id\";s:2:\"12\";s:6:\"format\";s:3:\"xml\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488816952, 0.244014, '1', 200),
(7, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488816960, 0.17101, '1', 200),
(8, 'payroll/earning_deduction_codes/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488816960, 0.258014, '1', 200),
(9, 'payroll/posting_types/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488816961, 0.282016, '1', 200),
(10, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488816974, 0.18201, '1', 200),
(11, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488816982, 0.250014, '1', 200),
(12, 'payroll/earning_deduction_code', 'post', 'a:10:{s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:16:\"application/json\";s:9:\"X-API-KEY\";s:4:\"1234\";s:12:\"Content-type\";s:16:\"application/json\";s:14:\"Content-Length\";s:3:\"106\";s:22:\"earning_deduction_name\";s:8:\"test one\";s:9:\"recurrent\";s:1:\"1\";s:15:\"posting_type_id\";s:1:\"2\";s:10:\"company_id\";s:1:\"2\";s:7:\"taxable\";s:1:\"1\";}', '1234', '127.0.0.1', 1488816982, 0.214012, '1', 201),
(13, 'payroll/earning_deduction_codes/2', 'get', 'a:5:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:16:\"application/json\";s:9:\"X-API-KEY\";s:4:\"1234\";s:12:\"Content-type\";s:16:\"application/json\";}', '1234', '127.0.0.1', 1488816982, 0.124007, '1', 200),
(14, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488817217, 0.248015, '1', 200),
(15, 'payroll/summary/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488817218, 0.35602, '1', 200),
(16, 'company/company/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488817218, 0.138008, '1', 200),
(17, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488817226, 0.259015, '1', 200),
(18, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488817226, 0.082005, '1', 200),
(19, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488817394, 0.191011, '1', 200),
(20, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488817394, 0.16901, '1', 404),
(21, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488818237, 0.576033, '1', 200),
(22, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488818237, 0.285017, '1', 404),
(23, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488818333, 0.34202, '1', 200),
(24, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488818334, 0.52003, '1', 404),
(25, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488818364, 0.248014, '1', 200),
(26, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488818365, 0.198012, '1', 404),
(27, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488818511, 0.198012, '1', 200),
(28, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488818511, 0.131007, '1', 404),
(29, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488900874, 2.35213, '1', 200),
(30, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488900876, 0.589034, '1', 404),
(31, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488900948, 0.262015, '1', 200),
(32, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488900949, 0.395023, '1', 404),
(33, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901185, 0.139008, '1', 200),
(34, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901185, 0.384022, '1', 404),
(35, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901305, 0.209012, '1', 200),
(36, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901305, 0.266015, '1', 404),
(37, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901332, 0.18201, '1', 200),
(38, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901333, 0.18401, '1', 404),
(39, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901366, 0.52303, '1', 200),
(40, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901367, 0.548032, '1', 404),
(41, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901412, 1.51609, '1', 200),
(42, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488901413, 0.480028, '1', 404),
(43, 'payroll/generate_payroll_number/2', 'get', 'a:6:{i:0;N;s:10:\"User-Agent\";s:70:\"curl/7.21.1 (i686-pc-mingw32) libcurl/7.21.1 OpenSSL/0.9.8r zlib/1.2.3\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488906574, 0.274016, '1', 200),
(44, 'payroll/generate_payroll_number/2', 'get', 'a:6:{i:0;N;s:10:\"User-Agent\";s:70:\"curl/7.21.1 (i686-pc-mingw32) libcurl/7.21.1 OpenSSL/0.9.8r zlib/1.2.3\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488906587, 0.280413, '1', 200),
(45, 'payroll/generate_payroll_number/2', 'get', 'a:6:{i:0;N;s:10:\"User-Agent\";s:70:\"curl/7.21.1 (i686-pc-mingw32) libcurl/7.21.1 OpenSSL/0.9.8r zlib/1.2.3\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488906826, 0.265016, '1', 200),
(46, 'employees/types', 'get', 'a:5:{s:0:\"\";N;s:10:\"User-Agent\";s:70:\"curl/7.21.1 (i686-pc-mingw32) libcurl/7.21.1 OpenSSL/0.9.8r zlib/1.2.3\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488906952, 0.326019, '1', 200),
(47, 'payroll/generate_payroll_number/2', 'get', 'a:6:{i:0;N;s:10:\"User-Agent\";s:70:\"curl/7.21.1 (i686-pc-mingw32) libcurl/7.21.1 OpenSSL/0.9.8r zlib/1.2.3\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488907115, 0.240612, '1', 200),
(48, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907265, 0.358021, '1', 200),
(49, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907265, 0.17301, '1', 404),
(50, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907611, 0.159009, '1', 200),
(51, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907611, 0.247014, '1', 404),
(52, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907727, 0.207012, '1', 200),
(53, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907727, 0.184011, '1', 404),
(54, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907739, 0.287017, '1', 200),
(55, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488907739, 0.162009, '1', 200),
(56, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907824, 0.391023, '1', 200),
(57, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488907824, 0.257015, '1', 200),
(58, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907911, 0.17401, '1', 200),
(59, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488907911, 0.124606, '1', 200),
(60, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907986, 0.185209, '1', 200),
(61, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488907986, 0.25901, '1', 200),
(62, 'person/person/1', 'get', 'a:4:{s:2:\"id\";s:1:\"1\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488907987, 0.187808, '1', 200),
(63, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908038, 0.244812, '1', 200),
(64, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908039, 0.214211, '1', 200),
(65, 'person/person/1', 'get', 'a:4:{s:2:\"id\";s:1:\"1\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908039, 0.177407, '1', 200),
(66, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908168, 0.298616, '1', 200),
(67, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908169, 0.284412, '1', 200),
(68, 'employees/types/1', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908169, 0.21481, '1', 200),
(69, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908391, 0.264813, '1', 200),
(70, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908391, 0.278814, '1', 200),
(71, 'employees/types/1', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908392, 0.243213, '1', 200),
(72, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908470, 0.329218, '1', 200),
(73, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908471, 0.146009, '1', 200),
(74, 'employees/types/1', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908471, 0.193408, '1', 200),
(75, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908574, 0.304815, '1', 200),
(76, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908574, 0.272214, '1', 200),
(77, 'employees/types/1', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908575, 0.187007, '1', 200),
(78, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908719, 0.156608, '1', 200),
(79, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908720, 0.406019, '1', 200),
(80, 'employees/types/1', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908720, 0.18461, '1', 200),
(81, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908786, 0.216409, '1', 200),
(82, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908786, 0.180808, '1', 200),
(83, 'employees/types/1', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908787, 0.327613, '1', 200),
(84, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908801, 0.318212, '1', 200),
(85, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908801, 0.333618, '1', 200),
(86, 'employees/types/1', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908802, 0.335817, '1', 200),
(87, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908827, 0.239212, '1', 200),
(88, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908827, 0.159208, '1', 200),
(89, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908841, 0.111006, '1', 200),
(90, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908841, 0.218607, '1', 200),
(91, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908857, 0.097604, '1', 200),
(92, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908857, 0.182808, '1', 200),
(93, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908878, 0.126804, '1', 200),
(94, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908878, 0.413421, '1', 200),
(95, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908902, 0.188209, '1', 200),
(96, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908902, 0.195408, '1', 200),
(97, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908916, 0.266011, '1', 200),
(98, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908916, 0.426214, '1', 200),
(99, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488908955, 0.164609, '1', 200),
(100, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488908955, 0.173807, '1', 200),
(101, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488909008, 0.174406, '1', 200),
(102, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488909009, 0.239009, '1', 200),
(103, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488909036, 0.168208, '1', 200),
(104, 'payroll/generate_payroll_number/2', 'get', 'a:5:{i:0;N;s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";i:1;N;}', '1234', '127.0.0.1', 1488909036, 0.168609, '1', 200),
(105, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488909147, 0.17801, '1', 200),
(106, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488909147, 0.261015, '1', 404),
(107, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488984676, 1.36608, '1', 200),
(108, 'person/person/12.xml', 'get', 'a:5:{s:2:\"id\";s:2:\"12\";s:6:\"format\";s:3:\"xml\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488984677, 0.691039, '1', 404),
(109, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488984697, 0.331018, '1', 200),
(110, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488984698, 0.556031, '1', 404),
(111, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488984706, 0.399023, '1', 200),
(112, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488984707, 0.370022, '1', 200),
(113, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488985807, 0.251014, '1', 200),
(114, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488985807, 0.18601, '1', 200),
(115, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488985901, 0.921053, '1', 200),
(116, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488985902, 0.402023, '1', 404),
(117, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488985943, 0.152009, '1', 200),
(118, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488985943, 0.17201, '1', 404),
(119, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488985950, 0.246014, '1', 200),
(120, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488985950, 0.266016, '1', 200),
(121, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986127, 0.51503, '1', 200),
(122, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986128, 0.298017, '1', 404),
(123, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986168, 0.359021, '1', 200),
(124, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986168, 0.328018, '1', 200),
(125, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986364, 0.402023, '1', 200),
(126, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986365, 0.366021, '1', 200),
(127, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986372, 0.18401, '1', 200),
(128, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986373, 0.364021, '1', 200),
(129, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986373, 0.268016, '1', 404),
(130, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986379, 0.258015, '1', 200),
(131, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986380, 0.243014, '1', 200),
(132, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986679, 0.263015, '1', 200),
(133, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986679, 0.203012, '1', 200),
(134, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986680, 0.260015, '1', 404),
(135, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986686, 0.095005, '1', 200),
(136, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986687, 0.144009, '1', 200),
(137, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986747, 0.284016, '1', 200),
(138, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986747, 0.116007, '1', 200),
(139, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986747, 0.131008, '1', 404),
(140, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986755, 0.121007, '1', 200),
(141, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986756, 0.0900052, '1', 200),
(142, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986756, 0.151009, '1', 404),
(143, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986766, 0.18801, '1', 200),
(144, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986767, 0.190011, '1', 200),
(145, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986978, 0.154009, '1', 200),
(146, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986978, 0.147008, '1', 200),
(147, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986979, 0.118007, '1', 404),
(148, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986996, 0.156009, '1', 200),
(149, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488986996, 0.144009, '1', 200),
(150, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987056, 0.385022, '1', 200),
(151, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987057, 0.568033, '1', 200),
(152, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987058, 0.411024, '1', 404),
(153, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987221, 0.165009, '1', 200),
(154, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987222, 0.112006, '1', 200),
(155, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987222, 0.201011, '1', 404),
(156, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987295, 0.155009, '1', 200),
(157, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987296, 0.124007, '1', 200),
(158, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987489, 0.241014, '1', 200),
(159, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987490, 0.278016, '1', 200),
(160, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987501, 0.248014, '1', 200),
(161, 'paygrades/earning_deductions/3', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"3\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987502, 0.138008, '1', 404),
(162, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987505, 0.264015, '1', 200),
(163, 'paygrades/earning_deductions/1', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"1\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987505, 0.164009, '1', 404),
(164, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987513, 0.206012, '1', 200),
(165, 'paygrades/earning_deductions/5', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"5\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987513, 0.232013, '1', 404),
(166, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987518, 0.194011, '1', 200),
(167, 'paygrades/earning_deductions/8', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488987518, 0.272016, '1', 404),
(168, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988443, 0.541031, '1', 200),
(169, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988443, 0.155009, '1', 200),
(170, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988444, 0.135008, '1', 404),
(171, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988456, 0.162009, '1', 200),
(172, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988456, 0.143008, '1', 200),
(173, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988507, 0.316018, '1', 200),
(174, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988507, 0.427024, '1', 200),
(175, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988508, 0.767044, '1', 404),
(176, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988524, 0.190011, '1', 200),
(177, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988524, 0.140008, '1', 200),
(178, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988709, 0.274016, '1', 200),
(179, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988709, 0.240014, '1', 200),
(180, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988710, 0.317018, '1', 404),
(181, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988718, 0.190011, '1', 200),
(182, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988719, 0.248014, '1', 200),
(183, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988978, 0.170009, '1', 200),
(184, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988979, 0.17601, '1', 200),
(185, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988979, 0.221013, '1', 404),
(186, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988988, 0.137008, '1', 200),
(187, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488988988, 0.216012, '1', 200),
(188, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989064, 0.35402, '1', 200),
(189, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989065, 0.239013, '1', 200),
(190, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989065, 0.115007, '1', 404),
(191, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989072, 0.304018, '1', 200),
(192, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989073, 0.233014, '1', 200),
(193, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989131, 0.276016, '1', 200),
(194, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989131, 0.244014, '1', 200),
(195, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989132, 0.595034, '1', 404),
(196, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989142, 0.15801, '1', 200),
(197, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989143, 0.193011, '1', 200),
(198, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989184, 0.326019, '1', 200),
(199, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989186, 0.952055, '1', 200),
(200, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989187, 0.367021, '1', 404),
(201, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989199, 0.130007, '1', 200),
(202, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989199, 0.18701, '1', 200),
(203, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989200, 0.178011, '1', 404),
(204, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989205, 0.167009, '1', 200),
(205, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989206, 0.19001, '1', 200),
(206, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989267, 0.425024, '1', 200),
(207, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989268, 0.390022, '1', 200),
(208, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989270, 1.05006, '1', 404),
(209, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989278, 0.248014, '1', 200),
(210, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989278, 0.17101, '1', 200),
(211, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989429, 0.34302, '1', 200),
(212, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989429, 0.187011, '1', 200),
(213, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989430, 0.300017, '1', 404),
(214, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989440, 0.17101, '1', 200),
(215, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989440, 0.100006, '1', 200),
(216, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989458, 0.371021, '1', 200),
(217, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989458, 0.191011, '1', 200),
(218, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989459, 0.278016, '1', 404),
(219, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989466, 0.127008, '1', 200),
(220, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989466, 0.244014, '1', 200),
(221, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989497, 0.304017, '1', 200),
(222, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989498, 0.275016, '1', 200),
(223, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989499, 0.381022, '1', 404),
(224, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989507, 0.217012, '1', 200),
(225, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989507, 0.098006, '1', 200),
(226, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989529, 0.514029, '1', 200),
(227, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989530, 0.299017, '1', 200),
(228, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989531, 0.297017, '1', 404),
(229, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989537, 0.307017, '1', 200),
(230, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488989537, 0.198011, '1', 200),
(231, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488990065, 0.479028, '1', 200),
(232, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488990065, 0.196011, '1', 200),
(233, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991054, 0.87605, '1', 200),
(234, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991056, 0.441025, '1', 200),
(235, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991057, 0.637036, '1', 404);
INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(236, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991093, 0.296017, '1', 200),
(237, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991094, 0.243013, '1', 200),
(238, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991094, 0.138008, '1', 404),
(239, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991140, 0.106006, '1', 200),
(240, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991141, 0.119007, '1', 200),
(241, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991146, 0.17301, '1', 200),
(242, 'paygrades/find/6', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"6\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991146, 0.160009, '1', 200),
(243, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991166, 0.130008, '1', 200),
(244, 'paygrades/find/4', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"4\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991166, 0.082005, '1', 200),
(245, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991222, 0.258015, '1', 200),
(246, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991223, 0.311018, '1', 200),
(247, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991240, 0.455026, '1', 200),
(248, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991241, 0.195012, '1', 200),
(249, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991276, 0.236013, '1', 200),
(250, 'paygrades/find/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991276, 0.128007, '1', 200),
(251, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991315, 0.287016, '1', 200),
(252, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991316, 0.315018, '1', 200),
(253, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991346, 0.395023, '1', 200),
(254, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991348, 0.394023, '1', 200),
(255, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991368, 0.420024, '1', 200),
(256, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991368, 0.192011, '1', 200),
(257, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991369, 0.130007, '1', 404),
(258, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991369, 0.262015, '1', 200),
(259, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991370, 0.092005, '1', 200),
(260, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991370, 0.116006, '1', 404),
(261, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991388, 0.309018, '1', 200),
(262, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991389, 0.326019, '1', 200),
(263, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991407, 0.153009, '1', 200),
(264, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991407, 0.259014, '1', 200),
(265, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991741, 0.299017, '1', 200),
(266, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991742, 0.379021, '1', 200),
(267, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991742, 0.111006, '1', 404),
(268, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991759, 0.200011, '1', 200),
(269, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991759, 0.240014, '1', 200),
(270, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991762, 0.135007, '1', 200),
(271, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991762, 0.143008, '1', 200),
(272, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991772, 0.127008, '1', 200),
(273, 'paygrades/earning_deductions/7', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"7\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991773, 0.133008, '1', 404),
(274, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991783, 0.235013, '1', 200),
(275, 'paygrades/earning_deductions/1', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"1\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991783, 0.158009, '1', 404),
(276, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991790, 0.16901, '1', 200),
(277, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991790, 0.127007, '1', 200),
(278, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991895, 0.269015, '1', 200),
(279, 'paygrades/earning_deductions/7', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"7\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991896, 0.208012, '1', 404),
(280, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991899, 0.201011, '1', 200),
(281, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991900, 0.142008, '1', 200),
(282, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991965, 0.17801, '1', 200),
(283, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991966, 0.146008, '1', 200),
(284, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991966, 0.202011, '1', 404),
(285, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991977, 0.289017, '1', 200),
(286, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991977, 0.125007, '1', 200),
(287, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991980, 0.150009, '1', 200),
(288, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488991980, 0.266016, '1', 200),
(289, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992697, 0.754043, '1', 200),
(290, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992698, 0.236014, '1', 200),
(291, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992698, 0.189011, '1', 404),
(292, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992723, 0.233014, '1', 200),
(293, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992723, 0.270015, '1', 200),
(294, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992727, 0.324019, '1', 200),
(295, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992727, 0.17401, '1', 200),
(296, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992788, 0.202012, '1', 200),
(297, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992788, 0.194011, '1', 200),
(298, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992789, 0.220013, '1', 404),
(299, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992795, 0.147008, '1', 200),
(300, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992795, 0.121007, '1', 200),
(301, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992800, 0.116007, '1', 200),
(302, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992801, 0.196011, '1', 200),
(303, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992986, 0.149008, '1', 200),
(304, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992986, 0.320018, '1', 200),
(305, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992987, 0.364021, '1', 404),
(306, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992997, 0.282016, '1', 200),
(307, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488992998, 0.274015, '1', 200),
(308, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993003, 0.192011, '1', 200),
(309, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993003, 0.212012, '1', 200),
(310, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993064, 0.142008, '1', 200),
(311, 'paygrades/earning_deductions/5', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"5\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993065, 0.161009, '1', 404),
(312, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993073, 0.114007, '1', 200),
(313, 'paygrades/earning_deductions/4', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"4\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993073, 0.163009, '1', 404),
(314, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993080, 0.150009, '1', 200),
(315, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993080, 0.197011, '1', 200),
(316, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993091, 0.169009, '1', 200),
(317, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993091, 0.129008, '1', 200),
(318, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993092, 0.114007, '1', 404),
(319, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993218, 0.193011, '1', 200),
(320, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993219, 0.154009, '1', 200),
(321, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993222, 0.208012, '1', 200),
(322, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993222, 0.17101, '1', 200),
(323, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993256, 0.152009, '1', 200),
(324, 'paygrades/earning_deductions/8', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993256, 0.134008, '1', 404),
(325, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993267, 0.191011, '1', 200),
(326, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993267, 0.104006, '1', 200),
(327, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993472, 0.391022, '1', 200),
(328, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993472, 0.172009, '1', 200),
(329, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993473, 0.725042, '1', 404),
(330, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993498, 0.342019, '1', 200),
(331, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993498, 0.181011, '1', 200),
(332, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993670, 0.146008, '1', 200),
(333, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993670, 0.295017, '1', 200),
(334, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993671, 0.164009, '1', 404),
(335, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993693, 0.279016, '1', 200),
(336, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993693, 0.287017, '1', 200),
(337, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993694, 0.238013, '1', 404),
(338, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993705, 0.116007, '1', 200),
(339, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993706, 0.17601, '1', 200),
(340, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993731, 0.473027, '1', 200),
(341, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993731, 0.35302, '1', 200),
(342, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993732, 0.257015, '1', 404),
(343, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993739, 0.124007, '1', 200),
(344, 'payroll/generate_payroll_number/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993739, 0.156009, '1', 200),
(345, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993755, 0.17801, '1', 200),
(346, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993755, 0.256015, '1', 200),
(347, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993781, 0.153009, '1', 200),
(348, 'paygrades/earning_deductions/8', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993782, 0.230013, '1', 404),
(349, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993807, 0.123007, '1', 200),
(350, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993808, 0.133008, '1', 200),
(351, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993837, 0.140009, '1', 200),
(352, 'paygrades/earning_deductions/8', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993837, 0.121007, '1', 404),
(353, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993847, 0.147008, '1', 200),
(354, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993847, 0.122007, '1', 200),
(355, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993869, 0.296017, '1', 200),
(356, 'paygrades/earning_deductions/3', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"3\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993870, 0.155009, '1', 404),
(357, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993933, 0.17701, '1', 200),
(358, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993933, 0.185011, '1', 200),
(359, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993963, 0.152009, '1', 200),
(360, 'paygrades/earning_deductions/8', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993963, 0.131008, '1', 404),
(361, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993966, 0.134008, '1', 200),
(362, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488993967, 0.203012, '1', 200),
(363, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994493, 0.257015, '1', 200),
(364, 'paygrades/earning_deductions/8', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994494, 0.437025, '1', 404),
(365, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994509, 0.239014, '1', 200),
(366, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994558, 0.162009, '1', 200),
(367, 'paygrades/earning_deductions/9', 'get', 'a:4:{s:12:\"pay_grade_id\";s:1:\"9\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994558, 0.153009, '1', 200),
(368, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994683, 0.276015, '1', 200),
(369, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994694, 0.153008, '1', 200),
(370, 'payroll/summary/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994695, 0.297017, '1', 404),
(371, 'company/company/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994695, 0.141008, '1', 200),
(372, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994703, 0.16901, '1', 200),
(373, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994704, 0.17501, '1', 200),
(374, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994704, 0.103005, '1', 404),
(375, 'person/user/8', 'get', 'a:4:{s:2:\"id\";s:1:\"8\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994723, 0.191011, '1', 200),
(376, 'paygrades/2', 'get', 'a:4:{s:10:\"company_id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994723, 0.152009, '1', 200),
(377, 'company/employees/2', 'get', 'a:4:{s:2:\"id\";s:1:\"2\";s:4:\"Host\";s:9:\"localhost\";s:6:\"Accept\";s:3:\"*/*\";s:9:\"X-API-KEY\";s:4:\"1234\";}', '1234', '127.0.0.1', 1488994724, 0.116006, '1', 404);

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
  `taxable` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_earning_deduction_codes`
--

INSERT INTO `payroll_earning_deduction_codes` (`earning_deduction_id`, `company_id`, `posting_type_id`, `earning_deduction_name`, `recurrent`, `taxable`, `date_created`) VALUES
(15, 2, 1, 'basic salery', 0, 0, '2017-03-02 19:55:15'),
(16, 2, 1, 'House allawance', 1, 0, '2017-03-02 20:17:59'),
(17, 2, 2, 'test one', 1, 1, '2017-03-06 19:16:22');

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
(15, 0, '2017-03-07 20:00:34'),
(16, 0, '2017-03-07 20:00:35'),
(17, 0, '2017-03-07 20:00:58'),
(18, 0, '2017-03-07 20:02:01'),
(19, 0, '2017-03-07 20:02:03'),
(20, 0, '2017-03-07 20:02:25'),
(21, 0, '2017-03-07 20:02:26'),
(22, 0, '2017-03-07 20:02:28'),
(23, 0, '2017-03-07 20:02:29'),
(24, 0, '2017-03-07 20:02:30'),
(25, 0, '2017-03-07 20:02:31'),
(26, 0, '2017-03-07 20:02:32'),
(27, 0, '2017-03-07 20:04:49'),
(28, 0, '2017-03-07 20:04:51'),
(29, 0, '2017-03-07 20:04:52'),
(30, 0, '2017-03-07 20:04:53'),
(31, 0, '2017-03-07 20:04:56'),
(32, 0, '2017-03-07 20:04:57'),
(33, 0, '2017-03-07 20:09:34'),
(34, 0, '2017-03-07 20:09:47'),
(35, 0, '2017-03-07 20:13:34'),
(36, 0, '2017-03-07 20:13:46'),
(37, 0, '2017-03-07 20:15:02'),
(38, 0, '2017-03-07 20:18:35'),
(39, 0, '2017-03-07 20:28:59'),
(40, 0, '2017-03-07 20:30:24'),
(41, 0, '2017-03-07 20:31:51'),
(42, 0, '2017-03-07 20:33:06'),
(43, 0, '2017-03-07 20:33:59'),
(44, 0, '2017-03-07 20:36:09'),
(45, 0, '2017-03-07 20:39:51'),
(46, 0, '2017-03-07 20:41:11'),
(47, 0, '2017-03-07 20:42:54'),
(48, 0, '2017-03-07 20:45:20'),
(49, 0, '2017-03-07 20:46:26'),
(50, 0, '2017-03-07 20:46:42'),
(51, 0, '2017-03-07 20:47:07'),
(52, 0, '2017-03-07 20:47:21'),
(53, 0, '2017-03-07 20:47:37'),
(54, 0, '2017-03-07 20:47:58'),
(55, 0, '2017-03-07 20:48:22'),
(56, 0, '2017-03-07 20:48:37'),
(57, 0, '2017-03-07 20:49:16'),
(58, 0, '2017-03-07 20:50:09'),
(59, 0, '2017-03-07 20:50:36'),
(60, 2, '2017-03-08 17:51:47'),
(61, 2, '2017-03-08 18:10:07'),
(62, 2, '2017-03-08 18:12:30'),
(63, 2, '2017-03-08 18:19:40'),
(64, 2, '2017-03-08 18:24:47'),
(65, 2, '2017-03-08 18:26:07'),
(66, 2, '2017-03-08 18:29:56'),
(67, 2, '2017-03-08 18:34:56'),
(68, 2, '2017-03-08 18:54:16'),
(69, 2, '2017-03-08 18:55:24'),
(70, 2, '2017-03-08 18:58:39'),
(71, 2, '2017-03-08 19:03:08'),
(72, 2, '2017-03-08 19:04:33'),
(73, 2, '2017-03-08 19:05:43'),
(74, 2, '2017-03-08 19:06:46'),
(75, 2, '2017-03-08 19:07:58'),
(76, 2, '2017-03-08 19:10:40'),
(77, 2, '2017-03-08 19:11:06'),
(78, 2, '2017-03-08 19:11:47'),
(79, 2, '2017-03-08 19:12:17'),
(80, 2, '2017-03-08 19:39:01'),
(81, 2, '2017-03-08 19:43:09'),
(82, 2, '2017-03-08 19:49:19'),
(83, 2, '2017-03-08 19:52:57'),
(84, 2, '2017-03-08 20:05:23'),
(85, 2, '2017-03-08 20:06:35'),
(86, 2, '2017-03-08 20:09:58'),
(87, 2, '2017-03-08 20:13:39'),
(88, 2, '2017-03-08 20:18:18'),
(89, 2, '2017-03-08 20:21:46'),
(90, 2, '2017-03-08 20:22:19');

--
-- Triggers `payroll_number_tracker`
--
DELIMITER $$
CREATE TRIGGER `payroll_number_tracker_date_time` BEFORE INSERT ON `payroll_number_tracker` FOR EACH ROW SET NEW.date_created = NOW()
$$
DELIMITER ;

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
(2, 'Deductions', 0, '2016-12-28 12:29:29');

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
(9, 2, 'Pay grade F', '2017-02-10 19:18:42');

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
(33, 9, 17, '2000.00', '2017-03-02 20:20:14');

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
  `payroll_number` varchar(256) DEFAULT NULL,
  `is_employee` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `company_id`, `user_id`, `gender`, `first_name`, `middle_name`, `last_name`, `phone`, `pin_no`, `id_no`, `nssf_no`, `nhif_no`, `email`, `pays_kra`, `pays_nssf`, `pays_nhif`, `payroll_number`, `is_employee`, `is_active`, `date_created`) VALUES
(1, 2, 8, NULL, 'David', NULL, 'Mwangi', '+254729003109', NULL, NULL, NULL, NULL, 'daviek19@gmail.com', 0, 0, 0, NULL, NULL, NULL, '2016-12-12 14:05:44');

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
-- Indexes for table `employee_earnings_deductions`
--
ALTER TABLE `employee_earnings_deductions`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `earning_deduction_codes`
--
ALTER TABLE `earning_deduction_codes`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `employee_earnings_deductions`
--
ALTER TABLE `employee_earnings_deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;
--
-- AUTO_INCREMENT for table `payroll_earning_deduction_codes`
--
ALTER TABLE `payroll_earning_deduction_codes`
  MODIFY `earning_deduction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
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
  MODIFY `posting_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
