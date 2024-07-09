<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([UserObserver::class])]
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'patient_id',
        'user_id',
        'status',
        'obs',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'status' => AppointmentStatus::class,
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
