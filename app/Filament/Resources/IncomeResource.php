<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Models\Account;
use App\Models\Category;
use App\Models\Income;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class IncomeResource extends Resource
{
    protected static ?string $model          = Income::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('general.management_finances');
    }

    public static function getPluralLabel(): ?string
    {
        return __('general.incomes');
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
                Select::make('account_id')
                    ->options(Account::all()->mapWithKeys(function ($account) {
                        return [$account->id => "{$account->name} [\${$account->balance}]"];
                    })->toArray())
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
                TextColumn::make('account.name')
                    ->label(__('general.account')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    ViewAction::make()->label(__('general.view')),
                    Tables\Actions\DeleteAction::make()->after(function (Model $record) {
                        $account = Account::find($record->account_id);
                        $account->balance -= $record->amount;
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
            'index' => Pages\ManageIncomes::route('/'),
        ];
    }
}
