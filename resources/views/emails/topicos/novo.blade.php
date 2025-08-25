<x-mail::message>
    
# 💬 Um novo tópico está no ar!

Olá {{ $notifiable->name ?? '' }},

A comunidade está agitada com uma nova discussão! Sua opinião é fundamental para enriquecer a conversa.

Não fique de fora, participe agora mesmo:

---

### {{ $topico->titulo }}

<x-mail::button :url="$url">
🗣️ Participe da discussão
</x-mail::button>

Sua voz é o que faz a nossa comunidade ser incrível

Atenciosamente,<br>
A equipe do {{ config('app.name') }}
</x-mail::message>
