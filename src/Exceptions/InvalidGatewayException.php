<?php

namespace IBroStudio\PaymentMethodManager\Exceptions;

use Exception;

class InvalidGatewayException extends Exception
{
    public function __construct(string $classname)
    {
        return parent::__construct("{$classname} is not a valid payment Gateway class");
    }
}
