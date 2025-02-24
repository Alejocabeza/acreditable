<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Account;
use App\Models\Category;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('general.management_finances');
    }

    public static function getPluralLabel(): ?string
    {
        return __('general.expenses');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')
                    ->numeric()
                    ->label(__('general.amount'))
                    ->required(),
                DatePicker::make('date')
                    ->label(__('general.date'))
                    ->required()
                    ->default(now()),
                Select::make('category_id')
                    ->options(
                        Category::has('budget')->get()->mapWithKeys(function ($category) {
                            $budget = $category->budget->amount;
                            return [$category->id => " $category->name [\$" . number_format($budget, 2) . "]"];
                        })->toArray()
                    )
                    ->live()
                    ->preload()
                    ->searchable()
                    ->label(__('general.category'))
                    ->required(),
                Select::make('account_id')
                    ->options(
                        Account::where('balance', '>', 0)->get()->mapWithKeys(function ($account) {
                            return [$account->id => "{$account->name} [\${$account->balance}]"];
                        })->toArray()
                    )
                    ->live()
                    ->preload()
                    ->searchable()
                    ->label(__('general.account'))
                    ->required(),
                RichEditor::make('description')
                    ->columnSpanFull()
                    ->label(__('general.description')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')
                    ->label(__('general.amount'))
                    ->money('USD'),
                TextColumn::make('date')
                    ->label(__('general.date')),
                TextColumn::make('category.name')
                    ->label(__('general.category')),
                TextColumn::make('account.name')
                    ->label(__('general.account')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->label(__('general.view')),
                    Tables\Actions\DeleteAction::make()->after(function (Model $record) {
                        $account = Account::find($record->account_id);
                        $budget = Category::find($record->category_id)->budget;
                        $budget->amount += $record->amount;
                        $account->balance += $record->amount;
                        $budget->save();
                        $account->save();
                    })->label(__('general.delete')),
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
            'index' => Pages\ManageExpenses::route('/'),
        ];
    }
}
