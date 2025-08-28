<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Documento extends Model
{
    protected $fillable = [
        'nomeArquivo',
        'descricao',
        'caminhoArquivo',
        'status',
        'idUsuario',
        'idCategoria',
        'slug',
        'link'
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

    public static function buscarMeusDocumentos($query, $pagina, $abaAtiva, $perPage = 9)
    {
        $resultados = Documento::ativos()
            ->where('idUsuario', Auth::user()->id);

        if (!empty($query)) {
            $resultados->where(function ($q) use ($query) {
                $q->where('nomeArquivo', 'like', '%' . $query . '%')
                    ->orWhere('descricao', 'like', '%' . $query . '%');
            });
        }

        return $resultados->paginate($perPage, ['*'], 'myDocumentos_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }
}
