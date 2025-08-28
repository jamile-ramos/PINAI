<?php

namespace App\Notifications;

use App\Models\Comentario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Postagem;

class UsuarioMencionadoNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public \App\Models\Comentario $comentario)
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
        $idPostagem = $this->comentario->resposta->postagem->id;
        $postagem   = Postagem::findOrFail($idPostagem);

        return (new MailMessage)
            ->subject('Você foi mencionado em um comentário!')
            ->markdown('emails.comentarios.novo', [
                'notifiable' => $notifiable,
                'comentario' => $this->comentario,
                'url'        => url('/postagens/' . $postagem->id . '-' . $postagem->slug),
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        $postagem = $this->comentario->resposta->postagem;

        return [
            'type'       => 'novo.comentario',
            'title'      => 'Você foi mencionado em um comentário!',
            'message'    => $this->comentario->conteudo,
            'comentario_id' => $this->comentario->id,
            'icon'       => 'fas fa-comment-dots',
            'badgeClass' => 'notif-info',
            'url'        => route('postagens.show', ['id' => $postagem->id, 'slug' => $postagem->slug]),
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
