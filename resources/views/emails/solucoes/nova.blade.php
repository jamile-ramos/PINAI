<x-mail::message>
✅ Uma nova solução foi publicada!

Olá {{ $notifiable->name ?? '' }},

Temos uma excelente notícia! Uma nova solução foi publicada na nossa plataforma. Veja como a comunidade se uniu para resolver mais um desafio.

Fique por dentro dos detalhes e aprenda algo novo:

{{ $solucao->titulo }}

{{ $solucao->descricao }}

<x-mail::button :url="$url">
🔍 Ver a solução completa
</x-mail::button>

Sua dedicação torna a nossa plataforma um espaço de inclusão e apoio.

Atenciosamente,,<br>
A equipe do {{ config('app.name') }}
</x-mail::message>
