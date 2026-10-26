<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            // Altera a coluna keywords para o tipo JSON
            $table->json('keywords')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            // Reverte para string/text caso precise de fazer rollback
            $table->text('keywords')->nullable()->change();
        });
    }
};