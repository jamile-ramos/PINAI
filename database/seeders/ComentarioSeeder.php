<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comentario;
use App\Models\Resposta;
use App\Models\User;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all()->pluck('id')->toArray();
        $respostas = Resposta::all();

        foreach ($respostas as $resposta) {
            // Criar 3 comentários para cada resposta
            for ($i = 0; $i < 3; $i++) {
                Comentario::create([
                    'conteudo' => fake()->paragraph(),
                    'status' => 'ativo', // ou fake()->randomElement(['ativo','inativo'])
                    'idUsuario' => $usuarios[array_rand($usuarios)],
                    'idResposta' => $resposta->id,
                ]);
            }
        }
    }
}
