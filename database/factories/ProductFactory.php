<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use UnexpectedValueException;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug,
            'name' => $this->faker->words(asText: true),
            'cover_image' => $this->fakeImage(Product::COVER_STORAGE, 720, 640),
            'images' => array_map(
                fn () => $this->fakeImage(Product::COVER_STORAGE, 720, 640),
                range(1, random_int(2, 5)),
            ),

            'price' => random_int(15, 70) * 10,
            'unit' => $this->faker->randomElement(['個', '箱', '盒', '條', '份', '100g', '斤']),
            'description' => $this->faker->paragraphs(random_int(1, 3), asText: true),
        ];
    }

    private function fakeImage(string $disk, ?int $width = null, ?int $height = null): string
    {
        $root = config('filesystems.disks.' . Product::COVER_STORAGE . '.root');
        File::makeDirectory($root, 0755, true, true);

        if (empty($root)) {
            throw new UnexpectedValueException("The root directory for the \"{$disk}\" storage disk is not configured.");
        }

        return Str::after(
            $this->faker->image($root, $width, $height),
            $root,
        );
    }
}
