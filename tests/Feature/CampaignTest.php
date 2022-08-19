<?php

declare(strict_types=1);

use App\Models\Article;
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

it('lists banners', function (): void {
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

it('display banners on front page', function (): void {
    $availableBannerCount = 3;
    $availableBanners = Banner::factory()
        ->for(User::factory(), 'creator')
        ->has(Attachment::factory()->withImage())
        ->count($availableBannerCount)
        ->sequence(
            ['started_at' => now()->subWeek(), 'ended_at' => null],
            ['started_at' => now()->subWeek(), 'ended_at' => now()->addWeek()],
        )
        ->create();

    $hiddenBannerCount = 5;
    $hiddenBanners = Banner::factory()
        ->for(User::factory(), 'creator')
        ->has(Attachment::factory()->withImage())
        ->count($hiddenBannerCount)
        ->sequence(
            ['started_at' => now()->addWeek(), 'ended_at' => null],
            ['started_at' => now()->addWeek(), 'ended_at' => now()->addMonths(1)],
            ['started_at' => now()->subMonth(), 'ended_at' => now()->subWeek()],
            ['started_at' => now()->subWeek(), 'ended_at' => now()->subDay()],
            ['started_at' => now()->subDay(), 'ended_at' => now()->subMinute()],
        )
        ->create();

    $page = get(route('index'))->assertSuccessful();

    $page
        ->assertSee($availableBanners->pluck('url')->toArray())
        ->assertSee($availableBanners->pluck('title.zh_Hant_TW')->toArray())
        ->assertSee($availableBanners->pluck('description.zh_Hant_TW')->filter()->toArray())
        ->assertDontSee($hiddenBanners->pluck('url')->toArray());
});

it('creates new article', function (): void {
    $user = User::factory()->active()->create();
    actingAs($user);

    $coverImage = Attachment
        ::factory()
        ->withImage()
        ->withMeta(['type' => 'articleCoverImage'])
        ->create();

    $socialImage = Attachment
        ::factory()
        ->withImage()
        ->withMeta(['type' => 'articleSocialImage'])
        ->create();

    post(route('admin.articles.store'), [
        'slug' => $slug = 'article-slug-' . random_int(1, 100000),
        'title' => [
            'en' => 'Article title',
            'zh_Hant_TW' => '文章標題',
            'zh_Oan' => '文章標題',
        ],
        'description' => [
            'en' => 'Article description',
            'zh_Hant_TW' => '文章描述',
            'zh_Oan' => '文章描述',
        ],
        'cover_image_uuid' => $coverImage->uuid,
        'social_image_uuid' => $socialImage->uuid,
        'content' => [
            'en' => 'Article content',
            'zh_Hant_TW' => '文章內容',
            'zh_Oan' => '文章內容',
        ],
    ])->assertValid()->assertRedirect();

    assertDatabaseHas('articles', [
        'creator_id' => $user->id,
        'slug' => $slug,
    ]);
});

it('updates an article', function (): void {
    $user = User::factory()->create();

    actingAs($user);
    $article = Article::factory()->withImages()->for($user, 'creator')->create();

    put(route('admin.articles.update', [$article]), [
        'slug' => 'new-slug-' . $article->slug,
        'title' => $article->getTranslations('title'),
        'description' => $article->getTranslations('description'),
        'cover_image_uuid' => $article->cover_image_uuid,
        'social_image_uuid' => $article->social_image_uuid,
        'content' => $article->getTranslations('content'),
    ])->assertValid()->assertRedirect();

    assertDatabaseHas('articles', [
        'id' => $article->id,
        'slug' => 'new-slug-' . $article->slug,
    ]);
});
