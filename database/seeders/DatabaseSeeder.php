<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'username' => 'admin',
            'email' => 'test@example.com',
            'password' => Hash::make('hunter2'),
            'is_active' => true,
        ]);

        User
            ::factory()
            ->count(25)
            ->create();

        Category
            ::factory()
            ->count(3)
            ->create()
            ->each(static fn (Category $category) => Product::factory()->withImages()->for($category)->count(7)->create());

        Banner
            ::factory()
            ->count(12)
            ->for(User::factory(), 'creator')
            ->withImage()
            ->create();

        Article::factory()->count(25)->withImages()->create();
    }
}
