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
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->longText('description');
        $table->string('featured_image')->nullable();
        
        // Datas e Local
        $table->dateTime('start_date');
        $table->dateTime('end_date')->nullable();
        $table->string('location'); // Ex: Anfiteatro 1 ou Link Zoom
        $table->string('registration_url')->nullable(); // Link para inscrição externa
        
        // Relacionamentos
        $table->foreignId('organic_unit_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('user_id')->nullable()->constrained(); // Organizador
        
        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
