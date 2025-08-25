<x-mail::message>

# 📰 Uma nova notícia acabou de sair!

Olá {{ $notifiable->name ?? '' }},

Temos uma novidade fresquinha para você!  
Uma nova notícia foi publicada em nossa comunidade e pode ser do seu interesse.  


Não perca tempo, confira agora e fique por dentro:
### {{ $noticia->titulo }}

{{ $noticia->subtitulo ?? 'Clique no botão abaixo para ler mais detalhes.' }}

<x-mail::button :url="$url">
📖 Ler a notícia completa
</x-mail::button>

Fique ligado em nossas atualizações para não perder nada importante!  

Atenciosamente,<br>
A equipe do {{ config('app.name') }}
</x-mail::message>
