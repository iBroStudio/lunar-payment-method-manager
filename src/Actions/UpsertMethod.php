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
        MethodData|array $methodData,
        ?Method    $method = null): Method
    {
        if (is_array($methodData)) {
            $methodData = MethodData::from(
                $method ?
                array_merge($methodData, ['class' => $method->class, 'gateway_id' => $method->gateway_id])
                : $methodData
            );
        }

        if (is_null($method)) {
            return $methodData->class::create($methodData->toArray());
        }

        $method->fill($methodData->toArray());

        if ($method->isClean()) {
            return $method;
        }

        $method->save();

        return $method->refresh();
    }
}
