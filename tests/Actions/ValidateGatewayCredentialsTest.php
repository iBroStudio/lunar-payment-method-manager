<?php

use IBroStudio\PaymentMethodManager\Actions\ValidateGatewayCredentials;
use IBroStudio\TestSupport\Models\FakePaymentGateway;

it('can validate credentials', function () {
    expect(
        ValidateGatewayCredentials::run(
            credentials: [
                'token' => fake()->uuid,
                'secret' => fake()->uuid,
            ],
            gateway: FakePaymentGateway::factory()->create()
        )
    )->toBeTrue();
});
