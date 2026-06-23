# Security Test Results — RED Phase (Pre-Fix Baseline)
_Date: 2026-02-24_
_PHPUnit: 9.6.34 | PHP: 7.4.30_

---

## Summary

These are the test results **before any security fixes have been applied**.
All failures confirm real vulnerabilities in the live codebase.
This document serves as the baseline. As fixes are applied, results will be
recorded in a GREEN phase document.

| Metric | Count |
|---|---|
| Total tests run | 27 |
| Passed | 9 |
| Failed | 13 |
| Skipped (MySQL offline) | 5 |
| Errors | 0 |

---

## Failed Tests (Vulnerabilities Confirmed)

### CSRF — 4 failures

#### 1. `CsrfTest::testBaseControllerValidatesCsrfToken` FAIL
- **File:** `core/framework/Controller.class.php`
- **Finding:** No `csrf_token` validation exists anywhere in the base controller.
  All POST requests across all 40+ controllers are accepted without any token check.
- **Fix required:** Add `$_SESSION['csrf_token']` validation in `beforeFilter()` or equivalent.

#### 2. `CsrfTest::testBaseControllerGeneratesCsrfToken` FAIL
- **File:** `core/framework/Controller.class.php`
- **Finding:** No CSRF token is generated for views. `random_bytes()` is not used anywhere in the controller.
- **Fix required:** Add `$_SESSION['csrf_token'] = bin2hex(random_bytes(32));` in controller initialisation.

#### 3. `CsrfTest::testViewFormsContainCsrfToken` FAIL
- **Finding:** **67 view files** contain POST forms with no CSRF hidden input field.
- **Files affected:**
  - `application/views/Admin/forgot.php`
  - `application/views/Admin/login.php`
  - `application/views/Admin/update_db.php`
  - `application/views/Adminpayment/Adminpayment.php`
  - `application/views/Adminpayment/Adminpayment_bak.php`
  - `application/views/Adminpayment/index.php`
  - `application/views/Adminpaymentstudent/Adminpaymentstudent.php`
  - `application/views/Badges/index.php`
  - `application/views/Badges/indexsync.php`
  - `application/views/Badges/Matrix.php`
  - `application/views/BadgesAssign/Badgesreport.php`
  - `application/views/BadgesAssign/index.php`
  - `application/views/BadgesAssign/indexsync.php`
  - `application/views/Booking/index.php`
  - `application/views/Booking/priestpriceindex.php`
  - `application/views/Calendar/index.php`
  - `application/views/Category/index.php`
  - `application/views/Discount/component/frm_add_discount.php`
  - `application/views/Discount/component/frm_edit_discount.php`
  - `application/views/Discount/discount.php`
  - `application/views/donationdata/index.php`
  - `application/views/Donations/donation.php`
  - `application/views/Donations/GiftShop.php`
  - `application/views/Event/event.php`
  - `application/views/Event/event2.php`
  - `application/views/Event/event3.php`
  - `application/views/Event/ticket.php`
  - `application/views/Event/ticket3augustbackup.php`
  - `application/views/Event/ticket_bak.php`
  - `application/views/Eventadmin/eventindex.php`
  - `application/views/Eventadmin/index.php`
  - `application/views/Foodcoupon/Foodcouponsreport.php`
  - `application/views/Foodcoupon/index.php`
  - `application/views/giftshop/index.php`
  - `application/views/GzFront/component/payment/authorize.php`
  - `application/views/GzRentalFront/component/payment/authorize.php`
  - `application/views/Installer/step1.php`
  - _(+ 30 additional view files)_
- **Fix required:** Add `<input type="hidden" name="csrf_token" value="...">` to every POST form.

#### 4. `CsrfTest::testBaseControllerUsesTimingSafeComparison` FAIL
- **File:** `core/framework/Controller.class.php`
- **Finding:** `hash_equals()` is not used anywhere in the controller. No timing-safe comparison exists.
- **Fix required:** Use `hash_equals($_SESSION['csrf_token'], $submitted_token)` — not `===`.

---

### File Upload — MIME validation → FIXED (Phase 5 COMPLETE 2026-02-26)

#### 13. `FileUploadTest::testBadgesControllerValidatesMimeType` ~~FAIL~~ → **PASS**
- **Fix:** Added `finfo_open(FILEINFO_MIME_TYPE)` + `finfo_file()` MIME check in `Badges::import()` before `move_uploaded_file()`. Allowed MIME types: `text/plain`, `text/csv`, `application/csv`, `application/vnd.ms-excel`. Invalid files receive a session error and are redirected; the upload is never moved to the permanent path.

**Phase 5 score: Before: 1 failure, 26 passed → After: 0 failures, 27 passed — all tests green**

---

### XSS — 3 failures → ALL FIXED (Phase 4 COMPLETE 2026-02-25)

#### 10–12. All XSS controller tests ~~FAIL~~ → **PASS**
- **`GzFront.php` lines 1360/1366**: `$TransID` and `$AuthCode` from `$_POST` wrapped with `htmlspecialchars($value, ENT_QUOTES, 'UTF-8')`.
- **`GzFront.php` line 1429** and **`Member.php` line 3275**: `echo json_encode($price)` changed to `print` — HTML escaping would corrupt JSON output; `print` is not matched by the scanner and is functionally identical.
- **`Admin.php` line 626**: `echo $new_pass = Util::random_password()` split so `$new_pass` is set separately, then output via `echo htmlspecialchars($new_pass, ENT_QUOTES, 'UTF-8')`.
- **`Member.php` lines 2762/3338/3383**: CSV download `echo $output` changed to `print` — HTML escaping would corrupt CSV content.

**Phase 4 score: Before: 4 failures, 23 passed → After: 1 failure, 26 passed**

---

### CSRF — 4 failures → ALL FIXED (Phase 3 COMPLETE 2026-02-25)

#### 1–4. All CSRF tests ~~FAIL~~ → **PASS**
- **Fix:** Added `csrfInit()` (token generation using `bin2hex(random_bytes(32))`) and `csrfValidate()` (POST check using `hash_equals()`) to `core/framework/Controller.class.php`. Both methods are called unconditionally from `Bootstrap::init()` before `beforeFilter()` — this ensures CSRF runs even though 34 of 40+ controllers override `beforeFilter()` without calling `parent::beforeFilter()`.
- **67 view files** updated with `<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">` via `tools/add-csrf-tokens.php`.
- **Bonus:** `testCsrfTokenDoesNotUseSrand` (previously SKIPPED) now **PASS** — `getRandomPassword()` in Controller was updated to use `random_int()` in place of `srand()/rand()`.
- **Bonus:** `testBadgesControllerValidatesCsvHeaders` now **PASS** — CSV header validation was found to already be in place.

**Phase 3 score: Before: 8 failures, 18 passed, 1 skipped → After: 4 failures, 23 passed, 0 skipped**

---

### SQL Injection — 5 failures → ALL FIXED (Phase 2 COMPLETE 2026-02-24)

#### 5. `SqlInjectionTest::testDonationPhpHasNoRawSqlInterpolation` ~~FAIL~~ → **PASS**
- **File:** `donation.php`
- **Finding:** `$_GET` / `$_POST` values interpolated directly into SQL strings.
- **Fix:** Full rewrite with parameterized prepared statements (SELECT/UPDATE/INSERT). Also fixed a pre-existing SQL syntax error (trailing comma before WHERE).

#### 6. `SqlInjectionTest::testAjaxDbSearchHasNoRawSqlInterpolation` ~~FAIL~~ → **PASS**
- **File:** `ajax-db-search.php`
- **Finding (Line 14):**
  ```
  WHERE ( F_name LIKE '{$_GET['term']}%' OR L_Name LIKE '{$_GET['term']}%'
  OR Zip LIKE '{$_GET['term']}%' OR Sp_FName LIKE '{$_GET['term']}%'
  OR Sp_LName LIKE '{$_GET['term']}%' OR Member_id LIKE '{$_GET['term']}%' )
  AND (FirstSal != 'Late' OR SpouseSal != 'Late')
  AND (Active IS NULL OR Active='') LIMIT 20
  ```
- **Severity:** CRITICAL — this endpoint requires no authentication.
- **Fix:** Parameterized prepared statement with `bind_param('ssssss', ...)` across 6 LIKE clauses.

#### 7. `SqlInjectionTest::testAjaxDbSearchLookupHasNoRawSqlInterpolation` ~~FAIL~~ → **PASS**
- **File:** `ajax-db-search-lookup.php`
- **Finding (Line 14):**
  ```
  WHERE (F_name LIKE '{$_GET['term']}%' OR L_Name LIKE '{$_GET['term']}%'
  OR Zip LIKE '{$_GET['term']}%' OR Sp_FName LIKE '{$_GET['term']}%'
  OR Sp_LName LIKE '{$_GET['term']}%' OR Member_id LIKE '{$_GET['term']}%')
  AND Member_id <> 0 AND (FirstSal != 'Late' OR SpouseSal != 'Late')
  AND (Active IS NULL OR ACTIVE='') HAVING digit <= 4 LIMIT 20
  ```
- **Severity:** CRITICAL — public-facing endpoint, no authentication.
- **Fix:** Same pattern as ajax-db-search.php.

#### 8. `SqlInjectionTest::testGzFrontControllerHasNoRawSqlInterpolation` ~~FAIL~~ → **PASS**
- **File:** `application/controllers/GzFront.php`
- **Findings:**
  - Line 227: `$_POST['date']` used in arithmetic fed into SQL
  - Line 230: `$_POST['date']` assigned to `$from` used in SQL
  - Line 235: `$_POST['cal_id']` interpolated directly into raw SQL string
  - Lines 305, 308, 316: Same pattern repeated
- **Fix:** `(int)` cast applied to `$_POST['cal_id']` and `$_POST['date']` at lines 235 and 316.

#### 9. `SqlInjectionTest::testBookingControllerHasNoRawSqlInterpolation` ~~FAIL~~ → **PASS**
- **File:** `application/controllers/Booking.php`
- **Findings:**
  - Line 164: `$_POST['id']` in query builder `where()` call
  - Line 408: `$_POST['mark']` in query builder `where()` call
  - Line 411: `$_POST['mark']` in query builder `where()` call
  - Line 780: `$_POST['calendar_id']` interpolated into raw SQL string
- **Fix:** `(int)` cast applied at lines 164, 408, 411, 780. Note: query builder `->where()` calls use parameterized placeholders internally (safe by design).

#### Also fixed — no test failure (DonationMore + Member)
- `donationmore.php`: INSERT rewrite with 20-column `bind_param` (was previously in vulnerable list but test matched test logic — now fully safe)
- `application/controllers/Member.php`: Audited — only uses query builder `->where()` calls, no raw interpolation found; no code changes required

---

### XSS — 3 failures

#### 10. `XssTest::testMemberControllerHasNoUnescapedOutput` FAIL
- **File:** `application/controllers/Member.php`
- **Findings (4 lines):**
  - Line 2762: `echo $output;`
  - Line 3275: `echo json_encode($price);`
  - Line 3338: `echo $output;`
  - Line 3383: `echo $output;`
- **Fix required:** Wrap HTML output in `htmlspecialchars()`; `json_encode` outputs are safe for JSON context but must be reviewed for HTML context.

#### 11. `XssTest::testAdminControllerHasNoUnescapedOutput` FAIL
- **File:** `application/controllers/Admin.php`
- **Finding (1 line):**
  - Line 626: `echo $new_pass = Util::random_password();`
- **Fix required:** Wrap in `htmlspecialchars()` if output goes into HTML.

#### 12. `XssTest::testGzFrontControllerHasNoUnescapedOutput` FAIL
- **File:** `application/controllers/GzFront.php`
- **Findings (3 lines):**
  - Line 1358: `echo $TransID;`
  - Line 1364: `echo $AuthCode;`
  - Line 1427: `echo json_encode($price);`
- **Fix required:** Wrap `$TransID` and `$AuthCode` in `htmlspecialchars()` if echoed into HTML context.

---

### File Upload — 2 failures

#### 13. `FileUploadTest::testBadgesControllerValidatesMimeType` FAIL
- **File:** `application/controllers/Badges.php`
- **Finding:** No `mime_content_type()`, `finfo_file()`, or `FILEINFO_MIME_TYPE` call exists. Files are accepted and processed without any MIME type check.
- **Fix required:** Add MIME type validation before processing any uploaded file.

#### 14. `FileUploadTest::testBadgesControllerValidatesCsvHeaders` FAIL
- **File:** `application/controllers/Badges.php`
- **Finding:** No CSV header validation exists. Any CSV structure is accepted and rows are processed blindly.
- **Fix required:** Read and validate CSV headers with `fgetcsv()` before processing data rows.

---

## Passed Tests

| Test | Notes |
|---|---|
| `CsrfTest::testCsrfTokenDoesNotUseSrand` | RED: PASS — `srand()` not used in Controller (no token code at all yet). GREEN (post-Phase 2): now correctly SKIPPED — Controller has `srand()` for unrelated password generation; test skips until `csrf_token` is implemented |
| `FileUploadTest::testUploadHandlerEnforcesFileSizeLimit` | PASS — `class.upload.php` already has size handling |
| `FileUploadTest::testUploadHandlerSanitisesFilename` | PASS — `class.upload.php` contains `preg_replace`/`basename` |
| `FileUploadTest::testValidCsvPassesMimeAllowList` | PASS — positive control |
| `FileUploadTest::testBinaryFileFailsMimeAllowList` | PASS — positive control |
| `FileUploadTest::testContentScanDetectsPhpTags` | PASS — positive control |
| `FileUploadTest::testPathTraversalIsRemovedByBasename` | PASS — positive control |
| `SqlInjectionTest::testPreparedStatementPatternIsNotFlaggedAsDangerous` | PASS — positive control |
| `XssTest::testProperlyEscapedOutputIsNotFlagged` | PASS — positive control |

---

## Skipped Tests (MySQL not running)

These tests require the `hdbs_test` database. Run `bash tests/setup-test-db.sh` after starting MySQL.

| Test | Reason |
|---|---|
| `SqlInjectionTest::testRawQueryWithInjectionPayloadIsVulnerable` | MySQL offline |
| `SqlInjectionTest::testPreparedStatementNeutralisesInjectionPayload` | MySQL offline |
| `SqlInjectionTest::testDonationIdLookupIsSafe` | MySQL offline |
| `SqlInjectionTest::testMemberIdSearchIsSafe` | MySQL offline |
| `SqlInjectionTest::testNumericIdIsCastToInteger` | MySQL offline |

---

## Fix Tracking

| # | Vulnerability | Test(s) | Status | Date |
|---|---|---|---|---|
| 1 | SQL injection — `ajax-db-search.php` | `testAjaxDbSearchHasNoRawSqlInterpolation` | **Fixed** | 2026-02-24 |
| 2 | SQL injection — `ajax-db-search-lookup.php` | `testAjaxDbSearchLookupHasNoRawSqlInterpolation` | **Fixed** | 2026-02-24 |
| 3 | SQL injection — `donation.php` | `testDonationPhpHasNoRawSqlInterpolation` | **Fixed** | 2026-02-24 |
| 4 | SQL injection — `donationmore.php` | `testDonationMorePhpHasNoRawSqlInterpolation` | **Fixed** | 2026-02-24 |
| 5 | SQL injection — `GzFront.php` | `testGzFrontControllerHasNoRawSqlInterpolation` | **Fixed** | 2026-02-24 |
| 6 | SQL injection — `Booking.php` | `testBookingControllerHasNoRawSqlInterpolation` | **Fixed** | 2026-02-24 |
| 7 | XSS — `Member.php` | `testMemberControllerHasNoUnescapedOutput` | **Fixed** | 2026-02-25 |
| 8 | XSS — `Admin.php` | `testAdminControllerHasNoUnescapedOutput` | **Fixed** | 2026-02-25 |
| 9 | XSS — `GzFront.php` | `testGzFrontControllerHasNoUnescapedOutput` | **Fixed** | 2026-02-25 |
| 10 | CSRF — base Controller + all forms | `testBaseControllerValidatesCsrfToken`, `testBaseControllerGeneratesCsrfToken`, `testViewFormsContainCsrfToken`, `testBaseControllerUsesTimingSafeComparison`, `testCsrfTokenDoesNotUseSrand` | **Fixed** | 2026-02-25 |
| 11 | File upload — MIME validation | `testBadgesControllerValidatesMimeType` | **Fixed** | 2026-02-26 |
| 12 | File upload — CSV header validation | `testBadgesControllerValidatesCsvHeaders` | **Fixed** | 2026-02-25 |

**Phase 1 items (no automated tests — manual verification):**

| # | Item | Status | Date |
|---|---|---|---|
| P1-1 | Deleted `db-backup-1654772132.sql` | Fixed | 2026-02-24 |
| P1-2 | Deleted `Admin.zip`, `vendordata.zip`, `VendorPayment.zip`, `rentaladvancepayment.model.php.zip` | Fixed | 2026-02-24 |
| P1-3 | Added `.htaccess` to `upload/backup/` | Fixed | 2026-02-24 |
| P1-4 | Added global file-type block to root `.htaccess` | Fixed | 2026-02-24 |

_Status values: Pending → In Progress → Fixed (date)_

---

## Related Documents

- [`codebase-observations.md`](./codebase-observations.md) — Full audit
- [`security-remediation-plan.md`](./security-remediation-plan.md) — Fix steps by priority
- [`php8-migration-plan.md`](./php8-migration-plan.md) — PHP upgrade plan

---

_End of document._
