<?php

namespace IBroStudio\PaymentMethodManager\Concerns;

use IBroStudio\PaymentMethodManager\Models\PaymentIntent;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Lunar\Models\Cart;

trait MethodHasIntents
{
    public function intents(): HasManyThrough
    {
        return $this->hasManyThrough(PaymentIntent::class, Cart::class);
    }

    public function getIntent(Cart $cart, array $opts = []): PaymentIntent
    {
        $existingId = $this->getCartIntentId($cart);

        if (
            $existingId &&
            $intent = $this->fetchIntent(
                $existingId
            )
        ) {
            return $intent;
        }

        $paymentIntent = $this->buildIntent( // use $this->>api()->
            $cart->total->value,
            $cart->currency->code,
            $opts
        );

        $cart->paymentIntents()->create([
            'intent_id' => $paymentIntent->id,
            'status' => $paymentIntent->status,
        ]);

        return $paymentIntent;
    }
}
