<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    public function categoria(){
        return $this->belongsTo(CategoriaNoticia::class, 'idCategoria');
    }

    protected $fillable = [
        'titulo', 
        'subtitulo', 
        'conteudo',
        'imagem', 
        'idCategoria'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
