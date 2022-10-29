<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', static function (Blueprint $table): void {
            $table
                ->enum('status', ['created', 'processing', 'resolved'])
                ->default('created')
                ->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', static function (Blueprint $table): void {
            $table->dropColumn('status');
        });
    }
};
