<?php

namespace IBroStudio\PaymentMethodManager\Data;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class GatewayRegistryData extends Data
{
    #[Computed]
    public string $key;

    #[Computed]
    public string $name;

    public function __construct(
        public string $class,
        /** @var Collection<int, MethodRegistryData> */
        public Collection $methods
    ) {
        $this->key = Str::of($this->class)
            ->classBasename()
            ->kebab()
            ->toString();

        $this->name = Str::of($this->class)
            ->classBasename()
            ->headline()
            ->toString();
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data[0],
            MethodRegistryData::collect(
                items: Arr::map($data[1], function (string $method) use ($data) {
                    return ['gateway_class' => $data[0], 'class' => $method];
                }),
                into: Collection::class
            )
        );
    }
}
