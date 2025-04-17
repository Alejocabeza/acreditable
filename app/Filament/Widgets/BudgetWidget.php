<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Budget;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\DB;

class BudgetWidget extends ChartWidget
{
    protected static ?string $heading = 'Budget';
    protected static ?string $pollingInterval = '5s';
    protected static ?string $maxHeight = '180px';
    protected static ?int $sort = 3;

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
        $budgets = Budget::select(DB::raw('sum(amount) as total'), 'period')
            ->groupBy('period')
            ->pluck('total', 'period');

        if ($budgets->isEmpty()) {
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
                    'label' => 'Budget Amounts',
                    'data' => $budgets->values()->toArray(),
                ],
            ],
            'labels' => $budgets->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
