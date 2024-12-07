<?php

namespace IBroStudio\PaymentMethodManager\Contracts;

interface GatewayApiAdapterContract
{
    public function validateCredentials(array $credentials): bool;
}
