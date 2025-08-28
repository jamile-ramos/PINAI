<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Postagem;
use App\Models\User;
use App\Models\Topico;
use Illuminate\Support\Str;

class PostagemSeeder extends Seeder
{
    public function run(): void
    {
        // Pega todos os usuários e tópicos disponíveis
        $usuarios = User::all()->pluck('id')->toArray();
        $topicos = Topico::all()->pluck('id')->toArray();

        $temas = [
            'Melhorias na acessibilidade digital',
            'Ferramentas de apoio em sala de aula',
            'Inclusão de pessoas com deficiência no trabalho',
            'Comunicação alternativa e aumentativa',
            'Experiências com tecnologia assistiva',
            'Eventos de inclusão social',
            'Políticas públicas de acessibilidade',
            'Educação inclusiva e práticas inovadoras',
            'Dicas para transporte acessível',
            'Integração social de pessoas com deficiência',
        ];

        foreach ($temas as $tema) {
            $titulo = $tema;
            Postagem::create([
                'titulo' => $titulo,
                'slug' => Str::slug($titulo),
                'conteudo' => fake()->paragraphs(2, true),
                'status' => 'ativo', // ou pode alternar com fake()->randomElement(['ativo','inativo'])
                'idUsuario' => $usuarios[array_rand($usuarios)],
                'idTopico' => $topicos[array_rand($topicos)],
            ]);
        }
    }
}
