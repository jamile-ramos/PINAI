<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaNoticia;
use App\Models\User;

class CategoriaNoticiaSeeder extends Seeder
{
    public function run(): void
    {
        $usuarioId = User::first()->id; // Usuário responsável pelas categorias

        $categorias = [
            'Acessibilidade Digital',
            'Educação Inclusiva',
            'Tecnologias Assistivas',
            'Políticas de Inclusão',
            'Diversidade e Equidade',
            'Inclusão Social',
            'Saúde e Acessibilidade',
            'Inclusão no Trabalho',
            'Direitos das Pessoas com Deficiência',
            'Eventos Inclusivos',
        ];

        foreach ($categorias as $nome) {
            CategoriaNoticia::create([
                'nomeCategoria' => $nome,
                'status' => 'ativo',
                'idUsuario' => $usuarioId,
            ]);
        }
    }
}
