@extends('layouts.app')

@section('title', 'Fórum de Discurssão')

@section('content')

<div class="container-abas" id="abaTopicos">

@php
    $links = [
        ['content-id' => 'allTopicos', 'nomeAba' => 'Todos', 'classActive' => 'active', 'data-tipo' => 'topicos']
    ];

    $actions = [
        ['classBtn' => 'btn-primary', 'nomeButton' => 'Criar Postagem', 'data-url' => '/postagens/create']
    ];

    if (Auth::check() && Auth::user()->tipoUsuario == 1) {
        $links[] = ['content-id' => 'myTopicos', 'nomeAba' => 'Meus tópicos', 'data-tipo' => 'topicos'];
        $links[] = ['content-id' => 'sugestoes', 'nomeAba' => 'Tópicos sugeridos', 'data-tipo' => 'topicos'];
        $links[] = ['content-id' => 'myPostagens', 'nomeAba' => 'Minhas Postagens', 'data-tipo' => 'postagens'];  // Mover para depois dos tópicos
        $actions[] = ['classBtn' => 'btn-dark', 'nomeButton' => 'Criar Tópico', 'data-url' => '/topicos/create'];
    } else {    
        $actions[] = ['classBtn' => 'btn-dark', 'nomeButton' => 'Sugerir Tópico', 'data-url' => '/topicos/create'];
        $links[] = ['content-id' => 'myPostagens', 'nomeAba' => 'Minhas Postagens', 'data-tipo' => 'postagens'];  // Para o caso de usuários não autenticados
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
        <div class="content-link show" id="allTopicos">
            <div class="infos">
                @include('topicos.init', ['topicos' => $topicos])
            </div>
        </div>

        <div class="content-link" id="myTopicos">
            <div class="infos">
                @include('topicos.meusTopicos', ['itens' => $meusTopicos, 'title' => 'Meus Tópicos'])
            </div>
        </div>

        <div class="content-link" id="myPostagens">
            <div class="infos">
                @include('postagens.minhasPostagens', ['itens' => $minhasPostagens])
            </div>
        </div>

        <div class="content-link" id="sugestoes">
            <div class="infos" id="categorias-content">
                @include('topicos.meusTopicos', ['itens' => $topicosSugeridos, 'title' => 'Tópicos Sugeridos'])
            </div>
        </div>

    </div>
</div>

@include('topicos.form')
@include('layouts.createCategoria', ['tipo' => "topicos"])
@include('layouts.modalExclusao')
@include('topicos.modalStatus')

@endsection