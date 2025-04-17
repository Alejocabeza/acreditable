<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class IncomeWidget extends ChartWidget
{
    protected static ?string $heading = 'Income';
    protected static ?string $pollingInterval = '5s';
    protected static ?string $maxHeight = '180px';
    protected static ?int $sort = 1;

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
        $incomes = Income::selectRaw('sum(amount) as total, strftime("%m", date) as month')
            ->groupBy('month')
            ->pluck('total', 'month');

        if ($incomes->isEmpty()) {
            return [
                'datasets' => [
                    [
                        'label' => 'Expenses Amounts',
                        'data' => [0], // Valor por defecto
                    ],
                ],
                'labels' => ['No Data'], // Etiqueta por defecto
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Incomes Amounts',
                    'data' => $incomes->values()->toArray(),
                ],
            ],
            'labels' => $incomes->keys()->map(function ($month) {
                return date('M', mktime(0, 0, 0, $month, 10));
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
