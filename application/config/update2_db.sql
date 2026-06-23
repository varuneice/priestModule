ALTER TABLE `custom_date` ADD `timestamp_end` VARCHAR(255) DEFAULT NULL AFTER `timestamp`;

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'text', 'backhand', 'Special Event', 'Special Event', 'special_event', '0'),
(NULL, 3, 'text', 'backhand', 'Start Date', 'Start Date', 'start_date', '0'),
(NULL, 3, 'text', 'backhand', 'End Date', 'End Date', 'end_date', '0');