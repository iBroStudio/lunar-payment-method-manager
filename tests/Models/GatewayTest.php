<?php

use IBroStudio\TestSupport\Models\FakePaymentGateway;

use function Pest\Laravel\assertModelExists;

it('can create a payment gateway', function () {
    assertModelExists(
        FakePaymentGateway::factory()->create()
    );
});

it('can save credentials', function () {
    $data = [
        'token' => fake()->uuid,
        'secret' => fake()->uuid,
    ];
    $gateway = FakePaymentGateway::factory()
        ->create(['credentials' => $data]);

    expect(
        $gateway->credentials->token->decrypt()
    )->toBe($data['token'])
        ->and(
            $gateway->credentials->secret->decrypt()
        )->toBe($data['secret']);
});
