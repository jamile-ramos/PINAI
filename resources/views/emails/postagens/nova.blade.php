<x-mail::message>
💬 Uma nova postagem foi adicionada!

Olá {{ $notifiable->name ?? '' }},

Um dos tópicos que você participa recebeu uma nova postagem.

### {{ $postagem->topico->titulo }}
{{ Str::limit($postagem->conteudo, 150) }}


<x-mail::button :url="$url">
Acessar o Postagem
</x-mail::button>

Para continuar participando da conversa, acesse o link acima.

Atenciosamente,<br>
A equipe do {{ config('app.name') }}
</x-mail::message>
