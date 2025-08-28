<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaSolucao;
use App\Models\User;

class CategoriaSolucaoSeeder extends Seeder
{
    public function run(): void
    {
        $usuarioId = User::first()->id;

        $categorias = [
            'Recursos Educacionais Acessíveis',
            'Softwares de Inclusão',
            'Acessibilidade em Sites',
            'Ferramentas de Comunicação Alternativa',
            'Treinamentos Inclusivos',
            'Adaptações de Espaços',
            'Soluções de Mobilidade',
            'Integração Social',
            'Tecnologia para Deficiência Visual',
            'Tecnologia para Deficiência Auditiva',
        ];

        foreach ($categorias as $nome) {
            CategoriaSolucao::create([
                'nomeCategoria' => $nome,
                'status' => 'ativo',
                'idUsuario' => $usuarioId,
            ]);
        }
    }
}
