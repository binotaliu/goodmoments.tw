<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class ContactCommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => $this->faker->realText(random_int(15, 200)),
        ];
    }
}
