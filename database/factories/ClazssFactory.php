<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clazss>
 */
class ClazssFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => "{$this->faker->numerify("##")} {$this->faker->asciify("***")} {$this->faker->numerify("#")}",
            "major_id" => mt_rand(0, 10)
        ];
    }
}
