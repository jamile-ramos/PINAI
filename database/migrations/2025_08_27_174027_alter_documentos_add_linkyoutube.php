<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->text('caminhoArquivo')->nullable()->change();
            $table->string('link', 255)->nullable()->after('caminhoArquivo');
            $table->string('descricao', 150)->change();
        });
    }

    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->text('caminhoArquivo')->nullable(false)->change();
            $table->dropColumn('link');
            $table->text('descricao')->change();
        });
    }
};
