<?php

use IBroStudio\TestSupport\Models\FakePaymentMethod;

use function Pest\Laravel\assertModelExists;

it('can create a payment method', function () {
    assertModelExists(
        FakePaymentMethod::factory()->create()
    );
});

it('belongs to a payment gateway', function () {
    assertModelExists(
        FakePaymentMethod::factory()->create()
            ->gateway
    );
});

it('can scope to only active methods', function () {
    FakePaymentMethod::factory(10)->randomActive()->create();
    $methods = FakePaymentMethod::active();

    expect($methods->count())->toBeLessThan(FakePaymentMethod::all()->count());

    $methods->each(function (FakePaymentMethod $method) {
        expect($method->active)->toBeTrue();
    });
});
