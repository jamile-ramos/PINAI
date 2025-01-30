@extends('layouts.app')

@section('title', 'Painel de Usuários')

@section('content')

<div class="container-abas" id="abaUsuarios">

    <x-barra-filtros
        :links="[
        ['content-id' => 'all-users', 'nomeAba' => 'Todos', 'classActive' => 'active'],   
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
    <div class="tab-contents-users">
        <div class="content-link show" id="all-users">
            @if(session('sucess-status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="sucess-status-alert">
                <strong>{{ session('sucess-status') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Painel de Usuários</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            id="add-row"
                            class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo de usuário</th>
                                    <th>Status</th>
                                    <th>Data de criação</th>
                                    <th style="width: 26%">Ação</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo de usuário</th>
                                    <th>Status</th>
                                    <th>Data de criação</th>
                                    <th>Ação</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                @if ($loop->index % 2 == 0)
                                <tr>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->tipoUsuario == 0 ? 'Comum' : 'Admin'}}</td>
                                    <td>{{ $usuario->status == 0 ? 'Ativo' : 'Inativo'}}</td>
                                    <td>{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button
                                                type="button"
                                                class="btn btn-primary d-inline btn-alterar"
                                                data-id="{{ $usuario->id }}"
                                                data-name="{{ $usuario->name }}"
                                                data-email="{{ $usuario->email }}"
                                                data-type="{{ $usuario->tipoUsuario }}">
                                                Alterar tipo
                                            </button>
                                            <button
                                                type="button"
                                                class="btn toggle-status btn-status {{ $usuario->status == 0 ? 'btn-danger' : 'btn-success' }}"
                                                data-id="{{ $usuario->id }}"
                                                data-status="{{ $usuario->status }}">
                                                {{ $usuario->status == 0 ? 'Desabilitar' : 'Ativar' }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->tipoUsuario == 0 ? 'Comum' : 'Admin'}}</td>
                                    <td>{{ $usuario->status == 0 ? 'Ativo' : 'Inativo'}}</td>
                                    <td>{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button
                                                type="button"
                                                class="btn btn-primary d-inline btn-alterar"
                                                data-id="{{ $usuario->id }}"
                                                data-name="{{ $usuario->name }}"
                                                data-email="{{ $usuario->email }}"
                                                data-type="{{ $usuario->tipoUsuario }}">
                                                Alterar tipo
                                            </button>
                                            <button
                                                type="button"
                                                class="btn toggle-status btn-status {{ $usuario->status == 0 ? 'btn-danger' : 'btn-success' }}"
                                                data-id="{{ $usuario->id }}"
                                                data-status="{{ $usuario->status }}">
                                                {{ $usuario->status == 0 ? 'Desabilitar' : 'Ativar' }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endif

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
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
                            <option value="0">Comum</option>
                            <option value="1">Admin</option>
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