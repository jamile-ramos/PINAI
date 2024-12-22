<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projeto', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('status', 50);
            $table->date('dataInicio');
            $table->date('previsaoConclusao');
            $table->dateTime('ultimaAtualizacao');
            $table->foreignId('idUsuario')->constrained('usuario')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projeto');
    }
};
