<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('comentarios_mencoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idComentario')->constrained('comentarios')->onDelete('cascade');
            $table->foreignId('idUsuarioMencionou')->constrained('users')->onDelete('cascade');
            $table->foreignId('idUsuarioMencionado')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios_mencoes');
    }
};
