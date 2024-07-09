<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
