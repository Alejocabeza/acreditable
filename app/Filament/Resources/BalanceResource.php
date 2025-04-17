<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BalanceResource\Pages;
use App\Models\Balance;
use App\Services\PDFService;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class BalanceResource extends Resource
{
    protected static ?string $model = Balance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('general.management_accounts');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->label(__('general.type'))->default(__('general.no_available')),
                TextColumn::make('method')->default(__('general.no_available')),
                TextColumn::make('amount')->numeric()->money('USD')->label(__('general.amount')),
                TextColumn::make('account.name')
                    ->label(__('general.account')),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('download')
                        ->label(__('general.download'))
                        ->action(function (Collection $records) {
                            $items = $records->toArray();
                            $pdfData = [
                                'records' => $items,
                            ];
                            $path = 'pdfs/balances.pdf';
                            PDFService::PDFGenerate($pdfData, 'path.to.your.view', $path, true);
                        })
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBalances::route('/'),
        ];
    }
}
