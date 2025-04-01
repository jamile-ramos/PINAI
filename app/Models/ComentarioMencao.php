<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComentarioMencao extends Model
{
    protected $table = 'comentarios_mencoes';

    protected $fillable = [
        'idComentario',
        'idUsuarioMencionado',
        'idUsuarioMencionou',
    ];

    public function comentario(){
        return $this->belongsTo(Comentario::class);
    }
}
