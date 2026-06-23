# Priest Module Project Setup

Yeh document project ko GitHub se dusri machine/server par setup karne ke liye hai.

## 1. Required Software

Dusri machine par yeh cheezein installed honi chahiye:

- PHP
- Composer
- MySQL/MariaDB
- Apache/Laragon/XAMPP ya koi PHP web server
- Git

## 2. Project Clone Karo

Jis folder me project rakhna hai, wahan command run karo:

```powershell
git clone https://github.com/varuneice/priestModule.git
cd priestModule
```

Laragon me usually project path aisa ho sakta hai:

```text
C:\laragon\www\priestModule
```

## 3. Root Composer Dependencies Install Karo

Project root folder me yeh command run karo:

```powershell
composer install
```

Isse root ka `vendor` folder banega. Root `composer.json` me PHPMailer, mPDF aur PHPUnit dependencies hain.

## 4. Twilio Dependencies Install Karo

Twilio ke liye alag Composer setup hai. Is folder me jao:

```powershell
cd application\controllers\Twillio
composer install
```

Phir project root me wapas aa sakte ho:

```powershell
cd ..\..\..
```

## 5. env.php File Copy Karo

`application/config/env.php` GitHub par nahi hota, kyunki isme DB aur external service credentials hote hain.

Working machine/server se yeh file manually copy karo:

```text
application/config/env.php
```

New machine par same path me paste karo:

```text
application/config/env.php
```

Is file me mainly yeh settings hoti hain:

```text
DB host, DB name, DB user, DB password
App URL
App path
SMTP/mail credentials
Twilio credentials
Stripe keys
```

Important: `ENV_APP_URL` aur `ENV_APP_PATH` new machine/server ke path ke hisaab se update karo.

Example path:

```text
ENV_APP_PATH = C:/laragon/www/priestModule/
```

Example local URL:

```text
ENV_APP_URL = http://localhost/priestModule/
```

## 6. Database Setup Karo

New MySQL/MariaDB server me database create karo.

Phir old server/local machine se database export karke new server me import karo.

After import, `application/config/env.php` me DB values new database ke hisaab se set honi chahiye:

```text
ENV_DB_HOST
ENV_DB_NAME
ENV_DB_USER
ENV_DB_PASS
```

## 7. Web Server Configure Karo

Apache/Laragon/XAMPP me project ko web root ke andar rakho.

Common local path:

```text
C:\laragon\www\priestModule
```

Browser me open karo:

```text
http://localhost/priestModule/
```

Agar custom virtual host use kar rahe ho, to `ENV_APP_URL` us domain ke according set karo.

## 8. Quick Check

Setup ke baad yeh check karo:

- `vendor` folder root me bana hai
- `application/controllers/Twillio/vendor` folder bana hai
- `application/config/env.php` present hai
- Database imported hai
- `ENV_APP_URL` correct hai
- `ENV_APP_PATH` correct hai
- Apache/PHP server running hai

## 9. Common Problems

### Missing env.php

Error aa sakta hai:

```text
Missing config: application/config/env.php not found
```

Fix:

```text
application/config/env.php file working setup se copy karo.
```

### Composer vendor missing

Fix root folder me:

```powershell
composer install
```

Fix Twilio folder me:

```powershell
cd application\controllers\Twillio
composer install
```

### Database connection failed

Check karo:

- DB server running hai
- DB name correct hai
- DB username/password correct hai
- DB user ko database access permission hai
- Remote DB hai to firewall/SSL setting correct hai

### Wrong links or redirects

Check karo:

```text
ENV_APP_URL
ENV_APP_PATH
```

In dono ko new machine/server ke actual URL aur path ke according update karo.
