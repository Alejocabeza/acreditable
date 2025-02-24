<?php

namespace App\Filament\Resources;

use App\Enum\PeriodBudget;
use App\Filament\Resources\BudgetResource\Pages;
use App\Filament\Resources\BudgetResource\RelationManagers;
use App\Models\Budget;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BudgetResource extends Resource
{
    protected static ?string $model = Budget::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('general.management_finances');
    }

    public static function getPluralLabel(): ?string
    {
        return __('general.budgets');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')->label('Amount')->required()->numeric()->label(__('general.amount')),
                Select::make('period')
                    ->options(
                        collect(PeriodBudget::cases())
                            ->mapWithKeys(fn($type) => [$type->value => __('general.' . $type->name)])
                            ->toArray()
                    )
                    ->required()->label(__('general.period')),
                Select::make('category_id')
                    ->options(Category::all()->pluck('name', 'id')->toArray())
                    ->preload()
                    ->live()
                    ->searchable()
                    ->label(__('general.category')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')->label('Amount')->money('USD')->label(__('general.amount')),
                TextColumn::make('period')
                    ->label(__('general.period'))
                    ->formatStateUsing(fn($state) => __('general.' . (PeriodBudget::tryFrom($state)?->name ?? $state))),
                TextColumn::make('category.name')->label(__('general.category')),
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
            'index' => Pages\ManageBudgets::route('/'),
        ];
    }
}
