-- Teardown: remove all test seed data inserted by seed.sql
-- Run after tests complete to leave the test DB clean.

DELETE FROM `users`    WHERE `id`        = 9001;
DELETE FROM `members`  WHERE `id`        = 9001;
DELETE FROM `donation` WHERE `id`        = 9001;
