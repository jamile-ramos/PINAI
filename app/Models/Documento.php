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

    use HasSlug;

    protected string $slugFrom = 'nomeArquivo';

    // Ajudante para gerar URL
    public function getUrlAttribute(): string
    {
        return route('documentos.show', ['id' => $this->id, 'slug' => $this->slug]);
    }

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
