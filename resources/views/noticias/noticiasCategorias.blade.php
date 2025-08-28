@extends('layouts.app')

@section('title', $categoria->nomeCategoria)

@section('content')
<div class="col">
  <div>
    {{ Breadcrumbs::render('noticiasCategorias', $categoria)}}
  </div>

  <div class="home-news titulo-categoria g-0">

    <div class="my-4 mb-0">
      <h1 class="h2 fw-bolder text-uppercase text-dark mb-0 position-relative">
        <i class="fas fa-folder me-3 text-primary"></i>
        {{ $categoria->nomeCategoria }}
      </h1>
    </div>

    <div class="row row-cols-1 g-4 pt-3">
      @foreach($noticias as $noticia)
      <div class="col card-not-home">
        <div class="card h-100 border-0 bg-transparent shadow-none">
          <div class="row g-0 h-100">
            <div class="col-md-4">
              <div class="h-100 w-100 overflow-hidden">
                <img src="{{ $noticia->imagem ? asset('img/imgNoticias/' . $noticia->imagem) : asset('/img/noticia-sem-imagem.png') }}"
                  class="img-fluid rounded w-100 h-100"
                  style="min-height: 200px; max-height: 200px; object-fit: cover;"
                  alt="{{ $noticia->titulo }}">
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body d-flex flex-column h-100 bg-transparent p-0">
                <h2 class="fs-3 card-title title-new mb-2 pl-0">
                  <a href="{{ route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]) }}" class="text-decoration-none text-dark" data-btn="noticias">
                    {{ $noticia->titulo }}
                  </a>
                </h2>

                <p class="card-text mb-5">{{ Str::limit($noticia->subtitulo, 150) }}</p>
                <p class="card-text"><small class="text-muted">Publicado dia {{ $noticia->created_at->format('d/m/Y') }}</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

</div>
@endsection