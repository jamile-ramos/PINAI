<x-mail::message>
📚 Um novo recurso na biblioteca!

Olá {{ $notifiable->name ?? '' }},

Temos uma novidade fresquinha para você! A nossa biblioteca digital acaba de ser atualizada com um novo documento, que pode ser um material valioso.

Não perca tempo, confira agora mesmo:

{{ $documento->nomeArquivo }}

{{ $documento->descricao ?? 'Acesse o botão abaixo para conferir o documento completo.' }}

<x-mail::button :url="$url">
📥 Acessar o documento
</x-mail::button>

Agradecemos por fazer parte da nossa jornada de inclusão e conhecimento.

Atenciosamente,<br>
A equipe do {{ config('app.name') }}
</x-mail::message>
