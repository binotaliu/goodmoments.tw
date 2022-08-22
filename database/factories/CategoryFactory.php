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
                'zh_Hant_TW' => mb_substr($this->faker->realTextBetween(10, 16), random_int(0, 8)),
                'zh_Oan' => mb_substr($this->faker->realTextBetween(10, 16), random_int(0, 8)),
                'en' => $this->faker->words(asText: true),
            ],
        ];
    }
}
