<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipoUsuario',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function noticias() {
        return $this->hasMany(Noticia::class, 'idUsuario');
    }   
    
    public function topicos()
    {
        return $this->belongsToMany(Topico::class)->withPivot('status')->withTimestamps();
    } 

    public function respostas(){
        return $this->hasMany(Resposta::class, 'idUsuario');
    }

    public function comentarios(){
        return $this->hasMany(Comentario::class, 'idUsuario');
    }

    public function comentariosMencionados()
    {
        return $this->belongsToMany(Comentario::class, 'comentarios_mencoes', 'idUsuarioMencionado', 'idComentario');
    }

    public function documentos(){
        return $this->hasMany(Documento::class);
    }

    public function categoria_documento(){
        return $this->hasMany(CategoriaDocumento::class);
    }

    public function solucoes(){
        return $this->hasMany(Solucao::class, 'idUsuario');
    }

    public function nai(){
        return $this->belongsTo(Nai::class, 'idNai');
    }


}
