<?php

use IBroStudio\PaymentMethodManager\Models\CustomerMethod;
use IBroStudio\PaymentMethodManager\Models\Method;
use Lunar\Models\Customer;

use function Pest\Laravel\assertModelExists;

it('can create a customer payment method', function () {
    assertModelExists(
        CustomerMethod::factory()->create()
    );
});

it('belongs to a payment method', function () {
    $customerMethod = CustomerMethod::factory()->create();

    assertModelExists($customerMethod->method);

    expect($customerMethod->method)->toBeInstanceOf(Method::class);
});

it('belongs to a customer', function () {
    $customerMethod = CustomerMethod::factory()->create();

    assertModelExists($customerMethod->customer);

    expect($customerMethod->customer)->toBeInstanceOf(Customer::class);
});
