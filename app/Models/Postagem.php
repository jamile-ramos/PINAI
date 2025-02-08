<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postagem extends Model
{
    protected $table = 'postagens';
    
    public function topico(){
        return $this->belongsTo(Topico::class, 'idTopico');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
