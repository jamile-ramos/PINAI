<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioMencao extends Model
{
    use HasFactory;

    protected $table = 'comentarios_mencoes';

    protected $fillable = [
        'idComentario',
        'idUsuarioMencionado',
        'idUsuarioMencionou',
    ];

    public function comentario()
    {
        return $this->belongsTo(Comentario::class, 'idComentario', 'id');
    }

    public function usuarioMencionado()
    {
        return $this->belongsTo(User::class, 'idUsuarioMencionado', 'id');
    }

    public function usuarioMencionou()
    {
        return $this->belongsTo(User::class, 'idUsuarioMencionou', 'id');
    }
}
