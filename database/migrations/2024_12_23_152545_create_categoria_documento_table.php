<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categoria_documento', function (Blueprint $table) {
            $table->id();
            $table->string('nomeCategoria', 255);
            $table->foreignId('idUsuario')->constrained('usuario')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoria_documento');
    }
};
