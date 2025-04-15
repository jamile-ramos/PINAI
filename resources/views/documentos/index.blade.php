@extends('layouts.app')

@section('title', 'Biblioteca Digital')

@section('content')

<div class="container-abas" id="abaDocumentos">

    @php

    $links = [
    ['content-id' => 'visaoDocumentos', 'nomeAba' => 'Visão Geral', 'classActive' => 'active', 'data-tipo' => 'documentos'],
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
        <div class="content-link show" id="visaoDocumentos">
            <div class="infos">
               @include('documentos.init', ['categorias' => $categorias])
            </div>
        </div>
        <div class="content-link" id="myDocumentos">
            <div class="infos">
            @include('documentos.tableDocumentos', ['documentos' => $myDocumentos])
            </div>
        </div>
        <div class="content-link" id="allDocumentos">
            <div class="infos">
            @include('documentos.tableDocumentos', ['documentos' => $documentos])
            </div>
        </div>

        <div class="content-link" id="categoriasDocumentos">
            <div class="infos" id="categorias-content">
            @include('layouts.tabelaCategorias', ['categorias' => $categorias, 'tipo' => "documentos"])
            </div>
        </div>

    </div>
</div>

@include('layouts.createCategoria', ['tipo' => "documentos"])
@include('layouts.modalExclusao')

@endsection