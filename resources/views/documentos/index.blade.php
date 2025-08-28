@extends('layouts.app')

@section('title', 'Biblioteca Digital')

@section('content')

<div class="container-abas w-100" id="abaDocumentos">

    {{ Breadcrumbs::render('documentos')}}

    @php

    $links = [
    ['content-id' => 'visaoDocumentos', 'nomeAba' => 'Visão Geral', 'data-tipo' => 'documentos'],
    ['content-id' => 'myDocumentos', 'nomeAba' => 'Meus documentos', 'data-tipo' => 'documentos']
    ];

    if (Auth::check() && Auth::user()->tipoUsuario != 'comum') {
    $links[] = ['content-id' => 'allDocumentos', 'nomeAba' => 'Gerenciar Documentos', 'data-tipo' => 'documentos'];
    }

    $actions = [
    ['classBtn' => 'btn-primary', 'content-id' => 'myDocumentos', 'nomeButton' => 'Adicionar documento', 'data-url' => '/documentos/create']
    ];

    if (Auth::check() && Auth::user()->tipoUsuario != 'comum') {
    $links[] = ['content-id' => 'categoriasDocumentos', 'nomeAba' => 'Categorias', 'data-tipo' => 'documentos'];
    $actions[] = ['classBtn' => 'btn-dark', 'content-id' => 'categorias', 'nomeButton' => 'Criar Categoria'];
    }

    @endphp

    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Biblioteca Digital</h1>
            <p class="mt-3 ">Acesse, compartilhe e construa juntos um acervo de conhecimento para todos os NAIs.</p>
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
    <div class="tab-contents w-100">
        <div class="content-link" id="visaoDocumentos">
            <div class="infos">
                @include('documentos.init', ['categorias' => $categorias, 'documentos' => $documentos])
            </div>
        </div>
        <div class="content-link" id="myDocumentos">
            <div class="infos">
                @include('documentos.tableDocumentos', ['documentos' => $myDocumentos, 'tipoAba' => 'myDocumentos'])
            </div>
        </div>
        <div class="content-link" id="allDocumentos">
            <div class="infos">
                @include('documentos.tableDocumentos', ['documentos' => $allDocumentos, 'tipoAba' => 'allDocumentos'])
            </div>
        </div>

        <div class="content-link" id="categoriasDocumentos">
            <div class="infos" id="categorias-content">
                @include('layouts.tabelaCategorias', ['categorias' => $categoriasDocumentos, 'tipo' => "documentos"])
            </div>
        </div>

    </div>
</div>

@include('layouts.createCategoria', ['tipo' => "documentos"])
@include('layouts.modalExclusao')

@endsection