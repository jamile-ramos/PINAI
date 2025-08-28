<?php

namespace App\Listeners;

use App\Events\UsuarioInativo;
use App\Notifications\UsuarioInativoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class DispararEmailUsuarioInativo
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
    public function handle(usuarioInativo $event): void
    {
        FacadesNotification::send($event->user, new UsuarioInativoNotification($event->user));
    }
}
