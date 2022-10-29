<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'contact_method' => $this->faker->randomElement(['email', 'phone']),
            'email' => $this->faker->email(),
            'subject' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
        ];
    }
}
