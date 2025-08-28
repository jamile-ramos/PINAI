@extends('layouts.app')

@section('title', 'Fórum de Discurssão')

@section('content')

<div class="container-abas w-100" id="abaTopicos">

    {{ Breadcrumbs::render('topicos') }}

    @php
    $links = [
    ['content-id' => 'visaoTopicos', 'nomeAba' => 'Visão Geral', 'data-tipo' => 'topicos']
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
            <p class="mt-3 ">Converse, colabore e construa soluções inclusivas junto à comunidade.</p>
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
        <div class="content-link" id="visaoTopicos">
            <div class="infos">
                @include('topicos.init', ['topicos' => $topicos])
            </div>
        </div>

        <div class="content-link" id="allTopicos">
            <div class="infos">
                @include('topicos.tableTopicos', ['topicos' => $allTopicos, 'title' => 'Gerenciar Tópicos', 'tipoAba' => 'allTopicos'])
            </div>
        </div>

        <div class="content-link" id="myTopicos">
            <div class="infos">
                @include('topicos.tableTopicos', ['topicos' => $meusTopicos, 'title' => 'Meus Tópicos', 'tipoAba' => 'myTopicos'])
            </div>
        </div>

        <div class="content-link" id="sugestoes">
            <div class="infos" id="categorias-content">
                @include('topicos.tableTopicos', ['topicos' => $topicosSugeridos, 'title' => 'Tópicos Sugeridos', 'tipoAba' => 'sugestoes'])
            </div>
        </div>

    </div>
</div>

@include('topicos.form')
@include('layouts.createCategoria', ['tipo' => "topicos"])
@include('layouts.modalExclusao')
@include('topicos.modalStatusSituacao')

@endsection