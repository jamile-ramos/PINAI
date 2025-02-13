<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    public function postagem(){
        return $this->belongsTo(Postagem::class, 'idPostagem');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function comentarios(){
        return $this->hasMany(Resposta::class, 'idResposta');
    }
}
