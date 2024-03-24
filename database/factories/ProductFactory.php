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

    public function definition(): array
    {
        $name = "Товар".fake()->unique()->randomNumber(6).fake()->regexify('[A-Za-z]{5}');
        $slug = str_slug($name);
        return [
            'name' => $name,
            'price' => round(fake()->randomFloat(2,2000,50000)),
            'available_quantity' => fake()->randomNumber(3),
            'category_id' => fake()->numberBetween(1,4),
            'slug'=> $slug,
        ];
    }
}
