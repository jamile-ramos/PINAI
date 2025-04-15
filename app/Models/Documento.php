<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'nomeArquivo',
        'descricao',
        'caminhoArquivo',
        'status',
        'idUsuario',
        'idCategoria'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categoria_documento(){
        return $this->belongsTo(CategoriaDocumento::class, 'idCategoria');
    }
}
