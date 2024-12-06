<?php

namespace IBroStudio\PaymentMethodManager\Data;

use IBroStudio\DataRepository\Concerns\ConvertiblesDataProperties;
use IBroStudio\PaymentMethodManager\Contracts\MethodPresenterDataContract;
use Spatie\LaravelData\Data;

abstract class CustomerMethodData extends Data
{
    use ConvertiblesDataProperties;

    abstract public function presenter(): MethodPresenterDataContract;
}
