@extends('layouts.app')

@section('title', 'PINAI - Plataforma Interativa de Núcleos de Acessibilidade e Inclusão')

@section('content')

<!-- Card de principais funcionalidades -->
<div class="content-home">
  <div class="home-text">
    <h1>BEM VINDO À PINAI!</h1>
    <h3>A Plataforma Interativa de Núcleos de Acessibilidade e Inclusão (PINAI) é uma plataforma criada para
      centralizar e facilitar a comunicação entre os Núcleos de Acessibilidade e Inclusão (NAIs).</h3>
  </div>
  <div class="content-card">
    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-newspaper"></i>
        <h5 class="card-title">Notícias</h5>
        <p class="card-text card-home">Fique por dentro das últimas atualizações sobre acessibilidade e inclusão.</p>
        <a href="#" class="btn btn-home">Ver mais</a>
      </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
      <div class="card-body card-functions">
        <i class="fas fa-comments"></i>
        <h5 class="card-title">Fórum</h5>
        <p class="card-text">Participe das discussões e troque ideias sobre inclusão.</p>
        <a href="#" class="btn btn-home">Ver mais</a>
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
    <h2>NOTÍCIAS</h2>
    <div class="card card-new mb-3" style="max-width: 100%;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="img/blogpost.jpg" class="img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title title-new">
              <a href="#">Novos Avanços em Tecnologias Assistivas para Pessoas com Deficiência</a>
            </h5>
            <p class="card-text">Esta notícia pode destacar as inovações tecnológicas que estão melhorando a vida de pessoas com deficiência, como novos softwares de leitura de tela, dispositivos de navegação para deficientes visuais e avanços em aparelhos auditivos.</p>
            <p class="card-text"><small class="text-muted">Publicado dia 12/09/2021</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection