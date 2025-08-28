@extends('layouts.app')

@section('title', 'Fórum de Discurssão')

@section('content')

<div class="container-abas w-100" id="abaPostagens">

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
            <p class="mt-3 ">Converse, colabore e construa soluções inclusivas junto à comunidade.</p>
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
    <div class="tab-contents w-100">
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

        <div class="content-link w-100" id="myPostagens">
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