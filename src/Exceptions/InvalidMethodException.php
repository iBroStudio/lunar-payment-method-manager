<?php

namespace IBroStudio\PaymentMethodManager\Exceptions;

use Exception;

class InvalidMethodException extends Exception
{
    public function __construct(string $classname)
    {
        return parent::__construct("{$classname} is not a valid payment Method class");
    }
}
