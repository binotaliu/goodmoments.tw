<?php

namespace Database\Seeders;

use App\Enums\SysvalKey;
use App\Models\Sysval;
use Illuminate\Database\Seeder;

final class SysvalSeeder extends Seeder
{
    public function run(): void
    {
        Sysval::set(SysvalKey::about__description, fake()->randomHtml);
    }
}
