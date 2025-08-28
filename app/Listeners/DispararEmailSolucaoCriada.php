<?php

namespace App\Listeners;

use App\Events\SolucaoCriada;
use App\Models\User;
use App\Notifications\NovaSolucaoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DispararEmailSolucaoCriada
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
    public function handle(SolucaoCriada $event): void
    {
        User::ativos()->where('id', '!=', Auth::id())->select('id','name', 'email')
        ->chunkById(500, function($users) use ($event){
            Notification::send($users, new NovaSolucaoNotification($event->solucao));
        });
    }
}
