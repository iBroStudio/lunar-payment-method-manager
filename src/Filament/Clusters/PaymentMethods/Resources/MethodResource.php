<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources;

use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\MethodResource\Pages;
use IBroStudio\PaymentMethodManager\Models\Method;
use Lunar\Admin\Support\Resources\BaseResource;

class MethodResource extends BaseResource
{
    protected static ?string $model = Method::class;

    protected static ?string $slug = 'methods';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = PaymentMethods::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMethods::route('/'),
            'create' => Pages\CreateMethod::route('/create'),
            'edit' => Pages\EditMethod::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
