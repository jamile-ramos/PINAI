<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documento', function (Blueprint $table) {
            $table->id();
            $table->string('nomeArquivo', 255);
            $table->text('caminhoArquivo');
            $table->text('descricao');
            $table->dateTime('dataUpload');
            $table->foreignId('idusuario')->constrained('usuario')->onDelete('cascade');
            $table->foreignId('idCategoriaDocumento')->constrained('categoria_documento')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documento');
    }
};
