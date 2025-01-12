<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->string('subtitulo', 255);
            $table->text('conteudo');
            $table->string('imagem')->nullable();
            $table->foreignId('idUsuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('idCategoriaNoticia')->constrained('categorias_noticias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
