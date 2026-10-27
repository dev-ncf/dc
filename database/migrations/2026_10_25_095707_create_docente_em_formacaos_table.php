<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docentes_em_formacao', function (Blueprint $table) {
            $table->id();
            
            // Dados Institucionais e Pessoais
            // Substitua o campo 'unidade_organica' por este:
            $table->foreignId('organic_unit_id')
                ->constrained('organic_units')
                ->cascadeOnDelete();
            $table->string('nome_completo');
            $table->enum('sexo', ['Masculino', 'Feminino']);
            $table->date('data_nascimento');
            $table->enum('categoria', [
                'Assistente estagiário',
                'Assistente Universitário',
                'Professor Auxiliar',
                'Professor Associado',
                'Professor Catedrático'
            ]);
            $table->unsignedSmallInteger('ano_ingresso');
            $table->enum('vinculo', ['Quadro', 'Contratado']);
            
            // Formação Actual
            $table->enum('nivel_actual', ['Licenciado', 'Mestrado', 'Doutorado', 'Pós-doutorado']);
            $table->string('area_actual');

            // Formação em Curso
            $table->enum('nivel_em_curso', ['Mestrado', 'Doutorado', 'Pós-doutorado']);
            $table->string('area_em_curso');
            $table->string('curso');
            $table->string('instituicao');
            $table->string('pais');
            $table->string('cidade');
            $table->unsignedSmallInteger('ano_inicio');
            $table->unsignedSmallInteger('ano_previsao_fim');

            // Bolsa e Enquadramento Legal
            $table->enum('regime_bolsa', ['Parcial', 'Integral', 'Sem bolsa']);
            $table->string('financiador')->nullable();
            $table->string('despacho_edital');
            $table->boolean('possui_contrato')->default(false);

            // Contactos
            $table->string('email');
            $table->string('telefone');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes_em_formacao');
    }
};