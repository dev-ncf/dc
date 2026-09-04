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
        Schema::table('events', function (Blueprint $table) {
            $table->string('submitter_name')->nullable();   // Nome de quem enviou
            $table->string('submitter_email')->nullable();  // Email de quem enviou
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
            $table->dropColumn('submitter_name');
            $table->dropColumn('submitter_email');
        });
    }
};
