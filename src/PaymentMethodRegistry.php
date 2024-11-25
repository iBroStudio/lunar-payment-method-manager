<?php

namespace IBroStudio\PaymentMethodManager;

use IBroStudio\PaymentMethodManager\Actions\UpsertGateway;
use IBroStudio\PaymentMethodManager\Actions\UpsertMethod;
use IBroStudio\PaymentMethodManager\Data\GatewayData;
use IBroStudio\PaymentMethodManager\Data\GatewayRegistryData;
use IBroStudio\PaymentMethodManager\Data\MethodData;
use IBroStudio\PaymentMethodManager\Data\MethodRegistryData;
use IBroStudio\PaymentMethodManager\Exceptions\GatewayNotFoundException;
use IBroStudio\PaymentMethodManager\Exceptions\InvalidGatewayException;
use IBroStudio\PaymentMethodManager\Exceptions\InvalidMethodException;
use IBroStudio\PaymentMethodManager\Exceptions\MethodNotFoundException;
use IBroStudio\PaymentMethodManager\Models\Gateway;
use IBroStudio\PaymentMethodManager\Models\Method;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PaymentMethodRegistry
{
    public function __construct(protected ?Collection $registry = null)
    {
        $this->registry = Collection::make();
    }

    public function register(string $gateway, array $methods): bool
    {
        $this->validateGateway($gateway);

        Arr::map($methods, function (string $method) {
            $this->validateMethod($method);
        });

        $data = GatewayRegistryData::from([$gateway, $methods]);

        $this->registry->put(
            key: $data->key,
            value: $data
        );

        return true;
    }

    public function add(string $class, ?string $key = null): bool
    {
        if (! class_exists($class)) {
            throw new GatewayNotFoundException($class);
        }

        if (! is_subclass_of($class, Gateway::class)) {
            throw new InvalidGatewayException($class);
        }

        $this->registry->put(
            key: $key ?: Str::kebab(class_basename($class)),
            value: $class
        );

        return true;
    }

    public function all(): Collection
    {
        return $this->registry;
    }

    public function get(string $gateway_key): ?GatewayRegistryData
    {
        return $this->registry->get($gateway_key);
    }

    public function methods(): Collection
    {
        return $this->registry->map(function (GatewayRegistryData $gateway) {
            return $gateway->methods->flatten();
        })->flatten();
    }

    public function createGatewayAndMethodsModels(string $gateway_key): Gateway
    {
        $registry = $this->registry->get($gateway_key);

        if (is_null($registry)) {
            throw new GatewayNotFoundException($gateway_key);
        }

        $gateway = UpsertGateway::run(
            GatewayData::from($registry->only('name', 'class'))
        );

        $registry->methods->each(function (MethodRegistryData $methodRegistryData) use ($gateway) {
            UpsertMethod::run(
                MethodData::from([
                    'name' => [config('app.locale') => $methodRegistryData->name],
                    'class' => $methodRegistryData->class,
                    'gateway_id' => $gateway->id,
                    'icon' => $methodRegistryData->class::$defaultIcon,
                ])
            );
        });

        return $gateway;
    }

    protected function validateGateway(string $gateway): void
    {
        if (! class_exists($gateway)) {
            throw new GatewayNotFoundException($gateway);
        }

        if (! is_subclass_of($gateway, Gateway::class)) {
            throw new InvalidGatewayException($gateway);
        }
    }

    protected function validateMethod(string $method): void
    {
        if (! class_exists($method)) {
            throw new MethodNotFoundException($method);
        }

        if (! is_subclass_of($method, Method::class)) {
            throw new InvalidMethodException($method);
        }
    }
}
