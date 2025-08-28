@extends('layouts.app')

@section('title', 'Painel de Usuários')

@section('content')

<div class="container-abas w-100" id="abaUsuarios">
    {{ Breadcrumbs::render('painelUsuarios') }}
    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Painel de Usuários</h1>
            <p class="mt-3 ">Gerencie e acompanhe os membros dos NAIs com facilidade e transparência.</p>
        </div>
    </header>

    <x-barra-filtros
        :links="[
        ['content-id' => 'all-users', 'nomeAba' => 'Visão Geral'],
        ['content-id' => 'all-nais', 'nomeAba' => 'Núcleos de Acessibilidade e Inclusão']
        ]"
        :actions="[['classBtn' => 'btn-primary', 'content-id' => 'nais', 'nomeButton' => 'Adicionar NAI', 'data-url' => 'painelUsuarios/nais/create']]" />

    @foreach (['success', 'sucess-status'] as $status)
    @if(session($status))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <strong>{{ session($status) }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @endforeach

    @if ($errors->any())
    @foreach ($errors->all() as $message)
    <div class="alert alert-danger alert-dismissible fade show mt-2 mx-3 rounded" role="alert">
        {{ $message }}
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Fechar">
        </button>
    </div>
    @endforeach
    @endif

    <div class="tab-contents-users" role="tabpanel" id="panel-1" aria-labelledby="tab-1" tabindex="0">
        <div class="content-link" id="all-users">
            @include('usuarios.tableUsuarios', ['usuarios' => $usuarios])
        </div>
    </div>

    <div class="tab-contents-users" role="tabpanel" id="panel-2" aria-labelledby="tab-2" tabindex="0">
        <div class="content-link" id="all-nais">
            @include('usuarios.tableNais', ['nais' => $nais])
        </div>
    </div>

</div>

@include('layouts.modalExclusao')

@endsection