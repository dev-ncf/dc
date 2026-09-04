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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('abstract'); // Resumo
            $table->string('keywords'); // Palavras-chave
            
            // Autoria e Orientação
            $table->foreignId('user_id')->constrained(); // Quem submeteu
            $table->string('author_name'); // Nome do autor (pode ser diferente do user logado)
            $table->string('advisor_name')->nullable(); // Orientador
            
            // Classificação
            $table->foreignId('document_type_id')->constrained(); // Tipo: Tese, Artigo...
            $table->foreignId('knowledge_area_id')->constrained(); // Área Científica
            $table->foreignId('organic_unit_id')->constrained(); // Faculdade
            $table->foreignId('course_id')->constrained(); // Curso
            
            // Detalhes Técnicos
            $table->year('publication_year');
            $table->string('language')->default('Português');
            $table->string('file_path'); // Caminho do PDF
            
            $table->string('issuing_institution')->nullable()->after('advisor_name')
          ->default('Universidade Rovuma');
            
            // Níveis de Acesso e Workflow
            $table->enum('visibility', ['public', 'metadata_only', 'restricted'])->default('public');
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable(); // Para o bibliotecário explicar o erro
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
