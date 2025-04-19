<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('publicos_alvo_solucoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idSolucao')->constrained('solucoes')->onDelete('cascade');
            $table->foreignId('idPublicoAlvo')->constrained('publicos_alvo')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicos_alvo_solucoes');
    }
};
