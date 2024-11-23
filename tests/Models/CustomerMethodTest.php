<?php

use IBroStudio\PaymentMethodManager\Models\CustomerMethod;
use IBroStudio\PaymentMethodManager\Models\Gateway;
use IBroStudio\PaymentMethodManager\Models\Method;
use IBroStudio\TestSupport\Models\FakePaymentCustomerMethod;
use IBroStudio\TestSupport\Models\FakePaymentCustomerMethod2;
use IBroStudio\TestSupport\Models\FakePaymentGateway;
use IBroStudio\TestSupport\Models\FakePaymentGateway2;
use IBroStudio\TestSupport\Models\FakePaymentMethod;
use IBroStudio\TestSupport\Models\FakePaymentMethod2;
use Lunar\Models\Customer;

use function Pest\Laravel\assertModelExists;

it('can create a customer payment method', function () {
    assertModelExists(
        FakePaymentCustomerMethod::factory()->create()
    );
});

it('can save credentials', function () {
    $data = ['customer_id' => fake()->uuid];
    $gateway = FakePaymentCustomerMethod::factory()
        ->create(['credentials' => $data]);

    expect(
        $gateway->credentials->customer_id->decrypt()
    )->toBe($data['customer_id']);
});

it('belongs to a payment method', function () {
    $customerMethod = FakePaymentCustomerMethod::factory()->create();

    assertModelExists($customerMethod->method);

    expect($customerMethod->method)->toBeInstanceOf(FakePaymentMethod::class);
});

it('belongs to a customer', function () {
    $customerMethod = FakePaymentCustomerMethod::factory()->create();

    assertModelExists($customerMethod->customer);

    expect($customerMethod->customer)->toBeInstanceOf(Customer::class);
});

it('can handle multiple models', function () {
    FakePaymentCustomerMethod::factory(10)->create();
    FakePaymentCustomerMethod2::factory(10)->create();

    expect(Gateway::all()->count())->toBe(20)
        ->and(FakePaymentGateway::all()->count())->toBe(10)
        ->and(FakePaymentGateway2::all()->count())->toBe(10)

        ->and(Method::all()->count())->toBe(20)
        ->and(FakePaymentMethod::all()->count())->toBe(10)
        ->and(FakePaymentMethod2::all()->count())->toBe(10)

        ->and(CustomerMethod::all()->count())->toBe(20)
        ->and(FakePaymentCustomerMethod::all()->count())->toBe(10)
        ->and(FakePaymentCustomerMethod2::all()->count())->toBe(10);
});
