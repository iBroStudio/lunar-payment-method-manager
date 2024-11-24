<?php

namespace IBroStudio\PaymentMethodManager\Data;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class GatewayData extends Data
{
    public function __construct(
        public string $name
    ) {}
}
