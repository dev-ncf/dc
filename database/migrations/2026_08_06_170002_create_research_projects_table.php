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
        Schema::create('research_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('abstract'); // Resumo do projeto
            $table->longText('description')->nullable(); // Metodologia/Corpo do projeto
            
            // Gestão de Status (Workflow)
            $table->enum('status', [
                'draft',        // Rascunho do docente
                'submitted',    // Enviado para análise
                'under_review', // Em avaliação pelos pareceristas
                'approved',     // Aprovado para execução
                'rejected',     // Rejeitado
                'completed',    // Finalizado e arquivado
                'on_hold'       // Suspenso temporariamente
            ])->default('draft');

            // Financiamento e Prazos
            $table->decimal('requested_budget', 15, 2)->default(0); // Valor solicitado
            $table->decimal('approved_budget', 15, 2)->default(0);  // Valor concedido
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Documentação técnica
            $table->string('project_file_path'); // O PDF principal do projeto
            
            // Relacionamentos
            $table->foreignId('coordinator_id')->constrained('users'); // Coordenador (Docente)
            $table->foreignId('knowledge_area_id')->constrained();
            $table->foreignId('organic_unit_id')->nullable()->constrained();
            
            // Para projetos financiados externamente
            $table->string('funding_agency')->nullable(); // Ex: FNI, Camões, etc.
            
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('project_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('research_project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Papel do membro no projeto
            $table->enum('role', ['researcher', 'assistant', 'student_grantee', 'consultant'])
                ->default('researcher');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_projects');
        Schema::dropIfExists('project_user');
    }
};
