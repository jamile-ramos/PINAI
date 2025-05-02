@extends('layouts.app')

@section('title', 'PINAI - Plataforma Interativa de Núcleos de Acessibilidade e Inclusão')

@section('content')

<!-- Card de principais funcionalidades -->
<div class="content-home">
  <div class="home-text">
    <h1 class="pb-5">Bem vindo à PINAI, {{ Auth::user()->name }}!</h1>
    <h2 class="h4 fw-normal">A Plataforma Interativa de Núcleos de Acessibilidade e Inclusão (PINAI) é uma plataforma criada para
      centralizar e facilitar a comunicação entre os Núcleos de Acessibilidade e Inclusão (NAIs).</h2>
  </div>
  <div class="content-card">
    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-newspaper" aria-hidden="true"></i>
        <h5 class="card-title">Notícias</h5>
        <p class="card-text card-home">Fique por dentro das últimas atualizações sobre acessibilidade e inclusão.</p>
        <a href="/noticias" class="btn btn-home" data-btn="noticias" aria-label="Acessar mais notícias de acessibilidade e inclusão">Ver mais</a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-comments" aria-hidden="true"></i>
        <h5 class="card-title">Fórum</h5>
        <p class="card-text">Participe das discussões e troque ideias sobre inclusão.</p>
        <a href="/topicos" class="btn btn-home" data-btn="topicos" aria-label="Acessar o fórum para discutir temas sobre inclusão">Ver mais</a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-book" aria-hidden="true"></i>
        <h5 class="card-title">Biblioteca</h5>
        <p class="card-text">Acesse recursos e materiais sobre acessibilidade.</p>
        <a href="/documentos" class="btn btn-home" aria-label="Acessar a biblioteca com materiais sobre acessibilidade e inclusão">Ver mais</a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-lightbulb" aria-hidden="true"></i>
        <h5 class="card-title">Soluções</h5>
        <p class="card-text">Conheça soluções para promover inclusão e acessibilidade.</p>
        <a href="/solucoes" class="btn btn-home" aria-label="Acessar o banco de soluções sobre inclusão e acessibilidade">Ver mais</a>
      </div>
    </div>
  </div>

  <!-- Card de Noticias -->
  <div class="home-news container">
    <h2 class="mb-4">ÚLTIMAS NOTÍCIAS</h2>

    <div class="row row-cols-1 g-4">
      @foreach($noticias as $noticia)
      <div class="col card-not-home">
        <div class="card h-100 border-0 bg-transparent shadow-none">
          <div class="row g-0 h-100">
            <div class="col-md-4">
              <div class="h-100 w-100 overflow-hidden">
                <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}"
                  class="img-fluid rounded w-100 h-100"
                  style="min-height: 200px; max-height: 200px; object-fit: cover;"
                  alt="{{ $noticia->titulo }}">
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body d-flex flex-column h-100 bg-transparent p-0">
                <h5 class="card-title title-new mb-2">
                  <a href="{{ route('noticias.show', $noticia->id) }}" class="text-decoration-none text-dark" data-btn="noticias" aria-label="Abrir a notícia completa: {{ $noticia->titulo }}">
                    {{ $noticia->titulo }}
                  </a>
                </h5>

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