<?php

use IBroStudio\Billing\Models\Customer;
use IBroStudio\PaymentMethodManager\Enums\PaymentMethodStatesEnum;
use IBroStudio\PaymentMethodManager\Facades\PaymentMethod;
use IBroStudio\TestSupport\Models\FakePaymentMethod;
use IBroStudio\TestSupport\Models\FakePaymentMethod2;
use Lunar\Facades\Payments;
use Lunar\Models\Cart;

use function Pest\Laravel\actingAs;

it('can get methods', function () {
    $user = \IBroStudio\User\Models\User::factory()->create();
    $customer = $user->customers()->create(Customer::factory()->make()->toArray());
    actingAs($user);

    $method1 = FakePaymentMethod::factory()->create();
    $method2 = FakePaymentMethod2::factory()->create();
    $method3 = FakePaymentMethod::factory()
        ->withState(PaymentMethodStatesEnum::ACTIVE)
        ->create([
            'customer_id' => $customer->id,
            'credentials' => [
                'customer_id' => fake()->uuid,
                'number' => fake()->uuid,
                'provider' => 'Mastercard',
                'expires_at' => fake()->dateTime,
            ],
        ]);

    FakePaymentMethod::factory()
        ->withState(PaymentMethodStatesEnum::EXPIRED)
        ->create([
            'customer_id' => $customer->id,
        ]);
    FakePaymentMethod::factory()
        ->withState(PaymentMethodStatesEnum::ACTIVE)
        ->withCustomer()
        ->create();
    FakePaymentMethod::factory()
        ->withState(PaymentMethodStatesEnum::EXPIRED)
        ->withCustomer()
        ->create();

    $cart = Cart::factory()->create(['customer_id' => $customer->id]);

    expect(
        PaymentMethod::getPaymentMethodOptions($cart)
    )->toMatchArray([
        'options' => [
            $method3->getRadioDeckKey() => $method3->getRadioDeckLabel(),
            $method1->getRadioDeckKey() => $method1->getRadioDeckLabel(),
            $method2->getRadioDeckKey() => $method2->getRadioDeckLabel(),
        ],
        'descriptions' => [
            $method3->getRadioDeckKey() => $method3->getRadioDeckDescription(),
            $method1->getRadioDeckKey() => $method1->getRadioDeckDescription(),
            $method2->getRadioDeckKey() => $method2->getRadioDeckDescription(),
        ],
        'icons' => [
            $method3->getRadioDeckKey() => $method3->getRadioDeckIcon(),
            $method1->getRadioDeckKey() => $method1->getRadioDeckIcon(),
            $method2->getRadioDeckKey() => $method2->getRadioDeckIcon(),
        ],
    ]);
});

it('', function () {

    $method = FakePaymentMethod::factory()->create();

    Payments::extend('fake-payment-method', function ($app) use ($method) {
        return $method;
    });

    dd(
        Payments::driver('fake-payment-method')->authorize()
    );
});
