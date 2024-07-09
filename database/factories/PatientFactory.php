<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'identity_number' => $this->faker->numerify('###-###-####'),
            'birth_date' => $this->faker->date(),
            'genre' => $this->faker->randomElement(['male', 'female']),
            'photo' => 'https://i.pravatar.cc/300?img=' . $this->faker->numberBetween(1, 70),
        ];
    }
}
