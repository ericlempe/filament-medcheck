<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['start_at'] = Carbon::parse($data['start_at'])->format('Y-m-d H:i:s');
        $data['end_at'] = Carbon::parse($data['end_at'])->format('Y-m-d H:i:s');

        return $data;
    }
}
