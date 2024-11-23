<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\MethodResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\MethodResource;

class EditMethod extends EditRecord
{
    protected static string $resource = MethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
