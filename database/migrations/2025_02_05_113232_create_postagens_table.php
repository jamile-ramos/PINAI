<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('postagens', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('conteudo');
            $table->foreignId('idUsuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('idTopico')->constrained('topicos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postagens');
    }
};
