<?php

namespace Database\Factories;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug,
            'title' => [
                'en' => $this->faker->sentence,
                'zh_Hant_TW' => $this->faker->realTextBetween(10, 24),
                'zh_Oan' => $this->faker->realTextBetween(10, 24),
            ],
            'description' => [
                'en' => $this->faker->sentence,
                'zh_Hant_TW' => $this->faker->realTextBetween(26, 128),
                'zh_Oan' => $this->faker->realTextBetween(26, 128),
            ],
            'content' => [
                'en' => $this->faker->randomHtml,
                'zh_Hant_TW' => $this->faker->randomHtml,
                'zh_Oan' => $this->faker->randomHtml,
            ],
            'published_at' => $this->faker->dateTimeBetween(
                '-1 year',
                $this->faker->boolean(90) ? 'now' : '+1 year',
            ),
        ];
    }

    public function withImages(): static
    {
        return $this
            ->has(
                Attachment::factory()->withImage()->withMeta([
                    'type' => 'articleCoverImage',
                ])
            )
            ->has(
                Attachment::factory()->withImage()->withMeta([
                    'type' => 'articleSocialImage',
                ])
            );
    }
}
