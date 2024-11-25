<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources;

use Filament\Forms;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables;
use Filament\Tables\Table;
use IBroStudio\PaymentMethodManager\Facades\PaymentMethodRegistry;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\GatewayResource\Pages;
use IBroStudio\PaymentMethodManager\Models\Gateway;
use IBroStudio\Subscription\Enums\ChargeUnitEnum;
use Lunar\Admin\Support\Resources\BaseResource;

class GatewayResource extends BaseResource
{
    protected static ?string $model = Gateway::class;

    protected static ?string $slug = 'gateways';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = PaymentMethods::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 2;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                is_null($form->getRecord()) ?
                    static::getGatewayFormComponent() : static::getCredentialsFormComponents($form),
            ]);
    }

    protected static function getGatewayFormComponent(): Forms\Components\Component
    {
        return Forms\Components\Select::make('gateway')
            ->label(__('Gateways available'))
            ->options(
                PaymentMethodRegistry::all()
                    // filter to take out existing gateways
                    ->pluck('name', 'key')
                    ->toArray()
            )
            ->selectablePlaceholder(false)
            ->required()
            ->native(false);
    }

    protected static function getCredentialsFormComponents(Forms\Form $form): ?Forms\Components\Component
    {
        return $form->getRecord()->getCredentialsFormComponents($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading(__('Delete the gateway and its payment methods')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGateways::route('/'),
            //'create' => Pages\CreateGateway::route('/create'),
            //'edit' => Pages\EditGateway::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
