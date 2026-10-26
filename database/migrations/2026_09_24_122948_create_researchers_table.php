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
   Schema::create('researchers', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nome do Docente
        $table->string('academic_title')->nullable(); // Ex: Doutor, Professor Doutor
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->string('photo')->nullable(); // Guarda o caminho da foto
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researchers');
    }
};
