<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_topico', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dataSugestao');
            $table->string('topicoSugerido', 100);
            $table->foreignId('idUsuario')->constrained('usuario')->onDelete('cascade');
            $table->foreignId('idTopico')->constrained('topico')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_topico');
    }
};
