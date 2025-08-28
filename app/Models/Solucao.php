<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Solucao extends Model
{
    use HasSlug;
    use HasFactory;

    protected $table = 'solucoes';

    protected $fillable = [
        'titulo',
        'descricao',
        'passosImplementacao',
        'arquivo',
        'idPublicoAlvo',
        'idCategoria',
        'idUsuario',
        'slug'
    ];

    // Ajudante para gerar URL
    public function getUrlAttribute(): string
    {
        return route('solucoes.show', ['id' => $this->id, 'slug' => $this->slug]);
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaSolucao::class, 'idCategoria');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function publicosAlvo()
    {
        return $this->belongsToMany(PublicoAlvo::class, 'publicos_alvo_solucoes', 'idSolucao', 'idPublicoAlvo')->withTimestamps();
    }

    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public static function buscarMinhasSolucoes($query, $pagina, $abaAtiva, $perPage = 10)
    {
        $resultado = Solucao::ativos()
        ->where('idUsuario', Auth::user()->id);

        if(!empty($query)){
            $resultado->where('titulo', 'like', '%' . $query . '%');
        }

        return $resultado->paginate($perPage, ['*'], 'mySolucoes_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }
}
