<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_documento', function (Blueprint $table) {
            $table->foreignId('idUsuario')->constrained('usuario')->onDelete('cascade');
            $table->foreignId('idDocumento')->constrained('documento')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_documento');
    }
};
