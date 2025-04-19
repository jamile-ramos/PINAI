<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('solucoes', function (Blueprint $table) {
            $table->dropForeign(['idPublicoAlvo']);
            $table->dropColumn('idPublicoAlvo');
        });
    }

    public function down(): void
    {
        Schema::table('solucoes', function (Blueprint $table) {
            $table->unsignedBigInteger('idPublicoAlvo')->nullable();

            $table->foreign('idPublicoAlvo')->references('id')->on('publicos_alvo')->onDelete('set null');
        });
    }
};
