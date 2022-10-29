<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ContactStatus;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Contact;
use App\Models\ContactComment;
use App\Models\Member;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        $users = User
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
            ->count(46)
            ->for(User::factory(), 'creator')
            ->withImage()
            ->create();

        Article
            ::factory()
            ->count(25)
            ->for(User::factory(), 'creator')
            ->withImages()
            ->create();

        Member
            ::factory()
            ->count(15)
            ->withImage()
            ->state(new Sequence(
                ['row' => 0, 'priority' => 0],
                ['row' => 0, 'priority' => 1],
                ['row' => 1, 'priority' => 0],
                ['row' => 1, 'priority' => 1],
                ['row' => 1, 'priority' => 2],
                ['row' => 1, 'priority' => 3],
                ['row' => 1, 'priority' => 4],
                ['row' => 1, 'priority' => 5],
                ['row' => 2, 'priority' => 1],
                ['row' => 2, 'priority' => 2],
                ['row' => 2, 'priority' => 3],
                ['row' => 2, 'priority' => 4],
            ))
            ->create();

        $contacts = Contact
            ::factory()
            ->count(random_int(32, 128))
            ->create();

        $contacts
            ->random(round($contacts->count() / 3 * 2))
            ->each(
                fn (Contact $c) =>
                    ContactComment
                        ::factory()
                        ->count(random_int(1, 6))
                        ->for($c)
                        ->sequence(fn () => ['user_id' => $users->random()->id])
                        ->create(),
            )
            ->each(fn (Contact $c) => $c->update(['status' => ContactStatus::processing]))
            ->random(round($contacts->count() / 5))
            ->each(fn (Contact $c) => $c->update(['status' => ContactStatus::resolved]));


        $this->call(SysvalSeeder::class);
    }
}
