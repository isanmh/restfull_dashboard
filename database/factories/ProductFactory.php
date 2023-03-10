<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'description' => $this->faker->paragraph(1),
            'image' => $this->faker->imageUrl(640, 480, 'tech', true),
        ];
    }
}
