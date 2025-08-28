<?php

namespace App\Listeners;

use App\Events\DocumentoCriado;
use App\Models\User;
use App\Notifications\NovoDocumentoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DispararEmailDocumentoCriado
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
    public function handle(DocumentoCriado $event): void
    {
        User::ativos()
            ->where('id', '!=', Auth::id())   
            ->select('id', 'name', 'email')
            ->chunkById(500, function ($users) use ($event) {
                Notification::send($users, new NovoDocumentoNotification($event->documento));
            });
    }
}
