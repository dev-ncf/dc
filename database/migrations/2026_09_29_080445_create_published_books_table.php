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
 Schema::create('published_books', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->string('author_name');
    $table->string('author_qualification')->nullable(); // Habilitações Literárias (Ex: Doutor, Mestre)
    $table->string('title');
    $table->string('isbn_doi')->nullable();
    $table->string('link')->nullable();
    $table->string('country')->default('Moçambique');
    $table->year('publication_year')->default(2025);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('published_books');
    }
};
