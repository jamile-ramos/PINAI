<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('categorias_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('nomeCategoria', 255);
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->foreignId('idUsuario')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_documentos');
    }
};
