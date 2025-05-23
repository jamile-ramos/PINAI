<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('postagens', function (Blueprint $table) {
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
        });
    }

    public function down(): void
    {
        Schema::table('postagens', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
