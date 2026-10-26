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
    Schema::create('research_line_researcher', function (Blueprint $table) {
        $table->id();
        $table->foreignId('research_line_id')->constrained()->cascadeOnDelete();
        $table->foreignId('researcher_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_line_researcher');
    }
};
