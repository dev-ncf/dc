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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content'); // Para suportar editores ricos (Rich Text)
            $table->string('featured_image')->nullable();
            
            // Categorização profissional
            $table->enum('type', ['news', 'event', 'announcement', 'regulation', 'institutional'])
                ->default('news');
            
            // Metadados para Eventos/Agenda
            $table->dateTime('event_start_date')->nullable();
            $table->dateTime('event_end_date')->nullable();
            $table->string('location')->nullable(); // Local físico ou link Zoom/Google Meet
            
            // Arquivos anexos (Ex: PDF do Edital ou Regulamento)
            $table->string('attachment_path')->nullable();

            // Relacionamentos
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Autor
            $table->foreignId('organic_unit_id')->nullable()->constrained()->onDelete('set null');
            
            // Status de publicação
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Para segurança contra exclusões acidentais
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
