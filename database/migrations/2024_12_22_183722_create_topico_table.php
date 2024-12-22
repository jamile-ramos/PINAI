<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topico', function (Blueprint $table) {
            $table->id();
            $table->string("titulo", 255);
            $table->text("descricao")->nullable();
            $table->dateTime("dataCriacao");
            $table->dateTime("ultimaAtualizacao");
            $table->foreignId('idUsuario')->constrained('usuario')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topico');
    }
};
