<?php

use IBroStudio\PaymentMethodManager\Data\GatewayRegistryData;
use IBroStudio\PaymentMethodManager\Data\MethodRegistryData;
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
use function Pest\Laravel\assertModelExists;

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

    // PaymentMethodRegistry::all()->pluck('name', 'key')->toArray(),
    $gateways = PaymentMethodRegistry::all();

    expect($gateways)
        ->toBeInstanceOf(Collection::class)
        ->and($gateways->count())->toBe(2);
});

it('can retrieve all methods', function () {
    PaymentMethodRegistry::register(
        gateway: FakePaymentGateway::class,
        methods: [FakePaymentMethod::class]
    );
    PaymentMethodRegistry::register(
        gateway: FakePaymentGateway2::class,
        methods: [FakePaymentMethod2::class]
    );

    $methods = PaymentMethodRegistry::methods();
    //    dd($methods->where('key', 'fake-payment-method2')->toArray());
    //  dd($methods->pluck('name', 'key')->toArray());
    expect($methods)
        ->toBeInstanceOf(Collection::class)
        ->and($methods->first())->toBeInstanceOf(MethodRegistryData::class);
});

it('can create gateway model', function () {
    PaymentMethodRegistry::register(
        gateway: FakePaymentGateway::class,
        methods: [FakePaymentMethod::class]
    );

    $gateway = PaymentMethodRegistry::createGatewayAndMethodsModels('fake-payment-gateway');

    assertModelExists($gateway);
    assertModelExists($gateway->methods->first());
});
