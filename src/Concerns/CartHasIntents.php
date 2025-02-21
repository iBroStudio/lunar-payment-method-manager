<?php

namespace IBroStudio\PaymentMethodManager\Concerns;

use IBroStudio\PaymentMethodManager\Models\Method;
use IBroStudio\PaymentMethodManager\Models\PaymentIntent;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Arr;
use Lunar\Models\Cart;

trait CartHasIntents
{
    public function paymentIntents(): HasMany
    {
        return $this->hasMany(PaymentIntent::class);
    }

    public function paymentIntent(Method $method): PaymentIntent
    {
        /*
        if (Arr::exists($this->meta, 'payment_intent')) {

        }
        */

        $method->api()->createIntent($this);
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
