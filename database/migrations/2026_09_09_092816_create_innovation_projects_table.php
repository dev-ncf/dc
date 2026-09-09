<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('innovation_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            
            // Relacionamentos
            $table->foreignId('inventor_id')->constrained('users')->cascadeOnDelete(); // Autor/Inventor principal
            $table->foreignId('knowledge_area_id')->constrained('knowledge_areas')->cascadeOnDelete();
            
            // Campos específicos de Inovação / Startups / Patentes
            $table->string('innovation_type'); // ex: prototipo_tecnologico, produto_alimentar, software, patente
            $table->string('trl_level')->default('trl_3'); // Technology Readiness Level (Nível de Maturidade)
            $table->text('abstract'); // Resumo da Inovação
            $table->text('market_potential'); // Como aplica no mercado / Comercialização
            
            // Documento técnico ou Pitch Deck (PDF)
            $table->string('project_file_path'); 
            
            // Controlo Administrativo
            $table->string('status')->default('pending'); // pending, incubating, market_ready, patented, rejected
            $table->boolean('is_public')->default(true);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('innovation_projects');
    }
};