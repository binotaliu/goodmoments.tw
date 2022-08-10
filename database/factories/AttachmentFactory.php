<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        $uuid = Uuid::uuid4();

        return [
            'uuid' => $uuid->getHex()->toString(),
            'disk' => $this->faker->randomElement(['public', 'cover', 'image']),
            'path' => '/' . substr($uuid, 0, 2) . '/' . base64_url_encode($uuid) . '.jpg',
            'mime' => 'image/jpeg',
            'name' => $this->faker->slug . '.jpg',
            'size' => $this->faker->numberBetween(1000, 1_000_000_000),
            'meta' => [],
            'file_md5' => md5(random_bytes(36)),
            'meta_md5' => md5('{}'),
        ];
    }

    public function withFile(): self
    {
        return $this->state(function (array $attributes) {
            $file = UploadedFile::fake()->image($attributes['name']);
            $path = Str::beforeLast($attributes['path'], '/');
            Storage::disk($attributes['disk'])->putFileAs($path, $file, $attributes['name']);

            return [
                'size' => $file->getSize(),
                'file_md5' => md5_file($file->getRealPath()),
            ];
        });
    }

    public function withMeta(array $meta): self
    {
        ksort($meta);
        return $this->state(fn () => ['meta' => $meta, 'meta_md5' => md5(json_encode($meta, JSON_THROW_ON_ERROR))]);
    }

    public function appendMeta(array $meta): self
    {
        $meta = [
            ...($attributes['meta'] ?? []),
            ...$meta,
        ];
        ksort($meta);
        return $this->state(fn (array $attributes) => [
            'meta' => $meta,
            'meta_md5' => md5(json_encode($meta, JSON_THROW_ON_ERROR)),
        ]);
    }
}
