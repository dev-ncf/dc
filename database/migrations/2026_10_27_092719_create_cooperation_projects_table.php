<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cooperation_projects', function (Blueprint $table) {
            $table->id();

            // 1. Identificação do Projeto
            $table->string('title')->comment('Título completo do projeto de cooperação');
            $table->string('code')->nullable()->comment('Código interno ou do financiador (ex: ERASMUS-2026-UR)');
            
            // 2. Parceria e Âmbito
            $table->string('partner_institution')->comment('Universidade ou entidade parceira');
            $table->string('partner_country')->default('Moçambique');
            $table->enum('scope', [
                'Nacional',
                'Internacional (Bilateral)',
                'Regional (SADC)',
                'Comunidade CPLP',
                'Multilateral / Consórcio'
            ])->default('Internacional (Bilateral)');

            $table->enum('modality', [
                'Investigação Científica Conjunta',
                'Mobilidade Académica (Docente/Estudantil)',
                'Desenvolvimento Institucional e Infraestrutura',
                'Pós-Graduação e Formação Doutoral',
                'Capacitação Pedagógica e Curricular',
                'Extensão Comunitária Internacional',
                'Outro'
            ])->default('Investigação Científica Conjunta');

            // 3. Enquadramento UniRovuma
            $table->foreignId('coordinator_id')->constrained('users')->cascadeOnDelete()->comment('Coordenador / Investigador Principal UniRovuma');
            $table->foreignId('organic_unit_id')->nullable()->constrained('organic_units')->nullOnDelete()->comment('Faculdade / Extensão');
            $table->foreignId('knowledge_area_id')->nullable()->constrained('knowledge_areas')->nullOnDelete();

            // 4. Coordenação Externa
            $table->string('external_coordinator_name')->nullable()->comment('Responsável no parceiro');
            $table->string('external_coordinator_email')->nullable();

            // 5. Descrição, Metas e Entregáveis
            $table->text('abstract')->comment('Resumo / Objetivos do projeto de cooperação');
            $table->text('expected_results')->nullable()->comment('Artigos, teses, equipamentos ou relatórios previstos');

            // 6. Financiamento e Cronograma
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('funding_agency')->nullable()->comment('Ex: União Europeia, DAAD, FNI, Camões, Banco Mundial');
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('currency', 10)->default('MZN');

            // 7. Ficheiro Comprovativo (Proposta ou Termo de Cooperação)
            $table->string('document_path')->nullable()->comment('PDF do projeto ou contrato de cooperação');

            // 8. Estado do Projeto
            $table->enum('status', [
                'proposal',     // Em submissão / Negociação
                'approved',     // Aprovado
                'in_progress',  // Em Execução
                'completed',    // Concluído
                'suspended',    // Suspenso
                'canceled',     // Cancelado
            ])->default('in_progress');

            $table->boolean('is_public')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cooperation_projects');
    }
};