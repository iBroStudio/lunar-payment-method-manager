<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\MethodResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\MethodResource;

class CreateMethod extends CreateRecord
{
    protected static string $resource = MethodResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
