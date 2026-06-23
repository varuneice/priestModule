-- Rate limiting: login and payment attempt tracking
-- Added: Phase 8 security remediation (2026-02-25)
--
-- Apply via Admin > Update DB, or run manually in phpMyAdmin.

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `action`       VARCHAR(20)  NOT NULL DEFAULT 'login'
                              COMMENT 'login | payment',
  `identifier`   VARCHAR(255) NOT NULL
                              COMMENT 'Client IP address',
  `attempted_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_lookup` (`action`, `identifier`, `attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  COMMENT='Tracks failed login and payment submission attempts for rate limiting.';
