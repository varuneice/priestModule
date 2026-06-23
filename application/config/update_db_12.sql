-- Fix missing AUTO_INCREMENT on core tables (Azure deployment issue)
-- The Azure database was set up without AUTO_INCREMENT on id columns,
-- causing INSERT failures: "Field 'id' doesn't have a default value".
--
-- Run this once in phpMyAdmin or Azure MySQL query editor.

ALTER TABLE `reservations`
    MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `login_attempts`
    MODIFY COLUMN `id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `rentalreservations`
    MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rentalreservations`
    MODIFY COLUMN `enddate` VARCHAR(255) NULL DEFAULT NULL;

-- booking_slot: Azure created an invisible auto PK (my_row_id) instead of using id.
-- Must remove it first, then make id the real AUTO_INCREMENT primary key.
-- Step 1: strip AUTO_INCREMENT from the invisible column
ALTER TABLE `booking_slot`
    MODIFY COLUMN `my_row_id` bigint unsigned NOT NULL;
-- Step 2: drop old PK, drop invisible column, promote id
ALTER TABLE `booking_slot`
    DROP PRIMARY KEY,
    DROP COLUMN `my_row_id`,
    MODIFY COLUMN `id` int unsigned NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

-- rentalbooking_slot: run SHOW CREATE TABLE first to confirm structure,
-- then apply the same two-step fix if my_row_id exists, e.g.:
-- ALTER TABLE `rentalbooking_slot` MODIFY COLUMN `my_row_id` bigint unsigned NOT NULL;
-- ALTER TABLE `rentalbooking_slot` DROP PRIMARY KEY, DROP COLUMN `my_row_id`,
--     MODIFY COLUMN `id` int unsigned NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`id`);

-- Zelle: fix confirm_code table so UpdatedOn allows NULL (Azure rejects empty string in DATE)
ALTER TABLE `confirm_code`
    MODIFY COLUMN `UpdatedOn` DATE NULL DEFAULT NULL;

-- Convert any existing 0000-00-00 rows to NULL (old non-strict MySQL artifact)
UPDATE `confirm_code` SET `UpdatedOn` = NULL WHERE `UpdatedOn` = '0000-00-00';
