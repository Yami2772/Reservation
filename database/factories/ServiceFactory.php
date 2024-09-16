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
            "name" => fake()->name(),
            "price" => fake()->randomNumber(),
            "description" => fake()->text(),
            "type" => fake()->randomElement([
                'pool',
                'footsal',
                'football',
                'volleyball',
                'basketball',
                'ping_pong',
                'martial',
                'tenis',
            ]),
        ];
    }
}
