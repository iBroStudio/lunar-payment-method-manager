<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\GatewayResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use IBroStudio\PaymentMethodManager\Facades\PaymentMethodRegistry;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\GatewayResource;
use Illuminate\Database\Eloquent\Model;

class ListGateways extends ListRecords
{
    protected static string $resource = GatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->using(function (array $data): Model {
                    return PaymentMethodRegistry::createGatewayAndMethodsModels($data['gateway']);
                }),
        ];
    }
}
