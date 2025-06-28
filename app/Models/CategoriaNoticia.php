<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaNoticia extends Model
{
    use HasFactory;

    protected $table = 'categorias_noticias';

    protected $fillable = [
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function noticias(): HasMany
    {
        return $this->hasMany(Noticia::class, 'idCategoria'); 
    }

    //Laravel detecta automaticamente os métodos que começam com scope como query scopes. Então, scopeAtivos() se transforma em ativos() quando você chama ele no controller.
    // O $query é automaticamente injetado pelo Laravel, logo o proprio laravel ja fala que query nesse caso é User ou Nai.
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }
}
