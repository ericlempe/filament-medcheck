<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['photo'] = str_contains($data['photo'], 'https') ? $data['photo'] : Storage::url($data['photo']);

        return $data;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['birth_date'] = Carbon::parse($data['birth_date'])->format('Y-m-d');

        return $data;
    }
}
