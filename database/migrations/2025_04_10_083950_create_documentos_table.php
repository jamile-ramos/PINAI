<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('nomeArquivo', 255);
            $table->text('descricao');
            $table->text('caminhoArquivo');
            $table->foreignId('idUsuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('idCategoria')->constrained('categorias_documentos')->onDelete('cascade');
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
