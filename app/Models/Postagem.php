<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postagem extends Model
{

    use HasSlug;
    use HasFactory;

    protected $table = 'postagens';

    protected $fillable = [
        'titulo',
        'conteudo',
        'idTopico',
        'status',
        'imagem',
        'slug'
    ];

        // Ajudante para gerar URL
        public function getUrlAttribute(): string
        {
            return route('postagens.show', ['id' => $this->id, 'slug' => $this->slug]);
        }
    
    
    public function topico(){
        return $this->belongsTo(Topico::class, 'idTopico');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function respostas(){
        return $this->hasMany(Resposta::class, 'idPostagem');
    }

    public function scopeAtivos($query){
        return $query->where('status', 'ativo');
    }
}
