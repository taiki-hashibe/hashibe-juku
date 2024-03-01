<?php

namespace Database\Factories;

use App\Models\InflowRoute;
use App\Services\GenerateUniqueText;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InflowRoute>
 */
class InflowRouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'route' => $this->faker->word,
            'source' => $this->faker->word,
            'key' => GenerateUniqueText::generate(InflowRoute::class, 'key'),
            'redirect_url' => $this->faker->url,
        ];
    }
}
