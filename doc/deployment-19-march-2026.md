# Deployment File List — 19 March 2026

Files updated today. Upload all these files to Azure.

> ⚠️ Update `application/config/env.php` with Azure credentials before deploying.

---

## Config / Core

| File |
|------|
| `config.php` |
| `core/bootstrap.php` |
| `core/framework/Model.class.php` |
| `core/framework/BaseQuery.php` |
| `core/framework/I18n.php` |
| `application/config/constants.php` |
| `application/config/functions.inc.php` |
| `application/config/env.php` ← **Update Azure credentials here first** |

---

## Controllers

| File |
|------|
| `application/controllers/Admin.php` |
| `application/controllers/App.php` |
| `application/controllers/Discount.php` |
| `application/controllers/Donations.php` |
| `application/controllers/Eventadmin.php` |
| `application/controllers/GzFront.php` |
| `application/controllers/GzRentalFront.php` |
| `application/controllers/Installer.php` |
| `application/controllers/Member.php` |

---

## Models

| File |
|------|
| `application/models/Donationnewview.model.php` |
| `application/models/Paidparkingview.model.php` |
| `application/models/RentalBooking.model.php` |
| `application/models/Rentalinvoice.model.php` |
| `application/models/Volunteersdata.model.php` |

---

## Views

| File |
|------|
| `application/views/Donations/donation.php` |
| `application/views/Foodcoupon/edit.php` |
| `application/views/GzFront/component/extra_form.php` |
| `application/views/GzFront/getTimeSlot.php` |
| `application/views/Preview/index.php` |
| `application/views/Rental/index.php` |
| `application/views/Student/create.php` |

---

## JavaScript

| File |
|------|
| `application/web/js/GzBadges.js` |
| `application/web/js/GzDonation.js` |
| `application/web/js/GzEvent.js` |
| `application/web/js/GzMember.js` |
| `application/web/js/GzRentalBooking.js` |
| `application/web/js/GzStudent.js` |
| `application/web/js/GzVendorPayment.js` |
| `application/web/js/Gzadminpayment.js` |
| `application/web/js/Rentalload.js` |
| `application/web/js/load.js` |
| `application/web/js/loadRental.js` |

---

## Root Files

| File |
|------|
| `CronJobForGMToGD.php` |
| `ajax-db-search.php` |
| `donationmain.php` |

---

## What Changed (Summary)

| File | Change |
|------|--------|
| `core/framework/Model.class.php` | utf8mb4 charset, Azure SSL, removed ONLY_FULL_GROUP_BY |
| `application/config/functions.inc.php` | utf8mb4, Azure username auto-format, removed ONLY_FULL_GROUP_BY |
| `application/config/constants.php` | Removed getenv() overrides, reads only from env.php |
| `application/config/env.php` | Single config file for all environments |
| `application/controllers/Installer.php` | Raw mysqli_connect → gz_mysqli_connect, utf8mb4 |
| `application/models/Donationnewview.model.php` | Fixed GROUP BY alias, fixed WHERE clause logic |
| All other files | PHP 8.2 migration fixes (warnings, deprecated syntax) |

---

## Deployment Steps

1. Open `application/config/env.php` — fill Azure credentials
2. Upload all files listed above to Azure via FTP or Kudu
3. Azure Portal → App Service → Configuration → PHP version → **8.2**
4. SSH into Azure → run: `chmod -R 775 /home/site/wwwroot/application/web/upload`
