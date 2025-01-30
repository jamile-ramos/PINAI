@extends('layouts.app')

@section('title', 'Portal de Notícias')

@section('content')

<div class="container-abas" id="abaNoticias">

    <x-barra-filtros
        :links="[
        ['content-id' => 'allNoticias', 'nomeAba' => 'Todos', 'classActive' => 'active', 'data-tipo' => 'noticias'],
        ['content-id' => 'mysNoticias', 'nomeAba' => 'Minhas Noticias', 'data-tipo' => 'noticias'],
        ['content-id' => 'categoriasNoticias', 'nomeAba' => 'Categorias', 'data-tipo' => 'noticias']
    ]"
        :actions="[
        ['classBtn' => 'btn-dark', 'content-id' => 'categoriasNoticias', 'nomeButton' => 'Criar Categoria'],
        ['classBtn' => 'btn-primary', 'content-id' => 'mysNoticias', 'nomeButton' => 'Criar Notícia']
    ]" />

    @if(session('sucess'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="sucess-alert">
        <strong>{{ session('sucess') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Conteúdo das abas -->
    <div class="tab-contents">
        <div class="content-link show" id="allNoticias">
            <div class="infos">
                @include('noticias.home')
            </div>
        </div>

        <div class="content-link" id="mysNoticias">
            <div class="infos">
                @include('noticias.minhasNoticias', ['minhasNoticias' => $minhasNoticias])
            </div>
        </div>

        <div class="content-link" id="categoriasNoticias">
            <div class="infos" id="categorias-content">
                @include('layouts.tabelaCategorias', ['categorias' => $categorias])
            </div>
        </div>

    </div>
</div>

@include('layouts.createCategoria', ['tipo' => "noticias"])
@include('layouts.modalExclusao')

@endsection