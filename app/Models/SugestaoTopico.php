<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SugestaoTopico extends Model
{
    protected $table = 'sugestoes_topicos';

    protected $appends = ['status_nome'];

    public function getStatusNomeAttribute(){
        return match ($this->status) {
            1 => 'Aprovado',
            2 => 'Rejeitado',
            default => 'Pendente',
        };
    }

}
