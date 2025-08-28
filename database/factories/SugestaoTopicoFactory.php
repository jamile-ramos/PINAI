<?php

namespace Database\Factories;

use App\Models\SugestaoTopico;
use Illuminate\Database\Eloquent\Factories\Factory;

class SugestaoTopicoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SugestaoTopico::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => fake()->sentence(),
            'status_situacao' => fake()->randomElement(['pendente', 'aprovado', 'reprovado']),
            'status' => fake()->randomElement(['ativo', 'inativo']),
            'idUsuario' => \App\Models\User::factory(),
        ];
    }
}