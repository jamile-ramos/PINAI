<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    public function respostas(){
        return $this->belongsTo(Resposta::class, 'idComentario');
    }
}
