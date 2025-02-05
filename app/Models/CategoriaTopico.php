<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaTopico extends Model
{
    protected $table = 'categorias_topicos';

    public function user() {
        return $this->belongsTo(User::class, 'idUsuario');
    }

}
