<?php

namespace IBroStudio\PaymentMethodManager;

use IBroStudio\PaymentMethodManager\Data\GatewayRegistryData;
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

    public function get(string $key): ?GatewayRegistryData
    {
        return $this->registry[$key] ?? null;
    }

    public function methods(): Collection
    {
        return $this->registry->map(function (GatewayRegistryData $gateway) {
            return $gateway->methods->flatten();
        })->flatten();
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
