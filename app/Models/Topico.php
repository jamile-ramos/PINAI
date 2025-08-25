<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Topico extends Model
{

    use HasSlug;

    protected $fillable = ['titulo', 'status', 'slug', 'idUsuario'];

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

    public function getUltimaAtividadeAttribute()
    {
        $lastPost = $this->postagens()->latest('updated_at')->value('updated_at');
        return $lastPost ?? $this->updated_at;
    }

    // Scope para ordenar por última atividade.
    public function scopeUltimaAtividade($query)
    {
        return $query
            ->addSelect('topicos.*') // <-- garante que traz todas as colunas
            ->addSelect([
                'ultimaAtividade' => DB::raw('GREATEST(
                topicos.updated_at,
                IFNULL((SELECT MAX(p.updated_at) FROM postagens p WHERE p.idTopico = topicos.id), topicos.updated_at)
            )')
            ])
            ->orderByRaw('GREATEST(
            topicos.updated_at,
            IFNULL((SELECT MAX(p.updated_at) FROM postagens p WHERE p.idTopico = topicos.id), topicos.updated_at)
        ) DESC');
    }
}
