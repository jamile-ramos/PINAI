@extends('layouts.app')

@section('title', 'Painel de Usuários')

@section('content')

<div class="container-abas" id="abaUsuarios">
    {{ Breadcrumbs::render('painelUsuarios') }}
    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Painel de Usuários</h1>
            <p class="text-secondary mt-3 ">Gerencie e acompanhe os membros dos NAIs com facilidade e transparência.</p>
        </div>
    </header>

    <x-barra-filtros
        :links="[
        ['content-id' => 'all-users', 'nomeAba' => 'Visão Geral', 'classActive' => 'active'],
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

    <div class="tab-contents-users" role="tabpanel" id="panel-1" aria-labelledby="tab-1" tabindex="0">
        <div class="content-link show" id="all-users">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="forum-azul">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>NAI</th>
                            <th>Tipo de usuário</th>
                            <th>Status</th>
                            <th>Data de criação</th>
                            <th style="width: 10%">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->nai?->siglaNai ?? 'Não selecionado' }}</td>
                            <td>@if ($usuario->tipoUsuario == 'comum')
                                Comum
                                @elseif ($usuario->tipoUsuario == 'admin')
                                Admin
                                @elseif ($usuario->tipoUsuario == 'moderador')
                                Moderador
                                @endif
                            </td>
                            <td>{{ $usuario->status == 'ativo' ? 'Ativo' : 'Inativo' }}</td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="form-button-action">
                                    <button type="button" class="btn btn-info d-inline btn-alterar"
                                        data-id="{{ $usuario->id }}"
                                        data-name="{{ $usuario->name }}"
                                        data-email="{{ $usuario->email }}"
                                        data-type="{{ $usuario->tipoUsuario }}"
                                        data-nai="{{ $usuario->nai?->id ?? 'selecione'  }}"
                                        aria-label="Editar Usuário">
                                        Editar
                                    </button>
                                    <button type="button" class="btn toggle-status btn-status {{ $usuario->status == 'ativo' ? 'btn-danger' : 'btn-success' }}"
                                        data-id="{{ $usuario->id }}"
                                        data-status="{{ $usuario->status }}"
                                        aria-label="{{ $usuario->status == 'ativo' ? 'Desabilitar' : 'Ativar' }} usuário">
                                        {{ $usuario->status == 'ativo' ? 'Desabilitar' : 'Ativar' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-contents-users" role="tabpanel" id="panel-1" aria-labelledby="tab-1" tabindex="0">
        <div class="content-link" id="all-nais">
            @include('usuarios.tableNais', ['nais' => $nais])
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Editar</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST" data-route="{{ route('painel.update', ':id') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="userId" name="userId">
                    <div class="form-group">
                        <label for="userName">Nome</label>
                        <input type="text" class="form-control" id="userName" name="userName">
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail">
                    </div>
                    <div class="form-group">
                        <label for="userNai">Núcleo de Acessibilidade e Inclusão (NAI)</label>
                        <select class="form-control" id="userNai" name="userNai">
                            <option value="selecione" selected disabled>Selecione um NAI...</option>
                            @foreach($nais as $nai)
                            <option value="{{ $nai->id }}">{{ $nai->siglaNai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userType">Tipo de Usuário</label>
                        <select class="form-control" id="userType" name="tipoUsuario">
                            <option value="comum">Comum</option>
                            <option value="admin">Admin</option>
                            <option value="moderador">Moderador</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Ativação/Desativação -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="confirmModalLabel">Confirmar Ação</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body body-confirmar">
                <div class="texto-confirmar">
                    <p>Tem certeza de que deseja desativar este usuário?</p>
                </div>
                <!-- Formulário para desativar o usuário -->
                <form id="confirmForm" data-route="{{ route('painel.updateStatus', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="status">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="confirmActionBtn" class="btn">Desabilitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('layouts.modalExclusao')

@endsection