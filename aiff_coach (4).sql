-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2016 at 02:33 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `course_id`, `coach_id`, `status`, `remarks`, `updated_at`, `created_at`) VALUES
(2, 1, 3, 0, 'Applied | Pending', '2016-05-30 07:09:48', '2016-04-30 13:27:41'),
(4, 2, 3, 3, 'afdsafd', '2016-06-14 13:00:30', '2016-05-02 10:00:09'),
(5, 6, 3, 3, 'Applied | Pending', '2016-05-09 14:18:18', '2016-05-09 13:04:38'),
(6, 7, 3, 3, 'Applied | Pending', '2016-06-13 11:34:36', '2016-05-10 12:59:09'),
(7, 7, 6, 3, '', '2016-06-16 11:51:13', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `application_result`
--

CREATE TABLE IF NOT EXISTS `application_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `application_result`
--

INSERT INTO `application_result` (`id`, `application_id`, `status`, `remarks`, `updated_at`, `created_at`) VALUES
(1, 6, 3, 'All Exam Clear', '2016-06-17 14:05:03', '0000-00-00 00:00:00'),
(3, 7, 2, 'Low score in each subject', '2016-06-18 09:42:10', '0000-00-00 00:00:00'),
(4, 5, 2, 'Two Subjects Need Rexamination', '2016-06-18 13:15:21', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

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
(10, '', 'shubham', '', 'bhatt', 'coaches-doc/4-CHIRAG---WIN_20151003_143431.JPG', '2016-05-25', '23', 0, 32, 1, '2016-05-10 09:39:54', '2016-05-10 09:39:54'),
(11, '', 'Avyay', 'kumar', 'Aggarwal', 'coaches-doc/photo__CHIRAG---WIN_20151003_143525.JPG', '2016-05-19', '36', 0, 36, 1, '2016-05-12 12:24:55', '2016-05-12 12:24:55'),
(12, '', 'Sachin', 'Ramesh', 'Tendulkar', 'coaches-doc/13-CHIRAG---WIN_20151003_143525.JPG', '2016-05-26', '32', 0, 32, 1, '2016-05-12 12:27:57', '2016-05-12 12:27:57'),
(13, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:16:40', '2016-05-18 13:16:40'),
(14, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:18:50', '2016-05-18 13:18:50'),
(15, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:21:59', '2016-05-18 13:21:59'),
(16, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:24:10', '2016-05-18 13:24:10'),
(17, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:24:33', '2016-05-18 13:24:33'),
(18, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:25:09', '2016-05-18 13:25:09'),
(19, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:25:19', '2016-05-18 13:25:19'),
(20, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:25:25', '2016-05-18 13:25:25'),
(21, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:25:31', '2016-05-18 13:25:31'),
(22, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:25:39', '2016-05-18 13:25:39'),
(23, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:26:32', '2016-05-18 13:26:32'),
(24, '', 'chirag', '', 'verma', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', '36', 0, 36, 1, '2016-05-18 13:26:55', '2016-05-18 13:26:55');

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
(2, 3, '2016-12-21', '2016-12-22', 'India', '2016 IIFA', '15', '3', '2016-05-30 07:37:31', '2016-04-26 11:40:45'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `coach_parameters`
--

INSERT INTO `coach_parameters` (`id`, `coach_id`, `dob_proof`, `birth_place`, `address1`, `address2`, `city`, `pincode`, `address_state_id`, `email`, `alternate_email`, `mobile`, `landline`, `passport_no`, `passport_expiry`, `passport_copy`, `updated_at`, `created_at`) VALUES
(1, 1, 'coaches-doc/2-CHIRAG---WIN_20151003_143525.JPG', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 32, 'chiragverma2207@gmail.com', '', '07078395691', '07078395691', '5465466', '2020-02-03', 'coaches-doc/CHIRAG---WIN_20151003_143540.JPG', '2016-04-22 13:00:18', '2016-04-22 13:00:18'),
(2, 3, 'coaches-doc/7-CHIRAG---WIN_20151003_143525.JPG', 'uttrakhand', '80, mootichoor haripur', 'Sidkul Haridwar 2', 'Delhi/NCR 1', 110093, 36, 'vishu@gmail.com', 'vishu123@gmail.com', '9548766941', '9548766941', 'dfadsa456', '2020-02-03', 'coaches-doc/11-CHIRAG---WIN_20151003_143525.JPG', '2016-05-10 13:15:33', '2016-04-22 13:15:57'),
(3, 8, 'coaches-doc/11-Table-of-Contents.pdf', 'Delhi', 'MB-33 Inderlok Colony', 'Sidkul Haridwar', 'haridwar', 249403, 36, 'sachin@blasters.com', '', '9548766941', '09548766941', 'dfadsa456', '2020-02-03', 'coaches-doc/PassportProof_4_1462885757.pdf', '2016-05-10 13:15:54', '2016-05-09 12:43:21'),
(4, 9, 'coaches-doc/12-Table-of-Contents.pdf', 'delhi', '80, mootichoor hari', '', 'Delhi/NCR', 124646, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '5465466', '2016-05-11', 'coaches-doc/13-Table-of-Contents.pdf', '2016-05-09 12:47:19', '2016-05-09 12:47:19'),
(5, 10, 'coaches-doc/16-Table-of-Contents.pdf', 'Ranipokhri', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 9, 'shubham@gmail.com', '', '78798798797', '', '8789798', '2016-05-24', 'coaches-doc/17-Table-of-Contents.pdf', '2016-05-10 09:39:54', '2016-05-10 09:39:54'),
(6, 11, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'HARIDWAR UTTRAKHAND', '80, mootichoor hari', 'Sidkul Haridwar', 'Delhi/NCR', 110094, 36, 'avyay@gmail.com', '', '9548766941', '09548766941', '5465466', '2016-05-11', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-12 12:24:55', '2016-05-12 12:24:55'),
(7, 12, 'coaches-doc/11-Table-of-Contents.pdf', 'Delhi', 'MB-33 Inderlok Colony', 'Sidkul Haridwar', 'haridwar', 249403, 36, 'sachin@blasters.com', '', '9548766941', '09548766941', '21234646', '2016-05-17', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-12 12:27:57', '2016-05-12 12:27:57'),
(8, 13, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', 'dasfd', '2016-05-20', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:16:40', '2016-05-18 13:16:40'),
(9, 14, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', 'dfadsa', '2016-05-11', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:18:51', '2016-05-18 13:18:51'),
(10, 15, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', 'dfadsa', '2016-05-11', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:21:59', '2016-05-18 13:21:59'),
(11, 16, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '21234646', '2016-05-14', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:24:10', '2016-05-18 13:24:10'),
(12, 17, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '21234646', '2016-05-14', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:24:33', '2016-05-18 13:24:33'),
(13, 18, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '21234646', '2016-05-14', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:25:09', '2016-05-18 13:25:09'),
(14, 19, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '21234646', '2016-05-14', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:25:19', '2016-05-18 13:25:19'),
(15, 20, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '21234646', '2016-05-14', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:25:25', '2016-05-18 13:25:25'),
(16, 21, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '21234646', '2016-05-14', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:25:31', '2016-05-18 13:25:31'),
(17, 22, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '21234646', '2016-05-14', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:25:39', '2016-05-18 13:25:39'),
(18, 23, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '21234646', '2016-05-14', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:26:33', '2016-05-18 13:26:33'),
(19, 24, 'coaches-doc/dobProof__Table-of-Contents.pdf', 'Delhi', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 36, 'chiragverma2207@gmail.com', '', '9548766941', '09548766941', '21234646', '2016-05-14', 'coaches-doc/PassportProof__Table-of-Contents.pdf', '2016-05-18 13:26:55', '2016-05-18 13:26:55');

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
  `venue` text NOT NULL,
  `active` int(1) NOT NULL,
  `description` text NOT NULL,
  `documents` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `license_id`, `start_date`, `end_date`, `fees`, `venue`, `active`, `description`, `documents`, `updated_at`, `created_at`) VALUES
(1, 'cjdfk', 1, '2016-04-20', '2016-04-28', 100, 'Delhi', 0, 'dflsssssssafd', 'coaches-doc/8-CHIRAG---WIN_20151003_143540.JPG', '2016-06-09 10:31:39', '2016-04-29 12:08:03'),
(2, 'caskdfja', 1, '2016-04-13', '2016-05-20', 500, 'delhi', 0, 'djkfasjd sjdlalsjdl afj', 'coaches-doc/9-CHIRAG---WIN_20151003_143540.JPG', '2016-05-10 13:16:49', '2016-04-29 12:11:49'),
(4, 'past course', 1, '2016-03-27', '2016-04-02', 500, '', 0, '', 'coaches-doc/10-CHIRAG---WIN_20151003_143540.JPG', '2016-04-29 13:05:59', '2016-04-29 13:05:59'),
(5, 'B-grade', 2, '2016-04-04', '2016-04-28', 500, '', 0, '', 'coaches-doc/11-CHIRAG---WIN_20151003_143540.JPG', '2016-04-30 10:45:14', '2016-04-30 10:45:14'),
(6, 'license bc', 2, '2016-05-12', '2016-05-28', 100, '', 0, '', '', '2016-06-13 10:58:44', '2016-05-05 09:27:49'),
(7, 'LLB', 1, '2016-05-02', '2016-05-28', 500, 'delhi', 0, 'kdfajlsdjfla', 'coaches-doc/Document_5_Table-of-Contents.pdf', '2016-06-14 09:56:39', '2016-05-10 12:47:30'),
(8, 'new course', 2, '2016-06-17', '2016-06-22', 1500, 'Delhi', 0, 'A test course', 'coaches-doc/Document_5_OR.pdf', '2016-06-09 10:33:25', '2016-06-09 10:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `courses_parameter`
--

CREATE TABLE IF NOT EXISTS `courses_parameter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `license_id` int(11) NOT NULL,
  `parameter_id` int(11) NOT NULL,
  `active` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `courses_parameter`
--

INSERT INTO `courses_parameter` (`id`, `license_id`, `parameter_id`, `active`, `updated_at`, `created_at`) VALUES
(4, 2, 1, 0, '2016-06-13 11:32:17', '2016-06-13 11:32:17'),
(5, 2, 2, 0, '2016-06-13 11:32:17', '2016-06-13 11:32:17'),
(6, 2, 7, 0, '2016-06-14 09:46:11', '2016-06-14 09:46:11'),
(7, 2, 8, 0, '2016-06-14 09:46:27', '2016-06-14 09:46:27'),
(8, 1, 1, 0, '2016-06-14 10:01:34', '2016-06-14 10:01:34'),
(9, 1, 7, 0, '2016-06-14 10:01:34', '2016-06-14 10:01:34'),
(10, 1, 8, 0, '2016-06-14 10:01:34', '2016-06-14 10:01:34');

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
-- Table structure for table `parameters`
--

CREATE TABLE IF NOT EXISTS `parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parameter` varchar(100) NOT NULL,
  `max_marks` varchar(20) NOT NULL,
  `active` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`id`, `parameter`, `max_marks`, `active`, `updated_at`, `created_at`) VALUES
(1, 'Theory1', '100', 0, '2016-06-11 11:47:45', '2016-06-11 11:34:02'),
(2, 'Practicles', '100', 0, '2016-06-11 11:57:29', '2016-06-11 11:50:54'),
(3, 'dasdafd', '100', 1, '2016-06-11 11:52:09', '2016-06-11 11:51:07'),
(4, 'dfasdf', '450', 1, '2016-06-11 11:53:29', '2016-06-11 11:53:18'),
(5, 'dfadsf', '54', 1, '2016-06-11 11:54:24', '2016-06-11 11:54:16'),
(6, 'sdasdfad', '100', 1, '2016-06-13 09:36:21', '2016-06-13 09:36:13'),
(7, 'English', '100', 0, '2016-06-14 09:45:50', '2016-06-14 09:45:50'),
(8, 'Hindi', '100', 0, '2016-06-14 09:45:57', '2016-06-14 09:45:57');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `application_id`, `fees`, `payment_method`, `cheque_date`, `cheque_number`, `bank_name`, `remarks`, `status`, `updated_at`, `created_at`) VALUES
(2, 4, 500, 2, '2016-05-13', 125633, 'PNB', 'afdsafd', 0, '2016-05-30 06:31:34', '2016-05-06 14:08:35'),
(3, 2, 100, 3, '0000-00-00', 0, '', 'dafsdfa1', 0, '2016-05-10 11:11:07', '2016-05-06 14:16:35'),
(7, 5, 100, 3, '0000-00-00', 0, '', 'i wil pay that ammount at the department counter', 0, '2016-05-09 13:53:48', '2016-05-09 13:05:17'),
(8, 6, 500, 1, '2016-05-25', 454512, 'SBI', 'dfads asdf adsf', 0, '2016-05-30 07:38:22', '2016-05-30 07:38:22');

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
(14, 0, 'a:9:{s:5:"photo";s:51:"coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG";s:9:"dob_proof";s:43:"coaches-doc/dobProof__Table-of-Contents.pdf";s:10:"first_name";s:6:"chirag";s:11:"middle_name";s:0:"";s:9:"last_name";s:5:"verma";s:5:"email";s:25:"chiragverma2207@gmail.com";s:6:"gender";s:1:"1";s:3:"dob";s:10:"2016-05-18";s:11:"birth_place";s:5:"Delhi";}', 'a:11:{s:6:"_token";s:40:"2Es55k9ZmH5l0MvdYPckDCYcZLYFB5ovcoZJp4Nw";s:2:"id";s:2:"14";s:9:"state_reg";s:2:"36";s:15:"state_reference";s:2:"36";s:8:"address1";s:19:"80, mootichoor hari";s:8:"address2";s:0:"";s:4:"city";s:9:"Delhi/NCR";s:7:"pincode";s:6:"110094";s:5:"state";s:2:"36";s:6:"mobile";s:10:"9548766941";s:8:"landline";s:11:"09548766941";}', 'a:3:{s:14:"passport_proof";s:48:"coaches-doc/PassportProof__Table-of-Contents.pdf";s:15:"passport_expiry";s:10:"2016-05-14";s:8:"passport";s:8:"21234646";}', '2016-05-18 13:24:10', '0000-00-00 00:00:00'),
(15, 0, '', '', 'a:3:{s:14:"passport_proof";s:48:"coaches-doc/PassportProof__Table-of-Contents.pdf";s:15:"passport_expiry";s:10:"2016-05-20";s:8:"passport";s:7:"5465466";}', '2016-05-18 13:17:54', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `parameter_id` int(11) NOT NULL,
  `marks` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=348 ;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `application_id`, `parameter_id`, `marks`, `updated_at`, `created_at`) VALUES
(115, 4, 1, '88', '2016-06-14 13:00:59', '2016-06-14 13:00:59'),
(116, 4, 7, '99', '2016-06-14 13:00:59', '2016-06-14 13:00:59'),
(117, 4, 8, '55', '2016-06-14 13:00:59', '2016-06-14 13:00:59'),
(151, 6, 1, '50', '2016-06-18 09:40:29', '2016-06-18 09:40:29'),
(152, 6, 7, '55', '2016-06-18 09:40:29', '2016-06-18 09:40:29'),
(153, 6, 8, '78', '2016-06-18 09:40:29', '2016-06-18 09:40:29'),
(157, 7, 1, '10', '2016-06-18 09:43:07', '2016-06-18 09:43:07'),
(158, 7, 7, '20', '2016-06-18 09:43:07', '2016-06-18 09:43:07'),
(159, 7, 8, '30', '2016-06-18 09:43:07', '2016-06-18 09:43:07'),
(344, 5, 1, '40', '2016-06-18 13:15:21', '2016-06-18 13:15:21'),
(345, 5, 2, '50', '2016-06-18 13:15:21', '2016-06-18 13:15:21'),
(346, 5, 7, '60', '2016-06-18 13:15:21', '2016-06-18 13:15:21'),
(347, 5, 8, '70', '2016-06-18 13:15:21', '2016-06-18 13:15:21');

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
  `hash` varchar(200) NOT NULL,
  `active` int(11) NOT NULL,
  `privilege` int(11) NOT NULL,
  `remember_token` varchar(200) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `coach_id`, `username`, `password`, `password_check`, `hash`, `active`, `privilege`, `remember_token`, `updated_at`, `created_at`) VALUES
(4, 3, 'vishu@gmail.com', '$2y$10$BoJ.8qC7BfiY1C13m1jg4.yOzfqzr6sZI7/GK8nUVRcXP70b0jHcC', 'sample', '', 0, 1, 'b26Wk4lxRfAksgijr9NVOyhvr4H5HU3Oe8UaqlGLYDh31gAj6KqyQpo99Wwx', '2016-06-18 10:18:46', '2016-04-22 13:15:58'),
(5, 0, 'admin', '$2y$10$QOY2gfuw6v6.oqDB4V30nuXy.y3QVMJxVF26JK3dhHddnR8XF2KwS', 'sample', '', 0, 2, 'XZObg9eA3OFYs34kZjTtdeXcX3yAiKCkGhaa8acK0B0Ss1XpWBX8W4MEJvPX', '2016-06-18 10:14:47', '0000-00-00 00:00:00'),
(6, 8, 'sachin@blasters.com', '$2y$10$5jJBfXXG/yKijR0RDTXp4Oo0Nv.QLD0wQHiZWAz2K42NGnle13QdO', '0D42uMJI', '', 0, 1, '', '2016-05-09 12:43:22', '2016-05-09 12:43:22'),
(8, 10, 'shubham@gmail.com', '$2y$10$wWMRIknP6GIG7/VRYjv1VOYzOBArH9H1rXQb5KqY.QPl95znjwc.u', 'HCVQX3N4', '', 0, 1, '', '2016-05-10 09:39:54', '2016-05-10 09:39:54'),
(9, 11, 'avyay@gmail.com', '$2y$10$7CjfQ9JoTUz.Fs4.L1Jkau95TnT6vW.ZIZx5RoBQI2hX/ioRob0am', '80efBswP', '', 0, 1, '', '2016-05-12 12:24:56', '2016-05-12 12:24:56'),
(10, 12, 'sachin@blasters.com', '$2y$10$5pB0fsnXoTG0kxYFVArpk.7Oxxr4wpcZARCS7mcnt6a89/YalzbXO', 'PHTHcmxi', '', 0, 1, '', '2016-05-12 12:27:57', '2016-05-12 12:27:57'),
(11, 13, 'chiragverma2207@gmail.com', '$2y$10$tgibepon0xZLgGoz07neBuBJKJkooAPQ/pqvDBxSDBMvhikqjfd6e', '6FeTVief', '$2y$10$2XziIWTJjFc6gYHgcthYEe8hN7P2/Up.OrvxOhThytwPW9dKeXvEG', 1, 1, '', '2016-05-18 13:16:41', '2016-05-18 13:16:41'),
(12, 14, 'chiragverma2207@gmail.com', '$2y$10$iwWrpxNQ5wG4P2YjkwDqCeSzjccCWNxcUNvzlCXiB5rw8i7/c3zMq', 'CAgJBGL9', '$2y$10$qr9SbQFheBQqnc3Qr2zga.3/3PY1WbHtWq.3pcxnqGyeQtTOqcoXu', 1, 1, '', '2016-05-18 13:18:51', '2016-05-18 13:18:51'),
(13, 15, 'chiragverma2207@gmail.com', '$2y$10$0h5L0iFR8UDsm4LG.TkSGuN65OVktbOIeYVzqFWhvK6lbhO8tA23.', '0Ku0eE3V', '$2y$10$vxMmq8ptcTjzJeC69I1QfeM1.zLunmfW2m0Mmt.p29mxYuwRtd8fe', 0, 1, '', '2016-05-18 13:22:13', '2016-05-18 13:22:00'),
(14, 17, 'chiragverma2207@gmail.com', '$2y$10$ltxwi2iZj//qHQUKVHo22O/uLtU7oWA4..8Zggld/C.7nQIsUUFy.', 'JikQ37Tp', '$2y$10$zjHDAbZ/RdlbnGlj2kdiLehTxOStoTId/VTljQgFvDRUQPdf9F7nm', 1, 1, '', '2016-05-18 13:24:34', '2016-05-18 13:24:34'),
(15, 18, 'chiragverma2207@gmail.com', '$2y$10$g5TbJuFpSifPpW9nqrpdr.YJba4y2BfaRgUyMGgzd6G8ezegzU4Ge', 'OQ3cFbA3', '$2y$10$X8HWSFERscAyytFFnXqn2uVdZPYP8PqLPLe2siT.ApQ0SsLjzJw56', 1, 1, '', '2016-05-18 13:25:10', '2016-05-18 13:25:10'),
(16, 19, 'chiragverma2207@gmail.com', '$2y$10$QgR3Bj63MdZkTXxesiopMeY6a9qE78np.kj2jtWe.eAZfwkHRvPai', 'RKp7YsLr', '$2y$10$IL/LJxoBQXiW9muk23nrye1YaY8PCYVHtmGrhX1AXENAx1b/qxoHK', 1, 1, '', '2016-05-18 13:25:20', '2016-05-18 13:25:20'),
(17, 20, 'chiragverma2207@gmail.com', '$2y$10$VBiK36q.GfXLkMacdvSvWOZ5IX.QFRiPIC54oXtU9M1aE0VeyPjR.', 'YY3GqcJ0', '$2y$10$ZO7qTXTFveASKU0eUzsYou08rDDVJVhyvNl662ecbCW2kH3JiTtoy', 1, 1, '', '2016-05-18 13:25:26', '2016-05-18 13:25:26'),
(18, 21, 'chiragverma2207@gmail.com', '$2y$10$kYP/pffZ.Mi7Nw/9TV7KwODHYQh6rzCMw5vNCOjUJ6vWOVghSaOs2', 'zK2rEDOK', '$2y$10$PSMEVKPZEwtxaqHIb0e1puJcbcwAenYlbWWFBiW1sTuqX9jGV5Ram', 1, 1, '', '2016-05-18 13:25:32', '2016-05-18 13:25:32'),
(19, 22, 'chiragverma2207@gmail.com', '$2y$10$wYFrXNkIDyWHZklaIV3vhe8/gR7wXemT33zXeGy9axoDJVMjxjyZy', 'hBPIEEKX', '$2y$10$jo5FFcRxm.aTjPPqRKcg7eWDL.hzDsumOmIaXTAfTC1r3Wdr3zB06', 0, 1, '', '2016-05-18 13:25:44', '2016-05-18 13:25:39'),
(20, 23, 'chiragverma2207@gmail.com', '$2y$10$MeQi2w9//wke8OJ61lu2mObbBrdpADDoA0ryBoD39Dg3KI6eh9bP2', 'M2ALHTHk', '$2y$10$3N9epV2nue0jM/Wk1y7FE.rI6wASgjp9u49LqePuHB7mOyoSPPa8i', 1, 1, '', '2016-05-18 13:26:33', '2016-05-18 13:26:33'),
(21, 24, 'chiragverma2207@gmail.com', '$2y$10$XpiWBSjYuGmWVgdqfCErceIxzNJgiRUg/dMCRTHeoj0jbqzigYXWy', 'gjsS0qt2', '$2y$10$1ScDLgQMJK5DgMKTHLyuc.68lzdkiiZEAlSI0RBYV6erFlZJc8dVq', 0, 1, '', '2016-05-18 13:27:08', '2016-05-18 13:26:56'),
(22, 0, 'resultAdmin', '$2y$10$/3PFbaVqp8KW7oHcpR5z8e4K7DhgiMGCRVy1HYMTJvgbz86GxoBpm', 'sample123', '', 0, 3, '29cSsLy0bgYdF6gULZa3mls9F1h72yiTEA3OnDs0gw3o43uNAqijVGPPILPO', '2016-06-14 13:12:27', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
