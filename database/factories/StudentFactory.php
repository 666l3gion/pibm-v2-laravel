<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $uniqueNumber = $this->faker->numerify('##########');
        return [
            'name' => $this->faker->name(),
            'nis' => $uniqueNumber,
            'email' => $uniqueNumber . '@gmail.com',
            'gender' => collect(['L', 'P'])->random()
        ];
    }
}
