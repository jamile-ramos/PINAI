<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Documento;

class CategoriaDocumento extends Model
{
    protected $table = 'categorias_documentos';

    protected $fillable = [
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'idCategoria');
    }

    public function scopeAtivos($query){
        return $this->where('status', 'ativo');
    }

    
}
