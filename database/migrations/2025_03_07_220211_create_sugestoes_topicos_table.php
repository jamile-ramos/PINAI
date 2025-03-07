<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('sugestoes_topicos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->enum('status_situacao', ['pendente','aprovado','rejeitado'])->default('pendente');
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->foreignId('idUsuario')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sugestoes_topicos');
    }
};
