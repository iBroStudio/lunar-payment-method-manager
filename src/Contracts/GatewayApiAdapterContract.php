<?php

namespace IBroStudio\PaymentMethodManager\Contracts;

use IBroStudio\PaymentMethodManager\Models\Method;

interface GatewayApiAdapterContract
{
    public Method $method { get; }

    public static function validateCredentials(array $credentials): bool;
}
