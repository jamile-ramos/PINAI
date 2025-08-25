<?php

namespace App\Listeners;

use App\Events\ConteudoExcluido;
use App\Models\User;
use App\Notifications\ConteudoExcluidoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class DispararNotificacaoExclusao
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
    public function handle(ConteudoExcluido $event): void
    {

        $users = User::ativos()->whereIn('tipoUsuario', ['admin','moderator'])->get();

        Notification::send($users, new ConteudoExcluidoNotification($event->titulo, $event->tipo));
    }
}
