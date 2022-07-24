<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug,
            'name' => [
                'zh_Hant_TW' => $this->faker->words(asText: true),
                'zh_Oan' => 'oan:' . $this->faker->words(asText: true),
                'en' => 'en:' . $this->faker->words(asText: true),
            ],
            'cover_image' => $this->faker->imageUrl(720, 640),
            'images' => array_map(
                fn () => $this->faker->imageUrl(720, 640),
                range(1, random_int(2, 5)),
            ),

            'price' => random_int(15, 70) * 10,
            'unit' => [
                'zh_Hant_TW' => $this->faker->randomElement(['個', '箱', '盒', '條', '份', '100g', '斤']),
                'zh_Oan' => 'zh_Oan:' . $this->faker->randomElement(['ê', '箱', '盒', '條', '份', '100g', '斤']),
                'en' => $this->faker->randomElement(['Unit', 'Box', 'Pc', '100g']),
            ],
            'description' => [
                'zh_Hant_TW' => $this->faker->paragraphs(random_int(1, 3), asText: true),
                'zh_Oan' => 'zh_Oan:' . $this->faker->paragraphs(random_int(1, 3), asText: true),
                'en' => 'en:' . $this->faker->paragraphs(random_int(1, 3), asText: true),
            ],
        ];
    }
}
