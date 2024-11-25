<?php

namespace IBroStudio\PaymentMethodManager\Data;

use Spatie\LaravelData\Data;

class MethodData extends Data
{
    public function __construct(
        public array $name,
        public string $class,
        public int $gateway_id,
        public string $icon,
        public bool $active = false,
        public array $description = [],
    ) {}
}
