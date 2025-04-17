<?php

namespace App\Filament\Resources\BalanceResource\Pages;

use App\Filament\Exports\BalanceExporter;
use App\Filament\Resources\BalanceResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\Contracts\ExportFormat;
use Filament\Resources\Pages\ManageRecords;

class ManageBalances extends ManageRecords
{
    protected static string $resource = BalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(BalanceExporter::class)
                ->fileDisk('public')
                ->chunkSize(250)
                ->maxRows(100000)
                ->fileName('balances')
        ];
    }
}
