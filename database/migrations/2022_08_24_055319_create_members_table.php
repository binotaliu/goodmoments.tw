<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', static function (Blueprint $table): void {
            $table->comment('成員介紹');

            $table->id();

            $table->string('title');
            $table->string('name');

            $table->text('description');

            $table->integer('row');
            $table->integer('priority');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
