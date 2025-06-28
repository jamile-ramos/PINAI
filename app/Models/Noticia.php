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
        'idCategoria',
        'status',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaNoticia::class, 'idCategoria');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    //Laravel detecta automaticamente os métodos que começam com scope como query scopes. Então, scopeAtivos() se transforma em ativos() quando você chama ele no controller.
    // O $query é automaticamente injetado pelo Laravel, logo o proprio laravel ja fala que query nesse caso é User ou Nai.
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }
}
