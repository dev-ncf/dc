<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publication_policies', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Ex: Diretrizes para Publicação em Acesso Aberto
            $table->string('category'); // ex: revistas_cientificas, repositorio_institucional, teses_dissertacoes, incentivos
            $table->text('description'); // Breve resumo do documento
            $table->string('document_file_path'); // PDF da política de publicação
            $table->integer('version_year')->default(2026);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publication_policies');
    }
};