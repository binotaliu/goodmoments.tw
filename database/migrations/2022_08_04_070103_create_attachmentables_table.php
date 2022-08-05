<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachmentables', static function (Blueprint $table) {
            $table->bigInteger('attachment_id');
            $table->bigInteger('attachmentable_id');
            $table->string('attachmentable_type');

            $table->unique(['attachment_id', 'attachmentable_id', 'attachmentable_type'], 'attachmentables_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachmentables');
    }
};
