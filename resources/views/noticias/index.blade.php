@extends('layouts.app')

@section('title', 'Portal de Notícias')

@section('content')
<div class="bg-light">
    <div class="navbar navbar-light bg-light barra-filtros">
        <div class="filtros">
            <a href="/painelUsuarios?query" class="active">Todas</a>
            <a href="/painelUsuarios?query">Minhas Notícias</a>
            <a href="/painelUsuarios?query">Categorias</a>
        </div>

        <div class="ml-auto d-flex align-items-center barra-pesquisa">
            <!-- Campo de pesquisa inicialmente escondido -->
            <form action="/" method="GET" class="search-form" style="display: none;">
                <div class="search-container">
                    <i class="fas fa-search mr-2"></i>
                    <input type="text" class="search-input" name="query" placeholder="Pesquisar..." value="{{ request('query') }}" />
                </div>
            </form>
            <button type="button" class="btn btn-primary mr-2 toggle-search">
                Adicionar Notícia
            </button>
            <button type="button" class="btn btn-dark mr-2 toggle-search">
                Adicionar Categoria
            </button>
            <!-- Ícone de pesquisa que ativa a barra de pesquisa -->
            <div class="botao-pesquisar">
                <a href="javascript:void(0);" class="search-icon"><i class="fas fa-search mr-2"></i></a>
                <a href="javascript:void(0);" class="close-search" style="display: none;"><i class="fas fa-times mr-2"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="bd-example">
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/blogpost.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/bg-404.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/examples/example2.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<div class="home-news titulo-categoria">
    <h2>Categoria</h2>
    <div class="card card-new mb-3" style="max-width: 98%;">
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

@endsection