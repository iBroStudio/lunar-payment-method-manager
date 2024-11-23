<?php

use IBroStudio\TestSupport\Models\FakePaymentCustomerMethod;
use IBroStudio\TestSupport\Models\FakePaymentGateway;
use IBroStudio\TestSupport\Models\FakePaymentMethod;

it('can set the class attribute', function () {
    expect(
        FakePaymentGateway::factory()->create()
            ->class
    )->toBe(FakePaymentGateway::class)
        ->and(
            FakePaymentMethod::factory()->create()
                ->class
        )->toBe(FakePaymentMethod::class)
        ->and(
            FakePaymentCustomerMethod::factory()->create()
                ->class
        )->toBe(FakePaymentCustomerMethod::class);
});
