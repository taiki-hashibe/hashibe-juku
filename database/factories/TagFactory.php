<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Services\GenerateSlug;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::random(10);
        return [
            'name' => $name,
            'slug' => GenerateSlug::generate($name, Tag::class),
        ];
    }
}
