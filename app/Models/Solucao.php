<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solucao extends Model
{

    protected $table = 'solucoes';

    protected $fillable = [
        'titulo', 
        'descricao',
        'passosImplementacao',
        'arquivo',
        'idPublicoAlvo',
        'idCategoria',
        'idUsuario'
    ];

    public function categoria(){
        return $this->belongsTo(CategoriaSolucao::class, 'idCategoria');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function publicosAlvo(){
        return $this->belongsToMany(PublicoAlvo::class, 'publicos_alvo_solucoes', 'idSolucao', 'idPublicoAlvo')->withTimestamps();
    }

    public function scopeAtivos($query){
        return $query->where('status', 'ativo');
    }
}
