<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Expense;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\DB;

class ExpenseWidget extends ChartWidget
{
    protected static ?string $heading = 'Expense';
    protected static ?string $pollingInterval = '5s';
    protected static ?string $maxHeight = '180px';
    protected static ?int $sort = 2;

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
        {
            scales: {
                y: {
                    ticks: {
                        display: false
                    },
                    grid: {
                        display: false
                    },
                },
                x: {
                    ticks: {
                        display: false
                    },
                    grid: {
                        display: false
                    },
                },
            },
        }
    JS);
    }

    protected function getData(): array
    {
        $expenses = Expense::selectRaw('sum(amount) as total, strftime("%m", date) as month')
            ->groupBy('month')
            ->pluck('total', 'month');

        if ($expenses->isEmpty()) {
            return [
                'datasets' => [
                    [
                        'label' => 'Budget Amounts',
                        'data' => [0], // Valor por defecto
                    ],
                ],
                'labels' => ['No Data'], // Etiqueta por defecto
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Expense Amounts',
                    'data' => $expenses->values()->toArray(),
                ],
            ],
            'labels' => $expenses->keys()->map(function ($month) {
                return date('M', mktime(0, 0, 0, $month, 10));
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
