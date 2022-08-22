<?php

namespace Database\Factories;

use App\Models\Attachment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

final class BannerFactory extends Factory
{
    public function definition(): array
    {
        $showDescription = $this->faker->boolean(30);

        return [
            'location' => 'index',
            'title' => [
                'en' => 'en:' . $this->faker->words(3, asText: true),
                'zh_Oan' => 'oan:' . $this->faker->realTextBetween(10, 32),
                'zh_Hant_TW' => $this->faker->realTextBetween(10, 32),
            ],
            'description' => [
                'en' => $showDescription ? 'en:' . $this->faker->words(9, asText: true) : '',
                'zh_Oan' => $showDescription ? 'oan:' . $this->faker->realTextBetween(26, 128) : '',
                'zh_Hant_TW' => $showDescription ? $this->faker->realTextBetween(26, 128) : '',
            ],
            'image_description' => [
                'en' => 'en:' . $this->faker->words(3, asText: true),
                'zh_Oan' => 'oan:' . $this->faker->realTextBetween(32, 64),
                'zh_Hant_TW' => $this->faker->realTextBetween(32, 64),
            ],
            'url' => $this->faker->url,
            'started_at' => $startedAt = $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'ended_at' => $this->faker->boolean(10) ? null : $this->faker->dateTimeBetween($startedAt, Carbon::parse($startedAt)->add(1, 'year')),
        ];
    }

    public function withImage(): static
    {
        return $this->has(
            Attachment::factory()->withImage(2560, 960),
        );
    }
}
