<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicoAlvo extends Model
{
    protected $table = 'publicos_alvo';

    protected $fillable = [
        'nome', 
        'descricao'
    ];

    public function solucoes(){
        return $this->belongsToMany(Solucao::class, 'publicos_alvo_solucoes', 'idPublicoAlvo', 'idSolucao')->withTimestamps();
    }
}
