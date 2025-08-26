@extends('layouts.app')

@section('title', $noticia->titulo)

@section('content')
<div class="container py-2">
    <!-- Breadcrumb -->
    <div class="mb-4">
        {{ Breadcrumbs::render('verNoticia', $noticia) }}
    </div>

    <article class="bg-white p-3 p-md-5 rounded-4 shadow-sm">
        <!-- Cabeçalho da Notícia -->
        <header class="mb-4 text-center">
            {{-- Removendo o justify-content-between para centralizar todo o conteúdo --}}
            <h1 class="fw-bold fs-3 fs-md-2 fs-lg-1 text-primary">{{ $noticia->titulo }}</h1>
            <p class="fs-6 fs-md-5 text-secondary mt-3">{{ $noticia->subtitulo }}</p>

            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 text-muted small mt-2">
                <!-- Autor -->
                <div class="d-flex align-items-center me-sm-3">
                    <i class="bi bi-person-fill me-2" aria-hidden="true"></i>
                    <span>Por <strong class="text-dark">{{ $noticia->user->name }}
                            @if ($noticia->user->nai)
                            - {{ $noticia->user->nai->siglaNai }}
                            @endif</strong></span>
                </div>

                <!-- Datas -->
                @if($noticia->created_at == $noticia->updated_at)
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar-event me-2" aria-hidden="true"></i>
                    <time datetime="{{ $noticia->created_at }}">
                        {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y \à\s H:i') }}
                    </time>
                </div>
                @else
                <div class="d-flex align-items-center me-sm-3">
                    <i class="bi bi-pencil-square me-2" aria-hidden="true"></i>
                    <time datetime="{{ $noticia->updated_at }}">
                        Atualizado em {{ \Carbon\Carbon::parse($noticia->updated_at)->format('d/m/Y \à\s H:i') }}
                    </time>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar-event me-2" aria-hidden="true"></i>
                    <time datetime="{{ $noticia->created_at }}">
                        Publicado em {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y \à\s H:i') }}
                    </time>
                </div>
                @endif

                {{-- Botão de Compartilhar --}}
                <div class="mt-2 mt-sm-0">
                    <button id="shareButton"
                        data-url="{{ route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]) }}"
                        class="btn btn-link d-flex align-items-center gap-2">
                        <i class="fas fa-share-alt"></i>
                        Compartilhar
                    </button>
                </div>
            </div>
        </header>

        <!-- Imagem -->
        <div class="mb-4">
            <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}"
                alt="Imagem da notícia: {{ $noticia->titulo }}"
                class="img-fluid w-100 rounded"
                style="object-fit: cover; max-height: 400px;">
        </div>

        <!-- Conteúdo -->
        <section class="fs-6 lh-lg conteudo">
        {!! $noticia->conteudo !!}
        </section>
    </article>


    <section class="mt-5 pt-5">
        <h2 class="h4 text-primary fw-bold mb-4">Veja Também:</h2>
        <div class="home-news titulo-categoria mb-2 mt-4 pt-2">
            <div class="row">
                @foreach($ultimasNoticias as $noticia)
                <div class="col-md-4 mb-2">
                    <div class="card h-100 bg-transparent border-0 shadow-none">
                        <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}" class="card-img-top img-capa" alt="{{ 'Imagem da notícia: ' . Str::limit($noticia->titulo, 80) }}">
                        <div>
                            <h5 class="h5 card-title pt-3 hover-underline">
                                <a href="{{ route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]) }}">{{ $noticia->titulo }}</a>
                            </h5>
                            <p class="card-text">
                                <small class="text-muted">Publicado dia {{ $noticia->created_at->format('d/m/Y') }}</small>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection