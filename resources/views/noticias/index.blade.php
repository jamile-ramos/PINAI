@extends('layouts.app')

@section('title', 'Portal de Notícias')

@section('content')

<div class="container-abas" id="abaNoticias">

    {{ Breadcrumbs::render('noticias') }}

    @php

    $links = [
    ['content-id' => 'visaoNoticias', 'nomeAba' => 'Visão Geral', 'data-tipo' => 'noticias'],
    ['content-id' => 'myNoticias', 'nomeAba' => 'Minhas Noticias', 'data-tipo' => 'noticias']
    ];

    if (Auth::check() && Auth::user()->tipoUsuario != 'comum') {
    $links[] = ['content-id' => 'allNoticias', 'nomeAba' => 'Gerenciar Notícias', 'data-tipo' => 'noticias'];
    }

    $actions = [
    ['classBtn' => 'btn-primary', 'content-id' => 'myNoticias', 'nomeButton' => 'Criar Notícia', 'data-url' => '/noticias/create']
    ];

    if (Auth::check() && Auth::user()->tipoUsuario != 'comum') {
    $links[] = ['content-id' => 'categoriasNoticias', 'nomeAba' => 'Categorias', 'data-tipo' => 'noticias'];
    $actions[] = ['classBtn' => 'btn-dark', 'content-id' => 'categorias', 'nomeButton' => 'Criar Categoria'];
    }

    @endphp
    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Portal de Notícias</h1>
            <p class="text-secondary mt-3 ">Atualizações, eventos e novidades sobre acessibilidade nos NAIs de todo o Brasil.</p>
        </div>
    </header>

    <x-barra-filtros
        :links="$links"
        :actions="$actions" />

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    @foreach ($errors->all() as $message)
    <div class="alert alert-danger alert-dismissible fade show mt-2 mx-3 rounded" role="alert">
        {{ $message }}
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Fechar">
        </button>
    </div>
    @endforeach
    @endif
    <!-- Conteúdo das abas -->
    <div class="tab-contents">
        <div class="content-link" id="visaoNoticias">
            <div class="infos">
                @include('noticias.init', ['noticiasRecentes' => $noticiasRecentes, 'categorias' => $categorias])
            </div>
        </div>

        <div class="content-link" id="myNoticias">
            <div class="infos">
                @include('noticias.tableNoticias', ['noticias' => $minhasNoticias, 'tipoAba' => 'myNoticias'])
            </div>
        </div>

        <div class="content-link" id="allNoticias">
            <div class="infos">
                @include('noticias.tableNoticias', ['noticias' => $noticias, 'tipoAba' => 'allNoticias'])
            </div>
        </div>

        <div class="content-link" id="categoriasNoticias">
            <div class="infos" id="categorias-content">
                @include('layouts.tabelaCategorias', ['categorias' => $categoriasNoticias, 'tipo' => "noticias"])
            </div>
        </div>

    </div>
</div>

@include('layouts.createCategoria', ['tipo' => "noticias"])
@include('layouts.modalExclusao')

@endsection