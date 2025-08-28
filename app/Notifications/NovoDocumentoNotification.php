<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovoDocumentoNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public \App\Models\Documento $documento)
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
        $caminhoArquivo = $this->documento->caminhoArquivo;
        $url = asset('storage/' . $caminhoArquivo);

        return (new MailMessage)
            ->subject('Novo documento disponível!')
            ->markdown('emails.documentos.novo', [
                'notifiable' => $notifiable,
                'documento'     => $this->documento,
                'url'        => $url,
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'novo.documento',
            'title'      => 'Novo documento publicado',
            'message'    => $this->documento->titulo,
            'subtitulo'  => $this->documento->subtitulo,
            'slug'       => $this->documento->slug,
            'documento_id' => $this->documento->id,
            'icon'       => 'fas fa-file-alt',
            'badgeClass' => 'notif-danger',
            'url'        => url('/documentos/'),
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
