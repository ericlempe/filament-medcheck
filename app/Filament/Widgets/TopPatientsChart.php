<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\ChartWidget;

class TopPatientsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $topPatients = Patient::withCount('appointments')->orderBy('appointments_count', 'desc')->get()->take(5);

        return [
            'datasets' => [
                [
                    'label' => 'Top 5 Patients',
                    'data' => $topPatients->pluck('appointments_count')->toArray(),
                ],
            ],
            'labels' => $topPatients->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
