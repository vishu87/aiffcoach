-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2016 at 01:12 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aiff_coach`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `details` varchar(150) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `action` int(11) NOT NULL COMMENT '1=>"approved" , 2=>"not approved" , 3=>"Mark Inactive", 4 =>"Mark Active"',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_privilege`
--

CREATE TABLE IF NOT EXISTS `admin_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `priv` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `admin_privilege`
--

INSERT INTO `admin_privilege` (`id`, `name`, `priv`) VALUES
(1, 'coach', 1),
(2, 'Site Admin 1', 2),
(3, 'Site Admin 2', 3),
(4, 'Site Admin 3', 4);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=>"Not Approved",1=>"Payment Pending","2"=>"Payment Approval Pending","3"=>"Approved"',
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `course_id`, `coach_id`, `status`, `remarks`, `updated_at`, `created_at`) VALUES
(2, 1, 3, 2, 'Applied | Pending', '2016-05-10 11:11:07', '2016-04-30 13:27:41'),
(4, 2, 3, 2, 'Applied | Pending', '2016-05-10 11:04:43', '2016-05-02 10:00:09'),
(5, 6, 3, 3, 'Applied | Pending', '2016-05-09 14:18:18', '2016-05-09 13:04:38');

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE IF NOT EXISTS `approval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_type` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `status` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `approval`
--

INSERT INTO `approval` (`id`, `entity_type`, `entity_id`, `status`, `user_id`, `remarks`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 1, 5, 'checking for modules', '2016-05-05 09:16:48', '2016-05-05 09:16:48'),
(2, 1, 3, 3, 5, 'bad guy', '2016-05-05 10:14:03', '2016-05-05 10:14:03'),
(3, 1, 1, 2, 5, 'good guy.', '2016-05-05 10:14:35', '2016-05-05 10:14:35'),
(4, 1, 3, 2, 5, 'not that much bad.', '2016-05-05 10:16:08', '2016-05-05 10:16:08'),
(5, 1, 1, 3, 5, 'testing', '2016-05-05 10:20:10', '2016-05-05 10:20:10'),
(6, 1, 1, 2, 5, 'testing again', '2016-05-05 10:20:34', '2016-05-05 10:20:34'),
(7, 1, 3, 3, 5, 'testing once again', '2016-05-05 10:21:10', '2016-05-05 10:21:10'),
(8, 1, 1, 3, 5, 'testing again', '2016-05-05 10:21:28', '2016-05-05 10:21:28'),
(9, 1, 3, 2, 5, 'dfadsaf', '2016-05-05 10:24:58', '2016-05-05 10:24:58'),
(10, 1, 3, 3, 5, 'dfasdfad', '2016-05-05 10:34:35', '2016-05-05 10:34:35'),
(11, 1, 1, 2, 5, 'dfadsadf', '2016-05-05 10:40:11', '2016-05-05 10:40:11'),
(12, 1, 1, 3, 5, 'dfadsad', '2016-05-05 10:40:31', '2016-05-05 10:40:31'),
(13, 1, 1, 2, 5, 'gvfdfws', '2016-05-05 10:41:10', '2016-05-05 10:41:10'),
(14, 1, 1, 3, 5, 'fgsdfsg', '2016-05-05 10:41:25', '2016-05-05 10:41:25'),
(15, 1, 1, 2, 5, 'vkldsjlfads', '2016-05-05 10:43:16', '2016-05-05 10:43:16'),
(16, 1, 1, 3, 5, 'fsaa', '2016-05-05 11:01:39', '2016-05-05 11:01:39'),
(17, 1, 1, 2, 5, 'sdfads', '2016-05-05 11:02:34', '2016-05-05 11:02:34'),
(18, 1, 1, 3, 5, 'kjhk', '2016-05-05 11:04:49', '2016-05-05 11:04:49'),
(19, 1, 1, 2, 5, 'dfasdfa', '2016-05-05 11:05:04', '2016-05-05 11:05:04'),
(20, 1, 1, 3, 5, 'jljn', '2016-05-05 11:06:09', '2016-05-05 11:06:09'),
(21, 1, 1, 2, 5, 'dfsfafsd', '2016-05-05 11:15:07', '2016-05-05 11:15:07'),
(22, 1, 3, 2, 5, 'dfsd', '2016-05-05 11:16:31', '2016-05-05 11:16:31'),
(23, 1, 1, 3, 5, 'kjhk', '2016-05-05 11:17:29', '2016-05-05 11:17:29'),
(24, 1, 1, 3, 5, 'kjhk', '2016-05-05 11:18:05', '2016-05-05 11:18:05'),
(25, 1, 1, 3, 5, 'kjhk', '2016-05-05 11:18:16', '2016-05-05 11:18:16'),
(26, 1, 1, 2, 5, 'jhgj', '2016-05-05 11:18:42', '2016-05-05 11:18:42'),
(27, 1, 1, 3, 5, 'kjhk', '2016-05-05 11:22:54', '2016-05-05 11:22:54'),
(28, 1, 1, 2, 5, 'dfads', '2016-05-05 11:24:40', '2016-05-05 11:24:40'),
(29, 1, 1, 3, 5, 'cxzdsff', '2016-05-05 11:25:50', '2016-05-05 11:25:50'),
(30, 1, 3, 3, 5, 'fsfadfa', '2016-05-05 11:39:06', '2016-05-05 11:39:06'),
(31, 1, 1, 2, 5, 'dasfsdaf', '2016-05-05 11:39:36', '2016-05-05 11:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE IF NOT EXISTS `coaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `dob` date NOT NULL,
  `state_registration` varchar(100) NOT NULL,
  `status` int(5) NOT NULL,
  `state_reference` int(11) NOT NULL,
  `gender` int(2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`id`, `registration_id`, `first_name`, `middle_name`, `last_name`, `photo`, `dob`, `state_registration`, `status`, `state_reference`, `gender`, `updated_at`, `created_at`) VALUES
(1, '0', 'chirag', '', 'verma', 'coaches-doc/CHIRAG---WIN_20151003_143457.JPG', '1965-07-15', '36', 2, 36, 1, '2016-05-05 11:39:36', '2016-04-22 13:00:18'),
(3, '0', 'vishu', '', 'agg', 'coaches-doc/6-CHIRAG---WIN_20151003_143525.JPG', '1964-04-13', '32', 3, 32, 1, '2016-05-05 11:39:06', '2016-04-22 13:15:57'),
(4, '', 'ankit ', 'kumar', 'gupta', 'coaches-doc/2-CHIRAG---WIN_20151003_143431.JPG', '2016-05-10', '36', 0, 36, 1, '2016-05-09 12:29:12', '2016-05-09 12:29:12'),
(5, '', 'ankit ', 'kumar', 'gupta', 'coaches-doc/2-CHIRAG---WIN_20151003_143431.JPG', '2016-05-10', '36', 0, 36, 1, '2016-05-09 12:30:34', '2016-05-09 12:30:34'),
(6, '', 'Sachin', 'Ramesh', 'Tendulkar', 'coaches-doc/2-CHIRAG---WIN_20151003_143457.JPG', '2016-05-26', '36', 0, 36, 1, '2016-05-09 12:38:05', '2016-05-09 12:38:05'),
(7, '', 'Sachin', 'Ramesh', 'Tendulkar', 'coaches-doc/2-CHIRAG---WIN_20151003_143457.JPG', '2016-05-26', '36', 0, 36, 1, '2016-05-09 12:39:40', '2016-05-09 12:39:40'),
(8, '', 'Sachin', 'Ramesh', 'Tendulkar', 'coaches-doc/13-CHIRAG---WIN_20151003_143525.JPG', '2016-05-26', '32', 0, 32, 1, '2016-05-09 12:43:21', '2016-05-09 12:43:21'),
(9, '', 'ankit ', 'kumar', 'gupta', 'coaches-doc/3-CHIRAG---WIN_20151003_143457.JPG', '2016-05-10', '36', 0, 36, 1, '2016-05-09 12:47:19', '2016-05-09 12:47:19'),
(10, '', 'shubham', '', 'bhatt', 'coaches-doc/4-CHIRAG---WIN_20151003_143431.JPG', '2016-05-25', '23', 0, 32, 1, '2016-05-10 09:39:54', '2016-05-10 09:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `coach_activity`
--

CREATE TABLE IF NOT EXISTS `coach_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `place` varchar(100) NOT NULL,
  `event` varchar(100) NOT NULL,
  `participants` varchar(50) NOT NULL,
  `position_role` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `coach_activity`
--

INSERT INTO `coach_activity` (`id`, `coach_id`, `from_date`, `to_date`, `place`, `event`, `participants`, `position_role`, `updated_at`, `created_at`) VALUES
(2, 3, '0000-00-00', '0000-00-00', 'India', '2016 IIFA', '15', '3', '2016-04-26 11:40:45', '2016-04-26 11:40:45'),
(3, 3, '0000-00-00', '0000-00-00', 'delhi', 'world Cup', '16', '2', '2016-04-26 11:49:30', '2016-04-26 11:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `coach_parameters`
--

CREATE TABLE IF NOT EXISTS `coach_parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `dob_proof` varchar(100) NOT NULL,
  `birth_place` varchar(100) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` int(20) NOT NULL,
  `address_state_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alternate_email` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `landline` varchar(50) NOT NULL,
  `passport_no` varchar(50) NOT NULL,
  `passport_expiry` date NOT NULL,
  `passport_copy` varchar(200) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `coach_parameters`
--

INSERT INTO `coach_parameters` (`id`, `coach_id`, `dob_proof`, `birth_place`, `address1`, `address2`, `city`, `pincode`, `address_state_id`, `email`, `alternate_email`, `mobile`, `landline`, `passport_no`, `passport_expiry`, `passport_copy`, `updated_at`, `created_at`) VALUES
(1, 1, 'coaches-doc/2-CHIRAG---WIN_20151003_143525.JPG', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 32, 'chiragverma2207@gmail.com', '', '07078395691', '07078395691', '5465466', '2020-02-03', 'coaches-doc/CHIRAG---WIN_20151003_143540.JPG', '2016-04-22 13:00:18', '2016-04-22 13:00:18'),
(2, 3, 'coaches-doc/7-CHIRAG---WIN_20151003_143525.JPG', 'uttrakhand', '80, mootichoor haripur', 'Sidkul Haridwar 2', 'Delhi/NCR 1', 110093, 36, 'vishu@gmail.com', 'vishu123@gmail.com', '9548766941', '9548766941', 'dfadsa456', '0000-00-00', 'coaches-doc/11-CHIRAG---WIN_20151003_143525.JPG', '2016-05-09 12:49:16', '2016-04-22 13:15:57'),
(3, 8, 'coaches-doc/11-Table-of-Contents.pdf', 'Delhi', 'MB-33 Inderlok Colony', 'Sidkul Haridwar', 'haridwar', 249403, 36, 'sachin@blasters.com', '', '9548766941', '09548766941', 'dfadsa456', '1900-12-22', 'coaches-doc/1-syno-revise.pdf', '2016-05-09 12:57:48', '2016-05-09 12:43:21'),
(4, 9, 'coaches-doc/12-Table-of-Contents.pdf', 'delhi', '80, mootichoor hari', '', 'Delhi/NCR', 124646, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '5465466', '2016-05-11', 'coaches-doc/13-Table-of-Contents.pdf', '2016-05-09 12:47:19', '2016-05-09 12:47:19'),
(5, 10, 'coaches-doc/16-Table-of-Contents.pdf', 'Ranipokhri', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 9, 'shubham@gmail.com', '', '78798798797', '', '8789798', '2016-05-24', 'coaches-doc/17-Table-of-Contents.pdf', '2016-05-10 09:39:54', '2016-05-10 09:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `license_id` int(5) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `fees` int(10) NOT NULL,
  `documents` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `license_id`, `start_date`, `end_date`, `fees`, `documents`, `updated_at`, `created_at`) VALUES
(1, 'cjdfk', 1, '2016-04-20', '2016-04-28', 100, 'coaches-doc/8-CHIRAG---WIN_20151003_143540.JPG', '2016-05-02 09:23:57', '2016-04-29 12:08:03'),
(2, 'caskdfja', 1, '2016-04-04', '2016-05-20', 500, 'coaches-doc/9-CHIRAG---WIN_20151003_143540.JPG', '2016-05-02 09:27:03', '2016-04-29 12:11:49'),
(4, 'past course', 1, '2016-03-27', '2016-04-02', 500, 'coaches-doc/10-CHIRAG---WIN_20151003_143540.JPG', '2016-04-29 13:05:59', '2016-04-29 13:05:59'),
(5, 'B-grade', 2, '2016-04-04', '2016-04-28', 500, 'coaches-doc/11-CHIRAG---WIN_20151003_143540.JPG', '2016-04-30 10:45:14', '2016-04-30 10:45:14'),
(6, 'license bc', 2, '2016-05-12', '2016-05-28', 100, '', '2016-05-09 13:53:39', '2016-05-05 09:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `employment_details`
--

CREATE TABLE IF NOT EXISTS `employment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `employment` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `contract` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `employment_details`
--

INSERT INTO `employment_details` (`id`, `coach_id`, `employment`, `start_date`, `end_date`, `contract`, `updated_at`, `created_at`) VALUES
(1, 1, 'Dehradun Football Association', '0000-00-00', '0000-00-00', 'coaches-doc/1-CHIRAG---WIN_20151003_143540.JPG', '2016-04-22 13:05:38', '2016-04-22 13:05:38'),
(2, 1, 'Raiwala Football Club', '0000-00-00', '0000-00-00', '', '2016-04-22 13:05:38', '2016-04-22 13:05:38'),
(6, 3, 'Himacal Football Club', '2014-07-11', '2014-07-16', 'coaches-doc/12-kanchanbvss-sss-c.png', '2016-05-05 12:24:53', '2016-04-22 13:17:09'),
(11, 3, 'Chennai Super Kings', '2014-07-25', '2014-07-30', 'coaches-doc/16-kanchanbvss-sss-c.png', '2016-05-05 12:26:36', '2016-04-26 09:32:53');

-- --------------------------------------------------------

--
-- Table structure for table `license`
--

CREATE TABLE IF NOT EXISTS `license` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `authorised_by` int(5) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `license`
--

INSERT INTO `license` (`id`, `name`, `description`, `authorised_by`, `updated_at`, `created_at`) VALUES
(1, 'chirag 1 ', 'this is for senior coaches', 1, '2016-04-28 13:37:46', '2016-04-28 13:37:35'),
(2, 'licensce B', 'junior coches can apply', 2, '2016-04-30 10:44:32', '2016-04-30 10:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `fees` int(11) NOT NULL,
  `payment_method` int(2) NOT NULL COMMENT '1=>"cheqe","2"=>"Draft","3"=>"Cash"',
  `cheque_date` date NOT NULL,
  `cheque_number` int(11) NOT NULL,
  `bank_name` text NOT NULL,
  `remarks` text,
  `status` int(1) NOT NULL COMMENT '0=>"Not Approved",1=>"Approved"',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `application_id`, `fees`, `payment_method`, `cheque_date`, `cheque_number`, `bank_name`, `remarks`, `status`, `updated_at`, `created_at`) VALUES
(2, 4, 500, 2, '2016-05-13', 125633, 'PNB', 'payment paid', 0, '2016-05-10 11:04:43', '2016-05-06 14:08:35'),
(3, 2, 100, 3, '0000-00-00', 0, '', 'dafsdfa1', 0, '2016-05-10 11:11:07', '2016-05-06 14:16:35'),
(7, 5, 100, 3, '0000-00-00', 0, '', 'i wil pay that ammount at the department counter', 0, '2016-05-09 13:53:48', '2016-05-09 13:05:17');

-- --------------------------------------------------------

--
-- Table structure for table `registration_details`
--

CREATE TABLE IF NOT EXISTS `registration_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `certificate_no` varchar(100) NOT NULL,
  `certificate_copy` varchar(100) NOT NULL,
  `certificate_date` date NOT NULL,
  `latest_certificate_copy` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `registration_details`
--

INSERT INTO `registration_details` (`id`, `coach_id`, `certificate_no`, `certificate_copy`, `certificate_date`, `latest_certificate_copy`, `updated_at`, `created_at`) VALUES
(1, 1, 'A102', 'coaches-doc/3-CHIRAG---WIN_20151003_143525.JPG', '0000-00-00', 'coaches-doc/2-CHIRAG---WIN_20151003_143540.JPG', '2016-04-22 13:05:38', '2016-04-22 13:05:38'),
(2, 1, 'A102', 'coaches-doc/4-CHIRAG---WIN_20151003_143525.JPG', '0000-00-00', 'coaches-doc/4-CHIRAG---WIN_20151003_143540.JPG', '2016-04-22 13:07:47', '2016-04-22 13:07:47'),
(3, 3, 'A102', 'coaches-doc/8-CHIRAG---WIN_20151003_143525.JPG', '0000-00-00', 'coaches-doc/9-CHIRAG---WIN_20151003_143525.JPG', '2016-04-22 13:17:09', '2016-04-22 13:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `reg_data`
--

CREATE TABLE IF NOT EXISTS `reg_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temp_id` int(11) NOT NULL,
  `data1` text NOT NULL,
  `data2` text NOT NULL,
  `data3` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `reg_data`
--

INSERT INTO `reg_data` (`id`, `temp_id`, `data1`, `data2`, `data3`, `updated_at`, `created_at`) VALUES
(1, 0, 'a:10:{s:6:"_token";s:40:"NwEP37u4qbux17ioTpZGisAGQe3yOAv92PnNQmT2";s:10:"first_name";s:8:"sdnlnlsn";s:11:"middle_name";s:4:"qlnl";s:9:"last_name";s:3:"lql";s:5:"email";s:17:"nlsadas@as.dsaocm";s:6:"gender";s:4:"male";s:3:"dob";s:10:"2016-05-18";s:11:"birth_place";s:0:"";s:9:"dob_proof";N;s:5:"photo";N;}', '', '', '2016-05-07 13:39:42', '0000-00-00 00:00:00'),
(2, 0, 'a:10:{s:6:"_token";s:40:"NwEP37u4qbux17ioTpZGisAGQe3yOAv92PnNQmT2";s:10:"first_name";s:8:"sdnlnlsn";s:11:"middle_name";s:4:"qlnl";s:9:"last_name";s:3:"lql";s:5:"email";s:17:"nlsadas@as.dsaocm";s:6:"gender";s:4:"male";s:3:"dob";s:10:"2016-05-18";s:11:"birth_place";s:0:"";s:9:"dob_proof";N;s:5:"photo";N;}', '', '', '2016-05-07 13:39:47', '0000-00-00 00:00:00'),
(3, 0, 'a:10:{s:6:"_token";s:40:"NwEP37u4qbux17ioTpZGisAGQe3yOAv92PnNQmT2";s:10:"first_name";s:8:"sdnlnlsn";s:11:"middle_name";s:4:"qlnl";s:9:"last_name";s:3:"lql";s:5:"email";s:17:"nlsadas@as.dsaocm";s:6:"gender";s:4:"male";s:3:"dob";s:10:"2016-05-18";s:11:"birth_place";s:0:"";s:9:"dob_proof";N;s:5:"photo";N;}', '', '', '2016-05-07 13:40:39', '0000-00-00 00:00:00'),
(4, 0, 'a:11:{s:6:"_token";s:40:"NwEP37u4qbux17ioTpZGisAGQe3yOAv92PnNQmT2";s:2:"id";s:1:"4";s:10:"first_name";s:6:"chirag";s:11:"middle_name";s:4:"dfad";s:9:"last_name";s:4:"dafd";s:5:"email";s:25:"chiragverma2207@gmail.com";s:6:"gender";s:4:"male";s:3:"dob";s:0:"";s:11:"birth_place";s:0:"";s:9:"dob_proof";N;s:5:"photo";N;}', '', '', '2016-05-07 14:12:38', '0000-00-00 00:00:00'),
(5, 0, 'a:11:{s:6:"_token";s:40:"zeUsRDOQvY4djbtnZCN6kRwziD4besG2blPl3bPL";s:2:"id";s:1:"0";s:10:"first_name";s:6:"chirag";s:11:"middle_name";s:0:"";s:9:"last_name";s:5:"verma";s:5:"email";s:25:"chiragverma2207@gmail.com";s:6:"gender";s:4:"male";s:3:"dob";s:0:"";s:11:"birth_place";s:0:"";s:9:"dob_proof";N;s:5:"photo";N;}', '', '', '2016-05-09 08:41:28', '0000-00-00 00:00:00'),
(6, 0, 'a:0:{}', '', '', '2016-05-09 08:47:58', '0000-00-00 00:00:00'),
(7, 0, 'a:11:{s:6:"_token";s:40:"zeUsRDOQvY4djbtnZCN6kRwziD4besG2blPl3bPL";s:2:"id";s:1:"0";s:10:"first_name";s:6:"chirag";s:11:"middle_name";s:0:"";s:9:"last_name";s:5:"verma";s:5:"email";s:25:"chiragverma2207@gmail.com";s:6:"gender";s:4:"male";s:3:"dob";s:0:"";s:11:"birth_place";s:0:"";s:9:"dob_proof";N;s:5:"photo";N;}', '', '', '2016-05-09 08:53:11', '0000-00-00 00:00:00'),
(8, 0, 'a:0:{}', '', '', '2016-05-09 08:53:12', '0000-00-00 00:00:00'),
(9, 0, 'a:11:{s:6:"_token";s:40:"zeUsRDOQvY4djbtnZCN6kRwziD4besG2blPl3bPL";s:2:"id";s:1:"9";s:10:"first_name";s:6:"chirag";s:11:"middle_name";s:5:"verma";s:9:"last_name";s:5:"verma";s:5:"email";s:25:"chiragverma2207@gmail.com";s:6:"gender";s:4:"male";s:3:"dob";s:10:"2016-05-24";s:11:"birth_place";s:5:"Delhi";s:9:"dob_proof";N;s:5:"photo";N;}', '', '', '2016-05-09 09:34:40', '0000-00-00 00:00:00'),
(10, 0, 'a:11:{s:6:"_token";s:40:"zeUsRDOQvY4djbtnZCN6kRwziD4besG2blPl3bPL";s:2:"id";s:0:"";s:9:"state_reg";s:1:"3";s:15:"state_reference";s:1:"1";s:8:"address1";s:7:" dsafsd";s:8:"address2";s:7:"ds afsd";s:4:"city";s:0:"";s:7:"pincode";s:0:"";s:5:"state";s:1:"7";s:6:"mobile";s:6:"554645";s:8:"landline";s:3:"546";}', '', '', '2016-05-09 09:35:21', '0000-00-00 00:00:00'),
(12, 0, '', '', 'a:3:{s:14:"passport_proof";s:33:"coaches-doc/Table-of-Contents.pdf";s:15:"passport_expiry";s:10:"2016-05-05";s:8:"passport";s:7:"5465466";}', '2016-05-09 11:41:57', '0000-00-00 00:00:00'),
(13, 0, '', '', 'a:3:{s:14:"passport_proof";s:35:"coaches-doc/1-Table-of-Contents.pdf";s:15:"passport_expiry";s:10:"2016-05-05";s:8:"passport";s:7:"5465466";}', '2016-05-09 11:42:15', '0000-00-00 00:00:00'),
(14, 0, 'a:9:{s:5:"photo";s:47:"coaches-doc/13-CHIRAG---WIN_20151003_143525.JPG";s:9:"dob_proof";s:36:"coaches-doc/11-Table-of-Contents.pdf";s:10:"first_name";s:6:"Sachin";s:11:"middle_name";s:6:"Ramesh";s:9:"last_name";s:9:"Tendulkar";s:5:"email";s:19:"sachin@blasters.com";s:6:"gender";s:1:"1";s:3:"dob";s:10:"2016-05-26";s:11:"birth_place";s:5:"Delhi";}', 'a:11:{s:6:"_token";s:40:"zeUsRDOQvY4djbtnZCN6kRwziD4besG2blPl3bPL";s:2:"id";s:2:"14";s:9:"state_reg";s:2:"32";s:15:"state_reference";s:2:"32";s:8:"address1";s:21:"MB-33 Inderlok Colony";s:8:"address2";s:15:"Sidkul Haridwar";s:4:"city";s:8:"haridwar";s:7:"pincode";s:6:"249403";s:5:"state";s:2:"36";s:6:"mobile";s:10:"9548766941";s:8:"landline";s:11:"09548766941";}', 'a:3:{s:14:"passport_proof";s:29:"coaches-doc/1-syno-revise.pdf";s:15:"passport_expiry";s:10:"2016-05-18";s:8:"passport";s:7:"5465466";}', '2016-05-09 12:43:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`) VALUES
(1, 'ANDHRA PRADESH'),
(2, 'ASSAM'),
(3, 'ARUNACHAL PRADESH'),
(4, 'GUJRAT'),
(5, 'BIHAR'),
(6, 'HARYANA'),
(7, 'HIMACHAL PRADESH'),
(8, 'JAMMU & KASHMIR'),
(9, 'KARNATAKA'),
(10, 'KERALA'),
(11, 'MADHYA PRADESH'),
(12, 'MAHARASHTRA'),
(13, 'MANIPUR'),
(14, 'MEGHALAYA'),
(15, 'MIZORAM'),
(16, 'NAGALAND'),
(17, 'ORISSA'),
(18, 'PUNJAB'),
(19, 'RAJASTHAN'),
(20, 'SIKKIM'),
(21, 'TAMIL NADU'),
(22, 'TRIPURA'),
(23, 'UTTAR PRADESH'),
(24, 'WEST BENGAL'),
(25, 'GOA'),
(26, 'PONDICHERY'),
(27, 'LAKSHDWEEP'),
(28, 'DAMAN & DIU'),
(29, 'DADRA & NAGAR'),
(30, 'CHANDIGARH'),
(31, 'ANDAMAN & NICOBAR'),
(32, 'UTTRAKHAND'),
(33, 'JHARKHAND'),
(34, 'CHATTISGARH'),
(35, 'ASSAM'),
(36, 'DELHI');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `password_check` varchar(50) NOT NULL,
  `active` int(11) NOT NULL,
  `privilege` int(11) NOT NULL,
  `remember_token` varchar(200) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `coach_id`, `username`, `password`, `password_check`, `active`, `privilege`, `remember_token`, `updated_at`, `created_at`) VALUES
(3, 1, 'chiragverma2207@gmail.com', '$2y$10$BoJ.8qC7BfiY1C13m1jg4.yOzfqzr6sZI7/GK8nUVRcXP70b0jHcC', 'sample', 0, 1, 'ToOW9ro1YabsLn5XKxB8msk8Qtavm9ShYS0rd3gYnULNvAXZcOSaegQGgiAZ', '2016-05-05 11:39:36', '2016-04-22 13:00:18'),
(4, 3, 'vishu@gmail.com', '$2y$10$7Hp3Q9jqYu7eJ/mDhYq/MuDy/N.IPrlllYstAxaDMHru8kH3NBSE.', 'sample123', 0, 1, '6FMGjdwrvz6Vb8Uk3zDZdB9t1fcrrsBfzoWPMvY0QzkpXpN9NSOtPTuaqPnG', '2016-05-09 13:05:40', '2016-04-22 13:15:58'),
(5, 0, 'admin', '$2y$10$QOY2gfuw6v6.oqDB4V30nuXy.y3QVMJxVF26JK3dhHddnR8XF2KwS', 'sample', 0, 2, 'uytIBaKjZUZDVH3wLDIZOito5s22uLa8odwJTjbRw8Bx4ThcHbGWfY5gVCk7', '2016-05-07 12:31:27', '0000-00-00 00:00:00'),
(6, 8, 'sachin@blasters.com', '$2y$10$5jJBfXXG/yKijR0RDTXp4Oo0Nv.QLD0wQHiZWAz2K42NGnle13QdO', '0D42uMJI', 0, 1, '', '2016-05-09 12:43:22', '2016-05-09 12:43:22'),
(7, 9, 'chiragverma2207@gmail.com', '$2y$10$igo95Vkkyk6GTYeqHBUH6O2LeeNOrp6i7SQqkgz9tUvxXpAaQRUvq', 'MCpBfIfR', 0, 1, '', '2016-05-09 12:47:19', '2016-05-09 12:47:19'),
(8, 10, 'shubham@gmail.com', '$2y$10$wWMRIknP6GIG7/VRYjv1VOYzOBArH9H1rXQb5KqY.QPl95znjwc.u', 'HCVQX3N4', 0, 1, '', '2016-05-10 09:39:54', '2016-05-10 09:39:54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
