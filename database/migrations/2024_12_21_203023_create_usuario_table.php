<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('tipousuario', ['admin', 'comum'])-> default('comum');
            $table->string('nome', 255);
            $table->string('email', 255)->unique();
            $table->string('senha',255) ;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};