<?php

use IBroStudio\Billing\Data\CustomerData;
use IBroStudio\PaymentMethodManager\Models\Gateway;

use function Pest\Laravel\assertModelExists;

it('can create a payment gateway', function () {
    assertModelExists(
        Gateway::factory()->create()
    );
});

it('can have credentials', function () {
    $gateway = Gateway::factory()->create();

    $gateway->credentials = \IBroStudio\TestSupport\Data\FakeData::from([
        'name' => fake()->word,
        'description' => fake()->sentence,
    ]);

    $gateway->save();

    dd($gateway->credentials);
});

it('can have different credentials', function () {
    Gateway::factory(count: 2)->create();

    $gateway1 = Gateway::find(1);
    $gateway1->credentials = \IBroStudio\TestSupport\Data\FakeData::from([
        'name' => fake()->word,
        'description' => fake()->sentence,
    ]);
    $gateway1->save();

    $gateway2 = Gateway::find(2);
    $gateway2->credentials = CustomerData::from(\IBroStudio\Billing\Models\Customer::factory()->make());
    $gateway2->save();

    dd($gateway1->credentials, $gateway2->credentials);
});
