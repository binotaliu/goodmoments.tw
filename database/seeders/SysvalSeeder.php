<?php

namespace Database\Seeders;

use App\Enums\SysvalKey;
use App\Models\Sysval;
use Illuminate\Database\Seeder;

final class SysvalSeeder extends Seeder
{
    public function run(): void
    {
        Sysval::set(SysvalKey::about__description, [
            'en' => fake()->randomHtml,
            'zh_Oan' => fake()->randomHtml,
            'zh_Hant_TW' => fake()->randomHtml,
        ]);

        Sysval::set(
            SysvalKey::life__blocks,
            array_map(
                static fn (string $actZhHantTw, string $actZhOan, string $actEn, string $textPosition): array => [
                    'image' => fake()->imageUrl(),
                    'image_description' => [
                        'en' => fake()->paragraph,
                        'zh_Oan' => fake()->imageUrl(),
                        'zh_Hant_TW' => fake()->realTextBetween(16, 120),
                    ],
                    'title' => [
                        'en' => $actEn,
                        'zh_Oan' => $actZhOan,
                        'zh_Hant_TW' => $actZhHantTw,
                    ],
                    'text' => [
                        'en' => fake()->paragraph,
                        'zh_Oan' => fake()->paragraph,
                        'zh_Hant_TW' => fake()->realTextBetween(120, 240),
                    ],
                    'text_position' => $textPosition,
                ],
                ['食', '衣', '住', '行', '育', '樂'],
                ['食', '衣', '住', '行', '育', '樂'],
                ['Eat', 'Wear', 'Live', 'Travel', 'Learn', 'Fun'],
                ['left', 'right', 'left', 'right', 'left', 'right'],
            ),
        );

        Sysval::set(SysvalKey::map_description, [
            'en' => fake()->paragraph,
            'zh_Oan' => fake()->realTextBetween(120, 240),
            'zh_Hant_TW' => fake()->realTextBetween(120, 240),
        ]);
    }
}
