@extends('layouts.app')

@section('title', 'Portal de Notícias')

@section('content')

<div class="container-abas">

    <x-barra-filtros
        :links="[
        ['content-id' => 'all', 'nomeAba' => 'Todos', 'classActive' => 'active'],
        ['content-id' => 'mys', 'nomeAba' => 'Minhas Noticias'],
        ['content-id' => 'categorias', 'nomeAba' => 'Categorias']
    ]"
        :actions="[
        ['classBtn' => 'btn-dark', 'content-id' => 'categorias', 'nomeButton' => 'Criar Categoria'],
        ['classBtn' => 'btn-primary', 'content-id' => 'mys', 'nomeButton' => 'Criar Notícia']
    ]" />


    <!-- Conteúdo das abas -->
    <div class="tab-contents">
        <div class="content-link show" id="all">
            <div class="infos">
                @include('noticias.home')
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