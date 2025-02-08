<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SugestaoTopico extends Model
{
    protected $table = 'sugestoes_topicos';

    protected $fillable = ['status'];

    public function getStatusNomeAttribute(): string
    {
        $statusMap = [
            0 => 'Pendente',
            1 => 'Aprovado',
            2 => 'Reprovado',
        ];

        return $statusMap[$this->status] ?? 'Desconhecido'; 
    }
}
