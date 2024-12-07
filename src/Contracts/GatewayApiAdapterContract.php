<?php

namespace IBroStudio\PaymentMethodManager\Contracts;

interface GatewayApiAdapterContract
{
    public static function validateCredentials(array $credentials): bool;
}
