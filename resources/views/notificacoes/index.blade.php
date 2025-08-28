@extends('layouts.app')

@section('title', 'Notificações')

@section('content')

<div class="container-abas w-100" id="abaNotificacoes">
    {{ Breadcrumbs::render('notificacoes') }}

    @php
    $links = [
    ['content-id' => 'visaoNotificacoes', 'nomeAba' => 'Todas', 'data-tipo' => 'notificacoes'],
    ['content-id' => 'lidas','nomeAba' => 'Lidas','data-tipo' => 'lidas'],
    ['content-id' => 'naoLidas','nomeAba' => 'Não Lidas','data-tipo' => 'naoLidas']
    ];
    @endphp

    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Notificações </h1>
            <p class="mt-3 ">Converse, colabore e construa soluções inclusivas junto à comunidade.</p>
        </div>
    </header>

    <x-barra-filtros
        :links="$links" />

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
        <div class="content-link" id="visaoNotificacoes">
            <div class="infos">
                @include('notificacoes.tableNotificacoes', ['notificacoes' => $notificacoes])
            </div>
        </div>

        <div class="content-link" id="lidas">
            <div class="infos">
                @include('notificacoes.tableNotificacoes', ['notificacoes' => $lidas])
            </div>
        </div>

        <div class="content-link w-100" id="naoLidas">
            <div class="infos">
                @include('notificacoes.tableNotificacoes', ['notificacoes' => $naoLidas])
            </div>
        </div>
    </div>
</div>

@include('topicos.form')
@include('layouts.createCategoria', ['tipo' => "topicos"])
@include('layouts.modalExclusao')
@include('topicos.modalStatusSituacao')

@endsection