<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachmentables', static function (Blueprint $table): void {
            $table->bigInteger('attachment_id');
            $table->string('attachmentable_id');
            $table->string('attachmentable_type');

            $table->unique(['attachment_id', 'attachmentable_id', 'attachmentable_type'], 'attachmentables_unique');
            $table->index('attachment_id');
            $table->index('attachmentable_id');
            $table->index('attachmentable_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachmentables');
    }
};
