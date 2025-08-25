<x-mail::message>
    
# Novo tópico publicado!
Olá!

Um novo tópico foi criado em nossa comunidade.
Participe da conversa e contribua com a sua opinião:

---

### {{ $topico->titulo }}
{{ $topico->resumo }}

<x-mail::button :url="$url">
Participar da discussão
</x-mail::button>

Esperamos que a discussão seja útil para você!

Atenciosamente,<br>
A equipe do {{ config('app.name') }}
</x-mail::message>
