@extends('layouts.app')

@section('title', $noticia->titulo)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <div class="mb-4">
        {{ Breadcrumbs::render('verNoticia', $noticia) }}
    </div>

    <article class="bg-white p-3 p-md-5 rounded-4 shadow-sm">
        <!-- Cabeçalho da Notícia -->
        <header class="mb-4">
            <h1 class="fw-bold fs-3 fs-md-2 fs-lg-1 text-primary">{{ $noticia->titulo }}</h1>
            <p class="fs-6 fs-md-5 text-secondary mb-3">{{ $noticia->subtitulo }}</p>

            <div class="d-flex flex-column flex-sm-row flex-wrap align-items-start align-items-sm-center gap-2 gap-sm-3 text-muted small">
                <!-- Autor -->
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-fill me-2" aria-hidden="true"></i>
                    <span>Por <strong class="text-dark">{{ $noticia->user->name }}</strong></span>
                </div>

                <!-- Separador -->
                <div class="vr d-none d-sm-block"></div>

                <!-- Datas -->
                @if($noticia->created_at == $noticia->updated_at)
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar-event me-2" aria-hidden="true"></i>
                    <time datetime="{{ $noticia->created_at }}">
                        {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y \à\s H:i') }}
                    </time>
                </div>
                @else
                <div class="d-flex align-items-center">
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
        <section class="fs-6 lh-lg">
            {!! nl2br(e($noticia->conteudo)) !!}
        </section>
    </article>
</div>
@endsection