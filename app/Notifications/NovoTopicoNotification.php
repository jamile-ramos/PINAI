<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovoTopicoNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public \App\Models\Topico $topico)
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
        ->subject('Novo tópico criado!')
        ->markdown('emails.topicos.novo', [
            'notifiable' => $notifiable,
            'topico'     => $this->topico,
            'url'        => url('/topicos/'.$this->topico->id . '-' .  $this->topico->slug),
        ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'novo.topico',
            'title'      => 'Novo topico publicado',
            'message'    => $this->topico->titulo,
            'slug'       => $this->topico->slug,
            'topico_id' => $this->topico->id,
            'icon'       => 'fas fa-folder-open',
            'badgeClass' => 'notif-secondary',
            'url'        => url('/topicos/'),
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
