<x-mail::message>
⚠️ Sua conta foi desativada

Olá {{ $notifiable->name ?? '' }},

Informamos que sua conta na nossa plataforma foi **desativada**.  
Com isso, o acesso aos recursos e serviços está temporariamente suspenso.

Se você acredita que isso foi um engano ou deseja mais informações, entre em contato com a nossa equipe de suporte.

Agradecemos pela sua compreensão.  
Estamos à disposição para esclarecer qualquer dúvida.

Atenciosamente,<br>
A equipe do {{ config('app.name') }}
</x-mail::message>
