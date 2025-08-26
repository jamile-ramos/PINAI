<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Noticia extends Model
{
    protected $fillable = [
        'titulo',
        'subtitulo',
        'conteudo',
        'imagem',
        'idCategoria',
        'status',
        'slug'
    ];

    use HasSlug;

    // Ajudante para gerar URL
    public function getUrlAttribute(): string
    {
        return route('noticias.show', ['id' => $this->id, 'slug' => $this->slug]);
    }

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

    // Coloquei essa busca aqui para ser possivel reutilizar em Profile
    public static function buscarMinhasNoticias($query, $pagina, $abaAtiva, $perPage = 10)
    {
        $resultado = self::ativos()
            ->with('categoria')
            ->where('idUsuario', Auth::user()->id);

        if (!empty($query)) {
            $resultado->where(function ($q) use ($query) {
                $q->where('titulo', 'like', '%' . $query . '%')
                    ->orWhereHas('categoria', function ($sub) use ($query) {
                        $sub->where('nomeCategoria', 'like', '%' . $query . '%');
                    });
            });
        }

        return $resultado->paginate($perPage, ['*'], 'myNoticias_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }
}
