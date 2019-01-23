# PHP Laravel cPanel
A php laravel package to manage cPanel email accounts

- Get a list of all email accounts.
- Create a new email account.
- Delete an email account.
- Change an email account's password.
- Change an email account's disk quota.

## Installation
```
composer require naif/php-cpanel-email
```

If your Laravel below 5.5 you need to add service provider and alias to config/app.php
```
Under Providers:
\Naif\cPanelMail\cPanelServiceProvider::class,

Under aliases:
'cPanel' => \Naif\cPanelMail\Facades\cPanelMail::class,
```

Add these to your .env
```
CPANEL_DOMAIN=your_domain.com
CPANEL_HOST=https://your_domain.com
CPANEL_PORT=2083 // cPanel port Default is: 2083
CPANEL_VERSION=2 // cPanel api current version
CPANEL_USERNAME=your_cpanel_username
CPANEL_PASSWORD=your_cpanel_password
```
## Usage

Create a class object
```php
$cpanel = new cPanel()
```

Get a list of all email addresses
```php
$cpanel->getEmailAddresses()

Response:
array:5 [
  0 => Email {#227 ▼
    +user: "abc"
    +domain: "domain.com"
    +email: "abc@domain.com"
    +_diskused: 0
    +_diskquota: 0
    +humandiskused: "None"
    +humandiskquota: "None"
    +suspended_incoming: 0
    +suspended_login: 0
    +mtime: 1539715896
   }
 ]
```

Create a new email account
```php
$cpanel->create('username','password')

Response:
[
  "status" => "success"
  "message" => "Email address has been added successfully"
]
```

Delete an email account
```php
$cpanel->delete('email_address')

Response:
[
  "status" => "success"
  "message" => "Email address has been deleted successfully"
]
```

Change an email account's password
```php
$cpanel->changePassword('username','password')

Response:
[
  "status" => "success"
  "message" => "Password has been changed successfully"
]
```

Change an email account's disk quota
```php
$cpanel->changeQuota('username',500)//quota as a number or 0 to set it as unlimited

Response:
[
  "status" => "success"
  "message" => "Email disk quota has been changed successfully"
]
```

## Support:
naif@naif.io

https://www.linkedin.com/in/naif

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

