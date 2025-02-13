<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    public function resposta()
    {
        return $this->belongsTo(Resposta::class, 'idResposta');
    }    

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
