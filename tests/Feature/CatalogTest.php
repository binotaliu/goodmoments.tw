<?php

use App\Models\Attachment;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('lists categories', function (): void {
    actingAs(User::factory()->create());

    Category::factory()->count(random_int(5, 25))->create();
    $totalCategoriesCount = Category::count();

    get('/admin/categories')
        ->assertInertia(
            fn (AssertableInertia $assert) => $assert
                ->component('Categories/Index')
                ->where('categories.total', $totalCategoriesCount)
        );
});

it('can create category', function (): void {
    $user = User::factory()->active()->create();
    actingAs($user);

    post(route('admin.categories.store'), [
        'slug' => $slug = 'category-slug-' . time(),
        'name' => [
            'en' => 'Category name',
            'zh_Hant_TW' => '分類名稱',
            'zh_Oan' => '分類名',
        ],
    ])->assertValid()->assertRedirect();

    assertDatabaseHas('categories', [
        'slug' => $slug,
    ]);
});

it('lists products inside a category', function (): void {
    $user = User::factory()->active()->create();
    actingAs($user);

    $category = Category::factory()->create();
    Product::factory()->withImages()->for($category)->count(random_int(5, 25))->create();
    Product::factory()->withImages()->for(Category::factory())->count(random_int(1, 3))->create();
    $categoryProductsCount = $category->products()->count();
    $allProductsCount = Product::count();

    expect($allProductsCount)->toBeGreaterThan($categoryProductsCount);

    get(route('admin.categories.products.index', $category))
        ->assertInertia(
            fn (AssertableInertia $assert) => $assert
                ->component('Products/Index')
                ->where('products.total', $categoryProductsCount)
        );
});

it('creates a product inside a category', function (): void {
    $user = User::factory()->active()->create();
    $category = Category::factory()->create();
    actingAs($user);

    /** @var Attachment $coverImageAttachment */
    $coverImageAttachment = Attachment
        ::factory()
        ->withImage()
        ->withMeta(['type' => Product::ATTACHMENT_TYPE_COVER])
        ->create();
    /** @var \Illuminate\Support\Collection|Attachment[] $imageAttachments */
    $imageAttachments = Attachment
        ::factory()
        ->count(random_int(4, 6))
        ->withImage()
        ->withMeta(['type' => Product::ATTACHMENT_TYPE_IMAGE])
        ->create();

    post(route('admin.categories.products.store', $category), [
        'slug' => $slug = 'product-slug-' . time(),
        'name' => [
            'en' => 'Product name',
            'zh_Hant_TW' => '產品名稱',
            'zh_Oan' => '產品名',
        ],
        'cover_image_uuid' => $coverImageAttachment->uuid,
        'image_uuids' => $imageAttachments->pluck('uuid')->toArray(),
        'price' => random_int(100, 1000),
        'store_url' => 'https://www.example.com',
        'store_url_text' => [
            'en' => 'Buy Now',
            'zh_Hant_TW' => '立即購買',
            'zh_Oan' => '立即購買',
        ],
        'unit' => [
            'en' => 'unit',
            'zh_Hant_TW' => '單位',
            'zh_Oan' => '單位',
        ],
        'description' => [
            'en' => 'description',
            'zh_Hant_TW' => '描述',
            'zh_Oan' => '描述',
        ],
    ])
        ->assertValid()
        ->assertRedirect();

    assertDatabaseHas('products', [
        'slug' => $slug,
        'category_id' => $category->id,
    ]);

    $createdProduct = Product::where('slug', $slug)->where('category_id', $category->id)->firstOrFail();
    $attachmentIds = [$coverImageAttachment->id, ...$imageAttachments->pluck('id')];
    foreach ($attachmentIds as $attachmentId) {
        assertDatabaseHas('attachmentables', [
            'attachment_id' => $attachmentId,
            'attachmentable_id' => $createdProduct->id,
            'attachmentable_type' => Product::class,
        ]);
    }
});
