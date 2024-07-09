<?php

namespace App\Filament\Widgets;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class SchedulePatients extends BaseWidget
{

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = [
        'sm' => 1,
        'md' => 2,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->whereDate('start_at', '=', Carbon::now()->format('Y-m-d'))
            )
            ->columns([
                Tables\Columns\IconColumn::make('status')
                    ->icon(fn(AppointmentStatus $state) => match ($state->value) {
                        'pending' => 'heroicon-o-clock',
                        'concluded' => 'heroicon-o-check-circle',
                        'canceled' => 'heroicon-o-x-circle',
                        'in_service' => 'heroicon-o-chat-bubble-oval-left-ellipsis',
                        'overdue' => 'heroicon-o-exclamation-circle',
                    }),
                Tables\Columns\TextColumn::make('patient.name')->searchable(),
                Tables\Columns\TextColumn::make('start_at')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('end_at')
                    ->dateTime('d/m/Y H:i')
            ]);
    }
}
