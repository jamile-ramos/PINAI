<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Lang;

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
        'idNai'
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

    public function noticias()
    {
        return $this->hasMany(Noticia::class, 'idUsuario');
    }

    public function topicos()
    {
        return $this->belongsToMany(Topico::class)->withPivot('status')->withTimestamps();
    }

    public function respostas()
    {
        return $this->hasMany(Resposta::class, 'idUsuario');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idUsuario');
    }

    public function comentariosMencionados()
    {
        return $this->belongsToMany(Comentario::class, 'comentarios_mencoes', 'idUsuarioMencionado', 'idComentario');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function categoria_documento()
    {
        return $this->hasMany(CategoriaDocumento::class);
    }

    public function solucoes()
    {
        return $this->hasMany(Solucao::class, 'idUsuario');
    }

    public function nai()
    {
        return $this->belongsTo(Nai::class, 'idNai', 'id');
    }

    //Laravel detecta automaticamente os métodos que começam com scope como query scopes. Então, scopeAtivos() se transforma em ativos() quando você chama ele no controller.
    // O $query é automaticamente injetado pelo Laravel, logo o proprio laravel ja fala que query nesse caso é User ou Nai.
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function isComum()
    {
        return $this->tipoUsuario === 'comum';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function isAdmin(): bool
    {
        return $this->tipoUsuario === 'admin';
    }
    public function isModerador(): bool
    {
        return $this->tipoUsuario === 'moderador';
    }

    public function scopeAdmins($q)
    {
        return $q->where('role', 'admin');
    }
    public function scopeModerators($q)
    {
        return $q->where('role', 'moderator');
    }


    public function notificacoes()
    {
        // pega todas não lidas
        $naoLidas = $this->unreadNotifications;

        if ($naoLidas->isEmpty()) {
            return collect(); 
        }

        // Agrupa por tipo de notificação
        $porTipo = $naoLidas->groupBy(fn($n) => $n->data['type'] ?? 'default');

        $resultado = [];

        foreach ($porTipo as $tipo => $notificacoes) {
            // notificacoes de cada grupo
            $qtd = $notificacoes->count();

            if ($qtd === 1) {
                $n = $notificacoes->first();
                $resultado[] = [
                    'id'         => $n->id, 
                    'qtd' => 1,
                    'icon'       => $n->data['icon'] ?? 'fas fa-bell',
                    'badgeClass' => $n->data['badgeClass'] ?? 'notif-primary',
                    'title'      => $n->data['title'] ?? 'Nova notificação',
                    'message'    => $n->data['message'] ?? '',
                    'time'       => $n->created_at->diffForHumans(),
                    'url'        => $n->data['url'] ?? '#',
                ];
            } else {
                $topico = 0;
                if($tipo == 'nova.postagem'){
                    $topico = Topico::findOrFail($notificacoes->first()->data['idTopico']);
                }
            
                $resultado[] = [
                    'id'         => $notificacoes->first()->id, 
                    'qtd' => $qtd,
                    'icon'       => $notificacoes->first()->data['icon'] ?? 'fas fa-bell',
                    'badgeClass' => $notificacoes->first()->data['badgeClass'] ?? 'notif-primary',
                    'title'      => "$qtd " . match ($tipo) {
                        'nova.noticia' => 'notícias publicadas',
                        'novo.topico'  => 'tópicos criados',
                        'nova.solucao' => 'soluções adicionadas',
                        'nova.postagem' => 'postagens criadas',
                        'novo.documento' => 'documentos adicionados',
                        'novo.comentario' => 'menções em comentários',
                        'novo.nai' => 'nais adicionados',
                        default        => 'notificações',
                    },
                    'message'    => '',
                    'time'       => 'Agora mesmo',
                    'url'        => match ($tipo) {
                        'nova.noticia' => route('noticias.index'),
                        'nova.solucao' => route('solucoes.index'),
                        'novo.documento' => route('documentos.index'),
                        'nova.postagem' => route('topicos.show', ['id' => $topico->id, 'slug' => $topico->slug ]),
                        'novo.topico' => route('topicos.index'),
                        'novo.comentario' => route('topicos.index'),
                        'novo.nai' => route('painel.usuarios'),
                        default        => route('notificacoes.index'),
                    },
                ];
            }            
        }

        return collect($resultado);
    }
}
