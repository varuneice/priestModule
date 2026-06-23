# HDBS Payment – Priest Module: Codebase Observations
_Generated: 2026-02-24_

---

## 1. Project Overview

**HDBS Payment (Priest Module)** is a PHP-based Religious Organization Management and Payment System for a Hindu/Durgabari/Brahmin Society. It handles the full lifecycle of member and financial management for the organization.

### Core Functions
- Member registration, renewal, and subscription management
- Donation and payment processing
- Event management and ticketing
- Rental property booking
- Food coupon system
- Badge and volunteer management
- Parking management
- Student education fees
- Fundraising

---

## 2. Current Technical Stack

### Backend
| Component | Details |
|---|---|
| Language | PHP 7.4.30 (procedural & OOP) — **EOL since Nov 2022** |
| Framework | Custom lightweight MVC (not Laravel/Symfony) |
| Database | MySQL via MySQLi + custom Fluent query builder |
| ORM | Custom chainable query builder (SelectQuery, InsertQuery, UpdateQuery, DeleteQuery) |
| Authentication | Session-based (`$_SESSION['admin_user']`, `$_SESSION['front_user']`) |
| Authorization | Role-Based Access Control (RBAC) — 14+ user types |

### Frontend
| Component | Version | Status |
|---|---|---|
| jQuery | 1.9.1 | Outdated |
| Bootstrap | 3 | Outdated |
| TinyMCE | Legacy | Outdated |
| KCFinder | Legacy | File browser |
| jQuery UI | Legacy | — |
| jQuery Validation | Legacy | Form validation |
| Date Range Picker | Legacy | — |

### Third-party Integrations
| Integration | Purpose | Status |
|---|---|---|
| Stripe | Primary payment gateway | Legacy v2 API (deprecated) |
| Authorize.Net | Secondary payment gateway | Present |
| Twilio SDK | SMS/communications | Active |
| PHPMailer | Email sending | v5.2.4 (outdated) |
| mPDF | PDF generation | Active |

### Infrastructure
- **Web Server:** Apache (XAMPP)
- **URL Routing:** `.htaccess` rewrite rules → `index.php`
- **Session Name:** `TimeSlotBookingCalendarPHP`
- **Config:** PHP flat files (`config.php`, `constants.php`)
- **Dependency Management:** Composer (Twilio, mPDF)

### Project Scale
- **Total PHP files:** ~3,067
- **Controllers:** 40+
- **Models:** 64 classes (~6,300 lines)
- **Views:** 354 templates
- **User Roles:** 14+ (Admin, Editor, Volunteer, Events, Rental, Parking Admin, Badges Admin, Foodcoupon Admin, Education, Registration, Vendor, etc.)

---

## 3. Architecture

### Directory Structure
```
priestModule/
├── index.php                    # Main entry point / router
├── config.php                   # Database credentials
├── application/
│   ├── config/                  # Constants, app configuration
│   ├── controllers/             # 40+ PHP controllers
│   ├── models/                  # 64 model classes
│   ├── views/                   # 354 view templates
│   ├── helpers/                 # Payment integrations, utilities
│   └── web/                     # CSS, JS, uploads
├── core/
│   ├── bootstrap.php            # MVC routing engine
│   ├── framework/               # Base Controller, Model, query builder
│   └── libs/                    # jQuery, TinyMCE, KCFinder, Twilio SDK
└── doc/                         # Documentation (this directory)
```

### MVC Pattern
- Controllers dispatch via URL routing
- Views loaded dynamically based on action names
- Template variables passed via `$this->tpl[]`
- Layouts: `admin`, `login`, `default`, `empty`

---

## 4. Security Issues

### Critical
| Issue | Location | Details |
|---|---|---|
| **SQL Injection** | `donation.php`, `ajax-db-search.php`, `GzFront.php`, `Booking.php`, and others | Direct interpolation of `$_GET` / `$_POST` values into SQL strings without sanitization |
| **Public Database Backup** | `application/web/upload/backup/db-backup-1654772132.sql` | 753KB database dump accessible via browser |

### High
| Issue | Details |
|---|---|
| **No CSRF Protection** | POST requests across all forms lack anti-CSRF tokens |
| **XSS (Cross-Site Scripting)** | Unsanitized user data echoed directly into HTML attributes and output |
| **Legacy Stripe.js v2** | Stripe ended support for v2; upgrading to v3 (Stripe.js) is required |
| **No File Upload Validation** | CSV imports and file uploads lack content-type or content validation |

### Medium
| Issue | Details |
|---|---|
| **Hardcoded DB Credentials** | `config.php` stores credentials in plaintext; uses `root` with empty password |
| **Error Reporting Suppressed** | `error_reporting(0)` in `config.php` and `upload.php` hides errors |
| **Backup Files in Production** | `Event3augustbackup.php`, `GzFront_23_may.php`, `Booking.modelbackup.php`, and multiple view backups present in production paths |
| **Hardcoded localhost URLs** | Email templates reference `http://localhost/HDBS_Payment/priestModule/...` |
| **Weak Password Generation** | Uses deprecated `srand()` (weak entropy) for password generation |
| **No Rate Limiting** | No rate limiting on login or payment endpoints |

### Security Posture Summary
| Aspect | Status |
|---|---|
| SQL Injection Prevention | FAIL |
| XSS Protection | FAIL |
| CSRF Protection | FAIL |
| Authentication | PASS (session-based, role checks present) |
| Data Exposure | FAIL (backups public) |
| API Security | FAIL (legacy Stripe, no rate limiting) |
| File Upload Validation | FAIL |
| Error Handling | FAIL (suppressed, no logging) |

---

## 5. Code Quality & Technical Debt

### Code Smells
- **God Controllers:** `Admin.php` and `Member.php` each contain 100+ methods and should be split
- **Inconsistent ORM Usage:** Mix of custom query builder (good) and raw `mysqli_query()` (bad) throughout codebase
- **Backup Files in Production:** Multiple `*backup.php` and `*_23_may.php` style files committed to the active codebase
- **Commented-out Code:** Extensive commented blocks in `donation.php`, `member.php`, etc.
- **No Environment Separation:** No dev/staging/prod config distinction; all environments use same config file
- **End-of-Life PHP Version:** Running PHP 7.4.30 (built Jun 2022), which reached end-of-life on November 28, 2022 and no longer receives security patches. Current stable is PHP 8.3/8.4
- **Outdated Dependencies:** jQuery 1.9.1, Bootstrap 3, PHPMailer 5.2.4 — all well behind current versions
- **No Cache Busting:** CSS/JS assets loaded without versioning
- **Silent Failures:** `@` error suppression operator used in places
- **No Automated Tests:** No unit or integration test suite observed

### What Works Well
- Role-based access control is consistently applied across routes
- Custom query builder uses PDO prepared statements in newer code
- MVC structure is logical and consistently followed
- Stripe and Twilio integrations are present and functional
- Update logging added to `Model.update()` (writes to `/core/framework/logs/db_update_log.txt`)

---

## 6. Recommended Actions

### Immediate (Before Live Payment Processing)
1. Remove or secure all backup files and database dumps from public paths
2. Move `config.php` outside the web root or use environment variables
3. Replace all raw SQL string interpolation with parameterized/prepared statements
4. Add CSRF token validation to all forms
5. Escape all output using `htmlspecialchars()` or equivalent
6. Upgrade Stripe integration from v2 to v3

### Short-term
1. **Upgrade PHP from 7.4 to 8.2+ (LTS)** — requires compatibility audit for deprecated functions between 7.4 → 8.x
2. Upgrade jQuery and Bootstrap to current stable versions
2. Upgrade PHPMailer to v6+
3. Add input validation and sanitization layer
4. Replace `error_reporting(0)` with proper error logging
5. Add rate limiting to login and payment endpoints
6. Remove all `*backup.php` files and use Git for version history
7. Replace hardcoded localhost URLs with config-driven base URLs

### Long-term
1. Consider migration to a maintained framework (Laravel, Symfony)
2. Introduce automated testing (PHPUnit)
3. Implement proper CI/CD and environment-based configuration
4. Database field encryption for sensitive personal and payment data
5. API authentication for any exposed endpoints (JWT or OAuth)
6. Upgrade all outdated frontend and backend dependencies

---

_End of document._
