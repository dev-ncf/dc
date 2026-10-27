<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            // Habilitações do autor principal
            $table->enum('author_degree', [
                'Licenciatura',
                'Mestrado',
                'Doutoramento',
                'Pós-Doutoramento',
                'Outro'
            ])->nullable()->after('author_name')->change();

            // Veiculação e Indexação Internacional
            $table->string('publication_country')->default('Moçambique')->after('publication_year')->change();
            $table->string('url')->nullable()->after('publication_country')->change();
            $table->string('doi')->nullable()->after('url')->change();
            $table->string('isbn')->nullable()->after('doi')->change(); // Livros e Capítulos
            $table->string('issn')->nullable()->after('isbn')->change(); // Artigos

            // Campos específicos de Artigos

            $table->string('journal_name')->nullable()->after('issn')->change();
            $table->string('volume_issue')->nullable()->after('journal_name')->change(); // Edição, vol, n.º, páginas

            // Campos específicos de Capítulos de Livro e Livros
            $table->string('book_title')->nullable()->after('volume_issue')->change(); // Para capítulos
            $table->string('publisher')->nullable()->after('book_title'); // Editora
        });
    }

    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn([
                'author_degree',
                'publication_country',
                'url',
                'doi',
                'isbn',
                'issn',
                'journal_name',
                'volume_issue',
                'book_title',
                'publisher'
            ]);
        });
    }
};