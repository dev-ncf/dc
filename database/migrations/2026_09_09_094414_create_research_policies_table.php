<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('research_policies', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Ex: Regulamento de Ética na Investigação
            $table->string('category'); // ex: etica, propriedade_intelectual, regulamento_geral, financiamento
            $table->text('description'); // Breve resumo do documento
            $table->string('document_file_path'); // PDF da política
            $table->integer('version_year')->default(2026);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research_policies');
    }
};