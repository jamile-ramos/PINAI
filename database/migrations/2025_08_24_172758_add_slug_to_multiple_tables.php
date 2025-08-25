<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('multiple_tables', function (Blueprint $table) {
            $tables = ['noticias', 'solucoes', 'postagens', 'topicos'];

            foreach ($tables as $table) {
                Schema::table($table, function (Blueprint $table) {
                    $table->string('slug')->after('titulo');
                });
            }
        });
    }

    public function down(): void
    {
        Schema::table('multiple_tables', function (Blueprint $table) {
            $tables = ['noticias', 'solucoes', 'postagens', 'topicos'];

            foreach ($tables as $table) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('slug');
                });
            }
        });
    }
};
