DROP TABLE IF EXISTS `donation`;
CREATE TABLE IF NOT EXISTS `donation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(250) DEFAULT NULL,
  `gift` varchar(250) DEFAULT NULL,
  `Payment_For` varchar(250) DEFAULT NULL,
  `MemberName` varchar(250) DEFAULT NULL,
  `Amount` float DEFAULT NULL,
  `PaymentOption` VARCHAR(255) DEFAULT NULL,
  `payment_status` VARCHAR(255) DEFAULT NULL,
  `payment_timestamp` VARCHAR(255) DEFAULT NULL,
  `stripe_return` VARCHAR(255) DEFAULT NULL,
  `transaction_id` VARCHAR(255) DEFAULT NULL,
  `paid_amount` VARCHAR(255) DEFAULT NULL,
  `stripe_product` VARCHAR(255) DEFAULT NULL,
  `update_on` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `students` CHANGE `subject` `subject` TEXT;

ALTER TABLE `members` CHANGE `status` `status` ENUM('T','F', 'E');

ALTER TABLE `members` CHANGE `Category` `Category` VARCHAR(255);

ALTER TABLE `members_log` ADD `rate` VARCHAR(255) DEFAULT NULL;

ALTER TABLE `members` ADD `rate` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `payment_status` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `payment_timestamp` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `stripe_return` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `transaction_id` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `paid_amount` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `stripe_product` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `donation` float DEFAULT NULL;
ALTER TABLE `members` ADD `amount` float DEFAULT NULL;
ALTER TABLE `members` ADD `fav_language` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `fav` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `total` float DEFAULT NULL;

ALTER TABLE `students` ADD `payment_method` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `students` ADD `payment_status` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `students` ADD `payment_timestamp` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `students` ADD `stripe_return` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `students` ADD `transaction_id` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `students` ADD `paid_amount` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `students` ADD `stripe_product` VARCHAR(255) DEFAULT NULL;

ALTER TABLE `members` ADD `Child4` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `members` ADD `Age4` VARCHAR(255) DEFAULT NULL;

ALTER TABLE `members` CHANGE `Age1` `Age1` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `members` CHANGE `Age2` `Age2` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `members` CHANGE `Age3` `Age3` VARCHAR(255) NULL DEFAULT NULL;

INSERT INTO `options` (`key`, `tab_id`, `group`, `value`, `title`, `description`, `label`, `type`, `order`, `calendar_id`) VALUES
('admin_new_member_subject', 4, 'member', 'Admin new member subject', 'Admin new member subject', '', NULL, 'string', 1, 1),
('admin_new_member_body', 4, 'member', 'Admin new member message', 'Admin new member message', '', NULL, 'text', 4, 1),
('active_member_subject', 4, 'member', 'Active member subject', 'Active member subject', '', NULL, 'string', 5, 1),
('active_member_body', 4, 'member', 'Active member message', 'Active member message', '', NULL, 'text', 6, 1);

INSERT INTO `options` (`id`, `key`, `tab_id`, `group`, `value`, `title`, `description`, `label`, `type`, `order`, `calendar_id`) VALUES
(NULL, 'gmi_1', 1, 'general', '150', 'General Member-Individual Due 1 Jan', '', '', 'float', 5, 1),
(NULL, 'gmi_4', 1, 'general', '165', 'General Member-Individual Due 1 Apr', '', '', 'float', 6, 1),
(NULL, 'gmf_1', 1, 'general', '200', 'General Member-Family Due jan1', '', '', 'float', 7, 1),
(NULL, 'gmf_4', 1, 'general', '220', 'General Member-Family Due 1 Apr', '', '', 'float', 8, 1),
(NULL, 'lm', 1, 'general', '3000', 'Life Member', '', '', 'float', 9, 1),
(NULL, 'bf', 1, 'general', '7500', 'Benefactor', '', '', 'float', 10, 1),
(NULL, 'pm', 1, 'general', '15000', 'Patron Member', '', '', 'float', 11, 1),
(NULL, 'lm_h', 1, 'general', '120', 'Maintenance (LM and higher)-per calendar Year', '', '', 'float', 12, 1);

INSERT INTO `options` (`id`, `key`, `tab_id`, `group`, `value`, `title`, `description`, `label`, `type`, `order`, `calendar_id`) VALUES
(NULL, 'student_annual', 1, 'general', '110', 'Student Annual', '', '', 'float', 13, 1),
(NULL, 'student_semester', 1, 'general', '60', 'Semester Annual', '', '', 'float', 14, 1);

INSERT INTO `options` (`id`, `key`, `tab_id`, `group`, `value`, `title`, `description`, `label`, `type`, `order`, `calendar_id`) VALUES
(NULL,'forgot_password_message', 8, 'forgot', '<p></p>', 'Forgot Password', '', NULL, 'text', 2, 1),
(NULL,'forgot_password_subject', 8, 'forgot', 'Forgot Password', 'Forgot Password', '', NULL, 'string', 1, 1);

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'array', 'backhand', '{Password} - new password', '{Password} - new password (For Forgot Passowrd)', 'email_forgot_password', '4'),
(NULL, 3, 'array', 'backhand', '{Email} - customer e-mail address', '{Email} - customer e-mail address', 'email_forgot_password', '2'),
(NULL, 3, 'array', 'backhand', '{FirstName} - customer first name', '{FirstName} - customer first name', 'email_forgot_password', '1'),
(NULL, 3, 'array', 'backhand', '{LastName} - customer last name', '{LastName} - customer last name', 'email_forgot_password', '0');

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'text', 'Member', 'Member', 'Member', 'member', '0'),
(NULL, 3, 'text', 'Member email', 'Member email', 'Member email', 'member_email', '0'),
(NULL, 3, 'array', 'backhand', '{ID} - ID', '{ID} - ID', 'member_email_token', '1'),
(NULL, 3, 'array', 'backhand', '{Information} - Information', '{Information} - Information', 'member_email_token', '2'),
(NULL, 3, 'array', 'backhand', '{GovtissueID} - GovtissueID', '{GovtissueID} - GovtissueID', 'member_email_token', '3'),
(NULL, 3, 'array', 'backhand', '{MembershipType} - Membership Type', '{MembershipType} - Membership Type', 'member_email_token', '4'),
(NULL, 3, 'array', 'backhand', '{Memberid} - Member id', '{Memberid} - Member id', 'member_email_token', '5'),
(NULL, 3, 'array', 'backhand', '{Category} - Category', '{Category} - Category', 'member_email_token', '6'),
(NULL, 3, 'array', 'backhand', '{F_Name} - F Name', '{F_Name} - F Name', 'member_email_token', '7'),
(NULL, 3, 'array', 'backhand', '{L_Name} - L Name', '{L_Name} - L Name', 'member_email_token', '8'),
(NULL, 3, 'array', 'backhand', '{Mob_No} - Mob No', '{Mob_No} - Mob No', 'member_email_token', '9'),
(NULL, 3, 'array', 'backhand', '{Sp_FName} - Sp FName', '{Sp_FName} - Sp FName', 'member_email_token', '10'),
(NULL, 3, 'array', 'backhand', '{Address1} - Address 1', '{Address1} - Address 1', 'member_email_token', '11'),
(NULL, 3, 'array', 'backhand', '{Address2} - Address 2', '{Address2} - Address 2', 'member_email_token', '12'),
(NULL, 3, 'array', 'backhand', '{Address3} - Address 3', '{Address3} - Address 3', 'member_email_token', '13'),
(NULL, 3, 'array', 'backhand', '{City} - City', '{City} - City', 'member_email_token', '14'),
(NULL, 3, 'array', 'backhand', '{State} - State', '{State} - State', 'member_email_token', '15'),
(NULL, 3, 'array', 'backhand', '{Country} - Country', '{Country} - Country', 'member_email_token', '16'),
(NULL, 3, 'array', 'backhand', '{Zip} - Zip', '{Zip} - Zip', 'member_email_token', '17'),
(NULL, 3, 'array', 'backhand', '{Email} - Email', '{Email} - Email', 'member_email_token', '18'),
(NULL, 3, 'array', 'backhand', '{Email2} - Email 2', '{Email2} - Email 2', 'member_email_token', '19'),
(NULL, 3, 'array', 'backhand', '{Tele1} - Tele 1', '{Tele1} - Tele 1', 'member_email_token', '20'),
(NULL, 3, 'array', 'backhand', '{Tele2} - Tele 2', '{Tele2} - Tele 2', 'member_email_token', '21'),
(NULL, 3, 'array', 'backhand', '{Child1} - Child 1', '{Child1} - Child 1', 'member_email_token', '21'),
(NULL, 3, 'array', 'backhand', '{Age1} - Age 1', '{Age1} - Age 1', 'member_email_token', '22'),
(NULL, 3, 'array', 'backhand', '{Child2} - Child 2', '{Child2} - Child 2', 'member_email_token', '23'),
(NULL, 3, 'array', 'backhand', '{Age2} - Age 2', '{Age2} - Age 2', 'member_email_token', '24'),
(NULL, 3, 'array', 'backhand', '{Child3} - Child 3', '{Child3} - Child 3', 'member_email_token', '25'),
(NULL, 3, 'array', 'backhand', '{Age3} - Age 3', '{Age3} - Age 3', 'member_email_token', '26'),
(NULL, 3, 'array', 'backhand', '{Parent1} - Parent 1', '{Parent1} - Parent 1', 'member_email_token', '27'),
(NULL, 3, 'array', 'backhand', '{Parent2} - Parent 2', '{Parent2} - Parent 2', 'member_email_token', '28'),
(NULL, 3, 'array', 'backhand', '{Remarks} - Remarks', '{Remarks} - Remarks', 'member_email_token', '29'),
(NULL, 3, 'array', 'backhand', '{Swap} - Swap', '{Swap} - Swap', 'member_email_token', '30'),
(NULL, 3, 'array', 'backhand', '{FirstSal} - FirstSal', '{FirstSal} - FirstSal', 'member_email_token', '31'),
(NULL, 3, 'array', 'backhand', '{Payment_method} - Payment method', '{Payment_method} - Payment method', 'member_email_token', '32'),
(NULL, 3, 'array', 'backhand', '{SpouseSal} - Spouse Sal', '{SpouseSal} - Spouse Sal', 'member_email_token', '33'),
(NULL, 3, 'array', 'backhand', '{CreatedOn} - CreatedOn', '{CreatedOn} - CreatedOn', 'member_email_token', '34'),
(NULL, 3, 'array', 'backhand', '{Password} - Password', '{Password} - Password', 'member_email_token', '35'),
(NULL, 3, 'array', 'backhand', '{Type} - Type', '{Type} - Type', 'member_email_token', '36'),
(NULL, 3, 'array', 'backhand', '{Status} - Status', '{Status} - Status', 'member_email_token', '37');

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'text', 'backhand', 'Session', 'Session', 'session', ''),
(NULL, 3, 'text', 'backhand', 'Updated Membership', 'Updated Membership', 'updated_membership', ''),
(NULL, 3, 'text', 'backhand', 'Member Name', 'Member Name', 'member_name', ''),
(NULL, 3, 'text', 'backhand', 'Edit Member', 'Edit Member', 'edit_member', ''),
(NULL, 3, 'text', 'backhand', 'Profile', 'Profile', 'profile', ''),
(NULL, 3, 'text', 'backhand', 'Pay', 'Pay', 'pay', '');

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'array', 'backhand', 'Inside Durgabari', 'Inside Durgabari', 'location_arr', 'inside'),
(NULL, 3, 'array', 'backhand', 'Outside Durgabari', 'Outside Durgabari', 'location_arr', 'outside'),
(NULL, 3, 'array', 'backhand', 'Online(epuja)', 'Online(epuja)', 'location_arr', 'online'),
(NULL, 3, 'array', 'backhand', '{Location} - Location', '{Location} - Location', 'email_token', '29'),
(NULL, 3, 'array', 'backhand', '{Location} - Location', '{Location} - Location', 'invoice_token', '38'),
(NULL, 3, 'array', 'backhand', 'Active', 'Active', 'member_status_arr', 'T'),
(NULL, 3, 'array', 'backhand', 'Pending', 'Pending', 'member_status_arr', 'F'),
(NULL, 3, 'array', 'backhand', 'Expire', 'Expire', 'member_status_arr', 'E');

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'array', 'backhand', 'New password is sent to your email', 'New password is sent to your email', 'status', '35'),
(NULL, 3, 'array', 'backhand', 'User with this email not exist!', 'User with this email not exist!', 'err', '12');