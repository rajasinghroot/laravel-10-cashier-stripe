<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
        return [
            'product_name' => ucfirst($this->faker->words(2, true)),
            'product_price' => $this->faker->randomFloat(2,0,100),
            'description' => $this->faker->text(50),
        ];
    }
}
