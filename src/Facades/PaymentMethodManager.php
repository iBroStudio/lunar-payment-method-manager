<?php

namespace IBroStudio\PaymentMethodManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IBroStudio\PaymentMethodManager\PaymentMethodManager
 */
class PaymentMethodManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \IBroStudio\PaymentMethodManager\PaymentMethodManager::class;
    }
}
