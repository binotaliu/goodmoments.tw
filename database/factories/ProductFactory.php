<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

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
                'zh_Hant_TW' => mb_substr($this->faker->realTextBetween(10, 16), random_int(0, 8)),
                'zh_Oan' => 'oan:' . mb_substr($this->faker->realTextBetween(10, 16), random_int(0, 8)),
                'en' => 'en:' . $this->faker->words(asText: true),
            ],

            'price' => random_int(15, 70) * 10,
            'unit' => [
                'zh_Hant_TW' => $this->faker->randomElement(['個', '箱', '盒', '條', '份', '100g', '斤']),
                'zh_Oan' => 'zh_Oan:' . $this->faker->randomElement(['ê', '箱', '盒', '條', '份', '100g', '斤']),
                'en' => $this->faker->randomElement(['Unit', 'Box', 'Pc', '100g']),
            ],
            'store_url' => $this->faker->url,
            'store_url_text' => [
                'zh_Hant_TW' => '前往購買',
                'zh_Oan' => '去購買',
                'en' => 'Buy Now',
            ],
            'description' => [
                'zh_Hant_TW' => $this->faker->realTextBetween(160, 320),
                'zh_Oan' => 'zh_Oan:' . $this->faker->realTextBetween(160, 320),
                'en' => 'en:' . $this->faker->paragraphs(random_int(1, 3), asText: true),
            ],
        ];
    }

    public function withImages(): self
    {
        return $this->has(
            Attachment
                ::factory()
                ->count($count = random_int(4, 6))
                ->sequence(fn (Sequence $sequence) => [
                    'meta' => $meta = [
                        'type' => $sequence->index % $count === 0 ? Product::ATTACHMENT_TYPE_COVER : Product::ATTACHMENT_TYPE_IMAGE,
                    ],
                    'meta_md5' => md5(json_encode($meta)),
                    'disk' => $sequence->index % $count === 0 ? 'cover' : 'image',
                ])
                ->withImage(),
        );
    }
}
