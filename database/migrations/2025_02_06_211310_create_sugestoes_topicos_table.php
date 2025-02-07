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
            $table->enum('status', [0,1,2])->default(0)->comment('0=pedente, 1=aprovado, 2=rejeitado');
            $table->foreignId('idUsuario')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sugestoes_topicos');
    }
};
