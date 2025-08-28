<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resposta;
use App\Models\Postagem;
use App\Models\User;

class RespostaSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all()->pluck('id')->toArray();
        $postagens = Postagem::all();

        foreach ($postagens as $postagem) {
            // Criar 5 respostas para cada postagem
            for ($i = 0; $i < 5; $i++) {
                Resposta::create([
                    'conteudo' => fake()->paragraph(),
                    'status' => 'ativo', // ou fake()->randomElement(['ativo','inativo'])
                    'idUsuario' => $usuarios[array_rand($usuarios)],
                    'idPostagem' => $postagem->id,
                ]);
            }
        }
    }
}
