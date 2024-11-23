<?php

namespace IBroStudio\PaymentMethodManager\Exceptions;

use Exception;

class MethodNotFoundException extends Exception
{
    public function __construct(string $classname)
    {
        return parent::__construct("Payment method {$classname} not found");
    }
}
