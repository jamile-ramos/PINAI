<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('nais', function (Blueprint $table) {
            $table->string('siglaNai', 10);
        });
    }

    public function down(): void
    {
        Schema::table('nais', function (Blueprint $table) {
            $table->dropColumn('siglaNai');
        });
    }
};
