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
?>