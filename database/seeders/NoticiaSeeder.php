<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noticia;
use App\Models\User;
use App\Models\CategoriaNoticia;
use Illuminate\Support\Str;

class NoticiaSeeder extends Seeder
{
    public function run(): void
    {
        // Pega todos os usuários e categorias disponíveis
        $usuarios = User::all()->pluck('id')->toArray();
        $categorias = CategoriaNoticia::all()->pluck('id')->toArray();

        $temas = [
            'Acessibilidade em escolas',
            'Tecnologias assistivas para todos',
            'Inclusão digital de pessoas com deficiência',
            'Direitos das pessoas com deficiência',
            'Eventos e workshops inclusivos',
            'Políticas públicas de inclusão',
            'Diversidade no ambiente de trabalho',
            'Saúde e acessibilidade',
            'Educação inclusiva para crianças',
            'Ferramentas de comunicação alternativa',
        ];

        foreach ($temas as $tema) {
            $titulo = $tema;
            Noticia::create([
                'titulo' => $titulo,
                'subtitulo' => fake()->sentence(),
                'slug' => Str::slug($titulo),
                'conteudo' => fake()->paragraphs(5, true),
                'imagem' => null,
                'status' => 'ativo', // ou pode alternar com fake()->randomElement(['ativo','inativo'])
                'idUsuario' => $usuarios[array_rand($usuarios)],
                'idCategoria' => $categorias[array_rand($categorias)],
            ]);
        }
    }
}
