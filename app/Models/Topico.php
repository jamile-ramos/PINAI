<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topico extends Model
{
    protected $fillable = ['titulo', 'status', 'slug'];

    // Ajudante para gerar URL
    public function getUrlAttribute(): string
    {
        return route('topicos.show', ['id' => $this->id, 'slug' => $this->slug]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function postagens()
    {
        return $this->hasMany(Postagem::class, 'idTopico');
    }

    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }
}
