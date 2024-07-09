<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $appointmentsToday = Appointment::query()
            ->whereDate('start_at', Carbon::now()->format('Y-m-d'));

        $totalAppointmentsToday = $appointmentsToday->count();
        $totalPatients = Patient::query()->count();

        $totalAppointmentsTodayPending = $appointmentsToday->where('status', 'pending')->count();

        return [
            Stat::make('Total Appointments Today', $totalAppointmentsToday)
                ->icon('heroicon-s-calendar'),
            Stat::make('Total Appointments Pending', $totalAppointmentsTodayPending)
                ->icon('heroicon-m-clock'),
            Stat::make('Total Patients', $totalPatients)
                ->icon('heroicon-m-users'),
        ];
    }
}
