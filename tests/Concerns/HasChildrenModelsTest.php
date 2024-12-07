<?php

use IBroStudio\PaymentMethodManager\Models\Gateway;
use IBroStudio\PaymentMethodManager\Models\Method;
use IBroStudio\TestSupport\Models\FakePaymentGateway;
use IBroStudio\TestSupport\Models\FakePaymentGateway2;
use IBroStudio\TestSupport\Models\FakePaymentMethod;
use IBroStudio\TestSupport\Models\FakePaymentMethod2;

it('can retrieve gateway child model', function () {
    FakePaymentGateway::factory()->create();
    FakePaymentGateway2::factory()->create();

    $gateways = Gateway::all();

    expect($gateways->count())->toBe(2)
        ->and(FakePaymentGateway::all()->count())->toBe(1)
        ->and(FakePaymentGateway2::all()->count())->toBe(1);

    $gateways
        ->each(function (Gateway $gateway) {
            expect($gateway->getChildModel())->toBeInstanceOf($gateway->class);
        });
});

it('can retrieve method child model', function () {
    FakePaymentMethod::factory()->create();
    FakePaymentMethod2::factory()->create();

    $methods = Method::all();

    expect($methods->count())->toBe(2)
        ->and(FakePaymentMethod::all()->count())->toBe(1)
        ->and(FakePaymentMethod2::all()->count())->toBe(1);

    $methods
        ->each(function (Method $method) {
            expect($method->getChildModel())->toBeInstanceOf($method->class);
        });
});
