<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solucao;
use App\Models\User;
use App\Models\CategoriaSolucao;
use Illuminate\Support\Str;

class SolucaoSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all()->pluck('id')->toArray();
        $categorias = CategoriaSolucao::all()->pluck('id')->toArray();

        $titulos = [
            'Interface amigável para deficientes visuais',
            'Teclado adaptado para mobilidade reduzida',
            'Leitura de tela para usuários com baixa visão',
            'Alertas sonoros para usuários surdos',
            'Menus simplificados para dislexia',
            'Atalhos de acessibilidade para idosos',
            'Controle por voz para navegação',
            'Configurações de contraste e cores',
            'Feedback tátil para interação',
            'Tutorial acessível passo a passo',
        ];

        foreach ($titulos as $titulo) {
            Solucao::create([
                'titulo' => $titulo,
                'slug' => Str::slug($titulo),
                'descricao' => fake()->paragraph(),
                'passosImplementacao' => fake()->paragraphs(3, true),
                'arquivo' => 'solucoes/' . Str::slug($titulo) . '-' . Str::random(6) . '.pdf',
                'status' => 'ativo', 
                'idUsuario' => $usuarios[array_rand($usuarios)],
                'idCategoria' => $categorias[array_rand($categorias)],
            ]);
        }
    }
}
