<?php

namespace IBroStudio\PaymentMethodManager\Actions;

use IBroStudio\PaymentMethodManager\Data\GatewayData;
use IBroStudio\PaymentMethodManager\Data\GatewayRegistryData;
use IBroStudio\PaymentMethodManager\Data\MethodData;
use IBroStudio\PaymentMethodManager\Models\Gateway;
use IBroStudio\PaymentMethodManager\Models\Method;
use Lorisleiva\Actions\Concerns\AsAction;

final class UpsertMethod
{
    use AsAction;

    public function handle(
        MethodData $methodData,
        ?Method    $method = null): Method
    {
        if (is_null($method)) {
            return Method::create($methodData->toArray());
        }

        $method->fill($methodData->toArray());

        if ($method->isClean()) {
            return $method;
        }

        $method->save();

        return $method->refresh();
    }
}
