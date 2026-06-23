-- Test seed data
-- Minimal records needed to run security tests.
-- Safe dummy data only — no real member information.

-- Test user account (password: 'TestPass123')
INSERT INTO `users` (`id`, `username`, `password`, `type`, `status`) VALUES
(9001, 'test_admin', MD5('TestPass123'), 1, 1)
ON DUPLICATE KEY UPDATE `username` = 'test_admin';

-- Test member record
INSERT INTO `members` (`id`, `Member_id`, `F_name`, `L_name`, `Email`, `status`) VALUES
(9001, 'TEST9001', 'Test', 'Member', 'test@example.com', 1)
ON DUPLICATE KEY UPDATE `Member_id` = 'TEST9001';

-- Test donation record
INSERT INTO `donation` (`id`, `Member_id`, `amount`, `status`, `date`) VALUES
(9001, 'TEST9001', 10.00, 'paid', NOW())
ON DUPLICATE KEY UPDATE `Member_id` = 'TEST9001';
