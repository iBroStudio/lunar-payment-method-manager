<?php

namespace IBroStudio\PaymentMethodManager;

use IBroStudio\PaymentMethodManager\Models\Method;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lunar\Models\Cart;

final class PaymentMethodManager
{
    public function __construct(protected ?Method $method = null)
    {}

    public function getPaymentMethods(Cart $cart): Collection
    {
        return $this->query($cart)->pluck('class', 'id');
    }

    public function getPaymentMethodForms(Cart $cart): Collection
    {
        return $this->getPaymentMethods($cart)
            ->map(function (string $class, int $id) {
               return $class::$paymentForm;
            });
    }

    public function registerPaymentMethod() {}

    public function getPaymentMethodOptions(Cart $cart): array
    {
        $query = $this->query($cart);

        return [
            'options' => Method::radioDeck($query)->options(),
            'descriptions' => Method::radioDeck($query)->descriptions(),
            'icons' => Method::radioDeck($query)->icons(),
        ];
    }

    protected function query(Cart $cart): Builder
    {
        return Method::enabled()
            ->whereCustomerId(null)
            ->orWhere(function (Builder $query) use ($cart) {
                $query->whereCustomerId($cart->customer->id)
                    ->active();
            })
            ->orderBy('customer_id', 'desc');
    }
}
