<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\GatewayResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\GatewayResource;

class ListGateways extends ListRecords
{
    protected static string $resource = GatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
