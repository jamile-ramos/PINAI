<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject(__('Redefinição de Senha'))
            ->line(__('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.'))
            ->action(__('Redefinir Senha'), $url)
            ->line(__('Este link de redefinição de senha irá expirar em :count minutos.', [
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')
            ]))
            ->line(__('Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.'));
    }
}
