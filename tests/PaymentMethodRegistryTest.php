<?php

use IBroStudio\PaymentMethodManager\Data\GatewayRegistryData;
use IBroStudio\PaymentMethodManager\Exceptions\GatewayNotFoundException;
use IBroStudio\PaymentMethodManager\Exceptions\InvalidGatewayException;
use IBroStudio\PaymentMethodManager\Exceptions\InvalidMethodException;
use IBroStudio\PaymentMethodManager\Exceptions\MethodNotFoundException;
use IBroStudio\PaymentMethodManager\Facades\PaymentMethodRegistry;
use IBroStudio\TestSupport\Models\FakePaymentGateway;
use IBroStudio\TestSupport\Models\FakePaymentGateway2;
use IBroStudio\TestSupport\Models\FakePaymentMethod;
use IBroStudio\TestSupport\Models\FakePaymentMethod2;
use Illuminate\Support\Collection;

it('can register', function () {
    expect(
        PaymentMethodRegistry::register(
            gateway: FakePaymentGateway::class,
            methods: [FakePaymentMethod::class]
        )
    )->toBeTrue();
});

it('throws exception if gateway is not found', function () {
    PaymentMethodRegistry::register(
        gateway: 'BadGateway',
        methods: [FakePaymentMethod::class]
    );
})->throws(GatewayNotFoundException::class);

it('throws exception if gateway is not valid', function () {
    PaymentMethodRegistry::register(
        gateway: FakePaymentMethod::class,
        methods: [FakePaymentMethod::class]
    );
})->throws(InvalidGatewayException::class);

it('throws exception if method is not found', function () {
    PaymentMethodRegistry::register(
        gateway: FakePaymentGateway::class,
        methods: ['BadMethod']
    );
})->throws(MethodNotFoundException::class);

it('throws exception if method is not valid', function () {
    PaymentMethodRegistry::register(
        gateway: FakePaymentGateway::class,
        methods: [FakePaymentGateway::class]
    );
})->throws(InvalidMethodException::class);

it('can retrieve one gateway', function () {
    PaymentMethodRegistry::register(
        gateway: FakePaymentGateway::class,
        methods: [FakePaymentMethod::class]
    );

    expect(PaymentMethodRegistry::get('fake-payment-gateway'))
        ->toBeInstanceOf(GatewayRegistryData::class);
});

it('can retrieve all gateways', function () {
    PaymentMethodRegistry::register(
        gateway: FakePaymentGateway::class,
        methods: [FakePaymentMethod::class]
    );
    PaymentMethodRegistry::register(
        gateway: FakePaymentGateway2::class,
        methods: [FakePaymentMethod2::class]
    );

    $gateways = PaymentMethodRegistry::all();

    expect($gateways)
        ->toBeInstanceOf(Collection::class)
        ->and($gateways->count())->toBe(2);
});
