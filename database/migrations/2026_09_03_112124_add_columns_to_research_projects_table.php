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
        Schema::table('research_projects', function (Blueprint $table) {
            //
            $table->enum('status', [
                'pending_validation',   // Acabou de ser submetido (não visível)
                'searching_funds',      // Submetido para financiamento (procura parceiros)
                'portfolio',            // Na carteira (aguardando oportunidade/edital)
                'funded',               // Já financiado
                'in_execution',         // Em execução
                'completed',            // Concluído
                'rejected'              // Não aprovado pela Direção
            ])->default('pending_validation')->change();

            $table->boolean('is_public')->default(false); // Controle de visibilidade no site
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_projects', function (Blueprint $table) {
            //
            $table->dropColumn('status');
            $table->dropColumn('is_public');
        });
    }
};
