<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('nais', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('instituicao');
            $table->string('siglaInstituicao')->nullable();
            $table->string('estado', 2);
            $table->string('cidade');
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('site')->nullable();
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nais');
    }
};
