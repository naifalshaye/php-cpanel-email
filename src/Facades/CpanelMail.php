<?php
namespace Naif\CpanelMail\Facades;

use Illuminate\Support\Facades\Facade;

class CpanelMail extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'cpanel-mail';
    }
}