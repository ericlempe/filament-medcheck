<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Actions\DeleteAction;
use Saade\FilamentFullCalendar\Actions\EditAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Appointment::class;

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
        'sm' => 1,
        'md' => 2,
    ];

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'dayGridWeek,dayGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
        ];
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Appointment')
        ];
    }

    protected function modalActions(): array
    {
        return [
            CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    return [
                        ...$data,
                        'user_id' => auth()->id()
                    ];
                })
                ->mountUsing(
                    function (Form $form, array $arguments) {
                        $form->fill([
                            'start_at' => $arguments['start'] ?? null,
                            'end_at' => $arguments['end'] ?? null,
                        ]);
                    }
                ),
            EditAction::make()
                ->mountUsing(
                    function (Appointment $record, Form $form, array $arguments) {
                        $form->fill([
                            'name' => $record->name,
                            'patient_id' => $record->patient_id,
                            'service_id' => $record->service_id,
                            'start_at' => $arguments['event']['start'] ?? $record->start_at,
                            'end_at' => $arguments['event']['end'] ?? $record->end_at
                        ]);
                    }
                ),
            DeleteAction::make(),
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
//        dd($fetchInfo);
        return Appointment::query()
            ->where('start_at', '>=', $fetchInfo['start'])
            ->where('end_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn(Appointment $event) => [
                    'id' => $event->id,
                    'title' => $event->patient->name,
                    'start' => $event->start_at,
                    'end' => $event->end_at,
                    'url' => AppointmentResource::getUrl(name: 'edit', parameters: ['record' => $event]),
                    'shouldOpenUrlInNewTab' => false
                ]
            )
            ->all();
    }

    public function getFormSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'md' => 2,
                    ])
                        ->schema([
                            DateTimePicker::make('start_at')
                                ->columnSpan(1)
                                ->required(),
                            DateTimePicker::make('end_at')
                                ->columnSpan(1)
                                ->required(),
                        ]),
                    Grid::make([
                        'default' => 1,
                        'md' => 2,
                    ])
                        ->schema([
                            Select::make('patient_id')
                                ->label('Patient')
                                ->options(Patient::all()->pluck('name', 'id'))
                                ->required()
                                ->searchable(),
                            Select::make('service_id')
                                ->label('Service')
                                ->options(Service::all()->pluck('name', 'id'))
                                ->required()
                                ->searchable()
                        ]),
                    Textarea::make('obs')
                        ->label('Observation')
                        ->columns(1)
                ])
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
            function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
                el.setAttribute("x-tooltip", "tooltip");
                el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
            }
        JS;
    }

    public function getColumns(): int|string|array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 2
        ];
    }
}
