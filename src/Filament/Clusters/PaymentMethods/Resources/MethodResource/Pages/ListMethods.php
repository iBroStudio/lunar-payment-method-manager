<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\MethodResource\Pages;

use Filament\Resources\Pages\ListRecords;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\MethodResource;

class ListMethods extends ListRecords
{
    protected static string $resource = MethodResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
