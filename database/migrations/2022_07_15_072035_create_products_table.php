<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', static function (Blueprint $table): void {
            $table->id();
            $table->bigInteger('category_id')->unsigned();

            $table->string('slug')->unique();
            $table->json('name');

            $table->string('cover_image');
            $table->json('images');

            $table->decimal('price', 10, 2);
            $table->json('unit');

            $table->json('description');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
