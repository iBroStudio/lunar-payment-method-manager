<?php

namespace IBroStudio\PaymentMethodManager;

use IBroStudio\PaymentMethodManager\Models\Method;
use Illuminate\Database\Eloquent\Builder;
use Lunar\Models\Cart;

class PaymentMethodManager
{
    public function getPaymentMethods()
    {
        return $methods = Method::all();
    }

    public function registerPaymentMethod() {}

    public function getPaymentMethodOptions(Cart $cart): array
    {
        $query = Method::enabled()
            ->whereCustomerId(null)
            ->orWhere(function (Builder $query) use ($cart) {
                $query->whereCustomerId($cart->customer->id)
                    ->active();
            })
            ->orderBy('customer_id', 'desc');

        return [
            'options' => Method::radioDeck($query)->options(),
            'descriptions' => Method::radioDeck($query)->descriptions(),
            'icons' => Method::radioDeck()->icons($query),
        ];
    }
}
