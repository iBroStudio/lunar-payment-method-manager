<?php

namespace IBroStudio\PaymentMethodManager\Data;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class GatewayRegistryData extends Data
{
    #[Computed]
    public string $name;

    public function __construct(
        public string $class,
        /** @var Collection<int, MethodRegistryData> */
        public Collection $methods
    ) {
        $this->name = Str::of($this->class)
            ->classBasename()
            ->headline()
            ->toString();
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data[0],
            MethodRegistryData::collect($data[1], Collection::class)
        );
    }
}
