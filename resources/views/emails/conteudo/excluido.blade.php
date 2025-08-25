<x-mail::message>
🗑️ Aviso de Exclusão

Olá {{ $notifiable->name ?? '' }},

Gostaríamos de informar que um item foi removido da nossa plataforma.

{{ ucfirst($tipo) }} excluído(a): {{ $titulo }}

Se você tiver alguma dúvida sobre esta ação, por favor, entre em contato com a nossa equipe de suporte.

Agradecemos a sua compreensão.

Atenciosamente,<br>
A equipe da {{ config('app.name') }}
</x-mail::message>
