<?php

namespace IBroStudio\PaymentMethodManager\Data;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
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
