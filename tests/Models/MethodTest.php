<?php

use IBroStudio\PaymentMethodManager\Models\Method;

use function Pest\Laravel\assertModelExists;

it('can create a payment method', function () {
    assertModelExists(
        Method::factory()->create()
    );
});

it('belongs to a payment gateway', function () {
    $method = Method::factory()->create();

    assertModelExists(
        $method->gateway
    );
});
