<?php

namespace App\Listeners;

use App\Events\UsuarioAtivo;
use App\Models\User;
use App\Notifications\UsuarioAtivoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DispararEmailUsuarioAtivo
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
    public function handle(UsuarioAtivo $event): void
    {
        Notification::send($event->user, new UsuarioAtivoNotification($event->user));
    }
}
