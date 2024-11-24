<?php

namespace IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources;

use Filament\Forms;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables;
use Guava\FilamentIconPicker\Forms\IconPicker;
use IBroStudio\PaymentMethodManager\Actions\UpsertMethod;
use IBroStudio\PaymentMethodManager\Data\MethodData;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods;
use IBroStudio\PaymentMethodManager\Filament\Clusters\PaymentMethods\Resources\MethodResource\Pages;
use IBroStudio\PaymentMethodManager\Models\Method;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Lunar\Admin\Support\Forms\Components\TranslatedRichEditor;
use Lunar\Admin\Support\Forms\Components\TranslatedText;
use Lunar\Admin\Support\Resources\BaseResource;
use Lunar\Models\Language;

class MethodResource extends BaseResource
{
    protected static ?string $model = Method::class;

    protected static ?string $slug = 'methods';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = PaymentMethods::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 1;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        static::getNameFormComponent(),
                        static::getDescriptionFormComponent(),
                        static::getIconFormComponent(),
                        static::getActiveFormComponent(),
                    ])
            ]);
    }

    protected static function getNameFormComponent(): Forms\Components\Component
    {
        return TranslatedText::make('name')
            ->label(__('Name'))
            ->required()
            ->autofocus();
    }

    protected static function getDescriptionFormComponent(): Forms\Components\Component
    {
        return TranslatedText::make('description')
            ->label(__('Description'));
    }

    protected static function getIconFormComponent(): Forms\Components\Component
    {
        return IconPicker::make('icon');
    }

    protected static function getActiveFormComponent(): Forms\Components\Component
    {
        return Forms\Components\Toggle::make('active');
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gateway.name'),

                Tables\Columns\TextColumn::make('name'),

                Tables\Columns\IconColumn::make('icon')
                    ->icon(fn (string $state): string => $state)
                    ->color('primary'),

                Tables\Columns\ToggleColumn::make('active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (Model $record, array $data): Model {
                        return UpsertMethod::run(
                            methodData: $data,
                            method: $record
                        );
                        $record->update($data);

                        return $record;
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMethods::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
