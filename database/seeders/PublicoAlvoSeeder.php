<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicoAlvo;
use Illuminate\Support\Str;

class PublicoAlvoSeeder extends Seeder
{
    public function run(): void
    {
        $publicos = [
            'Usuários com deficiência visual',
            'Usuários com deficiência auditiva',
            'Usuários com mobilidade reduzida',
            'Usuários idosos',
            'Usuários com dislexia',
            'Usuários com baixa visão',
            'Usuários com deficiência motora',
            'Usuários com deficiência cognitiva',
            'Usuários surdos',
            'Usuários com necessidades especiais de leitura',
        ];

        foreach ($publicos as $nome) {
            PublicoAlvo::create([
                'nome' => $nome,
                'descricao' => fake()->paragraph(),
                'status' => 'ativo',
            ]);
        }
    }
}
