<?php

use IBroStudio\PaymentMethodManager\Actions\UpsertCredentials;
use IBroStudio\TestSupport\Models\FakePaymentGateway;

it('can save credentials', function () {
    $data = [
        'token' => fake()->uuid,
        'secret' => fake()->uuid,
    ];
    $gateway = FakePaymentGateway::factory()->create();
    UpsertCredentials::run($data, $gateway);

    expect(
        $gateway->credentials->token->decrypt()
    )->toBe($data['token'])
        ->and(
            $gateway->credentials->secret->decrypt()
        )->toBe($data['secret']);
});
