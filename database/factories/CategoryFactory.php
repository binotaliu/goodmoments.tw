<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
final class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug,
            'name' => [
                'zh_Hant_TW' => $this->faker->words(asText: true),
                'zh_Oan' => $this->faker->words(asText: true),
                'en' => $this->faker->words(asText: true),
            ],
        ];
    }
}
