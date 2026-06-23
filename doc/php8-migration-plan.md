# PHP 7.4 → 8.x Migration Plan
_Generated: 2026-02-24 | Last updated: 2026-03-12 (Phase 5 in progress — batches 36–43 applied, error log clean, code review sweep complete)_

---

## Overview

The application currently runs **PHP 7.4.30** (built June 2022), which reached end-of-life on **November 28, 2022** and no longer receives security patches. The target upgrade version is **PHP 8.2 (LTS)**, supported until December 2026.

This document outlines the full migration path based on a static scan of the codebase.

---

## Target Version Recommendation

| Version | Support Until | Recommendation |
|---|---|---|
| PHP 8.0 | EOL Nov 2023 | Skip |
| PHP 8.1 | EOL Nov 2024 | Skip |
| **PHP 8.2** | Dec 2026 | **Recommended target** |
| PHP 8.3 | Nov 2027 | Acceptable, slightly more risk |

Go straight to **PHP 8.2** — it skips two already-EOL versions and gives the longest remaining support window without jumping to the bleeding edge.

---

## Phase 1 — Audit & Preparation

> Do this before touching any code.

1. Set up a **dedicated dev/test environment** — never run migration work against production
2. Enable **full error reporting** (`E_ALL`) in the dev environment so nothing is silently hidden
3. Run a **static analysis tool** against the codebase to generate a full automated compatibility report:
   - [PHP Rector](https://getrector.com/) — automated upgrade tool
   - [PHPCompatibility](https://github.com/PHPCompatibility/PHPCompatibility) — detects version-specific issues
4. Take a **full backup** of all files and the database before any changes begin
5. Set up **version control (Git)** if not already in place, to track all migration changes

---

## Phase 2 — Fix Fatal Errors (PHP 8.0 Hard Breaks)

These will cause immediate fatal errors on PHP 8.0+ — the application will not boot until resolved.

### 2a. `mysql_*` Functions (Removed in PHP 7.0, fatal in 8.x)

| File | Line(s) | Issue |
|---|---|---|
| `core/framework/Object.class.php` | 10–11 | `mysql_query()`, `mysql_fetch_assoc()` |
| `application/helpers/PHPMailer_5.2.4/examples/test_db_smtp_basic.php` | 35–40 | `MYSQL_CONNECT()`, `mysql_select_db()`, `MYSQL_QUERY()`, `mysql_fetch_array()` |

**Action:** Replace all `mysql_*` calls with `mysqli_*` equivalents or PDO.

---

### 2b. `each()` Function (Removed in PHP 8.0)

| File | Line(s) | Issue |
|---|---|---|
| `application/helpers/MPDF57/mpdf.php` | 10888, 13034, 26345, 26347, 31090 | `each()` in `while(list(...) = each(...))` loops |
| `application/helpers/PHPMailer_5.2.4/class.phpmailer.php` | 2050 | `each()` in while loop |
| `application/helpers/PHPMailer_5.2.4/class.smtp.php` | 544, 573 | `@each()` in while loops |

**Action:** Replace all `each()` patterns with `foreach`. Note: most of these are inside third-party libraries — the preferred fix is to **upgrade the libraries** (see Phase 3).

---

### 2c. `get_magic_quotes_*` / `set_magic_quotes_*` (Removed in PHP 8.0)

| File | Line(s) | Issue |
|---|---|---|
| `application/helpers/MPDF57/compress.php` | 91, 96 | `get_magic_quotes_runtime()`, `set_magic_quotes_runtime(0)` |
| `application/helpers/MPDF57/mpdf.php` | 9478, 9480 | `ini_get("magic_quotes_runtime")` |
| `application/helpers/PHPMailer_5.2.4/class.phpmailer.php` | 1856–1870 | Multiple magic_quotes get/set calls |
| `application/controllers/GzFront.php` | 1200–1204 | `get_magic_quotes_gpc()` check |
| `application/controllers/GzFront_23_may.php` | 747–751 | `get_magic_quotes_gpc()` check |

**Action:** Remove all magic_quotes function calls entirely. Magic quotes were removed in PHP 5.4; these calls serve no purpose and will fatal on PHP 8.0+.

---

### 2d. Other Removed Functions to Audit

| Function | Removed In | Action |
|---|---|---|
| `create_function()` | PHP 8.0 | Replace with anonymous functions (`function() {}`) |
| `__autoload()` | PHP 8.0 | Replace with `spl_autoload_register()` |
| `hebrevc()` | PHP 8.0 | Replace with equivalent logic |
| `ctype_*` on non-string | PHP 8.1 | Ensure string arguments passed |

**Action:** Run a full codebase grep for these function names to confirm presence/absence.

---

## Phase 3 — Upgrade Third-party Libraries

> **COMPLETE 2026-02-27** — PHPMailer, mPDF, and Twilio upgraded. Authorize.Net deferred by user decision.

All four key bundled libraries are incompatible with PHP 8.x. Three have been upgraded; one is deferred.

| Library | Old Version | New Version | Status |
|---|---|---|---|
| **PHPMailer** | 5.2.4 | 6.12.0 (Composer) | **COMPLETE 2026-02-27** |
| **mPDF** | 5.7 | 8.2.7 (Composer) | **COMPLETE 2026-02-27** |
| **Authorize.Net SDK** | `~5.3` era | — | **DEFERRED** (user decision — requires full rewrite) |
| **Twilio SDK** | 6.35.1 | 8.11.1 (Composer) | **COMPLETE 2026-02-27** |

### What was done

**Step 1 — Composer install**
- Root `composer.json`: added `phpmailer/phpmailer:"^6.0"` and `mpdf/mpdf:"^8.0"`. Installed PHPMailer 6.12.0 and mPDF 8.2.7 into project root `vendor/`.
- Enabled PHP `ext-gd` in `C:\xampp82\php\php.ini` (required by mPDF 8).
- `application/controllers/Twillio/composer.json`: bumped `twilio/sdk` constraint from `^6.35` to `^8.0`. Upgraded to 8.11.1 in its own `vendor/`.

**Step 2 — Add autoloader to index.php**
- `index.php` line 21: added `require_once ROOT_PATH . 'vendor/autoload.php';` before config.php.

**Step 3 — PHPMailer 5.2.4 → 6.x (5 controller files + 2 root scripts)**

| File | Changes |
|---|---|
| `application/controllers/App.php` | Added `use PHPMailer\PHPMailer\PHPMailer;` + `use ... Exception as PHPMailerException;` after Twilio use. Removed 18 `require_once` lines. Fixed `catch (phpmailerException)` → `catch (PHPMailerException)`. |
| `application/controllers/AppRental.php` | Same — removed 5 `require_once` lines |
| `application/controllers/RentalBooking.php` | Same — removed 2 `require_once` lines |
| `application/controllers/Booking.php` | Same — removed 1 `require_once` line |
| `application/controllers/Invoice.php` | Added use statements after `require_once CONTROLLERS_PATH . 'App.php';`. Removed 1 `require_once` line. |
| `donationmain.php` | Replaced `include "application/helpers/PHPMailer_5.2.4/class.phpmailer.php";` with `require_once __DIR__ . '/vendor/autoload.php';` + use statements. Removed commented-out require_once. |
| `CronJobForGMToGD.php` | Same as donationmain.php. Fixed `catch (phpmailerException)`. |

Key compatibility notes for PHPMailer 6:
- Constructor `new PHPMailer(true)` — unchanged
- All existing method calls (`AddAddress`, `Send`, `IsHTML`, `MsgHTML`, etc.) — unchanged (PHP methods are case-insensitive)
- Exception class renamed: `phpmailerException` → `PHPMailer\PHPMailer\Exception` (aliased as `PHPMailerException` via `use`)

**Step 4 — mPDF 5.7 → 8.x (6 models + 2 controllers)**

| File | Changes |
|---|---|
| `application/models/Volunteersdata.model.php` | Removed `include_once MPDF57/mpdf.php`. Changed `new mPDF()` → `new \Mpdf\Mpdf()`. |
| `application/models/Vendor.model.php` | Same |
| `application/models/RentalBooking.model.php` | Same |
| `application/models/Parkingdataview.model.php` | Same |
| `application/models/Paidparkingview.model.php` | Same |
| `application/models/Booking.model.php` | Same |
| `application/controllers/Foodcoupon.php` | Same |
| `application/controllers/BadgesAssign.php` | Same |

Key compatibility notes for mPDF 8:
- `new \Mpdf\Mpdf()` with no args works (config array is optional, defaults to `[]`)
- `$mpdf->WriteHTML($html)` — unchanged
- `$mpdf->Output($path, 'F')` — string modes ('F', 'I', 'D', 'S') still accepted

**Step 5 — Twilio 6.35.1 → 8.11.1**
- Updated `Twillio/composer.json`: `"twilio/sdk": "^6.35"` → `"^8.0"`, ran `composer update`
- `Twilio\Rest\Client` namespace unchanged — no code changes needed
- `new Client($sid, $token)` and `$client->messages->create()` API unchanged

**Authorize.Net — DEFERRED**
- User decision: defer pending full rewrite
- Existing bundled Authorize.Net SDK still in `application/helpers/`; works on current PHP 7.4 copy but not yet tested on PHP 8.2

### Notes per Library (original)

**PHPMailer 5.2.4 → 6.x** — COMPLETE. Old files remain in `helpers/PHPMailer_5.2.4/` but are no longer loaded by any application code.

**mPDF 5.7 → 8.x** — COMPLETE. Old files remain in `helpers/MPDF57/` but are no longer loaded. Old files still contain PHP 7.4-era curly-brace fixes and each() replacements from Phase 2; they are not loaded.

**Authorize.Net SDK** — DEFERRED. Requires complete integration rewrite of all Authorize.Net payment processing code.

**Twilio SDK 6.35 → 8.11.1** — COMPLETE. Installed in `application/controllers/Twillio/vendor/` (separate Composer install from project root).

---

## Phase 4 — Fix Deprecations (PHP 8.1 / 8.2 Warnings & Breaks)

> **COMPLETE 2026-02-27** — All sub-items resolved.

### 4a. `safe_mode` ini Checks — FIXED

| File | Line(s) | Action |
|---|---|---|
| `application/helpers/PHPMailer_5.2.4/class.phpmailer.php` | 513, 930 | **NO ACTION** — file is no longer loaded (replaced by PHPMailer 6 in Phase 3) |
| `core/libs/kcfinder/core/bootstrap.php` | 30–31 | **FIXED 2026-02-27** — `if (ini_get("safe_mode")) die(...)` replaced with a comment |

---

### 4b. Loose Type Comparison Behavior Change (PHP 8.0) — FIXED

| File | Line | Issue | Action |
|---|---|---|---|
| `core/framework/Object.class.php` | 12 | `$row['max'] == 'NULL'` | **Already fixed in Phase 2** — now `=== null` |
| `core/framework/Controller.class.php` | 105 | `@$_SESSION[...]['is_member'] == 1` | **No change needed** — value is always a numeric string or integer; PHP 8 only changed `0 == "non-numeric-string"` behaviour |

Audit result: all other `==` comparisons in controllers involve numeric session/DB values. No silent logic error risk.

---

### 4c. Passing `null` to Non-nullable Parameters — FIXED

Full audit of core framework files (Model.class.php, BaseQuery.php, Controller.class.php). Findings:

| File | Line | Issue | Fix |
|---|---|---|---|
| `core/framework/Model.class.php` | 339–341 | `if (!empty($column))` block in `getI18n()` referenced `$column` which was never defined in the function — dead code | **FIXED 2026-02-27** — dead block removed |
| `core/framework/Model.class.php` | 344–345 | `$row = $arr[0]` in `getI18n()` with no empty check — Warning if query returns 0 rows | **FIXED 2026-02-27** — early return `array()` if `$arr` is empty |
| `core/framework/Model.class.php` | 454 | `return $arr[0]` in `getbymemberid()` — Warning if no rows | **FIXED 2026-02-27** — `return !empty($arr) ? $arr[0] : null` |
| `core/framework/Model.class.php` | 461 | `return $arr[0]` in `getparking()` — same | **FIXED 2026-02-27** — same pattern |

All other null risks in BaseQuery.php and Controller.class.php were already guarded by `!empty()`, defaults, or type checks.

---

### 4d. `${var}` String Interpolation Syntax (Deprecated in PHP 8.2) — FIXED

| File | Line | Fix |
|---|---|---|
| `application/helpers/stripe/lib/Stripe/SingletonApiResource.php` | 19 | `"/v1/${base}"` → `"/v1/{$base}"` |
| `application/helpers/stripe/lib/Stripe/ApiResource.php` | 56 | `"/v1/${base}s"` → `"/v1/{$base}s"` |

Note: `${...}` occurrences in view files (extra_form.php, ticketedit.php, create.php) are **JavaScript template literals** inside `T_INLINE_HTML` — PHP never processes them. No changes needed there.

---

### 4e. Weak Random Functions — Already resolved

`srand()` / `rand()` used for password generation was replaced with `random_int()` / `random_bytes()` in **Security Phase 7 (2026-02-25)**. Remaining `rand()` calls in application code are for non-security purposes (temp filenames, CAPTCHA visual positioning) and do not require cryptographic strength.

---

### 4f. `strpos()` Loose Comparison Patterns — FIXED

| File | Line | Issue | Fix |
|---|---|---|---|
| `core/framework/CommonQuery.php` | 109 | `strpos(...) \|\|  strpos(...)` — falsy 0 at position 0 | **FIXED 2026-02-27** — `!== false` added to both calls |
| `core/framework/Model.class.php` | 278 | `if (strpos($column, ' '))` | **FIXED 2026-02-27** — `!== false` added |

All strpos() calls in application/controllers/ already used `!== false` correctly.

---

## Phase 5 — Regression Testing

Given the application has no automated test suite, this phase requires thorough manual testing across all major workflows.

### Runtime errors found and fixed (2026-02-27)

| File | Error | Fix |
|---|---|---|
| `application/config/functions.inc.php:580` | **Fatal** `Uncaught mysqli_sql_exception` — PHP 8.1+ `mysqli` throws exceptions by default; `@new mysqli(...)` suppresses warnings but not exceptions | Wrapped in `try { } catch (\mysqli_sql_exception $e) { return null; }` |
| `core/framework/BaseQuery.php:81` | **Deprecated** `getIterator()` return type incompatible with `IteratorAggregate::getIterator(): Traversable` | Added `#[\ReturnTypeWillChange]` attribute |
| `core/framework/SelectQuery.php:121` | **Deprecated** `count()` return type incompatible with `Countable::count(): int` | Added `#[\ReturnTypeWillChange]` attribute |
| `application/controllers/Admin.php:12` | **Deprecated** Creation of dynamic property `Admin::$option_arr` (PHP 8.2 disallows dynamic properties) | Declared `var $option_arr = null;` explicitly in class body |
| `application/controllers/App.php:64` | **Deprecated** `date_default_timezone_set()` passing null; **Notice** timezone ID '' invalid — `option_arr_values['timezone']` key missing when DB unavailable | Guarded with `$tz = ... ?? ''; if ($tz) { date_default_timezone_set($tz); }` |
| `application/controllers/Admin.php:16–18` | Same timezone null issue + `Undefined array key "date_format"` | Same null guard for timezone; `!empty()` guard before `getJsDateFormta()` call |
| `core/framework/I18n.php:35` | **Warning** `Only the first byte will be assigned to the string offset` — when a `type='array'` row in i18n_local shares a key with a prior `type='text'` row, `['value']` is already a string; assigning multi-char string into it via string-offset syntax warns in PHP 8 | Added `!is_array()` guard to re-initialise `['value']` as `[]` before assignment |
| `core/framework/BaseQuery.php` — `clauseNotEmpty()` | **Fatal** `Uncaught PDOException: Unknown system variable 'id'` — root cause: the Phase 2 runtime fix changed `count($this->statements[$clause])` to `is_array(...) ? count(...) : 0`. This made `clauseNotEmpty('UPDATE')` return false for string table names, silently dropping the `UPDATE` keyword. PDO executed `SET \`last_login\`=?, \`id\`=? WHERE id=?` which MariaDB parsed as a variable SET statement and rejected `id` as an unknown system variable | Corrected to `is_array() ? count > 0 : !empty()` — arrays are counted, strings are truthy-checked |
| `core/framework/BaseQuery.php` — `execute()` | **Fatal** unhandled `PDOException` — PHP 8.0 changed PDO default error mode from `ERRMODE_SILENT` (return false) to `ERRMODE_EXCEPTION` (throw). Code expected execute() to return false on error | Wrapped `$result->execute($parameters)` in `try/catch (\PDOException)` to restore PHP 7 return-false behaviour |

| `application/config/constants.php` | `INSTALL_URL` pointed to `http://localhost/` (port 80); all redirects after login sent browser to PHP 7.4 copy | Changed fallback to `http://localhost:8082/` and `INSTALL_PATH` to `C:/xampp82/...` for the 8.2 dev copy |
| `application/controllers/Admin.php:349,354,359,364,377,381,386,494` | **Deprecated** `round(): Passing null to parameter #1` — `SUM()` returns `NULL` (not `0`) when no rows match; PHP 8.1 deprecated passing null to typed parameters | Added `?? 0` null coalesce to all 8 `round($arr[0]['col'])` calls |
| `application/models/Booking.model.php:484` | **Warning** `Undefined array key 0` + `Trying to access array offset on value of type null` — `$slots` is empty for bookings with no slot records; `$slots[0]` undefined | `$slots[0]['location'] ?? null` |
| `application/views/Booking/component/booking_table.php:38` | **Warning** `Undefined array key 0` + **Deprecated** `explode(): Passing null to parameter #2` — `$slot[0]` undefined when booking has no slots, null passed to `explode()` | `explode(" ", $slot[0] ?? '')` |
| `application/controllers/Member.php:13` | **Deprecated** Creation of dynamic property `Member::$option_arr` | Declared `var $option_arr = null;` in class body |
| `application/views/giftshop/component/tab_2_table.php:54` | **Fatal** `TypeError: ksort(): Argument #1 must be of type array, bool given` — same copy-paste pattern as `donationdata/tab_1_table.php` and `vendordata/vendor_table.php` (fixed Phase 2): `strtotime($id)` returns false, `ksort(false)` was a warning in PHP 7 but throws TypeError in PHP 8 | `$dataid = $tpl[...]['id']; $datadesc = $dataid;` |
| `application/views/Student/component/Student_table.php:85` | Same `ksort(false)` Fatal | Same fix |
| `application/views/Eventadmin/component/tab_1_table.php:61` | Same `ksort(false)` Fatal | Same fix |
| `application/views/Eventadmin/component/tickettab_2_table.php:65` | Same `ksort(false)` Fatal | Same fix |
| **26 controllers** (Adminpayment, Adminpaymentstudent, BadgesAssign, Badges, Booking, Calendar, Category, Discount, donationdata, Donations, Event, Eventadmin, Foodcoupon, giftshop, GzInstall, Invoice, Items, MemberLog, RentalBooking, Settings, Statistic, Student, TimePrice, User, vendordata, VendorPayment) | **Deprecated** — dynamic property `$option_arr` in all controllers that call `$this->option_arr = $OptionModel->getAllPairValues()` without declaring the property (PHP 8.2 disallows dynamic properties) | `var $option_arr = null;` inserted after `var $layout` line in all 26 files via `tools/fix-dynamic-option-arr.php` |

| **28 controllers** (Adminpayment, Adminpaymentstudent, BadgesAssign, Badges, Booking, Calendar, Category, Discount, donationdata, Donations, Event, Eventadmin, Foodcoupon, giftshop, GzInstall, Invoice, Items, Member, MemberLog, RentalBooking, Settings, Statistic, Student, TimePrice, User, vendordata, VendorPayment, AppRental) | **Deprecated** `date_default_timezone_set(): Passing null` — `option_arr_values['timezone']` is null when DB is unavailable or settings row missing; PHP 8.1 deprecated passing null to typed string parameters | `$tz = $this->tpl['option_arr_values']['timezone'] ?? ''; if ($tz) { date_default_timezone_set($tz); }` — applied to all 28 files via `tools/fix-timezone-null-guard.php` |

| **`$arr[0]` unguarded after `execute()` — 14 locations** | **Warning** `Undefined array key 0` + `Trying to access array offset on value of type null` — query returns empty array when no rows match; `$arr[0]` is undefined | `?? null` applied to all direct returns/assignments; `if (empty($arr)) { return; }` guard added to methods that echo output (Eventname, ticketeventname) | Files: `ticketeventname.model.php`, `Vendor.model.php`, `Donation.model.php`, `Donationnewview.model.php`, `Foodcoupon.model.php`, `Eventname.model.php` (×4 methods), `Member.model.php` (×5 methods), `Booking.model.php:167`, `Admin.php` (lines 310, 325, 330, 344, 371) |

Note: the `Warning: foreach() argument must be of type array|object, bool given` (App.php:28) and `Warning: Trying to access array offset on value of type bool` (I18n.php:22, App.php:41/47/52) are cascading effects of the DB connection failure — when the DB is available, the underlying queries return arrays and these warnings disappear.

### Runtime errors found and fixed (2026-03-02 — batch 25)

| File | Error | Fix |
|---|---|---|
| `application/models/RentalBookingSlot.model.php:25,51,59` | **Warning** `Undefined array key 0` — `getAllBookingSlotData()`, `getBookingRentalLocation()`, `getLocationRentalBooking()` returned `$arr[0]` / `$arr[0]['location']` without checking for empty result | `?? null` applied to all three returns |
| `application/models/Rentalinvoice.model.php:134` | **Warning** `Undefined array key 0` — `getinvoice()` returned `$arr[0]` unguarded | `return $arr[0] ?? null;` |
| `application/models/vendorinvoice.model.php:49` | **Warning** `Undefined array key 0` — `getAllvendorinvoiceData()` returned `$arr[0]` unguarded | `return $arr[0] ?? null;` |
| `application/controllers/Event.php:178,784,1316` | **Warning** `Undefined array key 0` — `$EventThresholdAmount[0]['amount']` unguarded in all three event actions | `$EventThresholdAmount[0]['amount'] ?? null` in all 3 locations |
| `application/controllers/Event.php:190,793,1324` + `203,206` | **Warning** `Undefined array key 0` — `$result[0]['paymentaccount']` / `$result2[0]` / `$result3[0]` unguarded | `?? null` applied to all |
| `application/controllers/Statistic.php:134,146,160` | **Warning** `Undefined array key 0` — chart loop assigned `$arr[0]` without guard (COUNT queries virtually always return a row, but execute() can return false if PDOException) | `$arr[0] ?? null` applied to all three chart loops |
| `application/controllers/Eventadmin.php:576` | **Warning** `Undefined array key 0` — `$totalAmount[0]` unguarded | `$totalAmount[0] ?? null` |
| `application/controllers/Eventadmin.php:600,653` | **Warning** `foreach` on undefined — `$Event[0]` / `$ticket[0]` used as foreach argument in CSV export header row without empty check | `$Event[0] ?? []` and `$ticket[0] ?? []` |
| `application/controllers/Adminpayment.php:193–202` | **Warning** `Undefined array key 1` / `key 2` — `explode(" ", $spouse)[1]` and `explode(" ", $memberna)[1,2]` undefined when name has fewer parts than expected | `?? ''` applied to `[0]`, `[1]`, `[2]` accesses on both explode results |
| `application/controllers/App.php:1671` | **Deprecated** `Passing null to parameter #2 of mktime()` — `$start_time[1]` / `$end_time[1]` undefined when time string has no colon | `$start_time[1] ?? 0` and `$end_time[1] ?? 0` in for-loop initialiser |
| `application/controllers/AppRental.php:1645` | Same mktime() null issue | Same fix |
| `application/controllers/App.php:1765,1771` | **TypeError** `explode(): Argument #2 must be of type string, null given` — `$option_arr['notify_email']` can be null when settings row is missing | `explode(',', $option_arr['notify_email'] ?? '')` + `$email_arr[0] ?? ''` for From/FromName |
| `application/controllers/AppRental.php:1741,1747` | Same explode null issue | Same fix |
| `application/controllers/App.php:925–927, 1079–1081, 1305–1307` | **TypeError** `PHPMailer::addReplyTo(string)` / typed property `$From` / `$FromName` — `$option_arr['notify_email']` null assigned to PHPMailer string properties | `$option_arr['notify_email'] ?? ''` at all 3 locations (6 lines total) |
| `application/controllers/AppRental.php:634–636, 843–845, 1116–1118, 1277–1279` | Same PHPMailer null issue (4 occurrences) | Same fix — `replace_all` applied |
| `application/controllers/Booking.php:456–458` | Same PHPMailer null issue | Same fix |
| `application/controllers/Invoice.php:237–239` | Same PHPMailer null issue | Same fix |
| `application/controllers/RentalBooking.php:1283–1285, 1438–1440` | Same PHPMailer null issue (2 occurrences) | Same fix — `replace_all` applied |
| `application/controllers/vendordata.php:168` | **Warning** `Undefined array key 0` — `$result[0]['paymentaccount']` unguarded | `?? null` |
| `application/controllers/Student.php:140` | **Warning** `Undefined array key 0` — `$registrationLastnDate[0]['registrationDate']` unguarded | `?? null` |
| `application/controllers/GzFront.php:322` | **Warning** `Undefined array key 0` — `$booked_slots[0]['location']` unguarded (variable is dead code — only used in commented-out lines — but still generates Warning) | `?? null` |
| `application/controllers/GzFront.php:2417,2465` | **Warning** `Undefined array key 0` — `$arr[0]['Confirmation']` unguarded when `$_POST['confirm_code']` has no matching DB row | `?? null` applied to both (`replace_all`) |
| `application/controllers/GzRentalFront.php:1429,1477` | Same confirmation-code lookup pattern | Same fix (`replace_all`) |

**Known remaining warnings (low priority — no Fatals):**
- `Discount.php:133,172,237,279` — `$calendar[0]['user_id']` accessed inside `isEditor()` branch; query is filtered by user_id so empty result is unlikely in normal operation; generates Warning not Fatal.

### Runtime errors found and fixed (2026-03-02 — batch 26)

Triggered by user-reported runtime warnings in `GzFront/getTimeSlot.php` (lines 350, 451, 806). Extended scan to all booking-related views.

| File | Error | Fix |
|---|---|---|
| `application/views/GzFront/getTimeSlot.php:90,143,194,248,299,350,401` | **Warning** `Trying to access array offset on value of type null` — `$tpl['prices']['calendars_price']` where `$tpl['prices']` is null when no location-based price applies | `($tpl['prices']['calendars_price'] ?? 0) != 0` — `replace_all` (7 occurrences) |
| `application/views/GzFront/getTimeSlot.php:451` | **Warning** `Undefined array key "booked_location"` — `if($tpl['booked_location'])` where key is not set by controller | `if(!empty($tpl['booked_location']))` |
| `application/views/GzFront/getTimeSlot.php:806` | **Warning** `Trying to access array offset on value of type null` → **TypeError** `count(null)` — `$_SESSION[product]['slots'][cid]` chain where session slot not initialised | `?? []` applied to innermost access |
| `application/views/GzRentalFront/getTimeSlot.php:57,108,157,209,258,307,356` | Same `$tpl['prices']['calendars_price']` null issue | Same fix — `replace_all` (7 occurrences) |
| `application/views/GzRentalFront/getTimeSlot.php:475` | Same `count($_SESSION[...] ?? [])` fix | Applied |
| `application/views/GzFront/component/extra_form.php:256` | Same `$tpl['prices']['calendars_price']` null issue | Same fix |
| `application/views/GzFront/component/extra_form.php:36,139` | **Warning** `foreach` on null — `foreach ($_SESSION[...]['slots'][cid] as ...)` without null guard | `?? []` applied to both (replace_all) |
| `application/views/GzFront/component/extra_form.php:484` | Same `count($_SESSION[...] ?? [])` fix | Applied |
| `application/views/GzRentalFront/component/extra_form.php:98` | Same `$tpl['prices']['calendars_price']` null issue | Same fix |
| `application/views/GzRentalFront/component/extra_form.php:279` | Same `count($_SESSION[...] ?? [])` fix | Applied |
| `application/views/GzFront/component/booking_details.php:3,112` | **Warning** `foreach` on null — `foreach ($_SESSION[...]['slots'][cid] as ...)` without null guard | `?? []` applied to both (replace_all) |
| `application/views/Booking/getSlotsTable.php:27` | Same `foreach ($_SESSION[...]['admin']['slots'][calendar_id] as ...)` null guard missing | `?? []` applied |
| `application/views/RentalBooking/getSlotsTable.php:27` | Same pattern | `?? []` applied |
| `application/controllers/Calendar.php:224` | **Warning** `Trying to access array offset on value of type null` — `$arr['user_id']` where `$arr` is null when calendar ID not found | `if ($arr && $this->getUserId() != $arr['user_id'])` |
| `application/views/Admin/dashboard.php:89` | **Warning** `count(null)` — `count($tpl['calendars'])` without null guard | `count($tpl['calendars'] ?? [])` |

### Runtime errors found and fixed (2026-03-02 — batch 27)

| File | Error | Fix |
|---|---|---|
| `application/config/functions.inc.php:450` (and 462, 490, ~504) | **Deprecated** `str_replace(): Passing null to parameter #2 ($replace)` — token replacement values in `$replacement` array can be null when an invoice/email field is not filled in | `$v ?? ''` applied to all 4 `str_replace($token, $v, ...)` calls via `replace_all` |
| `application/config/config.php` | **Fatal** `Class "Mpdf\Mpdf" not found` — Composer `vendor/autoload.php` was never required, so the `\Mpdf\Mpdf` namespace class (used in 7 models/controllers for PDF generation) was unavailable | Added `require_once ROOT_PATH . 'vendor/autoload.php';` as first line in `config.php` |

### Runtime errors found and fixed (2026-03-02 — batch 28)

Applied via `fix_working_time.php` CLI script (now deleted).

| File | Error | Fix |
|---|---|---|
| `application/views/GzFront/getTimeSlot.php:190,244,295,346` | **Fatal** `TypeError: mktime(): Argument #1 ($hour) must be of type int, string given` — `$tpl['working_time']['day_*']` fields are null when working hours not configured; `explode(':', null)` returns `['']`; `mktime('', ...)` gets a string instead of int | All 28 `explode(':', $tpl['working_time']['X'])` → `explode(':', $tpl['working_time']['X'] ?? '00:00')` |
| `application/views/GzRentalFront/getTimeSlot.php` | Same `mktime(): string given` Fatal | Same fix — 28 occurrences applied |
| Also: **Deprecated** `explode(): Passing null to parameter #2` at getTimeSlot.php lines 184,185,187,188,238,239,241,242,289,290,292,293,340,341,343,344 (both files) | Root cause same — `working_time` fields null | Resolved by same `?? '00:00'` fix above |

### Runtime errors found and fixed (2026-03-02 — batch 29)

| File | Error | Fix |
|---|---|---|
| `application/views/giftshop/component/tab_2_table.php:87-88` | **Fatal** `Cannot access offset of type string on string` — loop iterates `$tpl['giftmiscarr']` but edit/delete links used `$tpl['active'][$i]['ID']` (wrong array; `$tpl['active']` has different structure) and undefined `$v['ID']` | Replaced both with `$dataid` (already set as `$tpl['giftmiscarr'][$i]['id']` on line 53) |
| `application/views/donationdata/component/tab_1_table.php:103-104` | Same `Cannot access offset of type string on string` Fatal — same copy-paste bug: loop over `$tpl['Donationarr']` but links used `$tpl['active'][$i]['ID']` + `$v['ID']` | Replaced with `$dataid` (= `$tpl['Donationarr'][$i]['id']`) |
| `application/views/Booking/component/priestpujaprice_table.php:53` | **Fatal** `Cannot access offset of type string on string` — `rev="<?php echo $v['id']; ?>"` where `$v` is undefined in loop scope | `$v['id']` → `$tpl['pujapricearr'][$i]['id']` |
| `application/views/RentalBooking/component/booking_1_table.php:38` | Same — `$v['id']` undefined in loop | `$v['id']` → `$tpl['Rentallocationpricearr'][$i]['id']` |
| `application/views/Member/component/gd_member_table.php:63-64` | **Warning** `Undefined array key "id"` (hundreds per page load) — `$tpl['gd'][$i]['id']` where query may not return `'id'` column | `?? ''` applied to all 3 usages on lines 63-64 |
| `application/views/TimePrice/index.php:171` | **Fatal** `Cannot access offset of type string on string` — `$currencies[$currency]['symbol']` where `$currencies` and `$currency` are not initialised in this view scope | Replaced with `Util::getCurrensySimbol($tpl['option_arr_values']['currency'] ?? '')` |
| `application/views/TimePrice/rentalindex.php:151` | Same undefined `$currencies`/`$currency` variables | Same fix |
| `application/views/Admin/dashboard.php:449` | **Warning** `Trying to access array offset on value of type null` — `$tpl['arr'][$i]['date']` where `$tpl['arr']` can be null; `?? 0` only catches the innermost null, not the outer null array access | Changed to `isset($tpl['arr'][$i]['date']) ? $tpl['arr'][$i]['date'] : 0` |
| `C:/xampp82/php/php.ini:935` | **Fatal** `Call to undefined function imap_open()` in `GzFront.php:1660` — IMAP PHP extension disabled by default in XAMPP 8.2 | Uncommented `extension=imap` (restart Apache required) |

### Runtime errors found and fixed (2026-03-02 — batch 30)

Identified from second pass through XAMPP 8.2 Apache error log (`tail -100`).

| File | Error | Fix |
|---|---|---|
| `application/views/GzFront/getTimeSlot.php:487,711` | **Warning** `Undefined variable $price` — `$price` set only inside conditional `if (empty($_POST['location']) && calendars_price != 0)` blocks, leaves `$price` undefined when condition is false | Added `$price = 0;` initialisation before `$date = $_POST['date'];` |
| `application/views/GzRentalFront/getTimeSlot.php` | Same `Undefined variable $price` in rental version | Same fix — `$price = 0;` initialised before the switch/case |
| `application/views/GzFront/component/booking_form.php:222` | **Warning** `Undefined array key "Amount"` + `foreach() null` — `$tpl['Amount']` is null when no payment records exist | `foreach ($tpl['Amount'] ?? [] as ...)` |
| `application/controllers/App.php:979-998` (×2 occurrences) | **Warning** `Undefined array key "male"/"nights"/"date_from"/"date_to"/"extra_price"/"fax"` — columns missing from booking DB query; fires in email token-replacement setup | `?? null` added to all 12 fields in both occurrences (sendBookingConfirmation and sendCancellationEmail paths) |
| `application/controllers/GzFront.php:1091-1093` | **Warning** `Undefined variable $msg` — `$msg` passed to `sendBookingEmailsNew()` before it is assigned (assignment is at line 1098, after the calls) | Added `$msg = '';` initialisation on the line before the first call |
| `application/models/Booking.model.php:290` | **Warning** `Undefined array key "male"` — `$booking['male']` in `generateInvoice()` when booking DB row lacks this optional column | `$booking['male'] ?? null` |
| `application/models/Booking.model.php:310` | **Warning** `Undefined array key "slots"` — `$data['slots'] = $option_arr['slots']` where `$option_arr` is the settings pair array (not booking-specific; has no 'slots' key) | `$option_arr['slots'] ?? null` |
| `application/helpers/stripe/lib/Stripe/Object.php:101,106,111,115` | **Deprecated** Return type of `offsetSet/offsetExists/offsetUnset/offsetGet` not compatible with `ArrayAccess` interface (PHP 8 requires explicit return type declarations or suppress attribute) | Added `#[\ReturnTypeWillChange]` before each of the 4 ArrayAccess methods |
| `application/helpers/stripe/lib/Stripe/ApiRequestor.php:22` | **Deprecated** Creation of dynamic property `Stripe_ApiRequestor::$_apiKey` — constructor assigns `$this->_apiKey` but class only declares `$apiKey` (note: different names) | Declared `private $_apiKey;` in class body |
| `application/views/GzFront/GzABCCss.php` | **Fatal** `Failed to open stream: No such file or directory` — `GzABCCss()` controller method outputs CSS directly via `getCss()` and sets `$this->layout = 'empty'`; bootstrap then `require`s the view file which did not exist | Created empty stub file |
| `application/views/GzFront/checkCodeDD.php` | Same missing view — `checkCodeDD()` echoes directly | Created empty stub file |
| `application/views/GzRentalFront/GzABCCss.php` | Same missing view (rental variant) | Created empty stub file |
| `application/views/GzRentalFront/checkCodeDD.php` | Same missing view (rental variant) | Created empty stub file |
| `application/views/Donations/AllMemberNew.php` | **Fatal** `Failed to open stream` — `AllMemberNew()` echoes member data directly; framework tried to load view that didn't exist | Created empty stub file |
| `C:/xampp82/php/php.ini` ← batch 29 | **Fatal** `imap_open()` — IMAP extension was disabled | Uncommented `extension=imap` (Apache restart required to take effect) |

### Runtime errors found and fixed (2026-03-02 — batch 31)

Identified after fresh Apache restart with cleared error log.

| File | Error | Fix |
|---|---|---|
| `application/controllers/Invoice.php:211` | **Fatal** `Declaration of Invoice::sendEmail() must be compatible with App::sendEmail($Parking, $path)` — PHP 8 made method signature override compatibility strict | Added default params: `function sendEmail($Parking = null, $path = null)` |
| `application/controllers/App.php:41` | **Warning** `Trying to access array offset on value of type bool` — `getLanguage()` returns `false` when no session language set; `$select_language['id']` then accesses `false['id']` | `$language = $select_language ? $LanguagesModel->getAll(...) : [];` |
| `application/controllers/Admin.php:26` | **Warning** `Undefined array key "action"` — `$_REQUEST['action']` accessed 3× with only first suppressed by `@` (which doesn't suppress E_WARNING in PHP 8 anyway) | `$req_action = $_REQUEST['action'] ?? '';` then replaced all 3 usages |
| `application/controllers/GzFront.php:69` | **Warning** `Undefined array key "cid"` + `foreach() null` — `$_GET['cid']` can be missing or a scalar | `foreach ((array)($_GET['cid'] ?? []) as $cid)` |
| `application/controllers/Donations.php:102` (×2) | **Warning** `Undefined array key "memberid"` — `$_POST['memberid']` accessed on GET requests | `$_POST['memberid'] ?? null` (replace_all) |
| `application/controllers/App.php:1408-1448` | **Warning** `Undefined array key "bg_month"` (and 40 others) — calendar styling DB settings not present in XAMPP 8.2 test DB | `?? ''` added to all 41 optional styling key accesses |
| `application/controllers/App.php:1449` | **Warning** `Undefined array key "cid"` — `'#gz-abc-main-container-' . $_GET['cid']` | `$_GET['cid'] ?? ''` |
| `application/views/Donations/index.php` | **Fatal** `Failed opening required` — controller has no `index()` method; framework still tries to load view | Created redirect stub: `<?php Util::redirect(INSTALL_URL . 'Donations/donation'); ?>` |
| `application/views/Event/index.php` | **Fatal** `Failed opening required` — same missing view pattern | Created redirect stub: `<?php Util::redirect(INSTALL_URL . 'Eventadmin/index'); ?>` |
| `application/views/GzFront/index.php:6,91` | **Warning** `Undefined array key "cid"` + `foreach() null` — same `$_GET['cid']` pattern in view | `foreach ((array)($_GET['cid'] ?? []) as $cid)` (replace_all, 2 occurrences) |

### Runtime errors found and fixed (2026-03-02 — batch 32)

Identified from fresh error log after batch 31 fixes were applied.

| File | Error | Fix |
|---|---|---|
| `application/controllers/App.php:1347` | **Warning** `Undefined array key "cid"` — `$cid = $_GET['cid'];` in CSS-generation action with no `?? ''` guard | `$cid = $_GET['cid'] ?? '';` |
| `application/views/vendordata/component/vendor_price_table.php:52` | **Warning** `Undefined variable $v` + `Trying to access array offset on null` — loop iterates `$tpl['vendorpricearr']` but edit link used `$v['id']` (undefined in scope) | `$v['id']` → `$tpl['vendorpricearr'][$i]['id']` |
| `application/views/Booking/component/search.php:11` | **Warning** `Undefined array key "calendars"` + `foreach() null` — `$tpl['calendars']` not set when Booking search form includes this on pages without calendar data | `foreach ($tpl['calendars'] ?? [] as ...)` |
| `application/views/Eventadmin/component/search.php:12` | **Warning** `Undefined array key "calendars"` + `foreach() null` — same as above, inside an HTML comment block but PHP still executes | `foreach ($tpl['calendars'] ?? [] as ...)` |
| `application/views/Eventadmin/component/tab_1_table.php:89` | **Fatal** `Cannot access offset of type string on string` — same copy-paste bug: loop over `$tpl['Eventarr']` but edit/delete links used `$tpl['active'][$i]['ID']` + `$v['ID']` (both wrong) | Replaced all 4 occurrences with `$dataid` (= `$tpl['Eventarr'][$i]['id']` set at line 60) |
| `application/views/GzFront/index.php:99` | **Warning** `Undefined array key "view_month"` — `$_GET['view_month']` echoed directly in JS options object | `$_GET['view_month'] ?? ''` |
| `application/views/Booking/preiestpricecreate.php:88` | **Warning** `Undefined array key "rentalarr"` — `$tpl['rentalarr']['id']` inside an HTML comment block but PHP still executes | `$tpl['rentalarr']['id'] ?? ''` |
| DB: `durgab5_hdbs_payment_prod.items` | **Fatal** `Table 'items' doesn't exist` — `GzRentalFront::beforeFilter()` always calls `ItemsModel->getitems()` which SELECTs from `items` table; table was never created in XAMPP 8.2 DB | Created table from model schema using `CREATE TABLE IF NOT EXISTS items (...)` |

### Runtime errors found and fixed (2026-03-02 — batch 33)

Identified from fresh error log after batch 32 fixes were applied.

| File | Error | Fix |
|---|---|---|
| `application/controllers/AppRental.php:44` | **Warning** `Trying to access array offset on value of type bool` — same pattern as App.php:41; `getLanguage()` returns `false` when no session language, then `$select_language['id']` fails | `$language = $select_language ? $LanguagesModel->getAll(...) : [];` |
| `application/controllers/GzRentalFront.php:86` | **Warning** `Undefined array key "cid"` + `foreach() null` — `foreach ($_GET['cid'] as $cid)` in `beforeRender()` for CSS loading | `foreach ((array)($_GET['cid'] ?? []) as $cid)` |
| `application/controllers/GzRentalFront.php:268` | **Warning** `Undefined array key "cid"` + `foreach() null` — same in `index()` action; also `$_GET['view_month']` undefined on line 273 | `foreach ((array)($_GET['cid'] ?? []) as $cid)` and `$_GET['view_month'] ?? ''` |
| `application/views/GzRentalFront/index.php:6,91` | **Warning** `Undefined array key "cid"` + `foreach() null` — rental version of GzFront/index.php; same two locations | `foreach ((array)($_GET['cid'] ?? []) as $cid)` (replace_all) |
| `application/views/GzRentalFront/index.php:99` | **Warning** `Undefined array key "view_month"` — rental version of same issue | `$_GET['view_month'] ?? ''` |
| `application/views/Donations/donation.php:453` | **Warning** `Undefined array key "Amount"` + `foreach() null` — `foreach ($tpl['Amount'] as ...)` where `$tpl['Amount']` is null when no Zelle payments exist | `foreach ($tpl['Amount'] ?? [] as ...)` |

### Runtime errors found and fixed (2026-03-02 — batch 34)

Identified from extended page sweep (28 pages) after batch 33.

| File | Error | Fix |
|---|---|---|
| `application/views/Layouts/default.php` | **Fatal** `Failed opening required 'Layouts/default.php'` — `Controller` base class defaults `$layout = 'default'`; `AppRental` doesn't override, so bootstrap tries to load missing layout | Created `default.php` layout (mirrors `front.php`: requires `$content_tpl` then outputs CSS links) |
| `application/views/AppRental/index.php` | **Fatal** `Failed to open stream` — `AppRental/index` route resolves but no view existed (AppRental is a base class with no `index()` action) | Created empty stub file |
| `application/views/Member/create.php:42` | **Warning** `Undefined variable $img` — `$decaldb = $img;` where `$img` is never set in create context (only set in edit context) | `$decaldb = $img ?? null;` |
| `application/views/Member/create.php:605` | **Warning** `Undefined array key "Amount"` + `foreach() null` — same Zelle-payment `$tpl['Amount']` null pattern as donation.php and GzFront booking_form.php | `foreach ($tpl['Amount'] ?? [] as ...)` |

### Runtime errors found and fixed (2026-03-02 — batch 35)

Identified from booking form submission testing and Rental calendar testing.

| File | Error | Fix |
|---|---|---|
| `application/views/vendordata/component/vendor_table.php:87` | **Warning** `Undefined array key "uid"` — delete button href used `$tpl['arr'][$i]['uid']` which doesn't exist in vendordata query results | `$tpl['arr'][$i]['uid'] ?? $tpl['arr'][$i]['id']` |
| `application/controllers/AppRental.php` (4 functions) | **Warning** `Undefined array key "male"/"nights"/"date_from"/"date_to"/"fax"/"additional"/"calendar"/"cc_num"/"cc_code"/"cc_exp_month"/"cc_exp_year"` — same missing-column pattern as App.php batch 30 fix, but AppRental's 4 booking email functions had no `?? null` guards | `?? null` added to all 11 fields (replace_all, covers all 4 functions) |
| `application/controllers/Booking.php` | **Warning** same missing-column fields in Booking.php email functions | `?? null` added to all fields (replace_all) |
| `application/controllers/RentalBooking.php` | **Warning** same missing-column fields in RentalBooking.php email functions | `?? null` added to all fields (replace_all) |
| `application/models/Invoice.model.php:84,178` | **Warning** `Undefined array key "male"/"fax"` — `$invoice['male']` and `$invoice['fax']` where invoice DB row lacks these optional columns | `?? null` added (replace_all for both occurrences in each model) |
| `application/models/Invoice.model.php:86,180` | **Warning** `Undefined array key "slots"` — `implode(', ', $booking_details['slots'])` where `slots` key doesn't exist in this path's booking details | `$booking_details['slots'] ?? []` |
| `application/controllers/App.php:1004,1253` | **Warning** same `slots` implode issue in App.php's two sendBookingEmailsNew occurrences | `$booking_details['slots'] ?? []` (replace_all) |
| `application/models/RentalBooking.model.php:187` | **Warning** `Undefined array key "male"` — `$booking['male']` without guard | `$booking['male'] ?? null` |
| `application/models/Rentalinvoice.model.php:85` | **Warning** `Undefined array key "male"` — `$invoice['male']` without guard | `$invoice['male'] ?? null` |
| `application/helpers/ABCalendar/RentalABCalendar.php:318` (and ~10 more calls) | **Fatal** `mktime(): Argument #1 ($hour) must be of type int, string given` — `lunch_start`/`lunch_end` DB fields are empty strings; `explode(':', '')` returns `['']`; then `mktime('', ...)` → Fatal in PHP 8 (int required) | `(int)($launch_start_time[0] ?? 0)` and `(int)($launch_start_time[1] ?? 0)` casts added to all `mktime()` calls involving lunch_start/end times in `getMonthView()` |
| `application/helpers/ABCalendar/RentalABCalendar.php:696` | **Warning** `Trying to access array offset on value of type null` — `$this->custom_dates[$date]['count']` where date key not always in custom_dates array | `$this->custom_dates[$date]['count'] ?? 0` (replace_all, 2 occurrences) |
| `application/helpers/ABCalendar/RentalABCalendar.php:704` (and ~7 more calls in `getCalendarDateClassNew`) | **Fatal** same mktime TypeError — second function using `$date` var instead of `$timestamp` | Same `(int)(... ?? 0)` fix applied to all calls in `getCalendarDateClassNew` |
| `application/helpers/ABCalendar/ABCalendar.php` (multiple calls) | **Fatal/Warning** same mktime issue in the non-rental calendar helper (affects booking calendar) | Same `(int)(... ?? 0)` fix applied to all `getMonthView` mktime calls |
| Apache restart | OPcache serving stale bytecodes after batch 30–34 fixes were applied; `#[\ReturnTypeWillChange]` and `?? null` fixes weren't taking effect | `Stop-Process httpd + Start-Process httpd.exe` to clear OPcache |

### Runtime errors found and fixed (2026-03-06 — batch 36)

Identified from extended Rental calendar testing.

| File | Error | Fix |
|---|---|---|
| `application/helpers/ABCalendar/RentalABCalendar.php` | **Deprecated** — dynamic properties `$monthShortNames`, `$custom_dates`, `$booked_slots` set in constructor without class declaration (PHP 8.2 disallows dynamic properties) | Declared all three as class properties |
| `application/helpers/ABCalendar/RentalABCalendar.php:345,350` | **Warning** `strtolower()/strpos(): Passing null` — `$GetSelectedLocations` can be null when no location selected | `strtolower($GetSelectedLocations ?? '')` and `strpos($GetSelectedLocations ?? '', ',')` |
| `application/controllers/GzRentalFront.php::GetLocationByDate()` | **Fatal** — framework tried to load view file `GetLocationByDate.php` which doesn't exist; function outputs JSON directly | Added `$this->isAjax = true;` before JSON output |
| `application/views/GzRentalFront/component/extra_form.php:47` | **Warning** `Undefined variable $LL` | `$LL ?? 0` |
| `application/views/GzRentalFront/component/extra_form.php:242,246` | **Warning** `Undefined array key` — `$tpl['prices'][...]` where prices null | `?? ''` applied |
| `application/views/GzRentalFront/component/booking_form.php:206` | **Warning** `foreach` on null — `foreach ($tpl['Amount'] as ...)` | `foreach (($tpl['Amount'] ?? []) as ...)` |

### Runtime errors found and fixed (2026-03-06 — batches 37–38)

Identified from view component undefined variable sweep and global model `$_POST` audit.

| File | Error | Fix |
|---|---|---|
| 13 component view files (`Category`, `Student`, `RentalBooking`, `Items`, `Eventadmin`, `Badges` component folders) | **Warning** `Undefined variable $v` — `$v['id']` used in table row href/actions when foreach loop was above and `$v` went out of scope | `$v['id'] ?? ''` applied to all href and action references |
| `Items/component/tab_2_table.php` | **Warning** `Undefined variable $eventnewname[1]` — typo: `$eventnewname` instead of `$eventname` | Fixed to correct variable name |
| `Eventadmin/component/tickettab_2_table.php` | **Warning** wrong `$tpl['active']` array key | Corrected key |
| `application/models/Member.model.php` | **Warning** `Undefined array key` — 7 functions (`AllMember`, `checkduplicate*`, `memberphone`, `Membercheck`) accessed `$_POST[...]` directly | `?? ''` applied to all |
| `application/models/RentalLocationPriceDetails.model.php` | Same `$_POST` pattern — `locationprice()`, `locationprice20June()` | `?? ''` applied |
| `application/models/Eventname.model.php` | Same — `checkdateevent()` | `?? ''` applied |
| `application/models/ltdytdmember.model.php` | Same — `AllMember()` | `?? ''` applied |
| `application/models/vendorprice.model.php` | Same — `paymentfor()` | `?? ''` applied |
| `application/models/Badgesdata.model.php` | Same — `UpdateAssignBadges()` — 28 unguarded `$POST['key']` | `?? ''` applied to all 28 |
| Several controllers (`BadgesAssign`, `GzFront`, `Donations`, `Event`, `Eventadmin`, `App`, `AppRental`, `Admin`) | **Warning** unguarded `$_POST[...]` in various handlers | `?? ''` applied, `replace_all` used where patterns recurred |
| `application/views/Badges/Paidparking.php`, `Student/feeedit.php`, `Student/component/studentfee_table.php` | **Warning** `Undefined array key 1` — `$name[1]` from `explode()` result assumed to have 2 parts | `$name[1] ?? ''` |

### Runtime errors found and fixed (2026-03-06 — batches 39–41)

Identified from receipt screen warnings and global `$_POST` / view `foreach` audit.

| File | Error | Fix |
|---|---|---|
| **26+ controllers** (Admin, Adminpayment, Adminpaymentstudent, App, AppRental, Badges, BadgesAssign, Booking, Calendar, Category, Donations, Event, Eventadmin, Foodcoupon, GzFront, GzRentalFront, Invoice, Items, Member, MemberLog, RentalBooking, Settings, Statistic, Student, TimePrice, User) | **Warning** `Undefined array key` — ~956 unguarded `$_POST[...]` accesses in value assignments, conditionals, and foreach arguments | `?? ''` / `?? []` applied throughout; `replace_all` used where patterns were consistent |
| `application/views/Donations/donation.php:184` | **Warning** `Undefined array key "uid"` — inside HTML comment but still evaluated by PHP | `$tpl['arr']['uid'] ?? ''` |
| `application/views/Eventadmin/component/tab_1_table.php:86` | **Warning** `Undefined array key` — `$status_arr[...]` inside HTML comment | `$status_arr[... ?? ''] ?? ''` |
| `application/views/RentalBooking/component/search.php:11` | **Warning** `foreach` on null — `$tpl['calendars']` | `($tpl['calendars'] ?? [])` |
| **93 view files** (114 individual foreach guards) | **Warning** `foreach` on null — `foreach ($tpl['key'] as ...)` where controller doesn't always set that key | All converted to `foreach (($tpl['key'] ?? []) as ...)` |
| `application/views/Admin/dashboard.php` | **Warning** `today_reservation` / `bookings_this_week` / `$status_arr[status]` undefined keys | `?? 0` and `$status_arr[... ?? ''] ?? ''` applied |
| 4 component views (`tickettab_2_table.php`, `invoice_table.php`, `booking_table.php`, `tab_2_table.php`) | **Warning** `Undefined array key` in `$status_arr[$tpl[...]['status']]` | `$status_arr[$tpl[...]['status'] ?? ''] ?? ''` |
| `application/controllers/App.php:2448` | **Warning** `Undefined variable $Badges` | `if (!empty($Badges) && ...)` guard added |

### Runtime errors found and fixed (2026-03-06 — batch 42)

Identified from comprehensive static sweep of all controllers, models, views, and helper libraries.

| File | Error | Fix |
|---|---|---|
| **20+ controllers** (Adminpayment, AppRental, Badges, BadgesAssign, Booking, Calendar, Category, Eventadmin, Foodcoupon, giftshop, GzFront, GzRentalFront, Invoice, Items, Member, RentalBooking, Student, TimePrice, User, vendordata) | **Warning** `Undefined array key` — 131 unguarded `$_GET[...]` accesses | `$_GET['id'] ?? ''`, `$_GET['ID'] ?? ''`, `$_GET['cid'] ?? []`, `$_GET['view_month'] ?? 1` applied throughout |
| **Views** (`Booking/send.php`, `Calendar/settings.php`, `Calendar/view.php`, `RentalBooking/send.php`, `GzFront/calendar.php` and component equivalents, `GzRentalFront` equivalents) | Same `$_GET` warning in views | Same guards applied |
| `application/controllers/Admin.php:40` | **Warning** `Trying to access array offset on null` — `$member['payment_status']` checked before null check | `if (!$member || $member['payment_status'] ...` |
| `application/models/Studentfee.model.php` | **Warning** unguarded `$_POST['regmember']`, `$_POST['typeregistration']` | `?? ''` applied |
| `application/models/subjectfee.model.php` | Same — `$_POST['regtype']` | `?? ''` applied |
| `application/models/ticketeventday.model.php` | Same — `$_POST['valticket']` | `?? ''` applied |
| `application/models/Vendor.model.php` | Same — 11 unguarded `$_POST[...]` fields | `?? ''` applied to all |
| `application/views/TimePrice/component/custom_time_price_table2.php:74` | **Warning** `Undefined array key 0` — `$slot_lenght[$value['slot_lenght']]` | `?? ''` applied |
| `application/views/MemberLog/component/search.php:34` | **Warning** `Undefined variable $k` / `$v` — foreach was commented out, option tag still referenced loop vars | `$k ?? ''` and `$v ?? ''` applied |
| `application/controllers/Student.php:283` | **Warning** `Undefined array key "id"` — `$_GET['id']` without guard | `$_GET['id'] ?? ''` |
| `application/views/Student/feeedit.php:44` | **Warning** `Undefined array key "lateFee"` — `$tpl['feearr']['lateFee']` | `?? ''` applied |
| `application/helpers/MPDF57/classes/barcode.php` | **Fatal** `Array and string offset access syntax with curly braces is no longer supported` — legacy `$var{n}` syntax throughout | All `$var{n}` → `$var[n]` via PHP preg_replace_callback script |
| `application/helpers/MPDF57/classes/gif.php` | Same fatal — `$lpData{8}` etc. | Same fix |
| `application/helpers/MPDF57/classes/otl.php` | Same fatal — `$dict{$dictptr}` etc. | Same fix |
| `application/helpers/MPDF57/classes/svg.php` | Same fatal curly-brace syntax | Same fix |
| `application/helpers/MPDF57/classes/svg.php:3000` | **Fatal** `break` outside loop/switch — `break` inside `xml_svg2pdf_start()` callback function not inside any loop | Changed to `return` (consistent with all other branches in same function) |
| `application/helpers/PHPMailer_5.2.4/extras/htmlfilter.php` | Same curly-brace fatal (not in production include path but cleaned up for correctness) | Same fix |
| `core/libs/kcfinder/core/class/browser.php` | **Deprecated** `${_GET['file']}` variable interpolation syntax | Changed to `{$_GET['file']}` |

### Runtime errors found and fixed (2026-03-12 — batch 43)

Identified from Member page code review.

| File | Error | Fix |
|---|---|---|
| `application/views/Member/edit.php:37,39` | **Warning** `Undefined array key "Renew_date"/"CreatedOn"` — `strtotime($tpl['arr']['Renew_date'])` called without null guard; also passed to `date()` | `strtotime($tpl['arr']['Renew_date'] ?? '')` and `strtotime($tpl['arr']['CreatedOn'] ?? '')` |
| `application/views/Member/pay.php:30,32` | Same issue — identical `strtotime()` calls without guards | Same fix |
| `application/views/Member/adminedit.php:68,71` | Same issue | Same fix |
| `application/views/Member/checkout.php:34` | **Warning** `Undefined array key "F_Name"/"M_Name"/"L_Name"` — name concatenation without guards | `($tpl['arr']['F_Name'] ?? '')` etc. applied to all three fields |
| `application/controllers/Member.php:2593` | **Warning** `Undefined array key "id"` — `$_REQUEST['id']` without guard | `$_REQUEST['id'] ?? ''` |

**Full static sweep results (2026-03-12):**
- PHP syntax check (`php -l`) on all controllers, models, views, MPDF57 classes, config files — **0 fatal/parse errors**
- Pattern grep across all view directories for unguarded `$tpl['x']['y']`, `$_GET[...]`, `foreach ($tpl[...])` — **0 remaining issues found**
- Pattern grep across all controllers/models for unguarded `$_POST[...]`, `$_GET[...]` — **0 remaining issues found**
- Error log: **clean** (empty)

### Database setup for XAMPP 8.2 — COMPLETE 2026-02-27

XAMPP 8.2 installs its own MariaDB 10.4.32 instance (same port 3306 as XAMPP 7.4). Both cannot run simultaneously.

Steps performed:
1. Stopped XAMPP 8.2 MySQL (`mysqladmin shutdown`)
2. Started XAMPP 7.4 MySQL (`mysqld --standalone`)
3. Dumped `durgab5_hdbs_payment_prod` via `mysqldump` (32 MB, 160 tables, 3215 members, 15175 donations)
4. Stopped XAMPP 7.4 MySQL
5. Started XAMPP 8.2 MySQL
6. Created `durgab5_hdbs_payment_prod` in XAMPP 8.2's MariaDB; imported dump (all 160 tables)
7. Applied `application/config/update_db_11.sql` (creates `login_attempts` table — was never applied to the live database from security Phase 8)

**Note:** XAMPP 8.2's MySQL/MariaDB is now the active MySQL on port 3306. XAMPP 7.4's MySQL is stopped. Keep it that way during PHP 8.2 testing.

### Test Matrix

| Area | What to Test | Status |
|---|---|---|
| **Authentication** | Login/logout for all 14+ user role types | Code review clean |
| **Member Management** | Registration, renewal, edit, search, checkout | Code review clean (batch 43) |
| **Donations** | Stripe payment flow end-to-end | Code review clean — live test pending |
| **Events** | Event creation, ticket purchase, listing | Code review clean — live test pending |
| **Rentals** | Booking creation, calendar, pricing | Code review clean — live test pending |
| **Foodcoupons** | Coupon generation, redemption | Code review clean — live test pending |
| **Badges** | Badge assignment, CSV import | Code review clean — live test pending |
| **Parking** | Slot allocation and management | Code review clean — live test pending |
| **Education** | Fee payment flows | Code review clean — live test pending |
| **Emails** | All transactional emails (confirmation, receipts) | Code review clean — live test pending |
| **PDFs** | All PDF generation points (receipts, reports) | MPDF57 syntax fixed; live test pending |
| **File Uploads** | Image uploads, CSV imports | Code review clean — live test pending |
| **Admin** | Dashboard, reports, user management | Code review clean |

### Testing Approach
1. Test in the dev environment with PHP 8.2 before touching production
2. Step through each user role and verify access control still works
3. Trigger each payment pathway with Stripe test mode enabled
4. Generate a PDF from each PDF-generating action
5. Send a test email from each email-triggering action
6. Review PHP error logs after each test session

---

## Phase 6 — Upgrade XAMPP / PHP Binary

Once all code issues are resolved and tests pass in the dev environment:

1. Download and install XAMPP with **PHP 8.2** (available from [apachefriends.org](https://www.apachefriends.org))
2. Carry over any custom `php.ini` settings — review the diff carefully as some directives were renamed or removed
3. Key `php.ini` changes to review for PHP 8.x:
   - `error_reporting` — update to `E_ALL` for dev, structured logging for prod
   - `display_errors` — should be `Off` in production
   - Removed directives: `magic_quotes_*`, `safe_mode`, `register_globals`
4. Restart Apache and verify the application boots without fatal errors
5. Re-run the full test matrix (Phase 5) after the PHP binary swap

---

## Effort Summary

| Phase | Description | Complexity | Status |
|---|---|---|---|
| Phase 1 | Audit & preparation | Low | **COMPLETE 2026-02-26** |
| Phase 2 | Fix fatal errors (removed functions) | Medium–High | **COMPLETE 2026-02-26** |
| Phase 3 | Upgrade third-party libraries | High | **COMPLETE 2026-02-27** (Authorize.Net deferred) |
| Phase 4 | Fix deprecations | Medium | **COMPLETE 2026-02-27** |
| Phase 5 | Regression testing | High (large surface area) | **IN PROGRESS** — batches 36–43 applied; error log clean; code review sweep complete (0 remaining static issues); live functional testing outstanding |
| Phase 6 | PHP binary upgrade | Low | **COMPLETE** — running on XAMPP 8.2 (PHP 8.2) |

---

## Known Risks

- **mPDF and PHPMailer upgrades** have significant API breaking changes that touch PDF and email generation across many controllers
- **Authorize.Net SDK** will require a full rewrite of its integration code
- **No automated test coverage** means regression testing is entirely manual — risk of undetected breakage is high
- **Loose type comparisons** throughout the codebase may produce silent logic errors under PHP 8.0's changed comparison semantics

---

## Related Documents

- [`codebase-observations.md`](./codebase-observations.md) — Full codebase audit and security observations

---

_End of document._
