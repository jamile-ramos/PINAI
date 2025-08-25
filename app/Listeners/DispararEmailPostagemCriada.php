<?php

namespace App\Listeners;

use App\Events\PostagemCriada;
use App\Models\User;
use App\Notifications\NovaPostagemNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class DispararEmailPostagemCriada
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
    public function handle(PostagemCriada $event): void
    {
        $topico = $event->postagem->topico;
        $usersIds = $topico->postagens()->pluck('idUsuario')->unique();
        $users = User::whereIn('id', $usersIds)->get();
        Notification::send($users, new NovaPostagemNotification($event->postagem));
    }
}
