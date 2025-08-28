<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Documento;
use App\Models\User;
use App\Models\CategoriaDocumento;
use Illuminate\Support\Str;

class DocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all()->pluck('id')->toArray();
        $categorias = CategoriaDocumento::all()->pluck('id')->toArray();

        $nomesFicticios = [
            'Guia de Acessibilidade Web',
            'Manual de Inclusão Escolar',
            'Diretrizes de Design Universal',
            'Plano de Acessibilidade Corporativa',
            'Relatório de Inclusão Digital',
            'Boas Práticas para Educação Inclusiva',
            'Guia de Comunicação Acessível',
            'Checklist de Acessibilidade em Eventos',
            'Procedimentos de Inclusão Social',
            'Estratégias de Design para Todos',
        ];

        foreach ($nomesFicticios as $nome) {
            Documento::create([
                'nomeArquivo' => $nome,
                'descricao' => substr(fake()->paragraph(), 0, 150),
                'caminhoArquivo' => 'documentos/' . Str::slug($nome) . '-' . Str::random(6) . '.pdf',
                'status' => 'ativo', // ou fake()->randomElement(['publicado', 'rascunho'])
                'idUsuario' => $usuarios[array_rand($usuarios)],
                'idCategoria' => $categorias[array_rand($categorias)],
            ]);
        }
    }
}
