<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = Service::all();
        $patients = Patient::all();
        $status = AppointmentStatus::cases();

        $date = $this->faker->dateTimeBetween('now', '+3 months');
        $start = $date->format('Y-m-d H:i:s');
        $end = $date->modify('+1 hour')->format('Y-m-d H:i:s');

        return [
            'service_id' => $services->random()->id,
            'patient_id' => $patients->random()->id,
            'status' => $this->faker->randomElement($status)->value,
            'obs' => $this->faker->paragraph(),
            'start_at' => $start,
            'end_at' => $end
        ];
    }
}
