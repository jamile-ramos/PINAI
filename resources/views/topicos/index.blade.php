@extends('layouts.app')

@section('title', 'Fórum de Discurssão')

@section('content')

<div class="container-abas" id="abaTopicos">

    <x-barra-filtros
        :links="[
        ['content-id' => 'allTopicos', 'nomeAba' => 'Todos', 'classActive' => 'active', 'data-tipo' => 'topicos'],
        ['content-id' => 'sugestoes', 'nomeAba' => 'Tópicos sugeridos', 'data-tipo' => 'topicos']
    ]"
        :actions="[
        ['classBtn' => 'btn-primary', 'content-id' => 'mysTopicos', 'nomeButton' => 'Criar Tópico', 'data-url' => '/topicos/create'],
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
        <div class="content-link show" id="allTopicos">
            <div class="infos">
            @include('topicos.init')
            </div>
        </div>

        <div class="content-link" id="mysTopicos">
            <div class="infos">
               
            </div>
        </div>

        <div class="content-link" id="sugestoes">
            <div class="infos" id="categorias-content">
                Teste4
            </div>
        </div>

    </div>
</div>

@include('layouts.createCategoria', ['tipo' => "topicos"])
@include('layouts.modalExclusao')

@endsection