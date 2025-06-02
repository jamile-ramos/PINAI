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
}
