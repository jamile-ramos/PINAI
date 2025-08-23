<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'conteudo',
        'status'
    ];

    public function resposta()
    {
        return $this->belongsTo(Resposta::class, 'idResposta');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function mencoes(){
        return $this->belongsToMany(User::class, 'comentarios_mencoes', 'idComentario', 'idUsuarioMencionado');
    }

    public function podeEditar(){
        $user = Auth::user();

        if($user && $user->tipoUsuario !== 'comum'){
            return true;
        }

        return $user && $user->id === $this->idUsuario && $this->created_at->gt(now()->subHour());
    }
}

