<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SugestaoTopico extends Model
{
    protected $table = 'sugestoes_topicos';

    protected $fillable = ['status', 'status_situacao'];

public function getStatusSituacaoAttribute(): string
{
    $statusMap = [
        'pendente' => 'Pendente',
        'aprovado' => 'Aprovado',
        'reprovado' => 'Reprovado',
    ];

    $valor = $this->attributes['status_situacao'] ?? '';

    return $statusMap[$valor] ?? 'Desconhecido';
}

}
