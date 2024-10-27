<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auto>
 */
class AutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'modelo' => $this->faker->word,
            'color' => $this->faker->colorName,
            'precio' => $this->faker->randomFloat(2, 10000, 50000), // Precio en un rango más adecuado para carros
            'transmision' => $this->faker->randomElement(['Manual', 'Automática']),
            'submarca' => $this->faker->word,
            'marca_id' => $this->faker->numberBetween(1, 6),
            'imagen' => ''
        ];
    }
}
