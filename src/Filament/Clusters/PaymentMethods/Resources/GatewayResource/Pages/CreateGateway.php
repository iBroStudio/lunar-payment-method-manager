<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\GatewayResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\GatewayResource;

class CreateGateway extends CreateRecord
{
    protected static string $resource = GatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
