<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaDocumento;
use App\Models\User;

class CategoriaDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $usuarioId = User::first()->id;

        $categorias = [
            'Manuais de Inclusão',
            'Guias de Acessibilidade',
            'Relatórios de Diversidade',
            'Documentos de Políticas Inclusivas',
            'Normas de Acessibilidade',
            'Estudos de Caso Inclusivos',
            'Pesquisas sobre Tecnologia Assistiva',
            'Legislação e Direitos',
            'Materiais Educacionais Adaptados',
            'Relatórios de Eventos Inclusivos',
        ];

        foreach ($categorias as $nome) {
            CategoriaDocumento::create([
                'nomeCategoria' => $nome,
                'status' => 'ativo',
                'idUsuario' => $usuarioId,
            ]);
        }
    }
}
