<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->string('author_qualification')->nullable()->after('author_name'); // Habilitações Literárias
            $table->string('publication_country')->default('Moçambique')->after('publication_year'); // País
            $table->string('book_title')->nullable()->after('title'); // Título do Livro (capítulos)
            $table->string('journal_name')->nullable()->after('title'); // Nome da Revista (artigos)
            $table->string('journal_edition')->nullable()->after('journal_name'); // Edição da Revista
            $table->string('isbn_issn')->nullable()->after('publication_year'); // ISBN/ISSN
            $table->string('doi')->nullable()->after('isbn_issn'); // DOI
            $table->text('external_link')->nullable()->after('file_path'); // Link Externo
        });
    }

    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn([
                'author_qualification',
                'publication_country',
                'book_title',
                'journal_name',
                'journal_edition',
                'isbn_issn',
                'doi',
                'external_link',
            ]);
        });
    }
};