@extends('layouts.app')

@section('title', $noticia->titulo)

@section('content')

<div class="col">
    <div class="mx-2">
        {{ Breadcrumbs::render('verNoticia', $noticia)}}
    </div>

    <div class="noticia-container">
        <header class="noticia-header">
            <h1 class="noticia-titulo">{{ $noticia->titulo }}</h1>
            <p class="noticia-subtitulo">{{ $noticia->subtitulo }}</p>
            <p class="autor">Por {{ $noticia->user->name }}</p>
            <div class="dadosNoticia">
                @if($noticia->created_at == $noticia->updated_at)
                <p>Publicado em {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y \à\s H:i') }}</p>
                @else
                <p>Atualizado em {{ \Carbon\Carbon::parse($noticia->updated_at)->format('d/m/Y \à\s H:i') }}</p>
                <p>Publicado em {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y \à\s H:i') }}</p>
                @endif

            </div>
        </header>

        <!-- Imagem da notícia -->
        <div class="noticia-imagem">
            <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}" alt="{{ $noticia->titulo }}" />
        </div>

        <!-- Conteúdo da notícia -->
        <section class="noticia-conteudo">
            {!! nl2br(e($noticia->conteudo)) !!}
        </section>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Voltar</a>
    </div>
</div>

@endsection