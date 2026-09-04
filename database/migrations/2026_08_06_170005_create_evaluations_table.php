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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            // Cria evaluable_id e evaluable_type
            // Isso permite que a avaliação aponte para 'Publication' ou 'ResearchProject'
            $table->morphs('evaluable'); 
            
            $table->foreignId('reviewer_id')->constrained('users');
            $table->text('comment');
            $table->integer('score')->nullable(); // Pontuação de 0 a 100
            $table->enum('decision', ['approved', 'correction_required', 'rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
