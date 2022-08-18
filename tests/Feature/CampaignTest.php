<?php

declare(strict_types=1);

use App\Models\Attachment;
use App\Models\Banner;
use App\Models\User;

use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

it('lists banners', function () {
    actingAs(User::factory()->create());

    Banner::factory()
        ->for(User::factory()->create(), 'creator')
        ->has(Attachment::factory()->withImage())
        ->count(random_int(5, 25))
        ->create();
    $totalBannersCount = Banner::count();

    get(route('admin.banners.index'))
        ->assertInertia(
            fn (AssertableInertia $assert) => $assert
                ->component('Banners/Index')
                ->where('banners.total', $totalBannersCount)
        );
});

it('creates banner', function (): void {
    $user = User::factory()->active()->create();

    actingAs($user);

    $attachment = Attachment::factory()->withImage()->create();
    post(route('admin.banners.store'), [
        'title' => [
            'en' => 'Banner title',
            'zh_Hant_TW' => '橫幅標題',
            'zh_Oan' => '橫幅標題',
        ],
        'description' => [
            'en' => 'Banner description',
            'zh_Hant_TW' => '橫幅描述',
            'zh_Oan' => '橫幅描述',
        ],
        'image_uuid' => $attachment->uuid,
        'image_description' => [
            'en' => 'Banner image description',
            'zh_Hant_TW' => '橫幅圖片描述',
            'zh_Oan' => '橫幅圖片描述',
        ],
        'url' => $url = 'https://www.example.com?' . Str::random(),
        'started_at' => now()->toIso8601String(),
        'ended_at' => now()->addDays(7)->toIso8601String(),
    ])->assertValid()->assertRedirect();


    assertDatabaseHas('banners', [
        'creator_id' => $user->id,
        'url' => $url,
    ]);
});

it('updates banner', function (): void {
    $user = User::factory()->active()->create();

    $banner = Banner::factory()
        ->for(User::factory()->create(), 'creator')
        ->has(Attachment::factory()->withImage())
        ->create();

    actingAs($user);

    put(route('admin.banners.update', [$banner]), [
        'title' => $banner->getTranslations('title'),
        'description' => $banner->getTranslations('description'),
        'image_uuid' => $banner->attachments->sole()->uuid,
        'image_description' => $banner->getTranslations('image_description'),
        'url' => $url = 'https://www.example.com?' . Str::random(),
        'started_at' => $banner->started_at->toIso8601String(),
        'ended_at' => $banner->ended_at?->toIso8601String(),
    ])->assertValid()->assertRedirect();

    assertDatabaseHas('banners', [
        'id' => $banner->id,
        'url' => $url,
    ]);
});
