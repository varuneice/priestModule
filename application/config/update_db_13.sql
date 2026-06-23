-- OTP verification table — shared across all public payment forms
-- context values: 'donation', 'giftshop', 'booking', 'rental', 'event', 'member'
-- Run via Admin > Update DB before deploying this release.
CREATE TABLE IF NOT EXISTS member_otp (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    member_id   INT NOT NULL,
    context     VARCHAR(50) NOT NULL,
    otp_code    VARCHAR(6) NOT NULL,
    ip_address  VARCHAR(45) NULL,
    attempts    TINYINT DEFAULT 0,
    verified    TINYINT(1) DEFAULT 0,
    expires_at  DATETIME NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    verified_at DATETIME NULL,
    INDEX idx_lookup (member_id, context, expires_at)
);
