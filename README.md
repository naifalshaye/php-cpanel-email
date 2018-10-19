# PHP Laravel cPanel
A php laravel package to manage cPanel email accounts

## Installation
```
composer require naif/php-cpanel-email
```

Add service provider and alias to config/app.php
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

Delete an new email account
```php
$cpanel->delete('email_address')

Response:
[
  "status" => "success"
  "message" => "Email address has been deleted successfully"
]
```

## Support:
naif@naif.io

https://www.linkedin.com/in/naif

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

