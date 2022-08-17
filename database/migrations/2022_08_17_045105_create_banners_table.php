<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', static function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('creator_id');

            $table->enum('location', ['index']);
            $table->json('title');
            $table->json('description');
            $table->string('url', 4096);

            $table->json('image_description');

            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
