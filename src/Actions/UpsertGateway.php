<?php

namespace IBroStudio\PaymentMethodManager\Actions;

use IBroStudio\PaymentMethodManager\Data\GatewayData;
use IBroStudio\PaymentMethodManager\Data\GatewayRegistryData;
use IBroStudio\PaymentMethodManager\Models\Gateway;
use Lorisleiva\Actions\Concerns\AsAction;

final class UpsertGateway
{
    use AsAction;

    public function handle(
        GatewayData $gatewayData,
        ?Gateway $gateway = null): Gateway
    {
        if (is_null($gateway)) {
            return Gateway::create($gatewayData->toArray());
        }

        $gateway->fill($gatewayData->toArray());

        if ($gateway->isClean()) {
            return $gateway;
        }

        $gateway->save();

        return $gateway->refresh();
    }
}
