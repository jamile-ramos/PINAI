@extends('layouts.app')

@section('title', 'Banco de soluções')

@section('content')

<div class="container-abas" id="abaSolucoes">

    {{Breadcrumbs::render('solucoes')}}

    @php

    $links = [
    ['content-id' => 'visaoSolucoes', 'nomeAba' => 'Visão Geral', 'classActive' => 'active', 'data-tipo' => 'solucoes'],
    ['content-id' => 'mySolucoes', 'nomeAba' => 'Minhas Soluções', 'data-tipo' => 'solucoes']
    ];

    if (Auth::check() && Auth::user()->tipoUsuario != 'comum') {
    $links[] = ['content-id' => 'allSolucoes', 'nomeAba' => 'Gerenciar Solucoes', 'data-tipo' => 'solucoes'];
    }

    $actions = [
    ['classBtn' => 'btn-primary', 'content-id' => 'mySolucoes', 'nomeButton' => 'Adicionar Solução', 'data-url' => '/solucoes/create']
    ];

    if (Auth::check() && Auth::user()->tipoUsuario != 'comum') {
    $links[] = ['content-id' => 'categoriasSolucoes', 'nomeAba' => 'Categorias', 'data-tipo' => 'solucoes'];
    $actions[] = ['classBtn' => 'btn-dark', 'content-id' => 'categorias', 'nomeButton' => 'Criar Categoria'];
    }

    @endphp
    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Banco de soluções</h1>
            <p class="text-secondary mt-3 ">Compartilhe e descubra boas práticas e soluções acessíveis para seu NAI.</p>
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
        <div class="content-link show" id="visaoSolucoes">
            <div class="infos">
                @include('solucoes.init', ['solucoes' => $solucoes])
            </div>
        </div>

        <div class="content-link" id="mySolucoes">
            <div class="infos">
                @include('solucoes.tableSolucoes', ['solucoes' => $mySolucoes, 'tipoAba' => 'mySolucoes'])
            </div>
        </div>

        <div class="content-link" id="allSolucoes">
            <div class="infos">
            @include('solucoes.tableSolucoes', ['solucoes' => $solucoes, 'tipoAba' => 'allSolucoes'])
            </div>
        </div>

        <div class="content-link" id="categoriasSolucoes">
            <div class="infos" id="categorias-content">
                @include('layouts.tabelaCategorias', ['categorias' => $categorias , 'tipo' => 'solucoes'])
            </div>
        </div>

    </div>
</div>

@include('layouts.createCategoria', ['tipo' => "solucoes"])
@include('layouts.modalExclusao')
@endsection