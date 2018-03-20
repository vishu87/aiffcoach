<?php

ALTER TABLE `users`  ADD `official_types` VARCHAR(10) NOT NULL  AFTER `privilege`,  ADD `manage_official_type` INT(1) NOT NULL  AFTER `official_types`;

ALTER TABLE `coaches` CHANGE `state_registration` `state_id` INT NOT NULL;

ALTER TABLE `coach_parameters` DROP `passport_no`, DROP `passport_expiry`, DROP `passport_copy`;

ALTER TABLE `coach_documents`  ADD `expiry_date` DATE NOT NULL  AFTER `file`;

CREATE TABLE `documents` (`id` int(11) NOT NULL, `name` varchar(50) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `documents` ADD PRIMARY KEY (`id`);
ALTER TABLE `documents` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `coach_documents`  ADD `approved` INT(1) NOT NULL  AFTER `remarks`;

ALTER TABLE `coach_documents`  ADD `number` VARCHAR(100) NOT NULL  AFTER `name`;
//updated on chirag server

//25/08/2016 
ALTER TABLE `application_result` ADD `upload_marks` TEXT NOT NULL AFTER `status`;
ALTER TABLE `courses` ADD `prerequisite_id` VARCHAR(20) NOT NULL AFTER `license_id`;

ALTER TABLE `coaches`  ADD `full_name` VARCHAR(500) NOT NULL  AFTER `last_name`;
//updated on chirag server

//29/08/2016

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

// 30/08/2016

ALTER TABLE `coach_licenses` ADD `course_id` INT NOT NULL AFTER `coach_id`;

// 01-09
ALTER TABLE `users`  ADD `name` VARCHAR(200) NOT NULL  AFTER `coach_id`;

//02-09
ALTER TABLE `coach_licenses` ADD `status` INT(2) NOT NULL AFTER `document`;
ALTER TABLE `employment_details` ADD `status` INT(2) NOT NULL AFTER `contract`;
ALTER TABLE `coach_activity` ADD `status` INT(2) NOT NULL AFTER `position_role`;
ALTER TABLE `approval` ADD `document` TEXT NOT NULL AFTER `user_id`;

//03-09
ALTER TABLE `users` ADD `mobile` VARCHAR(11) NOT NULL AFTER `password_check`;
ALTER TABLE `courses` ADD `registration_start` DATE NOT NULL AFTER `end_date`, ADD `registration_end` DATE NOT NULL AFTER `registration_start`;

//06-09
ALTER TABLE `license`  ADD `user_type` INT NOT NULL  AFTER `authorised_by`;
ALTER TABLE `courses`  ADD `user_type` INT NOT NULL  AFTER `documents`;
ALTER TABLE `payment`  ADD `amount_paid` INT NOT NULL  AFTER `fees`;

//07-09
CREATE TABLE `application_log` (
`id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `closed` int(1) NOT NULL,
  `status` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document` text NOT NULL,
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

ALTER TABLE `application_log` ADD PRIMARY KEY (`id`);

ALTER TABLE `application_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;

//updated on chirag server
CREATE TABLE IF NOT EXISTS `course_result_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `result_admin_id` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

// 11-09-2016

ALTER TABLE `parameters` ADD `user_type` INT(2) NOT NULL AFTER `max_marks`;

//17-12-2016
ALTER TABLE `coach_documents` ADD `start_date` DATE NOT NULL AFTER `file`;

// 21/12/2016
ALTER TABLE `employment_details` ADD `emp_status` INT(1) NOT NULL DEFAULT '0' AFTER `employment`;

ALTER TABLE `employment_details` ADD `cv` TEXT NOT NULL AFTER `contract`;

ALTER TABLE `employment_details` ADD `referral_contact` VARCHAR(20) NOT NULL AFTER `cv`;

ALTER TABLE `coach_activity` CHANGE `position_role` `position_role` INT(3) NOT NULL;

ALTER TABLE `coach_activity` ADD `role_name` VARCHAR(50) NOT NULL AFTER `position_role`;

ALTER TABLE `payment` ADD `amount` INT NOT NULL AFTER `bank_name`;

//22-12-2016
ALTER TABLE `license` ADD `prerequisite_id` VARCHAR(20) NOT NULL AFTER `name`;

ALTER TABLE `courses` DROP `prerequisite_id`;

ALTER TABLE `license`  ADD `duration` INT NOT NULL DEFAULT '0'  AFTER `user_type`;

ALTER TABLE `coach_documents` CHANGE `start_date` `start_date` DATE NULL, CHANGE `expiry_date` `expiry_date` DATE NULL;

ALTER TABLE `courses`  ADD `postponed` INT(1) NULL  AFTER `registration_end`;

// 21/1/2017
ALTER TABLE `courses` CHANGE `registration_end` `registration_end` DATE NULL DEFAULT NULL;
ALTER TABLE `courses` CHANGE `registration_start` `registration_start` DATE NULL DEFAULT NULL;

// 24-01-2017

ALTER TABLE `results` CHANGE `marks` `marks` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;


// --
// -- Table structure for table `d_courses`
// --

CREATE TABLE IF NOT EXISTS `d_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(200) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `venue` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `d_licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `d_course_id` int(11) NOT NULL,
  `applicant_name` varchar(150) NOT NULL,
  `license_issue_date` date DEFAULT NULL,
  `license_number` varchar(100) NOT NULL,
  `remarks` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `d_courses` CHANGE `start_date` `start_date` DATE NULL DEFAULT NULL, CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL;

//20-02-2017 added by chirag

ALTER TABLE `coach_licenses` ADD `recc` INT(1) NULL DEFAULT '0' AFTER `license_id`, ADD `equivalent_license_id` INT NULL DEFAULT NULL AFTER `recc`;

ALTER TABLE `coach_licenses`  ADD `recc_document` TEXT NOT NULL  AFTER `recc`;

// 7-04-2017 added by chirag
ALTER TABLE `employment_details` CHANGE `start_date` `start_date` DATE NULL DEFAULT NULL, CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL;

// 4/8/2017 added by chirag

ALTER TABLE `coaches`  ADD `domicile_country` TEXT NULL DEFAULT NULL  AFTER `state_id`,  ADD `domicile_state` TEXT NULL DEFAULT NULL  AFTER `domicile_country`;

ALTER TABLE `coach_parameters`  ADD `address_country` TEXT NULL DEFAULT NULL  AFTER `address_state_id`,  ADD `address_state` TEXT NULL DEFAULT NULL  AFTER `address_country`;

// 08/09/2017 added by chirag
ALTER TABLE `license` ADD `show_dropdown` INT(1) NOT NULL DEFAULT '0' AFTER `description`;

// 17/11/2017 added by chirag
ALTER TABLE `employment_details` CHANGE `emp_status` `emp_status` INT(1) NULL DEFAULT '0';

// 17/1/2018 added by chirag
ALTER TABLE `coaches`  ADD `is_doctor` INT(1) NULL DEFAULT '0'  AFTER `full_name`,  ADD `doctor_degree` TEXT NULL DEFAULT NULL  AFTER `is_doctor`;