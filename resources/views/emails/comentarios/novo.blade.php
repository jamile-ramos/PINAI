<x-mail::message>
📚 Uma menção em um comentário!

Olá {{ $notifiable->name ?? '' }},

Você foi mencionado em um novo comentário no fórum da nossa plataforma!

O comentário está em uma resposta de uma postagem que pode ser do seu interesse.

Conteúdo do comentário:

{{ $comentario->conteudo }}

Para conferir o comentário completo e participar da discussão, acesse o link abaixo:

<x-mail::button :url="$url">
💬 Acessar o comentário
</x-mail::button>

Atenciosamente,<br>
A equipe do {{ config('app.name') }}
</x-mail::message>
