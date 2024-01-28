<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' =>  fake()->sentence(3, true) . " Hotel",
            'type' => fake()->randomElement([
                'Apartment', 'Hotel', 'Villa'
            ]),
            'city' => fake()->city(),
            'address' => fake()->address(),
            'rating' => rand(1, 10) / 2,
            'description' => fake()->text(255)
        ];
    }
}
