<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class UserObserver
{
    public function creating(Model $model)
    {
        $model->setAttribute('user_id', auth()->id());
    }
}
