<?php

use IBroStudio\PaymentMethodManager\Models\Method;
use IBroStudio\PaymentMethodManager\Models\PaymentIntent;
use Lunar\Models\Cart;
use Lunar\Models\Order;

use function Pest\Laravel\assertModelExists;

it('can create a payment intent', function () {
    assertModelExists(
        PaymentIntent::factory()->create()
    );
});

it('belongs to a cart', function () {
    $intent = PaymentIntent::factory()->create();

    expect($intent->cart)->toBeInstanceOf(Cart::class);

    expect($intent->cart->paymentIntents->first()->id)->toBe($intent->id);
});

it('belongs to an order', function () {
    $intent = PaymentIntent::factory()->create();

    expect($intent->order)->toBeInstanceOf(Order::class);
});

it('belongs to a payment method', function () {
    $intent = PaymentIntent::factory()->create();

    expect($intent->method)->toBeInstanceOf(Method::class);
});
