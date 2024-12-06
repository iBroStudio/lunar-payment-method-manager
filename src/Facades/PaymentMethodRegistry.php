<?php

namespace IBroStudio\PaymentMethodManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IBroStudio\PaymentMethodManager\PaymentMethodRegistry
 */
class PaymentMethodRegistry extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \IBroStudio\PaymentMethodManager\PaymentMethodRegistry::class;
    }
}
