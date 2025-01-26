@extends('layouts.app')

@section('title', 'Portal de Notícias')

@section('content')

<div class="container-abas">
    <div class="tab-buttons">
        <form action="/" method="GET" class="search-form" style="display: none;">
            <div class="search-container">
                <i class="fas fa-search mr-2"></i>
                <input type="text" class="search-input" name="query" placeholder="Pesquisar..." value="{{ request('query') }}" />
            </div>
        </form>

        <!-- Select para telas menores -->
        <div class="select-btn">
            <div class="select-option">Todas</div>
            <i class="dropdown-icon fas fa-chevron-down"></i>
            <div class="dropdown close-drop">
                <button class="option-btn" content-id="all">Todos</button>
                <button class="option-btn" content-id="mys">Minhas Notícias</button>
                <button class="option-btn" content-id="categorias">Categorias</button>
                <div class="line-button"></div>
                <div class="btns-select">
                    <button class="option-add btn btn-primary" content-id="mys">Criar Notícias</button>
                    <button class="option-add btn btn-dark" content-id="categorias">Criar Categoria</button>
                </div>
            </div>
        </div>

        <!-- Abas para telas maiores -->
        <button class="tab-btn active" content-id="all">
            Todos
        </button>

        <button class="tab-btn" content-id="mys">
            Minhas Noticias
        </button>

        <button class="tab-btn" content-id="categorias">
            Categorias
        </button>

        <!-- Botões para telas maiores -->
        <div class="add">
            <button class="add-btn btn btn-primary">
                Adicionar Notícia
            </button>
            <button class="add-btn btn btn-dark">
                Adicionar Categoria
            </button>

            <div class="botao-pesquisar">
                <a href="javascript:void(0);" class="search-icon"><i class="fas fa-search mr-2"></i></a>
                <a href="javascript:void(0);" class="close-search" style="display: none;"><i class="fas fa-times mr-2"></i></a>
            </div>
        </div>
    </div>

    <!-- Conteúdo das abas -->
    <div class="tab-contents">
        <div class="content-link show" id="all">
            <div class="infos">
                <h1 class="content-title">
                    Home
                </h1>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis eaque eos cum voluptatibus repudiandae autem, voluptate ex dicta officiis odio illo magni, dolores quibusdam temporibus alias expedita eligendi et nam?</p>
            </div>
        </div>

        <div class="content-link" id="mys">
            <div class="infos">
                @include('noticias.minhasNoticias')
            </div>
        </div>

        <div class="content-link" id="categorias">
            <div class="infos">
                @include('noticias.categorias')
            </div>
        </div>
    </div>
</div>

@endsection