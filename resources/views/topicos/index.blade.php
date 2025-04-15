@extends('layouts.app')

@section('title', 'Fórum de Discurssão')

@section('content')

<div class="container-abas" id="abaTopicos">

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