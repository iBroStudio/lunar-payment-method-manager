<?php

namespace IBroStudio\PaymentMethodManager\Contracts;

use IBroStudio\PaymentMethodManager\GatewayApi;

interface GatewayContract
{
    public static function bootHasClassProperty();

    public function api(): GatewayApi;
}
