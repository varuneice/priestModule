CREATE TABLE IF NOT EXISTS `member_category_thresholds` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_code` varchar(10) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `threshold_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `display_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_member_category_thresholds_category_code` (`category_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `member_category_thresholds`
  (`category_code`, `category_name`, `threshold_amount`, `display_order`, `is_active`)
VALUES
  ('LM', 'Life Member', 3000.00, 1, 1),
  ('BF', 'Benefactor', 7500.00, 2, 1),
  ('PM', 'Patron Member', 15000.00, 3, 1)
ON DUPLICATE KEY UPDATE
  `category_name` = VALUES(`category_name`),
  `threshold_amount` = VALUES(`threshold_amount`),
  `display_order` = VALUES(`display_order`),
  `is_active` = VALUES(`is_active`);
