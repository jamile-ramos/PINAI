<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaSolucao extends Model
{
    protected $table = 'categorias_solucoes';

    protected $fillable = [
        'status'
    ];

    public function solucoes(){
        return $this->hasMany(Solucao::class, 'idCategoria');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function scopeAtivos($query){
        return $query->where('status', 'ativo');
    }
}
