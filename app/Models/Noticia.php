<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    public function categoriaNoticia(){
        return $this->belongsTo(CategoriaNoticia::class, 'idCategoriaNoticia');
    }
}
