@extends('layouts.app')

@section('title', 'Portal de Notícias')

@section('content')

<x-barra-filtros 
    :links="[
        ['href' => '/noticias?query', 'nome' => 'Todas', 'class' => 'active', 'data-value' => 'todas'],
        ['href' => '/painelUsuarios?query', 'nome' => 'Minhas Notícias', 'data-value' => 'minhas-noticias'],
        ['href' => 'javascript:void(0);', 'nome' => 'Categorias', 'class' => 'toggle-categorias', 'tipo' => 'noticia', 'data-value' => 'categorias']
    ]"
    :actionsMenor="[
        ['class' => 'btn-primary mr-2 toggle-search', 'id' => 'abrirModalNoticiaMenor', 'nome' => 'Adicionar Notícia'],
        ['class' => 'btn-dark mr-2 toggle-categorias', 'id' => 'abrirModalCategoriaMenor', 'nome' => 'Adicionar Categoria']
    ]"
    :actions="[
        ['class' => 'btn-primary mr-2 toggle-search', 'id' => 'abrirModalNoticia', 'nome' => 'Adicionar Notícia'],
        ['class' => 'btn-dark mr-2 toggle-categorias', 'id' => 'abrirModalCategoria', 'nome' => 'Adicionar Categoria']
    ]"
    :modals="[
        ['view' => 'components.modal-categoria-create', 'data' => ['tipo' => 'noticia']],
        ['view' => 'noticias.create']
    ]"
/>

<div id="conteudo-categorias">
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
</div>
</div>
@endsection