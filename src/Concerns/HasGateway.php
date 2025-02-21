<?php

namespace IBroStudio\PaymentMethodManager\Concerns;

use IBroStudio\PaymentMethodManager\Contracts\GatewayApiAdapterContract;
use IBroStudio\PaymentMethodManager\GatewayApi;
use IBroStudio\PaymentMethodManager\Models\Gateway;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasGateway
{
    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class, 'gateway_id');
    }

    public function api(): GatewayApi
    {
        return $this->gateway->api()->withMethod($this);
    }
}
