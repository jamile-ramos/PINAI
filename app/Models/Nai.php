<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nai extends Model
{

    protected $fillable = [
        'nome',
        'instituicao',
        'siglaInstituicao',
        'estado',
        'cidade',
        'email',
        'telefone',
        'site',
        'status',
        'siglaNai'
    ];

    public function users(){
        return $this->hasMany(User::class, 'idNai');
    }

    //Laravel detecta automaticamente os métodos que começam com scope como query scopes. Então, scopeAtivos() se transforma em ativos() quando você chama ele no controller.
    // O $query é automaticamente injetado pelo Laravel, logo o proprio laravel ja fala que query nesse caso é User ou Nai.
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

}
