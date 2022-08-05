<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', static function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('disk');
            $table->string('path');
            $table->string('name');
            $table->string('mime');
            $table->string('size');
            $table->string('md5');

            $table->json('meta')->default(DB::raw('(JSON_OBJECT())'));

            $table->index('md5');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
