<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaNoticia extends Model
{
    use HasFactory;

    protected $table = 'categorias_noticias';

    public function user() {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function categoriaNoticia(){
        return $this->belongsTo(CategoriaNoticia::class, 'idUsuario');
    }
}
