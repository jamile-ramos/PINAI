<?php

namespace App\Notifications;

use App\Models\Postagem;
use App\Models\Topico;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovaPostagemNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public \App\Models\Postagem $postagem)
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
            ->subject('Nova postagem Publicada!')
            ->markdown('emails.postagens.nova', [
                'notifiable' => $notifiable,
                'postagem'     => $this->postagem,
                'url' => url('/postagens/' . $this->postagem->id . '-' . $this->postagem->slug),
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'nova.postagem',
            'title'      => 'Nova postagem publicada',
            'message'    => $this->postagem->titulo,
            'slug'       => $this->postagem->slug,
            'postagem_id' => $this->postagem->id,
            'idTopico' => $this->postagem->idTopico,
            'icon'       => 'fas fa-edit',
            'badgeClass' => 'notif-secondary',
            'url'        => route('postagens.show', ['id' => $this->postagem->id, 'slug' => $this->postagem->slug]),
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
