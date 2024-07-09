<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([UserObserver::class])]
class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'value',
        'is_active',
        'is_presencial',
        'user_id',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
