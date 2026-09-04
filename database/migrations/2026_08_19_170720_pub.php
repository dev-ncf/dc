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
        //
        Schema::table('publications', function (Blueprint $table) {
            // Tornar campos opcionais
            $table->foreignId('organic_unit_id')->nullable()->change();
            $table->foreignId('course_id')->nullable()->change();
            
            // Adicionar campo para proveniência externa
            $table->string('issuing_institution')->nullable()->after('advisor_name')
                ->default('Universidade Rovuma'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('publications', function (Blueprint $table) {
            // Reverter campos para obrigatórios
            $table->foreignId('organic_unit_id')->nullable(false)->change();
            $table->foreignId('course_id')->nullable(false)->change();
            
            // Remover campo de proveniência externa
            $table->dropColumn('issuing_institution');
        });
    }
};
