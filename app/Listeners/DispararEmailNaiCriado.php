<?php

namespace App\Listeners;

use App\Events\NaiCriado;
use App\Models\User;
use App\Notifications\NaiCriadoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class DispararEmailNaiCriado
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
    public function handle(NaiCriado $event): void
    {
        $users = User::ativos()
            ->where('tipoUsuario', 'admin')
            ->get();
        Notification::send($users, new NaiCriadoNotification($event->nai));
    }
}
