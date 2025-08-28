<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NaiCriadoNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public \App\Models\Nai $nai)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Novo NAI adicionado!')
            ->markdown('emails.nais.novo', [
                'notifiable' => $notifiable,
                'nai'     => $this->nai,
                'url' => url('/painelUsuarios/nais/show/'. $this->nai->id),
            ]);
    }

    
    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'nova.nai',
            'title'      => 'Novo NAI adicionado',
            'message'    => $this->nai->nome,
            'nai_id' => $this->nai->id,
            'icon'       => 'fas fa-landmark',
            'badgeClass' => 'notif-dark',
            'url'        => route('nais.show', $this->nai->id),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
