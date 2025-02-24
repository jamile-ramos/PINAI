@extends('layouts.app')

@section('title', 'PINAI - Plataforma Interativa de Núcleos de Acessibilidade e Inclusão')

@section('content')

<!-- Card de principais funcionalidades -->
<div class="content-home">
  <div class="home-text">
    <h1>Bem vindo à PINAI, {{ Auth::user()->name }}!</h1>
    <h3>A Plataforma Interativa de Núcleos de Acessibilidade e Inclusão (PINAI) é uma plataforma criada para
      centralizar e facilitar a comunicação entre os Núcleos de Acessibilidade e Inclusão (NAIs).</h3>
  </div>
  <div class="content-card">
    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-newspaper"></i>
        <h5 class="card-title">Notícias</h5>
        <p class="card-text card-home">Fique por dentro das últimas atualizações sobre acessibilidade e inclusão.</p>
        <a href="/noticias" class="btn btn-home" data-btn="noticias" >Ver mais</a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-comments"></i>
        <h5 class="card-title">Fórum</h5>
        <p class="card-text">Participe das discussões e troque ideias sobre inclusão.</p>
        <a href="/topicos" class="btn btn-home" data-btn="topicos">Ver mais</a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-book"></i>
        <h5 class="card-title">Biblioteca</h5>
        <p class="card-text">Acesse recursos e materiais sobre acessibilidade.</p>
        <a href="#" class="btn btn-home">Ver mais</a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-lightbulb"></i>
        <h5 class="card-title">Soluções</h5>
        <p class="card-text">Conheça soluções para promover inclusão e acessibilidade.</p>
        <a href="#" class="btn btn-home">Ver mais</a>
      </div>
    </div>
  </div>

  <!-- Card de Noticias -->
  <div class="home-news">
    <h2>ÚLTIMAS NOTÍCIAS</h2>
    @foreach($noticias as $noticia)
    <div class="card card-new mb-3" style="max-width: 100%;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}" class="img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title title-new">
              <a href="{{ route('noticias.show', $noticia->id) }}" data-btn="noticias">{{ $noticia->titulo }}</a>
            </h5>
            <p class="card-text">{{Str::limit($noticia->subtitulo, 150) }}</p>
            <p class="card-text"><small class="text-muted">Publicado dia {{ $noticia->created_at->format('d/m/Y') }}</small></p>
          </div>

        </div>
      </div>
    </div>
    @endforeach
  </div>

</div>

@endsection