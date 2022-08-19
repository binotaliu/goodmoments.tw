<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', static function (Blueprint $table): void {
            $table->id();

            $table->string('slug');

            $table->json('title');
            $table->json('description');

            $table->json('content');

            $table->unsignedBigInteger('creator_id');

            $table->timestamp('published_at');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')->references('id')->on('users');
            $table->index('slug');
            $table->unique(['slug', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
