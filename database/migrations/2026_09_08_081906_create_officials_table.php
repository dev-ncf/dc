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
    Schema::create('officials', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        $table->string('academic_level'); // Ex: Prof. Doutor, Mestre, Lic.
        $table->string('position');       // Ex: Diretor Científico, Chefe de Departamento
        $table->string('image_path')->nullable();
        $table->text('bio')->nullable();
        
        // Relacionamento Opcional
        $table->foreignId('organic_unit_id')->nullable()->constrained()->onDelete('set null');
        
        // Ordenação e Status
        $table->integer('sort_order')->default(0); 
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officials');
    }
};
