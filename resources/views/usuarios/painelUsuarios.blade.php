@extends('layouts.app')

@section('title', 'Painel de Usuários')

@section('content')

<div class="col-md-12 table-usuarios">
    <div class="bg-light">
        <div class="navbar navbar-light bg-light barra-pesquisa">
            <div class="filtros">
                <button>Todos</button>
            </div>
            <div class="ml-auto d-flex align-items-center add-pesquisa">
                <button type="button" class="btn btn-secondary">Secondary</button>
                <div class="botao-pesquisar">
                    <a href=""><i class="fas fa-search mr-2"></i></a>
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
            <!-- Modal -->
            <div
                class="modal fade"
                id="addRowModal"
                tabindex="-1"
                role="dialog"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">
                                <span class="fw-mediumbold"> New</span>
                                <span class="fw-light"> Row </span>
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="small">
                                Create a new row using this form, make sure you
                                fill them all
                            </p>
                            <form>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Name</label>
                                            <input
                                                id="addName"
                                                type="text"
                                                class="form-control"
                                                placeholder="fill name" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 pe-0">
                                        <div class="form-group form-group-default">
                                            <label>Position</label>
                                            <input
                                                id="addPosition"
                                                type="text"
                                                class="form-control"
                                                placeholder="fill position" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Office</label>
                                            <input
                                                id="addOffice"
                                                type="text"
                                                class="form-control"
                                                placeholder="fill office" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer border-0">
                            <button
                                type="button"
                                id="addRowButton"
                                class="btn btn-primary">
                                Add
                            </button>
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

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
                                    <button type="button" class="btn btn-info d-inline">Alterar tipo</button>
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

@endsection