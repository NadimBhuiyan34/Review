<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'id' => Str::uuid(),
        'name' => fake()->sentence(3),
        'slug' => Str::slug(fake()->unique()->sentence(3)),
        'description' => fake()->paragraph(),
        'image' => 'https://via.placeholder.com/800x400', // Default fallback
        'status' => true,
    ];
    }
}
