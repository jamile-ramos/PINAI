@extends('layouts.app')

@section('title', 'PINAI - Plataforma Interativa de Núcleos de Acessibilidade e Inclusão')

@section('content')

<!-- Card de principais funcionalidades -->
<div class="content-home">
  <div class="home-text">
    <h1 class="pb-5">Bem vindo à PINAI, {{ Auth::user()->name }}!</h1>
    <p class="h4 fw-normal texto-justificado">
      A Plataforma Interativa de Núcleos de Acessibilidade e Inclusão (PINAI) é uma plataforma criada para
      centralizar e facilitar a comunicação entre os Núcleos de Acessibilidade e Inclusão (NAIs).
    </p>
  </div>
  <h2 class="h3 fw-bolder mt-5 pt-3 mb-5">Principais funcionalidades</h2>
  <div class="content-card">
    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-newspaper" aria-hidden="true"></i>
        <h3 class="card-title h5" id="titulo-noticias">Notícias</h3>
        <p class="card-text card-home">Fique por dentro das últimas atualizações sobre acessibilidade e inclusão.</p>
        <a href="/noticias" class="btn btn-home" data-btn="noticias" id="link-noticias" aria-labelledby="titulo-noticias link-noticias">
          Ver mais
        </a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-comments" aria-hidden="true"></i>
        <h3 class="card-title h5" id="titulo-forum">Fórum</h3>
        <p class="card-text">Participe das discussões e troque ideias sobre inclusão.</p>
        <a href="/topicos" class="btn btn-home" data-btn="topicos" id="link-forum" aria-labelledby="titulo-forum link-forum">
          Ver mais
        </a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-book" aria-hidden="true"></i>
        <h3 class="card-title h5" id="titulo-biblioteca">Biblioteca</h3>
        <p class="card-text">Acesse recursos e materiais sobre acessibilidade.</p>
        <a href="/documentos" class="btn btn-home" id="link-biblioteca" aria-labelledby="titulo-biblioteca link-biblioteca">
          Ver mais
        </a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-lightbulb" aria-hidden="true"></i>
        <h3 class="card-title h5" id="titulo-solucoes">Soluções</h3>
        <p class="card-text">Conheça soluções para promover inclusão e acessibilidade.</p>
        <a href="/solucoes" class="btn btn-home" id="link-solucoes" aria-labelledby="titulo-solucoes link-solucoes">
          Ver mais
        </a>
      </div>
    </div>


    <!-- Card de Noticias -->
    <div class="home-news container">
      <h2 class="h4 fw-bolder mb-0 pb-0">Últimas Notícias</h2>

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
                    alt="Imagem ilustrativa da notícia: {{ $noticia->titulo }}">
                </div>
              </div>
              <div class="col-md-8">
                <div class="card-body d-flex flex-column h-100 bg-transparent p-0">
                  <h3 class="card-title title-new mb-2 h4">
                    <a href="{{ route('noticias.show', $noticia->slug) }}" class="text-decoration-none" data-btn="noticias" aria-label="Abrir a notícia completa: {{ $noticia->titulo }}">
                      {{ $noticia->titulo }}
                    </a>
                  </h3>

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