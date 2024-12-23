<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticia', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('conteudo');
            $table->datetime('dataPublicacao');
            $table->datetime('ultimaAtualizacao')->nullable();
            $table->string('nomeImagem', 255)->nullable();
            $table->text('caminhoImagem')->nullable();

            $table->foreignId('idUsuario')->constrained('usuario')->onDelete('cascade');
            $table->foreignId('idCategoriaNoticia')->constrained('categoria_noticia')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticia');
    }
};
