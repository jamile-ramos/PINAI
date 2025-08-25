<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'nomeArquivo',
        'descricao',
        'caminhoArquivo',
        'status',
        'idUsuario',
        'idCategoria',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function categoria_documento()
    {
        return $this->belongsTo(CategoriaDocumento::class, 'idCategoria');
    }

    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }
}
