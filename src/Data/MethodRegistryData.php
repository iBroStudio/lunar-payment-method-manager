<?php

namespace IBroStudio\PaymentMethodManager\Data;

use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class MethodRegistryData extends Data
{
    #[Computed]
    public string $key;

    #[Computed]
    public string $name;

    #[Computed]
    public string $gateway_key;

    public function __construct(
        public string $gateway_class,
        public string $class,
    ) {
        $this->key = Str::of($this->class)
            ->classBasename()
            ->kebab()
            ->toString();

        $this->name = Str::of($this->class)
            ->classBasename()
            ->headline()
            ->toString();

        $this->gateway_key = Str::of($this->gateway_class)
            ->classBasename()
            ->kebab()
            ->toString();
    }
}
