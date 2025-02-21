<?php

namespace IBroStudio\PaymentMethodManager\Facades;

use IBroStudio\PaymentMethodManager\PaymentMethodManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Lunar\Models\Cart;

/**
 * @method static array getPaymentMethods(Cart $cart): Collection
 * @method static array getPaymentMethodForms(Cart $cart): Collection
 * @method static array getPaymentMethodOptions(Cart $cart): array
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
