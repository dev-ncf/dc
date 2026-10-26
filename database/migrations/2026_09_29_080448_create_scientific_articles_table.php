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
Schema::create('scientific_articles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->string('author_name');
    $table->string('author_qualification')->nullable();
    $table->string('title');
    $table->string('journal_name'); // Nome da Revista
    $table->string('edition_and_year'); // Edição e Ano de Publicação
    $table->string('issn_doi')->nullable();
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
        Schema::dropIfExists('scientific_articles');
    }
};
