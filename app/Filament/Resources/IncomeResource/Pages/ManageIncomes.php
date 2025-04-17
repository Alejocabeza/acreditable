<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use App\Models\Account;
use App\Models\Balance;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageIncomes extends ManageRecords
{
    protected static string $resource = IncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->after(function (Model $record) {
                // Update account balance
                $account = Account::find($record->account_id);
                $account->balance += $record->amount;
                $account->save();
                // create balance record
                $balance = Balance::create([
                    'type' => 'Ingreso',
                    'account_id' => $record->account_id,
                    'amount' => $record->amount,
                ]);
            })->label(__('general.create_income')),
        ];
    }
}
