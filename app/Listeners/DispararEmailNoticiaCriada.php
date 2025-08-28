<?php

namespace App\Listeners;

use App\Events\NoticiaCriada;
use App\Models\User;
use App\Notifications\NovaNoticiaNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class DispararEmailNoticiaCriada
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
    public function handle(NoticiaCriada $event): void
    {
        User::ativos()->where('id', '!=', Auth::id())->select('id', 'name', 'email')
        ->chunkById(500, function($users) use ($event){
            Notification::send($users, new NovaNoticiaNotification($event->noticia));
        });
    }
}
