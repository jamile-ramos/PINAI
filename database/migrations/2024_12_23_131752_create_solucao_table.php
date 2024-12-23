<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solucao', function (Blueprint $table){
            $table->id();
            $table->string('titulo', 255);
            $table->text('descricao');
            $table->text('passos');
            $table->text('publicoAlvo');
            $table->string('arquivo', 255);
            $table->dateTime('dataCriacao');
            $table->foreignId('idUsuario')->constrained('usuario')->onDelete('cascade');
            $table->foreignId('idCategoriaSolucao')->constrained('categoria_solucao')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solucao');
    }
};
