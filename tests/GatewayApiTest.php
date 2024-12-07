<?php

use IBroStudio\PaymentMethodManager\GatewayApi;
use IBroStudio\TestSupport\ApiAdapters\FakePaymentApiAdapter;

it('can instantiate', function () {
    expect(
        GatewayApi::use(FakePaymentApiAdapter::class)
    )->toBeInstanceOf(GatewayApi::class);
});

it('can validate credentials', function () {
    expect(
        GatewayApi::use(FakePaymentApiAdapter::class)
            ->validateCredentials(['token' => fake()->uuid])
    )->toBeTrue();
});
