-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Sep 06, 2016 at 03:25 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

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

CREATE TABLE `activity` (
`id` int(11) NOT NULL,
  `coach_activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `details` varchar(150) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `action` int(11) NOT NULL COMMENT '1=>"approved" , 2=>"not approved" , 3=>"Mark Inactive", 4 =>"Mark Active"',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_privilege`
--

CREATE TABLE `admin_privilege` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `priv` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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

CREATE TABLE `applications` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=>"Not Approved",1=>"Payment Pending","2"=>"Payment Approval Pending","3"=>"Approved"',
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `course_id`, `coach_id`, `status`, `remarks`, `updated_at`, `created_at`) VALUES
(2, 1, 3, 0, 'Applied | Pending', '2016-05-30 07:09:48', '2016-04-30 13:27:41'),
(4, 2, 3, 3, 'afdsafd', '2016-06-14 13:00:30', '2016-05-02 10:00:09'),
(5, 6, 3, 3, 'Applied | Pending', '2016-05-09 14:18:18', '2016-05-09 13:04:38'),
(6, 7, 3, 0, 'Applied | Pending', '2016-06-28 08:12:16', '2016-05-10 12:59:09'),
(7, 7, 6, 0, '', '2016-08-22 12:40:42', '0000-00-00 00:00:00'),
(12, 1, 27, 1, 'Applied | Pending', '2016-08-02 08:40:26', '2016-07-11 10:19:46'),
(13, 5, 8, 3, 'ok', '2016-09-05 14:54:08', '2016-08-23 09:56:16'),
(15, 10, 8, 2, 'Applied | Pending', '2016-08-23 11:06:56', '2016-08-23 10:42:02'),
(16, 11, 8, 0, '', '2016-09-05 13:50:00', '2016-09-05 13:50:00'),
(17, 11, 8, 0, '', '2016-09-05 13:50:24', '2016-09-05 13:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `application_log`
--

CREATE TABLE `application_log` (
`id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `status` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document` text NOT NULL,
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `application_result`
--

CREATE TABLE `application_result` (
`id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `upload_marks` text NOT NULL,
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `application_result`
--

INSERT INTO `application_result` (`id`, `application_id`, `status`, `upload_marks`, `remarks`, `updated_at`, `created_at`) VALUES
(1, 6, 3, '', 'All Exam Clear', '2016-06-26 12:42:27', '0000-00-00 00:00:00'),
(3, 7, 3, '', 'Qualify', '2016-07-24 11:01:02', '0000-00-00 00:00:00'),
(5, 4, 3, '', 'Qualified', '2016-06-28 08:57:25', '0000-00-00 00:00:00'),
(7, 5, 2, '', 'not clear', '2016-08-22 13:09:45', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE `approval` (
`id` int(11) NOT NULL,
  `entity_type` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `status` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document` text NOT NULL,
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approval`
--

INSERT INTO `approval` (`id`, `entity_type`, `entity_id`, `status`, `user_id`, `document`, `remarks`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 1, 5, '', 'checking for modules', '2016-05-05 09:16:48', '2016-05-05 09:16:48'),
(2, 1, 3, 3, 5, '', 'bad guy', '2016-05-05 10:14:03', '2016-05-05 10:14:03'),
(3, 1, 1, 2, 5, '', 'good guy.', '2016-05-05 10:14:35', '2016-05-05 10:14:35'),
(4, 1, 3, 2, 5, '', 'not that much bad.', '2016-05-05 10:16:08', '2016-05-05 10:16:08'),
(5, 1, 1, 3, 5, '', 'testing', '2016-05-05 10:20:10', '2016-05-05 10:20:10'),
(6, 1, 1, 2, 5, '', 'testing again', '2016-05-05 10:20:34', '2016-05-05 10:20:34'),
(7, 1, 3, 3, 5, '', 'testing once again', '2016-05-05 10:21:10', '2016-05-05 10:21:10'),
(8, 1, 1, 3, 5, '', 'testing again', '2016-05-05 10:21:28', '2016-05-05 10:21:28'),
(9, 1, 3, 2, 5, '', 'dfadsaf', '2016-05-05 10:24:58', '2016-05-05 10:24:58'),
(10, 1, 3, 3, 5, '', 'dfasdfad', '2016-05-05 10:34:35', '2016-05-05 10:34:35'),
(11, 1, 1, 2, 5, '', 'dfadsadf', '2016-05-05 10:40:11', '2016-05-05 10:40:11'),
(12, 1, 1, 3, 5, '', 'dfadsad', '2016-05-05 10:40:31', '2016-05-05 10:40:31'),
(13, 1, 1, 2, 5, '', 'gvfdfws', '2016-05-05 10:41:10', '2016-05-05 10:41:10'),
(14, 1, 1, 3, 5, '', 'fgsdfsg', '2016-05-05 10:41:25', '2016-05-05 10:41:25'),
(15, 1, 1, 2, 5, '', 'vkldsjlfads', '2016-05-05 10:43:16', '2016-05-05 10:43:16'),
(16, 1, 1, 3, 5, '', 'fsaa', '2016-05-05 11:01:39', '2016-05-05 11:01:39'),
(17, 1, 1, 2, 5, '', 'sdfads', '2016-05-05 11:02:34', '2016-05-05 11:02:34'),
(18, 1, 1, 3, 5, '', 'kjhk', '2016-05-05 11:04:49', '2016-05-05 11:04:49'),
(19, 1, 1, 2, 5, '', 'dfasdfa', '2016-05-05 11:05:04', '2016-05-05 11:05:04'),
(20, 1, 1, 3, 5, '', 'jljn', '2016-05-05 11:06:09', '2016-05-05 11:06:09'),
(21, 1, 1, 2, 5, '', 'dfsfafsd', '2016-05-05 11:15:07', '2016-05-05 11:15:07'),
(22, 1, 3, 2, 5, '', 'dfsd', '2016-05-05 11:16:31', '2016-05-05 11:16:31'),
(23, 1, 1, 3, 5, '', 'kjhk', '2016-05-05 11:17:29', '2016-05-05 11:17:29'),
(24, 1, 1, 3, 5, '', 'kjhk', '2016-05-05 11:18:05', '2016-05-05 11:18:05'),
(25, 1, 1, 3, 5, '', 'kjhk', '2016-05-05 11:18:16', '2016-05-05 11:18:16'),
(26, 1, 1, 2, 5, '', 'jhgj', '2016-05-05 11:18:42', '2016-05-05 11:18:42'),
(27, 1, 1, 3, 5, '', 'kjhk', '2016-05-05 11:22:54', '2016-05-05 11:22:54'),
(28, 1, 1, 2, 5, '', 'dfads', '2016-05-05 11:24:40', '2016-05-05 11:24:40'),
(29, 1, 1, 3, 5, '', 'cxzdsff', '2016-05-05 11:25:50', '2016-05-05 11:25:50'),
(30, 1, 3, 3, 5, '', 'fsfadfa', '2016-05-05 11:39:06', '2016-05-05 11:39:06'),
(31, 1, 1, 2, 5, '', 'dasfsdaf', '2016-05-05 11:39:36', '2016-05-05 11:39:36'),
(32, 1, 1, 3, 5, '', 'dsasdfads', '2016-06-28 08:10:04', '2016-06-28 08:10:04'),
(33, 1, 8, 2, 5, '', 'dafdsaf', '2016-06-28 08:10:14', '2016-06-28 08:10:14'),
(34, 1, 18, 2, 5, '', 'approved', '2016-08-23 07:42:27', '2016-08-23 07:42:27'),
(35, 1, 12, 2, 5, '', 'dfasdfaf', '2016-08-23 07:47:19', '2016-08-23 07:47:19'),
(36, 1, 13, 2, 5, '', 'dfasdafds', '2016-08-23 07:47:24', '2016-08-23 07:47:24'),
(37, 1, 27, 2, 5, '', 'sdfdadfgsfv', '2016-08-23 08:19:32', '2016-08-23 08:19:32'),
(38, 1, 27, 2, 5, '', 'dfasda', '2016-08-23 08:19:38', '2016-08-23 08:19:38'),
(39, 1, 15, 2, 5, '', 'dfasdfad', '2016-08-23 08:19:52', '2016-08-23 08:19:52'),
(40, 1, 1, 2, 5, '', 'dsfasdfad', '2016-08-23 08:34:34', '2016-08-23 08:34:34'),
(41, 1, 3, 2, 5, '', 'fadsfadsaf', '2016-08-23 08:34:40', '2016-08-23 08:34:40'),
(42, 1, 30, 1, 5, '', 'ssaas', '2016-09-01 13:25:22', '2016-09-01 13:25:22'),
(43, 3, 1, 1, 5, '', 'assadassda', '2016-09-02 13:39:12', '2016-09-02 13:39:12'),
(44, 2, 8, 1, 5, '', 'Ok document', '2016-09-02 13:48:32', '2016-09-02 13:48:32'),
(45, 3, 2, 1, 5, '', 'OK', '2016-09-05 13:09:54', '2016-09-05 13:09:54'),
(46, 3, 3, 1, 5, '', 'Ok', '2016-09-05 13:18:29', '2016-09-05 13:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE `coaches` (
`id` int(11) NOT NULL,
  `registration_id` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `full_name` varchar(500) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `dob` date NOT NULL,
  `state_id` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `gender` int(2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`id`, `registration_id`, `first_name`, `middle_name`, `last_name`, `full_name`, `photo`, `dob`, `state_id`, `status`, `gender`, `updated_at`, `created_at`) VALUES
(1, '0', 'chirag', '', 'verma', '', 'coaches-doc/CHIRAG---WIN_20151003_143457.JPG', '1965-07-15', 36, 2, 1, '2016-08-23 08:34:34', '2016-04-22 13:00:18'),
(3, '0', 'vishu', '', 'agg', '', 'coaches-doc/6-CHIRAG---WIN_20151003_143525.JPG', '1964-04-13', 32, 2, 1, '2016-08-23 08:34:40', '2016-04-22 13:15:57'),
(4, '', 'ankit ', 'kumar', 'gupta', '', 'coaches-doc/2-CHIRAG---WIN_20151003_143431.JPG', '2016-05-10', 36, 0, 1, '2016-05-09 12:29:12', '2016-05-09 12:29:12'),
(5, '', 'ankit ', 'kumar', 'gupta', '', 'coaches-doc/2-CHIRAG---WIN_20151003_143431.JPG', '2016-05-10', 36, 0, 1, '2016-05-09 12:30:34', '2016-05-09 12:30:34'),
(6, '', 'Sachin', 'Ramesh', 'Tendulkar', '', 'coaches-doc/2-CHIRAG---WIN_20151003_143457.JPG', '2016-05-26', 36, 0, 1, '2016-05-09 12:38:05', '2016-05-09 12:38:05'),
(7, '', 'Sachin', 'Ramesh', 'Tendulkar', '', 'coaches-doc/2-CHIRAG---WIN_20151003_143457.JPG', '2016-05-26', 36, 0, 1, '2016-05-09 12:39:40', '2016-05-09 12:39:40'),
(8, '', 'Sachin', 'Ramesh', 'Tendulkar', '', 'coaches-doc/13-CHIRAG---WIN_20151003_143525.JPG', '2016-05-04', 32, 1, 1, '2016-09-05 13:00:36', '2016-05-09 12:43:21'),
(9, '', 'ankit ', 'kumar', 'gupta', '', 'coaches-doc/3-CHIRAG---WIN_20151003_143457.JPG', '2016-05-10', 36, 0, 1, '2016-05-09 12:47:19', '2016-05-09 12:47:19'),
(10, '', 'shubham', '', 'bhatt', '', 'coaches-doc/4-CHIRAG---WIN_20151003_143431.JPG', '2016-05-25', 23, 0, 1, '2016-05-10 09:39:54', '2016-05-10 09:39:54'),
(11, '', 'Avyay', 'kumar', 'Aggarwal', '', 'coaches-doc/photo__CHIRAG---WIN_20151003_143525.JPG', '2016-05-19', 36, 0, 1, '2016-05-12 12:24:55', '2016-05-12 12:24:55'),
(12, '', 'Sachin', 'Ramesh', 'Tendulkar', '', 'coaches-doc/13-CHIRAG---WIN_20151003_143525.JPG', '2016-05-26', 32, 2, 1, '2016-08-23 07:47:19', '2016-05-12 12:27:57'),
(13, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 2, 1, '2016-08-23 07:47:24', '2016-05-18 13:16:40'),
(14, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-05-18 13:18:50', '2016-05-18 13:18:50'),
(15, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 2, 1, '2016-08-23 08:19:52', '2016-05-18 13:21:59'),
(16, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-05-18 13:24:10', '2016-05-18 13:24:10'),
(17, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-05-18 13:24:33', '2016-05-18 13:24:33'),
(18, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 2, 1, '2016-08-23 07:42:27', '2016-05-18 13:25:09'),
(19, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-05-18 13:25:19', '2016-05-18 13:25:19'),
(20, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-05-18 13:25:25', '2016-05-18 13:25:25'),
(21, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-05-18 13:25:31', '2016-05-18 13:25:31'),
(22, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-05-18 13:25:39', '2016-05-18 13:25:39'),
(23, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-05-18 13:26:32', '2016-05-18 13:26:32'),
(24, '', 'chirag', '', 'verma', '', 'coaches-doc/photo__CHIRAG---WIN_20150602_192149.JPG', '2016-05-18', 36, 0, 1, '2016-05-18 13:26:55', '2016-05-18 13:26:55'),
(25, '', 'dafsda', '', 'asdafd', '', 'coaches-doc/photo_20150415120548122.jpg', '1966-12-30', 36, 0, 1, '2016-06-26 11:38:27', '2016-06-26 11:38:27'),
(26, '', 'dafsda', '', 'asdafd', '', 'coaches-doc/photo_20150415120548122.jpg', '1966-12-30', 36, 1, 1, '2016-06-26 11:56:11', '2016-06-26 11:39:26'),
(27, '', 'ravi', '', 'sharma', '', 'coaches-doc/photo_25_construction-stage.png', '1990-04-09', 36, 2, 2, '2016-08-23 08:19:38', '2016-06-28 09:16:07'),
(28, '2016Aug28', 'Vashisth', 'kumar', 'aggarwal', '', 'coaches-doc/photo_pic.jpg', '1953-04-03', 6, 0, 1, '2016-08-23 12:17:17', '2016-08-23 12:17:17'),
(29, '2016Aug29', 'MUKESH', '', 'KUMAR', '', 'coaches-doc/photo_pic.jpg', '1954-05-03', 6, 0, 1, '2016-08-23 12:36:50', '2016-08-23 12:36:50'),
(30, '2016Aug30', 'MUKESH1', '', 'KUMAR', 'MUKESH1 KUMAR', 'coaches-doc/photo_pic.jpg', '1954-05-03', 6, 1, 1, '2016-09-01 13:25:23', '2016-08-23 12:38:32'),
(31, '2016Aug31', 'MUKESH2', '', 'KUMAR', 'MUKESH2 KUMAR', 'coaches-doc/photo_pic.jpg', '2016-08-02', 2, 0, 1, '2016-08-27 13:01:36', '2016-08-24 12:28:03'),
(32, '2016Aug32', 'MUKESH3', '', 'KUMAR', 'MUKESH3 KUMAR', 'coaches-doc/photo_pic.jpg', '2016-08-09', 6, 0, 1, '2016-08-27 13:01:21', '2016-08-24 12:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `coach_activity`
--

CREATE TABLE `coach_activity` (
`id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `place` varchar(100) NOT NULL,
  `event` varchar(100) NOT NULL,
  `participants` varchar(50) NOT NULL,
  `position_role` varchar(50) NOT NULL,
  `status` int(2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coach_activity`
--

INSERT INTO `coach_activity` (`id`, `coach_id`, `from_date`, `to_date`, `place`, `event`, `participants`, `position_role`, `status`, `updated_at`, `created_at`) VALUES
(2, 3, '2016-12-21', '2016-12-22', 'India', '2016 IIFA', '15', '3', 0, '2016-05-30 07:37:31', '2016-04-26 11:40:45'),
(3, 3, '0000-00-00', '0000-00-00', 'delhi', 'world Cup', '16', '2', 0, '2016-04-26 11:49:30', '2016-04-26 11:49:30'),
(4, 27, '2016-06-14', '2016-06-24', 'Chennai', 'Chennai Football Club', '15', '3', 0, '2016-06-28 09:21:13', '2016-06-28 09:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `coach_documents`
--

CREATE TABLE `coach_documents` (
`id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `number` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `expiry_date` date NOT NULL,
  `remarks` text NOT NULL,
  `approved` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coach_documents`
--

INSERT INTO `coach_documents` (`id`, `coach_id`, `document_id`, `name`, `number`, `file`, `expiry_date`, `remarks`, `approved`, `updated_at`, `created_at`) VALUES
(2, 27, 2, NULL, '', 'coaches-doc/file_25_OR-Details.pdf', '0000-00-00', 'voter card', 0, '2016-07-11 08:57:28', '2016-07-11 08:57:28'),
(7, 27, 6, 'Aiff Certifiacte', '', 'coaches-doc/file_25_OR-Details.pdf', '0000-00-00', 'other doucemnt', 0, '2016-07-11 09:30:44', '2016-07-11 09:30:44'),
(8, 30, 1, NULL, '', 'coaches-doc/file_27_vas0001-(1).pdf', '0000-00-00', 'Auto Approve', 0, '2016-08-23 12:50:53', '2016-08-23 12:50:53'),
(9, 32, 1, NULL, '', 'coaches-doc/file_29_ADDRESS_PROOF.pdf', '2016-08-02', 'NA', 0, '2016-08-24 12:57:37', '2016-08-24 12:57:37'),
(10, 32, 0, 'DOB Proof', '', 'coaches-doc/file_29_vas0003.pdf', '2016-08-24', 'sasasadsa', 0, '2016-08-24 12:57:59', '2016-08-24 12:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `coach_licenses`
--

CREATE TABLE `coach_licenses` (
`id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL,
  `document` text NOT NULL,
  `status` int(2) NOT NULL,
  `number` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coach_licenses`
--

INSERT INTO `coach_licenses` (`id`, `coach_id`, `course_id`, `license_id`, `document`, `status`, `number`, `start_date`, `end_date`, `updated_at`, `created_at`) VALUES
(1, 30, 0, 1, '', 1, '223233', '2016-09-07', '1970-01-01', '2016-09-02 13:39:12', '2016-09-01 14:04:16'),
(3, 8, 0, 3, '', 1, 'ewewewwe', '2014-08-01', '1970-01-01', '2016-09-05 13:18:29', '2016-09-05 13:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `coach_parameters`
--

CREATE TABLE `coach_parameters` (
`id` int(11) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

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
(23, 28, 'vishu.iitd@gmail.com', 'coaches-doc/dobProof_pan-card.pdf', 'Faridabad', '402/6, Khatariwada, Agrasain Market', '', 'Faridabad', 121002, 1, '', '9756481682', '9756481682', '2016-08-23 12:17:17', '2016-08-23 12:17:17'),
(24, 29, 'vashi@1bhelhwr.co.in', 'coaches-doc/dobProof_vas0002-(2).pdf', 'HARIDWAR', '402/6, Khatariwada, Agrasain Market', '', 'Faridabad', 121002, 1, '', '9756481682', '9756481682', '2016-08-23 12:36:50', '2016-08-23 12:36:50'),
(25, 30, 'vashi@1bhelhwr.co.in', 'coaches-doc/dobProof_vas0002-(2).pdf', 'HARIDWAR', '402/6, Khatariwada, Agrasain Market', '', 'Faridabad', 121002, 1, '', '9756481682', '9756481682', '2016-08-23 12:38:32', '2016-08-23 12:38:32'),
(26, 31, 'vashi2@bhelhwr.co.in', 'coaches-doc/dobProof_ADDRESS_PROOF.pdf', 'HARIDWAR', 'HOUSE NO C-10, SHASHTRI NAGAR', 'JWALAPUR', 'HARIDWAR', 249407, 3, '', '9756481682', '', '2016-08-24 12:28:03', '2016-08-24 12:28:03'),
(27, 32, 'vashi3@bhelhwr.co.in', 'coaches-doc/dobProof_vas0002.pdf', 'HARIDWAR', '402/6, Khatariwada, Agrasain Market', '', 'Faridabad', 121002, 5, 'sadsas@asdas.com', '9756481682', '9756481682', '2016-08-24 12:57:08', '2016-08-24 12:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
`id` int(11) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `license_id`, `prerequisite_id`, `start_date`, `end_date`, `fees`, `venue`, `active`, `description`, `documents`, `updated_at`, `created_at`) VALUES
(4, 'past course', 1, '', '2016-03-27', '2016-04-02', 500, '', 0, '', 'coaches-doc/10-CHIRAG---WIN_20151003_143540.JPG', '2016-04-29 13:05:59', '2016-04-29 13:05:59'),
(5, 'B-grade', 2, '', '2016-04-12', '2016-08-25', 500, 'dsafsdfasd', 0, 'dsafsdad', 'coaches-doc/11-CHIRAG---WIN_20151003_143540.JPG', '2016-08-23 08:54:59', '2016-04-30 10:45:14'),
(6, 'license bc', 2, '', '2016-05-12', '2016-05-28', 100, '', 0, '', '', '2016-06-13 10:58:44', '2016-05-05 09:27:49'),
(7, 'LLB', 1, '', '2016-05-02', '2016-05-28', 500, 'delhi', 0, 'kdfajlsdjfla', 'coaches-doc/Document_5_Table-of-Contents.pdf', '2016-06-14 09:56:39', '2016-05-10 12:47:30'),
(8, 'new course', 2, '', '2016-06-17', '2016-06-22', 1500, 'Delhi', 0, 'A test course', 'coaches-doc/Document_5_OR.pdf', '2016-06-09 10:33:25', '2016-06-09 10:33:25'),
(9, 'Test item', 2, '', '2016-08-07', '2016-08-11', 1500, 'delhi', 0, 'fdsfasdfasdfasdfa', '', '2016-08-22 12:25:16', '2016-08-22 12:25:16'),
(10, 'National Training', 2, '', '2016-08-11', '2016-08-31', 500, 'delhi', 0, 'dafdsfadsfasd', '', '2016-08-23 10:38:38', '2016-08-23 10:38:38'),
(11, 'New course check', 2, '3', '2016-09-01', '2016-09-30', 1500, 'nainital', 0, 'no descrptsadasd asd', '', '2016-09-05 12:13:37', '2016-09-05 12:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `courses_parameter`
--

CREATE TABLE `courses_parameter` (
`id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL,
  `parameter_id` int(11) NOT NULL,
  `active` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses_parameter`
--

INSERT INTO `courses_parameter` (`id`, `license_id`, `parameter_id`, `active`, `updated_at`, `created_at`) VALUES
(8, 1, 1, 0, '2016-06-14 10:01:34', '2016-06-14 10:01:34'),
(9, 1, 7, 0, '2016-06-14 10:01:34', '2016-06-14 10:01:34'),
(10, 1, 8, 0, '2016-06-14 10:01:34', '2016-06-14 10:01:34'),
(18, 2, 1, 0, '2016-07-09 09:22:10', '2016-07-09 09:22:10'),
(19, 2, 2, 0, '2016-07-09 09:22:10', '2016-07-09 09:22:10'),
(20, 2, 7, 0, '2016-07-09 09:22:11', '2016-07-09 09:22:11'),
(21, 2, 8, 0, '2016-07-09 09:22:11', '2016-07-09 09:22:11');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `name`) VALUES
(1, 'Passport'),
(2, 'Driving License');

-- --------------------------------------------------------

--
-- Table structure for table `employment_details`
--

CREATE TABLE `employment_details` (
`id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `employment` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `contract` varchar(100) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employment_details`
--

INSERT INTO `employment_details` (`id`, `coach_id`, `employment`, `start_date`, `end_date`, `contract`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 'Dehradun Football Association', '0000-00-00', '0000-00-00', 'coaches-doc/1-CHIRAG---WIN_20151003_143540.JPG', 0, '2016-04-22 13:05:38', '2016-04-22 13:05:38'),
(2, 1, 'Raiwala Football Club', '0000-00-00', '0000-00-00', '', 0, '2016-04-22 13:05:38', '2016-04-22 13:05:38'),
(6, 3, 'Himacal Football Club', '2014-07-11', '2014-07-16', 'coaches-doc/12-kanchanbvss-sss-c.png', 0, '2016-05-05 12:24:53', '2016-04-22 13:17:09'),
(11, 3, 'Chennai Super Kings', '2014-07-25', '2014-07-30', 'coaches-doc/16-kanchanbvss-sss-c.png', 0, '2016-05-05 12:26:36', '2016-04-26 09:32:53'),
(13, 26, 'Raiwala Football Club', '2016-06-08', '2016-06-07', NULL, 0, '2016-06-26 11:56:11', '2016-06-26 11:56:11'),
(18, 26, 'dafsdafd', '2016-06-28', '2016-06-29', 'coaches-doc/presentemp_24_dfsda.pdf', 0, '2016-06-26 12:36:57', '2016-06-26 12:36:57'),
(19, 27, 'Colkata Association 1', '2016-06-29', '2010-12-02', 'coaches-doc/PassportProof_25_by-enterprises.pdf', 0, '2016-06-28 09:19:23', '2016-06-28 09:18:36'),
(20, 27, 'Himacal Football Club', '2016-06-24', '2016-06-15', NULL, 0, '2016-06-28 09:18:36', '2016-06-28 09:18:36'),
(21, 27, 'Dehradun Football Association', '2016-06-16', '2016-06-17', 'coaches-doc/presentemp_25_by-enterprises.pdf', 0, '2016-06-28 09:20:20', '2016-06-28 09:20:20'),
(22, 32, 'ssadsa', '2016-08-10', '2016-08-05', 'coaches-doc/presentemp_29_ADDRESS_PROOF.pdf', 0, '2016-08-24 13:18:06', '2016-08-24 13:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `license`
--

CREATE TABLE `license` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `authorised_by` int(5) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `license`
--

INSERT INTO `license` (`id`, `name`, `description`, `authorised_by`, `updated_at`, `created_at`) VALUES
(1, 'chirag 1 ', 'this is for senior coaches', 1, '2016-04-28 13:37:46', '2016-04-28 13:37:35'),
(2, 'licensce B', 'junior coches can apply', 2, '2016-04-30 10:44:32', '2016-04-30 10:44:32'),
(3, 'Test license 1', 'for football', 1, '2016-09-05 12:12:46', '2016-09-05 12:12:46'),
(4, 'Test license 2', 'for football', 2, '2016-09-05 12:13:02', '2016-09-05 12:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
`id` int(11) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `measurements`
--

INSERT INTO `measurements` (`id`, `coach_id`, `height`, `weight`, `shoes`, `boots`, `sliper`, `tracksuit`, `jersey`, `shorts`, `shirts`, `updated_at`, `created_at`) VALUES
(1, 27, 6, 80, '8', '10', '8', '44', '10', 'XL', '4', '2016-07-10 11:36:05', '2016-07-10 11:35:28'),
(2, 32, 0, 0, '', '', '', '', '', '', '', '2016-08-24 12:58:22', '2016-08-24 12:58:22');

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters` (
`id` int(11) NOT NULL,
  `parameter` varchar(100) NOT NULL,
  `max_marks` varchar(20) NOT NULL,
  `active` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

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

CREATE TABLE `payment` (
`id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `fees` int(11) NOT NULL,
  `payment_method` int(2) NOT NULL COMMENT '1=>"cheqe","2"=>"Draft","3"=>"Cash"',
  `cheque_date` date NOT NULL,
  `cheque_number` int(11) NOT NULL,
  `bank_name` text NOT NULL,
  `remarks` text,
  `status` int(1) NOT NULL COMMENT '0=>"Not Approved",1=>"Approved"',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `application_id`, `fees`, `payment_method`, `cheque_date`, `cheque_number`, `bank_name`, `remarks`, `status`, `updated_at`, `created_at`) VALUES
(2, 4, 500, 2, '2016-05-13', 125633, 'PNB', 'afdsafd', 0, '2016-05-30 06:31:34', '2016-05-06 14:08:35'),
(3, 2, 100, 3, '0000-00-00', 0, '', 'dafsdfa1', 1, '2016-08-23 09:53:50', '2016-05-06 14:16:35'),
(7, 5, 100, 3, '0000-00-00', 0, '', 'i wil pay that ammount at the department counter', 1, '2016-08-23 09:53:45', '2016-05-09 13:05:17'),
(8, 6, 500, 1, '2016-05-25', 454512, 'SBI', 'dfads asdf adsf', 1, '2016-08-23 09:04:40', '2016-05-30 07:38:22'),
(9, 12, 100, 1, '0000-00-00', 545555, 'pnb', 'kdsjflajdljdsklajfl sdflasdl f\r\n', 0, '2016-07-11 10:22:01', '2016-07-11 10:22:01'),
(10, 13, 500, 3, '0000-00-00', 0, '', 'ok', 1, '2016-09-05 14:54:08', '2016-08-23 09:57:26'),
(11, 13, 500, 3, '0000-00-00', 0, '', '', 0, '2016-08-23 10:24:48', '2016-08-23 10:24:48'),
(13, 15, 500, 1, '0000-00-00', 87135486, 'PNB', 'fdsfasdfa', 0, '2016-08-23 11:06:55', '2016-08-23 11:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `registration_details`
--

CREATE TABLE `registration_details` (
`id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `certificate_no` varchar(100) NOT NULL,
  `certificate_copy` varchar(100) NOT NULL,
  `certificate_date` date NOT NULL,
  `latest_certificate_copy` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

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

CREATE TABLE `reg_data` (
`id` int(11) NOT NULL,
  `temp_id` int(11) NOT NULL,
  `data1` text NOT NULL,
  `data2` text NOT NULL,
  `data3` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
`id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `parameter_id` int(11) NOT NULL,
  `marks` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=554 DEFAULT CHARSET=latin1;

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
(553, 5, 2, '40', '2016-08-22 13:09:45', '2016-08-22 13:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
`id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

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

CREATE TABLE `users` (
`id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `password_check` varchar(50) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `hash` varchar(200) NOT NULL,
  `active` int(11) NOT NULL,
  `privilege` int(11) NOT NULL,
  `official_types` varchar(10) NOT NULL,
  `manage_official_type` int(1) NOT NULL,
  `remember_token` varchar(200) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `coach_id`, `name`, `username`, `password`, `password_check`, `mobile`, `hash`, `active`, `privilege`, `official_types`, `manage_official_type`, `remember_token`, `updated_at`, `created_at`) VALUES
(4, 3, '', 'vishu@gmail.com', '$2y$10$BoJ.8qC7BfiY1C13m1jg4.yOzfqzr6sZI7/GK8nUVRcXP70b0jHcC', 'sample', '', '', 0, 1, '', 0, 'kfFCYGjKMtEIIUzmAoeQacrmG1Xu3YltOActqHwUxeF1WqaNYpdQrhUW2aDO', '2016-08-23 08:34:40', '2016-04-22 13:15:58'),
(5, 0, '', 'admin', '$2y$10$QOY2gfuw6v6.oqDB4V30nuXy.y3QVMJxVF26JK3dhHddnR8XF2KwS', 'sample', '', '', 0, 2, '', 1, 'actnPRGLALw34SMvgRVKzcnAkkLJuNTOsiTsst6mK0RuHZEbCEXgnwLjSSVs', '2016-09-05 12:14:26', '0000-00-00 00:00:00'),
(6, 8, '', 'sachin@blasters.com', '$2y$10$5jJBfXXG/yKijR0RDTXp4Oo0Nv.QLD0wQHiZWAz2K42NGnle13QdO', '0D42uMJI', '', '', 0, 1, '1', 0, 'HvLPUAsM6n8TxrtWRH5lSb9kvxR0Lakj2TBR7CytYh4WepaOSdGpfpyJCz0G', '2016-09-05 12:58:38', '2016-05-09 12:43:22'),
(8, 10, '', 'shubham@gmail.com', '$2y$10$wWMRIknP6GIG7/VRYjv1VOYzOBArH9H1rXQb5KqY.QPl95znjwc.u', 'HCVQX3N4', '', '', 0, 1, '', 0, '', '2016-05-10 09:39:54', '2016-05-10 09:39:54'),
(9, 11, '', 'avyay@gmail.com', '$2y$10$7CjfQ9JoTUz.Fs4.L1Jkau95TnT6vW.ZIZx5RoBQI2hX/ioRob0am', '80efBswP', '', '', 0, 1, '', 0, '', '2016-05-12 12:24:56', '2016-05-12 12:24:56'),
(10, 12, '', 'sachin@blasters.com', '$2y$10$5pB0fsnXoTG0kxYFVArpk.7Oxxr4wpcZARCS7mcnt6a89/YalzbXO', 'PHTHcmxi', '', '', 0, 1, '', 0, '', '2016-05-12 12:27:57', '2016-05-12 12:27:57'),
(11, 13, '', 'chiragverma2207@gmail.com', '$2y$10$tgibepon0xZLgGoz07neBuBJKJkooAPQ/pqvDBxSDBMvhikqjfd6e', '6FeTVief', '', '$2y$10$2XziIWTJjFc6gYHgcthYEe8hN7P2/Up.OrvxOhThytwPW9dKeXvEG', 1, 1, '', 0, '', '2016-05-18 13:16:41', '2016-05-18 13:16:41'),
(22, 0, '', 'resultAdmin', '$2y$10$4xUYSZ0rUTLaL4p3BEpzEumt2PVuhibDRatQQctJv5kCtlfgu3scW', 'sample', '', '', 0, 3, '', 0, 'ebVB7mLRQSIiwleUlKas6OOgFbL3uI9iZbZFvOFzqZCFgz2Ins48YiGLP4rJ', '2016-08-22 13:14:40', '0000-00-00 00:00:00'),
(24, 26, '', 'chiragverma27@gmail.com', '$2y$10$c90K4IejSt6HXmKwYtTuXumrfwFl81o9i/qBlTdnPEyEuleoz5CjC', 'oAFF3Ulo', '', '$2y$10$aoeZuAN8L8IDxpiVQ2vHRON4zlcVNNQT7cSFXPdL2Ddp.2sg2CrNu', 0, 1, '', 0, '', '2016-06-28 08:07:30', '2016-06-26 11:39:27'),
(25, 27, '', 'ravi@gmail.com', '$2y$10$gA.9Ci.Wwu/0.3dg0kpwoecluN6bdSxlcliScqhAFLYB/6I8WDlvC', 'sample', '', '$2y$10$kAhwlEvYYydIPFx4hzKQmu7SY/S.iHcCjREZCVMoBcAvfMkTHnqfO', 0, 1, '', 0, '40GJj3siE70mIYX8yuQNbqm1AZdm9Qojb8Tkv24WYTNRcdxQ9L3lnO6owslm', '2016-07-11 10:30:21', '2016-06-28 09:16:08'),
(26, 28, '', 'vishu.iitd@gmail.com', '$2y$10$ek/EADxM..2XtdIKDeRsfe0un1e9yFPS/8T1kwVISwbIUSFYVK6py', 'wJMdU7Bz', '', '$2y$10$1n7LftFFkSs2ysPQVXQnD.FByGUmWvWspVcIU.UKfnPBeDLRW9CXO', 0, 1, '', 0, 'K88I43Q77QmSaVLJsdzTfiWLwejv4V1q5Yc3D87ynqKAywwX669UOAoNrlVC', '2016-08-23 12:33:46', '2016-08-23 12:17:18'),
(27, 30, '', 'vashi@1bhelhwr.co.in', '$2y$10$6fcoMWjehT3lszCGRBoaCeqFlXrFyW3jYdRJH4O2n2PI3JL3YDbFq', 'TJ6MA1nN', '', '$2y$10$pkl1I5OiNaisRQZ5wC695.Q/HrHyIm5C0JZkWxQxVlSd8bhJJRRxa', 0, 1, '1,2', 0, '', '2016-08-27 12:35:33', '2016-08-23 12:38:33'),
(28, 31, '', 'vashi2@bhelhwr.co.in', '$2y$10$aIjzAQpcu7dhwogImD.ppe4Azm4losQHAY0Gj84.m.3.TTxxwO/JW', 'Al3TXPZ9', '', '$2y$10$Cl.o3PsjdW5/LCef641.bOOm6ziVaBt9jDpRJep.DfImG9e/i7OUi', 0, 1, '1', 0, 'gxkuTXeqYpMD9KZRmZ27Kcsx9OQmlj8c9vVQbamhDGv5XIuHbosPir0k1Xaa', '2016-08-24 12:29:22', '2016-08-24 12:28:03'),
(29, 32, '', 'vashi3@bhelhwr.co.in', '$2y$10$T2A7oyhDeOkHS9JxtFLWC.XYZeh9.v9PBVJgc.CKsLqCMVimum0/e', 'yQKvwGGN', '', '$2y$10$IAIX0WLFQiGevdWElatGh.LpDwRA1dZ1riEJ4TNsSEA7Gt41kQSSi', 0, 1, '2', 0, '', '2016-08-27 12:27:12', '2016-08-24 12:30:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_privilege`
--
ALTER TABLE `admin_privilege`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_log`
--
ALTER TABLE `application_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_result`
--
ALTER TABLE `application_result`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approval`
--
ALTER TABLE `approval`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coaches`
--
ALTER TABLE `coaches`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coach_activity`
--
ALTER TABLE `coach_activity`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coach_documents`
--
ALTER TABLE `coach_documents`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coach_licenses`
--
ALTER TABLE `coach_licenses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coach_parameters`
--
ALTER TABLE `coach_parameters`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses_parameter`
--
ALTER TABLE `courses_parameter`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employment_details`
--
ALTER TABLE `employment_details`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `license`
--
ALTER TABLE `license`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration_details`
--
ALTER TABLE `registration_details`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reg_data`
--
ALTER TABLE `reg_data`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_privilege`
--
ALTER TABLE `admin_privilege`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `application_log`
--
ALTER TABLE `application_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `application_result`
--
ALTER TABLE `application_result`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `approval`
--
ALTER TABLE `approval`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `coaches`
--
ALTER TABLE `coaches`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `coach_activity`
--
ALTER TABLE `coach_activity`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `coach_documents`
--
ALTER TABLE `coach_documents`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `coach_licenses`
--
ALTER TABLE `coach_licenses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `coach_parameters`
--
ALTER TABLE `coach_parameters`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `courses_parameter`
--
ALTER TABLE `courses_parameter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employment_details`
--
ALTER TABLE `employment_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `registration_details`
--
ALTER TABLE `registration_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `reg_data`
--
ALTER TABLE `reg_data`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=554;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
