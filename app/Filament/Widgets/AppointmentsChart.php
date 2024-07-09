<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;

class AppointmentsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?int $sort = 4;

    protected function getData(): array
    {

        $appointments = Appointment::selectRaw('MONTH(start_at) as month')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $dataset = [];
        foreach (range(0, 11) as $i) {
            $monthWithAppointments = $appointments->firstWhere('month', $i + 1);
            $dataset[] = !is_null($monthWithAppointments) ? (int) $monthWithAppointments->count : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Appointments per month',
                    'data' => $dataset,
                ],
            ],
            'labels' => $months,

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
