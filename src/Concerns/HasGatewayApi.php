<?php

namespace IBroStudio\PaymentMethodManager\Concerns;

use IBroStudio\PaymentMethodManager\Contracts\GatewayApiAdapterContract;

trait HasGatewayApi
{
    public function api(): GatewayApiAdapterContract {}
}
/*
 $method->createIntent($cart, $options)
 $method->intent()->create()
 */
