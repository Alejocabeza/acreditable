<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Enum\TypeAccount;
use App\Filament\Resources\ExpenseResource;
use App\Models\Account;
use App\Models\Balance;
use App\Models\Budget;
use App\Models\Category;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class ManageExpenses extends ManageRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('general.create_expense'))
                ->after(function (Model $record) {
                    // Update account balance
                    $account = Account::find($record->account_id);
                    $account->balance -= $record->amount;
                    $account->save();

                    // Update budget
                    if (!empty($record->category_id)) {
                        $budget = Budget::query()->where('category_id', Category::find($record->category_id)->id)->first();
                        $budget->amount -= $record->amount;
                        $budget->save();
                    }

                    // Create balance record
                    Balance::create([
                        'type' => 'Egreso',
                        'method' => TypeAccount::from($record->account->type)->name,
                        'account_id' => $record->account_id,
                        'amount' => $record->amount,
                    ]);
                })
                ->before(function (array $data) {
                    if (!empty($data['category_id'])) {

                        $account = Account::find($data['account_id']);
                        $budget = Budget::query()->where('category_id', Category::find($data['category_id'])->id)->first();
                        if ($account->balance < $data['amount'] || $budget->amount < $data['amount']) {
                            Notification::make()
                                ->title('Error: La cuenta no tiene suficientes fondos.')
                                ->danger()
                                ->send();

                            throw ValidationException::withMessages([
                                'amount' => ['La cuenta no tiene suficientes fondos.'],
                            ]);
                        }
                    }
                    return true;
                }),
        ];
    }
}
