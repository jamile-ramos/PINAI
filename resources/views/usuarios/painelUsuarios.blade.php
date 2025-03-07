@extends('layouts.app')

@section('title', 'Painel de Usuários')

@section('content')

<div class="container-abas" id="abaUsuarios">
    <x-barra-filtros :links="[['content-id' => 'all-users', 'nomeAba' => 'Todos', 'classActive' => 'active']]" />

    @foreach (['success', 'sucess-status'] as $status)
    @if(session($status))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="{{ $status }}-alert">
        <strong>{{ session($status) }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @endforeach

    <div class="tab-contents-users">
        <div class="content-link show" id="all-users">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="forum-azul">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
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
                            <td>{{ $usuario->tipoUsuario == 'comum' ? 'Comum' : 'Admin' }}</td>
                            <td>{{ $usuario->status == 'ativo' ? 'Ativo' : 'Inativo' }}</td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="form-button-action">
                                    <button type="button" class="btn btn-info d-inline btn-alterar"
                                        data-id="{{ $usuario->id }}"
                                        data-name="{{ $usuario->name }}"
                                        data-email="{{ $usuario->email }}"
                                        data-type="{{ $usuario->tipoUsuario }}">
                                        Alterar tipo
                                    </button>
                                    <button type="button" class="btn toggle-status btn-status {{ $usuario->status == 'ativo' ? 'btn-danger' : 'btn-success' }}"
                                        data-id="{{ $usuario->id }}"
                                        data-status="{{ $usuario->status }}">
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
</div>

<!-- Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Tipo de Usuário</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                        <input type="text" class="form-control" id="userName" readonly>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="userEmail" readonly>
                    </div>
                    <div class="form-group">
                        <label for="userType">Tipo de Usuário</label>
                        <select class="form-control" id="userType" name="tipoUsuario">
                            <option value="comum">Comum</option>
                            <option value="admin">Admin</option>
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
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Ação</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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

@endsection