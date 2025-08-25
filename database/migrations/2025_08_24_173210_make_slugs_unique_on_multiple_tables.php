<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        $tables = ['noticias', 'solucoes', 'postagens', 'topicos'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                // Checa se a coluna 'slug' já existe antes de tentar alterá-la.
                if (Schema::hasColumn($table, 'slug')) {
                    // Remove slugs duplicados antes de adicionar a restrição UNIQUE.
                    DB::statement("DELETE T1 FROM `{$table}` T1 INNER JOIN `{$table}` T2 WHERE T1.id > T2.id AND T1.slug = T2.slug;");

                    // Altera a coluna para ser única.
                    $blueprint->unique('slug');
                }
            });
        }
    }

    public function down(): void
    {
        $tables = ['noticias', 'solucoes', 'postagens', 'topicos'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                // Checa se a coluna 'slug' tem a restrição 'unique'.
                if (Schema::hasColumn($table, 'slug')) {
                    $sm = Schema::getConnection()->getDoctrineSchemaManager();
                    $indexes = $sm->listTableIndexes($table);
                    if (array_key_exists("{$table}_slug_unique", $indexes)) {
                        $blueprint->dropUnique(["slug"]);
                    }
                }
            });
        }
    }
};
