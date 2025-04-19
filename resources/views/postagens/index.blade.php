@extends('layouts.app')

@section('title', 'Fórum de Discurssão')

@section('content')

<div class="container-abas" id="abaPostagens">

    @php
    $links = [
    ['content-id' => 'visaoPostagens', 'nomeAba' => 'Visão Geral', 'classActive' => 'active', 'data-tipo' => 'postagens'],
    ['content-id' => 'myPostagens','nomeAba' => 'Minhas Postagens','data-tipo' => 'postagens']
    ];

    if(Auth::check() && Auth::user()->tipoUsuario != 'comum'){
    $links[] = ['content-id' => 'allPostagens', 'nomeAba' => 'Gerenciar Postagens', 'data-tipo' => 'postagens'];
    }

    @endphp
    
    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Fórum de Discussão  </h1>
            <p class="fs-4 text-secondary mt-3 ">Converse, colabore e construa soluções inclusivas junto à comunidade.</p>
        </div>
    </header>

    <x-barra-filtros
        :links="$links"
        :actions="[
         ['classBtn' => 'btn-primary', 'nomeButton' => 'Criar Postagem', 'data-url' => url('/postagens/create/' . $topico->id)],
    ]" />

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
        <div class="content-link show" id="visaoPostagens">
            <div class="infos">
                @include('postagens.init', ['postagens' => $postagens])
            </div>
        </div>

        <div class="content-link" id="allPostagens">
            <div class="infos">
                @include('postagens.tablePostagens', ['itens' => $postagens, 'tipoAba' => 'allPostagens'])
            </div>
        </div>

        <div class="content-link" id="myPostagens">
            <div class="infos">
                @include('postagens.tablePostagens', ['itens' => $minhasPostagens, 'tipoAba' => 'myPostagens'])
            </div>
        </div>
    </div>
</div>

@include('topicos.form')
@include('layouts.createCategoria', ['tipo' => "topicos"])
@include('layouts.modalExclusao')
@include('topicos.modalStatusSituacao')

@endsection