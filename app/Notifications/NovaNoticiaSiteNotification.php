<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class NovaNoticiaSiteNotification extends Notification
{
    use Queueable;

    public $noticia;
    public $icon;
    public string $badgeClass;

    /**
     * Create a new notification instance.
     */
    public function __construct($noticia, $icon, $badgeClass)
    {
        $this->noticia = $noticia;
        $this->icon = $icon;
        $this->badgeClass = $badgeClass;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'titulo' => $this->noticia->titulo,
            'icon' => $this->icon,
            'badgeClass' => $this->badgeClass,
            'url' => route('noticias.show', ['id' => $this->noticia->id, 'slug' => $this->noticia->slug]),
        ];
    }

    public function databaseType(object $notifiable): string
    {
        return 'nova_noticia';
    }

    public function initialDatabaseReadAtValue(): ?Carbon
    {
        return null;    
    }
}
