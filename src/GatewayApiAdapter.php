<?php

namespace IBroStudio\PaymentMethodManager;

use IBroStudio\PaymentMethodManager\Models\Method;

abstract class GatewayApiAdapter
{
    public Method $method { get => $this->method; }

    public function withMethod(Method $method)
    {
        $this->method = $method;
    }
}
