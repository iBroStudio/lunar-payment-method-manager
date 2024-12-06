<?php

namespace IBroStudio\PaymentMethodManager\Facades;

use IBroStudio\PaymentMethodManager\PaymentMethodManager;
use Illuminate\Support\Facades\Facade;
use Lunar\Models\Cart;

/**
 * @method static array getPaymentMethodOptions(Cart $cart)
 *
 * @see PaymentMethodManager
 */
class PaymentMethod extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PaymentMethodManager::class;
    }
}
