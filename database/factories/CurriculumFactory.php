<?php

namespace Database\Factories;

use App\Models\Curriculum;
use App\Services\GenerateSlug;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curriculum>
 */
class CurriculumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id = Curriculum::max('id') + 1;
        $name = $id . '_' . fake()->sentence();
        return [
            'name' => $name,
            'slug' => GenerateSlug::generate($name, Curriculum::class),
            'description' => fake()->text(),
            'order' => 0
        ];
    }
}
