<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cooperation_agreements', function (Blueprint $table) {
            $table->id();

            // Identificação do Instrumento
            $table->string('title')->comment('Ex: Acordo de Cooperação Científica e Mobilidade');
            $table->string('agreement_number')->unique()->comment('Nº de Registo ex: AC/UR/2026/05');
            
            // Tipo de Instrumento Jurídico
            $table->enum('type', [
                'Memorando de Entendimento (MoU)',
                'Acordo-Quadro',
                'Protocolo Específico',
                'Convénio de Estágio',
                'Carta de Intenções',
                'Adenda / Aditivo',
            ])->default('Memorando de Entendimento (MoU)');

            // Parceiro
            $table->string('partner_name')->comment('Nome da Universidade / Embaixada / ONG parceira');
            $table->string('partner_country')->default('Moçambique');
            $table->enum('scope', [
                'Nacional',
                'Regional (SADC)',
                'CPLP',
                'Internacional Geral'
            ])->default('Internacional Geral');

            // Enquadramento Interno na UniRovuma
            $table->foreignId('organic_unit_id')->nullable()->constrained('organic_units')->nullOnDelete()->comment('Faculdade/Extensão beneficiária');
            $table->foreignId('focal_point_id')->nullable()->constrained('users')->nullOnDelete()->comment('Docente/Responsável pelo acompanhamento');

            // Áreas e Objetivos
            $table->json('areas_of_cooperation')->nullable()->comment('Ex: Pesquisa, Mobilidade, Pós-graduação');
            $table->text('objectives')->nullable();

            // Prazos e Vigência
            $table->date('signature_date')->comment('Data de assinatura');
            $table->date('expiration_date')->nullable()->comment('Data limite');
            $table->boolean('auto_renew')->default(false)->comment('Renovação automática');

            // Documento Comprovativo
            $table->string('document_file_path')->nullable()->comment('PDF do acordo assinado com carimbo');

            // Estado Administrativo
            $table->enum('status', [
                'negotiation', // Em negociação
                'active',      // Vigente
                'expired',     // Expirado / Caducado
                'renewing',    // Em processo de renovação
                'terminated',  // Rescindido
            ])->default('active');

            $table->boolean('is_public')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cooperation_agreements');
    }
};