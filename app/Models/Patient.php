<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([UserObserver::class])]
class Patient extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable = [
        'name',
        'identity_number',
        'birth_date',
        'genre',
        'photo',
        'user_id'
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
