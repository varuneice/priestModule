# PHP 8.4 Migration Plan — HDBS Payment priestModule

**Current Version:** PHP 8.2
**Target Version:** PHP 8.4
**Analysis Date:** 2026-03-30
**Status:** Planning

---

## Executive Summary

Migration from PHP 8.2 → 8.4 is **less complex** than the previous 7.4 → 8.2 migration. The codebase has no instances of the most common PHP 8.4 breaking changes. The main issues are:

- 2 implicitly nullable parameters in core framework files
- E_STRICT constant removed (affects PHPMailer 5.2.4 example files only)
- Outdated bundled libraries (PHPMailer 5.2.4, mPDF 5.7, Stripe v1.x)

---

## PHP 8.4 Key Changes Reference

| Change | Impact |
|---|---|
| Implicitly nullable parameters deprecated → ERROR | Breaking |
| `E_STRICT` constant removed | Breaking |
| `array_find()`, `array_find_key()`, `array_any()`, `array_all()` now built-in | Breaking if custom functions exist |
| `exit`/`die` are now proper functions | Minor |
| `stream_context_set_option()` deprecated | Warning |
| `mysqli_ping()`, `mysqli_kill()`, `mysqli_refresh()` deprecated | Warning |
| `round()` mode constants moved to `RoundingMode` enum | Soft deprecation |
| Property hooks (new feature) | None |
| Asymmetric visibility (new feature) | None |

---

## BREAKING CHANGES — Must Fix Before PHP 8.4

### 1. Implicitly Nullable Parameters

PHP 8.4 turns the PHP 8.3 deprecation into a **fatal error**.
Pattern: `function foo(Type $param = null)` — missing `?` before type.

#### Fix Required

**File:** `core/framework/Model.class.php` — Line 65
```php
// CURRENT (breaks in PHP 8.4)
function __construct(FluentStructure $structure = null)

// FIX
function __construct(?FluentStructure $structure = null)
```

**File:** `core/libs/kcfinder/core/class/uploader.php` — Line 427
```php
// CURRENT (breaks in PHP 8.4)
protected function checkUploadedFile(array $aFile = null)

// FIX
protected function checkUploadedFile(?array $aFile = null)
```

---

### 2. `E_STRICT` Constant Removed

`E_STRICT` was deprecated in PHP 8.0 and is **fully removed in PHP 8.4**.
Affects PHPMailer 5.2.4 example files only (not production code).

**Files affected** (example files, not loaded in production):
- `application/helpers/PHPMailer_5.2.4/examples/test_smtp_gmail_basic.php` line 10
- `application/helpers/PHPMailer_5.2.4/examples/test_smtp_basic_no_auth.php` line 10
- `application/helpers/PHPMailer_5.2.4/examples/test_smtp_basic.php` line 10
- `application/helpers/PHPMailer_5.2.4/examples/test_db_smtp_basic.php` line 10

```php
// CURRENT (fatal error in PHP 8.4)
error_reporting(E_STRICT);

// FIX
error_reporting(E_ALL);
// OR remove the line entirely
```

---

### 3. New Built-in Functions — Name Conflict Check

PHP 8.4 adds these as built-in functions:
- `array_find()`
- `array_find_key()`
- `array_any()`
- `array_all()`

**Status: NO CONFLICT FOUND** — codebase does not define any custom functions with these names. ✓

---

## DEPRECATIONS — Fix to Avoid Warnings

### 4. `stream_context_set_option()` Deprecated

Replaced by `stream_context_set_options()` (plural).

**Status: NOT FOUND in codebase.** ✓

### 5. `mysqli_ping()`, `mysqli_kill()`, `mysqli_refresh()` Deprecated

**Status: NOT FOUND in codebase.** ✓

### 6. `html_entity_decode()` Encoding Parameter

PHP 8.4 may change default encoding behavior.

**File:** `application/helpers/MPDF57/Tag.php` — Line 4499
```php
// CURRENT — missing encoding parameter
$char = html_entity_decode($attr['CHAR']);

// RECOMMENDED — explicit encoding
$char = html_entity_decode($attr['CHAR'], ENT_QUOTES, 'UTF-8');
```

---

## VENDOR LIBRARY ISSUES

### 7. PHPMailer 5.2.4 — CRITICAL (Upgrade Recommended)

| Item | Detail |
|---|---|
| **Bundled version** | 5.2.4 (released 2012, abandoned) |
| **Location** | `application/helpers/PHPMailer_5.2.4/` |
| **composer.json requires** | `phpmailer/phpmailer: ^6.0` |
| **Mismatch** | composer.json says 6.x but bundled code is 5.2.4 |

**Issues:**
- Uses `E_STRICT` in example files (see item 2 above)
- Old-style PHP not optimized for PHP 8.x
- `class.phpmailer.php` uses legacy patterns

**Action:** Upgrade to PHPMailer 6.x
PHPMailer 6.x is a drop-in upgrade but requires namespace change:
```php
// OLD (v5.x)
$mail = new PHPMailer();

// NEW (v6.x)
use PHPMailer\PHPMailer\PHPMailer;
$mail = new PHPMailer();
```

---

### 8. mPDF 5.7 — Upgrade Recommended

| Item | Detail |
|---|---|
| **Bundled version** | 5.7 (released 2015) |
| **Location** | `application/helpers/MPDF57/` |
| **composer.json requires** | `mpdf/mpdf: ^8.0` |
| **Mismatch** | composer.json says 8.x but bundled code is 5.7 |

**mPDF 8.x supports PHP 8.4** (confirmed in their composer.json).

**Action:** Migrate code to use mPDF 8.x from `vendor/mpdf/mpdf/`
Usage change:
```php
// OLD (v5.7)
$mpdf = new mPDF();

// NEW (v8.x)
$mpdf = new \Mpdf\Mpdf();
```

---

### 9. Stripe SDK — Outdated Bundled Version

| Item | Detail |
|---|---|
| **Bundled version** | v1.x (~2013) |
| **Location** | `application/helpers/stripe/lib/` |
| **Status** | Not in composer.json, manually bundled |

**Issues:**
- Very old API patterns
- Uses `get_class()` without arguments inside methods — safe in PHP 8.4 ✓
- Untyped parameters — no type errors in PHP 8.4 (untyped = no enforcement) ✓

**Action:** Consider upgrading to Stripe PHP SDK v12.x (current as of 2026)

---

### 10. Twilio SDK — Compatible

| Item | Detail |
|---|---|
| **Version** | 8.x |
| **Location** | `application/controllers/Twillio/vendor/twilio/sdk/` |
| **PHP 8.4 support** | Compatible |

**Status: No action required.** ✓
Uses `$this->$method()` dynamic method calls (30+ locations) — valid in PHP 8.4.

---

## NOT FOUND IN CODEBASE (confirmed safe)

| PHP 8.4 Change | Status |
|---|---|
| `array_find/any/all` custom function conflicts | ✓ Not found |
| `mysqli_ping/kill/refresh` usage | ✓ Not found |
| `stream_context_set_option()` usage | ✓ Not found |
| `PDO::FETCH_SERIALIZE` usage | ✓ Not found |
| `each()` function (removed PHP 8.0) | ✓ Not found |
| `curl_multi_select()` usage | ✓ Not found |
| Dynamic `exit()`/`die()` calls | ✓ Not found |
| `ReflectionProperty` usage | ✓ Not found |
| Indirect variable access issues | ✓ Already fixed in 8.2 migration |

---

## Migration Checklist

### Phase 1 — Core Fixes (2 files, ~10 min)
- [ ] `core/framework/Model.class.php:65` — add `?` to `FluentStructure` parameter
- [ ] `core/libs/kcfinder/core/class/uploader.php:427` — add `?` to `array` parameter

### Phase 2 — PHPMailer Examples (4 files, ~5 min)
- [ ] Replace `error_reporting(E_STRICT)` in 4 example files under `PHPMailer_5.2.4/examples/`

### Phase 3 — Encoding Fix (1 file, ~5 min)
- [ ] `application/helpers/MPDF57/Tag.php:4499` — add explicit encoding to `html_entity_decode()`

### Phase 4 — Library Upgrades (Major effort, separate sprint)
- [ ] Upgrade PHPMailer 5.2.4 → 6.x (requires namespace changes in all controllers)
- [ ] Migrate mPDF 5.7 → 8.x (requires class instantiation changes)
- [ ] Evaluate Stripe SDK upgrade path

### Phase 5 — Testing
- [ ] Install PHP 8.4 on local XAMPP
- [ ] Run PHP syntax check: `php -l` on all files
- [ ] Test booking flow end to end
- [ ] Test PDF generation (mPDF)
- [ ] Test email sending (PHPMailer)
- [ ] Test SMS sending (Twilio)
- [ ] Test payment processing (Stripe)
- [ ] Check Apache error log for new deprecation warnings

---

## Effort Estimate

| Phase | Files | Effort |
|---|---|---|
| Phase 1 — Core fixes | 2 | ~10 min |
| Phase 2 — E_STRICT | 4 | ~5 min |
| Phase 3 — Encoding | 1 | ~5 min |
| Phase 4 — Library upgrades | Many | 2–3 days |
| Phase 5 — Testing | All | 1 day |
| **Total (without Phase 4)** | **7** | **~20 min** |
| **Total (with Phase 4)** | Many | **3–4 days** |

---

## Comparison: 8.2 vs 8.4 Migration Complexity

| Migration | Issues Found | Effort |
|---|---|---|
| PHP 7.4 → 8.2 | 1000+ (batch fixes across 43 batches) | Weeks |
| PHP 8.2 → 8.4 | ~7 core issues + library upgrades | Days |

The 8.2 → 8.4 migration is **significantly simpler** because most breaking changes were already addressed in the 7.4 → 8.2 migration.
