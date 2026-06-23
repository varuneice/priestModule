<?php
/**
 * fix_db_for_azure.php
 * Transforms a local phpMyAdmin SQL dump to be Azure MySQL 8.0 compatible.
 * Run once from CLI: php fix_db_for_azure.php
 * Output: durgab5_HDBS_Payment_Prod_azure.sql
 */

$inputFile  = __DIR__ . '/durgab5_HDBS_Payment_Prod (1).sql';
$outputFile = __DIR__ . '/durgab5_HDBS_Payment_Prod_azure.sql';

echo "Reading input file...\n";
$lines = file($inputFile, FILE_IGNORE_NEW_LINES);
if ($lines === false) {
    die("ERROR: Cannot read input file: $inputFile\n");
}
echo "Total lines: " . count($lines) . "\n";

// ─────────────────────────────────────────────────────────────────────────────
// Helpers
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Replace all zero-date literals with NULL in a data (INSERT) line.
 * Handles: '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00.000000'
 */
function fixZeroDates(string $line): string {
    $line = str_replace("'0000-00-00 00:00:00.000000'", 'NULL', $line);
    $line = str_replace("'0000-00-00 00:00:00'",        'NULL', $line);
    $line = str_replace("'0000-00-00'",                  'NULL', $line);
    return $line;
}

/**
 * Strip DEFINER=`user`@`host` from VIEW / PROCEDURE / TRIGGER definitions.
 */
function stripDefiner(string $line): string {
    return preg_replace('/\s*DEFINER=`[^`]+`@`[^`]+`/', '', $line);
}

// ─────────────────────────────────────────────────────────────────────────────
// NOT NULL date/datetime columns that must become DEFAULT NULL
// Key = exact column definition string inside CREATE TABLE (trimmed line)
// Value = replacement
// ─────────────────────────────────────────────────────────────────────────────
$nullableDateFixes = [
    // members_log — Createdon datetime(6) NOT NULL  contains zero-date data
    '`Createdon` datetime(6) NOT NULL,'         => '`Createdon` datetime(6) DEFAULT NULL,',
    '`Createdon` datetime(6) NOT NULL'          => '`Createdon` datetime(6) DEFAULT NULL',

    // vendorinvoices — pay_date date NOT NULL / created_on datetime NOT NULL
    '`pay_date` date NOT NULL,'                 => '`pay_date` date DEFAULT NULL,',
    '`pay_date` date NOT NULL'                  => '`pay_date` date DEFAULT NULL',
    '`created_on` datetime NOT NULL,'           => '`created_on` datetime DEFAULT NULL,',
    '`created_on` datetime NOT NULL'            => '`created_on` datetime DEFAULT NULL',

    // vendors — CreatedOn datetime NOT NULL
    '`CreatedOn` datetime NOT NULL,'            => '`CreatedOn` datetime DEFAULT NULL,',
    '`CreatedOn` datetime NOT NULL'             => '`CreatedOn` datetime DEFAULT NULL',

    // tickets — pay_date datetime NOT NULL / created_on already covered above
    '`pay_date` datetime NOT NULL,'             => '`pay_date` datetime DEFAULT NULL,',
    '`pay_date` datetime NOT NULL'              => '`pay_date` datetime DEFAULT NULL',

    // rentalreservations — enddate date NOT NULL (already known issue)
    '`enddate` date NOT NULL,'                  => '`enddate` varchar(255) DEFAULT NULL,',
    '`enddate` date NOT NULL'                   => '`enddate` varchar(255) DEFAULT NULL',

    // members / students — CreatedOn date NOT NULL
    '`CreatedOn` date NOT NULL,'                => '`CreatedOn` date DEFAULT NULL,',
    '`CreatedOn` date NOT NULL'                 => '`CreatedOn` date DEFAULT NULL',

    // pujaregistrationdate / registrationlastdate
    '`registrationDate` date NOT NULL,'         => '`registrationDate` date DEFAULT NULL,',
    '`registrationDate` date NOT NULL'          => '`registrationDate` date DEFAULT NULL',
];

// ─────────────────────────────────────────────────────────────────────────────
// Tables that need PRIMARY KEY + AUTO_INCREMENT added (no ALTER TABLE exists)
// These tables are missing both in the dump.
// ─────────────────────────────────────────────────────────────────────────────
$tablesNeedingPKAndAI = [
    'advancepayment',
    'category',
    'options',
    'donationForPuja',
    'donation_08312025',
    'PujaDonation_24_25',
    'RegularDonation_Puja_2024',
];

// Tables that have ADD PRIMARY KEY via ALTER TABLE but no AUTO_INCREMENT MODIFY
$tablesNeedingAIOnly = [
    'donation',
    'donation_20_aug',
    'donation_98',
    'event',
    'pujaregistrationChildBirthYear',
    'tickets',
];

// ─────────────────────────────────────────────────────────────────────────────
// Process lines
// ─────────────────────────────────────────────────────────────────────────────

$output       = [];
$inCreateTable = false;
$currentTable  = '';

// Header: replace SQL_MODE line, add FOREIGN_KEY_CHECKS=0
$headerDone = false;

echo "Processing lines...\n";

foreach ($lines as $i => $line) {

    // ── Replace the SET SQL_MODE line ──────────────────────────────────────
    if (!$headerDone && strpos($line, 'SET SQL_MODE') !== false) {
        $output[] = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";';
        $output[] = 'SET FOREIGN_KEY_CHECKS = 0;';
        $output[] = '/*!50503 SET NAMES utf8mb4 */;';
        $headerDone = true;
        continue;
    }

    // ── Track CREATE TABLE context ─────────────────────────────────────────
    if (preg_match('/^CREATE TABLE `([^`]+)`/', $line, $m)) {
        $inCreateTable = true;
        $currentTable  = $m[1];
    }
    if ($inCreateTable && trim($line) === ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        || ($inCreateTable && preg_match('/^\) ENGINE=/', $line))) {
        $inCreateTable = false;
        $currentTable  = '';
    }

    // ── Fix NOT NULL date columns → DEFAULT NULL ───────────────────────────
    $trimmed = trim($line);
    foreach ($nullableDateFixes as $search => $replace) {
        if (strpos($trimmed, $search) !== false) {
            $line = str_replace($search, $replace, $line);
            break;
        }
    }

    // ── Strip DEFINER from views / procedures ─────────────────────────────
    if (stripos($line, 'DEFINER') !== false) {
        $line = stripDefiner($line);
    }

    // ── Fix zero-date values in INSERT statements ──────────────────────────
    if (stripos($line, 'INSERT INTO') !== false || (
        strpos($line, "'0000-00-00'") !== false ||
        strpos($line, "'0000-00-00 00:00:00'") !== false ||
        strpos($line, "'0000-00-00 00:00:00.000000'") !== false
    )) {
        $line = fixZeroDates($line);
    }

    $output[] = $line;

    // Progress indicator every 10k lines
    if (($i + 1) % 10000 === 0) {
        echo "  Processed " . ($i + 1) . " lines...\n";
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Append extra ALTER TABLE statements at the end for tables missing PK + AI
// ─────────────────────────────────────────────────────────────────────────────

$output[] = '';
$output[] = '-- ============================================================';
$output[] = '-- Azure compatibility: add PRIMARY KEY + AUTO_INCREMENT';
$output[] = '-- to tables that were missing them in the original dump';
$output[] = '-- ============================================================';
$output[] = '';

foreach ($tablesNeedingPKAndAI as $table) {
    $output[] = "ALTER TABLE `$table` ADD PRIMARY KEY (`id`);";
    $output[] = "ALTER TABLE `$table` MODIFY COLUMN `id` int(11) NOT NULL AUTO_INCREMENT;";
    $output[] = '';
}

$output[] = '-- Tables that had PRIMARY KEY but missing AUTO_INCREMENT:';
$output[] = '';
foreach ($tablesNeedingAIOnly as $table) {
    $output[] = "ALTER TABLE `$table` MODIFY COLUMN `id` int(11) NOT NULL AUTO_INCREMENT;";
    $output[] = '';
}

// Also fix booking_slot and rentalbooking_slot (known issues from deployment)
$output[] = '-- booking_slot / rentalbooking_slot: ensure AUTO_INCREMENT on id';
$output[] = '-- (Azure may have created my_row_id invisible PK instead)';
$output[] = '-- Run these only if the tables do NOT already have id as PRIMARY KEY:';
$output[] = '-- ALTER TABLE `booking_slot` MODIFY COLUMN `id` int(11) NOT NULL AUTO_INCREMENT;';
$output[] = '-- ALTER TABLE `rentalbooking_slot` MODIFY COLUMN `id` int NOT NULL AUTO_INCREMENT;';
$output[] = '';

// ─────────────────────────────────────────────────────────────────────────────
// Create missing tables: login_attempts and items
// These were not in the original dump but are required by the application
// ─────────────────────────────────────────────────────────────────────────────

$output[] = '';
$output[] = '-- ============================================================';
$output[] = '-- Missing tables: login_attempts and items';
$output[] = '-- Not present in original dump — created here for Azure';
$output[] = '-- ============================================================';
$output[] = '';

$output[] = "CREATE TABLE IF NOT EXISTS `login_attempts` (";
$output[] = "  `id`           INT UNSIGNED  NOT NULL AUTO_INCREMENT,";
$output[] = "  `action`       VARCHAR(20)   NOT NULL DEFAULT 'login',";
$output[] = "  `identifier`   VARCHAR(255)  NOT NULL,";
$output[] = "  `attempted_at` DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,";
$output[] = "  PRIMARY KEY (`id`),";
$output[] = "  INDEX `idx_lookup` (`action`, `identifier`, `attempted_at`)";
$output[] = ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$output[] = '';

$output[] = "CREATE TABLE IF NOT EXISTS `items` (";
$output[] = "  `id`           INT(11)      NOT NULL AUTO_INCREMENT,";
$output[] = "  `categories`   VARCHAR(255) DEFAULT NULL,";
$output[] = "  `count`        VARCHAR(255) DEFAULT NULL,";
$output[] = "  `title`        VARCHAR(255) DEFAULT NULL,";
$output[] = "  `description`  VARCHAR(255) DEFAULT NULL,";
$output[] = "  `rent_by_hour` VARCHAR(255) DEFAULT NULL,";
$output[] = "  `rent_by_day`  VARCHAR(255) DEFAULT NULL,";
$output[] = "  `rent_by_week` VARCHAR(255) DEFAULT NULL,";
$output[] = "  `avatar`       VARCHAR(255) DEFAULT NULL,";
$output[] = "  PRIMARY KEY (`id`)";
$output[] = ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$output[] = '';

$output[] = 'SET FOREIGN_KEY_CHECKS = 1;';

// ─────────────────────────────────────────────────────────────────────────────
// Write output file
// ─────────────────────────────────────────────────────────────────────────────

echo "Writing output file...\n";
$result = file_put_contents($outputFile, implode("\n", $output));
if ($result === false) {
    die("ERROR: Cannot write output file: $outputFile\n");
}

echo "Done! Output written to:\n  $outputFile\n";
echo "File size: " . number_format(filesize($outputFile)) . " bytes\n";
echo "\nSummary of changes made:\n";
echo "  1. SET FOREIGN_KEY_CHECKS=0/1 wrapper added\n";
echo "  2. All '0000-00-00' date values replaced with NULL\n";
echo "  3. All DEFINER clauses stripped from VIEWs\n";
echo "  4. NOT NULL date/datetime columns changed to DEFAULT NULL\n";
echo "  5. ALTER TABLE AUTO_INCREMENT added for 13 tables\n";
echo "\nIMPORTANT: Before importing to Azure, verify the output file looks\n";
echo "correct by spot-checking a few CREATE TABLE and INSERT blocks.\n";
