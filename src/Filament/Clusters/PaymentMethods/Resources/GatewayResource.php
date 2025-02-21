<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources;

use Filament\Forms;
use Filament\Notifications;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables;
use Filament\Tables\Table;
use IBroStudio\PaymentMethodManager\Actions\UpsertCredentials;
use IBroStudio\PaymentMethodManager\Actions\UpsertGateway;
use IBroStudio\PaymentMethodManager\Actions\ValidateGatewayCredentials;
use IBroStudio\PaymentMethodManager\Data\GatewayData;
use IBroStudio\PaymentMethodManager\Facades\PaymentMethodRegistry;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\GatewayResource\Pages;
use IBroStudio\PaymentMethodManager\Models\Gateway;
use Illuminate\Database\Eloquent\Model;
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
        if (is_null($form->getRecord())) {
            return $form
                ->schema([
                    static::getGatewayFormComponent()
                ]);
        }

        return $form
            ->schema([
                static::getNameFormComponent(),
                static::getCredentialsFormComponents($form),
            ]);
    }

    protected static function getGatewayFormComponent(): Forms\Components\Component
    {
        return Forms\Components\Select::make('gateway')
            ->label(__('Gateways available'))
            ->options(
                PaymentMethodRegistry::all()
                    ->pluck('name', 'key')
                    ->toArray()
            )
            ->selectablePlaceholder(false)
            ->required()
            ->native(false);
    }

    protected static function getNameFormComponent(): Forms\Components\Component
    {
        return Forms\Components\TextInput::make('name')
            ->label(__('Name'))
            ->required()
            ->autofocus();
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
                Tables\Actions\EditAction::make()
                    ->before(function (Tables\Actions\EditAction $action, Model $record, array $data) {
                        if (! ValidateGatewayCredentials::run(
                            credentials: $data['credentials'],
                            gateway: $record
                        )) {
                            Notifications\Notification::make()
                                ->danger()
                                ->title(__('Bad credentials!'))
                                ->body(__('Api test connection failed.'))
                                ->send();

                            $action->halt();
                        }
                    })
                    ->using(function (Model $record, array $data): Model {
                        UpsertGateway::run(
                            gatewayData: GatewayData::from([
                                'name' => $data['name'],
                                'class' => $record->class,
                            ]),
                            gateway: $record,
                        );

                        UpsertCredentials::run(
                            credentials: $data['credentials'],
                            model: $record
                        );

                        return $record;
                    }),
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
