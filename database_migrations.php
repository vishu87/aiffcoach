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

?>