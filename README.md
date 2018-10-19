# PHP Laravel Cpanel
A php laravel package to manage Cpanel email accounts

## Installation
```
composer require naif/php-cpanel-email
```

Add service provider and alias to config/app.php
```
Under Providers:
\Naif\CpanelMail\CpanelServiceProvider::class,

Under aliases:
'SaudiAddress' => Naif\Saudiaddress\Facades\SaudiAddress::class,
```
## API KEYS
Obtain your National Address API key from https://api.address.gov.sa/

Add these to your .env
```
CPANEL_DOMAIN=your_domain.com
CPANEL_HOST=https://your_domain.com
CPANEL_PORT=2083 // cpanel port Default is: 2083
CPANEL_VERSION=2 // cpanel api current version
CPANEL_USERNAME=your_cpanel_username
CPANEL_PASSWORD=your_cpanel_password
```
## Usage

Create a class object
```php
$cpanel = new Cpanel()
```

Get a list of all email addresses
```
$cpanel->getEmailAddresses()

Response:
array:5 [
  0 => Email {#227 ▼
    +user: "sddfsfsfd"
    +domain: "phototime.com.sa"
    +email: "sddfsfsfd@phototime.com.sa"
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
Create a new email account
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

