<?php

use IBroStudio\PaymentMethodManager\Enums\PaymentMethodStatesEnum;
use IBroStudio\PaymentMethodManager\Models\Method;
use IBroStudio\TestSupport\Models\FakePaymentMethod;
use Lunar\Models\Customer;

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

it('can save credentials', function () {
    $data = [
        'customer_id' => fake()->uuid,
        'number' => fake()->uuid,
        'provider' => 'Mastercard',
        'expires_at' => fake()->dateTime,
    ];

    $gateway = FakePaymentMethod::factory()
        ->create(['credentials' => $data]);

    expect(
        $gateway->credentials->customer_id->decrypt()
    )->toBe($data['customer_id']);
});

it('can belong to a customer', function () {
    $customerMethod = FakePaymentMethod::factory()->withCustomer()->create();

    assertModelExists($customerMethod->customer);

    expect($customerMethod->customer)->toBeInstanceOf(Customer::class);
});

it('can scope enabled methods', function () {
    FakePaymentMethod::factory(10)->randomEnabled()->create();
    $methods = FakePaymentMethod::enabled();

    expect($methods->count())->toBeLessThan(FakePaymentMethod::all()->count());

    $methods->each(function (FakePaymentMethod $method) {
        expect($method->enabled)->toBeTrue();
    });
});

it('can create customer payment methods', function () {
    $customer = Customer::factory()->create();
    $customer->paymentMethods()->create(
        FakePaymentMethod::factory()->make()->toArray()
    );

    expect($customer->paymentMethods->count())->toBe(1)
        ->and($customer->paymentMethods->first())->toBeInstanceOf(Method::class);
});

it('can scope customer active payment methods', function () {
    $customer = Customer::factory()->create();
    $customer->paymentMethods()->create(
        FakePaymentMethod::factory()
            ->withState(PaymentMethodStatesEnum::ACTIVE)
            ->make()
            ->toArray()
    );
    $customer->paymentMethods()->create(
        FakePaymentMethod::factory()
            ->withState(PaymentMethodStatesEnum::EXPIRED)
            ->make()
            ->toArray()
    );

    expect($customer->paymentMethods->count())->toBe(2)
        ->and($customer->activePaymentMethods->count())->toBe(1)
        ->and($customer->activePaymentMethods->first()->state)->toBe(PaymentMethodStatesEnum::ACTIVE);
});
