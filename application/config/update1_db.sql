DROP TABLE IF EXISTS `custom_date`;
CREATE TABLE IF NOT EXISTS `custom_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) DEFAULT NULL,
  `tooltip` varchar(250) DEFAULT NULL,
  `timestamp` varchar(250) DEFAULT NULL,
  `start` varchar(250) DEFAULT NULL,
  `end` varchar(250) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `slot_lenght` float DEFAULT NULL,
  `count` float DEFAULT NULL,
  `lunch_start` varchar(250) DEFAULT NULL,
  `lunch_end` varchar(250) DEFAULT NULL,
  `is_day_off` tinyint(1) DEFAULT NULL,
  `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'text', 'Tooltip', 'Tooltip', 'Tooltip', 'tooltip', '0'),
(NULL, 3, 'text', 'Optinal', 'Optinal', 'Optinal', 'optinal', '0'),
(NULL, 3, 'text', 'Availability tickets', 'Availability tickets', 'Availability tickets', 'availability_tickets', '0');

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'text', 'backhand', 'Custom Working Times & Prices', 'Custom Working Times & Prices', 'custom_time', '0'),
(NULL, 3, 'text', 'backhand', 'Add', 'Add', 'add', '0'),
(NULL, 3, 'text', 'backhand', 'Delete seleted working time?', 'Delete seleted working time?', 'time_del_title', '0'),
(NULL, 3, 'text', 'backhand', 'All details will be deleted.', 'All details will be deleted.', 'time_del_body', '0');
