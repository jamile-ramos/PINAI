<?php

namespace App\Notifications;

use App\Models\Noticia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovaNoticiaNotification extends Notification
{
    use Queueable;

    /**
     * A notícia que será usada na notificação.
     * @var Noticia
     */
    public $noticia;

    /**
     * Crie uma nova instância da notificação.
     *
     * @param Noticia $noticia
     * @return void
     */
    public function __construct(Noticia $noticia)
    {
        $this->noticia = $noticia;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nova notícia publicada!')
            ->markdown('emails.noticias.nova', [
                'notifiable' => $notifiable,
                'noticia'     => $this->noticia,
                'url' => url('/noticias/' . $this->noticia->id . '-' . $this->noticia->slug),
            ]);
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
