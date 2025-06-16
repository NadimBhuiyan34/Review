<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $name = $this->faker->unique()->company();

    return [
        'id' => Str::uuid(),
        'name' => $name,
        'slug' => Str::slug($name),
        'logo' => 'https://via.placeholder.com/150', // dummy logo
        'status' => true,
    ];
    }
}
