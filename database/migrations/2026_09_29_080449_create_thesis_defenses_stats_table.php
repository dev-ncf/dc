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
Schema::create('thesis_defenses_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('organic_unit_id')->constrained()->cascadeOnDelete();
    $table->foreignId('course_id')->constrained()->cascadeOnDelete();
    $table->integer('dissertations_count')->default(0); // Número de Dissertações (Mestrado)
    $table->integer('theses_count')->default(0);          // Número de Teses (Doutoramento)
    $table->year('reference_year')->default(2026);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_defenses_stats');
    }
};
