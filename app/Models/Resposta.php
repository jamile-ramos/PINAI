<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Resposta extends Model
{
    protected $fillable = [
        'status',
        'conteudo'
    ];


    public function postagem(){
        return $this->belongsTo(Postagem::class, 'idPostagem');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idResposta');
    }

    public function podeEditar(){
        $user = Auth::user();

        if($user && $user->tipoUsuario !== 'comum'){
            return true;
        }

        return $user && $user->id === $this->idUsuario;
    }
    
}
