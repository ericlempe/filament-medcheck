<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle(),
            'code' => $this->faker->unique()->randomNumber(),
            'value' => $this->faker->randomNumber(2),
            'is_active' => $this->faker->boolean(),
            'is_presencial' => $this->faker->boolean(),
        ];
    }
}
