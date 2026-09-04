<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('institutional_infos', function (Blueprint $table) {
        $table->id();
        $table->string('type')->unique(); // mission, vision, values, history
        $table->string('title');
        $table->text('content');
        $table->string('icon')->nullable(); // Nome do ícone Heroicons
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutional_infos');
    }
};
