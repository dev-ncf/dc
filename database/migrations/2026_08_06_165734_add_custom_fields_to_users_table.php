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
    Schema::table('users', function (Blueprint $table) {
        // Adicionando colunas após o email
        $table->string('orcid')->nullable()->unique()->after('email');
        $table->string('phone')->nullable()->after('orcid');
        
        // Relacionamento com unidade orgânica (pode ser nulo se for Direção Central)
        $table->foreignId('organic_unit_id')
              ->nullable()
              ->after('phone')
              ->constrained('organic_units')
              ->onDelete('set null');

        $table->enum('user_type', ['estudante', 'docente', 'investigador', 'admin', 'parecerista'])
              ->default('estudante')
              ->after('organic_unit_id');
              
        $table->boolean('is_active')->default(true)->after('password');
    });
}

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['organic_unit_id']);
        $table->dropColumn(['orcid', 'phone', 'organic_unit_id', 'user_type', 'is_active']);
    });
}
};
