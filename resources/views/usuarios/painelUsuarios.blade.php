@extends('layouts.app')

@section('title', 'Painel de Usuários')

@section('content')

<div class="col-md-12 table-usuarios">
    <div class="bg-light">
        <div class="navbar navbar-light bg-light barra-filtros">
            <div class="filtros">
                <button>Todos</button>
            </div>

            <div class="ml-auto d-flex align-items-center barra-pesquisa">
                <!-- Campo de pesquisa inicialmente escondido -->
                <form action="/pesquisar" method="GET" class="search-form" style="display: none;">
                    <div class="search-container">
                        <i class="fas fa-search mr-2"></i>
                        <input type="text" class="search-input" name="query" placeholder="Pesquisar..." />
                    </div>
                </form>

                <!-- Ícone de pesquisa que ativa a barra de pesquisa -->
                <div class="botao-pesquisar">
                    <!--<button type="button" class="btn btn-secondary btn-add">Secondary</button>-->
                    <a href="javascript:void(0);" class="search-icon"><i class="fas fa-search mr-2"></i></a>
                    <!-- Ícone de X que será exibido quando a barra de pesquisa estiver ativa -->
                    <a href="javascript:void(0);" class="close-search" style="display: none;"><i class="fas fa-times mr-2"></i></a>
                </div>
            </div>
        </div>
    </div>

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
                            <th style="width: 26%">Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Tipo de usuário</th>
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
                            <td>
                                <div class="form-button-action">
                                    <button type="button" class="btn btn-info d-inline">Alterar tipo</button>
                                    <button type="button" class="btn btn-danger">Excluir</button>
                                </div>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->tipoUsuario == 0 ? 'Comum' : 'Admin'}}</td>
                            <td>
                                <div class="form-button-action">
                                    <button
                                        type="button"
                                        class="btn btn-info d-inline"
                                        data-id="{{ $usuario->id }}"
                                        data-name="{{ $usuario->name }}"
                                        data-email="{{ $usuario->email }}"
                                        data-type="{{ $usuario->tipoUsuario }}">
                                        Alterar tipo
                                    </button>
                                    <button type="button" class="btn btn-danger">Excluir</button>
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
                <form id="editUserForm" action="">
                    @csrf
                    @method('put')
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
                        <button type="submit" class="btn btn-primary" id="saveUserChanges">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection