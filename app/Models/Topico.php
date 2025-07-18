<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topico extends Model
{
    protected $fillable = ['titulo', 'status'];

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function postagens(){
        return $this->hasMany(Postagem::class, 'idTopico');
    }

    public function scopeAtivos($query){
        return $query->where('status', 'ativo');
    }
}

