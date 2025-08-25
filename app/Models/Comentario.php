<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'conteudo',
        'status',
        'idResposta',
        'idUsuario'
    ];

    public function resposta()
    {
        return $this->belongsTo(Resposta::class, 'idResposta');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
    public function mencoes()
    {
        return $this->belongsToMany(User::class, 'comentarios_mencoes', 'idComentario', 'idUsuarioMencionado')
            ->withPivot('idUsuarioMencionou')
            ->withTimestamps();
    }

    public function podeEditar()
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        if ($user->tipoUsuario !== 'comum') {
            return true;
        }

        return $user->id === $this->idUsuario && $this->created_at->gt(now()->subHour());
    }


    public function getConteudoFormatadoAttribute()
    {
        // Escapa tudo
        $html = e($this->conteudo);

        foreach ($this->mencoes as $mencao) {
            $nome = $mencao->name;

            if (!$nome) {
                continue;
            }

            $pattern = '/@' . preg_quote($nome, '/') . '\b/u';
            $replacement = '<span class="mention text-primary fw-bold">@' . e($nome) . '</span>';

            $html = preg_replace($pattern, $replacement, $html);
        }

        return nl2br($html);
    }




    // helper para substituir só a primeira ocorrência de uma string
    private function strReplaceFirst(string $search, string $replace, string $subject): string
    {
        $pos = strpos($subject, $search);
        if ($pos === false) {
            return $subject;
        }
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
}
