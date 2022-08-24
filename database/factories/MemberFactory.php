<?php

namespace Database\Factories;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Factories\Factory;

final class MemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'row' => $this->faker->randomNumber(),
            'priority' => $this->faker->randomNumber(),
        ];
    }

    public function withImage(): static
    {
        return $this->has(Attachment::factory()->withImage(512, 512));
    }
}
