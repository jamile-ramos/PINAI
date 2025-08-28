<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sugestao;
use App\Models\SugestaoTopico;
use App\Models\User;
use Illuminate\Support\Str;

class SugestaoTopicoSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all()->pluck('id')->toArray();

        $titulos = [
            'Adicionar atalhos de teclado para navegação rápida',
            'Implementar leitura de tela para usuários com baixa visão',
            'Criar versão com alto contraste para deficientes visuais',
            'Disponibilizar legendas em vídeos de tutoriais',
            'Adicionar feedback tátil em interações importantes',
            'Incluir guia passo a passo para usuários iniciantes',
            'Configuração de cores personalizáveis para dislexia',
            'Alertas sonoros para notificações críticas',
            'Permitir controle por voz para usuários com mobilidade reduzida',
            'Adicionar botão de acessibilidade na barra principal',
        ];

        foreach ($titulos as $titulo) {
            SugestaoTopico::create([
                'titulo' => $titulo,
                'status_situacao' => fake()->randomElement(['pendente', 'aprovado', 'reprovado']),
                'status' => fake()->randomElement(['ativo', 'inativo']),
                'idUsuario' => $usuarios[array_rand($usuarios)],
            ]);
        }
    }
}
