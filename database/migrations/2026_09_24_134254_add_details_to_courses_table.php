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
    Schema::table('courses', function (Blueprint $table) {
        $table->longText('description')->nullable()->after('name'); // Apresentação / Sobre o curso
        $table->string('regime')->default('Pós-Laboral')->after('level'); // Regime (Ex: Laboral, Pós-Laboral, 
        $table->text('duration')->nullable()->after('regime'); // Duração (Ex: 4 Anos)
    });
}

public function down(): void
{
    Schema::table('courses', function (Blueprint $table) {
        $table->dropColumn(['description', 'regime', 'duration']);
    });
}

};
