<x-mail::message>
✅ Sua conta foi ativada!

Olá {{ $notifiable->name ?? '' }},

Temos uma ótima notícia! Sua conta na nossa plataforma foi **ativada** com sucesso.  
A partir de agora, você já pode acessar todos os recursos disponíveis e aproveitar ao máximo os serviços que oferecemos.

<x-mail::button :url="$url">
🚀 Acessar minha conta
</x-mail::button>

Estamos felizes em tê-lo(a) conosco.  
Conte sempre com a nossa equipe para apoiar sua jornada de inclusão e aprendizado.

Atenciosamente,<br>
A equipe do {{ config('app.name') }}
</x-mail::message>
