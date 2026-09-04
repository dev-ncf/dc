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
        $table->foreignId('coordinator_id')->nullable()->change(); 
        $table->string('external_proponent_name')->nullable();  
        $table->string('external_proponent_email')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_projects', function (Blueprint $table) {
            //
        });
    }
};
