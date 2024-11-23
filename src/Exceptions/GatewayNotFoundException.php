<?php

namespace IBroStudio\PaymentMethodManager\Exceptions;

use Exception;

class GatewayNotFoundException extends Exception
{
    public function __construct(string $classname)
    {
        return parent::__construct("Payment gateway {$classname} not found");
    }
}
