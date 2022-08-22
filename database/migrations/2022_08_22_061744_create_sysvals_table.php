<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sysvals', static function (Blueprint $table) {
            $table->string('key')->unique();
            $table->json('value');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sysvals');
    }
};
