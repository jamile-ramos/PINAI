@extends('layouts.app')

@section('title', 'Fórum de Discurssão')

@section('content')

<div class="container-abas" id="abaTopicos">

    {{ Breadcrumbs::render('topicos') }}

    @php
    $links = [
    ['content-id' => 'visaoTopicos', 'nomeAba' => 'Visão Geral', 'classActive' => 'active', 'data-tipo' => 'topicos']
    ];

    if (Auth::check() && Auth::user()->tipoUsuario != 'comum') {
    $links[] = ['content-id' => 'myTopicos', 'nomeAba' => 'Meus tópicos', 'data-tipo' => 'topicos'];
    $links[] = ['content-id' => 'allTopicos', 'nomeAba' => 'Gerenciar tópicos', 'data-tipo' => 'topicos'];
    $links[] = ['content-id' => 'sugestoes', 'nomeAba' => 'Tópicos sugeridos', 'data-tipo' => 'topicos'];
    $actions[] = ['classBtn' => 'btn-dark', 'nomeButton' => 'Criar Tópico', 'data-url' => '/topicos/create'];
    } else {
    $actions[] = ['classBtn' => 'btn-dark', 'nomeButton' => 'Sugerir Tópico', 'data-url' => '/topicos/create'];
    }
    @endphp

    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Fórum de Discussão </h1>
            <p class="text-secondary mt-3 ">Converse, colabore e construa soluções inclusivas junto à comunidade.</p>
        </div>
    </header>

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
        <div class="content-link show" id="visaoTopicos">
            <div class="infos">
                @include('topicos.init', ['topicos' => $topicos])
            </div>
        </div>

        <div class="content-link" id="allTopicos">
            <div class="infos">
                @include('topicos.tableTopicos', ['itens' => $topicos, 'title' => 'Gerenciar Tópicos'])
            </div>
        </div>


        <div class="content-link" id="myTopicos">
            <div class="infos">
                @include('topicos.tableTopicos', ['itens' => $meusTopicos, 'title' => 'Meus Tópicos'])
            </div>
        </div>

        <div class="content-link" id="sugestoes">
            <div class="infos" id="categorias-content">
                @include('topicos.tableTopicos', ['itens' => $topicosSugeridos, 'title' => 'Tópicos Sugeridos'])
            </div>
        </div>

    </div>
</div>

@include('topicos.form')
@include('layouts.createCategoria', ['tipo' => "topicos"])
@include('layouts.modalExclusao')
@include('topicos.modalStatusSituacao')

@endsection