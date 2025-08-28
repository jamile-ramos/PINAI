<x-mail::message>
🏛️ Um novo NAI foi adicionado!

Olá {{ $notifiable->name ?? '' }},

Temos uma ótima notícia: um **novo Núcleo de Acessibilidade e Inclusão (NAI)** foi registrado em nossa plataforma.

Agora, você poderá contar com mais suporte e recursos oferecidos pelo seguinte núcleo:

📌 **{{ $nai->nome }} ({{ $nai->siglaNai }})**  
🏫 Instituição: **{{ $nai->instituicao }}**

<x-mail::button :url="$url">
🔎 Ver detalhes do NAI
</x-mail::button>

Estamos felizes em expandir nossa rede de acessibilidade para oferecer cada vez mais apoio a você.

Atenciosamente,  
A equipe da {{ config('app.name') }}
</x-mail::message>