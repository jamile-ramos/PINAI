<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaNoticia extends Model
{
    use HasFactory;

    protected $table = 'categorias_noticias';

    public function user() {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function noticias(): HasMany
    {
        return $this->hasMany(Noticia::class, 'idCategoria'); 
    }
}
