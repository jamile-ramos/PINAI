<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Nai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $senhaPadrao = Hash::make('12345678@');

        $nais = Nai::pluck('id')->toArray(); // Pega todos os IDs de NAIs disponíveis

        // Usuário Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => $senhaPadrao,
            'tipoUsuario' => 'admin',
            'status' => 'ativo',
            'idNai' => $nais[array_rand($nais)],
        ]);

        // Usuário Moderador
        User::create([
            'name' => 'Moderador User',
            'email' => 'moderador@example.com',
            'password' => $senhaPadrao,
            'tipoUsuario' => 'moderador',
            'status' => 'ativo',
            'idNai' => $nais[array_rand($nais)],
        ]);

        // Usuário Comum
        User::create([
            'name' => 'Comum User',
            'email' => 'comum@example.com',
            'password' => $senhaPadrao,
            'tipoUsuario' => 'comum',
            'status' => 'ativo',
            'idNai' => $nais[array_rand($nais)],
        ]);

        // Cria mais 7 usuários aleatórios
        for ($i = 1; $i <= 7; $i++) {
            User::create([
                'name' => "Usuário $i",
                'email' => "usuario{$i}@example.com",
                'password' => $senhaPadrao,
                'tipoUsuario' => 'comum',
                'status' => 'ativo',
                'idNai' => $nais[array_rand($nais)],
            ]);
        }
    }
}
