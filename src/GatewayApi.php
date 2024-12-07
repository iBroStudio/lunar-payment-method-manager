<?php

namespace IBroStudio\PaymentMethodManager;

use IBroStudio\PaymentMethodManager\Contracts\GatewayApiAdapterContract;

class GatewayApi implements GatewayApiAdapterContract
{
    private function __construct(
        private string $driver,
        private GatewayApiAdapterContract $adapter,
    ) {}

    public static function use(
        string $driver,
    ): static {
        return new static(
            driver: $driver,
            adapter: app()->make($driver),
        );
    }

    public function validateCredentials(array $credentials): bool
    {
        return $this->adapter->validateCredentials($credentials);
    }
}
