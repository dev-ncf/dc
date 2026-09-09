<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extension_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            
            // Relacionamentos
            $table->foreignId('coordinator_id')->constrained('users')->cascadeOnDelete(); // Ou a tabela de docentes/pesquisadores
            $table->foreignId('knowledge_area_id')->constrained('knowledge_areas')->cascadeOnDelete();
            
            // Campos específicos de extensão
            $table->string('community_partner'); // Parceiro comunitário
            $table->string('target_beneficiaries')->nullable(); // Público-alvo
            $table->text('abstract'); // Resumo
            $table->text('expected_impact')->nullable(); // Impacto social esperado
            
            // Documento e Ficheiros
            $table->string('project_file_path'); // PDF
            
            // Cronograma e Orçamento
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('requested_budget', 12, 2)->nullable();
            $table->string('funding_source')->nullable();
            
            // Controlo Administrativo
            $table->string('status')->default('pending'); // pending, approved, in_execution, completed, suspended, rejected
            $table->boolean('is_public')->default(true);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extension_projects');
    }
};