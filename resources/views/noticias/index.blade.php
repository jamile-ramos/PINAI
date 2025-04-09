@extends('layouts.app')

@section('title', 'Portal de Notícias')

@section('content')

<div class="container-abas" id="abaNoticias">

    @php

    $links = [
    ['content-id' => 'visaoNoticias', 'nomeAba' => 'Visão Geral', 'classActive' => 'active', 'data-tipo' => 'noticias'],
    ];

    if (Auth::check() && Auth::user()->tipoUsuario == 'admin') {
    $links[] = ['content-id' => 'allNoticias', 'nomeAba' => 'Gerenciar Notícias', 'data-tipo' => 'noticias'];
    }

    $links[] = ['content-id' => 'mysNoticias', 'nomeAba' => 'Minhas Noticias', 'data-tipo' => 'noticias'];

    $actions = [
    ['classBtn' => 'btn-primary', 'content-id' => 'mysNoticias', 'nomeButton' => 'Criar Notícia', 'data-url' => '/noticias/create']
    ];

    if (Auth::check() && Auth::user()->tipoUsuario == 'admin') {
    $links[] = ['content-id' => 'categoriasNoticias', 'nomeAba' => 'Categorias', 'data-tipo' => 'noticias'];
    $actions[] = ['classBtn' => 'btn-dark', 'content-id' => 'categorias', 'nomeButton' => 'Criar Categoria'];
    }

    @endphp

    <x-barra-filtros
        :links="$links"
        :actions="$actions" />

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="sucess-alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <!-- Conteúdo das abas -->
    <div class="tab-contents">
        <div class="content-link show" id="visaoNoticias">
            <div class="infos">
                @include('noticias.init', ['noticiasRecentes' => $noticiasRecentes, 'categorias' => $categorias])
            </div>
        </div>

        <div class="content-link" id="allNoticias">
            <div class="infos">
                @include('noticias.tableNoticias', ['noticias' => $noticias, 'tipoAba' => 'allNoticias'])
            </div>
        </div>


        <div class="content-link" id="mysNoticias">
            <div class="infos">
                @include('noticias.tableNoticias', ['noticias' => $minhasNoticias, 'tipoAba' => 'mysNoticias'])
            </div>
        </div>

        <div class="content-link" id="categoriasNoticias">
            <div class="infos" id="categorias-content">
                @include('layouts.tabelaCategorias', ['categorias' => $categorias, 'tipo' => "noticias"])
            </div>
        </div>

    </div>
</div>

@include('layouts.createCategoria', ['tipo' => "noticias"])
@include('layouts.modalExclusao')

@endsection