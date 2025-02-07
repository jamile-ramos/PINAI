<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('topicos_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUsuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('idTopico')->constrained('topicos')->onDelete('cascade');
            $table->enum('status', [0, 1, 2])->default(1)->comment('0 = aprovado, 1 = pendente, 2 = rejeitado');
            $table->timestamps();
            $table->unique(['idUsuario', 'idTopico']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topicos_users');
    }
};
