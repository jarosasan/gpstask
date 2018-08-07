<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AddressService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'addressService';
    }
}