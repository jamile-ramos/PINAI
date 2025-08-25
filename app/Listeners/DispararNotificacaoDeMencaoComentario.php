<?php

namespace App\Listeners;

use App\Events\UsuarioMencionado;
use App\Notifications\UsuarioMencionadoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DispararNotificacaoDeMencaoComentario
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UsuarioMencionado $event): void
    {
        $comentario = $event->comentario;

        // buscar os usuários mencionados no comentário
        foreach ($comentario->mencoes as $usuario) {
            $usuario->notify(new UsuarioMencionadoNotification($comentario));
        }
    }
}
