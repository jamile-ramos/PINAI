@extends('layouts.app')

@section('title', 'Fórum de Discurssão')

@section('content')

<div class="container-abas" id="abaPostagens">

    <x-barra-filtros
        :links="[
        ['content-id' => 'allPostagens', 'nomeAba' => 'Todos', 'classActive' => 'active', 'data-tipo' => 'postagens'],
        ['content-id' => 'myPostagens', 'nomeAba' => 'Minhas Postagens', 'data-tipo' => 'postagens']
    ]"
        :actions="[
        ['classBtn' => 'btn-primary', 'nomeButton' => 'Criar Postagem', 'data-url' => '/postagens/create'],
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
        <div class="content-link show" id="allPostagens">
            <div class="infos">
            @include('postagens.init', ['postagens' => $postagens])
            </div>
        </div>

        <div class="content-link" id="myPostagens">
            <div class="infos">
           @include('postagens.minhasPostagens', ['itens' => $minhasPostagens])
            </div>
        </div>

    </div>
</div>

@include('topicos.form')
@include('layouts.createCategoria', ['tipo' => "topicos"])
@include('layouts.modalExclusao')
@include('topicos.modalStatus')

@endsection