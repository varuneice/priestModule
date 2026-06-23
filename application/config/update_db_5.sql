DROP TABLE IF EXISTS `confirm_code`;
CREATE TABLE IF NOT EXISTS `confirm_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(250) DEFAULT NULL,
  `Confirmation` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `reservations` ADD `confirm_code` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `reservations` ADD `stripe_return` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `reservations` ADD `transaction_id` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `reservations` ADD `paid_amount` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `reservations` ADD `stripe_product` VARCHAR(255) DEFAULT NULL;

INSERT INTO `options` (`key`, `tab_id`, `group`, `value`, `title`, `description`, `label`, `type`, `order`, `calendar_id`) VALUES
('stripe_allow', 3, 'peyment', '1|2::1', 'Stripe payment enable', '', 'Yes|No', 'enum', 20, 1),
('stripe_api_key', 3, 'peyment', 'STRIPE_SECRET_KEY_PLACEHOLDER', 'Stripe API key', '', NULL, 'string', 21, 1),
('stripe_publish_key', 3, 'peyment', 'STRIPE_PUBLISHABLE_KEY_PLACEHOLDER', 'Stripe API publishable key', '', NULL, 'string', 22, 1);

INSERT INTO `options` (`key`, `tab_id`, `group`, `value`, `title`, `description`, `label`, `type`, `order`, `calendar_id`) VALUES
('others_allow', 3, 'peyment', '1|2::1', 'Others payment enable', '', 'Yes|No', 'enum', 23, 1);

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'array', 'backhand', 'Others', 'Others', 'payment_method_arr', 'others'),
(NULL, 3, 'array', 'backhand', 'Stripe', 'Stripe', 'payment_method_arr', 'stripe');

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'text', 'backhand', 'Confirm Code', 'Confirm Code', 'confirm_code', '0');

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'text', 'backhand', 'Success Code', 'Success Code', 'success_code', '0');

INSERT INTO `i18n_local` (`id`, `language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`) VALUES
(NULL, 3, 'text', 'backhand', 'Error Code', 'Error Code', 'error_code', '0');
