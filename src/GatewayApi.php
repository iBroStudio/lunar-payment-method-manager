<?php

namespace IBroStudio\PaymentMethodManager;

use IBroStudio\PaymentMethodManager\Contracts\GatewayApiAdapterContract;

class GatewayApi
{
    private function __construct(
        private string $driver,
        private GatewayApiAdapterContract $adapter,
    ) {}

    public static function use(
        string $driver,
        array $parameters = []
    ): static {
        return new static(
            driver: $driver,
            adapter: app()->makeWith($driver, $parameters),
        );
    }
}
