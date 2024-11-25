<?php

namespace IBroStudio\PaymentMethodManager\Data;

use Spatie\LaravelData\Data;

class GatewayData extends Data
{
    public function __construct(
        public string $name,
        public string $class
    ) {}
}
