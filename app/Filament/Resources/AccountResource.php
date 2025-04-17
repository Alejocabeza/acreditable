<?php

namespace App\Filament\Resources;

use App\Enum\TypeAccount;
use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return __('general.accounts');
    }

    public static function getPluralLabel(): string
    {
        return __('general.accounts');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('general.management_accounts');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label(__('general.name'))->required(),
                DatePicker::make('initial_date')->label(__('initial_date'))->default(now())->required(),
                TextInput::make('balance')->label(__('general.balance'))->required(),
                Select::make('type')
                    ->label(__('general.type'))
                    ->options(
                        collect(TypeAccount::cases())
                            ->mapWithKeys(fn($type) => [$type->value => $type->name])
                            ->toArray()
                    )
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('general.name')),
                TextColumn::make('initial_date')->label(__('initial_date')),
                TextColumn::make('type')->label(__('general.type'))
                    ->formatStateUsing(fn($state) => TypeAccount::tryFrom($state)?->name ?? $state),
                TextColumn::make('balance')->numeric()->money('USD')->label(__('general.balance')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->label(__('general.editar')),
                    Tables\Actions\ViewAction::make()->label(__('general.view')),
                    Tables\Actions\DeleteAction::make()->label(__('general.delete')),
                ])->icon('tabler-menu-deep'),
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
            'index' => Pages\ManageAccounts::route('/'),
        ];
    }
}
