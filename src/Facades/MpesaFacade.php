<?php

namespace Agessah\Mpesa\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class MpesaFacade
 * @package Agessah\Mpesa\Facade
 */
class MpesaFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Mpesa';
    }
}
