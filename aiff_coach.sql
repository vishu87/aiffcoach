-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2016 at 02:32 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `course_id`, `coach_id`, `status`, `remarks`, `updated_at`, `created_at`) VALUES
(2, 1, 3, 0, 'Applied | Pending', '2016-05-30 07:09:48', '2016-04-30 13:27:41'),
(4, 2, 3, 3, 'afdsafd', '2016-06-14 13:00:30', '2016-05-02 10:00:09'),
(5, 6, 3, 3, 'Applied | Pending', '2016-05-09 14:18:18', '2016-05-09 13:04:38'),
(6, 7, 3, 0, 'Applied | Pending', '2016-06-28 08:12:16', '2016-05-10 12:59:09'),
(7, 7, 6, 0, '', '2016-08-22 12:40:42', '0000-00-00 00:00:00'),
(12, 10, 28, 1, 'Applied | Pending', '2016-08-29 10:20:57', '2016-07-11 10:19:46'),
(13, 5, 28, 3, 'jhgb', '2016-08-29 10:21:00', '2016-08-23 09:56:16'),
(15, 10, 8, 2, 'Applied | Pending', '2016-08-23 11:06:56', '2016-08-23 10:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `application_result`
--

CREATE TABLE IF NOT EXISTS `application_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `upload_marks` text NOT NULL,
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `application_result`
--

INSERT INTO `application_result` (`id`, `application_id`, `status`, `upload_marks`, `remarks`, `updated_at`, `created_at`) VALUES
(1, 6, 3, '', 'All Exam Clear', '2016-06-26 12:42:27', '0000-00-00 00:00:00'),
(3, 7, 3, '', 'Qualify', '2016-07-24 11:01:02', '0000-00-00 00:00:00'),
(5, 4, 3, '', 'Qualified', '2016-06-28 08:57:25', '0000-00-00 00:00:00'),
(7, 5, 1, 'marksFiles/upload_marks_How-To-Flash-Micromax-A102-MTK-Smartphone-With-SP-Flash-Tool.pdf', 'not clear', '2016-08-25 10:42:59', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

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
(31, 1, 1, 2, 5, 'dasfsdaf', '2016-05-05 11:39:36', '2016-05-05 11:39:36'),
(32, 1, 1, 3, 5, 'dsasdfads', '2016-06-28 08:10:04', '2016-06-28 08:10:04'),
(33, 1, 8, 2, 5, 'dafdsaf', '2016-06-28 08:10:14', '2016-06-28 08:10:14'),
(34, 1, 18, 2, 5, 'approved', '2016-08-23 07:42:27', '2016-08-23 07:42:27'),
(35, 1, 12, 2, 5, 'dfasdfaf', '2016-08-23 07:47:19', '2016-08-23 07:47:19'),
(36, 1, 13, 2, 5, 'dfasdafds', '2016-08-23 07:47:24', '2016-08-23 07:47:24'),
(37, 1, 27, 2, 5, 'sdfdadfgsfv', '2016-08-23 08:19:32', '2016-08-23 08:19:32'),
(38, 1, 27, 2, 5, 'dfasda', '2016-08-23 08:19:38', '2016-08-23 08:19:38'),
(39, 1, 15, 2, 5, 'dfasdfad', '2016-08-23 08:19:52', '2016-08-23 08:19:52'),
(40, 1, 1, 2, 5, 'dsfasdfad', '2016-08-23 08:34:34', '2016-08-23 08:34:34'),
(41, 1, 3, 2, 5, 'fadsfadsaf', '2016-08-23 08:34:40', '2016-08-23 08:34:40'),
(42, 1, 10, 2, 5, 'dadsfadsa', '2016-08-25 07:28:48', '2016-08-25 07:28:48');

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
  `full_name` varchar(500) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `dob` date NOT NULL,
  `state_id` int(11) NOT NULL,
  `status` int(5) NOT NULL,
  `gender` int(2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`id`, `registration_id`, `first_name`, `middle_name`, `last_name`, `full_name`, `photo`, `dob`, `state_id`, `status`, `gender`, `updated_at`, `created_at`) VALUES
(1, '', 'chirag', '', 'verma', '', 'coaches-doc/CHIRAG---WIN_20151003_143457.JPG', '1965-07-15', 36, 0, 1, '2016-08-27 17:31:48', '2016-04-22 13:00:18'),
(3, '', 'vishu', '', 'agg', '', 'coaches-doc/6-CHIRAG---WIN_20151003_143525.JPG', '1964-04-13', 32, 0, 1, '2016-08-27 17:31:48', '2016-04-22 13:15:57'),
(4, '', 'ankit ', 'kumar', 'gupta', '', 'coaches-doc/2-CHIRAG---WIN_20151003_143431.JPG', '2016-05-10', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-09 12:29:12'),
(5, '', 'ankit ', 'kumar', 'gupta', '', 'coaches-doc/2-CHIRAG---WIN_20151003_143431.JPG', '2016-05-10', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-09 12:30:34'),
(6, '', 'Sachin', 'Ramesh', 'Tendulkar', '', 'coaches-doc/2-CHIRAG---WIN_20151003_143457.JPG', '2016-05-26', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-09 12:38:05'),
(7, '', 'Sachin', 'Ramesh', 'Tendulkar', '', 'coaches-doc/2-CHIRAG---WIN_20151003_143457.JPG', '2016-05-26', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-09 12:39:40'),
(8, '', 'Sachin', 'Ramesh', 'Tendulkar', '', 'coaches-doc/13-CHIRAG---WIN_20151003_143525.JPG', '2016-05-04', 32, 0, 1, '2016-08-27 17:31:48', '2016-05-09 12:43:21'),
(9, '', 'ankit ', 'kumar', 'gupta', '', 'coaches-doc/3-CHIRAG---WIN_20151003_143457.JPG', '2016-05-10', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-09 12:47:19'),
(10, '', 'shubham', '', 'bhatt', 'jkhk', 'coaches-doc/4-CHIRAG---WIN_20151003_143431.JPG', '2016-05-25', 23, 0, 1, '2016-08-27 17:31:48', '2016-05-10 09:39:54'),
(11, '', 'Avyay', 'kumar', 'Aggarwal', 'gffjgjh', 'coaches-doc/photo__CHIRAG---WIN_20151003_143525.JPG', '2016-05-19', 36, 0, 1, '2016-08-27 17:31:48', '2016-05-12 12:24:55'),
(12, '', 'Sachin', 'Ramesh', 'Tendulkar', '', 'coaches-doc/13-CHIRAG---WIN_20151003_143525.JPG', '2016-05-26', 32, 0, 1, '2016-08-27 17:31:48', '2016-05-12 12:27:57'),
(13, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-08-27 17:31:48', '2016-05-18 13:16:40'),
(14, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-18 13:18:50'),
(15, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-08-27 17:31:48', '2016-05-18 13:21:59'),
(16, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-18 13:24:10'),
(17, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-18 13:24:33'),
(18, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-08-27 17:31:48', '2016-05-18 13:25:09'),
(19, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-18 13:25:19'),
(20, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-18 13:25:25'),
(21, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-18 13:25:31'),
(22, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-18 13:25:39'),
(23, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-18 13:26:32'),
(24, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 1, 1, '2016-08-27 17:31:48', '2016-05-18 13:26:55'),
(25, '', 'dafsda', '', 'asdafd', '', 'coaches-doc/photo_20150415120548122.jpg', '1966-12-30', 36, 1, 1, '2016-08-27 17:31:48', '2016-06-26 11:38:27'),
(26, '', 'dafsda', '', 'asdafd', '', 'coaches-doc/photo_20150415120548122.jpg', '1966-12-30', 36, 1, 1, '2016-08-27 17:31:48', '2016-06-26 11:39:26'),
(27, '', 'ravi', '', 'sharma', 'ravi sharma', 'coaches-doc/photo_25_construction-stage.png', '1990-04-09', 36, 1, 2, '2016-08-27 17:31:48', '2016-06-28 09:16:07'),
(28, '', 'chirag', '', 'verma', 'chirag verma', 'coaches-doc/photo_1487374_141912432845286_155216197888602831_n.jpg', '2016-08-24', 30, 1, 1, '2016-08-27 17:31:48', '2016-08-23 13:50:17'),
(29, '', 'chirag', '', 'verma', 'chirag vefm', 'coaches-doc/photo_27_1919096_141913469511849_4766196671235028884_n.jpg', '2016-08-19', 30, 1, 1, '2016-08-27 17:31:48', '2016-08-24 09:17:05'),
(30, '', 'chirag', '', 'verma', '', 'coaches-doc/photo_CHIRAG---WIN_20150602_192149.JPG', '2016-08-11', 30, 1, 2, '2016-08-27 17:31:48', '2016-08-24 12:02:28'),
(31, '', 'krishna', '', 'bhutt', 'krishna bhutt', 'coaches-doc/photo_1487374_141912432845286_155216197888602831_n.jpg', '2016-08-17', 32, 1, 1, '2016-08-27 17:31:48', '2016-08-24 12:36:52');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `coach_activity`
--

INSERT INTO `coach_activity` (`id`, `coach_id`, `from_date`, `to_date`, `place`, `event`, `participants`, `position_role`, `updated_at`, `created_at`) VALUES
(2, 3, '2016-12-21', '2016-12-22', 'India', '2016 IIFA', '15', '3', '2016-05-30 07:37:31', '2016-04-26 11:40:45'),
(3, 3, '0000-00-00', '0000-00-00', 'delhi', 'world Cup', '16', '2', '2016-04-26 11:49:30', '2016-04-26 11:49:30'),
(4, 28, '2016-06-14', '2016-06-24', 'Chennai', 'Chennai Football Club', '15', '3', '2016-08-29 09:38:59', '2016-06-28 09:21:13'),
(5, 28, '2016-08-15', '2016-08-25', 'Haridwar4', 'Haripur football tournament1', '15', '21', '2016-08-29 09:39:06', '2016-08-24 11:05:32'),
(6, 31, '2016-04-13', '2016-08-01', 'Delhi', 'Haripur football tournament', '', '2', '2016-08-24 13:57:36', '2016-08-24 13:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `coach_documents`
--

CREATE TABLE IF NOT EXISTS `coach_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `number` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `expiry_date` date NOT NULL,
  `remarks` text NOT NULL,
  `approved` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `coach_documents`
--

INSERT INTO `coach_documents` (`id`, `coach_id`, `document_id`, `name`, `number`, `file`, `expiry_date`, `remarks`, `approved`, `updated_at`, `created_at`) VALUES
(2, 27, 2, NULL, '', 'coaches-doc/file_25_OR-Details.pdf', '2016-08-07', 'voter card', 0, '2016-08-24 13:07:19', '2016-07-11 08:57:28'),
(7, 28, 6, 'Aiff Certifiacte', '451643', 'coaches-doc/file_25_OR-Details.pdf', '2016-08-17', 'other doucemnt', 0, '2016-08-29 09:32:38', '2016-07-11 09:30:44'),
(8, 29, 0, 'Birth Proof', '', 'coaches-doc/file_27_HDFC-Bank-Credit-Card.pdf', '2016-08-16', 'Recently uploaded', 0, '2016-08-24 13:07:11', '2016-08-24 09:45:02'),
(9, 29, 1, NULL, '', 'coaches-doc/file_27_IGNOU-Online-Admission.pdf', '2016-08-16', 'fdsfadaf', 0, '2016-08-24 13:07:07', '2016-08-24 12:29:10'),
(10, 31, 1, '', '234234', 'coaches-doc/PassportProof_by-enterprises.pdf', '2016-08-16', '', 0, '2016-08-24 13:07:02', '2016-08-24 12:36:52'),
(11, 31, 3, NULL, '', 'coaches-doc/file_29_by-enterprises.pdf', '2018-08-19', 'chr', 0, '2016-08-24 12:38:32', '2016-08-24 12:38:32'),
(12, 31, 4, NULL, '', 'coaches-doc/file_29_Payment-has-been-received-for-this-order---Mi-India.pdf', '2016-08-16', '', 0, '2016-08-24 13:04:17', '2016-08-24 13:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `coach_licenses`
--

CREATE TABLE IF NOT EXISTS `coach_licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL,
  `document` text NOT NULL,
  `number` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `coach_licenses`
--

INSERT INTO `coach_licenses` (`id`, `coach_id`, `license_id`, `document`, `number`, `start_date`, `end_date`, `updated_at`, `created_at`) VALUES
(2, 31, 3, '', '123456', '2016-05-10', '2016-08-26', '2016-08-29 12:06:39', '2016-08-29 11:57:56'),
(3, 31, 1, 'coach-licenses/dobProof_29_admission.du.ac.in_pg16_index.pdf', '1263', '2016-08-11', '2016-08-26', '2016-08-29 12:07:22', '2016-08-29 12:07:22');

-- --------------------------------------------------------

--
-- Table structure for table `coach_parameters`
--

CREATE TABLE IF NOT EXISTS `coach_parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob_proof` varchar(100) NOT NULL,
  `birth_place` varchar(100) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` int(20) NOT NULL,
  `address_state_id` int(11) NOT NULL,
  `alternate_email` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `landline` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `coach_parameters`
--

INSERT INTO `coach_parameters` (`id`, `coach_id`, `email`, `dob_proof`, `birth_place`, `address1`, `address2`, `city`, `pincode`, `address_state_id`, `alternate_email`, `mobile`, `landline`, `updated_at`, `created_at`) VALUES
(2, 3, 'vishu@gmail.com', 'coaches-doc/7-CHIRAG---WIN_20151003_143525.JPG', 'uttrakhand', '80, mootichoor haripur', 'Sidkul Haridwar 2', 'Delhi/NCR 1', 110093, 36, 'vishu123@gmail.com', '9548766941', '9548766941', '2016-05-10 13:15:33', '2016-04-22 13:15:57'),
(3, 8, 'sachin@blasters.com', 'coaches-doc/11-Table-of-Contents.pdf', 'Delhi', 'MB-33 Inderlok Colony', 'Sidkul Haridwar', 'haridwar', 249403, 36, '', '9548766941', '09548766941', '2016-08-23 10:49:49', '2016-05-09 12:43:21'),
(5, 10, 'shubham@gmail.com', 'coaches-doc/16-Table-of-Contents.pdf', 'Ranipokhri', '80, mootichoor hari', '', 'Delhi/NCR', 110094, 9, '', '78798798797', '', '2016-05-10 09:39:54', '2016-05-10 09:39:54'),
(6, 11, 'avyay@gmail.com', 'coaches-doc/dobProof__Table-of-Contents.pdf', 'HARIDWAR UTTRAKHAND', '80, mootichoor hari', 'Sidkul Haridwar', 'Delhi/NCR', 110094, 36, '', '9548766941', '09548766941', '2016-05-12 12:24:55', '2016-05-12 12:24:55'),
(7, 12, 'sachin@blasters.com', 'coaches-doc/11-Table-of-Contents.pdf', 'Delhi', 'MB-33 Inderlok Colony', 'Sidkul Haridwar', 'haridwar', 249403, 36, '', '9548766941', '09548766941', '2016-05-12 12:27:57', '2016-05-12 12:27:57'),
(20, 25, 'chiragverma27@gmail.com', 'coaches-doc/dobProof_26062014_Maths_SetA_QP_2.pdf', 'dsafdad', '80, mootichoor hari', 'Sidkul Haridwar', 'Delhi/NCR', 110094, 36, '', '9548766941', '09548766941', '2016-06-26 11:38:27', '2016-06-26 11:38:27'),
(21, 26, 'chiragverma27@gmail.com', 'coaches-doc/dobProof_26062014_Maths_SetA_QP_2.pdf', 'dsafdad', '80, mootichoor hari', 'Sidkul Haridwar', 'Delhi/NCR', 110094, 33, 'chiragverma2207@gmail.com', '9548766941', '09548766941', '2016-06-26 12:02:58', '2016-06-26 11:39:26'),
(22, 27, 'ravi@gmail.com', 'coaches-doc/dobProof_by-enterprises.pdf', 'haridwar', 'E-278 MAIN ROAD KHAJOORI KHAS, NEAR SANDHYA PUBLIC SCHOOL', 'NEAR SANDHYA PUBLIC SCHOOL', 'East Delhi', 110094, 36, '', '9548766941', '09548766941', '2016-07-10 09:54:04', '2016-06-28 09:16:07'),
(23, 28, 'chiragverma@gmail.com', 'coaches-doc/dobProof_HDFC-Bank-Credit-Card.pdf', 'Delhi', 'xfafadsfadsfds', '', 'fdsfadfa', 2153132, 36, '', '9873159377', 'd545132', '2016-08-23 13:50:18', '2016-08-23 13:50:18'),
(24, 29, 'kingramjas@gmail.com', 'coaches-doc/dobProof_Payment-has-been-received-for-this-order---Mi-India.pdf', 'fdsfadfa', 'xfafadsfadsfds', 'dfasdaf', 'fdsfadfa', 2153132, 30, '', '987315937721', 'd545132', '2016-08-24 10:56:44', '2016-08-24 09:17:05'),
(25, 30, 'dsfasjd@dlajf.com', 'coaches-doc/dobProof_by-enterprises.pdf', 'dsdfdsdfs', 'xfafadsfadsfds', '', 'fdsfadfa', 2153132, 33, '', '987315937721', 'd545132', '2016-08-24 12:02:28', '2016-08-24 12:02:28'),
(26, 31, 'krishna@gmail.com', 'coaches-doc/dobProof_Payment-has-been-received-for-this-order---Mi-India.pdf', 'Delhi', 'haripur', '', 'haridwar', 2153132, 32, '', '9873159377', '6876535', '2016-08-24 12:36:52', '2016-08-24 12:36:52');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `license_id` int(5) NOT NULL,
  `prerequisite_id` varchar(20) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `license_id`, `prerequisite_id`, `start_date`, `end_date`, `fees`, `venue`, `active`, `description`, `documents`, `updated_at`, `created_at`) VALUES
(4, 'past course', 1, '', '2016-03-27', '2016-04-02', 500, '', 0, '', 'coaches-doc/10-CHIRAG---WIN_20151003_143540.JPG', '2016-04-29 13:05:59', '2016-04-29 13:05:59'),
(5, 'B-grade', 2, '2,3', '2016-04-05', '2016-08-23', 500, 'dsafsdfasd', 0, 'dsafsdad', 'coaches-doc/11-CHIRAG---WIN_20151003_143540.JPG', '2016-08-25 11:23:15', '2016-04-30 10:45:14'),
(6, 'license bc', 2, '', '2016-05-12', '2016-05-28', 100, '', 0, '', '', '2016-06-13 10:58:44', '2016-05-05 09:27:49'),
(7, 'LLB', 1, '', '2016-05-02', '2016-05-28', 500, 'delhi', 0, 'kdfajlsdjfla', 'coaches-doc/Document_5_Table-of-Contents.pdf', '2016-06-14 09:56:39', '2016-05-10 12:47:30'),
(8, 'new course', 2, '', '2016-06-17', '2016-06-22', 1500, 'Delhi', 0, 'A test course', 'coaches-doc/Document_5_OR.pdf', '2016-06-09 10:33:25', '2016-06-09 10:33:25'),
(9, 'Test item', 2, '', '2016-08-07', '2016-08-11', 1500, 'delhi', 0, 'fdsfasdfasdfasdfa', '', '2016-08-22 12:25:16', '2016-08-22 12:25:16'),
(10, 'National Training', 2, '1,2', '2016-08-11', '2016-08-31', 500, 'delhi', 0, 'dafdsfadsfasd', '', '2016-08-25 11:21:40', '2016-08-23 10:38:38');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `courses_parameter`
--

INSERT INTO `courses_parameter` (`id`, `license_id`, `parameter_id`, `active`, `updated_at`, `created_at`) VALUES
(22, 2, 1, 0, '2016-08-25 09:45:13', '2016-08-25 09:45:13'),
(23, 2, 2, 0, '2016-08-25 09:45:13', '2016-08-25 09:45:13'),
(24, 2, 7, 0, '2016-08-25 09:45:13', '2016-08-25 09:45:13'),
(25, 2, 8, 0, '2016-08-25 09:45:13', '2016-08-25 09:45:13'),
(26, 2, 10, 0, '2016-08-25 09:45:13', '2016-08-25 09:45:13'),
(27, 1, 1, 0, '2016-08-25 09:47:03', '2016-08-25 09:47:03'),
(28, 1, 8, 0, '2016-08-25 09:47:03', '2016-08-25 09:47:03'),
(29, 3, 1, 0, '2016-08-25 09:49:28', '2016-08-25 09:49:28'),
(30, 3, 7, 0, '2016-08-25 09:49:28', '2016-08-25 09:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `name`) VALUES
(1, 'Passport'),
(2, 'Voter Id'),
(3, 'Aadhar Card'),
(4, 'Driving License'),
(5, 'Rason Card'),
(6, 'PAN Card');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `employment_details`
--

INSERT INTO `employment_details` (`id`, `coach_id`, `employment`, `start_date`, `end_date`, `contract`, `updated_at`, `created_at`) VALUES
(1, 1, 'Dehradun Football Association', '0000-00-00', '0000-00-00', 'coaches-doc/1-CHIRAG---WIN_20151003_143540.JPG', '2016-04-22 13:05:38', '2016-04-22 13:05:38'),
(2, 1, 'Raiwala Football Club', '0000-00-00', '0000-00-00', '', '2016-04-22 13:05:38', '2016-04-22 13:05:38'),
(6, 3, 'Himacal Football Club', '2014-07-11', '2014-07-16', 'coaches-doc/12-kanchanbvss-sss-c.png', '2016-05-05 12:24:53', '2016-04-22 13:17:09'),
(11, 3, 'Chennai Super Kings', '2014-07-25', '2014-07-30', 'coaches-doc/16-kanchanbvss-sss-c.png', '2016-05-05 12:26:36', '2016-04-26 09:32:53'),
(13, 26, 'Raiwala Football Club', '2016-06-08', '2016-06-07', NULL, '2016-06-26 11:56:11', '2016-06-26 11:56:11'),
(18, 26, 'dafsdafd', '2016-06-28', '2016-06-29', 'coaches-doc/presentemp_24_dfsda.pdf', '2016-06-26 12:36:57', '2016-06-26 12:36:57'),
(19, 27, 'Colkata Association 1', '2016-06-29', '2010-12-02', 'coaches-doc/PassportProof_25_by-enterprises.pdf', '2016-06-28 09:19:23', '2016-06-28 09:18:36'),
(20, 27, 'Himacal Football Club', '2016-06-24', '2016-06-15', NULL, '2016-06-28 09:18:36', '2016-06-28 09:18:36'),
(21, 28, 'Dehradun Football Association', '2016-06-16', '2016-06-17', 'coaches-doc/presentemp_25_by-enterprises.pdf', '2016-08-29 09:38:23', '2016-06-28 09:20:20'),
(22, 29, 'All India football club', '2010-08-10', '2011-06-15', 'coaches-doc/presentemp_27_How-To-Flash-Micromax-A102-MTK-Smartphone-With-SP-Flash-Tool.pdf', '2016-08-24 10:41:18', '2016-08-24 10:04:03'),
(25, 31, 'dfasdfads', '2016-08-10', '2014-01-14', 'coaches-doc/presentemp_29_IGNOU-Online-Admission.pdf', '2016-08-24 14:05:25', '2016-08-24 13:38:33'),
(26, 28, 'All India football club', '2010-08-10', '2016-08-02', 'coaches-doc/presentemp_29_Example-interview-questions-for-postgrad-study-_-TARGETpostgrad.pdf', '2016-08-29 09:37:56', '2016-08-24 13:50:04'),
(27, 31, 'dadsa', '2016-08-22', '1970-01-01', NULL, '2016-08-24 14:06:23', '2016-08-24 14:06:23');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `license`
--

INSERT INTO `license` (`id`, `name`, `description`, `authorised_by`, `updated_at`, `created_at`) VALUES
(1, 'chirag 1 ', 'this is for senior coaches', 1, '2016-04-28 13:37:46', '2016-04-28 13:37:35'),
(2, 'licensce B', 'junior coches can apply', 2, '2016-04-30 10:44:32', '2016-04-30 10:44:32'),
(3, 'test', 'dsasdfq', 2, '2016-08-25 09:49:16', '2016-08-25 09:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE IF NOT EXISTS `measurements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `shoes` varchar(20) NOT NULL,
  `boots` varchar(20) NOT NULL,
  `sliper` varchar(20) NOT NULL,
  `tracksuit` varchar(20) NOT NULL,
  `jersey` varchar(20) NOT NULL,
  `shorts` varchar(20) NOT NULL,
  `shirts` varchar(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `measurements`
--

INSERT INTO `measurements` (`id`, `coach_id`, `height`, `weight`, `shoes`, `boots`, `sliper`, `tracksuit`, `jersey`, `shorts`, `shirts`, `updated_at`, `created_at`) VALUES
(1, 27, 6, 80, '8', '10', '8', '44', '10', 'XL', '4', '2016-07-10 11:36:05', '2016-07-10 11:35:28'),
(2, 29, 150, 65, '8', '8', '7', '44', '10', '36', '42', '2016-08-24 09:48:50', '2016-08-24 09:47:52'),
(3, 31, 156, 0, '', '', '', '', '', '', '', '2016-08-24 13:07:36', '2016-08-24 13:07:27');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
(8, 'Hindi', '100', 0, '2016-06-14 09:45:57', '2016-06-14 09:45:57'),
(9, 'fasdfasdf', '100', 1, '2016-08-22 12:50:14', '2016-08-22 12:50:06'),
(10, 'Physical Education', '150', 0, '2016-08-22 13:18:28', '2016-08-22 13:18:28');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `application_id`, `fees`, `payment_method`, `cheque_date`, `cheque_number`, `bank_name`, `remarks`, `status`, `updated_at`, `created_at`) VALUES
(2, 4, 500, 2, '2016-05-13', 125633, 'PNB', 'afdsafd', 0, '2016-05-30 06:31:34', '2016-05-06 14:08:35'),
(3, 2, 100, 3, '0000-00-00', 0, '', 'dafsdfa1', 1, '2016-08-23 09:53:50', '2016-05-06 14:16:35'),
(7, 5, 100, 3, '0000-00-00', 0, '', 'i wil pay that ammount at the department counter', 1, '2016-08-23 09:53:45', '2016-05-09 13:05:17'),
(8, 6, 500, 1, '2016-05-25', 454512, 'SBI', 'dfads asdf adsf', 1, '2016-08-23 09:04:40', '2016-05-30 07:38:22'),
(9, 12, 100, 1, '0000-00-00', 545555, 'pnb', 'kdsjflajdljdsklajfl sdflasdl f\r\n', 0, '2016-07-11 10:22:01', '2016-07-11 10:22:01'),
(10, 13, 500, 3, '0000-00-00', 0, '', 'jhgb', 1, '2016-08-27 09:21:01', '2016-08-23 09:57:26'),
(11, 13, 500, 3, '0000-00-00', 0, '', '', 0, '2016-08-23 10:24:48', '2016-08-23 10:24:48'),
(13, 15, 500, 1, '0000-00-00', 87135486, 'PNB', 'fdsfasdfa', 0, '2016-08-23 11:06:55', '2016-08-23 11:06:55'),
(14, 16, 500, 1, '0000-00-00', 0, 'fdasdafdfa', 'dafsdaf', 0, '2016-08-24 11:24:05', '2016-08-24 11:24:05');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `registration_details`
--

INSERT INTO `registration_details` (`id`, `coach_id`, `certificate_no`, `certificate_copy`, `certificate_date`, `latest_certificate_copy`, `updated_at`, `created_at`) VALUES
(1, 1, 'A102', 'coaches-doc/3-CHIRAG---WIN_20151003_143525.JPG', '0000-00-00', 'coaches-doc/2-CHIRAG---WIN_20151003_143540.JPG', '2016-04-22 13:05:38', '2016-04-22 13:05:38'),
(2, 1, 'A102', 'coaches-doc/4-CHIRAG---WIN_20151003_143525.JPG', '0000-00-00', 'coaches-doc/4-CHIRAG---WIN_20151003_143540.JPG', '2016-04-22 13:07:47', '2016-04-22 13:07:47'),
(3, 3, 'A102', 'coaches-doc/8-CHIRAG---WIN_20151003_143525.JPG', '0000-00-00', 'coaches-doc/9-CHIRAG---WIN_20151003_143525.JPG', '2016-04-22 13:17:09', '2016-04-22 13:17:09'),
(4, 26, 'dsadsa', 'coaches-doc/aiffcertificate_24_CHIRAG---WIN_20150602_192149.JPG', '2016-06-29', 'coaches-doc/aiffLatest_24_CHIRAG---WIN_20151003_143457.JPG', '2016-06-26 11:56:11', '2016-06-26 11:56:11'),
(5, 27, 'A102', 'coaches-doc/aiffcertificate_25_by-enterprises.pdf', '2016-06-29', 'coaches-doc/aiffLatest_25_by-enterprises.pdf', '2016-06-28 09:18:36', '2016-06-28 09:18:36');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `reg_data`
--

INSERT INTO `reg_data` (`id`, `temp_id`, `data1`, `data2`, `data3`, `updated_at`, `created_at`) VALUES
(2, 0, 'a:9:{s:5:"photo";s:27:"coaches-doc/photo_INDIA.jpg";s:9:"dob_proof";s:46:"coaches-doc/dobProof_HDFC-Bank-Credit-Card.pdf";s:10:"first_name";s:6:"chirag";s:11:"middle_name";s:0:"";s:9:"last_name";s:5:"verma";s:5:"email";s:17:"dsfasjd@dlajf.com";s:6:"gender";s:1:"1";s:3:"dob";s:10:"2016-08-17";s:11:"birth_place";s:5:"Delhi";}', '', '', '2016-08-23 13:40:45', '0000-00-00 00:00:00'),
(4, 0, 'a:7:{s:10:"first_name";s:6:"chirag";s:11:"middle_name";s:0:"";s:9:"last_name";s:5:"verma";s:5:"email";s:19:"verma2207@gmail.com";s:6:"gender";s:1:"1";s:3:"dob";s:10:"2016-08-17";s:11:"birth_place";s:5:"Delhi";}', '', '', '2016-08-24 11:46:57', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=581 ;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `application_id`, `parameter_id`, `marks`, `updated_at`, `created_at`) VALUES
(501, 4, 1, '88', '2016-06-28 08:57:25', '2016-06-28 08:57:25'),
(502, 4, 7, '99', '2016-06-28 08:57:25', '2016-06-28 08:57:25'),
(503, 4, 8, '55', '2016-06-28 08:57:25', '2016-06-28 08:57:25'),
(538, 7, 1, '50', '2016-07-24 11:01:02', '2016-07-24 11:01:02'),
(539, 7, 7, '50', '2016-07-24 11:01:02', '2016-07-24 11:01:02'),
(540, 7, 8, '50', '2016-07-24 11:01:02', '2016-07-24 11:01:02'),
(578, 5, 1, '15', '2016-08-25 10:42:59', '2016-08-25 10:42:59'),
(579, 5, 2, '40', '2016-08-25 10:42:59', '2016-08-25 10:42:59'),
(580, 5, 7, '65', '2016-08-25 10:42:59', '2016-08-25 10:42:59');

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
  `official_types` varchar(10) NOT NULL,
  `manage_official_type` int(1) NOT NULL,
  `remember_token` varchar(200) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `coach_id`, `username`, `password`, `password_check`, `hash`, `active`, `privilege`, `official_types`, `manage_official_type`, `remember_token`, `updated_at`, `created_at`) VALUES
(4, 3, 'vishu@gmail.com', '$2y$10$BoJ.8qC7BfiY1C13m1jg4.yOzfqzr6sZI7/GK8nUVRcXP70b0jHcC', 'sample', '', 0, 1, '', 0, 'kfFCYGjKMtEIIUzmAoeQacrmG1Xu3YltOActqHwUxeF1WqaNYpdQrhUW2aDO', '2016-08-23 08:34:40', '2016-04-22 13:15:58'),
(5, 0, 'admin', '$2y$10$QOY2gfuw6v6.oqDB4V30nuXy.y3QVMJxVF26JK3dhHddnR8XF2KwS', 'sample', '', 0, 2, '', 1, 'G349Sutg9dXOpxrAKetjtTyNirkjdpn39Iv4DKettPBrvbi3OldWr8Ux5XTg', '2016-08-29 11:09:44', '0000-00-00 00:00:00'),
(6, 8, 'sachin@blasters.com', '$2y$10$5jJBfXXG/yKijR0RDTXp4Oo0Nv.QLD0wQHiZWAz2K42NGnle13QdO', '0D42uMJI', '', 0, 1, '', 0, 'HvLPUAsM6n8TxrtWRH5lSb9kvxR0Lakj2TBR7CytYh4WepaOSdGpfpyJCz0G', '2016-06-28 08:25:47', '2016-05-09 12:43:22'),
(8, 10, 'shubham@gmail.com', '$2y$10$wWMRIknP6GIG7/VRYjv1VOYzOBArH9H1rXQb5KqY.QPl95znjwc.u', 'HCVQX3N4', '', 0, 1, '1', 0, '', '2016-08-27 17:18:36', '2016-05-10 09:39:54'),
(9, 11, 'avyay@gmail.com', '$2y$10$7CjfQ9JoTUz.Fs4.L1Jkau95TnT6vW.ZIZx5RoBQI2hX/ioRob0am', '80efBswP', '', 0, 1, '1', 0, '', '2016-08-27 17:18:39', '2016-05-12 12:24:56'),
(10, 12, 'sachin@blasters.com', '$2y$10$5pB0fsnXoTG0kxYFVArpk.7Oxxr4wpcZARCS7mcnt6a89/YalzbXO', 'PHTHcmxi', '', 0, 1, '', 0, '', '2016-05-12 12:27:57', '2016-05-12 12:27:57'),
(11, 13, 'chiragverma2207@gmail.com', '$2y$10$tgibepon0xZLgGoz07neBuBJKJkooAPQ/pqvDBxSDBMvhikqjfd6e', '6FeTVief', '$2y$10$2XziIWTJjFc6gYHgcthYEe8hN7P2/Up.OrvxOhThytwPW9dKeXvEG', 1, 1, '', 0, '', '2016-05-18 13:16:41', '2016-05-18 13:16:41'),
(22, 0, 'resultAdmin', '$2y$10$4xUYSZ0rUTLaL4p3BEpzEumt2PVuhibDRatQQctJv5kCtlfgu3scW', 'sample', '', 0, 3, '', 0, 'vNA1aHj8OmInVDho9uFymPs6skEhc10afJxf8AAJaKAtiD4JCvSIRYaV1h82', '2016-08-25 10:59:01', '0000-00-00 00:00:00'),
(24, 26, 'chiragverma27@gmail.com', '$2y$10$c90K4IejSt6HXmKwYtTuXumrfwFl81o9i/qBlTdnPEyEuleoz5CjC', 'oAFF3Ulo', '$2y$10$aoeZuAN8L8IDxpiVQ2vHRON4zlcVNNQT7cSFXPdL2Ddp.2sg2CrNu', 0, 1, '', 0, '', '2016-06-28 08:07:30', '2016-06-26 11:39:27'),
(25, 27, 'ravi@gmail.com', '$2y$10$gA.9Ci.Wwu/0.3dg0kpwoecluN6bdSxlcliScqhAFLYB/6I8WDlvC', 'sample', '$2y$10$kAhwlEvYYydIPFx4hzKQmu7SY/S.iHcCjREZCVMoBcAvfMkTHnqfO', 0, 1, '', 0, '40GJj3siE70mIYX8yuQNbqm1AZdm9Qojb8Tkv24WYTNRcdxQ9L3lnO6owslm', '2016-07-11 10:30:21', '2016-06-28 09:16:08'),
(26, 28, 'chiragverma@gmail.com', '$2y$10$uT.LC0en.l4x4qDrderCbObDSBdb90Xvi6MhGAOrd2hsahklk4qNy', 'Co2AjJgP', '$2y$10$VN0XxwKTNejPobx2sMS6jecrKC.Pr4OPfGXdowgZfYoZJeTIyp9Mm', 0, 1, '1', 0, '', '2016-08-23 13:50:18', '2016-08-23 13:50:18'),
(27, 29, 'kingramjas@gmail.com', '$2y$10$REZOkANI8ujEzV39SQshKuA8jO3juVWS6/aUsIya64BzCGlN.Kn7y', 'w2eqxShK', '$2y$10$oLMMij6QIhKbfwyB3DfhD.xsgJZD3L7cSHnECBnaC4InnkrS.hep2', 0, 1, '1', 0, 'pZ9HVXxubwdQ27K4YHdLV9NKS6qWgD2zffjinxWLvlclV3MKUMuYlEnnoyj4', '2016-08-27 17:14:49', '2016-08-24 09:17:06'),
(28, 30, 'dsfasjd@dlajf.com', '$2y$10$dLnEnBGmxdo1gUIqw69mVesnzTX1Lmif.aAOI81q.FZn9xFzcD2im', 'ZokWdFHG', '$2y$10$gkngNy.0W3qWO7itNMBPDe81OMR.8WffkY4nzZOviAWEB/bWfnnn2', 0, 1, '1', 0, '', '2016-08-24 12:02:28', '2016-08-24 12:02:28'),
(29, 31, 'krishna@gmail.com', '$2y$10$omB9DAUubWbR71rx8dzNCOvgVmKcJxhmnJqcY9KhRfgEW4PTmYUbS', 'fe2Sc9TN', '$2y$10$c87NytIjAW5coza/jG/98u7.dE4jqot4Ky.NrGNu0f6zMA8KEXdAC', 0, 1, '1', 0, 'XLufAJLODF1vEu8hDEEbm6aL8uhvFeXwfx97s1OQjKTIi81y0AcDxShfcx5H', '2016-08-25 07:24:26', '2016-08-24 12:36:52');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
