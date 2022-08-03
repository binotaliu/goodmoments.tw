<?php

use App\Models\Category;
use App\Models\User;

use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('lists categories', function () {
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

it('can create category', function () {
    $user = User::factory()->active()->create();
    actingAs($user);

    post(route('admin.categories.store'), [
        'slug' => $slug = 'category-slug-' . time(),
        'name' => [
            'en' => 'Category name',
            'zh_Hant_TW' => '分類名稱',
            'zh_Oan' => '分類名'
        ],
    ])->assertValid()->assertRedirect();

    assertDatabaseHas('categories', [
        'slug' => $slug,
    ]);
});
