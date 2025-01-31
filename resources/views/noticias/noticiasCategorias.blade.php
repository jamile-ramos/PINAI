@extends('layouts.app')

@section('title', $categoria->nomeCategoria)

@section('content')


<div class="home-news titulo-categoria">
        <h2>{{ $categoria->nomeCategoria }}</a></h2>

        @foreach($noticias as $noticia)
        <div class="card card-new mb-3" style="max-width: 98%;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}" class="img-fluid rounded-start" alt="$noticia->titulo">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title title-new">
                            <a href="{{ route('noticias.show', $noticia->id) }}">{{ $noticia->titulo }}</a>
                        </h5>
                        <p class="card-text">{{ Str::limit($noticia->subtitulo, 150) }}</p>
                        <p class="card-text"><small class="text-muted">Publicado dia {{ $noticia->created_at->format('d/m/Y') }}</small></p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

@endsection