<?php

namespace App\Filament\Exports;

use App\Models\Balance;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BalanceExporter extends Exporter
{
    protected static ?string $model = Balance::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('type')->label(__('general.type')),
            ExportColumn::make('method')->label(__('general.method')),
            ExportColumn::make('amount')->label(__('general.amount')),
            ExportColumn::make('account.name')->label(__('general.account')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your balance export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
