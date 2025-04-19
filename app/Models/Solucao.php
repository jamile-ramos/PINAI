<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solucao extends Model
{
    public function categoria_solucao(){
        return $this->belongsTo(CategoriaSolucao::class, 'idCategoria');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
