<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['noticias', 'solucoes', 'postagens', 'topicos'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                // adiciona a coluna slug única
                $blueprint->string('slug')->unique()->after('titulo');
            });
        }
    }

    public function down(): void
    {
        $tables = ['noticias', 'solucoes', 'postagens', 'topicos'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                // remove a constraint unique e a coluna slug
                $blueprint->dropUnique([$blueprint->getTable().'_slug_unique']);
                $blueprint->dropColumn('slug');
            });
        }
    }
};
