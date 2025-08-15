@extends('layouts.app')

@section('title', 'Fórum de Discurssão')

@section('content')

<div class="container-abas" id="abaPostagens">

    {{ Breadcrumbs::render('postagens', $topico) }}
    @php
    $links = [
    ['content-id' => 'visaoPostagens', 'nomeAba' => 'Visão Geral', 'data-tipo' => 'postagens'],
    ['content-id' => 'myPostagens','nomeAba' => 'Minhas Postagens','data-tipo' => 'postagens']
    ];

    if(Auth::check() && Auth::user()->tipoUsuario != 'comum'){
    $links[] = ['content-id' => 'allPostagens', 'nomeAba' => 'Gerenciar Postagens', 'data-tipo' => 'postagens'];
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
        :actions="[
         ['classBtn' => 'btn-primary', 'nomeButton' => 'Criar Postagem', 'data-url' => url('/postagens/create/' . $topico->id)],
    ]" />

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <!-- Conteúdo das abas -->
    <div class="tab-contents">
        <div class="content-link" id="visaoPostagens">
            <div class="infos">
                @include('postagens.init', ['postagens' => $postagens, 'topico' => $topico])
            </div>
        </div>

        <div class="content-link" id="allPostagens">
            <div class="infos">
                @include('postagens.tablePostagens', ['postagens' => $allPostagens, 'topico' => $topico, 'tipoAba' => 'allPostagens'])
            </div>
        </div>

        <div class="content-link" id="myPostagens">
            <div class="infos">
                @include('postagens.tablePostagens', ['postagens' => $minhasPostagens, 'tipoAba' => 'myPostagens'])
            </div>
        </div>
    </div>
</div>

@include('topicos.form')
@include('layouts.createCategoria', ['tipo' => "topicos"])
@include('layouts.modalExclusao')
@include('topicos.modalStatusSituacao')

@endsection