<?php

namespace App\Listeners;

use App\Events\TopicoCriado;
use App\Models\User;
use App\Notifications\NovoTopicoNotification;
use Illuminate\Support\Facades\Notification;

class DispararEmailTopicoCriado
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
    public function handle(TopicoCriado $event): void
    {
        User::ativos()->select('id','name', 'email')
        ->chunkById(500, function($users) use ($event){
            Notification::send($users, new NovoTopicoNotification($event->topico));
        });
    }
}
