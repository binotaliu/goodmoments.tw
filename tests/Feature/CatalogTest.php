<?php

use App\Models\Attachment;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

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

it('updates a category', function (): void {
    $user = User::factory()->active()->create();
    $category = Category::factory()->create();

    actingAs($user);
    put(route('admin.categories.update', ['category' => $category]), [
        'slug' => $newSlug = 'new-slug-' . time(),
        'name' => [
            'en' => 'Category name',
            'zh_Hant_TW' => '分類名稱',
            'zh_Oan' => '分類名',
        ],
    ])->assertValid()->assertRedirect();

    assertDatabaseHas('categories', [
        'slug' => $newSlug,
    ]);
});

it('deletes a category', function (): void {
    $user = User::factory()->active()->create();
    $category = Category::factory()->create();

    actingAs($user);
    delete(route('admin.categories.destroy', ['category' => $category]))
        ->assertValid()->assertRedirect();

    assertSoftDeleted('categories', [
        'id' => $category->id,
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
    /** @var Collection|Attachment[] $imageAttachments */
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
        'cover_image' => $coverImageAttachment->toArray(),
        'images' => $imageAttachments->toArray(),
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
    $attachments = [$coverImageAttachment, ...$imageAttachments];
    expect($createdProduct)->toHaveAttachments($attachments);
});

it('updates images of a product', function (): void {
    $user = User::factory()->active()->create();

    /** @var Category $category */
    $category = Category::factory()->create();
    /** @var Product $product */
    $product = Product::factory()->for($category)->withImages()->create();

    $newCover = Attachment::factory()->withImage()->withMeta(['type' => Product::ATTACHMENT_TYPE_COVER])->create();
    $newImages = Attachment::factory()->count(random_int(4, 6))->withImage()->withMeta(['type' => Product::ATTACHMENT_TYPE_IMAGE])->create();

    actingAs($user);
    put(route('admin.categories.products.update', ['category' => $category, 'product' => $product]), [
        'slug' => $product->slug,
        'name' => $product->getTranslations('name'),
        'cover_image' => $newCover->toArray(),
        'images' => $newImages->toArray(),
        'price' => $product->price,
        'store_url' => $product->store_url,
        'store_url_text' => $product->getTranslations('store_url_text'),
        'unit' => $product->getTranslations('unit'),
        'description' => $product->getTranslations('description'),
    ])->assertValid()->assertRedirect();

    expect($product->refresh())
        ->toHaveAttachments([$newCover, ...$newImages]);
});

it('deletes a product', function (): void {
    $user = User::factory()->active()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->for($category)->create();

    actingAs($user);
    delete(route('admin.categories.products.destroy', ['category' => $category, 'product' => $product]))
        ->assertValid()->assertRedirect();

    assertSoftDeleted('products', [
        'id' => $product->id,
    ]);
});
