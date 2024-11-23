<?php

namespace IBroStudio\PaymentMethodManager\Data;

use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class MethodRegistryData extends Data
{
    #[Computed]
    public string $name;

    public function __construct(
        public string $class,
    ) {
        $this->name = Str::of($this->class)
            ->classBasename()
            ->headline()
            ->toString();
    }

    public static function fromString(string $class): self
    {
        return new self($class);
    }
}
