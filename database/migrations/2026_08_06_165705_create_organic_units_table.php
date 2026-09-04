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
    Schema::create('organic_units', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        $table->string('sigla', 20)->unique();
        $table->enum('type', ['reitoria', 'faculdade', 'extensao', 'direccao_central', 'departamento', 'centro'])->default('faculdade');
        $table->string('location'); 
        $table->string('slug')->unique();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organic_units');
    }
};
