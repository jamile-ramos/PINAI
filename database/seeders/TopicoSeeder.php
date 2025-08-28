<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topico;
use App\Models\User;
use Illuminate\Support\Str;

class TopicoSeeder extends Seeder
{
    public function run(): void
    {
        // Pega todos os usuários disponíveis
        $usuarios = User::all()->pluck('id')->toArray();

        $temas = [
            'Como melhorar a acessibilidade em sites',
            'Ferramentas de apoio para educação inclusiva',
            'Dicas para inclusão no ambiente de trabalho',
            'Comunicação alternativa para pessoas com deficiência',
            'Experiências com tecnologia assistiva',
            'Eventos e workshops sobre inclusão',
            'Direitos e políticas públicas de acessibilidade',
            'Integração social de pessoas com deficiência',
            'Acessibilidade em transportes públicos',
            'Educação inclusiva: desafios e soluções',
        ];

        foreach ($temas as $tema) {
            $titulo = $tema;
            Topico::create([
                'titulo' => $titulo,
                'slug' => Str::slug($titulo),
                'status' => 'ativo', // pode alternar com fake()->randomElement(['ativo','inativo'])
                'idUsuario' => $usuarios[array_rand($usuarios)],
            ]);
        }
    }
}
