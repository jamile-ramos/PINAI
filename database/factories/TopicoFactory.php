<?php

namespace Database\Factories;

use App\Models\Topico;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TopicoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topico::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titulo = fake()->sentence();
        return [
            'titulo' => $titulo,
            'slug' => Str::slug($titulo),
            'status' => fake()->randomElement(['ativo', 'inativo']),
            'idUsuario' => \App\Models\User::factory(),
        ];
    }
}