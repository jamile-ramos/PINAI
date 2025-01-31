<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Noticia extends Model
{
    protected $fillable = [
        'titulo', 
        'subtitulo', 
        'conteudo',
        'imagem', 
        'idCategoria'
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaNoticia::class, 'idCategoria'); 
    }

    public function user() {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
