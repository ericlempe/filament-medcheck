<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = User::factory()->create([
            'name' => 'Eric Lempe',
            'email' => 'ericlempe1994@gmail.com',
        ]);

        Auth::login($user);

        Patient::factory(100)->create();
        Service::factory(100)->create();
        Appointment::factory(30)->create();

    }
}
