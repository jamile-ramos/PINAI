<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('solucoes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('descricao');
            $table->text('passosImplementacao');
            $table->text('arquivo')->nullable();
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->foreignId('idPublicoAlvo')->constrained('publicos_alvo')->onDelete('cascade');
            $table->foreignId('idCategoria')->constrained('categorias_solucoes')->onDelete('cascade');
            $table->foreignId('idUsuario')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solucoes');
    }
};
